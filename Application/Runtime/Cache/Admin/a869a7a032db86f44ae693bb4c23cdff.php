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


  <style>
        
        .table-responsive th, .table-responsive td {
            white-space: nowrap;
        }
  </style>
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"><i class="fa fa-list"></i> 代理列表</h3>
        </div>
        <div class="panel-body">    
		<div class="navbar navbar-default">
            <div class="row navbar-form">
                <button type="submit" onclick="location.href='<?php echo U('Admin/Proxy/addEditProxy');?>'"  class="btn btn-primary pull-right"><i class="fa fa-plus"></i>新增代理</button>
            </div>
          </div>
                        
          <div id="ajax_return"> 
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th class="sorting text-center">ID</th>  
                                <th class="sorting text-center">所属分级</th>                              
                                <th class="sorting text-center">用户名</th>
                                <th class="sorting text-center">真实姓名</th>
                                <th class="sorting text-center">注册时间</th>
                                <th class="sorting text-center">手机号</th>
                                <th class="sorting text-center">身份证号</th>
                                <th class="sorting text-center">银行卡账户</th>
                                <th class="sorting text-center">分成百分数</th>
                                <th class="sorting text-center">URL</th>
                                <th class="sorting text-center">开通/关闭</th>
                                <th class="sorting text-center">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(is_array($proxyList)): $i = 0; $__LIST__ = $proxyList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr>
                                    <td class="text-center"><?php echo ($list["id"]); ?></td>
                                    <td class="text-center"><?php echo ($list["category"]); ?></td>
                                    <td class="text-center"><?php echo ($list["username"]); ?></td>
                                    <td class="text-center"><?php echo ($list["name"]); ?></td>
                                    <td class="text-center"><?php echo (date("y-m-d",$list["register"])); ?></td>
                                    <td class="text-center"><?php echo ($list["phone"]); ?></td>
                                    <td class="text-center"><?php echo ($list["id_card"]); ?></td>
                                    <td class="text-center"><?php echo ($list["bank_card"]); ?></td>
                                    <td class="text-center"><?php echo ($list["divided"]); ?></td>
                                    <td class="text-center"><?php echo ($list["url"]); ?></td>
                                    <td class="text-center"><?php echo ($list["opened"]); ?></td>
                                    <td class="text-center">
										                                  
                                        <a href="<?php echo U('Admin/Proxy/addEditProxy',array('id'=>$list['id']));?>" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="编辑"><i class="fa fa-pencil"></i></a>
                                        <a href="javascript:del_fun('<?php echo U('Proxy/delProxy',array('id'=>$list['id']));?>');" id="button-delete6" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="删除"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                            </tbody>
                        </table>
                    </div>
                
                <div class="row">
                    <div class="col-sm-6 text-left"></div>
                    <div class="col-sm-6 text-right"><?php echo ($show); ?></div>
                </div>
          
          </div>
        </div>
      </div>
    </div>
    <!-- /.row --> 
  </section>
  <!-- /.content --> 
</div>
<!-- /.content-wrapper --> 
</body>
</html>