<?php
namespace Admin\Model;
use Think\Model;

class RangesModel extends Model {
	protected $_validate = array(
		array('range_name','require','请补全信息'), //默认情况下用正则进行验证
		array('ceo','require','请补全信息'), //默认情况下用正则进行验证
		array('phone','require','请补全信息'), //默认情况下用正则进行验证
        array('range_name','','该区域已存在',0,'unique',1), // 在新增的时候验证name字段是否唯一
        array('range_name','checkReg','该区域已存在！',1,'callback',2), 
        array('phone','checkphone','手机格式错误',1,'callback'), //默认情况下用正则进行验证
	);

    public function checkphone($phone){
        return (preg_match_all("/1[3,5,8,7]{1}[0-9]{1}[0-9]{8}|0[0-9]{2,3}-[0-9]{7,8}(-[0-9]{1,4})?/", $phone) == 1) ? true : false;
    }

    protected function checkReg($range_name){
        return ($this->range_name == $range_name || !$this->where(array('range_name'=>$range_name))->find()) ? true : false;
    }
}
?>