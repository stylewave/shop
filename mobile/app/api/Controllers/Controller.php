<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace App\Api\Controllers;

class Controller extends \Laravel\Lumen\Routing\Controller
{
	use \Dingo\Api\Routing\Helpers;

	protected function apiReturn($data, $code = 0)
	{
		return array('code' => $code, 'data' => $data);
	}
}

?>
