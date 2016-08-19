<?php
namespace Home\Controller;
use Home\Controller;

class GoodsController extends BaseController
{
    public function index($cate_id){//$cate_id 通过get方式传过来的商品分类id
//        //判断传过来的分类id是否为最顶层，不是则为其赋值为最顶层。
//        $cateModel = D('goods_category');

        //获取header分类信息
        $cateList = $this->getTopCategory();
        if($cateList){
            $this->assign('cateList',$cateList);
        }

        //获取本分类页面的子分类
        $childCateList = $this->getChildCate($cate_id);
        if($childCateList){
            $this->assign('childCateList',$childCateList);
        }

        //获取商品，按添加时间排行
        $newGoodsList = $this->getGoodsOrderByTime();
        if($newGoodsList){
            $this->assign('newGoodsList',$newGoodsList);
        }

        $this->display();
    }

    //获取推荐的5个顶级分类
    public function getTopCategory(){
        $cateModel = D('goods_category');
        $cateList = $cateModel->where("level = 1 and is_hot = 1")->select();

        if($cateList){
            return $cateList;
        }else{
            return false;
        }
    }

    //获取商品分类的下级分类
    public function getChildCate($cate_id){
        $cateModel = D('goods_category');
        $childCateList = $cateModel->where("parent_id = $cate_id")->select();

        if($childCateList){
            return $childCateList;
        }else{
            return false;
        }
    }

    //获取热门的商品
    public function getHotGoods(){
        //获取热销商品的条件
        $condition['cat_id'] = I('get.cate_id');
        //var_dump($condition);
        $condition['is_hot'] = 1;

        //获取商品
        $goodsModel = D('goods');
        $hotGoodsList = $goodsModel->where($condition)->select();

        if($hotGoodsList){
            //var_dump($hotGoodsList);
            return $hotGoodsList;
        }else{
            return false;
        }
    }

    //获取某一分类商品，根据添加时间（最新）排序
    public function getGoodsOrderByTime(){
        //条件
        $condition['cat_id'] = I('get.cate_id');
        $condition['is_on_sale'] = 1;

        //获取最新商品
        $goodsModel = D("goods");
        $newGoodsList = $goodsModel->where($condition)->order("last_update desc,on_time desc")->select();

        if($newGoodsList){
            //var_dump($newGoodsList);
            return $newGoodsList;
        }else{
            return false;
        }
    }

    //根据商品、销量来排行
    public function getGoodsOrderBySales(){
        //条件
        $condition['cat_id'] = I('get.cate_id');
        $condition['is_on_sale'] = 1;

        //获取商品、按销量排行
        $goodsModel = D("goods");
        $GoodsList = $goodsModel->where($condition)->order("sales_sum desc")->select();

        if($GoodsList){
            //var_dump($newGoodsList);
            return $GoodsList;
        }else{
            return false;
        }
    }

    public function getSelectGoods(){
        $goodsList = $this->getGoodsOrderByTime();
        if($goodsList){
            $data['code'] = 1;
            $data['msg'] = "获取成功";
            $data['data'] = $goodsList;
            exit(json_encode($data));
        }else{
            $data['code'] = 0;
            $data['msg'] = '数据库没有数据';
            exit(json_encode($data));
        }
    }

    public function getSortGoods(){
        $val = I('get.val');
        $goodsList = array();
        if($val == 'is_new'){
            $goodsList = $this->getGoodsOrderByTime();
		}else if($val == 'is_hot'){
            $goodsList = $this->getHotGoods();
		}else if($val == "sales_sum"){
            $goodsList = $this->getGoodsOrderBySales();
		}
        if($goodsList){
            $data['code'] = 1;
            $data['msg'] = "获取成功";
            $data['data'] = $goodsList;
            exit(json_encode($data));
        }else{
            $data['code'] = 0;
            $data['msg'] = '数据库没有数据';
            exit(json_encode($data));
        }
    }

    //通过商品id获取商品详细信息
    public function goods_detail(){
        //获取goods_id
        $goods_id = I('get.goods_id');

        //判断是否从购物车跳转过来
        if(I('get.cart')){
            $condition['user_id'] = session('user_id');
            $condition['goods_id'] = $goods_id;
            $goods_num = D('cart')->select()[0]['goods_num'];
            $this->assign('goods_num',$goods_num);
        }else{
            $this->assign('goods_num',1);
        }

        //获取商品的信息
        $goods = D('goods')->where("goods_id = $goods_id")->select();
        $this->assign('goods',$goods);
        //var_dump($goods);

        //获取商品相册
        $goodsImageModel = D('goods_images');
        $goodsImageList = $goodsImageModel->where("goods_id = $goods_id")->select();
        //var_dump($goodsImageList);
        $this->assign('goodsImageList',$goodsImageList);

        //获取导航条数组
        $nav = $this->makeNav($goods_id);
        $this->assign("nav",$nav);

        $this->display();
    }

    //获取父节点的分类，用于制作导航条
    public function makeNav($goods_id){
        $goodsModel = D('goods');
        $nav = array();
        $goods = $goodsModel->where("goods_id = $goods_id")->field("cat_id,goods_name")->select()[0];
        $nav[0]['id'] = $goods_id;
        $nav[0]['name'] = $goods['goods_name'];
        $cate_id = $goods['cat_id'];
        $i = 1;

        $parent_id = 0;
        do{
            $cateModel = D('goods_category');
            $cate = $cateModel->field("name,parent_id,level")->where("id = $cate_id")->select()[0];
            $nav[$i]['id'] = $cate_id;
            $nav[$i]['name'] = $cate['name'];
            $cate_id = $cate['parent_id'];
            $parent_id = $cate['level'];
            $i++;
        }while($parent_id != 1);

        $temp = $nav;
        $j = count($nav)-1;
        foreach($nav as $k => $v){
            $nav[$k] = $temp[$j];
            $j--;
        }
        //var_dump($nav);
        return $nav;
    }
}