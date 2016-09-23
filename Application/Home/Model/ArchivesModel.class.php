<?php
namespace Home\Model;
use Think\Model;

class ArchivesModel extends Model {
    protected $_validate = array(
        array('name','require','请输入姓名'), //默认情况下用正则进行验证
        // array('identity','require','请输入身份证号'), //默认情况下用正则进行验证
        array('identity','identity','身份证号格式错误',1,'callback',0), //默认情况下用正则进行验证
        array('urgent','require','请输入紧急联系人'), //默认情况下用正则进行验证
        array('urgent_phone','checkphone','手机格式错误',1,'callback',0), //默认情况下用正则进行验证
        array('education','require','请选择学历'), //默认情况下用正则进行验证
        array('occupation','require','请输入职业'), //默认情况下用正则进行验证
        array('carrying','require','请选择出行方式'), //默认情况下用正则进行验证
        array('address','require','请输入详细地址'), //默认情况下用正则进行验证
        array('id_a','require','请上传证件照'), //默认情况下用正则进行验证
        array('id_b','require','请上传证件照'), //默认情况下用正则进行验证
        array('id_c','require','请上传证件照'), //默认情况下用正则进行验证
        array('id_d','require','请上传证件照'), //默认情况下用正则进行验证
        array('source','require','请选择获知来源'), //默认情况下用正则进行验证
    );

    protected $_auto = array ( 
        array('openid','setOpeind',3,'callback'), // 对name字段在新增和编辑的时候回调getName方法
        array('fans_user_id','setId',3,'callback'), // 对name字段在新增和编辑的时候回调getName方法
        array('createtime','time',3,'function'), // 对name字段在新增和编辑的时候回调getName方法
        array('id_a','saveMedia',3,'function'), //默认情况下用正则进行验证
        array('id_b','saveMedia',3,'function'), //默认情况下用正则进行验证
        array('id_c','saveMedia',3,'function'), //默认情况下用正则进行验证
        array('id_d','saveMedia',3,'function'), //默认情况下用正则进行验证
    );
    
    protected function setOpeind(){
        $UserInfo = session(C(HOME_SESSION));
        return $UserInfo['openid'];
    }

    protected function setId(){
        $UserInfo = session(C(HOME_SESSION));
        return $UserInfo['id'];
    }

    protected function checkphone($username){
        return (preg_match_all("/1[3,5,8,7]{1}[0-9]{1}[0-9]{8}|0[0-9]{2,3}-[0-9]{7,8}(-[0-9]{1,4})?/", $username) == 1) ? true : false;
    }

    protected function identity($identity){
        return (preg_match_all("/^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$|^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/",$identity) == 1) ? true : false;
    }
}
?>