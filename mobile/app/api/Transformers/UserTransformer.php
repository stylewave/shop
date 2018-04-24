<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace App\Api\Transformers;

class UserTransformer extends \League\Fractal\TransformerAbstract
{
	public function transform(\App\Models\User $user)
	{
		return array('id' => $user->user_id, 'name' => $user->user_name);
	}
}

?>
