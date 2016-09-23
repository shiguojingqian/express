<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

/**
 * Think 系统函数库
 */

 //获取用户基本信息
function getWeixinUserInfo($openid,$status = null) {
    if($status == 'false'){
        $access_token = session('access_token_'.$openid);
        if(empty($access_token)){
            $refresh_token = session('refresh_token'.$openid);
            $param3 ['appid'] = 'wx4b7d567b6572c7eb';
            $param3 ['grant_type'] = 'refresh_token';
            $param3 ['refresh_token'] = $refresh_token;
            $toke = 'https://api.weixin.qq.com/sns/oauth2/refresh_token?' . http_build_query ( $param3 );
            $refresh_token_content = curlRequest ( $url );
            $content = json_decode ( $refresh_token_content, true );
            session('access_token_'.$openid,$content['access_token'],7100);
            session('refresh_token'.$openid,$content['refresh_token'],8200);
            $access_token = session('access_token_'.$openid);
        }
     }else{
         $access_token = get_access_token();
     }

	if (empty ( $access_token )) {
		return false;
	}

	$param2 ['access_token'] = $access_token;
	$param2 ['openid'] = $openid;
	$param2 ['lang'] = 'zh_CN';
    if($status == 'false'){
        $url = 'https://api.weixin.qq.com/sns/userinfo?' . http_build_query ( $param2 );
    }else{
        $url = 'https://api.weixin.qq.com/cgi-bin/user/info?' . http_build_query ( $param2 );
    }
	
	$content = curlRequest ( $url );
	$content = json_decode ( $content, true );
	return $content;
}

//获取用户openid
function get_openid(){
	if(! empty ( $_REQUEST ['openid'] )){
		session('openid',$_REQUEST ['openid']);
	}
	
	$openid = session('openid');
	$isWeixinBrowser = isWeixinBrowser ();
	if(empty($openid) && $isWeixinBrowser){
		$callback = GetCurUrl();
		OAuthWeixin($callback);
	}

    if (empty ( $openid )) {
		return '-1';
	}
	return $openid;
}

//页面授权 
function OAuthWeixin($callback){
	$param ['appid'] = 'wx4b7d567b6572c7eb';
	if(!isset($_GET['getOpenId'])){
		$param['redirect_uri'] = $callback . '&getOpenId=1';
		$param['response_type'] = 'code';
		$param['scope'] = 'snsapi_userinfo';
		$param['state'] = 123;
		$url = "https://open.weixin.qq.com/connect/oauth2/authorize?".http_build_query($param)."#wechat_redirect";
		redirect($url);
	}else if($_GET ['state']){
		$param ['secret'] = 'a8b4e1599fca77fb785924aec89c1670';
		$param ['code'] = I ( 'code' );
		$param ['grant_type'] = 'authorization_code';
		$url = "https://api.weixin.qq.com/sns/oauth2/access_token?".http_build_query($param);
		$content = curlRequest($url);
		$content = json_decode($content,true);
        session('access_token_'.$content['openid'],$content['access_token'],7100);
        session('refresh_token'.$content['openid'],$content['refresh_token'],8200);
		redirect ( $callback . '&openid=' . $content ['openid'] );
	}
}

//获取access_token
function get_access_token() {
	$res = S ( 'access_token' );
	if ($res !== false){return $res;}
	$info ['appid'] = 'wx4b7d567b6572c7eb';
	$info ['secret'] = 'a8b4e1599fca77fb785924aec89c1670';
	$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $info ['appid'] . '&secret=' . $info ['secret'];
	$tempArr = json_decode ( curlRequest ( $url ), true );
	if (@array_key_exists ( 'access_token', $tempArr )) {
		S ( 'access_token', $tempArr ['access_token'], 7100 );
		return $tempArr ['access_token'];
	} else {
		return 0;
	}
}

function isWeixinBrowser() {
	$agent = $_SERVER ['HTTP_USER_AGENT'];
	if (! strpos ( $agent, "icroMessenger" )) {
		return false;
	}
	return true;
}

function GetCurUrl() {
	$url = 'http://';
	if (isset ( $_SERVER ['HTTPS'] ) && $_SERVER ['HTTPS'] == 'on') {
		$url = 'https://';
	}
	if ($_SERVER ['SERVER_PORT'] != '80') {
		$url .= $_SERVER ['HTTP_HOST'] . ':' . $_SERVER ['SERVER_PORT'] . $_SERVER ['REQUEST_URI'];
	} else {
		$url .= $_SERVER ['HTTP_HOST'] . $_SERVER ['REQUEST_URI'];
	}
	// 兼容后面的参数组装
	if (stripos ( $url, '?' ) === false) {
		$url .= '?t=' . time ();
	}
	return $url;
}

function curlRequest($url, $data=null){
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    	if($data){
    		curl_setopt($ch, CURLOPT_POST, 1);
    		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    	}
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($ch, CURLOPT_HEADER, 0);
    	$output = curl_exec($ch);
    	curl_close($ch);
    
    	if($output === FALSE){
    		return false;
    	}else{
    		return $output;
    	}
}

function saveMedia($media_id = null){
    $url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=".get_access_token()."&media_id=".$media_id;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);    
    curl_setopt($ch, CURLOPT_NOBODY, 0);    //对body进行输出。
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $package = curl_exec($ch);
    $httpinfo = curl_getinfo($ch);
   
    curl_close($ch);
    $media = array_merge(array('mediaBody' => $package), $httpinfo);
    
    //求出文件格式
    preg_match('/\w\/(\w+)/i', $media["content_type"], $extmatches);

    $fileExt = $extmatches[1];
    $filename = time().rand(100,999).".{$fileExt}";
    $dirname = "./Public/imgwx/";
    if(!file_exists($dirname)){
        mkdir($dirname,0777,true);
    }
    file_put_contents($dirname.$filename,$media['mediaBody']);
    return $filename;
}
/**
 * 根据两点间的经纬度计算距离
 *
 * @param float $lat
 *        	纬度值
 * @param float $lng
 *        	经度值
 */
function getDistance($lat1, $lng1, $lat2, $lng2) {
	$earthRadius = 6367000; // approximate radius of earth in meters
	                        
	// Convert these degrees to radians to work with the formula
	$lat1 = ($lat1 * pi ()) / 180;
	$lng1 = ($lng1 * pi ()) / 180;
	
	$lat2 = ($lat2 * pi ()) / 180;
	$lng2 = ($lng2 * pi ()) / 180;
	
	$calcLongitude = $lng2 - $lng1;
	$calcLatitude = $lat2 - $lat1;
	$stepOne = pow ( sin ( $calcLatitude / 2 ), 2 ) + cos ( $lat1 ) * cos ( $lat2 ) * pow ( sin ( $calcLongitude / 2 ), 2 );
	$stepTwo = 2 * asin ( min ( 1, sqrt ( $stepOne ) ) );
	$calculatedDistance = $earthRadius * $stepTwo;
	
	return round ( $calculatedDistance );
}

//求出区域名称
function getRange($id = null){
    $map['id'] = intval($id);
    $RangesInfo = M('ranges')->where($map)->find();
    return $RangesInfo['range_name'] ? $RangesInfo['range_name'] : '记录不存在';
}