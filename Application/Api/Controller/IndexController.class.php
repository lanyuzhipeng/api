<?php
namespace Api\Controller;
use Think\Controller;
include_once("./vendor/CCPRestSmsSDK.php");
class IndexController extends Controller {
    public function index(){
        $this->display();
    }
    //创建json
    public function createJson()
    {
    	$personArray = array(
    		'name' => 'Tom',
    		'age'  => 20,
    		'job'  => 'php',
    		);
    	$personArray = json_encode($personArray);
    	dump($personArray);
    	echo '<br />';
    	echo $personArray;
    }
    //解析json
    public function readJson()
    {
    	$personJson = '{"name":"Tom","age":20,"job":"php"}';
    	$personArray =json_decode($personJson, true);
    	$personObj =json_decode($personJson);
    	dump($personArray);
    	echo "<br />";
    	echo "name:" . $personArray['name'];
		echo "<br />";
    	dump($personObj);
		echo "<br />";
    	echo "name:" . $personObj->name;
    }
    //创建XML
    public function createXML()
    {
    	$str = '<?xml version="1.0" encoding="utf-8"?>';
    	$str .= '<person>';
    	$str .= '<name>tom</name>';
    	$str .= '<age>20</age>';
    	$str .= '<job>php</job>';
    	$str .= '</person>';
    	//xml保存为文档
    	$rs = file_put_contents('./person.xml', $str);
    	// dump($rs);
    	echo $rs;
    }
    //读取XML
    public function readXML()
    {
    	//读取xml文档
    	$xmlStr = file_get_contents('./person.xml');
    	//解析xml为一个对象
    	$xmlObj = simplexml_load_string($xmlStr);
    	dump($xmlObj);
    	echo '<br />';
    	echo "name:" . $xmlObj->name;
    }
    public function getinfo()
    {
    	phpinfo();
    }
    public function testRequest()
    {
    	$url = 'https://www.baidu.com/';
    	$content = request($url);
    	var_dump($content);
    }
    //调用天气接口
    public function weather()
    {
        //接收地址参数
        $city = I('get.city');
        //接口地址
        $url = 'http://api.map.baidu.com/telematics/v2/weather?location='.$city.'&ak=B8aced94da0b345579f481a1294c9094';
        //发送请求
        $content = request($url,false);
        // dump($content);
        // 解析XML为一个对象
        $content = simplexml_load_string($content);
        echo '当前查询城市为：' . $content->currentCity . '<br />';
        echo '日期为：' . $content->results->result[0]->data . '<br />';
        echo '<img src="' . $content->results->result[0]->dayPictureUrl . '">' . '<br />';
        echo '<img src="' . $content->results->result[0]->nightPictureUrl . '">' . '<br />';
        echo '天气：' . $content->results->result[0]->weather  . '<br />';
        echo '风力：' . $content->results->result[0]->wind . '<br />';
        echo '温度区间：' . $content->results->result[0]->temperature . '<br />';
    }
    //调用号码归属地接口
    public function getAreaByPhone()
    {
        $num = I('get.phone');
        //接口地址
        $url = 'http://cx.shouji.360.cn/phonearea.php?number=' . $num;
        //发送请求
        $content = request($url, false);
        
        //处理返回值，转化为对象
        $contentObj = json_decode($content);
        // dump($contentObj);
        echo '当前查询的号码为：' . $num . '<br />';
        echo '当前查询的号码的省份为：' . $contentObj->data->province . '<br />';
        echo '当前查询的号码的城市为：' . $contentObj->data->city . '<br />';
        echo '当前查询的号码的运营商为：' . $contentObj->data->sp . '<br />';
    }



