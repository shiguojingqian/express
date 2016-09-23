<?php
namespace Home\Controller;

class SendController extends IndexController {
    protected $FansUserInfo = array();
    protected $SettingInfo = array();
    protected $key = "EFBBZ-5CSKF-GXAJS-JFVDF-M4RKJ-PXFJC";
    
    public function _initialize(){
        if(ACTION_NAME != 'backPay'){
            parent::_initialize();
            $this->FansUserInfo = session(C(HOME_SESSION));
            $this->assign('UserInfo',$this->FansUserInfo);
            $this->orderpay();
        }
        $this->SettingInfo = M('setting')->where(array('status'=>2))->find();
    }

    public function index(){
        session('send_'. $this->FansUserInfo['openid'],null);
        $this->assign('RegionList',M('region')->where(array('path'=>0))->select());
        $this->display();
    }

    public function sendadd(){
        if(IS_POST){
            $SendModel = D('Send');
            !($SendModel->create($_POST)) && $this->error($SendModel->getError());
            session('send_'.$this->FansUserInfo['openid'],$_POST);
            $SendInfo = session('send_'.$this->FansUserInfo['openid']);
            $sender_address = $this->citylist($SendInfo['sender_city']);
            $receiver_address = $this->citylist($SendInfo['receiver_city']);
            $SendInfo['km'] = ceil((getDistance($sender_address['lat'] , $sender_address['lng'] , $receiver_address['lat'] , $receiver_address['lng'])) / 1000);
            session('send_'.$this->FansUserInfo['openid'],$SendInfo);
            $this->success('正在提交',U('Send/info'));
        }
    }

    public function info(){
        $SendInfo = session('send_'.$this->FansUserInfo['openid']);
        if($SendInfo){
            if((int)$SendInfo['km'] > 1){
                $total = ((int)$SendInfo['km'] - 1) * $this->SettingInfo['kilometre'] + $this->SettingInfo['price'];
            }else{
                $total = $this->SettingInfo['price'];
            }
            $time = array();
            for($i=8;$i<=17;$i++){
                $time[] = $i < 10 ? "0".$i.":00" : $i.":00";
            }
            $this->assign('vip',$this->SettingInfo['vip']);
            $this->assign('total',$total);
            $this->assign('time',$time);
            $this->display();
        }else{
            $this->redirect('Send/index');
        }
    }

    public function ajaxsend(){
        if(IS_POST){
            $SendInfo = session('send_'.$this->FansUserInfo['openid']);
            $range_id = M('Region')->where(array('id'=>$SendInfo['receiver_city'][3]))->field('range_id')->find();
            $SendModel = D('Send');
            $SendInfo['goods_name'] = I('post.goods_name');
            $SendInfo['weight'] = I('post.weight');
            $SendInfo['fetchtime'] = I('post.fetchtime');
            $SendInfo['vip'] = I('post.vip');
            $SendInfo['remarks'] = I('post.remarks');
            $SendInfo['number'] = time().rand(10000,99999);
            $SendInfo['user_id'] = $this->FansUserInfo['id'];
            $SendInfo['createtime'] = time();
            $SendInfo['range_id'] = $range_id['range_id'];
           !($SendModel->create($SendInfo)) && $this->error($SendModel->getError());
            if($SendInfo['vip'] == 1){
                $SendInfo['price'] = ((int)$SendInfo['km'] - 1) * $this->SettingInfo['kilometre'] + $this->SettingInfo['price'] + $this->SettingInfo['vip'];
            }elseif((int)$SendInfo['km'] > 1){
                $SendInfo['price'] = ((int)$SendInfo['km'] - 1) * $this->SettingInfo['kilometre'] + $this->SettingInfo['price'];
            }else{
                $SendInfo['price'] = $this->SettingInfo['price'];
            }
            $regionModel = M('region');
            foreach($SendInfo['sender_city'] as $k){
                $info = $regionModel->where(array('id'=>$k))->find();
                $addressa[] = $info['city'];
            }
            $SendInfo['sender_city'] = implode("",$addressa);
            foreach($SendInfo['receiver_city'] as $k){
                $info = $regionModel->where(array('id'=>$k))->find();
                $addressb[] = $info['city'];
            }
            $SendInfo['receiver_city'] = implode("",$addressb);
            if($result = $SendModel->add($SendInfo)){
                session('send_'. $this->FansUserInfo['openid'],null);
                $url = "http://".$_SERVER['HTTP_HOST']."/Home/Send/order?id=".$result;
                $this->success('订单提交成功',$url);
            }
            $this->error('订单提交失败');
        }
    }

