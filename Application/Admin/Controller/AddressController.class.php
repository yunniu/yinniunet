<?php
/**
 * Created by PhpStorm.
 * User: my_pc
 * Date: 2016/7/27
 * Time: 15:11
 */

namespace Admin\Controller;
use Think\Controller;

class AddressController extends Controller
{
    public function getRegion(){
        $level = 1;
        $regionModel = D('region2');
        $region = $regionModel->where("level = $level")->select();

        if($region){
            $data['code'] = 1;
            $data['msg'] = "获取成功";
            $data['region'] = $region;

            exit(json_encode($data));
        }else{
            $data['code'] = 0;
            $data['msg'] = "获取失败";

            exit(json_encode($data));
        }
    }

    public function getRegionById($parent_id)
    {
        $regionModel = D('region2');
        $region = $regionModel->where("parent_id = $parent_id")->select();

        return $region;
    }

    public function getRegionTree($parent_id  = 1){

        $result = $this->getRegionById($parent_id);
        if($result){
            $result2 = $this->getRegionTree($result[0]['id']);
            $result[0]['child'] = $result2;
            return $result;
        }
    }

    public function RegionTree(){
        $parent_id = $_GET['parent_id'] ? $_GET['parent_id'] : 1;
        $result = $this->getRegionTree($parent_id);
        if($result){
            $data['code'] = 1;
            $data['msg'] = "获取成功";
            $data['region'] = $result;

            exit(json_encode($data));
        }else{
            $data['code'] = 0;
            $data['msg'] = "获取失败";

            exit(json_encode($data));
        }
    }
}