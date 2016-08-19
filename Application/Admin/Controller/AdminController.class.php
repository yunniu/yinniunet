<?php
namespace Admin\Controller;
use Think\Verify;

class AdminController extends BaseController {
	/**
	 * 管理员列表
	 */
    public function index(){
    	$res = $list = array();
    	$keywords = I('keywords');

		//判断是否有搜索关键词，没有则查询全部，有就按关键字查询。
    	if(empty($keywords)){
    		$res = D('admin')->select();
    	}else{
    		$res = D()->query("select * from __PREFIX__admin where user_name like '%$keywords%' order by admin_id");
    	}
		//获取所有的管理角色
    	$roles = D('admin_role')->select();

		//判断管理角色是否为空
    	if($res && $roles){
			//循环管理角色，组成一个以role_id为索引，role_name为值的关联数组$role。
    		foreach ($roles as $v){
    			$role[$v['role_id']] = $v['role_name'];
    		}
			//循环添加role的名称到管理角色的结果集，并转化add_time为date格式，组成新的结果集list。
    		foreach ($res as $val){
    			$val['role'] =  $role[$val['role_id']];
    			$val['add_time'] = date('Y-m-d H:i:s',$val['add_time']);
    			$list[] = $val;
    		}
    	}
    	$this->assign('list',$list);
        $this->display();
    }

	/**
	 *判断是添加管理员或者编辑管理员
	 */
    public function admin_info(){
    	$admin_id = I('get.admin_id',0);//获取管理员ID
    	if($admin_id){//如果管理员信息存在，从数据库中获取管理员的信息
    		$info = D('admin')->where("admin_id=$admin_id")->find();
    		$this->assign('info',$info);
    	}
    	$act = empty($admin_id) ? 'add' : 'edit'; //通过管理员的ID是否为空来判断是添加还是编辑管理员信息。
    	$this->assign('act',$act);
    	$role = D('admin_role')->where('1=1')->select(); //获取管理员信息
    	$this->assign('role',$role);
    	$this->display();
    }

	/**
	 * 获取提交过来的信息，判断act是添加、编辑、删除来执行相应的动作。
	 */
    public function adminHandle(){
    	$data = I('post.');

    	if(empty($data['password'])){//如果递交过来的密码为空，则默认密码不改变。
    		unset($data['password']);
    	}else{
    		$data['password'] = encrypt($data['password']);
    	}

		//添加
    	if($data['act'] == 'add'){
    		unset($data['admin_id']);//释放传过来的admin_id,原因此处admin_id为空,添加时会产生错误。
    		$data['add_time'] = time();
    		if(D('admin')->where("user_name='".$data['user_name']."'")->count()){
    			$this->error("此用户名已被注册，请更换",U('Admin/Admin/admin_info'));
    		}else{
    			$r = D('admin')->add($data);
    		}
    	}

    	//编辑
    	if($data['act'] == 'edit'){
			//根据提交过来的数据更新管理用户的信息。
    		$r = D('admin')->where('admin_id='.$data['admin_id'])->save($data);
    	}

    	//删除
    	if($data['act'] == 'del'){
			//根据admin_id删除对应的记录。
    		$r = D('ad_position')->where('admin_id='.$data['admin_id'])->delete();
    	}
    	
    	if($r){
    		$this->success("操作成功",U('Admin/Admin/index'));
    	}else{
    		$this->error("操作失败",U('Admin/Admin/index'));
    	}
    }
    
    
    /*
     * 管理员登陆
     */
    public function login(){
        if(session('?admin_id') && session('admin_id')>0){
             $this->error("您已登录",U('Admin/Index/index'));
        }
      
        if(IS_POST){
            $verify = new Verify();
            if (!$verify->check(I('post.vertify'), "Admin/Login")) {
            	exit(json_encode(array('status'=>0,'msg'=>'验证码错误')));
            }
            $condition['user_name'] = I('post.username');
            $condition['password'] = I('post.password');

            if(!empty($condition['user_name']) && !empty($condition['password'])){
                $condition['password'] = encrypt($condition['password']);
				//联表 admin表和admin_role表 查询出用户对应的信息，包含拥有的操作权限。
               	$admin_info = M('admin')->join('__ADMIN_ROLE__ ON __ADMIN__.role_id=__ADMIN_ROLE__.role_id')->where($condition)->find();

				if(is_array($admin_info)){
                    session('admin_id',$admin_info['admin_id']);
                    session('act_list',$admin_info['act_list']);
                    $last_login_time = M('admin_log')->where("admin_id = ".$admin_info['admin_id']." and log_info = '后台登录'")->order('log_id desc')->limit(1)->getField('log_time');                    
                    session('last_login_time',$last_login_time);                            
                    adminLog('后台登录',__ACTION__);//管理员登录日志
                    $url = session('from_url') ? session('from_url') : U('Admin/Index/index');

                    exit(json_encode(array('status'=>1,'url'=>$url)));
                }else{
                    exit(json_encode(array('status'=>0,'msg'=>'账号密码不正确')));
                }
            }else{
                exit(json_encode(array('status'=>0,'msg'=>'请填写账号密码')));
            }
        }
        $this->display();
    }
    
