<?php
namespace Admin\Controller;

use Think\Controller;
use Think\Auth;

class IndexController extends Controller {
	/* public function _initialize(){
       if(empty(session(C('ADMIN_SESSION')))) redirect(U('Login/login'));
        $not_check = array('Index/index', 'Index/login','Index/top','Index/leftnav','Index/shouye');
        if(ACTION_NAME == 'update' || ACTION_NAME == 'insert'){
            return true;
        }
        if (in_array(CONTROLLER_NAME . '/' . ACTION_NAME, $not_check)) {
            return true;
        }
        $auth = new Auth();
        if (!$auth->check(CONTROLLER_NAME . '/' . ACTION_NAME, $_SESSION[C('ADMIN_SESSION')]['id'])) {
            $this->error('暂无权限');
        }
    } */

    public function index(){
        $this->display('ht');
    }
}