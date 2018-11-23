<?php
/**
* 标签管理
*/
namespace app\admins\controller;
use app\admins\controller\BaseAdmin;

class Cates extends BaseAdmin{

	// 分类管理
	public function index(){
		$channel = $this->db->table('product_cates')->lists();
		$this->assign('data',$channel);
		return $this->fetch();
	}

	public function save(){
		$ords = input('post.ords/a');
		$titles = input('post.titles/a');
		$status = input('post.status/a');

		foreach ($ords as $key => $value) {
			// 新增
			$data['ord'] = $value;
			$data['title'] = $titles[$key];
			$data['status'] = isset($status[$key]) ? 1 : 0;

			if($key==0 && $data['title']){
				$this->db->table('product_cates')->insert($data);
			}
			if($key > 0){
				if($data['title']==''){
					// 删除
					$this->db->table('product_cates')->where(array('id'=>$key))->delete();
				}else{
					// 修改
					$this->db->table('product_cates')->where(array('id'=>$key))->update($data);
				}
			}
		}
		exit(json_encode(array('code'=>0,'msg'=>'保存成功')));
	}
}