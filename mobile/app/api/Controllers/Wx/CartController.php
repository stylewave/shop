<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace App\Api\Controllers\Wx;

class CartController extends \App\Api\Controllers\Controller
{
	private $cartService;
	private $authService;

	public function __construct(\App\Services\CartService $cartService, \App\Services\AuthService $authService)
	{
		$this->cartService = $cartService;
		$this->authService = $authService;
	}

	public function cart(\Illuminate\Http\Request $request)
	{
		$this->validate($request, array());
		$cart = $this->cartService->getCart();
		return $this->apiReturn($cart);
	}

	public function addGoodsToCart(\Illuminate\Http\Request $request)
	{
		$this->validate($request, array('id' => 'required|integer', 'num' => 'required|integer', 'goods_attr' => 'integer'));
		$res = $this->authService->authorization();
		$args = array_merge($request->all(), array('uid' => $res));
		$result = $this->cartService->addGoodsToCart($args);
		return $this->apiReturn($result);
	}

	public function updateCartGoods(\Illuminate\Http\Request $request)
	{
		$this->validate($request, array('id' => 'required|integer', 'amount' => 'required|integer'));
		$uid = $this->authService->authorization();
		$args = $request->all();
		$args['uid'] = $uid;
		return $this->cartService->updateCartGoods($args);
	}

	public function deleteCartGoods(\Illuminate\Http\Request $request)
	{
		$this->validate($request, array('id' => 'required|integer'));
		$uid = $this->authService->authorization();
		$args = $request->all();
		$args['uid'] = $uid;
		$res = $this->cartService->deleteCartGoods($args);
		return $res;
	}
}

?>
