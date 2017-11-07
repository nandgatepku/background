<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPEhtml>
<!-- 用户登录界面 -->
<html>
<head>
    <meta charset="utf-8">
    <title>后台管理员登录界面</title>
    <link rel="stylesheet" type="text/css"href="/dxwork/Public/css/indexstyle.css">
</head>
<body>
<div id="main">
<h2 align="center">管理员登录中心</h2>
<form action="/dxwork/admin.php/Home/Index/denglu"method="post">
<table id="tbdl">
<tr>
    <td>用户名：</td>
    <td><input type="text" name="uname" size="20" onblur="if(this.value == '')this.value='admin';" onclick="if(this.value == 'admin')this.value='';" value="admin"></td>
</tr>
<tr>
    <td>密码：</td>
    <td><input type="password" name="upwd"></td>
</tr>

    <tr>
        <td>验证图片：</td>
        <?php
 srand( microtime() * 1000000 ); $inum = rand( 1, 9 ); $image_file="http://localhost/dxwork/Public/images/" . $inum . ".jpg"; ?>
        <td><img src="<?php echo ($image_file); ?>" /></td>
    </tr>
    <input type="hidden" name="inum" value="<?php echo $inum ?>">
    <tr>
        <td>验证码：</td>
        <td><input type="text" name="uyzm"></td>
    </tr>

<tr>
    <td colspan="2"><center>
    <input type="submit"name="sub" value="登录">
    <input type="submit"name="re" value="刷新">
    </td>
</tr>
</table>
</form>
</div>
</body>
</html>