<?php
namespace Admin\Model;
use Think\Model\RelationModel;

class PackageModel extends RelationModel {
     protected $_link = array(
        'FansUser'=>array(
            'mapping_type'      => self::BELONGS_TO,
            'class_name'        => 'FansUser',
            'foreign_key'       => 'user_id',
            ),
    );
}
?>