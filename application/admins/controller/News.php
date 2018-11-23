<?php
/**
* 新闻管理
*/
namespace app\admins\controller;
use app\admins\controller\BaseAdmin;
use think\Db;

class News extends BaseAdmin{
	// 首页新闻
	public function index(){
		$data['pageSize'] = 15;
		$data['page'] = max(1,(int)input('get.page'));

		$data['wd'] = trim(input('get.wd'));
		$where = array();
		$data['wd'] && $where = 'title like "%'.$data['wd'].'%"';
		$data['data'] = $this->db->table('news')->where($where)->order('id desc')->pages($data['pageSize']);
		foreach ($data['data']['lists'] as &$item) {
			$img = explode(';',$item['img']);
			$item['img'] = $img[0];
		}
		$this->assign('data',$data);
		return $this->fetch();
	}
	// 添加新闻
	public function add(){
		$product_id = (int)input('get.id');
		// 商品信息
		$data['product'] = $this->db->table('news')->where(array('id'=>$product_id))->item();
		if($data['product']['img']){
			$img = explode(';',$data['product']['img']);
			$data['product']['imgs'] = $img;
		}
		return $this->fetch('',$data);
	}
	// 保存新闻
	public function save(){
		$id = (int)input('post.id');
		$data['title'] = trim(input('post.title'));
		$data['content'] = trim(input('post.content'));
		$data['status'] = (int)input('post.status');
		$data['hot'] = (int)(input('post.hot'));

		$img = trim(input('post.img'));
		$img = ltrim($img,';');
		$data['img'] = $img;
		if($data['title']=='' || $data['content']=='' || $data['img']==''){
			exit(json_encode(array('code'=>1,'msg'=>'数据不能为空')));
		}
		if($id>0){
			$this->db->table('news')->where(array('id'=>$id))->update($data);
		}else{
			$data['add_time'] = time();
			$this->db->table('news')->insert($data);
		}
		exit(json_encode(array('code'=>0,'msg'=>'保存成功')));
	}
	// 删除新闻
	public function delete(){
		$id = (int)input('post.id');
		$this->db->table('news')->where(array('id'=>$id))->delete();
		exit(json_encode(array('code'=>0,'msg'=>'删除成功')));
	}
}