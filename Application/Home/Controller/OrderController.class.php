<?php
namespace Home\Controller;

class OrderController extends IndexController {
    protected $FansUserInfo = array();
    protected $SettingInfo = array();
    
    public function _initialize(){
        if(ACTION_NAME != 'backPay'){
            parent::_initialize();
            $this->FansUserInfo = session(C(HOME_SESSION));
            $this->assign('UserInfo',$this->FansUserInfo);
            $this->orderpay();
        }
        $this->SettingInfo = M('setting')->where(array('status'=>4))->find();
    }

    public function index(){
        $this->display();
    }

    public function order(){
        $OrderModel = M('order');
        $OrderList = $OrderModel
                    ->join('join rrsd_dot on rrsd_dot.region_id = rrsd_order.roleId')
                    ->field('rrsd_order.*,rrsd_dot.dot_name,rrsd_dot.address,rrsd_dot.phone')
                    ->where(array('openid'=>$this->FansUserInfo['openid'],'sendFlag'=>0,'rrsd_order.status'=>I('get.status') ? I('get.status') : 0))
                    ->order('createTime desc')
                    ->select();
        $this->assign('OrderList',$OrderList);
        $this->display();
    }

    public function orderlist(){
        if(IS_POST){
            if(!preg_match_all("/1[3,5,8,7]{1}[0-9]{1}[0-9]{8}|0[0-9]{2,3}-[0-9]{7,8}(-[0-9]{1,4})?/", I('post.phone')) == 1) $this->error('手机格式不正确');
            $data = array(
                'appId'     => 'CCWLFW8767UID',
                'mcheck'    => strtoupper(MD5("CCWLFW8767UID".date('Ymd')."CCWLFW")),
                'userTel'   => I('post.phone'),
            );

            $url = "http://www.ccwlfw.com/wx/WeiXinEmsApi_fetchEmsByUser.action";
            $OrderList = json_decode(curlRequest($url , $data),true);
            $OrderModel = M('order');
            foreach($OrderList as $key => $val){
                if($OrderList[$key]['sendFlag'] == 1) 
                    unset($OrderList[$key],$OrderList);
                if(!empty($OrderList[$key]) && $OrderModel->where(array('sendGoodId'=>$OrderList[$key]['sendGoodId']))->find() == null){
                    $data['sendGoodNo'] = $OrderList[$key]['sendGoodNo'];
                    $data['containerCode'] = $OrderList[$key]['containerCode'];
                    $data['belongTel'] = $OrderList[$key]['belongTel'];
                    $data['roleId'] = $OrderList[$key]['roleId'];
                    $data['sendGoodId'] = $OrderList[$key]['sendGoodId'];
                    $data['sendFlag'] = $OrderList[$key]['sendFlag'];
                    $data['createTime'] = $OrderList[$key]['createTime'];
                    $data['sendTime'] = $OrderList[$key]['sendTime'];
                    $data['sendMessageFlag'] = $OrderList[$key]['sendMessageFlag'];
                    $data['belongName'] = $OrderList[$key]['belongName'];
                    $data['belongCode'] = $OrderList[$key]['belongCode'];
                    $data['createCode'] = $OrderList[$key]['createCode'];
                    $data['openid'] = I('post.openid');
                    $OrderModel->add($data);
                }
            }
            $OrderList = $OrderModel
                        ->join('join rrsd_dot on rrsd_dot.region_id = rrsd_order.roleId')
                        ->field('rrsd_order.*,rrsd_dot.dot_name,rrsd_dot.address,rrsd_dot.phone')
                        ->where(array('openid'=>I('post.openid'),'sendFlag'=>0,'rrsd_order.status'=>I('get.status') ? I('get.status') : 0,'belongTel'=>I('post.phone')))
                        ->order('createTime desc')
                        ->select();
            $this->assign('OrderList',$OrderList);
            // $this->assign('count',count($OrderList));
        }
        $this->display();
    }

