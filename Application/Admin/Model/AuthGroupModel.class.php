<?php
namespace Admin\Model;
use Think\Model;

class AuthRuleModel extends Model {
	protected $_validate = array(
		array('title','require','请补全信息'), //默认情况下用正则进行验证
		array('rules','require','请补勾选操作'), //默认情况下用正则进行验证
	);
}
?>