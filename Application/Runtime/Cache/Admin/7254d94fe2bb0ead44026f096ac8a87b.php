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
			<div class="head-title">操作规则</div>
            <form action="<?php echo U('AuthRule/index');?>" method="GET">
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
                <a class="form-button color-bg-yellow" href="<?php echo U('AuthRule/add');?>" target="main">添加</a>
			</div>
            </form>
		</div>
	</div>
	
	<div class="table-list">
		<table cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th>操作名称</th>
					<th>操作标识</th>
					<th>
						<a href="javascript:;">当前状态</a>
					</th>
					<th>地区开关</th>
					<th>操作</th>
				</tr>
			</thead>
			<?php if(is_array($AuthRuleList)): $i = 0; $__LIST__ = $AuthRuleList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
				<td><?php echo ($vo["title"]); ?></td>
				<td><?php echo ($vo["name"]); ?></td>
				<td class="color-yellow"><?php if(($vo['status']) == "1"): ?>已开启<?php else: ?>已禁用<?php endif; ?></td>
				<td>
					<label class="switch">
						<input <?php if(($vo['status']) == "1"): ?>checked<?php endif; ?> type="checkbox" />
						<span></span>
					</label>
				</td>
				<td>
					<div>
						<a href="<?php echo U('AuthRule/edit',array('id'=>$vo['id']));?>">
							<button class="form-button color-bg-green">修改</button>
						</a>
						<a href="<?php echo U('AuthRule/delete',array('id'=>$vo['id']));?>">
							<button class="form-button color-bg-green">删除</button>
						</a>
					</div>
				</td>
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		</table>
        <?php if(empty($AuthRuleList)): ?><div class="nodata"><i class="iconfont">&#xe607;</i><span>没有查询到符合条件的记录</span></div><?php endif; ?>
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