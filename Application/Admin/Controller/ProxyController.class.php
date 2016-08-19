<?php
namespace Admin\Controller;
use Admin\Logic\GoodsLogic;
use Admin\Model\GoodsModel;
use Admin\Model\SpecModel;
use Think\AjaxPage;
use Think\Page;

class ProxyController extends BaseController {
    /**
     * 代理商列表
     */
    public function proxyList(){
        $model = D("Proxys");                
        $count = $model->count();        
        $Page  = new Page($count,100);
        $show  = $Page->show();
        $proxyList = $model->order("id desc")->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('show',$show);
        $str="SELECT * FROM `tp_proxys`";
        $this->assign('proxyList',$proxyList);
        $this->display('proxyList');
    }
    
    
    /**
     * 添加修改编辑  开户
     */
    public  function addEditProxy(){        
            $_GET['id'] = $_GET['id'] ? $_GET['id'] : 0;            
            $model = M("Proxys"); 
            $agent=M('Agents');
            $agentarr=$agent->select();
               
            if(IS_POST)
            {
                    $data = $model->create();
                    if($_GET['id']){
                        $id = $_GET['id']+6679;
                        $data['code'] = md5($id);
                        $data['password']=encrypt(I('password'));
                        //C('agent_path') 可在配置文件更改。
                        $data['url'] = "http://".C('agent_path')."/index.php/home/index/index/agent_id/".$data['code'];

                        $res = $model->save($data);
                        //var_dump($res);
                    }else{
                        $id = $model->add($data);
                        //var_dump($id);
                        if($id){
                            $code= $id+6679;
                            $data2['code'] = md5($code);
                            $data2['password']=encrypt(I('password'));
                            $data2['url'] = "http://".C('agent_path')."/index.php/home/index/index/agent_id/".$data2['code'];

                            $model->where("id = $id")->save($data2);
                        }
                    }
                    
                    $this->success("操作成功!!!",U('Admin/Proxy/proxyList'));               
                    exit;
            }           
           $proxy = $model->find($_GET['id']);
          
           $this->assign('proxy',$proxy);
           $this->assign('agentarr',$agentarr);
           $this->display();           
    }

    /**
     * 删除代理商
     */
    public function delProxy()
    {

        M('Proxys')->where("id = {$_GET['id']}")->delete();   
        $this->success("操作成功!!!",U('Admin/Proxy/proxyList'));
    }
}