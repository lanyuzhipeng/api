<?php
namespace Api\Controller;
use Think\Controller;
class UserController extends Controller {
  public function index()
  {
    $this->display();
  }
   //展示注册表单
  public function register(){
    // echo "aaa";
   
    //判断是否为post提交表单，如果是处理表单数据
    if(IS_POST){
      //接收表单数据
      $username = I('post.username');
      $password = md5(I('post.password'));
      $mail = I('post.mail');
      $salt = md5(time());
      //组合插入的数据
      $data = array(
        'username' => $username,
        'password' => $password,
        'email'    => $mail,
        'salt'     => $salt
        );
      //实例化user表
      $user = M('user');
      //插入数据
      $rs = $user->add($data);
      dump($mail);
      if($rs) {
        $sendRs = sendMail("产品激活邮件","<a href='http://www.baidu.com'>点击链接激活产品</a>", $mail);
        if ($sendRs === true) {
          $this->success('注册成功,请到邮箱激活用户', U('User/login'), 3);
        } else {
          $this->error('注册成功,发送激活邮件失败' . $sendRs, U('User/register'), 1000000);
        }        
      } else {
        $this->error('注册失败', U('User/register'), 3);
      }
    } else {
      //如果不是提交表单，就加载页面
      $this->display();
    }
   }
}