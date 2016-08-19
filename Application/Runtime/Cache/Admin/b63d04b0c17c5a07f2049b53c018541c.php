<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>tpshop管理后台</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.4 -->
    <link rel="stylesheet" href="/Public/bootstrap/css/bootstrap.css">
    <link href="/Public/bootstrap/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/Public/Font-Awesome/css/font-awesome.css">
    <!-- Ionicons 2.0.0 --
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="/Public/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
    	folder instead of downloading all of them to reduce the load. -->
    <link href="/Public/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="/Public/plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />
    <script src="/Public/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="/Public/js/common.js"></script>
    <script src="/Public/js/myFormValidate.js"></script>    
    <script src="/Public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/Public/js/layer/layer-min.js"></script><!-- 弹窗js 参考文档 http://layer.layui.com/-->
    <script src="/Public/js/myAjax.js"></script>
    <script type="text/javascript">
    function delfunc(obj){
    	layer.confirm('确认删除？', {
    		  btn: ['确定','取消'] //按钮
    		}, function(){
    		    // 确定
   				$.ajax({
   					type : 'post',
   					url : $(obj).attr('data-url'),
   					data : {act:'del',del_id:$(obj).attr('data-id')},
   					dataType : 'json',
   					success : function(data){
   						if(data==1){
   							layer.msg('操作成功', {icon: 1});
   							$(obj).parent().parent().remove();
   						}else{
   							layer.msg(data, {icon: 2,time: 2000});
   						}
   						layer.closeAll();
   					}
   				})
    		}, function(index){
    			layer.close(index);
    			return false;// 取消
    		}
    	);
    }
    
    function selectAll(name,obj){
    	$('input[name*='+name+']').prop('checked', $(obj).checked);
    }    
    </script>        
  </head>
  <body style="background-color:white;">
 

<div class="wrapper">
    <!--<div class="breadcrumbs" id="breadcrumbs">-->
	<!--<ol class="breadcrumb">-->
	<!--<?php if(is_array($navigate_admin)): foreach($navigate_admin as $k=>$v): ?>-->
	    <!--<?php if($k == '后台首页'): ?>-->
	        <!--<li><a href="<?php echo ($v); ?>"><i class="fa fa-home"></i>&nbsp;&nbsp;<?php echo ($k); ?></a></li>-->
	    <!--<?php else: ?>    -->
	        <!--<li><a href="<?php echo ($v); ?>"><?php echo ($k); ?></a></li>-->
	    <!--<?php endif; ?>                  -->
	<!--<?php endforeach; endif; ?>          -->
	<!--</ol>-->
<!--</div>-->

    <section class="content">
        <!-- Main content -->
        <div class="container-fluid">
            <div class="pull-right">
                <a href="javascript:history.go(-1)" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="返回"><i class="fa fa-reply"></i></a>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-list"></i> 代理商详情</h3>
                </div>
                <div class="panel-body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_tongyong" data-toggle="tab">代理信息</a></li>
                    </ul>
                    <!--表单数据-->
                    <form method="post" id="addEditGoodsTypeForm" onsubmit="">                    
                        <!--通用信息-->
                    <div class="tab-content">                 	  
                        <div class="tab-pane active" id="tab_tongyong">
                           
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <td>用户名:</td>
                                    <td>
                                        <input type="text" value="<?php echo ($proxy["username"]); ?>" name="username" id="username" />
                                        <span id="err_name" style="color:#F00; display:none;">代理的名称不能为空!!</span>
                                </tr>
                                <tr>                                        
                                    </td>

                                    <td>密码:</td>
                                    <td>
                                        <input type="text" value="" name="password" id="password" />                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td>真实姓名:</td>
                                    <td>
                                        <input type="text" value="<?php echo ($proxy["name"]); ?>" name="name" id="name" />                                        
                                    </td>
                                </tr>  
                                <tr>
                                    <td>注册时间:</td>
                                    <td>
                                        <input type="text" value='<?php echo ($proxy["register"]); ?>' name="register" id="register" />                                      
                                    </td>
                                </tr> 
                                <tr>
                                    <td>手机号码:</td>
                                    <td>
                                        <input type="text" value="<?php echo ($proxy["phone"]); ?>" name="phone" id="phone" />                                        
                                    </td>
                                </tr>   
                                <tr>
                                    <td>身份证号:</td>
                                    <td>
                                        <input type="text" value="<?php echo ($proxy["id_card"]); ?>" name="id_card" id="id_card" />                                        
                                    </td>
                                </tr>  
                                <tr>
                                    <td>银行卡账户:</td>
                                    <td>
                                        <input type="text" value="<?php echo ($proxy["bank_card"]); ?>" name="bank_card" id="bank_card" />                                        
                                    </td>
                                </tr> 
                                <tr>
                                    <td>分成百分比（小数）:</td>
                                    <td>
                                        <input type="text" value="<?php echo ($proxy["divided"]); ?>" name="divided" id="divided" />                                        
                                    </td>
                                </tr> 
                                <tr>
                                    <td>所属总代:</td>
                                    <td>
                                       
                                        <select  value="<?php echo ($proxy["category"]); ?>" name="category" id="category">
                                        <?php if(is_array($agentarr)): $i = 0; $__LIST__ = $agentarr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option><?php echo ($vo["agentname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                        </select>                                        
                                    </td>
                                </tr>                             
                                </tbody>                                
                                </table>
                        </div>                           
                    </div>              
                    <div class="pull-right">
                        <input type="hidden" name="id" value="<?php echo ($proxy["id"]); ?>">
                        <button class="btn btn-primary" title="" data-toggle="tooltip" type="submit" data-original-title="保存"><i class="fa fa-save"></i></button>
                    </div>
			    </form><!--表单数据-->
                </div>
            </div>
        </div>    <!-- /.content -->
    </section>
</div>
<script>
// 判断输入框是否为空
function checkName(){
	var name = $("#addEditGoodsTypeForm").find("input[name='username']").val();
    if($.trim(name) == '' && $('#username')=null)
	{
		$("#err_name").show();
		return false;
	}
	return true;

}



</script>

</body>
</html>