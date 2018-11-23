<?php /*a:1:{s:73:"D:\phpStudy\PHPTutorial\WWW\admin\application\admins\view\cates\index.php";i:1525837596;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<title>手机分类</title>
	<link rel="stylesheet" type="text/css" href="/static/plugins/layui/css/layui.css">
	<script type="text/javascript" src="/static/plugins/layui/layui.js"></script>
	<style type="text/css">
		.header span{background: #009688;margin-left: 30px;padding: 10px;color:#ffffff;}
		.header div{border-bottom: solid 2px #009688;margin-top: 8px;}
	</style>
</head>
<body style="padding: 10px;">
	<div class="header">
		<span>分类管理</span>
		<div></div>
	</div>

	<form class="layui-form">
		<input type="hidden" name="flag" value="channel">
		<table class="layui-table">
			<thead>
				<tr>
					<th>ID</th>
					<th>排序</th>
					<th>标签名称</th>
					<th>是否禁用</th>
				</tr>
			</thead>
			<tbody>
				<?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
				<tr>
					<td><?php echo htmlentities($vo['id']); ?></td>
					<td><input type="text" class="layui-input" name="ords[<?php echo htmlentities($vo['id']); ?>]" value="<?php echo htmlentities($vo['ord']); ?>"></td>
					<td><input type="text" class="layui-input" name="titles[<?php echo htmlentities($vo['id']); ?>]" value="<?php echo htmlentities($vo['title']); ?>"></td>
					<td><input type="checkbox" lay-skin="primary" name="status[<?php echo htmlentities($vo['id']); ?>]" title="禁用" <?php echo !empty($vo['status']) ? 'checked' : ''; ?> value=1></td>
				</tr>
				<?php endforeach; endif; else: echo "" ;endif; ?>
				<tr>
					<td></td>
					<td><input type="text" class="layui-input" name="ords[0]"></td>
					<td><input type="text" class="layui-input" name="titles[0]"></td>
					<td><input type="checkbox" lay-skin="primary" name="status[0]" title="禁用" value=1></td>
				</tr>
			</tbody>
		</table>
	</form>
	<button class="layui-btn" onclick="save()">保存</button>
	<script type="text/javascript">
		layui.use(['layer','form'],function(){
			$ = layui.jquery;
			layer = layui.layer;
			form = layui.form;
		});

		// 保存
		function save(){
			$.post('/index.php/admins/Cates/save',$('form').serialize(),function(res){
				if(res.code>0){
					layer.alert(res.msg,{'icon':2});
				}else{
					layer.msg(res.msg,{'icon':1});
					setTimeout(function(){window.location.reload();},1000);
				}
			},'json');
		}
	</script>
</body> 
</html>