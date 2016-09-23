<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function _initialize(){
        if(!isWeixinBrowser()){
            exit('请使用微信浏览器打开');
        }
        get_openid();
        // if(!empty(session(C('HOME_SESSION')))) redirect(U('Index/index'));
    }

    public function login(){
        $this->display('Index/login');
    }

    public function register(){
        if(IS_POST){
            $FansUserModel = D('FansUser');
            !($FansUserModel->create($_POST,1)) && $this->error($FansUserModel->getError());
            if(!($this->checkcode($_POST['code'],$_POST['username']))){ $this->error('验证码错误或已过期'); }
            unset($_POST['code']);
            $wxInfo = getWeixinUserInfo(get_openid());
            $data = $_POST;
            $data['password'] = MD5(MD5($_POST['password']));
            $data['openid'] = $wxInfo['openid'];
            $data['nickname'] = $wxInfo['nickname'];
            $data['htmlurl'] = $wxInfo['headimgurl'];
            $data['sex'] = $wxInfo['sex'];
            $data['creatime'] = time();
            ($FansUserModel->add($data)) ? $this->success('注册成功',U('Login/login')) : $this->error('注册失败');
            exit;
        }
        $this->display('Index/register');
    }

    public function gologin(){
        if(IS_POST){
            $FansUserModel = D('FansUser');
            !($FansUserModel->create($_POST,4)) && $this->error($FansUserModel->getError());
            $FansUserInfo = $FansUserModel->where(array('username'=>I('post.username'),'password'=>MD5(MD5(I('post.password')))))->field('password',true)->find();
            if($FansUserInfo){
                session(C('HOME_SESSION'),$FansUserInfo);
                $this->success('登陆成功',U('Personal/index'));
            }else{
                $this->error('登录失败');
            }
        }
    }

    public function code(){
        $CodeModel = M('code');
        empty(I('post.phone')) && $this->error('用户名不能为空');
        $where = array(
            'phone'     =>  I('post.phone'),
        );
        $CodeInfo = $CodeModel->where($where)->find();
        Vendor('sendSMS.SendTemplateSMS');
        $rsSms = new \SMSREST();
        if($CodeInfo['endtime'] > time()){
           $result = json_decode($rsSms->sendTemplateSMS($CodeInfo['phone'], $datas = array("{$CodeInfo['code']}") ,"114119"),true);
        }else{
            $data = array(
                'code'      => rand(10000,99999),
                'phone'     => I('post.phone'),
                'endtime'   => time() + 600,
                'startime'  => time(),
            );
            $result = json_decode($rsSms->sendTemplateSMS($data['phone'], $datas = array("{$data['code']}") ,"114119"),true);
            empty($CodeInfo) ? $CodeModel->add($data) : $CodeModel->where(array('id'=>$CodeInfo['id']))->save($data);
        }
        if($result['statusCode'] == 'SUCCESS'){
            $this->success('验证码已发送');
        }else if($result['errorCode'][0] == '160040'){
            $this->error('您的验证码验证已达上线,请明日再来');
        }
    }

    protected function checkcode($code = 0 , $phone = ''){
       $CodeInfo = M('code')->where(array('code'=>$code,'phone'=>$phone))->find();
       if(time() < $CodeInfo['endtime']){
           return true;
       }
       return false;
    }
}