    public function citylist($data = array()){
        if($data){
            $regionModel = M('region');
            if(!($location = $regionModel->where(array('id'=>$data[3]))->field('lat,lng')->find())) return $location;
            foreach($data as $k){
                $info = $regionModel->where(array('id'=>$k))->find();
                $address[] = $info['city'];
            }
            $address = implode("",$address);
            $url = "http://apis.map.qq.com/ws/geocoder/v1/?address={$address}&key=".$this->key;
            $dataInfo = json_decode(file_get_contents($url),true);
            $regionModel->where(array('id'=>$data[3]))->save(array('lat'=>$dataInfo['result']['location']['lat'],'lng'=>$dataInfo['result']['location']['lng']));
            return $dataInfo['result']['location'];
        }
        return ;
    }

    public function get_distance($lat , $lng , $tolat , $tolng){
        $url = "http://apis.map.qq.com/ws/distance/v1/?mode=driving&from={$lat},{$lng}&to={$tolat},{$tolng}&key=".$this->key;
        $dataInfo = json_decode(file_get_contents($url),true);
        if($dataInfo['status'] == 0){
            $km = ceil($dataInfo['result']['elements'][0]['distance'] / 1000);
            return $km;
        }else{
            return '不在配送范围';
        }
    }

    public function orderlist(){
        $SendModel = M('send');
        I('get.evaluate') != '' && $where['evaluate'] = I('get.evaluate');
        I('get.evaluate') != '' && $where['status'] = 4;
        $SendInfo = $SendModel->where($where)->select();
        $this->assign('SendInfo',$SendInfo);
        $this->display();
    }

    public function order(){
        $SendInfo = M('send')->where(array('id'=>(int)I('get.id')))->find();
        $this->assign('SendInfo',$SendInfo);
        $this->display();
    }

    public function evaluate(){
        $SendInfo = M('send')->where(array('id'=>(int)I('get.id')))->find();
        if($Info = M('evaluate')->where(array('order_id'=>$SendInfo['id'],'number'=>$SendInfo['number'],'type'=>$SendInfo['type']))->find()){
            $this->assign('Info',$Info);
        }
        $this->assign('SendInfo',$SendInfo);
        $this->display();
    }

    public function ajaxpay(){
        if(IS_POST){
            $SendInfo = M('send')->where($_POST)->find();
            if(!$SendInfo){
                $this->error('未找到此订单');
            }else if($SendInfo['pay_type'] == 1){
                $this->error('已支付订单');
            }
            try{
                $apipay = $this->weipay($SendInfo);
            } catch ( \Think\Exception $e) {
                $this->error($e->getMessage());
            }
            $this->success(json_decode($apipay,true));
        }
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
     *  统一订单
     */
    protected function weipay($SendInfo){
        Vendor('Wxpay/WxPayJsApiPay');
        $tools = new \JsApiPay();
        $input = new \WxPayUnifiedOrder();
        $input->SetBody("寄件人:".$SendInfo['sender_name']);
        $input->SetAttach("收件人:".$SendInfo['receiver_name']);
        $input->SetOut_trade_no($SendInfo['number']);
        $input->SetTotal_fee(1);
        $input->SetNotify_url("http://".$_SERVER['HTTP_HOST']."/Home/Send/backPay/id/".$SendInfo['id'].".html");
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($this->FansUserInfo['openid']);
        $order = \WxPayApi::unifiedOrder($input);
        $jsApiParameters = $tools->GetJsApiParameters($order);
        return $jsApiParameters;
    }

    public function backPay(){
        $SendModel = M('send');
		$xml = $GLOBALS['HTTP_RAW_POST_DATA'];
		$tmpData = $this->xmlToArray($xml);
		$rs = $this->notify($tmpData);
		if($rs){
             $map = array(
                'id' => (int)I('get.id'),
                'number'    => $tmpData['out_trade_no'],
                'pay_type'  => 0,
            );
            $order = $SendModel->where($map)->find();
            if($order){
                $data = array(
                    'pay_type' => 1,
                    'pay_time'=>time(),
                    'transaction_id' => $tmpData['transaction_id'],
                );
                $result = $SendModel->where($map)->save($data);
                if($result){
                    $map['pay_type'] = 1;
                    $orderInfo = $SendModel->where($map)->find();
                    $SettingInfo = M('setting')->where(array('status'=>4))->find();
                    $result = parent::business($orderInfo['id'],$orderInfo['range_id'],$orderInfo['vip'],$orderInfo['type'],$SettingInfo['price']);
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

    public function ajaxevaluate(){
        if(IS_POST){
            !(M('evaluate')->add($_POST)) && $this->error('提交失败');
            (I('post.type') == 2) && M('send')->where(array('id'=>I('post.order_id'),'number'=>I('post.number')))->save(array('evaluate'=>1));
            $this->success('评价已提交');
        }
    }
}