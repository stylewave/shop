<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace App\Repositories\Goods;

class CollectGoodsRepository implements \App\Contracts\Repository\Goods\CollectGoodsRepositoryInterface
{
	public function findByUserId($userId, $page, $size)
	{
		$start = ($page - 1) * $size;
		return \App\Models\CollectGoods::where('user_id', $userId)->offset($start)->limit($size)->get()->toArray();
	}
}

?>
