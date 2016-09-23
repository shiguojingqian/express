<?php
/*
 *  Copyright (c) 2014 The CCP project authors. All Rights Reserved.
 *
 *  Use of this source code is governed by a Beijing Speedtong Information Technology Co.,Ltd license
 *  that can be found in the LICENSE file in the root of the web site.
 *
 *   http://www.yuntongxun.com
 *
 *  An additional intellectual property rights grant can be found
 *  in the file PATENTS.  All contributing project authors may
 *  be found in the AUTHORS file in the root of the source tree.
 */

include_once("CCPRestSDK.php");

class SMSREST{
    //主帐号
    protected $accountSid;
    //主帐号Token
    protected $accountToken;
    //应用Id
    protected $appId;
    //请求地址，格式如下，不需要写https://
    protected $serverIP;
    //请求端口 
    protected $serverPort;
    //REST版本号
    protected $softVersion;
    
    public function __construct()	
	{
		$this->accountSid = 'aaf98f8950189e9b01504b84397d1fcd';
		$this->accountToken = '09f771de6b7f40af83ea6ad1cc99c3ba';
		$this->appId = '8a48b5515018a0f4015056f9c3b37205';
		$this->serverIP = 'sandboxapp.cloopen.com';
        $this->serverPort = '8883';
        $this->softVersion = '2013-12-26';
	}
    /**
      * 发送模板短信
      * @param to 手机号码集合,用英文逗号分开
      * @param datas 内容数据 格式为数组 例如：array('Marry','Alon')，如不需替换请填 null
      * @param $tempId 模板Id
      */       
    public function sendTemplateSMS($to,$datas,$tempId)
    {
         // 初始化REST SDK
         $rest = new REST($this->serverIP,$this->serverPort,$this->softVersion);
         $rest->setAccount($this->accountSid,$this->accountToken);
         $rest->setAppId($this->appId);
        
         // 发送模板短信
         //echo "Sending TemplateSMS to $to <br/>";
         $result = $rest->sendTemplateSMS($to,$datas,$tempId);
         if($result == NULL ) {
             echo "result error!";
             break;
         }
         if($result->statusCode!=0) {
             $data = array(
                'errorCode'    => $result->statusCode,
                'errorMsg'    => $result->statusMsg,
             );
             return json_encode($data);
         }else{
             $smsmessage = $result->TemplateSMS;
             $data = array(
                'statusCode'    => 'SUCCESS',
                'dateCreated'   => $smsmessage->dateCreated,
                'smsMessageSid' => $smsmessage->smsMessageSid,
             );
             //TODO 添加成功处理逻辑
             return json_encode($data);
         }
    }
}
//Demo调用,参数填入正确后，放开注释可以调用 
//sendTemplateSMS("18652161332",$data = array('88888'),"114119");
?>