    public function details(){
        $OrderModel = M('order');
        $OrderInfo = $OrderModel
                        ->join('join rrsd_dot on rrsd_dot.region_id = rrsd_order.roleId')
                        ->field('rrsd_order.*,rrsd_dot.dot_name,rrsd_dot.address,rrsd_dot.phone')
                        ->where(array('rrsd_order.openid'=>get_openid(),'rrsd_order.sendFlag'=>0,'rrsd_order.id'=>I('get.id')))
                        ->order('createTime desc')
                        ->find();
        $this->assign('OrderInfo',$OrderInfo);
        if($OrderInfo['status'] == 1){
            $OrderListModel = M('OrderList');
            $OrderListInfo = $OrderListModel->where(array('order_id'=>$OrderInfo['id']))->find();
            $regionInfo = M('region')->field('city')->where(array('id'=>array('IN',$OrderListInfo['city_id'])))->select();
            foreach($regionInfo as $k){ $Info[] = $k['city']; }
            $OrderListInfo['city_id'] = implode('-',$Info);
            $this->assign('OrderListInfo',$OrderListInfo);
            if($OrderListInfo['pay_type'] == 1){
                $packageInfo = M('package')->where(array('order_list'=>array('LIKE',"%".$OrderListInfo['id']."%")))->find();
                if($packageInfo['user_id'] != 0){
                    $this->assign('UserInfoPs',D('FansUser')->relation(true)->where(array('id'=>$packageInfo['user_id']))->find());
                    $this->assign('count',M('package')->where(array('user_id'=>$packageInfo['user_id']))->count());
                }
                $this->assign('packageInfo',$packageInfo);
                $this->display('followup');
                exit;
            }
            $this->display('pay');
            exit;
        }
        $this->assign('setting',M('setting')->where(array('status'=>1))->find());
        $this->assign('RegionList',M('region')->where(array('path'=>0))->select());
        $this->display();
    }

    public function generate(){
        if(IS_POST){
            $OrderListModel = D('OrderList');
            !($OrderListModel->create($_POST)) && $this->error($OrderListModel->getError());
            $range_id = M('Region')->where(array('id'=>$_POST['city_id'][3]))->field('range_id')->find();
            $_POST['city_id'] = implode(',',$_POST['city_id']);
            $data =  $_POST;
            $setting = M('setting')->where(array('status'=>1))->find();
            $data['price'] = empty(I('post.vip')) ? $setting['price'] : ($setting['price'] + $setting['vip']);
            $data['type'] = 1;
            $data['createtime'] = time();
            $data['number'] = time().rand(1000,9999);
            $data['range_id'] = $range_id['range_id'];
            $data['user_id'] = $this->FansUserInfo['id'];
            
            ($OrderListModel->add($data) && M('order')->where(array('id'=>I('post.order_id')))->save(array('status'=>1))) ? $this->success('订单提交成功') : $this->error('订单提交失败');
        }
    }

    public function ajaxpay(){
        if(IS_POST){
            $OrderListInfo = M('order_list')->where(array('id'=>(int)I('order_list_id'),'range_id'=>(int)I('post.range_id')))->find();
            if(!$OrderListInfo){
                $this->error('未找到此订单');
            }else if($OrderListInfo['pay_type'] == 1){
                $this->error('已支付订单');
            }
            try{
                $apipay = $this->weipay($OrderListInfo);
            } catch ( \Think\Exception $e) {
                $this->error($e->getMessage());
            }
            $this->success(json_decode($apipay,true));
           // $this->business(I('order_list_id'),I('post.range_id'));
        }
    }
    
    /*
     *  统一订单
     */
    protected function weipay($OrderInfo){
        Vendor('Wxpay/WxPayJsApiPay');
        $tools = new \JsApiPay();
        $input = new \WxPayUnifiedOrder();
        $input->SetBody($OrderInfo['name']);
        $input->SetAttach($OrderInfo['name']);
        $input->SetOut_trade_no($OrderInfo['number']);
        $input->SetTotal_fee(1);
        $input->SetNotify_url("http://".$_SERVER['HTTP_HOST']."/Home/Order/backPay/id/".$OrderInfo['id']."/order_id/".$OrderInfo['order_id'].".html");
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($this->FansUserInfo['openid']);
        $order = \WxPayApi::unifiedOrder($input);
        // dump($order);exit;
        $jsApiParameters = $tools->GetJsApiParameters($order);
        return $jsApiParameters;
    }
    
