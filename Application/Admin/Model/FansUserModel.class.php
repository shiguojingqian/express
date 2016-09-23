<?php
namespace Admin\Model;
use Think\Model\RelationModel;

class FansUserModel extends RelationModel {
    protected $_validate = array(
        
	);

    protected $_link = array(
        'Archives'  =>  array(
            'mapping_type'     => self::HAS_ONE,
            'class_name'       => 'Archives',
            'foreign_key'      => 'fans_user_id',
            'condition'        => 'status',
        ),
        'Packagew'   =>  array(
            'mapping_type'     => self::HAS_MANY,
            'class_name'       => 'Package',
            'foreign_key'      => 'user_id',
            'condition'        => 'state = 0',
            'mapping_fields'   => 'sum(price) as totalw',
        ),
        'Packagej'   =>  array(
            'mapping_type'     => self::HAS_MANY,
            'class_name'       => 'Package',
            'foreign_key'      => 'user_id',
            'condition'        => 'state = 1 and status = 3',
            'mapping_fields'   => 'sum(price) as totalj',
        )
    );
}
?>