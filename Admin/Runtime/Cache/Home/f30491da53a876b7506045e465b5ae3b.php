<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>完整用户列表页面</title>
</head>
<body>
<div id="mainshow">
    <h2 align="center">完整用户列表</h2>
    <table id="tbinfo">
        <form action="/dxwork/admin.php/Home/Index/userh"method="post"  enctype="multipart/form-data">
            <tr>
                <td>当前管理员：</td>
                <td><?php echo ($info[0]['name']); ?></td>
            </tr>
            <tr>
                <td>完整用户列表：</td>
            </tr>
            <table border="1" width="400" >
                <tr>
                    <td>id</td>
                    <td>name</td>
                    <td>wechat</td>
                </tr>
                <?php foreach ($list as $value): ?>
                <tr>
                    <td><?php echo $value['id']; ?></td>
                    <td><?php echo $value['name']; ?></td>
                    <td><?php echo $value['wechat']; ?></td>
                </tr>
                <?php endforeach ?>
            </table>
            <?php echo ($page); ?>
            <td>
                <input type="submit"name="back" value="返回">
            </td>

</body>
</html>