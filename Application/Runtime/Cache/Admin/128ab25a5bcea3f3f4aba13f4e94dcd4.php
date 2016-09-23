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
	<script type="text/javascript" src="/Public/Admin/js/echarts.common.min.js"></script>
</head>
<body onselectstart="return false">
<div class="desktop">
	<div class="desktop-head">
		<div class="welcome">hello,李木木 欢迎登陆！</div>
		<div class="login-time">上次登陆：20150516</div>
	</div>
	<div class="desktop-main">
		<div class="model-one">
			<div class="model-head">代办事项</div>
			<div class="model-list">
				<table>
					<tr>
						<td class="model-list-title">
							<div>
								<span>微沟通后台</span><i>加急</i>
							</div>
						</td>
						<td class="model-list-progress">
							<div>
								<div class="FromLeftToRight2" style="width:70%"></div>
							</div>
						</td>
						<td>
							<div>2016.01.04</div>
						</td>
						<td class="model-list-operate">
							<div class="operate-list">
								<a class="heart" href="#">
									<i class="iconfont">&#xe643;</i>
								</a>
								<a class="pen" href="#">
									<i class="iconfont">&#xe64f;</i>
								</a>
								<a class="delete" href="#">
									<i class="iconfont">&#xe62b;</i>
								</a>
								<a class="eye" href="#">
									<i class="iconfont">&#xe619;</i>
								</a>
							</div>
						</td>
					</tr>
					<tr>
						<td class="model-list-title">
							<div>
								<span>微沟通后台</span><i>加急</i>
							</div>
						</td>
						<td class="model-list-progress">
							<div>
								<div class="FromLeftToRight2" style="width:10%"></div>
							</div>
						</td>
						<td>
							<div>2016.01.04</div>
						</td>
						<td class="model-list-operate">
							<div class="operate-list">
								<a class="heart" href="#">
									<i class="iconfont">&#xe643;</i>
								</a>
								<a class="pen" href="#">
									<i class="iconfont">&#xe64f;</i>
								</a>
								<a class="delete" href="#">
									<i class="iconfont">&#xe62b;</i>
								</a>
								<a class="eye" href="#">
									<i class="iconfont">&#xe619;</i>
								</a>
							</div>
						</td>
					</tr>
					<tr>
						<td class="model-list-title">
							<div>
								<span>微沟通后台</span><i>加急</i>
							</div>
						</td>
						<td class="model-list-progress">
							<div>
								<div class="FromLeftToRight2" style="width:20%"></div>
							</div>
						</td>
						<td>
							<div>2016.01.04</div>
						</td>
						<td class="model-list-operate">
							<div class="operate-list">
								<a class="heart" href="#">
									<i class="iconfont">&#xe643;</i>
								</a>
								<a class="pen" href="#">
									<i class="iconfont">&#xe64f;</i>
								</a>
								<a class="delete" href="#">
									<i class="iconfont">&#xe62b;</i>
								</a>
								<a class="eye" href="#">
									<i class="iconfont">&#xe619;</i>
								</a>
							</div>
						</td>
					</tr>
					<tr>
						<td class="model-list-title">
							<div>
								<span>微沟通后台</span><i>加急</i>
							</div>
						</td>
						<td class="model-list-progress">
							<div>
								<div class="FromLeftToRight2" style="width:40%"></div>
							</div>
						</td>
						<td>
							<div>2016.01.04</div>
						</td>
						<td class="model-list-operate">
							<div class="operate-list">
								<a class="heart" href="#">
									<i class="iconfont">&#xe643;</i>
								</a>
								<a class="pen" href="#">
									<i class="iconfont">&#xe64f;</i>
								</a>
								<a class="delete" href="#">
									<i class="iconfont">&#xe62b;</i>
								</a>
								<a class="eye" href="#">
									<i class="iconfont">&#xe619;</i>
								</a>
							</div>
						</td>
					</tr>
					<tr>
						<td class="model-list-title">
							<div>
								<span>微沟通后台</span><i>加急</i>
							</div>
						</td>
						<td class="model-list-progress">
							<div>
								<div class="FromLeftToRight2" style="width:80%"></div>
							</div>
						</td>
						<td>
							<div>2016.01.04</div>
						</td>
						<td class="model-list-operate">
							<div class="operate-list">
								<a class="heart" href="#">
									<i class="iconfont">&#xe643;</i>
								</a>
								<a class="pen" href="#">
									<i class="iconfont">&#xe64f;</i>
								</a>
								<a class="delete" href="#">
									<i class="iconfont">&#xe62b;</i>
								</a>
								<a class="eye" href="#">
									<i class="iconfont">&#xe619;</i>
								</a>
							</div>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="model-two">
			<div class="model-two-left">
				<div class="model-head">图形</div>
				<div id="myChart1" class="model-list">
					<script type="text/javascript">
						// 基于准备好的dom，初始化echarts实例
						var myChart = echarts.init(document.getElementById('myChart1'));

						// 指定图表的配置项和数据
