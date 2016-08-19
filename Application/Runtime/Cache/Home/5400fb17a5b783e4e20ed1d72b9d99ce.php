<?php if (!defined('THINK_PATH')) exit();?><!Doctype html>
<html lang="zh-CN">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <!--[if lt IE 9]>
  <!--<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>-->
  <!--<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>-->
  <![endif]-->
  <!-- 新 Bootstrap 核心 CSS 文件 -->
  <link rel="stylesheet" href="/Public/bootstrap/css/bootstrap.css">
  <!--样式表-->
  <!--<link rel="stylesheet" href="http://cdn.amazeui.org/amazeui/2.7.1/css/amazeui.min.css">-->
  <link rel="stylesheet" href="/Public/css/main.css">
  <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
  <script src="/Public/bootstrap/jquery-3.1.0.min.js"></script>
  <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
  <script src="/Public/bootstrap/js/bootstrap.min.js"></script>

  <script src="/Public/lazyload-master/amazeui.lazyload.js"></script>

  <script src="/Public/echo.js"></script>
  <title>支付</title>
  <link rel="stylesheet" type="text/css" href="">
</head>

<body>
  <header>
  	<div class="container-fluid text-center">
  		<div class="row">
  			<div class="col-xs-3 col-sm-2 col-lg-1">
  				<button><span class="glyphicon glyphicon-th-list orange" onclick="isLogin()"></span></button>
  			</div>
  			<div class="col-xs-6 col-sm-8 col-lg-10">
          <a href="/index.php/Home/index/index/agent_id/<?php echo (session('agent_code')); ?>"><img src="<?php echo ($shop_info["store_logo"]); ?>" class="center-block"></a>
        </div>
  			<div class="col-xs-3 col-sm-2 col-lg-1">
  				<button type="button" onclick="goCart()">
            <span class="glyphicon glyphicon-shopping-cart green"></span>
            <span class="cart_num" id="cart_num">
                <?php if($cart_num == ''): ?>0
                <?php else: ?>
                  <?php echo ($cart_num); endif; ?>
            </span>
          </button>                   
  			</div>
  		</div>
  	</div>
  </header>

  <!--点击按钮即可通过 JavaScript 启动一个模态框,请为按钮添加data-toggle="modal" data-target="#login" -->
  <!-- Modal -->
<div id="login" class="modal fade" role="dialog">
  <div class="loginbox">
    <div class="loginContent">
      <div class="container-fluid">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <img src="/Public/images/header_logo.png" class="center-block">
          </div>
          <div class="modal-body">           
            <div class="tab-content">
              <div class="tab-pane fade in active" id="log">
                <form class="form-horizontal" action="/index.php/Home/user/login/agent_id/<?php echo (session('agent_code')); ?>" method="post">
                  <div class="input-group">
                    <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
                    <input type="text" class="form-control" placeholder="请输入您的用户名或手机号码" name="username">
                  </div>
                  <div class="input-group">
                    <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
                    <input type="password" class="form-control" placeholder="请输入密码" name="password">
                  </div>
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="请输入验证码">
                    <div class="input-group-addon"><img src="/Public/images/num.png"></div>
                  </div>
                  <button type="submit" class="btn btn-success form-control">登陆</button>
                </form>
              </div>
              <div class="tab-pane fade" id="msg_log">
                <form class="form-horizontal">                  
                  <div class="input-group">
                    <div class="input-group-addon"><span class="glyphicon glyphicon-phone"></span></div>
                    <input type="text" class="form-control" placeholder="请输入您的手机号码">
                  </div>
                  <div class="input-group">
                    <input type="text" class="form-control" id="num">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">获取短信验证码</button>
                    </span>
                  </div>
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="请输入验证码">
                    <div class="input-group-addon"><img src="/Public/images/num.png"></div>
                  </div>
                  <button type="submit" class="btn btn-success form-control">登陆</button>
                </form>
              </div>
              <div class="tab-pane fade" id="signup">
                <form class="form-horizontal">
                  <div class="input-group">
                    <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
                    <input type="text" class="form-control" id="username" placeholder="请设置用户名">
                  </div>
                  <div class="input-group">
                    <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
                    <input type="password" class="form-control" id="Password" placeholder="请设置密码">
                  </div>
                  <div class="input-group">
                    <div class="input-group-addon"><span class="glyphicon glyphicon-phone"></span></div>
                    <input type="text" class="form-control" id="phone" placeholder="请输入您的手机号码">
                  </div>
                  <div class="input-group">
                    <input type="text" class="form-control" id="num">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">获取短信验证码</button>
                    </span>
                  </div>
                  <button type="submit" class="btn btn-warning form-control">注册</button>
                </form>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#log" data-toggle="tab">登陆</a></li>
              <li><a href="#msg_log" data-toggle="tab">短信登陆</a></li>
              <li><a href="#signup" data-toggle="tab">没有账号？注册</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
  <script>
    function goCart(){
      $.ajax({
        url:'/index.php/Home/cart/isLogin/agent_id/<?php echo (session('agent_code')); ?>',
        dataType:"json",
        success:function(msg){
          if(msg.code == 0){
            //alert(msg.msg);
            $("#login").modal('show');
          }else{
            location.href="/index.php/Home/cart/index/agent_id/<?php echo (session('agent_code')); ?>";
          }
        },
        error:function(){
          alert('出错了');
        }
      });
    }

    function isLogin(){
      $.ajax({
        url:'/index.php/Home/cart/isLogin/agent_id/<?php echo (session('agent_code')); ?>',
        dataType:"json",
        success:function(msg){
          if(msg.code == 0){
            //alert(msg.msg);
            $("#login").modal('show');
          }else{
            location.href="/index.php/Home/User/index/agent_id/<?php echo (session('agent_code')); ?>";
          }
        },
        error:function(){
          alert('出错了');
        }
      });
    }
  </script>

