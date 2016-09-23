<?php
namespace Admin\Model;
use Think\Model;

class AuthRuleModel extends Model {
	protected $_validate = array(
		array('title','require','请补全信息'), //默认情况下用正则进行验证
		array('name','require','请补全信息'), //默认情况下用正则进行验证
	);
}
?>