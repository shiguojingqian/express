<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {

	public function login(){
		if(!empty(session(C('ADMIN_SESSION')))) redirect(U('Index/index'));
		$this->display('Index/login');
	}
	
	 public function checkuser(){
		if(IS_POST){
            $UserModel = D('UserAdmin');
            !($UserModel->create($_POST,4)) && $this->error($UserModel->getError());
            $UserInfo = $UserModel->where(array('username'=>$_POST['username'],'status'=>1))->field('id,username')->find();
            if(empty($UserInfo)){
                $this->error('该账号已关闭');
            }
            session(C('ADMIN_SESSION'),$UserInfo);
            $this->success('登陆成功',U('Index/index'));
		}
	}
	
	protected function usersession(){
		$User = session('UserInfo'.$this->token);
		if(empty($User)) {
			return false;
		}
		return true;
	}

    public function outlogin(){
        if(IS_POST){
            $User = $this->usersession();
            if($User) {
                session('UserInfo'.$this->token,null);
                $url = U('Login/gologin');
                $this->success('退出成功',$url);
            }
        }
    } 
}