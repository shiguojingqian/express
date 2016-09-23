<?php
namespace Home\Model;
use Think\Model\RelationModel;

class PackageModel extends RelationModel {

    protected $_link = array(
         'Ranges'  =>  array(
             'mapping_type'     => self::BELONGS_TO,
             'class_name'       => 'Ranges',
             'foreign_key'      => 'range_id',
         ),
    );
    
}
?>