<!--导航栏-->
<nav>
	<div class="w70">
		<div class="container_fluid">
			<div class="row text-center">
				<div class="col-xs-2">
					<a href="/index.php/Home/index/index/agent_id/<?php echo (session('agent_code')); ?>">首页</a>
				</div>
				<?php if(is_array($categoryList)): $i = 0; $__LIST__ = $categoryList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="col-xs-2">
						<a href="/index.php/Home/goods/index/agent_id/<?php echo (session('agent_code')); ?>/cate_id/<?php echo ($vo["id"]); ?>" data-id="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></a>
					</div><?php endforeach; endif; else: echo "" ;endif; ?>
			</div>
		</div>
	</div>
</nav>
<!--当前位置-->
<div class="w90">
	<div class="container-fluid">
		<!--当前位置-->
		<ol class="breadcrumb">
			<span class="grey">当前位置:&nbsp;&nbsp;&nbsp;</span>
			<li>
				<a href="<?php echo U('Index/index');?>">首页</a>
			</li>
			<li>
				<a href="#">支付</a>
			</li>
		</ol>
		<!--信息填写-->
		<div class="pay text-center">
			<div class="cart_head"><span>&yen;</span>&nbsp;选择支付方式</div>
			<div class="cart_content">
				<p>一共<span>5</span>件商品&nbsp;&nbsp;合计：<span class="goods_price">&yen;5000.00</span></p>
				<p>请通过支付宝或微信扫描下方二维码完成支付</p>
				<div class="center-block">
					<img src="/Public/images/ali_code.png">
					<img src="/Public/images/wechat_code.png">
				</div>
				<p>支付完成后页面将自动跳转，<br>下一步你将需要输入联系方式与收货地址</p>
			</div>
			<button class="btn orange_btn" onclick="location.href='<?php echo U('Cart/adress');?>'">返回</button>			
		</div>
	</div>
</div>
<!--footer 开始-->
	<footer>
		<p class="footer_title"><?php echo ($article["content"]); ?></p>
		<div class="w90">
			<div class="container-fluid">
				<div class="row">
					<div class="col-xs-6 col-sm-5">
						<img src="/Public/images/footer_logo.png" width="50%"><br>
						<span>上海市偶满意商务有限公司</span><br>
						<span>地址：上海市浦东新区张江高科A-221号</span><br>
						<span style="word-break:break-all;">邮箱：oumanyi@youmaniyi.com</span><br>
					</div>
					<div class="col-xs-6 col-sm-7">
						<div class="col-xs-12 col-sm-4 col-sm-push-8 wechat_code">
							<img src="/Public/images/wechat.png" class="center-block">
						</div>
						<div class="col-xs-12 col-sm-8 col-sm-pull-4 phone_box">
							<div class="phone_msg">
								<img src="/Public/images/phone.png">
								<div>
									<small>客服时间：+09:00-18:00</small><br>
									<span class="orange">400-996-0976</span>
								</div>
							</div>
						</div>
					</div>
					<!-- <div class="col-xs-7 col-sm-2 col-sm-push-5 wechat_code">
						<img src="/Public/images/wechat.png" class="center-block">
					</div>
					<div class="col-xs-7 col-xs-offset-5 col-sm-offset-0 col-sm-5 col-sm-pull-2 phone_box">
						<div class="phone_msg">
							<img src="/Public/images/phone.png">
							<div>
								<small>客服时间：+09:00-18:00</small><br>
								<span class="orange">400-996-0976</span>
							</div>
						</div>
					</div> -->
<!-- 					<div class="col-xs-7 col-lg-8">
						<div class="col-xs-12 col-sm-4 wechat_code">
							<img src="/Public/images/wechat.png" class="center-block">
						</div>
						<div class="col-xs-12 col-sm-8 phone_box">
							<div class="phone_msg">
								<img src="/Public/images/phone.png">
								<div>
									<small>客服时间：+09:00-18:00</small><br>
									<span class="orange">400-996-0976</span>
								</div>
							</div>
						</div>
					</div> -->
				</div>
			</div>
		</div>
	</footer>
<!--footer 结束-->
</body>
</html>