<?php
/**
 * Created by PhpStorm.
 * User: my_pc
 * Date: 2016/8/17
 * Time: 10:30
 */

namespace Home\Controller;

class OrderController extends BaseController
{
    public function __construct(){
        parent::__construct();
        if(empty(session('user_id'))){
            $msg['code'] = 0;
            $msg['msg'] = "请先登录";
            exit(json_encode($msg));
        }
    }

    //立即购买
    public function promptlyBuy(){
        //获取代理商id
        $agent_code = I('get.agent_id');
        $data3['code'] = $agent_code;
        $proxys_id = D('proxys')->field('id')->where($data3)->select()[0]['id'];
        //获取用户id,商品id,商品数量
        $goods_id = I('get.goods_id');
        $goods_num = I('get.goods_num');
        $user_id = session('user_id');

        //获取商品信息
        $goodsModel = D('goods');
        $condition['goods_id'] = $goods_id;
        $goods = $goodsModel->where($condition)->select()[0];
        //var_dump($goods);


        //初步生成订单
        $orderModel = D('order');
        $orderModel->startTrans();
        $data['user_id'] = $user_id;
        $data['order_status'] = 0;
        $data['shipping_status'] = 0;
        $data['pay_status'] = 0;
        $data['add_time'] = time();
        $data['proxys_id'] = $proxys_id;
        $data['goods_price'] =$goods['shop_price'] * $goods_num;
        $data['total_amount'] = $goods['shop_price'] * $goods_num;//总金额还要算上运费，现在暂时没有
//        var_dump($data);
//        exit;

        $order_id = $orderModel->data($data)->add();

        $order_goods_model = D('order_goods');
        $og_data['order_id'] = $order_id;
        $og_data['goods_id'] = $goods['goods_id'];
        $og_data['goods_sn'] = $goods['goods_sn'];
        $og_data['goods_name'] = $goods['goods_name'];
        $og_data['market_price'] = $goods['market_price'];
        $og_data['goods_price'] = $goods['shop_price'];
        $og_data['goods_price'] = $goods['shop_price'];
        $og_data['goods_num'] = $goods_num;
        $result = $order_goods_model->data($og_data)->add();
//        var_dump($order_id);
        if($order_id && $result){
            $code = str_pad($order_id,6,0,STR_PAD_LEFT);
            $data2['order_sn'] = date("Ymd",time()).$code;
            $num = $orderModel->where("order_id = $order_id")->data($data2)->save();
            //var_dump($result);
            $orderModel->commit();
            if($num !== false){
                $msg['code'] = 1;
                $msg['msg'] = "成功";
                exit(json_encode($msg));
            }else{
                $msg['code'] = 0;
                $msg['msg'] = "失败";
                exit(json_encode($msg));
            }
        }else{
            $orderModel->rollback();
        }
    }

    //购物车结算
    public function balance(){
        $user_id = session('user_id');

        //var_dump($user_id);
        $data['user_id'] = $user_id;
        $cartModel = D('cart');
        $cartList = $cartModel->where($data)->select();
        if(empty($cartList)){
            $msg['code'] = 0;
            $msg['msg'] = "购物车为空";
            exit(json_encode($msg));
        }
//        var_dump($cartList);

        //获取代理商id
        $agent_code = I('get.agent_id');
        $data3['code'] = $agent_code;
        $proxys_id = D('proxys')->field('id')->where($data3)->select()[0]['id'];

        $orderModel = D('order');
        $data['user_id'] = $user_id;
        $data['order_status'] = 0;
        $data['shipping_status'] = 0;
        $data['pay_status'] = 0;
        $data['add_time'] = time();
        $data['proxys_id'] = $proxys_id;
        $data['goods_price'] = 0;
        $data['total_amount'] = 0;

        foreach($cartList as $k => $v){
            $data['goods_price'] += $v['goods_price'] * $v['goods_num'];
        }

        //$data['goods_price'] = $data['goods_price'];
        $data['total_amount'] = $data['goods_price']; //后续可能要计算运费

//        var_dump($data);
        $orderModel->startTrans();
        $order_id = $orderModel->data($data)->add();

        if($order_id){
            //生成订单号，并添加到订单
            $code = str_pad($order_id,6,0,STR_PAD_LEFT);
            $data2['order_sn'] = date("Ymd",time()).$code;
            $num = $orderModel->where("order_id = $order_id")->data($data2)->save();

            //循环$cartList获取用户每条购物车的记录中的商品id,利用商品id获取商品信息，添加到order_goods数据表
            $order_goods_model = D('order_goods');
            $goodsModel = D('goods');
            $order_goods_model->startTrans();//开启事务
            foreach($cartList as $key => $val){
                $g_data['goods_id'] = $val['goods_id'];
                $goods = $goodsModel->where($g_data)->select()[0];
                $og_data['order_id'] = $order_id;
                $og_data['goods_id'] = $goods['goods_id'];
                $og_data['goods_sn'] = $goods['goods_sn'];
                $og_data['goods_name'] = $goods['goods_name'];
                $og_data['market_price'] = $goods['market_price'];
                $og_data['goods_price'] = $goods['shop_price'];
                $og_data['goods_price'] = $goods['shop_price'];
                $og_data['goods_num'] = $val['goods_num'];
                $result = $order_goods_model->data($og_data)->add();
                if(!$result){
                    $orderModel->rollback();//事务回滚，当有一条记录出错的时候。
                    //返回消息
                    $msg['code'] = 0;
                    $msg['msg'] = "失败";
                    exit(json_encode($msg));
                }else{
                    //删除购物车的记录
                    $g_condition['goods_id'] = $goods['goods_id'];
                    $g_condition['user_id'] = $user_id;
                    $cartModel->where($g_condition)->delete();
                    //echo 11122;
                }
            }
            $orderModel->commit();
            //返回消息
            $msg['code'] = 1;
            $msg['msg'] = "成功";
            exit(json_encode($msg));
        }
    }
}