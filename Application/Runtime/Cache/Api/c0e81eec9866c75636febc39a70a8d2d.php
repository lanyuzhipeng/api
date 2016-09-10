<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">

<head>
    <title>登录操作</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <script type="text/javascript" src="/Public/js/jquery.js"></script>
    <style type="text/css">

    </style>
</head>

<body>
<form action="<?php echo U('register');?>" method="post" name="cms" onsubmit="return loginok(this)">
    <div class="form-control">
        <label for="login_name">用户名</label>
        <input type="text" name="username" id="login_name" placeholder="用户名" />
    </div>
    <div class="form-control">
        <label for="login_pwd">密码</label>
        <input type="password" name="password" id="login_pwd" placeholder="密码" />
    </div>
    <div class="form-control">
        <label for="email">邮箱</label>
        <input type="text" name="mail" placeholder="邮箱地址" />
    </div>
    <div class="form-control">
        <input type="submit" value="提交" />
    </div>

</form>
    <div></div>
</body>

</html>