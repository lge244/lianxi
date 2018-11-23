<?php
namespace app\api\controller;
use think\Controller;
use Util\data\Sysdb;

class Home extends Base
{
	# 首页
	public function index(){
		# 获取banner图
		$banner = $this->db->table('slide')->where(array('type'=>0))->lists();
		if($banner){
			foreach($banner as &$banner_v){
				$banner_v['img'] = str_replace('\\','/',$banner_v['img']);
				$banner_img[] = 'http://'.$_SERVER['HTTP_HOST'].$banner_v['img'];
			}
		}
		# 获取要闻
		$new = $this->db->table('news')->where(array('status'=>1,'hot'=>1))->lists();
		if($new){
			foreach($new as &$new_v){
				$new_imgs = explode(';', $new_v['img']);
				$new_img  = str_replace('\\','/',$new_imgs[0]);
				$new_v['img'] = 'http://'.$_SERVER['HTTP_HOST'].$new_img;
				$new_v['add_time_s'] = date('Y-m-d H:i',$new_v['add_time']);
			}
		}
		$arr = array(
			'img' => $banner_img,
			'new' => $new,
		);
		$this->returnCode(0,$arr);
	}
	# 产品列表
	public function shop_list(){
		$page = (int)input('post.page');
		$product = $this->db->table('product')->where(array('status'=>1))->pages_api(10,$page);
		if($product['lists']){
			foreach($product['lists'] as &$product_v){
				$product_imgs = explode(';', $product_v['img']);
				$product_img  = str_replace('\\','/',$product_imgs[0]);
				$product_v['img'] = 'http://'.$_SERVER['HTTP_HOST'].$product_img;
			}
		}
		$this->returnCode(0,$product);
	}
	# 产品详情
	public function shop_details(){
		$id = (int)input('post.id');
		$product = $this->db->table('product')->where(array('id'=>$id))->item();
		if($product){
			$img = explode(';', $product['img']);
			foreach($img as $img_v){
				$product_img  = str_replace('\\','/',$img_v);
				$product['imgs'][] = 'http://'.$_SERVER['HTTP_HOST'].$product_img;
			}
		}else{
			$product = [];
		}
		$this->returnCode(0,$product);
	}
	# 新闻列表
	public function new_list(){
		$page = (int)input('post.page');
		$news = $this->db->table('news')->where(array('status'=>1))->pages_api(4,$page);
		if($news['lists']){
			foreach($news['lists'] as &$news_v){
				$news_imgs = explode(';', $news_v['img']);
				$news_img  = str_replace('\\','/',$news_imgs[0]);
				$news_v['img'] = 'http://'.$_SERVER['HTTP_HOST'].$news_img;
				$news_v['add_time_s'] = date('Y-m-d H:i',$news_v['add_time']);
			}
		}
		$this->returnCode(0,$news);
	}
	# 新闻详情
	public function new_details(){
		$id = (int)input('post.id');
		$news = $this->db->table('news')->where(array('id'=>$id))->item();
		if($news){
			$img = explode(';', $news['img']);
			foreach($img as $img_v){
				$news_img  = str_replace('\\','/',$img_v);
				$news['imgs'][] = 'http://'.$_SERVER['HTTP_HOST'].$news_img;
				$news['add_time_s'] = date('Y-m-d H:i',$news['add_time']);
			}
		}else{
			$news = [];
		}
		$this->returnCode(0,$news);
	}
}