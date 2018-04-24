<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace App\Repositories\User;

class UserRepository implements \App\Contracts\Repository\User\UserRepositoryInterface
{
	public function userInfo($uid)
	{
		$user = \App\Models\User::where('user_id', $uid)->select('user_id as id', 'user_name', 'nick_name', 'sex', 'birthday', 'user_money', 'frozen_money', 'pay_points', 'rank_points', 'address_id', 'qq', 'mobile_phone', 'user_picture')->first();

		if ($user === null) {
			return array();
		}

		return $user->toArray();
	}
}

?>
