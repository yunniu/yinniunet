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
  <title>商品详情</title>
  <link rel="stylesheet" type="text/css" href="/Public/css/goods_detail.css">
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
                  <!--<div class="input-group">-->
                    <!--<input type="text" class="form-control" placeholder="请输入验证码">-->
                    <!--<div class="input-group-addon"><img src="/Public/images/num.png"></div>-->
                  <!--</div>-->
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
                  <!--<div class="input-group">-->
                    <!--<input type="text" class="form-control" placeholder="请输入验证码">-->
                    <!--<div class="input-group-addon"><img src="/Public/images/num.png"></div>-->
                  <!--</div>-->
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
<div class="w90">
	<div class="container-fluid">
		<!--当前位置-->
		<div class="clearfix  current_url">
			<div class="pull-right">
				<a href="javascript:history.go(-1)">返回</a>
			</div>
			<div>
				<ol class="breadcrumb">
					<span class="grey">当前位置:&nbsp;&nbsp;&nbsp;</span>
					<li>
						<a href="/index.php/Home/index/index/agent_id/<?php echo (session('agent_code')); ?>">首页</a>

					<?php if(is_array($nav)): $i = 0; $__LIST__ = $nav;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($i == count($nav)): ?><li>
								<a href="/index.php/Home/Goods/goods_detail/goods_id/<?php echo ($vo["id"]); ?>/agent_id/<?php echo (session('agent_code')); ?>"><?php echo ($vo["name"]); ?></a>
							</li>
						<?php else: ?>
							<li>
								<a href="/index.php/Home/Goods/index/cate_id/<?php echo ($vo["id"]); ?>/agent_id/<?php echo (session('agent_code')); ?>"><?php echo ($vo["name"]); ?></a>
							</li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
				</ol>
			</div>
		</div>
		<!--商品简介-->
		<div class="goods_intro">
			<div class="row">
				<div class="col-xs-12 col-sm-5 goods_pic">
					<div class="tab-content">
						<?php if(is_array($goodsImageList)): $i = 0; $__LIST__ = $goodsImageList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($i == 1): ?><div class="tab-pane fade in active" id="goods_<?php echo ($i); ?>">
									<img src="<?php echo ($vo["image_url"]); ?>" class="center-block"></div>
							<?php else: ?>
								<div class="tab-pane fade" id="goods_<?php echo ($i); ?>">
									<img src="<?php echo ($vo["image_url"]); ?>" class="center-block"></div><?php endif; endforeach; endif; else: echo "" ;endif; ?>
					</div>
					<ul class="nav nav-tabs">
						<?php if(is_array($goodsImageList)): $i = 0; $__LIST__ = $goodsImageList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($i == 1): ?><li class="active">
									<a href="#goods_<?php echo ($i); ?>" data-toggle="tab">
									<img src="<?php echo ($vo["image_url"]); ?>"></a>
								</li>
							<?php else: ?>
							<li class="">
								<a href="#goods_<?php echo ($i); ?>" data-toggle="tab">
									<img src="<?php echo ($vo["image_url"]); ?>"></a><?php endif; endforeach; endif; else: echo "" ;endif; ?>
					</ul>
				</div>
				<div class="col-xs-12 col-sm-6 col-sm-offset-1 goods_pic_right">
					<div class="row">
						<div class="col-xs-10 col-xs-offset-1 col-sm-11 col-sm-offset-0">
							<div class="goods_title">
								<h1><?php echo ($goods["0"]["goods_name"]); ?></h1>
								<?php if($goods[0]['is_new'] == 1): ?><span class="red">NEW!</span><?php endif; ?>
								<?php if($goods[0]['is_hot'] == 1): ?><span class="red">HOT!</span><?php endif; ?>
							</div>
						</div>
						<div class="col-xs-11 col-xs-offset-1 col-sm-12  col-sm-offset-0">
							价格:<span class="discount_price">&yen;<?php echo ($goods["0"]["shop_price"]); ?></span>
							<?php if($goods[0]['shop_price'] <= $goods[0]['market.price']): ?>&nbsp;&nbsp;<span class="original_cost">&yen;<?php echo ($goods["0"]["market_price"]); ?></span><?php endif; ?>
						</div>
						<div class="col-xs-5 col-xs-offset-1 col-sm-12  col-sm-offset-0">
							配送：送货上门
						</div>
						<div class="col-xs-5 col-xs-offset-1 col-sm-12  col-sm-offset-0">
							<?php if($goods[0]['is_free_shipping'] == 0): ?>运费：免运费
							<?php else: ?>
								运费：待计算<?php endif; ?>
						</div>
						<div class="col-xs-10 col-xs-offset-1 col-sm-12  col-sm-offset-0">
							<span>数量：</span>
							<div class="input-group">
								<span class="input-group-btn">
									<button class="btn" type="button" onclick="changeNum(this)">-</button>
								</span>
								<input type="text" class="form-control text-center" value="<?php echo ($goods_num); ?>" data-id="<?php echo ($goods["0"]["goods_id"]); ?>" size="3">
								<span class="input-group-btn">
									<button class="btn" type="button" onclick="changeNum(this)">+</button>
								</span>
							</div>
						</div>
						<div class="col-xs-5 col-xs-offset-1  col-sm-7 col-sm-offset-0">
							<button class="btn orange_btn buy_btn" onclick="promptlyBuy(this)" data-id="<?php echo ($goods["0"]["goods_id"]); ?>">立即购买</button>
						</div>
						<div class="col-xs-5 col-sm-7">
							<button class="btn green_btn buy_btn" onclick="addToCart(this)" data-id="<?php echo ($goods["0"]["goods_id"]); ?>" id="test"><span class="glyphicon glyphicon-shopping-cart"></span>&nbsp;加入购物车</button>
						</div>
						<div class="col-xs-11 col-xs-offset-1 col-sm-12 col-sm-offset-0">
							<a href="#"><img src="/Public/images/aliPay.png"></a>
							<a href="#"><img src="/Public/images/wechatPay.png"></a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--商品详情-->
		<div class="goods_msg">
			<ul class="nav nav-tabs">
			  <li class="active">
			  	<a href="#details" data-toggle="tab">商品详情</a>
			  </li>
			  <li>
			  	<a href="#comment" data-toggle="tab">商品评价</a>
			  </li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane fade in active" id="details">
					<?php echo (htmlspecialchars_decode($goods["0"]["goods_content"])); ?>
					<!--<img src="/Public/images/goods_details.png">-->
				</div>
				<div class="tab-pane fade" id="comment">
					<div class="comment_list">
						<div class="container-fluid">
							<div class="row">
								<div class="col-xs-12 col-sm-9">
									<span>到货速度很快，分量很足味道还可以，我标注了要日期新鲜的，果真收到货很新鲜赞一个</span>
								</div>
								<div class="col-xs-6 col-sm-2 col-sm-offset-1">v***e（匿名）</div>
								<div class="col-xs-6 comment_date">2016.07.13</div>
							</div>
						</div>
					</div>
					<div class="comment_list">
						<div class="container-fluid">
							<div class="row">
								<div class="col-xs-12 col-sm-9">
									<span>坚果味道很不错哦，颗粒很大，打开没有闻到油腻味，果实表面干爽，咬下去香香脆脆的，有果仁的自然清甜味道，表皮只有盐味，没有其它乱七八糟的调料味，感觉比较健康，个人感觉杏仁果最香，但也是附着盐最多的，有一点咸，其他的恰到好处。</span>
								</div>
								<div class="col-xs-6 col-sm-2 col-sm-offset-1">v***e（匿名）</div>
								<div class="col-xs-6 comment_date">2016.07.13</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	function changeNum(obj){
		var operator = $(obj).html();
		if(operator == '-'){
			var goods_id = $(obj).parent().next().data('id');
			var goods_num = $(obj).parent().next().val();
			var goods_num = goods_num-1;
			if(goods_num <= 1 ){
				goods_num = 1;
				$(obj).parent().next().val(goods_num);
			}else{
				$(obj).parent().next().val(goods_num);
			}
//			$.ajax({
//				url:"/index.php/Home/cart/changeGoodsNum/agent_id/<?php echo (session('agent_code')); ?>",
//				type:'post',
//				dataType:'json',
//				data:{'goods_id':goods_id,'operator':operator},
//				success:function(msg){
//					var goods_num = $(obj).parent().next().val();
//					console.log(goods_num);
//					console.log(msg);
//					var goods_num = goods_num-1;
//					console.log(goods_num);
//					if(goods_num <= 0 ){
//						goods_num = 0;
//						$(obj).parent().next().val(goods_num);
//					}else{
//						$(obj).parent().next().val(goods_num);
//					}
//				},
//				error:function(){
//					console.log("出错了");
//				}
//			});
		}else if(operator == '+'){
			var goods_id = $(obj).parent().prev().data('id');
			var goods_num = $(obj).parent().prev().val();
			$(obj).parent().prev().val(parseInt(goods_num)+1);
			console.log(goods_id);
//			$.ajax({
//				url:"/index.php/Home/cart/changeGoodsNum/agent_id/<?php echo (session('agent_code')); ?>",
//				type:'post',
//				dataType:'json',
//				data:{'goods_id':goods_id,'operator':operator},
//				success:function(msg){
//					var goods_num = $(obj).parent().prev().val();
//					console.log(goods_num);
//					$(obj).parent().prev().val(parseInt(goods_num)+1);
//				},
//				error:function(){
//					console.log("出错了");
//				}
//			});
		}
	}

	function addToCart(obj){
		var goods_id = $(obj).data('id');
		var goods_num = $(obj).parent().prev().prev().children().eq(1).children().eq(1).val();
		$.ajax({
			url:"/index.php/Home/cart/addToCart/agent_id/<?php echo (session('agent_code')); ?>/goods_num/"+goods_num,
			type:"get",
			dataType:"json",
			data:{"goods_id":goods_id},
			success:function(msg){
				//console.log(msg);
				if(msg.code == 0){
					//alert(msg.msg);
					$("#login").modal('show');
				}else{
					alert('加入成功');
				}
			},
			error:function(){
				alert("网络繁忙。。。");
			}
		});
	}

	function promptlyBuy(obj){
		var goods_id = $(obj).data('id');
		var goods_num = $(obj).parent().prev().children().eq(1).children().eq(1).val();
		//console.log(goods_num);
		$.ajax({
			url:'/index.php/Home/order/promptlyBuy/agent_id/<?php echo (session('agent_code')); ?>',
			type:"get",
			dataType:"json",
			data:{'goods_id': goods_id,'goods_num':goods_num},
			success:function(msg){
				//console.log(msg);
				if(msg.code == 0){
					//alert(msg.msg);
					$("#login").modal('show');
				}else{
					location.href="/index.php/Home/order/address/agent_id/<?php echo (session('agent_code')); ?>";
				}
			},
			error:function(){
				alert("网络繁忙。。。");
			}
		});
	}
</script>
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