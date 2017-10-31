<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPEhtml>
<!-- 用户注册界面 -->
<html>
<head>
    <meta charset="utf-8">
    <title>用户注册界面</title>
    <link rel="stylesheet" type="text/css"href="/mytp/login/Home/Public/css/style.css">
</head>
<body>
<div id="mainzhuce">
<h2 align="center">用户注册中心</h2>
<form action="/dexin/index.php/Home/Index/zhuce" method="post">
<table id="tbdl">
<tr>
    <td>用户名:</td>
    <td><input type="text" name="uname" size="20"></td>
</tr>
<tr>
    <td>密码：</td>
    <td><input type="password" name="upwd"></td>
</tr>
<tr>
    <td>微信：</td>
    <td><input type="text" name="uwechat"></td>
</tr>
<tr>
    <td colspan="2"><center>
    <input type="submit"name="sub" value="注册">
    <input type="reset"name="ret" value="重置">
        <input type="submit"name="back" value="返回">
</center>
    </td>
</tr>
</table>
</form>
</div>
</body>
</html>