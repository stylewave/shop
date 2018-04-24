<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace App\Services;

class UserService
{
	private $orderRepository;
	private $goodsRepository;
	private $userRepository;
	private $addressRepository;
	private $regionRepository;
	private $userBonusRepository;
	private $accountRepository;
	private $collectGoodsRepository;

	public function __construct(\App\Repositories\Order\OrderRepository $orderRepository, \App\Repositories\Goods\GoodsRepository $goodsRepository, \App\Repositories\User\UserRepository $userRepository, \App\Repositories\User\AddressRepository $addressRepository, \App\Repositories\Region\RegionRepository $regionRepository, \App\Repositories\Bonus\UserBonusRepository $userBonusRepository, \App\Repositories\User\AccountRepository $accountRepository, \App\Repositories\Goods\CollectGoodsRepository $collectGoodsRepository)
	{
		$this->orderRepository = $orderRepository;
		$this->goodsRepository = $goodsRepository;
		$this->userRepository = $userRepository;
		$this->addressRepository = $addressRepository;
		$this->regionRepository = $regionRepository;
		$this->userBonusRepository = $userBonusRepository;
		$this->accountRepository = $accountRepository;
		$this->collectGoodsRepository = $collectGoodsRepository;
	}

	public function userCenter(array $args)
	{
		$userId = $args['uid'];
		$result['order']['all_num'] = $this->orderRepository->orderNum($userId);
		$result['order']['no_paid_num'] = $this->orderRepository->orderNum($userId, 0);
		$result['order']['no_received_num'] = $this->orderRepository->orderNum($userId, 1);
		$result['order']['no_evaluation_num'] = $this->orderRepository->orderNum($userId, 3);
		$result['userInfo'] = $this->userRepository->userInfo($userId);
		$bestGoods = $this->goodsRepository->findByType('best');
		$result['best_goods'] = array_map(function($v) {
			return array('goods_id' => $v['goods_id'], 'goods_name' => $v['goods_name'], 'market_price' => $v['market_price'], 'shop_price' => $v['shop_price'], 'goods_thumb' => get_image_path($v['goods_thumb']));
		}, $bestGoods);
		return $result;
	}

	public function orderList($args)
	{
		$orderList = $this->orderRepository->getOrderByUserId($args['uid'], $args['status']);

		foreach ($orderList as $k => $v) {
			$orderList[$k]['add_time'] = date('Y-m-d H:i', $v['add_time']);
			$orderList[$k]['order_status'] = $this->orderStatus($v['order_status']);
			$orderList[$k]['pay_status'] = $this->payStatus($v['pay_status']);
			$orderList[$k]['shipping_status'] = $this->shipStatus($v['shipping_status']);
			$dataTotalNumber = 0;

			foreach ($v['goods'] as $gk => $gv) {
				$dataTotalNumber += $gv['goods_number'];
			}

			unset($orderList[$k]['goods']);
			$orderList[$k]['total_number'] = $dataTotalNumber;
			$orderList[$k]['total_amount'] = price_format($v['money_paid'] + $v['order_amount'], false);
		}

		return $orderList;
	}

	private function orderStatus($num)
	{
		$array = array('未确认', '已确认', '已取消', '无效', '退货', '已分单', '部分分单');
		return $array[$num];
	}

	private function payStatus($num)
	{
		$array = array('未付款', '付款中', '已付款');
		return $array[$num];
	}

	private function shipStatus($num)
	{
		$array = array('未发货', '已发货', '已收货', '备货中', '已发货(部分商品)', '发货中(处理分单)', '已发货(部分商品)');
		return $array[$num];
	}

	public function userAddressList($userId)
	{
		$res = $this->addressRepository->addressListByUserId($userId);
		$list = array_map(function($v) {
			$v['country_name'] = $this->regionRepository->getRegionName($v['country']);
			$v['province_name'] = $this->regionRepository->getRegionName($v['province']);
			$v['city_name'] = $this->regionRepository->getRegionName($v['city']);
			$v['district_name'] = $this->regionRepository->getRegionName($v['district']);
			$v['street_name'] = $this->regionRepository->getRegionName($v['street']);
			unset($v['country']);
			unset($v['province']);
			unset($v['city']);
			unset($v['district']);
			unset($v['street']);
			$v['address'] = $v['country_name'] . ' ' . $v['province_name'] . ' ' . $v['city_name'] . ' ' . $v['district_name'] . ' ' . $v['street_name'] . ' ' . $v['address'];
			return $v;
		}, $res);
		return $list;
	}

