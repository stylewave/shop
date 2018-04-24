<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace App\Api\Controllers\Wx;

class GoodsController extends \App\Api\Controllers\Controller
{
	private $goodsService;

	public function __construct(\App\Services\GoodsService $goodsService)
	{
		$this->goodsService = $goodsService;
	}

	public function goodsList(\Illuminate\Http\Request $request)
	{
		$this->validate($request, array('id' => 'required', 'page' => 'required|int'));
		$list = $this->goodsService->getGoodsList($request->get('id'), $request->get('page'));
		return $this->apiReturn($list);
	}

	public function goodsDetail(\Illuminate\Http\Request $request)
	{
		$this->validate($request, array('id' => 'required|integer'));
		$list = $this->goodsService->goodsDetail($request->get('id'));
		return $this->apiReturn($list);
	}

	public function property(\Illuminate\Http\Request $request)
	{
		$this->validate($request, array('id' => 'required|integer', 'attr_id' => 'required', 'num' => 'required|integer'));
		$price = $this->goodsService->goodsPropertiesPrice($request->get('id'));
		return $this->apiReturn($price);
	}
}

?>