    /*
     *  支付JSAPI
     */
    public function orderpay(){
        $jssdk = new \Com\jssdk();
		$signPackage = $jssdk->getSignPackage();
		if($signPackage){
			//如果获得返回值,则进行后续动作
			$this->assign('signPackage',$signPackage);
		}
    }
    
    /*
     *  支付成功后回调订单打包操作
     *  @ range_id 区域外键
     *  @ order_list_id 支付后操作订单的外键
     *
     */
  /*   protected function business($order_list_id = null , $range_id = '' , $vip = 0 , $type){
        $DistribModel = M('distrib');
        $this->pack_list($range_id , $DistribModel);
        if($vip == 0){
            $data['order_list_id'] = intval($order_list_id,0);
            $data['range_id'] = intval($range_id,0);
            $data['createtime'] = time();
            $data['endtime'] = time() + 1800;
            $data['type']   =  $type;
            if($DistribModel->add($data)){
                $this->pack_list($range_id , $DistribModel);
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
    } */

    /*
     *  订单打包
     *  @ range_id 区域外键
     *  
     */
   /*  protected function pack_list($range_id = '' , $DistribModel = array()){
        if($DistribModel->where(array('range_id'=>$range_id))->count() >= intval($this->SettingInfo['price'])){
            $Rar = $DistribModel->field('id,order_list_id')->where(array('range_id'=>$range_id))->order('endtime asc')->limit('0,'.intval($this->SettingInfo['price']))->select();
            foreach($Rar as $k){
                if($type == 1){
                    $order_id[] = $k['order_list_id'];
                }else if($type == 2){
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
                M('order_list')->where(array('id'=>array('IN',$package['order_list'])))->save(array('status'=>2));
            }
        }
    } */

    public function pond(){
        $PackageModel = D('Package');
        $UserInfoId = D('FansUser')->relation(true)->where(array('id'=>I('get.id'),'openid'=>I('get.openid')))->find();
        $PackageList = $PackageModel->relation(true)->where(array('status'=>I('get.status')))->select();
        $this->assign('PackageList',$PackageList);
        $this->display();
    }

    public function getlist(){
        $PackageModel = D('Package');
        $UserInfoId = D('FansUser')->relation(true)->where(array('id'=>I('get.id'),'openid'=>I('get.openid')))->find();
        $PackageList = $PackageModel->relation(true)->where(array('status'=>I('get.status')))->select();
        $this->assign('PackageList',$PackageList);
        $this->display();
    }

    public function iddetail(){
        $OrderListModel = D('OrderList');
        $DotModel = M('Dot');
        $regionModel = M('region');
        $OrderList = $OrderListModel->relation(true)->where(array('id'=>I('get.id')))->find();
        $OrderList['Dot'] = $DotModel->where(array('region_id'=>$OrderList['Order']['roleid']))->find();
        $OrderList['city_id_list'] = $regionModel->field('city')->where(array('id'=>array('IN',$OrderList['city_id'])))->select();
        $this->assign('OrderList',$OrderList);
        $this->display();
    }