option = {
    tooltip: {
        trigger: 'item',
        formatter: "{a} <br/>{b}: {c} ({d}%)"
    },
    legend: {
        orient: 'vertical',
        x: 'left',
        data:['直接访问','邮件营销','联盟广告','视频广告','搜索引擎']
    },
    series: [
        {
            name:'访问来源',
            type:'pie',
            radius: ['50%', '70%'],
            avoidLabelOverlap: false,
            label: {
                normal: {
                    show: false,
                    position: 'center'
                },
                emphasis: {
                    show: true,
                    textStyle: {
                        fontSize: '30',
                        fontWeight: 'bold'
                    }
                }
            },
            labelLine: {
                normal: {
                    show: false
                }
            },
            data:[
                {value:335, name:'直接访问'},
                {value:310, name:'邮件营销'},
                {value:234, name:'联盟广告'},
                {value:135, name:'视频广告'},
                {value:500, name:'搜索引擎'}
            ]
        }
    ]
};


myChart.setOption(option);
						//加载等候效果等待
						// myChart.showLoading();
						// $.get('data.json').done(function (data) {
						//     myChart.hideLoading();
						// 	myChart.setOption({
						// 	    series : [
						// 	        {
						// 	            name: '访问来源',
						// 	            type: 'pie',
						// 	            radius: '55%',
						// 	            data:[
						// 	                {value:400, name:'搜索引擎'},
						// 	                {value:335, name:'直接访问'},
						// 	                {value:310, name:'邮件营销'},
						// 	                {value:274, name:'联盟广告'},
						// 	                {value:235, name:'视频广告'}
						// 	            ]
						// 	        }
						// 	    ]
						// 	})
						// });
				    </script>
				</div>
			</div>
			<div class="model-two-right">
				<div class="model-head">最新公告</div>
				<div class="model-list">
					<table>
						<tr>
							<td class="model-list-title">
								<div>
									<span><a href="#">微沟通后台</a></span>
								</div>
							</td>
							<td>1015.12</td>
						</tr>
						<tr>
							<td class="model-list-title">
								<div>
									<span><a href="#">微沟通后台</a></span>
								</div>
							</td>
							<td>1015.12</td>
						</tr>
						<tr>
							<td class="model-list-title">
								<div>
									<span><a href="#">微沟通后台</a></span>
								</div>
							</td>
							<td>1015.12</td>
						</tr>
						<tr>
							<td class="model-list-title">
								<div>
									<span><a href="#">微沟通后台</a></span>
								</div>
							</td>
							<td>1015.12</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="model-third">
			<div class="model-head">系统信息</div>
				<div class="model-list">
					<table>
						<tr>
							<td class="model-list-title">
								<div>
									<span><a href="#">微沟通后台</a></span>
								</div>
							</td>
							<td>1015.12</td>
						</tr>
						<tr>
							<td class="model-list-title">
								<div>
									<span><a href="#">微沟通后台</a></span>
								</div>
							</td>
							<td>1015.12</td>
						</tr>
						<tr>
							<td class="model-list-title">
								<div>
									<span><a href="#">微沟通后台</a></span>
								</div>
							</td>
							<td>1015.12</td>
						</tr>
						<tr>
							<td class="model-list-title">
								<div>
									<span><a href="#">微沟通后台</a></span>
								</div>
							</td>
							<td>1015.12</td>
						</tr>
						<tr>
							<td class="model-list-title">
								<div>
									<span><a href="#">微沟通后台</a></span>
								</div>
							</td>
							<td>1015.12</td>
						</tr>
						<tr>
							<td class="model-list-title">
								<div>
									<span><a href="#">微沟通后台</a></span>
								</div>
							</td>
							<td>1015.12</td>
						</tr>
						<tr>
							<td class="model-list-title">
								<div>
									<span><a href="#">微沟通后台</a></span>
								</div>
							</td>
							<td>1015.12</td>
						</tr>
						<tr>
							<td class="model-list-title">
								<div>
									<span><a href="#">微沟通后台</a></span>
								</div>
							</td>
							<td>1015.12</td>
						</tr>
						<tr>
							<td class="model-list-title">
								<div>
									<span><a href="#">微沟通后台</a></span>
								</div>
							</td>
							<td>1015.12</td>
						</tr>
						<tr>
							<td class="model-list-title">
								<div>
									<span><a href="#">微沟通后台</a></span>
								</div>
							</td>
							<td>1015.12</td>
						</tr>
						<tr>
							<td class="model-list-title">
								<div>
									<span><a href="#">微沟通后台</a></span>
								</div>
							</td>
							<td>1015.12</td>
						</tr>
						<tr>
							<td class="model-list-title">
								<div>
									<span><a href="#">微沟通后台</a></span>
								</div>
							</td>
							<td>1015.12</td>
						</tr>
					</table>
				</div>
		</div>
		<div class="date-content">
			<div class="date-content-head">
				<div class="date-left">
					<i class="iconfont">&#xe635;</i>
				</div>
				<span>2015年12月</span>
				<div class="date-right">
					<i class="iconfont">&#xe635;</i>
				</div>
			</div>
			<ul class="data-week">
				<li>周日</li>
				<li>周一</li>
				<li>周二</li>
				<li>周三</li>
				<li>周四</li>
				<li>周五</li>
				<li>周六</li>
			</ul>
			<ul class="data-day">
				<li>
					<a href="javascript:;">1</a>
				</li>
				<li>
					<a href="javascript:;">2</a>
				</li>
				<li>
					<a href="javascript:;">3</a>
				</li>
				<li>
					<a href="javascript:;">4</a>
				</li>
				<li>
					<a href="javascript:;">5</a>
				</li>
				<li>
					<a href="javascript:;">6</a>
				</li>
				<li>
					<a href="javascript:;">7</a>
				</li>
				<li>
					<a href="javascript:;">1</a>
				</li>
				<li>
					<a href="javascript:;">2</a>
				</li>
				<li>
					<a href="javascript:;">3</a>
				</li>
				<li>
					<a href="javascript:;">4</a>
				</li>
				<li>
					<a href="javascript:;">5</a>
				</li>
				<li>
					<a href="javascript:;">6</a>
				</li>
				<li>
					<a href="javascript:;">7</a>
				</li>
				<li>
					<a href="javascript:;">1</a>
				</li>
				<li>
					<a href="javascript:;">2</a>
				</li>
				<li>
					<a href="javascript:;">3</a>
				</li>
				<li>
					<a href="javascript:;">4</a>
				</li>
				<li>
					<a href="javascript:;">5</a>
				</li>
				<li>
					<a href="javascript:;">6</a>
				</li>
				<li>
					<a href="javascript:;">7</a>
				</li>
				<li>
					<a href="javascript:;">1</a>
				</li>
				<li>
					<a class="active" href="javascript:;">2</a>
				</li>
				<li>
					<a href="javascript:;">3</a>
				</li>
				<li>
					<a href="javascript:;">4</a>
				</li>
				<li>
					<a href="javascript:;">5</a>
				</li>
				<li>
					<a href="javascript:;">6</a>
				</li>
				<li>
					<a href="javascript:;">7</a>
				</li>
				<li>
					<a href="javascript:;">1</a>
				</li>
				<li>
					<a href="javascript:;">2</a>
				</li>
				<li>
					<a href="javascript:;">3</a>
				</li>
				<li>
					<a href="javascript:;">4</a>
				</li>
				<li>
					<a href="javascript:;">5</a>
				</li>
				<li>
					<a href="javascript:;">6</a>
				</li>
				<li>
					<a href="javascript:;">7</a>
				</li>
				<li>
					<a href="javascript:;">1</a>
				</li>
				<li>
					<a href="javascript:;">2</a>
				</li>
				<li>
					<a href="javascript:;">3</a>
				</li>
				<li>
					<a href="javascript:;">4</a>
				</li>
				<li>
					<a href="javascript:;">5</a>
				</li>
				<li>
					<a href="javascript:;">6</a>
				</li>
				<li>
					<a href="javascript:;">7</a>
				</li>
			</ul>
		</div>
	</div>
		
</div>
<div class="main-foot">Copyright  2013-2015 WeiGouTong.com. All Rights Reserved.  苏ICP备09098830号</div>


<!-- 弹窗 -->
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
<script>
	$(".delete").click(function(){
		$(".pop-delete").fadeIn("fast");
	});
</script>
</body>
</html>