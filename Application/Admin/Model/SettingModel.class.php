<?php
namespace Admin\Model;
use Think\Model;

class SettingModel extends Model {
	protected $_validate = array(
		array('price','require','请补全信息'), //默认情况下用正则进行验证
		array('vip','require','请补全信息'), //默认情况下用正则进行验证
		array('kilometre','require','请补全信息',0), //默认情况下用正则进行验证
	);
}
?>