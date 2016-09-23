<?php
namespace Home\Model;
use Think\Model\RelationModel;

class SendModel extends RelationModel {
    protected $_validate = array(
        array('sender_name','require','寄件人不能为空'), //默认情况下用正则进行验证
        array('sender_mobile','checkphone','手机格式错误',1,'callback',0), //默认情况下用正则进行验证
        array('sender_city','checkcity','缺少地址参数',1,'callback',0), //默认情况下用正则进行验证
        array('sender_address_detail','require','详细地址不能为空'), //默认情况下用正则进行验证
        array('receiver_name','require','收件人不能为空'), //默认情况下用正则进行验证
        array('receiver_mobile','checkphone','手机格式错误',1,'callback',0), //默认情况下用正则进行验证
        array('receiver_city','checkcity','缺少地址参数',1,'callback',0), //默认情况下用正则进行验证
        array('receiver_address_detail','require','详细地址不能为空'), //默认情况下用正则进行验证
        array('goods_name','require','运输货物不能为空',0), //默认情况下用正则进行验证
        array('weight','require','重量不能为空',0), //默认情况下用正则进行验证
        array('fetchtime','require','预约时间不能为空',0), //默认情况下用正则进行验证
    );

    protected function checkphone($phone){
        return (preg_match_all("/1[3,5,8,7]{1}[0-9]{1}[0-9]{8}|0[0-9]{2,3}-[0-9]{7,8}(-[0-9]{1,4})?/", $phone) == 1) ? true : false;
    }

    protected function checkcity($city){
        foreach($city as $k => $v){
            if(empty($city[$k])){
               return false;
            }
        }
        return true;
    }
}
?>