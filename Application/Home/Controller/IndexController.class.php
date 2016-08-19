<?php
namespace Home\Controller;
use Home\Controller;

class IndexController extends BaseController
{

    //商城首页展示
    public function index(){
        //获取首页轮播图广告图。
        $adModel = D('ad');
        $adList = $adModel->where('pid = 10')->select();
        //var_dump($adList);
        $this->assign('adList',$adList);

        //获取推荐商品
        $recommendGoodsList = $this->getRecommendGoods();
        if($recommendGoodsList){
            $this->assign('recommendGoodsList',$recommendGoodsList);
        }

        //获取热销商品
        $hotGoodsList = $this->getHotGoods();
        if($hotGoodsList){
            $this->assign('hotGoodsList',$hotGoodsList);
        }
        $this->display();
    }

    //获取推荐商品
    public function getRecommendGoods(){
        $goodsModel = D('goods');
        $condition['is_recommend'] = 1;
        $condition['is_on_sale'] = 1;
        $recommendGoodsList = $goodsModel->where($condition)->select();

        if($recommendGoodsList){
            //var_dump($recommendGoodsList);
            return $recommendGoodsList;
        }else{
            return false;
        }
    }

    //获取热销的商品
    public function getHotGoods(){
        $goodsModel = D('goods');
        $condition['is_hot'] = 1;
        $condition['is_on_sale'] = 1;
        $hotGoodsList = $goodsModel->where($condition)->select();

        if($hotGoodsList){
            //var_dump($recommendGoodsList);
            return $hotGoodsList;
        }else{
            return false;
        }
    }

    //ajax获取更多推荐商品
    public function ajaxGetRecommendGoods(){
        $goodsModel = D('goods');
        $condition['is_recommend'] = 1;
        $condition['is_on_sale'] = 1;
        $recommendGoodsList = $goodsModel->where($condition)->select();
        //var_dump($ajaxGoodsList);
        if($recommendGoodsList){
            $data['code'] = 1;
            $data['msg'] = '获取更多推荐商品成功';
            $data['data'] = $recommendGoodsList;
            exit(json_encode($data));
        }else{
            $data['code'] = 0;
            $data['msg'] = '获取更多推荐商品失败';
            exit(json_encode($data));
        }
    }

    //ajax获取更多的热销商品
    public function ajaxGetHotGoods(){
        $goodsModel = D('goods');
        $condition['is_hot'] = 1;
        $condition['is_on_sale'] = 1;
        $hotGoodsList = $goodsModel->where($condition)->select();

        if($hotGoodsList){
            $data['code'] = 1;
            $data['msg'] = '获取热销产品成功';
            $data['data'] = $hotGoodsList;

            exit(json_encode($data));
        }else{
            $data['code'] = 0;
            $data['msg'] = '获取失败';

            exit(json_encode($data));
        }
    }
}