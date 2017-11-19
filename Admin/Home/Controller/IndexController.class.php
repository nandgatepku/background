<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $this->display();
        // $this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
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
                    $select = $user->query("select *from admin where name='$uname' and pwd='$upwd'"); // 执行查询
                    if ($select) {// 如果存在该用户
                        //将用户名和密码保存在session中
                        session_start();
                        $_SESSION['uname'] = $uname;
                        $_SESSION['upwd'] = $upwd;
                        //跳转到用户中心
                        $this->redirect('Index/show', '', 2, '登录成功！前往管理后台!...页面跳转中...');
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

        if(isset($_POST['re'])){
            $this->redirect('Index/index','',0,'...刷新界面...');
        }
    }




    public function show(){
        //获取当前用户信息
        session_start();
        $uname=$_SESSION['uname'];
        //执行查询用户信息
        $cnm=$_POST['cnm'];
        $cwx=$_POST['cwx'];
        $user=M();
        $select=$user->query("select *from admin where name='$uname' ");
        $this->assign('info',$select);              // 传递变量
        $this->display();// 显示用户信息展示页面

        if(isset($_POST['excel'])){
            $str = date ( 'Ymdhis' );
            $ename=$str.'Excelfile';    //生成的Excel文件文件名
            $edata= M("users");   //查出数据
            $edataa = $edata -> select();
            $res=push($edataa,$ename);
        }

        if(isset($_POST['epdf'])){
            $strp = date ( 'Ymdhis' );
            $pname=$strp.'Pdffile';    //生成的Excel文件文件名
            $pdata= M("users");   //查出数据
            $pdata = $pdata -> where($map)->order('id')->select();
            $res=export_pdf($pdata,$pname);
        }

        if(isset($_POST['load'])){
            if (! empty ( $_FILES ['file_stu'] ['name'] ))
            {
                $tmp_file = $_FILES ['file_stu'] ['tmp_name'];
                $file_types = explode ( ".", $_FILES ['file_stu'] ['name'] );
                $file_type = $file_types [count ( $file_types ) - 1];
                /*判别是不是.xls文件，判别是不是excel文件*/
                if (strtolower ( $file_type ) != "xls")
                {
                    $this->error ( '不是Excel文件，重新上传' );
                }
                /*设置上传路径*/
                $savePath = "./Public/Xlsupload/";
                /*以时间来命名上传的文件*/
                $str = date ( 'Ymdhis' );
                $file_name = $str . "." . $file_type;
                /*是否上传成功*/
                if (! copy ( $tmp_file, $savePath . $file_name ))
                {
                    $this->error ( '上传失败' );
                }
                $res = uxlsread ( $savePath . $file_name );
                //spl_autoload_register ( array ('Think', 'autoload' ) );
                /*对生成的数组进行数据库的写入*/
                $flagt=0;
                foreach ( $res as $k => $v )
                {
                    if ($k != 0 && $flagt<=10000)
                    {
                        $data ['name'] = $v [0];
                        $data ['pwd'] =  '888888' ;
                        $data ['wechat'] = $v [1];
                        $result = M ( "users" )->add ( $data );
                        if (! $result)
                        {
                            $this->error ( '导入数据库失败' );
                        }
                        $flagt++;
                    }
                    if ($flagt>10000)
                    {
                        $this->error ( '只导入前10000条数据' );
                    }
                }
                $this->success('成功上传'.$flagt.'条数据');
            }
        }

        if(isset($_POST['cxwx'])){
            $cnm=$_POST['cnm'];
            $icxwx = $user -> query("select wechat from users where name='$cnm' ");
            $this->assign('infowechat',$icxwx);
            var_dump($icxwx);
        }
        if(isset($_POST['cxnm'])){
            $cwx=$_POST['cwx'];
            $icxnm = $user -> query("select name from users where wechat='$cwx' ");
            $this->assign('infoname',$icxnm);
            var_dump($icxnm);
        }
        if(isset($_POST['userh'])){
            $this->redirect('Index/userh','',1,'前往用户列表...页面跳转中...');
        }

        if(isset($_POST['back'])){
            $this->redirect('Index/index','',2,'退出成功!返回主界面...页面跳转中...');
        }
    }

    public function userh()
    {
        session_start();
        $uname=$_SESSION['uname'];
        $user=M();
        $select=$user->query("select *from admin where name='$uname' ");
        $this->assign('info',$select);              // 传递变量
//        $this->display();// 显示用户信息展示页面

        $Data = M("users"); // 实例化Data数据对象
        import('ORG.Util.Page');// 导入分页类
        $count      = $Data->where($map)->count();// 查询满足要求的总记录数 $map表示查询条件
        $Page       =  new \Think\Page($count,2);// 实例化分页类 传入总记录数

        $Page->setConfig('prev', "上一页");//上一页
        $Page->setConfig('next', '下一页');//下一页
        $Page->setConfig('first', '首页');//第一页
        $Page->setConfig('last', "末页");//最后一页
        $Page -> setConfig ( 'theme', '%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%' );
        // 进行分页数据查询
        $nowPage = isset($_GET['p'])?$_GET['p']:1;
        $show       = $Page->show();// 分页显示输出
        $list = $Data->where($map)->order('id')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('list',$list);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出
        $this->display();

        if(isset($_POST['back'])){
            $this->redirect('Index/show','',2,'返回管理后台...页面跳转中...');
        }
    }
}


