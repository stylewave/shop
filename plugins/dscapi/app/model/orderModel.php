<?php
//zend by 旺旺dongshaolin2008所有  禁止倒卖 一经发现停止任何服务
namespace app\model;

abstract class orderModel extends \app\func\common
{
	private $alias_config;

	public function __construct()
	{
		$this->orderModel();
	}

	public function orderModel($table = '')
	{
		$this->alias_config = array('order' => 'o', 'order_goods' => 'og');

		if ($table) {
			return $this->alias_config[$table];
		}
		else {
			return $this->alias_config;
		}
	}

	public function get_where($val = array(), $alias = '')
	{
		$where = 1;
		$where .= \app\func\base::get_where($val['seller_id'], $alias . 'ru_id');
		$where .= \app\func\base::get_where($val['order_id'], $alias . 'order_id');
		$where .= \app\func\base::get_where($val['order_sn'], $alias . 'order_sn');
		$where .= \app\func\base::get_where($val['mobile'], $alias . 'mobile');
		$where .= \app\func\base::get_where($val['rec_id'], $alias . 'rec_id');
		$where .= \app\func\base::get_where($val['goods_sn'], $alias . 'goods_sn');
		$where .= \app\func\base::get_where($val['goods_id'], $alias . 'goods_id');
		return $where;
	}

	public function get_select_list($table, $select, $where, $page_size, $page, $sort_by, $sort_order)
	{
		$sql = 'SELECT COUNT(*) FROM ' . $GLOBALS['ecs']->table($table) . ' WHERE ' . $where;
		$result['record_count'] = $GLOBALS['db']->getOne($sql);

		if ($sort_by) {
			$where .= ' ORDER BY ' . $sort_by . ' ' . $sort_order . ' ';
		}

		$where .= ' LIMIT ' . (($page - 1) * $page_size) . ',' . $page_size;
		$sql = 'SELECT ' . $select . ' FROM ' . $GLOBALS['ecs']->table($table) . ' WHERE ' . $where;
		$result['list'] = $GLOBALS['db']->getAll($sql);
		return $result;
	}

	public function get_select_info($table, $select, $where)
	{
		$sql = 'SELECT ' . $select . ' FROM ' . $GLOBALS['ecs']->table($table) . ' WHERE ' . $where . ' LIMIT 1';
		$result = $GLOBALS['db']->getRow($sql);
		return $result;
	}

	public function get_insert($table, $select, $format)
	{
		$orderLang = \languages\orderLang::lang_order_insert();
		$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table($table), $select, 'INSERT');
		$id = $GLOBALS['db']->insert_id();
		$common_data = array('result' => empty($id) ? 'failure' : 'success', 'msg' => empty($id) ? $orderLang['msg_failure']['failure'] : $orderLang['msg_success']['success'], 'error' => empty($id) ? $orderLang['msg_failure']['error'] : $orderLang['msg_success']['error'], 'format' => $format);
		\app\func\common::common($common_data);
		return \app\func\common::data_back();
	}

	public function get_update($table, $select, $where, $format)
	{
		$orderLang = \languages\orderLang::lang_order_update();

		if (strlen($where) != 1) {
			$info = $this->get_select_info($table, '*', $where);

			if (!$info) {
				$common_data = array('result' => 'failure', 'msg' => $userLang['null_failure']['failure'], 'error' => $userLang['null_failure']['error'], 'format' => $format);
			}
			else {
				$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table($table), $select, 'UPDATE', $where);
				$common_data = array('result' => empty($select) ? 'failure' : 'success', 'msg' => empty($select) ? $orderLang['msg_failure']['failure'] : $orderLang['msg_success']['success'], 'error' => empty($select) ? $orderLang['msg_failure']['error'] : $orderLang['msg_success']['error'], 'format' => $format);
			}
		}
		else {
			$common_data = array('result' => 'failure', 'msg' => $orderLang['where_failure']['failure'], 'error' => $orderLang['where_failure']['error'], 'format' => $format);
		}

		\app\func\common::common($common_data);
		return \app\func\common::data_back();
	}

	public function get_delete($table, $where, $format)
	{
		$orderLang = \languages\orderLang::lang_order_delete();

		if (strlen($where) != 1) {
			$sql = 'DELETE FROM ' . $GLOBALS['ecs']->table($table) . ' WHERE ' . $where;
			$GLOBALS['db']->query($sql);
			$common_data = array('result' => 'success', 'msg' => $orderLang['msg_success']['success'], 'error' => $orderLang['msg_success']['error'], 'format' => $format);
		}
		else {
			$common_data = array('result' => 'failure', 'msg' => $orderLang['where_failure']['failure'], 'error' => $orderLang['where_failure']['error'], 'format' => $format);
		}

		\app\func\common::common($common_data);
		return \app\func\common::data_back();
	}

	public function get_list_common_data($result, $page_size, $page, $orderLang, $format)
	{
		$common_data = array('page_size' => $page_size, 'page' => $page, 'result' => empty($result) ? 'failure' : 'success', 'msg' => empty($result) ? $orderLang['msg_failure']['failure'] : $orderLang['msg_success']['success'], 'error' => empty($result) ? $orderLang['msg_failure']['error'] : $orderLang['msg_success']['error'], 'format' => $format);
		\app\func\common::common($common_data);
		$result = \app\func\common::data_back($result, 1);
		return $result;
	}

	public function get_info_common_data_fs($result, $orderLang, $format)
	{
		$common_data = array('result' => empty($result) ? 'failure' : 'success', 'msg' => empty($result) ? $orderLang['msg_failure']['failure'] : $orderLang['msg_success']['success'], 'error' => empty($result) ? $orderLang['msg_failure']['error'] : $orderLang['msg_success']['error'], 'format' => $format);
		\app\func\common::common($common_data);
		$result = \app\func\common::data_back($result);
		return $result;
	}

	public function get_info_common_data_f($orderLang, $format)
	{
		$result = array();
		$common_data = array('result' => 'failure', 'msg' => $orderLang['where_failure']['failure'], 'error' => $orderLang['where_failure']['error'], 'format' => $format);
		\app\func\common::common($common_data);
		$result = \app\func\common::data_back($result);
		return $result;
	}
}

?>
