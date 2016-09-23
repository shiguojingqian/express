<?php
namespace Admin\Model;
use Think\Model\RelationModel;

class OrderListModel extends RelationModel {
    protected $_link = array(
         'Order'  =>  array(
             'mapping_type'     => self::BELONGS_TO,
             'class_name'       => 'Order',
             'foreign_key'      => 'order_id',
         )
    );
}
?>