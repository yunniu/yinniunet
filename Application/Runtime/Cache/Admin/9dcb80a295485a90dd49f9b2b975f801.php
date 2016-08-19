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
				        <div class="collapse navbar-collapse">
				          <form class="navbar-form form-inline" action="<?php echo U('Ad/adList');?>" method="post">
				            <div class="form-group">
				              	<input type="text" name="keywords" class="form-control" placeholder="请输入广告名称">
				            </div>
				            <div class="form-group">
				            	 <select name="pid" class="form-control">
                                      <?php if(is_array($ad_position_list)): $k = 0; $__LIST__ = $ad_position_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($k % 2 );++$k;?><option value="<?php echo ($k); ?>" <?php if($pid == $k): ?>selected<?php endif; ?>><?php echo ($item); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>                  
                                 </select>   
				            </div>
				            <button type="submit" class="btn btn-primary">查询</button>
				            <div class="form-group pull-right">
					            <a href="<?php echo U('Ad/ad');?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> 新增广告</a>
				            </div>		          
				          </form>
				      	</div>
	    			</nav>
	    			<!--<nav class="navbar navbar-default">	     -->
				      <!--<div class="collapse navbar-collapse">-->
	    				<!--&lt;!&ndash;<div class="navbar-form form-inline">&ndash;&gt;-->
				            <!--&lt;!&ndash;<div class="form-group">&ndash;&gt;-->
				            	<!--&lt;!&ndash;<p class="text-success margin blod">预览广告所在页面:</p>&ndash;&gt;-->
				            <!--&lt;!&ndash;</div>&ndash;&gt;-->
				             <!--&lt;!&ndash;<div class="form-group">&ndash;&gt;-->
                                 <!--&lt;!&ndash;<a class="btn btn-default" href="<?php echo U('/Home/Index/index',array('edit_ad'=>1));?>">首页</a>&nbsp;&nbsp;&nbsp;&nbsp;                                            &ndash;&gt;-->
                                 <!--&lt;!&ndash;<a class="btn btn-default" href="<?php echo U('/Home/Index/promoteList',array('edit_ad'=>1));?>" >商品促销页</a>&nbsp;&nbsp;&nbsp;&nbsp;                                            &ndash;&gt;-->
                                 <!--&lt;!&ndash;<a class="btn btn-default" href="<?php echo U('/Home/GroupBuy/GroupBuyList',array('edit_ad'=>1));?>" >团购页面</a>&nbsp;&nbsp;&nbsp;&nbsp;&ndash;&gt;-->
                                    <!--&lt;!&ndash;<select class="form-control" name="intro" onchange="if(this.value != 0) location.href='/index.php?m=Home&c=Channel&a=index&edit_ad=1&id='+this.value;">&ndash;&gt;-->
                                        <!--&lt;!&ndash;<option value="0">请选择频道页广告</option>&ndash;&gt;-->
                                        <!--&lt;!&ndash;<tpshop sql="select * from `__PREFIX__goods_category` where `level` = 1" key="k" item='v'>&ndash;&gt;-->
	                                        <!--&lt;!&ndash;<option value="<?php echo ($v[id]); ?>"><?php echo ($v[name]); ?></option>&ndash;&gt;-->
                                      	<!--&lt;!&ndash;</tpshop>&ndash;&gt;-->
                                    <!--&lt;!&ndash;</select>&ndash;&gt;-->
                                 <!--&lt;!&ndash;&lt;!&ndash; <a class="btn btn-default" href="<?php echo U('/Mobile/Index/index',array('edit_ad'=>1));?>">手机首页</a>&nbsp;&nbsp;&nbsp;&nbsp;&ndash;&gt;&ndash;&gt;-->
				            <!--&lt;!&ndash;</div>			          &ndash;&gt;-->
				          <!--&lt;!&ndash;</div>&ndash;&gt;-->
				       <!--</div>-->
	    		 <!--</nav>	-->
	             </div>
	             <div class="box-body">
	           	 <div class="row">
	            	<div class="col-sm-12">
		              <table id="list-table" class="table table-bordered table-striped dataTable">
		                 <thead>
		                   <tr role="row">
                                           <th>广告id</th>
                                           <th>广告位置</th>
			                   <th>广告名称</th>	
			                   <th>广告图片</th>	                   
			                   <th>广告链接</th>
                                           <th>新窗口</th>
			                   <th>是否显示</th>
		                  	   <th>排序</th>
		                  	   <th>操作</th>
		                   </tr>
		                 </thead>
						<tbody>
                          <?php if(is_array($list)): foreach($list as $k=>$vo): ?><tr role="row">    
                                     <td><?php echo ($vo[ad_id]); ?></td>
                                     <td><?php echo ($ad_position_list[$vo[pid]]); ?></td>
		                     <td><?php echo ($vo["ad_name"]); ?></td>	                    
		                     <td><img alt="" src="<?php echo ($vo["ad_code"]); ?>" width="80px" height="50px"></td>
		                     <td><?php echo ($vo["ad_link"]); ?></td>
		                     <td>
                                         <img width="20" height="20" src="/Public/images/<?php if($vo[target] == 1): ?>yes.png<?php else: ?>cancel.png<?php endif; ?>" onclick="changeTableVal('ad','ad_id','<?php echo ($vo["ad_id"]); ?>','target',this)"/>
		                     </td>                                     
		                     <td>
                                         <img width="20" height="20" src="/Public/images/<?php if($vo[enabled] == 1): ?>yes.png<?php else: ?>cancel.png<?php endif; ?>" onclick="changeTableVal('ad','ad_id','<?php echo ($vo["ad_id"]); ?>','enabled',this)"/>
		                     </td>
		                     <td>
                                        <input type="text" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onpaste="this.value=this.value.replace(/[^\d]/g,'')" onchange="updateSort('ad','ad_id','<?php echo ($vo["ad_id"]); ?>','orderby',this)" size="4" value="<?php echo ($vo["orderby"]); ?>" class="input-sm" />		                     	
		                     </td>
		                     <td>
		                      <a class="btn btn-primary" href="<?php echo U('Ad/ad',array('act'=>'edit','ad_id'=>$vo['ad_id']));?>"><i class="fa fa-pencil"></i></a>
		                      <a class="btn btn-danger" onclick="delfunc(this)" data-url="<?php echo U('Ad/adHandle');?>" data-id="<?php echo ($vo["ad_id"]); ?>"><i class="fa fa-trash-o"></i></a>
				     </td>
		                   </tr><?php endforeach; endif; ?>
		                   </tbody>
		                 <tfoot>
		                 
		                 </tfoot>
		               </table>
	               </div>
	          </div>
              <div class="row">
              	    <div class="col-sm-6 text-left">
              	    	<button class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
              	    </div>
                    <div class="col-sm-6 text-right"><?php echo ($page); ?></div>		
              </div>
	          </div>
	        </div>
       	</div>
       </div>
   </section>
<script>

</script>
</div>
</body>
</html>