    //注册
    public function register()
    {
        //获取数据
        $this->display();
        // $post = I('post.');
        // $this.display();

    }
    //处理接收到的手机号，并执行发送验证码函数
    public function sendCode()
    {
        //获取手机号
        $telphone = I('get.telphone');
        //生成验证码
        $code = rand(100000, 999999);        
        //将验证码存入session
        session('code', $code);

        //主帐号,对应开官网发者主账号下的 ACCOUNT SID
        $accountSid= '8aaf070856d4826c0156d642c01403f9';
        //主帐号令牌,对应官网开发者主账号下的 AUTH TOKEN
        $accountToken= '5478fa43fe4f4619bd6c6d274eb8d3cc';
        //应用Id，在官网应用列表中点击应用，对应应用详情中的APP ID
        //在开发调试的时候，可以使用官网自动为您分配的测试Demo的APP ID
        $appId='8aaf070856d4826c0156d642c0d90400';
        //请求地址
        //沙盒环境（用于应用开发调试）：sandboxapp.cloopen.com
        //生产环境（用户应用上线使用）：app.cloopen.com
        $serverIP='sandboxapp.cloopen.com';
        //请求端口，生产环境和沙盒环境一致
        $serverPort='8883';
        //REST版本号，在官网文档REST介绍中获得。
        $softVersion='2013-12-26';

        //执行发送验证码的函数
        $res = $this->sendTemplateSMS($telphone, array($code, 1), "1", $accountSid,$accountToken,$appId,$serverIP,$serverPort,$softVersion);

        if($res){
            echo 1;
        }else{
            echo 0;
        }
    }
    /**
  * 发送模板短信
  * @param to 手机号码集合,用英文逗号分开
  * @param datas 内容数据 格式为数组 例如：array('Marry','Alon')，如不需替换请填 null
  * @param $tempId 模板Id,测试应用和未上线应用使用测试模板请填写1，正式应用上线后填写已申请审核通过的模板ID
  */
    function sendTemplateSMS($to,$datas,$tempId,$accountSid,$accountToken,$appId,$serverIP,$serverPort,$softVersion)
    {
         // 初始化REST SDK
         import('vendor.sms.REST');     
         $rest = new \REST($serverIP,$serverPort,$softVersion);
         $rest->setAccount($accountSid,$accountToken);
         $rest->setAppId($appId);

         // 发送模板短信
        // echo "Sending TemplateSMS to $to <br/>";
         $result = $rest->sendTemplateSMS($to,$datas,$tempId);
         if($result == NULL ) {
            return false;
         }
         if($result->statusCode!=0) {
             return false;
             //TODO 添加错误处理逻辑
         }else{
             return true;
             //TODO 添加成功处理逻辑
         }
    }

    //快递接口调用
    public function express()
    {
        $type = 'tiantian';
        $postid = '666781831520';
        //组装url
        $url = 'https://www.kuaidi100.com/query?type=' . $type . '&postid=' . $postid;
        //发送请求
        $content = request($url);
        //处理返回值
        $content = json_decode($content);
        // echo "<pre>";
        // var_dump($content);
        // echo "</pre>";
        foreach ($content->data as $key => $value) {
            echo '时间：' . $value->time . '########信息：' . $value->context . '<br/>';
        }
    }
 
    public function test()
    {
        $data = M('user')->select();
        dump($data);
    }
     // //邮件接口调用
    public function testSendMail()
    {
        $rs = sendMail('helloworld', '发送邮件的流程图：
php发送邮件，需要使用到一个叫做phpmailer的类库
            ', '626820844@qq.com');
//         dump($rs);
//         echo "<br/>";
        if($rs === true) {
            echo "发送成功";
        } else {
//             echo "发送失败" . $rs;
            echo $rs;
        }
    } 
    
    //展示地图生成器生成的地图
    public function showMap()
    {
        $this->display();          
    }
    //获取accetoken值
    public function getAccessToken()
    {
        $appID = "wx68503b287cd90a2e";
        $appsecret = "d537ed275591d5d2d5e243cc2cc8ee75";
        //组装url;
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appID . "&secret=" . $appsecret;
        //发送请求
        $rs = request($url);
        dump($rs);
        //处理返回数据
        $rs = json_decode($rs);
        $accessToken = $rs->access_token;
        echo $accessToken;
    }
}










