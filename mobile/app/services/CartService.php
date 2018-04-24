<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace App\Services;

class CartService
{
	private $cartRepository;
	private $goodsRepository;
	private $authService;

	public function __construct(\App\Repositories\Cart\CartRepository $cartRepository, \App\Repositories\Goods\GoodsRepository $goodsRepository, AuthService $authService)
	{
		$this->cartRepository = $cartRepository;
		$this->goodsRepository = $goodsRepository;
		$this->authService = $authService;
	}

	public function getCart()
	{
		$cart = $this->getCartGoods();
		$result = array();

		foreach ($cart['goods_list'] as $v) {
			$result['cart_list'][$v['ru_id']][] = array('rec_id' => $v['rec_id'], 'user_id' => $v['user_id'], 'ru_id' => $v['ru_id'], 'shop_name' => $v['shop_name'], 'goods_id' => $v['goods_id'], 'goods_name' => $v['goods_name'], 'market_price' => strip_tags($v['market_price']), 'goods_price' => strip_tags($v['goods_price']), 'goods_number' => $v['goods_number'], 'goods_attr' => $v['goods_attr'], 'goods_attr_id' => $v['goods_attr_id'], 'goods_thumb' => get_image_path($v['goods']['goods_thumb']));
		}

		$result['total'] = array_map('strip_tags', $cart['total']);
		$result['best_goods'] = $this->getBestGoods();
		return $result;
	}

	private function getCartGoods()
	{
		$userId = $this->authService->authorization();
		$list = $this->cartRepository->getGoodsInCartByUser($userId);
		return $list;
	}

	private function getBestGoods()
	{
		$list = $this->goodsRepository->findByType('best');
		$bestGoods = array_map(function($v) {
			return array('goods_id' => $v['goods_id'], 'goods_name' => $v['goods_name'], 'market_price' => $v['market_price'], 'shop_price' => $v['shop_price'], 'goods_thumb' => get_image_path($v['goods_thumb']));
		}, $list);
		return $bestGoods;
	}

	public function addGoodsToCart($params)
	{
		$goods = $this->goodsRepository->find($params['id']);

		if ($goods['is_on_sale'] != 1) {
			return '商品已下架';
		}

		$goodsAttr = (empty($params['goods_attr']) ? '' : $params['goods_attr']);
		$product = $this->goodsRepository->getProductByGoods($params['id'], $goodsAttr);
		$arguments = array('goods_id' => $params['id'], 'user_id' => $params['uid'], 'goods_sn' => $goods['goods_sn'], 'product_id' => empty($product['id']) ? '' : $product['id'], 'group_id' => '', 'goods_name' => $goods['goods_name'], 'market_price' => $goods['market_price'], 'goods_price' => $goods['shop_price'], 'goods_number' => $params['num'], 'goods_attr' => empty($params['goods_attr']) ? '' : $params['goods_attr'], 'is_real' => $goods['is_real'], 'extension_code' => empty($params['extension_code']) ? '' : $params['extension_code'], 'parent_id' => $params['num'], 'rec_type' => 0, 'is_gift' => $params['num'], 'is_shipping' => $goods['is_shipping'], 'can_handsel' => '', 'model_attr' => $goods['model_attr'], 'goods_attr_id' => '', 'ru_id' => $goods['user_id'], 'shopping_fee' => '', 'warehouse_id' => '', 'area_id' => '', 'add_time' => time(), 'stages_qishu' => '', 'store_id' => '', 'freight' => '', 'tid' => '', 'shipping_fee' => '', 'store_mobile' => '', 'take_time' => '', 'is_checked' => '');
		return $this->cartRepository->addGoodsToCart($arguments);
	}

	public function updateCartGoods($args)
	{
		$res = $this->cartRepository->update($args['uid'], $args['id'], $args['amount']);

		if ($res) {
			return array('code' => 0, 'msg' => '添加成功');
		}

		return array('code' => 1, 'msg' => '添加失败');
	}

	public function deleteCartGoods($args)
	{
		$res = $this->cartRepository->deleteOne($args['id'], $args['uid']);
		$result = array();

		switch ($res) {
		case 0:
			$result['code'] = 1;
			$result['msg'] = '购物车中没有该商品';
			break;

		case 1:
			$result['code'] = 0;
			$result['msg'] = '删除一个商品';
			break;

		default:
			$result['code'] = 1;
			$result['msg'] = '删除失败';
			break;
		}

		return $result;
	}
}


?>
