<?php
namespace Home\Model;
use Think\Model\RelationModel;

class OrderListModel extends RelationModel {
    protected $_validate = array(
        array('name','require','请输入收件人'), //默认情况下用正则进行验证
        array('phone','checkphone','手机格式错误',1,'callback',0), //默认情况下用正则进行验证
        array('city_id','checkcity','请选择收货地址',1,'callback',0), //默认情况下用正则进行验证
        array('address','require','请输入详细地址'), //默认情况下用正则进行验证
    );

    protected $_link = array(
         'Order'  =>  array(
             'mapping_type'     => self::BELONGS_TO,
             'class_name'       => 'Order',
             'foreign_key'      => 'order_id',
         )
    );

    protected function checkphone($phone){
        return (preg_match_all("/1[3,5,8,7]{1}[0-9]{1}[0-9]{8}|0[0-9]{2,3}-[0-9]{7,8}(-[0-9]{1,4})?/", $phone) == 1) ? true : false;
    }

    protected function checkcity($city_id){
        foreach($city_id as $k => $v){
             if(empty($city_id[$k]))
                return false;
        }
        return true;
    }
}
?>