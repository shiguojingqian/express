<?php
namespace Admin\Model;
use Think\Model\RelationModel;

class DotModel extends RelationModel {
	protected $_validate = array(
		array('dot_name','require','请补全信息'), //默认情况下用正则进行验证
		array('address','require','请补全信息'), //默认情况下用正则进行验证
		array('ceo','require','请补全信息'), //默认情况下用正则进行验证
		array('phone','require','请补全信息'), //默认情况下用正则进行验证
        array('phone','checkphone','手机格式错误',1,'callback'), //默认情况下用正则进行验证
		array('region_id','require','请补全信息',1), //默认情况下用正则进行验证
	);
    
    protected function checkphone($phone){
        return (preg_match_all("/1[3,5,8,7]{1}[0-9]{1}[0-9]{8}|0[0-9]{2,3}-[0-9]{7,8}(-[0-9]{1,4})?/", $phone) == 1) ? true : false;
    }

    
}
?>