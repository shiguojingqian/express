<?php
namespace Admin\Model;
use Think\Model\RelationModel;

class RegionModel extends RelationModel {
	protected $_validate = array(
		array('city','require','请补全信息'), //默认情况下用正则进行验证
        array('city','','城市信息已经存在！',0,'unique',1), // 在新增的时候验证name字段是否唯一
        array('city','checkReg','城市信息已经存在！',1,'callback',2), 
	);

    protected function checkReg($city){
        return ($this->city == $city || !$this->where(array('city'=>$city,'path'=>$this->path))->find()) ? true : false;
    }

    
}
?>