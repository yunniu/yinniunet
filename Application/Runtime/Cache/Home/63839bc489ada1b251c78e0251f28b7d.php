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
  <title>商品列表</title>
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
<!--大图-->
<div>
	<img src="/Public/images/goods_list_pic.png" width="100%">
</div>
<!--商品列表-->
<div class="goods_list">
	<div class="w90">
		<div class="container-fluid">
			<div class="goods_header text-center">
				<div class="row">
					<div class="col-xs-12 col-sm-7">
						<ul id="childCate">
							<li class="grey">筛选:</li>
							<li><a href="javascript:void(0)" class="sort_active" data-id="<?php echo ($_GET['cate_id']); ?>" onclick="changeSelect(this)">全部</a></li>
							<?php if(is_array($childCateList)): $i = 0; $__LIST__ = $childCateList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="javascript:void(0)" data-id="<?php echo ($vo["id"]); ?>" onclick="changeSelect(this)"><?php echo ($vo["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
						</ul>
					</div>
					<div class="col-xs-12 col-sm-5">
						<ul class="sort" id="sortGoods">
							<li class="grey">排序:</li>
							<li><a href="javascript:void(0)" class="hot_active" onclick="sortGoods(this)" data-val="is_new">最新</a></li>
							<li><a href="javascript:void(0)" onclick="sortGoods(this)" data-val="is_hot">热门</a></li>
							<li><a href="javascript:void(0)" onclick="sortGoods(this)" data-val="sales_sum">销量</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="goods_content">
				<div class="row" id="goodsList">
					<?php if(is_array($newGoodsList)): $i = 0; $__LIST__ = $newGoodsList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($i % 2 );++$i;?><div class="col-xs-6 col-sm-3">
							<div class="bg_white">
								<a href="/index.php/Home/Goods/goods_detail/goods_id/<?php echo ($vo2["goods_id"]); ?>/agent_id/<?php echo (session('agent_code')); ?>"><img data-echo="<?php echo ($vo2["original_img"]); ?>" alt="Photo" src="/Public/images/blank.gif"></a>
								<div class="clearfix">
									<span class="goods_price">&yen;<?php echo ($vo2["shop_price"]); ?></span>
									<button class="btn orange_btn pull-right">
										<span class="glyphicon glyphicon-shopping-cart"></span>加入
									</button>
								</div>
								<a href="/index.php/Home/Goods/goods_detail/goods_id/<?php echo ($vo2["goods_id"]); ?>/agent_id/<?php echo (session('agent_code')); ?>"><?php echo ($vo2["goods_name"]); ?></a>
							</div>
						</div><?php endforeach; endif; else: echo "" ;endif; ?>
				</div>
			</div>
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
<script>
	//懒加载
	function delay_init(){
		echo.init({
			offset: 100,
			throttle: 250,
			unload: false,
			callback: function (element,op) {
				console.log(element, 'has been', op + 'ed')
			}
		});
	}

	//调用懒加载
	$(function(){
		delay_init();
	});

	function changeSelect(obj){
		//改变筛选的选中状态。
		$.each($(obj).parent().parent().children(),function(k,v){
			if($(v).children().attr('class') == "sort_active"){
				$(v).children().attr('class','')
			}
		});
		$(obj).attr('class','sort_active');

		$.each($("#sortGoods li"),function(k,v){
			if($(v).children().attr('class') == "hot_active"){
				$(v).children().attr('class','')
			}
		});
		$("#sortGoods li").eq(1).children().attr('class','hot_active');

		var $cate_id = $(obj).data("id");
		//console.log($cate_id);

		//ajax请求后台数据
		$.ajax({
			url:"/index.php/Home/Goods/getSelectGoods/agent_id/<?php echo (session('agent_code')); ?>/cate_id/"+$cate_id,
			dataType:"json",
			success:function(msg){
				if(msg.code == 1){
					$('#goodsList').html("");
					$.each(msg.data,function(k,v){
//						if(k<8){
//							var str = '<div class="col-xs-6 col-sm-3"><div class="bg_white">'
//									+'<a href="/index.php/Home/Goods/goods_detail/agent_id/<?php echo (session('agent_code')); ?>/goods_id/'+v.goods_id+'"><img src="'+v.original_img+'"></a>'
//									+'<div class="clearfix">'
//									+'<span class="goods_price">&yen;'+v.shop_price+'</span>'
//									+'<button class="btn green_btn pull-right">'
//									+'<span class="glyphicon glyphicon-shopping-cart"></span>已加入</button></div>'
//									+'<a href="/index.php/Home/Goods/goods_detail/agent_id/<?php echo (session('agent_code')); ?>/goods_id/'+v.goods_id+'">'+v.goods_name+'</a></div></div>';
//						}else{
							var str = '<div class="col-xs-6 col-sm-3"><div class="bg_white">'
									+'<a href="/index.php/Home/Goods/goods_detail/agent_id/<?php echo (session('agent_code')); ?>/goods_id/'+v.goods_id+'"><img data-echo="'+v.original_img+'" alt="Photo" src="/Public/images/blank.gif" ></a>'
									+'<div class="clearfix">'
									+'<span class="goods_price">&yen;'+v.shop_price+'</span>'
									+'<button class="btn green_btn pull-right">'
									+'<span class="glyphicon glyphicon-shopping-cart"></span>已加入</button></div>'
									+'<a href="/index.php/Home/Goods/goods_detail/agent_id/<?php echo (session('agent_code')); ?>/goods_id/'+v.goods_id+'">'+v.goods_name+'</a></div></div>';
//						}
						//console.log(v.original_img);
						$('#goodsList').append(str);
					});
					delay_init();
				}else{
					$('#goodsList').html("<span>没有相关数据<span/>");
				}
			},
			error:function(){
				alert("出错了");
			}
		});
	}

	function sortGoods(obj){
		//改变筛选的选中状态。
		$.each($(obj).parent().parent().children(),function(k,v){
			if($(v).children().attr('class') == "hot_active"){
				$(v).children().attr('class','');
			}
		});
		$(obj).attr('class','hot_active');
		var val = $(obj).data('val');

		//获取分类id
		var cate_id = '';
		$.each($("#childCate li"),function(k,v){
		if($(v).children().attr('class') == "sort_active"){
			cate_id = $(v).children().data('id');
		}
	});

		//ajax请求后台数据
		$.ajax({
			url:"/index.php/Home/Goods/getSortGoods/agent_id/<?php echo (session('agent_code')); ?>",
			type:'get',
			data:{'val':val,'cate_id':cate_id},
			dataType:"json",
			success:function(msg){
				console.log(msg);
				if(msg.code == 1){
					$('#goodsList').html("");
					$.each(msg.data,function(k,v){
//						if(k<8){
//							var str = '<div class="col-xs-6 col-sm-3"><div class="bg_white">'
//									+'<a href="/index.php/Home/Goods/goods_detail/agent_id/<?php echo (session('agent_code')); ?>/goods_id/'+v.goods_id+'"><img src="'+v.original_img+'"></a>'
//									+'<div class="clearfix">'
//									+'<span class="goods_price">&yen;'+v.shop_price+'</span>'
//									+'<button class="btn green_btn pull-right">'
//									+'<span class="glyphicon glyphicon-shopping-cart"></span>已加入</button></div>'
//									+'<a href="/index.php/Home/Goods/goods_detail/agent_id/<?php echo (session('agent_code')); ?>/goods_id/'+v.goods_id+'">'+v.goods_name+'</a></div></div>';
//						}else{
							var str = '<div class="col-xs-6 col-sm-3"><div class="bg_white">'
									+'<a href="/index.php/Home/Goods/goods_detail/agent_id/<?php echo (session('agent_code')); ?>/goods_id/'+v.goods_id+'"><img data-echo="'+v.original_img+'" alt="Photo" src="/Public/images/blank.gif" ></a>'
									+'<div class="clearfix">'
									+'<span class="goods_price">&yen;'+v.shop_price+'</span>'
									+'<button class="btn green_btn pull-right">'
									+'<span class="glyphicon glyphicon-shopping-cart"></span>已加入</button></div>'
									+'<a href="/index.php/Home/Goods/goods_detail/goods_id/'+v.goods_id+'">'+v.goods_name+'</a></div></div>';
//						}
						//console.log(v.original_img);
						$('#goodsList').append(str);
					});
					delay_init();
				}else{
					$('#goodsList').html("<span>没有相关数据<span/>");
				}
			},
			error:function(){
				alert("出错了");
			}
		});
	}
</script>