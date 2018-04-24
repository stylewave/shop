<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace App\Repositories\Shipping;

class ShippingRepository implements \App\Contracts\Repository\Shipping\ShippingRepositoryInterface
{
	private $goodsRepository;
	private $addressRepository;

	public function __construct(\App\Repositories\Goods\GoodsRepository $goodsRepository, \App\Repositories\User\AddressRepository $addressRepository)
	{
		$this->goodsRepository = $goodsRepository;
		$this->addressRepository = $addressRepository;
	}

	public function shippingList()
	{
		$shippingList = \App\Models\Shipping::select('*')->get()->toArray();
		return $shippingList;
	}

	public function find($id)
	{
		$shipping = \App\Models\Shipping::select('*')->where('shipping_id', $id)->where('enabled', 1)->first();

		if ($shipping === null) {
			return array();
		}

		return $shipping->toArray();
	}

	public function total_shipping_fee($address, $products, $shipping_id)
	{
		$uid = app('config')->get('uid');
		$prefix = 'dsc_';
		$weight = 0;
		$amount = 0;
		$number = 0;
		$IsShippingFree = true;

		if (isset($products)) {
			foreach ($products as $product) {
				$goods_weight = \App\Models\Goods::where(array('goods_id' => $product['goods_id']))->pluck('goods_weight')->toArray();
				$goods_weight = $goods_weight[0];
				$goods_weight = (0 < count($goods_weight) ? $goods_weight[0] : 0);

				if ($goods_weight) {
					$weight += $goods_weight * $product['goods_number'];
				}

				$amount += $this->goodsRepository->getFinalPrice($product['goods_id'], $product['goods_number']);
				$number += $product['goods_number'];

				if (!intval($product['is_shipping'])) {
					$IsShippingFree = false;
				}
			}
		}

		if ($IsShippingFree) {
			return 0;
		}

		if (!empty($address)) {
			$region_id_list = $this->addressRepository->getRegionIdList($address);
		}

		$model = \App\Models\Shipping::select('shipping_area.configure', 'shipping.shipping_code')->leftJoin('shipping_area', 'shipping_area.shipping_id', '=', 'shipping.shipping_id')->leftJoin('area_region', 'area_region.shipping_area_id', '=', 'shipping_area.shipping_area_id')->where('shipping.enabled', 1)->where('shipping.shipping_id', $shipping_id);

		if (!empty($region_id_list)) {
			$model->wherein('area_region.region_id', $region_id_list);
		}

		$result = $model->first();

		if ($result === null) {
			$result = array();
		}
		else {
			$result = $result->toArray();
		}

		if (!empty($result['configure'])) {
			$configure = $this->getConfigure($result['configure']);
			$fee = $this->calculate($configure, $result['shipping_code'], $weight, $amount, $number);
			return price_format($fee, false);
		}

		return false;
	}

	private function calculate($configure, $shipping_code, $goods_weight, $goods_amount, $goods_number)
	{
		$fee = 0;
		if ((0 < $configure['free_money']) && ($configure['free_money'] <= $goods_amount)) {
			return $fee;
		}

		switch ($shipping_code) {
		case 'city_express':
		case 'flat':
			$fee = (isset($configure['base_fee']) ? $configure['base_fee'] : 0);
			break;

		case 'ems':
			$fee = (isset($configure['base_fee']) ? $configure['base_fee'] : 0);
			$configure['fee_compute_mode'] = !empty($configure['fee_compute_mode']) ? $configure['fee_compute_mode'] : 'by_weight';

			if ($configure['fee_compute_mode'] == 'by_number') {
				$fee = $goods_number * $configure['item_fee'];
			}
			else if (0.5 < $goods_weight) {
				$fee += ceil(($goods_weight - 0.5) / 0.5) * $configure['step_fee'];
			}

			break;

		case 'post_express':
			$fee = (isset($configure['base_fee']) ? $configure['base_fee'] : 0);
			$configure['fee_compute_mode'] = !empty($configure['fee_compute_mode']) ? $configure['fee_compute_mode'] : 'by_weight';

			if ($configure['fee_compute_mode'] == 'by_number') {
				$fee = $goods_number * $configure['item_fee'];
			}
			else if (5 < $goods_weight) {
				$fee += 8 * $configure['step_fee'];
				$fee += ceil(($goods_weight - 5) / 0.5) * $configure['step_fee1'];
			}
			else if (1 < $goods_weight) {
				$fee += ceil(($goods_weight - 1) / 0.5) * $configure['step_fee'];
			}

			break;

		case 'post_mail':
			$fee = $configure['base_fee'] + $configure['pack_fee'];
			$configure['fee_compute_mode'] = !empty($configure['fee_compute_mode']) ? $configure['fee_compute_mode'] : 'by_weight';

			if ($configure['fee_compute_mode'] == 'by_number') {
				$fee = $goods_number * ($configure['item_fee'] + $configure['pack_fee']);
			}
			else if (5 < $goods_weight) {
				$fee += 4 * $configure['step_fee'];
				$fee += ceil($goods_weight - 5) * $configure['step_fee1'];
			}
			else if (1 < $goods_weight) {
				$fee += ceil($goods_weight - 1) * $configure['step_fee'];
			}

			break;

		case 'presswork':
			$fee = ($goods_weight * 4) + 3.3999999999999999;

			if (0.10000000000000001 < $goods_weight) {
				$fee += ceil(($goods_weight - 0.10000000000000001) / 0.10000000000000001) * 0.40000000000000002;
			}

			break;

		case 'sf_express':
		case 'sto_express':
		case 'yto':
			if ((0 < $configure['free_money']) && ($configure['free_money'] <= $goods_amount)) {
				return 0;
			}
			else {
				$fee = (isset($configure['base_fee']) ? $configure['base_fee'] : 0);
				$configure['fee_compute_mode'] = !empty($configure['fee_compute_mode']) ? $configure['fee_compute_mode'] : 'by_weight';

				if ($configure['fee_compute_mode'] == 'by_number') {
					$fee = $goods_number * $configure['item_fee'];
				}
				else if (1 < $goods_weight) {
					$fee += ceil($goods_weight - 1) * $configure['step_fee'];
				}
			}

			break;

		case 'zto':
			$fee = (isset($configure['base_fee']) ? $configure['base_fee'] : 0);
			$configure['fee_compute_mode'] = !empty($configure['fee_compute_mode']) ? $configure['fee_compute_mode'] : 'by_weight';

			if ($configure['fee_compute_mode'] == 'by_number') {
				$fee = $goods_number * $configure['item_fee'];
			}
			else if (1 < $goods_weight) {
				$fee += ceil($goods_weight - 1) * $configure['step_fee'];
			}

			break;

		default:
			$fee = 0;
			break;
		}

		$fee = floatval($fee);
		return $fee;
	}

	private function getConfigure($configure)
	{
		$data = array();
		$configure = unserialize($configure);

		foreach ($configure as $key => $val) {
			$data[$val['name']] = $val['value'];
		}

		return $data;
	}
}

?>
