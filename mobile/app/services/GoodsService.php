<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace App\Services;

class GoodsService
{
	private $goodsRepository;

	public function __construct(\App\Repositories\Goods\GoodsRepository $goodsRepository)
	{
		$this->goodsRepository = $goodsRepository;
	}

	public function getGoodsList($categoryId = 0, $page = 1)
	{
		$page = (empty($page) ? 1 : $page);
		$size = 10;
		$field = array('goods_id', 'goods_name', 'shop_price', 'goods_thumb', 'goods_number', 'market_price', 'sales_volume');
		$list = $this->goodsRepository->findBy('category', $categoryId, $page, $size, $field);
		return $list;
	}

	public function goodsDetail($id)
	{
		$result = array('goods_img' => '', 'goods_info' => '', 'goods_comment' => '', 'goods_properties' => '');
		$result['goods_comment'] = $this->goodsRepository->goodsComment($id);
		$result['goods_info'] = $this->goodsRepository->goodsInfo($id);
		$result['goods_img'] = $this->goodsRepository->goodsGallery($id);
		$result['goods_properties'] = $this->goodsRepository->goodsProperties($id);
		return $result;
	}

	public function goodsPropertiesPrice($goodsId)
	{
		$goodsId = 1692;
		return $goodsId;
	}
}


?>
