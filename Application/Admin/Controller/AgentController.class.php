<?php
namespace Admin\Controller;
use Admin\Logic\GoodsLogic;
use Admin\Model\GoodsModel;
use Admin\Model\SpecModel;
use Think\AjaxPage;
use Think\Page;

class AgentController extends BaseController {

    /**
     * 代理级别列表
     */
    public function agentList(){
        $model = M("Agents");                
        $count = $model->count();        
        $Page  = new Page($count,100);
        $show  = $Page->show();
        $goodsTypeList = $model->order("id desc")->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('show',$show);
        $this->assign('goodsTypeList',$goodsTypeList);
        $this->display('agentList');
    }
    
    
    /**
     * 添加修改编辑代理级别
     */
    public  function addEditAgent(){        
            $_GET['id'] = $_GET['id'] ? $_GET['id'] : 0;            
            $model = M("Agents");           
            if(IS_POST)
            {
                    $model->create();
                    if($_GET['id'])
                        $model->save();
                    else
                        $model->add();
                    
                    $this->success("操作成功!!!",U('Admin/Agent/agentList'));               
                    exit;
            }           
           $goodsType = $model->find($_GET['id']);
           $this->assign('goodsType',$goodsType);
           $this->display('_agentType');           
    }

    /**
     * 删除代理级别
     */
    public function delAgentType()
    {

        M('Agents')->where("id = {$_GET['id']}")->delete();   
        $this->success("操作成功!!!",U('Admin/Agent/agentList'));
    }
}