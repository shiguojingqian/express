<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta http-equiv="pragram" content="no-cache">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>后台管理</title>
	<link href="/Public/Admin/css/swiper.css" rel="stylesheet" type="text/css">
	<link href="/Public/Admin/css/style.css" rel="stylesheet" type="text/css">
	<link href="/Public/Admin/css/animate.css" rel="stylesheet" type="text/css">
	<link href="/Public/Admin/css/iconfont.css" rel="stylesheet" type="text/css">
	<script src="/Public/Admin/js/jquery-1.11.1.min.js"></script>
	<script src="/Public/Admin/js/publicjquery.js"></script>
	<script src="/Public/Admin/js/swiper.min.js"></script>
</head>
<body onselectstart="return false">
<div class="main">
	<div class="content">
		<div class="head-content">
			<div class="head-title"><?php echo ($title); ?></div>
            <form action="<?php echo U('UserAdmin/index');?>" method="GET">
			<div class="head-search">
<!--                 <div class="form-time-list">
                    <input type="text" placeholder="开始时间" /><span>至</span><input type="text" placeholder="结束时间"/>
                </div> -->
                <input class="form-input-small" type="text" name="search" placeholder="请输入" />
<!--                 <select class="form-select-small">
                    <option value="">请选择</option>
                    <option value="">北戴河</option>
                    <option value="">北戴河</option>
                </select> -->
				<button class="form-button color-bg-green">搜索</button>
			</div>
            </form>
		</div>
	</div>
	
	<div class="table-list">
		<table cellpadding="0" cellspacing="0">
			<thead>
				<tr>
                    <th>用户头像</th>
					<th>姓名</th>
					<th>性别</th>
					<th>家庭住址</th>
					<th>身份证号</th>
					<th>联系电话</th>
					<th>所属区域</th>
					<th>审核状态</th>
					<th>操作</th>
				</tr>
			</thead>
			<?php if(is_array($FansUserList)): $i = 0; $__LIST__ = $FansUserList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                <td>
					<img src="<?php echo ($vo["htmlurl"]); ?>"/>
				</td>
				<td><?php echo ($vo["Archives"]["name"]); ?></td>
				<td><?php echo ($vo['sex'] == 1? '男': '女'); ?></td>
                <td><?php echo ($vo["Archives"]["address"]); ?></td>
                <td><?php echo ($vo["Archives"]["identity"]); ?></td>
                <td><?php echo ($vo["Archives"]["urgent_phone"]); ?></td>
                <td><?php echo (getRange($vo["Archives"]["carrying"])); ?></td>
				<td class="color-yellow"><?php if($vo['Archives']['status'] == 2): ?>待审核<?php elseif($vo['Archives']['status'] == 3): ?>未通过<?php else: ?>已通过<?php endif; ?></td>
				<td>
					<div>
						<a href="<?php echo U('FansUser/details',array('id'=>$vo['Archives']['id']));?>">
							<button class="form-button color-bg-green">查看信息</button>
						</a>
					</div>
				</td>
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		</table>
        <?php if(empty($FansUserList)): ?><div class="nodata"><i class="iconfont">&#xe607;</i><span>没有查询到符合条件的记录</span></div><?php endif; ?>
		<div class="table-foot">
			<div class="delete-all">
				<a href="#">删除</a>
			</div>
			<div class="foot-page">
				<ul>
					<li>
						<a href="#"><</a>
					</li>
					<li>
						<a class="active" href="#">1</a>
					</li>
					<li>
						<a href="#">2</a>
					</li>
					<li>
						<a href="#">3</a>
					</li>
					<li class="page-ellipsis">
						<a href="#">...</a>
					</li>
					<li>
						<a href="#">12</a>
					</li>
					<li>
						<a href="#">></a>
					</li>
				</ul>
				<div class="pade-switch">
					<input type="text"/>
					<a href="#" class="pade-switch-btn">GO</a>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="pop-window pop-delete">
	<div class="pop-notice FromUpToDown">
		<div class="notice-head">
			<div class="notice-head-title">温馨提示</div>
			<div class="notice-head-delete">×</div>
		</div>
		<div class="notice-content">
			<div>
				<i class="iconfont">&#xe607;</i>
			</div>
			<div class="notice-content-word">是否要删除本条信息？</div>
		</div>
		<div class="notice-foot">
			<a href="javascript:;" class="notice-btn btn-submit">确定</a>
			<a href="javascript:;" class="notice-btn btn-drop">取消</a>
		</div>
	</div>
</div>

<div class="main-foot">Copyright  2013-2015 WeiGouTong.com. All Rights Reserved.  苏ICP备09098830号</div>
<script>
	$(".delete").click(function(){
		$(".pop-delete").fadeIn("fast");
	});
	$(".eye").click(function(){
		$(".pop-detail").fadeIn("fast");
		var mySwiper = new Swiper('.pop-img-list', {
		prevButton:'.swiper-button-prev',
		nextButton:'.swiper-button-next',
	});
	});
</script>
</body>
</html>