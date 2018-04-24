<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace App\Api\Controllers\Wx;

class FlowController extends \App\Api\Controllers\Controller
{
	private $flowService;
	private $authService;

	public function __construct(\App\Services\FlowService $flowService, \App\Services\AuthService $authService)
	{
		$this->flowService = $flowService;
		$this->authService = $authService;
	}

	public function index(\Illuminate\Http\Request $request)
	{
		$this->validate($request, array());
		$userId = $this->authService->authorization();
		$flowInfo = $this->flowService->flowInfo($userId);
		return $this->apiReturn($flowInfo);
	}

	public function down(\Illuminate\Http\Request $request)
	{
		$this->validate($request, array('consignee' => 'required|integer'));
		$userId = $this->authService->authorization();
		$args = $request->all();
		$args['uid'] = $userId;
		$res = $this->flowService->submitOrder($args);

		if ($res['error'] == 1) {
			return $this->apiReturn($res, 1);
		}

		return $this->apiReturn($res);
	}
}

?>
