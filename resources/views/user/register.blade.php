<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
        <meta name="author" content="order by dede58.com"/>
		<title>用户注册</title>
		<link rel="stylesheet" type="text/css" href="{{URL::asset('css/login.css')}}">
		<script language="JavaScript" src="{{URL::asset('js/jquery.js')}}"></script>
	</head>
	<body>
		<form  method="post" action="{{URL::asset('doregister')}}">
			{{ csrf_field() }}
		<div class="regist">
			<div class="regist_center">
				<div class="regist_top">
					<div class="left fl">会员注册</div>
					<div class="right fr"><a href="/index" target="_self">小米商城</a></div>
					<div class="right fr"><a href="javascript:void(0)" id="regist">邮箱注册</a>||</div>
					<div class="clear"></div>
					<div class="xian center"></div>
				</div>
				<div class="regist_main center">
					<div class="username">手&nbsp;&nbsp;机&nbsp;&nbsp;号:&nbsp;&nbsp;<input class="shurukuang" type="tel" onkeyup="value=value.replace(/[^\d]/g,'')" name="tel" placeholder="请填写正确的手机号" id="tel" /><span></span></div>
					<div class="username">密&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;码:&nbsp;&nbsp;<input class="shurukuang" type="password" name="password" placeholder="请输入你的密码"/><span>请输入6位以上12位以下字符</span></div>
					
					<div class="username">确认密码:&nbsp;&nbsp;<input class="shurukuang" type="password" name="repassword" placeholder="请确认你的密码"/><span>两次密码要输入一致哦</span></div>
					<div class="username">
						<div class="left fl">验&nbsp;&nbsp;证&nbsp;&nbsp;码:&nbsp;&nbsp;<input class="yanzhengma" type="text" name="captcha" placeholder="请输入验证码"/></div>
						<div class="right fl"><img src="{{captcha_src()}}" style="cursor: pointer" onclick="this.src='{{captcha_src()}}'+Math.random()"></div>
						<div class="clear"></div>
					</div>
				</div>
				<div class="regist_submit">
					<input class="submit" type="submit" name="submit" value="立即注册" >
				</div>
				
			</div>
		</div>
		</form>
	</body>
</html>
<script>
	$(document).ready(function(){
		
		$('#regist').click(function(){
			var a = $(this).text();
			if (a=='邮箱注册') {
				$('.regist_main > div:first').html("邮&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;箱:&nbsp;&nbsp;<input class='shurukuang' type='text' name='mail' placeholder='请填写正确的邮箱' id='mail'/><span>请填写正确的邮箱</span>");
				$(this).text('手机号注册');
			}else{
				$('.regist_main > div:first').html("手&nbsp;&nbsp;机&nbsp;&nbsp;号:&nbsp;&nbsp;<input class='shurukuang' type='tel' name='tel' onkeyup=\"value=value.replace(/[^\\d]/g,'')\" placeholder='请填写正确的手机号' id='tel'/><span></span>");
				$(this).text('邮箱注册');
			}
		});

	});
</script>