<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace App\Repositories\User;

class AddressRepository implements \App\Contracts\Repository\user\AddressRepositoryInterface
{
	public function addressListByUserId($id)
	{
		return \App\Models\UserAddress::select('address_id', 'address_name', 'consignee', 'email', 'mobile', 'country', 'province', 'city', 'district', 'street', 'address')->where('user_id', $id)->get()->toArray();
	}

	public function addAddress($args)
	{
		$model = new \App\Models\UserAddress();

		foreach ($args as $k => $v) {
			$model->$k = $v;
		}

		$model->save();
		return $model->address_id;
	}

	public function updateAddress($id, array $args)
	{
		$model = \App\Models\UserAddress::where('user_id', $args['user_id'])->where('address_id', $id)->first();

		if ($model === null) {
			return array();
		}

		foreach ($args as $k => $v) {
			$model->$k = $v;
		}

		return $model->save();
	}

	public function deleteAddress($id, $uid)
	{
		return \App\Models\UserAddress::where('user_id', $uid)->where('address_id', $id)->delete();
	}

	public function find($address_id)
	{
		$address = \App\Models\UserAddress::where('address_id', $address_id)->first();

		if ($address_id === null) {
			return array();
		}

		return $address;
	}

	public function getRegionIdList($address_id)
	{
		$arr = array();

		if ($model = \App\Models\UserAddress::where(array('address_id' => $address_id))->first()) {
			$arr['country'] = $model->country;
			$arr['province'] = $model->province;
			$arr['city'] = $model->city;
			$arr['district'] = $model->district;
		}

		return $arr;
	}
}

?>