    public function rob(){
        !($PackageInfo = M('package')->where(array('id'=>I('get.id'),'status'=>$_GET['status'] ? $_GET['status'] : 1))->find()) && $this->error('该订单已处理');
        if($PackageInfo['order_list'] != ''){
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
        if($PackageInfo['send_list'] != ''){
            $SendList = M('send')->where(array('id'=>array("IN",$PackageInfo['send_list'])))->select();
            $this->assign('SendList',$SendList);
        }
        $this->assign('PackageInfo',$PackageInfo);
        if($PackageInfo['status'] == 2 || $PackageInfo['status'] == 3){
            $this->display('detailslist');
            exit;
        }
        $this->display();
    }

    public function ajaxrod(){
        if(IS_POST){
            $id = intval(I('post.id'),0);
            $PackageModel = M('Package');
            if(!($PackageInfo = $PackageModel->where(array('id'=>$id,'status'=>1))->find())) $this->error('该订单已处理');
            if(!($PackageModel->where(array('id'=>$id,'status'=>1))->save(array('status'=>2,'user_id'=>$this->FansUserInfo['id'])))) $this->error('抢单失败');
            $OrderListModel = M('OrderList');
            $order_list = explode(',',$PackageInfo['order_list']);
            $send_list = explode(',',$PackageInfo['send_list']);
            $order_list_num = 0;
            if($order_list){
                foreach($order_list as $k => $v){
                    $order_list_num += $OrderListModel->where(array('id'=>$v))->save(array('status'=>3));
                }
            }
            $SendModel = M('send');
            $send_list_num = 0;
            if($send_list){
                foreach($send_list as $k => $v){
                    $send_list_num += $SendModel->where(array('id'=>$v))->save(array('status'=>3));
                }
            }

            if(count($order_list) == $order_list_num && count($send_list) == $send_list_num) $this->success('抢单成功');

            if(count($order_list) != $order_list_num){
                foreach($order_list as $k => $v){
                    $OrderListModel->where(array('id'=>$v))->save(array('status'=>2));
                }
            }
            if(count($send_list) != $send_list_num){
                foreach($send_list as $k => $v){
                    $SendModel->where(array('id'=>$v))->save(array('status'=>2));
                }
            }
            
            $PackageModel->where(array('id'=>$id,'status'=>2))->save(array('status'=>1,'user_id'=>0));
            $this->error('抢单失败');
        }
    }

    public function ajaxsign(){
        if(IS_POST){
           $OrderListModel = M('order_list');
           $OrderListInfo = $OrderListModel->where(array('id'=>I('post.id'),'status'=>I('post.status')))->find();
           if($OrderListInfo['status'] == 3){
               if($OrderListModel->where(array('id'=>I('post.id'),'status'=>I('post.status')))->save(array('status'=>6,'code'=>rand(100000,999999)))){
                   $this->success('取货成功');
               }
           }elseif($OrderListInfo['status'] == 6){
               if($OrderListModel->where(array('id'=>I('post.id'),'status'=>I('post.status')))->save(array('status'=>4))){
                   $this->success('送达请求已提交');
               }
           }
        }
    }

    public function ajaxsend(){
        if(IS_POST){
           $SendModel = M('send');
           $SendInfo = $SendModel->where(array('id'=>I('post.id'),'status'=>I('post.status')))->find();
           if($SendInfo['status'] == 3){
               if($SendModel->where(array('id'=>I('post.id'),'status'=>I('post.status')))->save(array('status'=>6))){
                   $this->success('取货成功');
               }
           }elseif($SendInfo['status'] == 6){
               if($SendModel->where(array('id'=>I('post.id'),'status'=>I('post.status')))->save(array('status'=>4))){
                   $this->success('送达请求已提交');
               }
           }
        }
    }

    public function complete(){
        if(IS_POST){
            $PackageModel = M('Package');
            !($PackageInfo = $PackageModel->where(array('number'=>I('post.number'),'id'=>I('post.id')))->find()) && $this->error('该订单不存在');
            $order_list = explode(',',$PackageInfo['order_list']);
            $order_list_num = 0;
            $OrderListModel = M('OrderList');
            foreach($order_list as $k => $v){
                $order_list_num += $OrderListModel->where(array('id'=>$v,'status'=>4))->count();
            }
            if(count($order_list) != $order_list_num){
                $this->error('有待送达订单');
            }

            $send_list = explode(',',$PackageInfo['send_list']);
            $send_list_num = 0;
            $SendModel = M('send');
            foreach($send_list as $k => $v){
                $send_list_num += $SendModel->where(array('id'=>$v,'status'=>4))->count();
            }
            if(count($send_list) != $send_list_num){
                $this->error('有待送达订单');
            }
            
            if(!($PackageModel->where(array('number'=>I('post.number'),'id'=>I('post.id')))->save(array('status'=>3,'state'=>1,'edittime'=>time())))){
                $this->error('出错了');
            }else{
                $WagesModel = M('wages');
                $where = array(
                    'user_id'        =>  $this->FansUserInfo['id'],
                    'createtime'     =>  array('BETWEEN',array(strtotime(date("Y-m-01")),strtotime(date("Y-m-t")))),
                );
                if(!($WagesInfo = $WagesModel->where($where)->find())){
                    $data = array(
                        'user_id'        =>  $this->FansUserInfo['id'],
                        'total'          =>  $PackageInfo['price'],
                        'createtime'     =>  time(),
                    );
                    $WagesModel->add($data);
                }else{
                    $data = array(
                        'user_id'        =>  $this->FansUserInfo['id'],
                        'total'          =>  ($PackageInfo['price'] + $WagesInfo['total']),
                    );
                    $WagesModel->where($where)->save($data);
                }
                $this->success('配送完成');
            }
        }
    }

    public function backPay(){
        $OrderModel = M('order_list');
		$xml = $GLOBALS['HTTP_RAW_POST_DATA'];
		$tmpData = $this->xmlToArray($xml);
		$rs = $this->notify($tmpData);
		if($rs){
            $map = array(
                'id' => (int)I('get.id'),
                'order_id' => I('get.order_id'),
                'number'    => $tmpData['out_trade_no'],
                'pay_type'  => 0,
            );
            $order = $OrderModel->where($map)->find();
            if($order){
                $data = array(
                    'pay_type' => 1,
                    'pay_time'=>time(),
                    'transaction_id' => $tmpData['transaction_id'],
                );
                $result = $OrderModel->where($map)->save($data);
                if($result){
                    unset($map['pay_type']);
                    $orderInfo = $OrderModel->where($map)->find();
                    $result = parent::business($orderInfo['id'],$orderInfo['range_id'],$orderInfo['vip'],$orderInfo['type'],$this->SettingInfo['price']);
                    exit($result);
                }else{
                    exit("FAIL");
                }
            }else{
				exit("SUCCESS");
			}
        }else{
			exit("SUCCESS");
		}
	}
    /**
     * 支付通知接口
     * @param unknown $data
     */
    public function notify($tmpData = array()){
    	if(empty($tmpData)){
    		$xml = $GLOBALS['HTTP_RAW_POST_DATA'];
    		$tmpData = $this->xmlToArray($xml);
    	}
    	$notifySign = $tmpData['sign'];
    	unset($tmpData['sign']);
    	$sign = $this->getSign($tmpData);//本地签名
    	if ($notifySign == $sign) {
    		return TRUE;
    	}
    	return FALSE;
    }
    //生成Sign
    private function getSign($Obj){
        foreach ($Obj as $k => $v)
        {
            $Parameters[$k] = $v;
        }
        //签名步骤一：按字典序排序参数
        ksort($Parameters);
        $String = $this->formatBizQueryParaMap($Parameters, false);
        
        //echo '【string1】'.$String.'</br>';
        //签名步骤二：在string后加入KEY
        $String = $String."&key=98zOR7mDedbB34QYwc41Y636Z5CCMCyf";
        //签名步骤三：MD5加密
        $String = md5($String);
        //签名步骤四：所有字符转为大写
        $result_ = strtoupper($String);
        
        return $result_;
    }
    //	作用：格式化参数，签名过程需要使用 
    public function formatBizQueryParaMap($paraMap, $urlencode)
    {
        $buff = "";
        ksort($paraMap);
        foreach ($paraMap as $k => $v)
        {
            if($urlencode)
            {
                   $v = urlencode($v);
                }
                //$buff .= strtolower($k) . "=" . $v . "&";
                $buff .= $k . "=" . $v . "&";
        }
        $reqPar;
        if (strlen($buff) > 0) 
        {
                $reqPar = substr($buff, 0, strlen($buff)-1);
        }
        return $reqPar;
    }
    
    protected function xmlToArray($xml)
    {	
        //将XML转为array        
        $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);		
        return $array_data;
    }
}