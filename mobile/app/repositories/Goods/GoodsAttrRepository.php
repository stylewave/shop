<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace App\Repositories\Goods;

class GoodsAttrRepository implements \App\Contracts\Repository\Goods\GoodsAttrRepositoryInterface
{
	public function propertyPrice($property)
	{
		if (!empty($property)) {
			if (is_array($property)) {
				foreach ($property as $key => $val) {
					if (strpos($val, ',')) {
						$property = explode(',', $val);
					}
					else {
						$property[$key] = addslashes($val);
					}
				}
			}
			else {
				$property = addslashes($property);
			}

			$price = \App\Models\GoodsAttr::wherein('goods_attr_id', $property)->sum('attr_price');
		}
		else {
			$price = 0;
		}

		return empty($price) ? 0 : $price;
	}
}

?>
