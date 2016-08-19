<?php
/**
 * Created by PhpStorm.
 * User: my_pc
 * Date: 2016/8/15
 * Time: 14:57
 */

namespace Home\Controller;
class UserController extends BaseController
{
    public function login(){
        if($_POST){
            $condition['username'] = I('post.username');
            $condition['password'] = md5(I('post.password'));

//            var_dump($condition);
//            var_dump(11111111111111111111111);

            $userModel = D('users');
            $user_info = $userModel->where($condition)->select()[0];

//            var_dump($user_info);
            $agent_id = session('agent_code');
            if($user_info){
                session('user_id',$user_info['user_id']);
                $this->success("登陆成功",U("index/index?agent_id=$agent_id"));
                exit;
            }else{
                $this->error("用户名或密码错误",U("index/index?agent_id=$agent_id"));
            }
        }
    }
}