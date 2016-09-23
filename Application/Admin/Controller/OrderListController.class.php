<?php
namespace Admin\Controller;

class OrderListController extends IndexController {

    public function index(){
        if(IS_POST){
            $where['sendgoodno|phone'] = array('LIKE',"%".I('post.search')."%");
        }
        $OrderListModel = M('order_list');
        $OrderList = $OrderListModel->where($where)->select();
        $this->assign('OrderList',$OrderList);
        $this->display();
    }

    public function distrib(){
        if(IS_POST){
            $where['number'] = array('LIKE',"%".I('post.search')."%");
        }
        $PackageModel = D('Package');
        $PackageList = $PackageModel->relation(true)->where($where)->select();
        $this->assign('PackageList',$PackageList);
        $this->display();
    }

    public function details(){
        $PackageInfo = M('package')->where(array('id'=>I('get.id')))->find();
        if(!empty($PackageInfo['order_list'])){
            $OrderListModel = D('OrderList');
            $DotModel = M('Dot');
            $regionModel = M('region');
            foreach(explode(',',$PackageInfo['order_list']) as $k => $v){
                $OrderList[$k] = $OrderListModel->relation(true)->where(array('id'=>$v))->find();
                $OrderList[$k]['Dot'] = $DotModel->where(array('region_id'=>$OrderList[$k]['Order']['roleid']))->find();
                $OrderList[$k]['city_id_list'] = $regionModel->field('city')->where(array('id'=>array('IN',$OrderList[$k]['city_id'])))->select();
            }
            $this->assign('OrderList',$OrderList);
        }

        if(!empty($PackageInfo['send_list'])){
            $this->assign('SendList',M('send')->where(array('id'=>array('IN',$PackageInfo['send_list'])))->select());
        }
        
        $this->display();
    }

    public function getwagescount(){
        if(IS_POST){
            $where['username'] = array('LIKE',"%".I('post.search')."%");
        }
        $where['level'] = 2;
        $FansUserModel = D('FansUser');
        $FansUserList = $FansUserModel->relation(true)->where($where)->select();
        $this->assign('FansUserList',$FansUserList);
        $this->display('wages');
    }

    public function wagesdetails(){
        I('get.search') != '' && $where['number'] = array('LIKE',"%".I('get.search')."%");
        $where['user_id'] = intval(I('get.id'));
        $PackageInfo = M('package')->where($where)->select();
        $this->assign('PackageInfo',$PackageInfo);
        $this->display();
    }
}