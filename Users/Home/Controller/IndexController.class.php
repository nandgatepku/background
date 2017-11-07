<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index()
    {
        $this->display();
    }
    public function denglu(){
        $uname=$_POST['uname']; // 获取用户名
        $upwd=$_POST['upwd'];   // 获取密码
        $uyzm=$_POST['uyzm'];  // 获取输入的验证码
        $inum=$_POST['inum'];  // 获取输入的验证码
        if (isset($_POST['sub'])) {
            if($uyzm == $inum) {
                if (!empty($uname) && !empty($upwd)) {//如果用户名和密码非空
                    $user = M();// 实例化模型
                    $select = $user->query("select *from users where name='$uname' and pwd='$upwd'"); // 执行查询
                    if ($select) {// 如果存在该用户
                        //将用户名和密码保存在session中
                        session_start();
                        $_SESSION['uname'] = $uname;
                        $_SESSION['upwd'] = $upwd;
                        //跳转到用户中心
                        $this->redirect('Index/show', '', 2, '登录成功！前往用户中心!...页面跳转中...');
                    } else {  // 如果用户不存在
                        $this->redirect('Index/index', '', 2, '用户名或密码错误!...页面跳转中...');
                    }
                } else { // 如果用户名或密码未填写
                    $this->redirect('Index/index', '', 2, '请填写用户名或密码!...页面跳转中...');
                }
            }else{
                $this->redirect('Index/index','',3,'验证码输入错误!请重新输入...页面跳转中...');
            }
        }
                // 如果点击注册按钮,跳转到注册页面
        if(isset($_POST['zc'])){
            $this->redirect('Index/zhuce','',2,'前往用户注册中心!...页面跳转中...');
        }
        if(isset($_POST['re'])){
            $this->redirect('Index/index','',0,'...刷新界面...');
        }
    }

    function zhuce()
    {
        $this->display();
        if (isset($_POST['sub'])) {
            $uname = $_POST['uname'];    // 用户名
            $upwd = $_POST['upwd'];      // 密码
            $uwechat = $_POST['uwechat'];       // 微信
            if (!empty($uname) && !empty($upwd)) {
                // 判断该用户是否已经注册
                $user1 = M();
                $select = $user1->query("select *from users where name='$uname'");
                if ($select) {// 如果存在该用户
                    $this->redirect('Index/zhuce', '', 2, '用户名已存在，请更换!...页面跳转中...');
                }
                // 注册
                $data = array(
                    'name' => $uname,
                    'pwd' => $upwd,
                    'wechat' => $uwechat,
                );
                $insert = M('users')->add($data);
                if ($insert) {   // 如果注册成功
                    // 将用户名密码保存在session中
                    session_start();
                    $_SESSION['uname'] = $uname;
                    $_SESSION['upwd'] = $upwd;
                    // 页面跳转
                    $this->redirect('Index/show', '', 2, '注册成功！前往用户中心!...页面跳转中...');
                } else {   // 如果注册失败
                    echo "<script>alert('注册失败！');</script>";
                }
            }
        }
        if (isset($_POST['back'])) {
            $this->redirect('Index/index', '', 2, '返回主界面...页面跳转中...');
        }
    }

    public function show(){
        //获取当前用户信息
        session_start();
        $uname=$_SESSION['uname'];
        $upwd=$_SESSION['upwd'];
        //执行查询用户信息
        $user=M();
        $select=$user->query("select *from users where name='$uname' and pwd='$upwd'");
        $this->assign('info',$select);              // 传递变量
        $this->display();// 显示用户信息展示页面
        if(isset($_POST['back'])){
            session(null);
            $this->redirect('Index/index','',2,'退出成功!返回主界面...页面跳转中...');
        }
        if(isset($_POST['xg'])){
            $this->redirect('Index/gai','',2,'前往修改密码!...页面跳转中...');
        }
    }

    public function gai(){
        //获取当前用户信息
        session_start();
        $uname=$_SESSION['uname'];
        $upwd=$_SESSION['upwd'];
        $newpwd=$_POST['newpwd'];
        //执行查询用户信息
        $select=M('users')->query("select *from users where name='$uname' and pwd='$upwd'");
        $this->assign('info',$select);              // 传递变量
        $this->display();// 显示用户信息展示页面
        if(isset($_POST['gai'])){
            $user1 = M();
            $gaimi = $user1->execute("UPDATE users SET pwd = '$newpwd' WHERE name = '$uname'");
            if ($gaimi){
                $this->redirect('Index/index','',2,'成功改密码!返回主界面...页面跳转中...');
            }else {
                echo "<script>alert('改密失败！');</script>";
            }

        }
        if(isset($_POST['back'])){
            $this->redirect('Index/show','',2,'返回用户界面...页面跳转中...');
        }
    }


}