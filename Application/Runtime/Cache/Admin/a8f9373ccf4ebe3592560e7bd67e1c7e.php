<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="pragram" content="no-cache">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>后台管理</title>
    <link href="/Public/Admin/css/style.css" rel="stylesheet" type="text/css">
    <link href="/Public/Admin/css/iconfont.css" rel="stylesheet" type="text/css">
    <script src="/Public/Admin/js/jquery-1.11.1.min.js"></script>
    <script src="/Public/Admin/js/publicjquery.js"></script>
</head>
<body style="background:#2b333e;" onselectstart="return false">
<ul class="nav-first">
	<li>
		<a class="first" href="javascript:void(0);">
			<i class="iconfont">&#xe62a;</i>
			<span>业务管理</span>
			<i class="iconfont down">&#xe656;</i>
            <i class="iconfont down up">&#xe625;</i>
		</a>
		<ul class="nav-second">
			<li>
				<a href="main-form.html" target="main">
					首次关注设置
				</a>
			</li>
			<li>
				<a href="main-list.html" target="main">
					无匹配回复
				</a>
			</li>
			<li>
				<a href="main-list.html" target="main">
					自定义菜单
				</a>
			</li>
			<li>
				<a href="huifu.html" target="main">
					关键词恢复设置
				</a>
			</li>
			<li>
				<a href="shouye.html" target="main">
					微信接口配置
				</a>
			</li>
			<li>
				<a href="#">
					微信授权配置
				</a>
			</li>
		</ul>
	</li>
    
	<li>
		<a class="first" href="#">
			<i class="iconfont">&#xe60f;</i>
			<span>地点区域</span>
			<i class="iconfont down">&#xe656;</i>
            <i class="iconfont down up">&#xe625;</i>
		</a>
		<ul class="nav-second">
        
			<li>
				<a href="<?php echo U('Region/index');?>" target="main">
					地点
				</a>
			</li>
			<li>
				<a href="<?php echo U('Ranges/index');?>" target="main">
					区域
				</a>
			</li>
			
		</ul>
	</li>

	<li>
		<a class="first" href="#">
			<i class="iconfont">&#xe63b;</i>
			<span>资费设置</span>
			<i class="iconfont down">&#xe656;</i>
            <i class="iconfont down up">&#xe625;</i>
		</a>
		<ul class="nav-second">
        
			<li>
				<a href="<?php echo U('Setting/index',array('status'=>1));?>" target="main">
					快递业务
				</a>
			</li>
			<li>
				<a href="<?php echo U('Setting/index',array('status'=>2));?>" target="main">
					寄件业务
				</a>
			</li>
			<li>
				<a href="<?php echo U('Setting/index',array('status'=>3));?>" target="main">
					外卖业务
				</a>
			</li>
			<li>
				<a href="<?php echo U('Setting/tlist');?>" target="main">
					匹配设置
				</a>
			</li>
			<li>
				<a href="<?php echo U('Setting/reward');?>" target="main">
					奖励设置
				</a>
			</li>
            <li>
				<a href="<?php echo U('Setting/timesize',array('status'=>4));?>" target="main">
                    打包设置
				</a>
			</li>
		</ul>
	</li>

	<li>
		<a class="first" href="#">
			<i class="iconfont">&#xe66e;</i>
			<span>快递网点</span>
			<i class="iconfont down">&#xe656;</i>
            <i class="iconfont down up">&#xe625;</i>
		</a>
		<ul class="nav-second">
			<li>
				<a href="<?php echo U('Dot/index');?>" target="main">
					服务网点
				</a>
			</li>
		</ul>
	</li>

	<li>
		<a class="first" href="#">
			<i class="iconfont">&#xe66f;</i>
			<span>系统管理</span>
			<i class="iconfont down">&#xe656;</i>
            <i class="iconfont down up">&#xe625;</i>
		</a>
		<ul class="nav-second">
			<li>
				<a href="<?php echo U('UserAdmin/index');?>" target="main">
					管理账号
				</a>
			</li>
			<li>
				<a href="<?php echo U('AuthGroup/index');?>" target="main">
                    角色列表
				</a>
			</li>
			<li>
				<a href="<?php echo U('AuthRule/index');?>" target="main">
                    操作节点
				</a>
			</li>
		</ul>
	</li>

    <li>
		<a class="first" href="#">
			<i class="iconfont">&#xe620;</i>
			<span>用户管理</span>
			<i class="iconfont down">&#xe656;</i>
            <i class="iconfont down up">&#xe625;</i>
		</a>
		<ul class="nav-second">
			<li>
				<a href="<?php echo U('FansUser/index');?>" target="main">
					会员管理
				</a>
			</li>
			<li>
				<a href="<?php echo U('FansUser/express',array('level'=>2));?>" target="main">
                    配送员管理
				</a>
			</li>
			<li>
				<a href="<?php echo U('FansUser/express',array('level'=>1));?>" target="main">
                    配送员审核
				</a>
			</li>
		</ul>
	</li>

    <li>
		<a class="first" href="#">
			<i class="iconfont">&#xe63f;</i>
			<span>订单管理</span>
			<i class="iconfont down">&#xe656;</i>
            <i class="iconfont down up">&#xe625;</i>
		</a>
		<ul class="nav-second">
			<li>
				<a href="<?php echo U('OrderList/index');?>" target="main">
					快递订单
				</a>
			</li>
			<li>
				<a href="<?php echo U('SendList/index');?>" target="main">
					寄件订单
				</a>
			</li>
			<li>
				<a href="<?php echo U('OrderList/distrib');?>" target="main">
					配送列表
				</a>
			</li>
		</ul>
	</li>
	
    <li>
		<a class="first" href="#">
			<i class="iconfont">&#xe65b;</i>
			<span>财务管理</span>
			<i class="iconfont down">&#xe656;</i>
            <i class="iconfont down up">&#xe625;</i>
		</a>
		<ul class="nav-second">
			<li>
				<a href="<?php echo U('OrderList/getwagescount');?>" target="main">
					工资统计
				</a>
			</li>
			<li>
				<a href="<?php echo U('OrderList/distrib');?>" target="main">
					收支统计
				</a>
			</li>
		</ul>
	</li>
</ul>
</body>
</html>