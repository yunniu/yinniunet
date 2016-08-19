<?php
namespace Home\Controller;

class CartController extends BaseController {

    public function __construct(){
        parent::__construct();
        $agent_code = session('agent_code');
        if(empty(session('user_id'))){
            if(ACTION_NAME == 'index'){
                $this->error("请先登录",U('index/index',"agent_id=$agent_code"));
                exit;
            }else{
                $msg['code'] = 0;
                $msg['msg'] = "请先登录";
                exit(json_encode($msg));
            }
        }
    }

    public function index(){
        $user_id = session("user_id");
        //获取购物车的内容
        $cartModel = D('cart');
        $cartList = $cartModel->where("user_id = $user_id")->select();
        $cart_amount = 0;
        $goodsModel = D('goods');
        foreach($cartList as $k => $v){
            $goods_id = $v['goods_id'];
            $goods = $goodsModel->where("goods_id = $goods_id")->select()[0];
            $cartList[$k]['goods_img'] = $goods['original_img'];

            $goods_amount = $v['goods_price'] * $v['goods_num'];
            $cartList[$k]['goods_amount'] = number_format($goods_amount,'2');
            $cart_amount += $goods_amount;
        }
        $cart_amount = number_format($cart_amount,'2');
        $this->assign('cart_amount',$cart_amount);
        $this->assign('cartList',$cartList);
        //var_dump($cartList);
        $this->display();
    }

    public function addToCart($goods_id){
        $goods_num = I('get.goods_num') ? I('get.goods_num') : 1;

        //获取用户id,商品id，商品货号，商品名称，市场价，本店价，商品数量
        $user_id= session('user_id');
        $data['user_id'] = session('user_id');
        $data['goods_id'] = $goods_id;

        $cartModel = D('cart');
        $cart_info = $cartModel->where($data)->select()[0];
        //var_dump($cart_info);
        if($cart_info){
            $data['goods_num'] = $goods_num;
            $condition['id'] = $cart_info['id'];
            $cartModel->where($condition)->data($data)->save();
            $result = 1;
        }else{
            $goodsModel = D('goods');
            $goods = $goodsModel->where("goods_id = $goods_id")->select()[0];
            $data['goods_sn'] = $goods['goods_sn'];
            $data['goods_name'] = $goods['goods_name'];
            $data['market_price'] = $goods['market_price'];
            $data['goods_price'] = $goods['shop_price'];
            $data['goods_num'] = $goods_num;

            $result = $cartModel->data($data)->add();
        }

        $cart_num = $cartModel->where("user_id = $user_id")->count();

        if($result){
            $msg['code'] = 1;
            $msg['msg'] = "添加成功";
            $msg['cart_num'] = $cart_num;
            exit(json_encode($msg));
        }else{
            $msg['code'] = 0;
            $msg['msg'] = "添加失败";
            $msg['cart_num'] = $cart_num;
            exit(json_encode($msg));
        }
    }

    public function delCart($goods_id){
        //获取用户id,商品id
        $user_id= session('user_id');
        $data['user_id'] = session('user_id');
        $data['goods_id'] = $goods_id;

        $cartModel = D('cart');
        $result = $cartModel->where($data)->delete();
        $cart_num = $cartModel->where("user_id = $user_id")->count();

        if($result){
            $msg['code'] = 1;
            $msg['msg'] = "删除成功";
            $msg['cart_num'] = $cart_num;
            exit(json_encode($msg));
        }else{
            $msg['code'] = 0;
            $msg['msg'] = "删除失败";
            $msg['cart_num'] = $cart_num;
            exit(json_encode($msg));
        }
    }

    public function changeGoodsNum(){
        if($_POST){
            $operator = I('post.operator');

            $condition['user_id'] = session('user_id');
            $condition['goods_id'] =I('post.goods_id');

            $cartModel = D('cart');
            $goods_num = $cartModel->field('goods_num')->where($condition)->select()[0]['goods_num'];

            if($operator == '-'){
                $goods_num = $goods_num - 1;
            }else if($operator == '+'){
                $goods_num = $goods_num + 1;
            }
            if($goods_num < 1){
                $msg['code'] = 0;
                $msg['msg'] = "商品数量不能少于1";
                exit(json_encode($msg));;
            }

            $data['goods_num'] = $goods_num;
            $result = $cartModel->where($condition)->data($data)->save();

            if($result){
                $data = $cartModel->where($condition)->select()[0];
                $data['amount'] = number_format($data['goods_price'] * $data['goods_num'],'2');

                $cartList = $cartModel->select();
                $cart_amount = 0;
                foreach($cartList as $k => $v){
                    $goods_amount = $v['goods_price'] * $v['goods_num'];
                    $cartList[$k]['goods_amount'] = number_format($goods_amount,'2');
                    $cart_amount += $goods_amount;
                }
                $data['all_mount'] = number_format($cart_amount,'2');
                $msg['code'] = 1;
                $msg['msg'] = "成功";
                $msg['data'] = $data;
                exit(json_encode($msg));
            }else{
                $msg['code'] = 0;
                $msg['msg'] = "失败";
                exit(json_encode($msg));
            }
        }
    }

    public function isLogin(){
        if(session('user_id')){
            $msg['code'] = 1;
            $msg['msg'] = "成功";
            exit(json_encode($msg));
        }else{
            $msg['code'] = 0;
            $msg['msg'] = "失败";
            exit(json_encode($msg));
        }
    }
}