<?php /*a:1:{s:77:"D:\phpStudy\PHPTutorial\WWW\admin\application\admins\view\slide\add_first.php";i:1533870625;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<title>添加广告</title>
	<link rel="stylesheet" type="text/css" href="/static/plugins/layui/css/layui.css">
	<script type="text/javascript" src="/static/plugins/layui/layui.js"></script>
</head>
<body style="padding: 10px;">
	<form class="layui-form">
		<input type="hidden" name="type" value="0">
		<input type="hidden" name="id" value="<?php echo htmlentities($data['id']); ?>">
		<div class="layui-form-item">
			<label class="layui-form-label">标题</label>
			<div class="layui-input-block">
				<input type="text" class="layui-input" name="title" value="<?php echo htmlentities($data['title']); ?>">
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">排序</label>
			<div class="layui-input-block">
				<input type="text" class="layui-input" name="ord" value="<?php echo htmlentities($data['ord']); ?>">
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">URL</label>
			<div class="layui-input-block">
				<input type="text" class="layui-input" name="url" value="<?php echo htmlentities($data['url']); ?>">
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">图片上传</label>
			<div class="layui-input-block">
				<button class="layui-btn layui-btn-sm" id="upload_img" onclick="return false;">上传</button>
				<img id="preview_img" <?php if($data['img']){echo 'src="'.$data['img'].'"';}?> style="height: 30px;" />
				<input type="hidden" name="img" value="<?php echo htmlentities($data['img']); ?>" />
			</div>
		</div>
	</form>
	<hr />
	<div class="layui-form-item">
		<div class="layui-input-block">
			<button class="layui-btn" onclick="save()">保存</button>
		</div>
	</div>
</body>
</html>
<script type="text/javascript">
	layui.use(['layer','upload'],function(){
		layer = layui.layer;
		upload = layui.upload;
		$ = layui.jquery;

		var uploadInst = upload.render({
		    elem: '#upload_img' //绑定元素
		    ,url: '/index.php/admins/product/upload_img' //上传接口
		    ,done: function(res){
				$('#preview_img').attr('src',res.msg);
				$('input[name="img"]').val(res.msg);
		    }
		    ,error: function(){
		      //请求异常回调
		    }
		});
	});

	function save(){
		var title = $.trim($('input[name="title"]').val());
		var url = $.trim($('input[name="url"]').val());
		var img = $.trim($('input[name="img"]').val());
		if(title==''){
			layer.msg('请输入标题',{'icon':2,'anim':6});
			return;
		}
		if(url = ''){
			layer.msg('请输入URL',{'icon':2,'anim':6});
			return;
		}
		if(img = ''){
			layer.msg('请上传图片',{'icon':2,'anim':6});
			return;
		}

		$.post('/index.php/admins/slide/save',$('form').serialize(),function(res){
			if(res.code>0){
				layer.msg(res.msg,{'icon':2,'anim':6});
			}else{
				layer.msg(res.msg,{'icon':1});
				setTimeout(function(){parent.window.location.reload();},1000);
			}
		},'json');
	}
</script>