<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title></title>
	<script type="text/javascript" src="/Public/js/jquery.js"></script>
	<script type="text/javascript">
	var itime = 59;	//定义一个变量，倒计时变化从59秒开始
	function getTime() {
		if(itime >= 0) {
			if (itime == 0) {
				//倒计时为0时，清除计时器
				clearTimeout(act);
				//设置按钮为初始状态
				$("#getCodeBtn").val('免费获取手机验证码').attr('disabled', false);
				itime = 59;
			} else {
				//延迟一秒执行该函数
				var act = setTimeout('getTime()', 1000);
				//把倒计时的秒显示在按钮中
				$("#getCodeBtn").val('还剩' + itime + '秒');
				itime = itime - 1;
			}
		}
	}
		$(function() {
			$('#getCodeBtn').click(function() {
				var telphone = $('#telphone').val();
				$.ajax({
					type: 'get',
					// url:"/index.php/Api/Index/sendCode",
					url:"<?php echo U('sendCode');?>",
					data:"telphone=" + telphone,
					success:function(msg) {
						// alert(msg);
						//判断调用短信发送接口是否成功
						// if(msg == 1) {
						// 	alert('短信验证码已经发送成功');
						// 	$("#getCodeBtn").attr('disabled', true);
						// 	getTime();
						// } else {
						// 	alert('失败');
						// }
						alert(msg);
					}
				});
			});
		});
	</script>
</head>
<body>
<form action="<?php echo U('register');?>" method="post">
	<table>
		<tr>
			<td>姓名</td>
			<td>
				<input type="text" name="name" id="name" />
			</td>
		</tr>
		<tr>
			<td>手机</td>
			<td>
				<input type="text" name="telphone" id="telphone" />
			</td>
		</tr>
		<tr>
			<td>验证码</td>
			<td>
				<input type="text" name="checkcode" />
				<input type="button" value="免费获取手机验证码" id="getCodeBtn" />
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<input type="reset" value="重填" />
				<input type="submit" value="注册" />
			</td>
		</tr>
	</table>
</form>
</body>
</html>