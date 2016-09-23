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
				<span>审核信息</span>
			</div>
		</div>
        <form action="<?php echo U('FansUser/update');?>" method="POST">
        <input name="id" type="hidden" value="<?php echo ($ArchivesInfo["fans_user_id"]); ?>" />
		<div class="form-content">
			<div class="form">
				<div class="form-left">姓名</div>
				<div class="form-right">
					<input class="form-input-big" disabled name="name" type="text" value="<?php echo ($ArchivesInfo["name"]); ?>" />
					<div class="notice">这里填写姓名</div>
				</div>
			</div>
			<div class="form">
				<div class="form-left">身份证号</div>
				<div class="form-right">
					<input class="form-input-big" disabled name="identity" type="text" value="<?php echo ($ArchivesInfo["identity"]); ?>" />
					<div class="notice">这里填写身份证号</div>
				</div>
			</div>
            <div class="form">
				<div class="form-left">紧急联系人</div>
				<div class="form-right">
					<input class="form-input-big" disabled name="urgent" type="text" value="<?php echo ($ArchivesInfo["urgent"]); ?>" />
					<div class="notice">这里填写紧急联系人</div>
				</div>
			</div>
            <div class="form">
				<div class="form-left">联系人电话</div>
				<div class="form-right">
					<input class="form-input-big" disabled name="urgent_phone" type="text" value="<?php echo ($ArchivesInfo["urgent_phone"]); ?>" />
					<div class="notice">这里填写联系人电话</div>
				</div>
			</div>
            <div class="form">
				<div class="form-left">学历</div>
				<div class="form-right">
					<input class="form-input-big" disabled name="education" type="text" value="<?php echo ($ArchivesInfo["education"]); ?>" />
					<div class="notice">这里填写学历</div>
				</div>
			</div>
            <div class="form">
				<div class="form-left">职业</div>
				<div class="form-right">
					<input class="form-input-big" disabled name="occupation" type="text" value="<?php echo ($ArchivesInfo["occupation"]); ?>" />
					<div class="notice">这里填写职业</div>
				</div>
			</div>
            <div class="form">
				<div class="form-left">所属区域</div>
				<div class="form-right">
					<input class="form-input-big" disabled type="text" value="<?php echo (getRange($ArchivesInfo["carrying"])); ?>" />
					<input name="carrying" type="hidden" value="<?php echo ($ArchivesInfo["carrying"]); ?>" />
					<div class="notice">这里填写所属区域</div>
				</div>
			</div>
            <div class="form">
				<div class="form-left">现居地址</div>
				<div class="form-right">
					<input class="form-input-big" disabled name="address" type="text" value="<?php echo ($ArchivesInfo["address"]); ?>" />
					<div class="notice">这里填写现居地址</div>
				</div>
			</div>
            <div class="form">
				<div class="form-left">现居地址</div>
				<div class="form-right">
					<img src="/Public/imgwx/<?php echo ($ArchivesInfo["id_a"]); ?>" style="width:50%;height:30%;float:left;"/>
					<img src="/Public/imgwx/<?php echo ($ArchivesInfo["id_b"]); ?>" style="width:50%;height:30%;"/>
					<img src="/Public/imgwx/<?php echo ($ArchivesInfo["id_c"]); ?>" style="width:50%;height:30%;float:left;"/>
					<img src="/Public/imgwx/<?php echo ($ArchivesInfo["id_d"]); ?>" style="width:50%;height:30%;"/>
				</div>
			</div>
            <?php if($ArchivesInfo["status"] == 2 or $ArchivesInfo["status"] == 3): ?><div class="form">
				<div class="form-left">用户状态</div>
				<div class="form-right">
					<div class="form-input-radio">
						<label>
							<input type="radio" checked name="status" value="1"/>
							通过
						</label>
					</div>
					<div class="form-input-radio">
						<label>
							<input type="radio" name="status" value="3"/>
							拒绝
						</label>
					</div>
				</div>
			</div>
            
			<div class="form-operate">
            
				<button class="form-button color-bg-green">保存</button>
				<button class="form-button color-bg-grey" onclick="history.go(-1);">取消</button>
			</div><?php endif; ?>
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