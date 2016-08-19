<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>tpshop管理后台</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link href="/Public/bootstrap/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
      <!-- 新 Bootstrap 核心 CSS 文件 -->
      <link rel="stylesheet" href="/Public/bootstrap/css/bootstrap.css">
      <link rel="stylesheet" href="/Public/Font-Awesome/css/font-awesome.css">
      <!-- admin CSS -->
      <link rel="stylesheet" href="/Public/css/admin.css">

      <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
    <script src="/Public/bootstrap/jquery-3.1.0.min.js"></script>
      <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
      <script src="/Public/bootstrap/js/bootstrap.min.js"></script>
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  <script src="/Public/js/common.js"></script>
  <script src="/Public/js/upgrade.js"></script>
  <script src="/Public/js/layer/layer.js"></script><!--弹窗js 参考文档 http://layer.layui.com/-->
  </head>
<body>
  <!---->
  <section class="container">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">网站资讯</h3>
      </div>
      <div class="panel-body">
        <div class="navbar navbar-default">
          <div class="row navbar-form">
            <button type="submit" onclick="location.href='/index.php/Admin/ad/addArticle'" class="btn btn-primary pull-right">
              <i class="icon-plus"></i>增加资讯
            </button>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center">ID</th>
                <th class="text-center">名称</th>
                <th class="text-center">内容</th>
                <th class="text-center">关键词</th>
                <th class="text-center">是否启用</th>
                 <th class="text-center">添加时间</th>
                <th class="text-center">操作</th>

              </tr>
            </thead>
            <tbody>
            <?php if(is_array($articleList)): $i = 0; $__LIST__ = $articleList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                <td class="text-center"><?php echo ($i); ?></td>
                <td class="text-center"><?php echo ($vo["article_name"]); ?></td>
                <td class="text-center"><?php echo ($vo["content"]); ?></td>
                <td class="text-center"><?php echo ($vo["keywords"]); ?></td>
                <td class="text-center"><a href="javascript:void(0)" onclick="change(this)">
                  <?php if($vo[is_open] == 1): ?><img src="/Public/images/yes.png" data-val="<?php echo ($vo["is_open"]); ?>" data-id="<?php echo ($vo["article_id"]); ?>">
                  <?php else: ?>
                      <img src="/Public/images/cancel.png" data-val="<?php echo ($vo["is_open"]); ?>" data-id="<?php echo ($vo["article_id"]); ?>"><?php endif; ?>
                </a></td>
                <td class="text-center"><?php echo ($vo["add_time"]); ?></td>
                <td class="text-center">
                  <a href="/index.php/Admin/ad/editArticle/article_id/<?php echo ($vo["article_id"]); ?>" class="btn btn-primary" data-original-title="编辑">
                    <i class="icon-pencil"></i>
                  </a>
                  <a href="#" class="btn btn-danger" data-original-title="删除" onclick="delfun(this)" data-id="<?php echo ($vo["article_id"]); ?>">
                    <i class="icon-trash"></i>
                  </a>
                </td>
              </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
          </table>
        </div>
      </div>    
    </div>
  </section> 
</body>
<script>
    function change(obj){
      var val = $(obj).children(":first").data("val");
      var $article_id = $(obj).children(":first").data("id");
//      console.log(val);
//      console.log($article_id);
      $.ajax({
        url:"/index.php/admin/ad/changeArticleStatus",
        data:{"article_id":$article_id,"is_open":val},
        dataType:"json",
        success:function(msg){
          //console.log(msg.status);
          if(msg.status == 1){
            $(obj).children(":first").attr('src',"/Public/images/yes.png");
            $(obj).children(":first").data("val",1);
          }else if(msg.status == 0){
            $(obj).children(":first").attr('src',"/Public/images/cancel.png");
            $(obj).children(":first").data("val",0);
          }
        },
        error:function(){
          alert("出错了");
        }
      });
    }
    function delfun(obj){
      if(confirm('确认删除')){
        $.ajax({
          type : 'get',
          url : '/index.php/admin/ad/delArticle',
          data : {article_id:$(obj).attr('data-id')},
          dataType : 'json',
          success : function(msg){
            if(msg.code ==1){
              $(obj).parent().parent().remove();
            }else{
              layer.alert(data, {icon: 2});   //alert('用户名或密码不能为空');// alert(data);
            }
          }
        })
      }
      return false;
    }
</script>
</html>