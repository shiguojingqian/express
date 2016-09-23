<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

    public function _initialize(){
        if(!isWeixinBrowser()){
            exit('请使用微信浏览器打开');
        }
        if(empty(session(C('HOME_SESSION')))) redirect(U('Login/login'));
        $jssdk = new \Com\jssdk();
		$signPackage = $jssdk->getSignPackage();
		if($signPackage){
			//如果获得返回值,则进行后续动作
			$this->assign('signPackage',$signPackage);
		}
    }

    public function index(){
        redirect(U('Personal/index'));
    }

    /*
     *  支付成功后回调订单打包操作
     *  @ range_id 区域外键
     *  @ order_list_id 支付后操作订单的外键
     *
     */
    protected function business($order_list_id = null , $range_id = '' , $vip = 0 , $type , $num = 2){
        $DistribModel = M('distrib');
        $this->pack_list($range_id , $DistribModel , $num);
        if($vip == 0){
            $data['order_list_id'] = intval($order_list_id,0);
            $data['range_id'] = intval($range_id,0);
            $data['createtime'] = time();
            $data['endtime'] = time() + 1800;
            $data['type']   =  $type;
            if($DistribModel->add($data)){
                $this->pack_list($range_id , $DistribModel , $num);
            }
            return "SUCCESS";
        }
        if($type == 1){
            $package['order_list'] = $order_list_id;
        }else if($type == 2){
            $package['send_list'] = $order_list_id;
        }
        $package['range_id'] = $range_id;
        $package['price'] = 1;
        $package['number'] = date("YmdHis",time()).rand(10000,99999);
        $package['createtime'] = time();
        if(M('package')->add($package)){
            M('order_list')->where(array('id'=>intval($order_list_id)))->save(array('status'=>2));
        }
        return "SUCCESS";
    }

    /*
     *  订单打包
     *  @ range_id 区域外键
     *  
     */
    protected function pack_list($range_id = '' , $DistribModel = array() , $num){
        if($DistribModel->where(array('range_id'=>$range_id))->count() >= intval($num)){
            $Rar = $DistribModel->field('id,order_list_id,type')->where(array('range_id'=>$range_id))->order('endtime asc')->limit('0,'.intval($num))->select();
            foreach($Rar as $k){
                if($k['type'] == 1){
                    $order_id[] = $k['order_list_id'];
                }elseif($k['type'] == 2){
                    $send_id[] = $k['order_list_id'];
                }
                $did[] = $k['id'];
            }
            $package['order_list'] = implode(',',$order_id);
            $package['send_list'] = implode(',',$send_id);
            $package['range_id'] = $range_id;
            $package['price'] = 1;
            $package['number'] = date("YmdHis",time()).rand(10000,99999);
            $package['createtime'] = time();
            if(M('package')->add($package) && $DistribModel->where(array('id'=>array('IN',implode(',',$did))))->delete()){
                if($package['order_list'] != '') M('order_list')->where(array('id'=>array('IN',$package['order_list'])))->save(array('status'=>2));
                if($package['send_list'] != '') M('send')->where(array('id'=>array('IN',$package['send_list'])))->save(array('status'=>2));
            }
        }
    }
}