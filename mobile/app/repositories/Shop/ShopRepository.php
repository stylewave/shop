<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace App\Repositories\Shop;

class ShopRepository implements \App\Contracts\Repository\Shop\ShopRepositoryInterface
{
	public function get($id)
	{
		return $this->findBY('id', $id);
	}

	public function findBY($key, $val)
	{
		$list = \App\Models\SellerShopinfo::select('ru_id', 'shop_name', 'shop_logo', 'shopname_audit')->with(array('MerchantsShopInformation' => function($query) {
			$query->select('shoprz_brandName', 'user_id', 'shopNameSuffix', 'rz_shopName');
		}))->where($key, $val)->get()->toArray();

		if (empty($list)) {
			$list = array();
			return $list;
		}

		foreach ($list as $k => $v) {
			$list[$k]['brandName'] = $v['merchants_shop_information']['shoprz_brandName'];
			$list[$k]['shopNameSuffix'] = $v['merchants_shop_information']['shopNameSuffix'];
			$list[$k]['rz_shopName'] = $v['merchants_shop_information']['rz_shopName'];
			unset($list[$k]['merchants_shop_information']);
		}

		return $list;
	}

	public function getPositions($tc_type = 'banner', $num = 3)
	{
		$time = time();
		$res = \App\Models\TouchAd::select('ad_id', 'touch_ad.position_id', 'media_type', 'ad_link', 'ad_code', 'ad_name')->with(array('position'))->join('touch_ad_position', 'touch_ad_position.position_id', '=', 'touch_ad.position_id')->where('start_time', '<=', $time)->where('end_time', '>=', $time)->where('enabled', 1)->where('touch_ad_position.tc_type', $tc_type)->orderby('ad_id', 'desc')->limit($num)->get()->toArray();
		$res = array_map(function($v) {
			if (!empty($v['position'])) {
				$temp = array_merge($v, $v['position']);
				unset($temp['position']);
				return $temp;
			}
		}, $res);
		return $res;
	}
}

?>
