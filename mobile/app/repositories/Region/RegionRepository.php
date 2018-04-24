<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace App\Repositories\Region;

class RegionRepository implements \App\Contracts\Repository\Region\RegionRepositoryInterface
{
	public function getRegionName($regionId)
	{
		$regionName = \App\Models\Region::where('region_id', $regionId)->pluck('region_name')->toArray();

		if (empty($regionName)) {
			return '';
		}

		return $regionName[0];
	}
}

?>
