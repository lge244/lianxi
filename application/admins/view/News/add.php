<!DOCTYPE html>
<html>
<head>
	<title><?=$product['id']?'修改':'添加'?>新闻</title>
	<link rel="stylesheet" type="text/css" href="/static/plugins/layui/css/layui.css">
	<script type="text/javascript" src="/static/plugins/layui/layui.js"></script>
	<style type="text/css">
		.clear{clear: both;}
		.header span{background: #009688;margin-left: 30px;padding: 10px;color:#ffffff;}
		.header div{border-bottom: solid 2px #009688;margin-top: 8px;}
		.header button{float: right;margin-top: -5px;}
		.thumb{height: 28px;float: right;border: solid 1px #f0f0f0;padding: 1px;}
		.layui-table td{padding: 4px 10px;}
		.layui-table input{height: 30px;width: 60px;}
		.value-list{float: left;margin-right: 5px;}
		.value-list .del{padding: 0px 3px;background: #FF5722;border-radius: 50%;color: #fff;margin-left: 5px}
		.value-list a{margin: 0px 5px;}
	</style>
</head>
<body style="padding: 10px;">
	<div class="header">
		<span>新闻<?=$product['id']?'修改':'添加'?></span>
		<div></div>
	</div>

	<form class="layui-form" style="margin-top: 10px;">
		<input type="hidden" name="id" value="{$product.id}">
		<div style="float: left;width: 800px;">
			<div class="layui-form-item">
				<label class="layui-form-label">标题</label>
				<div class="layui-input-inline">
					<input type="text" class="layui-input" name="title" value="{$product.title}">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">&nbsp;</label>
				<div class="layui-input-inline">
					<button class="layui-btn layui-btn-sm" onclick="return false;" id="upload_img"><i class="layui-icon">&#xe67c;</i>上传图片</button>
					<div id="img">
						<?php if(!empty($product['imgs'])){ foreach($product['imgs'] as $v){ ?>
							<img class="img" style="height: 30px;" src="<?php echo $v; ?>" />
						<?php }} ?>
						<input type="hidden" name="img" value="{$product['img']}">
					</div>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">详情</label>
				<div class="layui-input-block">
					<textarea rows="10" cols="50" id="content">{$product.content}</textarea>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">状态</label>
				<div class="layui-input-inline">
					<input type="checkbox" layui-skin="primary" name="status" title="开启" <?php if($product['status']){echo 'checked';}?> value="1">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">要闻</label>
				<div class="layui-input-inline">
					<input type="checkbox" layui-skin="primary" name="hot" title="是" <?php if($product['hot']){echo 'checked';}?> value="1">
				</div>
			</div>
		</div>
	</form>
	<div class="layui-form-item">
		<div class="layui-input-block">
			<button class="layui-btn" onclick="save();return false;">保存</button>
		</div>
	</div>
	<script type="text/javascript">
		layui.use(['form','layer','upload'],function(){
			$ = layui.jquery;
			form = layui.form;
			layer = layui.layer;

			var upload = layui.upload;

			 // 执行上传实例
			var uploadInst = upload.render({
				elem: '#upload_img' //绑定元素
				,url: '/index.php/admins/product/upload_img' //上传接口
				,accept:'images'
				,done: function(res){
				  //上传完毕回调
					var html = '<img class="img" src="'+res.msg+'" style="height:30px" />';
					$('#img').append(html);
					var values = $('input[name="img"]').val();
					$('input[name="img"]').val(values+';'+res.msg);
				}
				,error: function(){
				  //请求异常回调
				}
			});
		});
		// 保存
		function save(){
			var data = new Object;
			// 商品数据
			data.id = $('input[name="id"]').val();
			data.title = $.trim($('input[name="title"]').val());
			data.img = $.trim($('input[name="img"]').val());
			data.content = $.trim($('#content').val());
			data.status = $('input[name="status"]').is(':checked')?1:0;
			data.hot = $('input[name="hot"]').is(':checked')?1:0;

			$.post('/index.php/admins/news/save',data,function(res){
				if(res.code>0){
					layer.msg(res.msg,{'icon':2,'anim':2});
				}else{
					layer.msg(res.msg,{'icon':1});
				}
			},'json');
		}
	</script>
</body>
</html>