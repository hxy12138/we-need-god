<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
        <meta name="author" content="order by dede58.com"/>
		<title>会员登录</title>
		<link rel="stylesheet" type="text/css" href="{{URL::asset('css/login.css')}}">
		
	</head>
	<body>
		<!-- login -->
		<div class="top center">
			<div class="logo center">
				<a href="/index" target="_blank"><img src="{{URL::asset('image/mistore_logo.png')}}" alt=""></a>
			</div>
		</div>
		<form  method="post" action="{{URL::asset('/dologin')}}" class="form center">
			{{ csrf_field() }}
		<div class="login">
			<div class="login_center">
				<div class="login_top">
					<div class="left fl">会员登录</div>
					<div class="right fr">您还不是我们的会员？<a href="{{URL::asset('/register')}}" target="_self">立即注册</a></div>
					<div class="clear"></div>
					<div class="xian center"></div>
				</div>
				<div class="login_main center">
					<div class="username">登录号:&nbsp;<input class="shurukuang" type="text" name="username" placeholder="请输入你的手机号或邮箱"/></div>
					<div class="username">密&nbsp;&nbsp;&nbsp;&nbsp;码:&nbsp;<input class="shurukuang" type="password" name="password" placeholder="请输入你的密码"/></div>
					<div class="username">
						<div class="left fl">验证码:&nbsp;<input class="yanzhengma" type="text" name="captcha" placeholder="请输入验证码"/></div>
						<div class="right fl"><img src="{{captcha_src()}}" style="cursor: pointer" onclick="this.src='http://www.phpsp.com/captcha/default?'+Math.random()"></div>
						<div class="clear"></div>
					</div>
				</div>
				<div class="login_submit">
					<input class="submit" type="submit" name="submit" value="立即登录" >
				</div>
				
			</div>
		</div>
		</form>
		<footer>
			<div class="copyright">简体 | 繁体 | English | 常见问题</div>
			<div class="copyright">小米公司版权所有-京ICP备10046444-<img src="{{URL::asset('image/ghs.png') }}" alt="">京公网安备11010802020134号-京ICP证110507号</div>

		</footer>
	</body>
</html>