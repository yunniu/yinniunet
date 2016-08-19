<?php
/**
 * Created by PhpStorm.
 * User: my_pc
 * Date: 2016/8/12
 * Time: 9:13
 */

namespace Home\Controller;
use Think\Controller;

class BaseController extends Controller
{
    function _initialize(){

        //获取url中的代理商id,与数据库中的代理商id做对比，有则跳转，没有则提示不存在
        $agent_id = I('get.agent_id');
        if(!empty($agent_id)){
            $agentModel = D('proxys');
            $data['code'] = $agent_id;
            $result = $agentModel->field("id")->where($data)->select();
            session('agent_code',$agent_id);
            //var_dump($result);
            if(!$result){
                $this->error("请检查url是否正确",U('Public/error'));
            }

        }else{
            $this->error("请检查url是否正确",U('Public/error'));
        }

        if(session('user_id')){
            $user_id = session('user_id');
            $cartModel = D('cart');
            $cart_num = $cartModel->where("user_id = $user_id")->count();
            $this->assign('cart_num',$cart_num);
        }

        //获取logo
        $configModel = D('config');
        $configList = $configModel->select();
        $shop_info = array();
        foreach($configList as $k => $v){
            if($v['inc_type'] == 'shop_info'){
                $shop_info[$v['name']] = $v['value'];
            }
        }
        $this->assign('shop_info',$shop_info);

        //获取首页商品顶级分类
        $categoryList = $this->getTopCategory();
        if($categoryList){
            $this->assign('categoryList',$categoryList);
        }

        //获取底部文字广告内容
        $articleModel = D('article');
        $article = $articleModel->where('is_open = 1')->select()[0];
        $this->assign('article',$article);
    }

    //获取首页商品顶级且为推荐的分类
    public function getTopCategory(){
        $categoryModel = D('goods_category');
        $categoryList = $categoryModel->where("level = 1 and is_hot = 1")->select();
//        var_dump($categoryList);
        if($categoryList){
            return $categoryList;
        }else{
            return false;
        }
    }
}