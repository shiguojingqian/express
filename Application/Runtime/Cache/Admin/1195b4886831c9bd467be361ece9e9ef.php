<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta http-equiv="pragram" content="no-cache">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>后台管理</title>
	<link href="/Public/Admin/css/style.css" rel="stylesheet" type="text/css">
	<link href="/Public/Admin/css/animate.css" rel="stylesheet" type="text/css">
	<link href="/Public/Admin/css/iconfont.css" rel="stylesheet" type="text/css">
	<script src="/Public/Admin/js/jquery-1.11.1.min.js"></script>
	<script src="/Public/Admin/js/publicjquery.js"></script>
    <script src="/Public/layer/layer.js"></script>
</head>
<body onselectstart="return false">
<div class="main FromUpToDown">
	<div class="content">
		<div class="head-content">
			<div class="head-title">
				<span>打包设置</span>
			</div>
		</div>
        <form action="<?php echo U('Setting/insert');?>" method="POST">
        <input name="id" type="hidden" value="<?php echo ($SettingInfo["id"]); ?>" />
        <input name="status" type="hidden" value="<?php echo $_GET['status'];?>" />
		<div class="form-content">
			<div class="form">
				<div class="form-left">打包数量</div>
				<div class="form-right">
					<input class="form-input-big" name="price" type="text" placeholder="请填写" value="<?php echo ($SettingInfo["price"]); ?>"/>
					<div class="notice">这里填写打包数量</div>
				</div>
			</div>
			<div class="form">
				<div class="form-left">打包时间</div>
				<div class="form-right">
					<input class="form-input-big" name="vip" type="text" placeholder="请填写" value="<?php echo ($SettingInfo["vip"]); ?>"/>
					<div class="notice">这里填写打包时间(单位:分钟)</div>
				</div>
			</div>
			<div class="form-operate">
				<button class="form-button color-bg-green">保存</button>
			</div>
		</div>
        </form>
	</div>
</div>
<div class="main-foot">Copyright  2013-2015 WeiGouTong.com. All Rights Reserved.  苏ICP备09098830号</div>

</body>
<script type="text/javascript">
    	$("form").submit(function(){
    		var self = $(this);
    		$.post(self.attr("action"), self.serialize(), success, "json");
    		return false;

    		function success(data){
				if(data.status == 0){
					layer.msg(data.info, {icon: 5,time: 2000 });  
				}else{
					layer.msg(data.info, {icon: 1,time: 2000 }, function(){history.go(-1);});  
				}
    		}
    	});
</script>
</html>