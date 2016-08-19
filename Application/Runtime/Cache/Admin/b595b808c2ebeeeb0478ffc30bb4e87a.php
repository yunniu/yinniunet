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
<aside class="main-sidebar">
  <section class="sidebar">
    <div class="container-fluid">
      <!-- 侧栏菜单-->
      <div class="sidebar" style="overflow-y:scroll;">
        <ul class="nav nav-sidebar">
          <!--网站logo-->
          <li style="margin-top:1em;margin-bottom:1em;">
            <a href="/index.php/Admin/index/index" style="padding:0;"><img src="/Public/images/header_logo.jpg" width="100%" height="46"></a>
          </li>

          <?php if(is_array($menu_list)): foreach($menu_list as $k=>$vo): ?><li class="treeview">
              <a href="javascript:void(0)">
                <i class="fa <?php echo ($vo["icon"]); ?>"></i><h5><?php echo ($vo["title"]); ?></h5>
              </a>
              <ul class="treeview-menu">
                <?php if(is_array($vo["submenu"])): foreach($vo["submenu"] as $kk=>$vv): ?><li onclick="makecss(this,<?php echo ($vv["mod_id"]); ?>)" id="menu_<?php echo ($vv["mod_id"]); ?>"><a href="<?php echo ($vv["url"]); ?>" target='rightContent'><i class="icon-circle-blank"></i></i> <?php echo ($vv["title"]); ?></a></li><?php endforeach; endif; ?>
              </ul>
            </li><?php endforeach; endif; ?>

          <!--&lt;!&ndash;权限管理&ndash;&gt;-->
          <!--<li class="treeview">-->
            <!--<a>-->
              <!--<i class="icon-cog"></i>-->
              <!--<h5>权限管理</h5>-->
            <!--</a>-->
            <!--<ul class="treeview-menu collapse" id="collapseExample">-->
              <!--<li>-->
                <!--<a href="/index.php/Admin/Admin/role" target='rightContent'>-->
                  <!--<i class="icon-circle-blank"></i>-->
                  <!--<span>角色管理</span>-->
                <!--</a>-->
              <!--</li>-->
              <!--<li>-->
                <!--<a href="/index.php/Admin/Admin/index" target='rightContent'>-->
                  <!--<i class="icon-circle-blank"></i>-->
                  <!--<span>管理员列表</span>-->
                <!--</a>-->
              <!--</li>-->
              <!--<li>-->
                <!--<a href="/index.php/Admin/Admin/log" target='rightContent'>-->
                  <!--<i class="icon-circle-blank"></i>-->
                  <!--<span>管理员日志</span>-->
                <!--</a>-->
              <!--</li>-->
            <!--</ul>-->
          <!--</li>-->
        </ul>
      </div>
    </div>
  </section>
</aside>
<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
<script src="/Public/bootstrap/jquery-3.1.0.min.js"></script>
<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="/Public/bootstrap/js/bootstrap.min.js"></script>

<section class="content-wrapper right-side" id="riframe" style="margin:0px;padding:0px;">
    <!-- 内容体 -->
    <div class="main">
        <div class="main_header">
            <div class="container">
                <div class="row">
                    <div class="col-sm-9 col-md-10 "><a href="/index.php/Admin/index/index" style="color:#000;font-weight: bold;font-size:2em;text-decoration:none;">系统后台</a></div>
                    <div class="col-sm-3 col-md-2">
                        <!-- Single button -->
                        <div class="btn-group dropdown-menu-left  dropdown" >
                            <a href="#" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="border:0">
                                <span style="color:#3c8dbc;"><span class="glyphicon glyphicon-user"></span><?php echo ($admin_info["user_name"]); ?><span class="caret"></span></span>
                            </a>
                            <ul class="dropdown-menu ">
                                <li><a href="/index.php/Admin/admin/logout">切换用户</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--页面主体-->
        <iframe id='rightContent' name='rightContent' src="/index.php/Admin/index/welcome" frameborder="0" width="100%" height="80%"  ></iframe>
        <!--</div>-->
    </div>
</section>
	<footer class="main-footer">
	</footer>
<script src="/Public/js/jquery-ui.min.js" type="text/javascript"></script>
<script src="/Public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/Public/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="/Public/plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
<script src="/Public/dist/js/app.js" type="text/javascript"></script>
<script src="/Public/dist/js/demo.js" type="text/javascript"></script>
 
<script type="text/javascript">
$(document).ready(function(){
	$("#riframe").height($(window).height()-100);//浏览器当前窗口可视区域高度
//	$("#rightContent").height($(window).height()-100);
//	$('.main-sidebar').height($(window).height()-50);
});
</script>
</body>
</html>