<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPEhtml>
<!-- 用户修改密码界面 -->
<html>
<head>
    <meta charset="utf-8">
    <title>修改密码界面</title>
    <link rel="stylesheet" type="text/css"href="/dexin/Home/Public/css/style.css">
</head>
<body>
<div id="mainxiugai">
    <form action="/dexin/index.php/Home/Index/xiugai"method="post">
    <h2 align="center">用户修改密码中心</h2>
    <table id="tbinfo">
        <tr>
            <td>用户名：</td>
            <td><?php echo ($info[0]['name']); ?></td>
        </tr>
        <tr>
            <td>原密码：</td>
            <td><?php echo ($info[0]['pwd']); ?></td>
        </tr>
        <tr>
            <td>新密码：</td>
            <td><input type="text" name="upwd"></td>
        </tr>
        <tr>
            <td>再次输入新密码：</td>
            <td><input type="text" name="upwd"></td>
        </tr>

        <tr>
            <td colspan="2"><center>
                <input type="submit"name="gai" value="确定">
                <input type="submit"name="back" value="退出"></center>
                </td>
        </tr>
    </table>
</div>
</body>
</html>