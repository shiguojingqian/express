<?php
namespace Admin\Model;
use Think\Model;

class UserAdminModel extends Model {
	protected $_validate = array(
		array('username','require','请补全信息'), //默认情况下用正则进行验证
        array('username','','帐号名称已经存在！',0,'unique',3), // 在新增的时候验证name字段是否唯一
		array('password','require','请补全信息',0), //默认情况下用正则进行验证
		array('repassword','password','确认密码不正确',0,'confirm'), // 验证确认密码是否和密码一致
        array('password','chunkPwd','不能使用原密码！',0,'callback',2),
        array('username','checkName','帐号错误！',1,'callback',4),  // 只在登录时候验证
        array('password','checkPwd','密码错误！',1,'callback',4), // 只在登录时候验证
	);
    
    protected $_auto = array ( 
        array('password','passmd5',3,'callback') , // 对password字段在新增和编辑的时候使md5函数处理
    );

    protected function passmd5($password = null){
        if($password != null) return MD5(MD5($password));
    }

    protected function chunkPwd($password){
        return !($this->password  == MD5(MD5($password)));
	}

    protected function checkName($username){
        return !empty($this->where(array('username'=>$username))->find());
    }

    protected function checkPwd($password){
        $password = MD5(MD5($password));
        return !empty($this->where(array('password'=>$password,array('username'=>$this->username)))->find());
    }
}
?>