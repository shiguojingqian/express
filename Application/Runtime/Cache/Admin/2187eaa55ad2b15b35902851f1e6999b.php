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
    <style>
    .form-operate a.newBtn{
        float: left;
        margin: 10px 10px 11px 0px;
        outline: none;
        border: none;
        border-radius: 3px;
        width: 80px;
        height: 34px;
        line-height: 34px;
        text-align: center;
        color: #fff;
        cursor: pointer;
        background: #cecece;
    }
    </style>
</head>
<body onselectstart="return false">
<div class="main FromUpToDown">
	<div class="content">
		<div class="head-content">
			<div class="head-title">
				<span>城市添加</span>
			</div>
		</div>
        <form action="<?php echo U('Region/insert');?>" method="POST">
        <input class="form-input-big" name="level" type="hidden" value="<?php echo $_GET['level'];?>"/>
        <input class="form-input-big" name="path" type="hidden" value="<?php echo $_GET['path'];?>"/>
		<div class="form-content">
        <?php if($_GET['level'] == '1'): ?><div class="form">
				<div class="form-left">选择省份</div>
				<div class="form-right">
					<select class="form-select-big change">
                        <option value="">选择省份</option>
                        <?php if(is_array($EMS)): $i = 0; $__LIST__ = $EMS;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>        
			</div>
			<div class="form">
				<div class="form-left">选择城市</div>
				<div class="form-right">
					<select class="form-select-big" name="ems_id">
                        <option value="">选择城市</option>
                    </select>
                </div>        
			</div><?php endif; ?>
        <?php if($_GET['level'] == '2'): ?><div class="form">
				<div class="form-left">选择区</div>
				<div class="form-right">
					<select class="form-select-big" name="ems_id">
                        <option value="">选择区</option>
                        <?php if(is_array($EMS)): $i = 0; $__LIST__ = $EMS;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" data-info="<?php echo ($vo["name"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>        
			</div><?php endif; ?>
        <?php if($_GET['level'] == '3'): ?><div class="form">
				<div class="form-left">选择镇</div>
				<div class="form-right">
					<select class="form-select-big" name="ems_id">
                        <option value="">选择镇</option>
                        <?php if(is_array($EMS)): $i = 0; $__LIST__ = $EMS;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" data-info="<?php echo ($vo["name"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>        
			</div><?php endif; ?> 
        <?php if($_GET['level'] == '4'): ?><div class="form">
				<div class="form-left">选择村</div>
				<div class="form-right">
					<select class="form-select-big" name="ems_id">
                        <option value="">选择村</option>
                        <?php if(is_array($EMS)): $i = 0; $__LIST__ = $EMS;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" data-info="<?php echo ($vo["name"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>        
			</div><?php endif; ?>
			<div class="form">
				<div class="form-left">城市名称</div>
				<div class="form-right">
					<input class="form-input-big" name="city" readonly type="text" placeholder="请填写" />
					<div class="notice">这里填写开放城市</div>
				</div>
			</div>
            <?php if($_GET['level'] == 4): ?><div class="form">
				<div class="form-left">所属区域</div>
				<div class="form-right">
					<select class="form-select-big" name="range_id">
                        <option value="">请选择</option>
                        <?php if(is_array($RangeList)): $i = 0; $__LIST__ = $RangeList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["range_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>        
			</div><?php endif; ?>
			<div class="form">
				<div class="form-left">商品类型</div>
				<div class="form-right">
					<div class="form-input-radio">
						<label>
							<input type="radio" checked name="status" value="1"/>
							开启
						</label>
					</div>
					<div class="form-input-radio">
						<label>
							<input type="radio" name="status" value="2"/>
							禁用
						</label>
					</div>
				</div>
			</div>
			<div class="form-operate">
				<button class="form-button color-bg-green">保存</button>
				<a href="javasciprt:;" class="newBtn" onclick="history.go(-1)">取消</a>
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
        
        $(".change").change(function(){
            $.ajax({
               type: "POST",
               url: "<?php echo U('Region/add');?>",
               data: {id:$(this).val()},
               dataType: 'json',
               success: function(data){
                    var datalength = data.info.length;
                    var html = '<option value="">选择城市</option>';
                    if(datalength >= 1){
                       for(var i=0;i<datalength;i++){
                            html += "<option value='"+data.info[i]['id']+"' data-info='"+data.info[i]['name']+"'>"+data.info[i]['name']+"</option>";
                       }
                    }
                    $("select[name=ems_id]").html(html);
               }
            });
        });
        $("select[name=ems_id]").change(function(){
            $("input[name=city]").val($(":selected",$(this)).data('info'));
        });
</script>
</html>