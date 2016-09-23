<?php
namespace Home\Model;
use Think\Model\RelationModel;

class FansUserModel extends RelationModel {
    protected $_validate = array(
        array('username','require','账号不能为空'), //默认情况下用正则进行验证
        array('username','','帐号名称已经存在！',0,'unique',1), // 在新增的时候验证name字段是否唯一
        array('username','checkphone','手机格式错误',1,'callback',0), //默认情况下用正则进行验证
        array('password','require','请输入密码',0), //默认情况下用正则进行验证
        array('state','require','请同意人人在线注册协议',1,'',1), //默认情况下用正则进行验证
        array('username','checkName','帐号错误！',1,'callback',4),  // 只在登录时候验证
        array('password','checkPwd','密码错误！',1,'callback',4), // 只在登录时候验证
    );

    protected $_link = array(
         'Archives'  =>  array(
             'mapping_type'     => self::HAS_ONE,
             'class_name'       => 'Archives',
             'foreign_key'      => 'fans_user_id',
             'condition'        => 'status',
         ),
    );
    
    public function checkphone($username){
        return (preg_match_all("/1[3,5,8,7]{1}[0-9]{1}[0-9]{8}|0[0-9]{2,3}-[0-9]{7,8}(-[0-9]{1,4})?/", $username) == 1) ? true : false;
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