    /**
     * 退出登陆
     */
    public function logout(){
        session_unset();
        session_destroy();
        $this->success("退出成功",U('Admin/Admin/login'));
    }
    
    /**
     * 验证码获取
     */
    public function vertify()
    {
        $config = array(
            'fontSize' => 30,
            'length' => 4,
            'useCurve' => true,
            'useNoise' => false,
        );    
        $Verify = new Verify($config);
		ob_end_clean();
        $Verify->entry("Admin/Login");
    }

	/**
	 * 角色管理（角色列表）
	 */
    public function role(){
    	$list = D('admin_role')->order('role_id desc')->select();
//		var_dump($list);
//		exit;
    	$this->assign('list',$list);
    	$this->display();
    }

	/**
	 * 角色的编辑和添加
	 */
    public function role_info(){
    	$role_id = I('get.role_id');
    	$tree = $detail = array();
    	if($role_id){
    		$detail = D('admin_role')->where("role_id=$role_id")->find();
    		$this->assign('detail',$detail);
    	}

    	$res = D('system_module')->order('mod_id ASC')->select();
    	if($res){
    		foreach($res as $k=>$v){
    			if($detail['act_list']){
    				$act_list = explode(',', $detail['act_list']);
    				$v['enable'] = in_array($v['mod_id'], $act_list) ? 1 : 0;
    			}else{
    				$v['enable'] = 0 ;
    			}    		
    			$modules[$v['mod_id']] = $v;
    		}
    		
    		if($modules){
    			foreach($modules as $k=>$v){
    				if($v['module'] == 'top'){
    					$tree[$k] = $v;
    				}
    			}
    			foreach($modules as $k=>$v){
    				if($v['module'] == 'menu'){
    					$tree[$v['parent_id']]['menu'][$k] = $v;
    				}
    			}
    			foreach($modules as $k=>$v){
    				if($v['module'] == 'module'){
    					$ppk = $modules[$v['parent_id']]['parent_id'];
    					$tree[$ppk]['menu'][$v['parent_id']]['menu'][$k] = $v;
    				}
    			}
    		}
    	}
//		var_dump($tree);
    	$this->assign('menu_tree',$tree);
    	$this->display();
    }

	//角色保存
    public function roleSave(){
    	$data = I('post.');
    	$res = $data['data'];
    	$res['act_list'] = is_array($data['menu']) ? implode(',', $data['menu']) : '';
    	if(empty($data['role_id'])){
    		$r = D('admin_role')->add($res);
    	}else{
    		$r = D('admin_role')->where('role_id='.$data['role_id'])->save($res);
    	}
		if($r){
			adminLog('管理角色',__ACTION__);
			$this->success("操作成功!",U('Admin/Admin/role_info',array('role_id'=>$data['role_id'])));
		}else{
			$this->success("操作失败!",U('Admin/Admin/role'));
		}
    }

	//角色删除
    public function roleDel(){
    	$role_id = I('post.role_id');
    	$admin = D('admin')->where('role_id='.$role_id)->find();
    	if($admin){
    		exit(json_encode("请先清空所属该角色的管理员"));
    	}else{
    		$d = M('admin_role')->where("role_id=$role_id")->delete();
    		if($d){
    			exit(json_encode(1));
    		}else{
    			exit(json_encode("删除失败"));
    		}
    	}
    }

	/**
	 * 管理员日志
	 */
    public function log(){
    	$Log = M('admin_log');
    	$p = I('p',1);
    	$logs = $Log->join('__ADMIN__ ON __ADMIN__.admin_id =__ADMIN_LOG__.admin_id')->order('log_time DESC')->page($p.',20')->select();
    	$this->assign('list',$logs);
    	$count = $Log->where('1=1')->count();
    	$Page = new \Think\Page($count,20);
    	$show = $Page->show();
    	$this->assign('page',$show); 	
    	$this->display();
    }
}