<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPEhtml>
<!-- 用户信息界面 -->
<html>
<head>
    <meta charset="utf-8">
    <title>用户信息界面</title>
    <link rel="stylesheet" type="text/css"href="/mytp/login/Home/Public/css/style.css">
</head>
<body>
<div id="mainshow">
<h2 align="center">用户信息中心</h2>
<table id="tbinfo">
    <form action="/dexin/index.php/Home/Index/show"method="post">
<tr>
    <td>用户名：</td>
    <td><?php echo ($info[0]['name']); ?></td>
</tr>
<tr>
    <td>密码：</td>
    <td><?php echo ($info[0]['pwd']); ?></td>
</tr>
<tr>
    <td>微信：</td>
    <td><?php echo ($info[0]['wechat']); ?></td>
</tr>
    <tr>
        <tdcol span="2"><center>
            <input type="submit"name="xg" value="修改密码">
            <input type="submit"name="back" value="退出"></center>
            </td>
    </tr>
</table>
</div>
</body>
</html>