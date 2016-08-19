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
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<nav class="navbar navbar-default">				
	               			<div class="pull-right navbar-form">
	               				<label><a class="btn btn-block btn-primary" href="javascript:void(0)" id="add-menu" data-url="">添加导航菜单</a></label>
	               			</div>
	               		</nav>
					</div>
		               <div class="box-body">
				           <div class="row">
				            	<div class="col-sm-12">
					              <table id="list-table" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
					                 <thead>
					                   <tr role="row">
					                   	   <th>ID</th>  
						                   <th class="sorting" tabindex="0" aria-controls="example1" >标题</th>
						                   <th class="sorting" tabindex="0" aria-controls="example1" >排序</th>
						                   <th class="sorting" tabindex="0" aria-controls="example1" >操作</th>
					                   </tr>
					                 </thead>
									<tbody>
										<?php if(is_array($tree)): foreach($tree as $key=>$v): ?><tr id="mod-<?php echo ($v["mod_id"]); ?>">
											<td><?php echo ($v["mod_id"]); ?></td>
											<td style="text-align:left;">&nbsp;&nbsp;<strong><?php echo ($v["title"]); ?></strong></td>
											<td>
                                                                                            <input type="text" name="orderby[<?php echo ($v["mod_id"]); ?>]" value="<?php echo ($v["orderby"]); ?>" class="input-sm" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onpaste="this.value=this.value.replace(/[^\d]/g,'')" onchange="updateSort('system_module','mod_id','<?php echo ($v["mod_id"]); ?>','orderby',this)"/>
                                                                                        </td>
											<td>
												<a href="javascript:void(0)" data-url="<?php echo U('Admin/System/create_menu',array('mod_id'=>$v[mod_id],'action'=>'add'));?>" class="btn btn-primary create-sub-menu">添加菜单</a>
												<a href="javascript:void(0)" data-url="<?php echo U('Admin/System/create_menu',array('mod_id'=>$v[mod_id],'action'=>'edit'));?>" class="btn btn-info create-sub-menu">编辑</a>
												<a href="javascript:void(0)" data-url="<?php echo U('Admin/System/menuSave',array('mod_id'=>$v[mod_id],'action'=>'del'));?>" data-id="<?php echo ($v["mod_id"]); ?>" class="btn btn-danger del-sub-menu">删除</a>
											 </td>
										</tr>
											<?php if(is_array($v["menu"])): foreach($v["menu"] as $key=>$vv): ?><tr id="mod-<?php echo ($vv["mod_id"]); ?>">
												<td><?php echo ($vv["mod_id"]); ?></td>
												<td style="text-align:left;">&nbsp;&nbsp;|----<strong><?php echo ($vv["title"]); ?></strong></td>
												<td><input type="text" name="orderby[<?php echo ($vv["mod_id"]); ?>]" value="<?php echo ($vv["orderby"]); ?>" class="input-sm" onchange="updateSort(this,<?php echo ($vv["mod_id"]); ?>)"/></td>
												<td>
												<a href="javascript:void(0)" class="btn btn-default model-edit" data-url="<?php echo U('Admin/System/ctl_detail',array('mod_id'=>$vv[mod_id]));?>">控制模块</a>
												<a href="javascript:void(0)" class="btn btn-info create-sub-menu" data-url="<?php echo U('System/create_menu',array('action'=>'edit','mod_id'=>$vv[mod_id]));?>">编辑</a>
												<a href="javascript:void(0)" data-url="<?php echo U('Admin/System/menuSave');?>" data-id="<?php echo ($vv["mod_id"]); ?>" class="btn btn-danger del-sub-menu">删除</a>
												</td>										
											</tr><?php endforeach; endif; endforeach; endif; ?>
					                  </tbody>
					               </table>
				               </div>
				          </div>
		          </div>
				</div>
			</div>
		</div>
	</section>
</div>
<script>
$('#add-menu').click(function(){
    layer.open({
        type: 2,
        title: '添加导航',
        shadeClose: true,
        shade: 0.8,
        area: ['450px', '320px'],
        content: "<?php echo U('Admin/System/create_menu');?>", 
    });
});

//管理菜单
$('.create-sub-menu').click(function(){
    var url = $(this).attr('data-url');
    layer.open({
        type: 2,
        title: '管理菜单',
        shadeClose: true,
        shade: 0.8,
        area: ['450px', '320px'],
        content: url, 
    });
});

//控制模块
$('.model-edit').click(function(){
    var url = $(this).attr('data-url');
    layer.open({
        type: 2,
        title: '管理模块',
        shadeClose: true,
        shade: 0.8,
        area: ['80%', '70%'],
        content: url, 
    });
});

//删除菜单
$('.del-sub-menu').click(function(){
    var url = $(this).attr('data-url')+'/'+Math.random();
    var mod_id = $(this).attr('data-id');
    layer.confirm('删除菜单要慎重哦', {
        btn: ['确定','取消']
    }, function(){
    	$.ajax({
    		url:url,
    		type:'post',
    		dataType:'json',
    		data:{mod_id:mod_id,action:'del'},
    		success:function(data){
    			if(data.stat=='ok'){
    				layer.msg('删除成功', {icon: 1});
    				$('#mod-'+mod_id).remove();
    			}else{
    				layer.msg(data.msg, {icon: 3});
    			}
    		}
    	});
    }, function(){
    	layer.close();
    });
});
 

//回调函数
function call_back(msg){
	if(msg>0){
		//layer.alert('操作成功');
		layer.msg('操作成功', {icon: 1});
		layer.closeAll('iframe');
		window.location.reload();
	}else{
		//layer.alert('操作失败');
		layer.msg('操作失败', {icon: 3});
		layer.closeAll('iframe');
	}
}
</script>

</body>
</html>