	public function addressAdd(array $args)
	{
		$arr = array('user_id' => $args['uid'], 'consignee' => $args['consignee'], 'email' => '', 'country' => !empty($args['country']) ? $args['country'] : '', 'province' => !empty($args['province']) ? $args['province'] : '', 'city' => !empty($args['city']) ? $args['city'] : '', 'district' => !empty($args['region']) ? $args['region'] : '', 'address' => $args['address'], 'mobile' => isset($args['mobile']) ? $args['mobile'] : '', 'address_name' => '', 'sign_building' => '', 'best_time' => '');
		$res = $this->addressRepository->addAddress($arr);
		return $res;
	}

	public function addressUpdate($args)
	{
		$arr = array('user_id' => $args['uid'], 'consignee' => $args['consignee'], 'email' => '', 'country' => !empty($args['country']) ? $args['country'] : '', 'province' => !empty($args['province']) ? $args['province'] : '', 'city' => !empty($args['city']) ? $args['city'] : '', 'district' => !empty($args['region']) ? $args['region'] : '', 'address' => $args['address'], 'mobile' => isset($args['mobile']) ? $args['mobile'] : '', 'address_name' => '', 'sign_building' => '', 'best_time' => '');
		$res = $this->addressRepository->updateAddress($args['id'], $arr);
		return (int) $res;
	}

	public function addressDelete($args)
	{
		$res = $this->addressRepository->deleteAddress($args['id'], $args['uid']);
		return $res;
	}

	public function userAccount($userId)
	{
		$userInfo = $this->userRepository->userInfo($userId);

		if (empty($userInfo)) {
			return array();
		}

		$result['user_money'] = $userInfo['user_money'];
		$result['frozen_money'] = $userInfo['frozen_money'];
		$result['pay_points'] = $userInfo['pay_points'];
		$result['bonus_num'] = $this->userBonusRepository->getUserBonusCount($userId);
		return $result;
	}

	public function accountDetail($args)
	{
		$list = $this->accountRepository->accountList($args['user_id'], $args['page'], $args['size']);
		$accountList = array_map(function($v) {
			return array('log_sn' => $v['log_id'], 'money' => $v['user_money'], 'time' => $v['change_time']);
		}, $list);
		return $accountList;
	}

	public function accountLog($args)
	{
		$list = $this->accountRepository->accountLogList($args['user_id'], $args['page'], $args['size']);
		$logList = array_map(function($v) {
			return array('log_sn' => $v['id'], 'money' => $v['amount'], 'time' => $v['add_time'], 'type' => $v['process_type'] == 0 ? '充值' : '提现', 'status' => $v['is_paid'] == 0 ? '未支付' : '已支付');
		}, $list);
		return $logList;
	}

	public function deposit($args)
	{
		$arr = array('user_id' => $args['uid'], 'amount' => $args['amount'], 'add_time' => time(), 'user_note' => $args['user_note'], 'payment' => $args['payment']);
		return $this->accountRepository->deposit($arr);
	}

	public function collectGoods($args)
	{
		$list = $this->collectGoodsRepository->findByUserId($args['user_id'], $args['page'], $args['size']);
		$collect = array_map(function($v) {
			$goodsInfo = $this->goodsRepository->goodsInfo($v['goods_id']);
			return array('goods_name' => $goodsInfo['goods_name'], 'shop_price' => $goodsInfo['goods_price'], 'goods_thumb' => get_image_path($goodsInfo['goods_thumb']), 'goods_stock' => $goodsInfo['stock'], 'time' => $v['add_time']);
		}, $list);
		return $collect;
	}

	public function myConpont($args)
	{
		$list = array();
		return $list;
	}
}


?>
