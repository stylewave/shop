<?php
//zend by 旺旺dongshaolin2008所有  禁止倒卖 一经发现停止任何服务
function get_warehouse_area_attr_price_insert($warehouse_area, $goods_id, $goods_attr_id, $table)
{
	$arr = array();

	if (is_array($warehouse_area)) {
		for ($i = 0; $i < count($warehouse_area); $i++) {
			if (!empty($warehouse_area[$i])) {
				$parent = array('goods_id' => $goods_id, 'goods_attr_id' => $goods_attr_id);

				if ($table == 'warehouse_attr') {
					$where = ' AND warehouse_id = \'' . $warehouse_area[$i] . '\'';
					$parent['warehouse_id'] = $warehouse_area[$i];
					$parent['attr_price'] = $_POST['attr_price_' . $warehouse_area[$i]];
				}
				else if ($table == 'warehouse_area_attr') {
					$where = ' AND area_id = \'' . $warehouse_area[$i] . '\'';
					$parent['area_id'] = $warehouse_area[$i];
					$parent['attr_price'] = $_POST['attrPrice_' . $warehouse_area[$i]];
				}

				if ($goods_id) {
					$admin_id = get_admin_id();
					$where .= ' AND admin_id = \'' . $admin_id . '\'';
				}

				$sql = 'SELECT id FROM ' . $GLOBALS['ecs']->table($table) . ' WHERE goods_id = \'' . $goods_id . '\' AND goods_attr_id = \'' . $goods_attr_id . '\' ' . $where;
				$id = $GLOBALS['db']->getOne($sql);

				if (0 < $id) {
					$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table($table), $parent, 'UPDATE', 'goods_id = \'' . $goods_id . '\' and goods_attr_id = \'' . $goods_attr_id . '\' ' . $where);
				}
				else {
					$parent['admin_id'] = $admin_id;
					$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table($table), $parent, 'INSERT');
				}
			}
		}
	}
	else if (is_array($goods_attr_id)) {
		for ($i = 0; $i < count($goods_attr_id); $i++) {
			if (!empty($goods_attr_id[$i])) {
				$parent = array('goods_id' => $goods_id, 'goods_attr_id' => $goods_attr_id[$i]);

				if ($table == 'warehouse_attr') {
					$where = ' AND warehouse_id = \'' . $warehouse_area . '\'';
					$parent['warehouse_id'] = $warehouse_area;
					$parent['attr_price'] = $_POST['attr_price_' . $goods_attr_id[$i]];
				}
				else if ($table == 'warehouse_area_attr') {
					$where = ' AND area_id = \'' . $warehouse_area . '\'';
					$parent['area_id'] = $warehouse_area;
					$parent['attr_price'] = $_POST['attrPrice_' . $goods_attr_id[$i]];
				}

				if ($goods_id) {
					$admin_id = get_admin_id();
					$where .= ' AND admin_id = \'' . $admin_id . '\'';
				}

				$sql = 'SELECT id FROM ' . $GLOBALS['ecs']->table($table) . ' WHERE goods_id = \'' . $goods_id . '\' AND goods_attr_id = \'' . $goods_attr_id[$i] . '\' ' . $where;
				$id = $GLOBALS['db']->getOne($sql);

				if (0 < $id) {
					$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table($table), $parent, 'UPDATE', 'goods_id = \'' . $goods_id . '\' and goods_attr_id = \'' . $goods_attr_id[$i] . '\' ' . $where);
				}
				else {
					$parent['admin_id'] = $admin_id;
					$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table($table), $parent, 'INSERT');
				}
			}
		}
	}
}

function get_seller_grade_rank($ru_id)
{
	$sql = 'SELECT sg.goods_sun, sg.seller_temp, sg.favorable_rate, sg.give_integral, sg.rank_integral, sg.pay_integral FROM ' . $GLOBALS['ecs']->table('merchants_grade') . ' AS mg, ' . $GLOBALS['ecs']->table('seller_grade') . ' AS sg ' . ' WHERE mg.grade_id = sg.id AND ru_id = \'' . $ru_id . '\' LIMIT 1';
	$res = $GLOBALS['db']->getRow($sql);
	$res['favorable_rate'] = !empty($res['favorable_rate']) ? $res['favorable_rate'] / 100 : 1;
	$res['give_integral'] = !empty($res['give_integral']) ? $res['give_integral'] / 100 : 1;
	$res['rank_integral'] = !empty($res['rank_integral']) ? $res['rank_integral'] / 100 : 1;
	$res['pay_integral'] = !empty($res['pay_integral']) ? $res['pay_integral'] / 100 : 1;
	return $res;
}

function get_account_log_list($ru_id, $type = 0)
{
	require_once ROOT_PATH . 'includes/lib_order.php';
	$result = get_filter();

	if ($result === false) {
		$filter['keywords'] = !isset($_REQUEST['keywords']) ? '' : trim($_REQUEST['keywords']);
		if (isset($_REQUEST['is_ajax']) && ($_REQUEST['is_ajax'] == 1)) {
			$filter['keywords'] = json_str_iconv($filter['keywords']);
		}

		$filter['order_sn'] = !isset($_REQUEST['order_sn']) ? '' : trim($_REQUEST['order_sn']);
		$filter['out_up'] = !isset($_REQUEST['out_up']) ? 0 : intval($_REQUEST['out_up']);
		$filter['log_type'] = !isset($_REQUEST['log_type']) ? 0 : intval($_REQUEST['log_type']);
		$filter['handler'] = !isset($_REQUEST['handler']) ? 0 : intval($_REQUEST['handler']);
		$filter['rawals'] = !isset($_REQUEST['rawals']) ? 0 : intval($_REQUEST['rawals']);
		$filter['sort_by'] = empty($_REQUEST['sort_by']) ? 'sal.log_id' : trim($_REQUEST['sort_by']);
		$filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);
		$filter['act_type'] = !isset($_REQUEST['act_type']) ? 'detail' : $_REQUEST['act_type'];
		$filter['ru_id'] = !isset($_REQUEST['ru_id']) ? $ru_id : intval($_REQUEST['ru_id']);
		$ex_where = ' WHERE 1 ';

		if ($filter['order_sn']) {
			$ex_where .= ' AND (sal.apply_sn = \'' . $filter['order_sn'] . '\'';
			$ex_where .= ' OR ';
			$ex_where .= ' (SELECT order_sn FROM ' . $GLOBALS['ecs']->table('order_info') . ' AS oi WHERE sal.order_id = oi.order_id LIMIT 1) = \'' . $filter['order_sn'] . '\')';
		}

		if ($filter['out_up']) {
			if ($filter['out_up'] != 4) {
				if ($filter['out_up'] == 3) {
					$ex_where .= ' AND sal.log_type = \'' . $filter['out_up'] . '\'';
				}

				$ex_where .= ' AND (sal.log_type > \'' . $filter['out_up'] . '\' OR sal.log_type =  \'' . $filter['out_up'] . '\')';
			}
			else {
				$ex_where .= ' AND sal.log_type = \'' . $filter['out_up'] . '\'';
			}
		}

		if ($filter['rawals'] == 1) {
			$type = array(1);
		}

		if ($filter['handler']) {
			if ($filter['handler'] == 1) {
				$ex_where .= ' AND sal.is_paid = 1';
			}
			else {
				$ex_where .= ' AND sal.is_paid = 0';
			}
		}

		if ($filter['log_type']) {
			$ex_where .= ' AND sal.log_type = \'' . $filter['log_type'] . '\'';
		}

		$filter['store_search'] = empty($_REQUEST['store_search']) ? 0 : intval($_REQUEST['store_search']);
		$filter['merchant_id'] = isset($_REQUEST['merchant_id']) ? intval($_REQUEST['merchant_id']) : 0;
		$filter['store_keyword'] = isset($_REQUEST['store_keyword']) ? trim($_REQUEST['store_keyword']) : '';
		$store_where = '';
		$store_search_where = '';

		if ($filter['store_search'] != 0) {
			if ($ru_id == 0) {
				if ($_REQUEST['store_type']) {
					$store_search_where = 'AND mis.shopNameSuffix = \'' . $_REQUEST['store_type'] . '\'';
				}

				if ($filter['store_search'] == 1) {
					$ex_where .= ' AND mis.user_id = \'' . $filter['merchant_id'] . '\' ';
				}
				else if ($filter['store_search'] == 2) {
					$store_where .= ' AND mis.rz_shopName LIKE \'%' . mysql_like_quote($filter['store_keyword']) . '%\'';
				}
				else if ($filter['store_search'] == 3) {
					$store_where .= ' AND mis.shoprz_brandName LIKE \'%' . mysql_like_quote($filter['store_keyword']) . '%\' ' . $store_search_where;
				}

				if (1 < $filter['store_search']) {
					$ex_where .= ' AND mis.user_id > 0 ' . $store_where . ' ';
				}
			}
		}

		$type = implode(',', $type);

		if ($filter['ru_id']) {
			$ex_where .= ' AND sal.ru_id = \'' . $filter['ru_id'] . '\'';
		}

		$sql = 'SELECT count(*) FROM ' . $GLOBALS['ecs']->table('seller_account_log') . ' AS sal ' . ' LEFT JOIN ' . $GLOBALS['ecs']->table('merchants_shop_information') . ' AS mis ON sal.ru_id = mis.user_id ' . ' ' . $ex_where . ' AND sal.log_type IN(' . $type . ')';
		$filter['record_count'] = $GLOBALS['db']->getOne($sql);
		$filter = page_and_size($filter);
		$sql = 'SELECT sal.* FROM ' . $GLOBALS['ecs']->table('seller_account_log') . ' AS sal ' . ' LEFT JOIN ' . $GLOBALS['ecs']->table('merchants_shop_information') . ' AS mis ON sal.ru_id = mis.user_id ' . ' ' . $ex_where . ' AND sal.log_type IN(' . $type . ')' . ' ORDER BY ' . $filter['sort_by'] . ' ' . $filter['sort_order'] . ' LIMIT ' . $filter['start'] . ',' . $filter['page_size'];
		$filter['keywords'] = stripslashes($filter['keywords']);
		set_filter($filter, $sql);
	}
	else {
		$sql = $result['sql'];
		$filter = $result['filter'];
	}

	$res = $GLOBALS['db']->getAll($sql);
	$arr = array();

	for ($i = 0; $i < count($res); $i++) {
		$res[$i]['shop_name'] = get_shop_name($res[$i]['ru_id'], 1);
		$order = order_info($res[$i]['order_id']);
		$res[$i]['order_sn'] = !empty($order['order_sn']) ? '【订单】' . $order['order_sn'] : $res[$i]['apply_sn'];
		$res[$i]['amount'] = price_format($res[$i]['amount'], false);
		$res[$i]['add_time'] = local_date($GLOBALS['_CFG']['time_format'], $res[$i]['add_time']);
		$res[$i]['payment_info'] = payment_info($res[$i]['pay_id']);
		$res[$i]['apply_sn'] = '【付款单号】' . $res[$i]['apply_sn'];
	}

	$arr = array('log_list' => $res, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
	return $arr;
}

function get_account_log_info($log_id)
{
	$sql = 'SELECT * FROM ' . $GLOBALS['ecs']->table('seller_account_log') . ' WHERE log_id = \'' . $log_id . '\' LIMIT 1';
	$res = $GLOBALS['db']->getRow($sql);

	if ($res) {
		$res['shop_name'] = get_shop_name($res['ru_id'], 1);
		$res['payment_info'] = payment_info($res['pay_id']);
		$info = get_seller_shopinfo($res['ru_id'], array('seller_money', 'frozen_money'));
		$res['seller_money'] = $info['seller_money'];
		$res['frozen_money'] = $info['frozen_money'];
	}

	return $res;
}

function get_seller_category()
{
	$sql = 'SELECT c.*, (SELECT c2.cat_name FROM ' . $GLOBALS['ecs']->table('category') . ' AS c2 WHERE c2.cat_id = c.parent_id LIMIT 1) AS parent_name ' . ' FROM ' . $GLOBALS['ecs']->table('merchants_category') . ' AS mc,' . $GLOBALS['ecs']->table('category') . ' AS c ' . ' WHERE 1 AND mc.cat_id = c.cat_id';
	$res = $GLOBALS['db']->getAll($sql);
	$chid_level = 0;
	$level = 1;
	$arr = array();

	if ($res) {
		foreach ($res as $key => $row) {
			$arr[$key]['cat_id'] = $row['cat_id'];
			$arr[$key]['cat_name'] = $row['cat_name'];
			$arr[$key]['parent_id'] = $row['parent_id'];
			$arr[$key]['keywords'] = $row['keywords'];
			$arr[$key]['cat_desc'] = $row['cat_desc'];
			$arr[$key]['sort_order'] = $row['sort_order'];
			$arr[$key]['measure_unit'] = $row['measure_unit'];
			$arr[$key]['show_in_nav'] = $row['show_in_nav'];
			$arr[$key]['style'] = $row['style'];
			$arr[$key]['grade'] = $row['grade'];
			$arr[$key]['filter_attr'] = $row['filter_attr'];
			$arr[$key]['is_top_style'] = $row['is_top_style'];
			$arr[$key]['top_style_tpl'] = $row['top_style_tpl'];
			$arr[$key]['cat_icon'] = $row['cat_icon'];
			$arr[$key]['is_top_show'] = $row['is_top_show'];
			$arr[$key]['category_links'] = $row['category_links'];
			$arr[$key]['category_topic'] = $row['category_topic'];
			$arr[$key]['pinyin_keyword'] = $row['pinyin_keyword'];
			$arr[$key]['cat_alias_name'] = $row['cat_alias_name'];
			$arr[$key]['template_file'] = $row['template_file'];
			$arr[$key]['parent_name'] = $row['parent_name'];
			$sql = 'SELECT * FROM ' . $GLOBALS['ecs']->table('merchants_category') . ' WHERE cat_id = \'' . $row['parent_id'] . '\'';

			if ($GLOBALS['db']->getOne($sql, true)) {
				$cat_level = get_seller_cat_level($row['parent_id']);

				if ($cat_level['parent_id'] != 0) {
					$chid = get_seller_cat_level($cat_level['parent_id']);

					if ($chid) {
						$chid_level += 1;
					}
				}

				$arr[$key]['level'] = $level + $chid_level;
			}
			else {
				$arr[$key]['level'] = 0;
			}

			$cat_level = array('一', '二', '三', '四', '五', '六', '气', '八', '九', '十');
			$arr[$key]['belongs'] = $cat_level[$arr[$key]['level']] . '级';

			if ($arr[$key]['level'] == 0) {
				$row['parent_id'] = 0;
			}
		}
	}

	return $arr;
}

function get_seller_cat_level($parent_id = 0, $level = 1)
{
	$sql = 'SELECT c.cat_id, c.cat_name, c.parent_id FROM ' . $GLOBALS['ecs']->table('merchants_category') . ' AS mc,' . $GLOBALS['ecs']->table('category') . ' AS c' . ' WHERE mc.cat_id = c.cat_id AND c.cat_id = \'' . $parent_id . '\' LIMIT 1';
	$row = $GLOBALS['db']->getRow($sql);
	return $row;
}

function get_seller_select_category($cat_id = 0, $relation = 0, $self = true, $user_id = 0)
{
	static $cat_list = array();
	$cat_list[] = intval($cat_id);

	if ($user_id) {
		$where = ' AND user_id = \'' . $user_id . '\'';
	}

	if ($relation == 0) {
		return $cat_list;
	}
	else if ($relation == 1) {
		$sql = ' select parent_id from ' . $GLOBALS['ecs']->table('merchants_category') . ' where cat_id=\'' . $cat_id . '\' ' . $where;
		$parent_id = $GLOBALS['db']->getOne($sql);

		if (!empty($parent_id)) {
			get_seller_select_category($parent_id, $relation, $self, $user_id);
		}

		if ($self == false) {
			unset($cat_list[0]);
		}

		$cat_list[] = 0;
		return array_reverse(array_unique($cat_list));
	}
	else if ($relation == 2) {
		$sql = ' select cat_id from ' . $GLOBALS['ecs']->table('merchants_category') . ' where parent_id=\'' . $cat_id . '\' ' . $where;
		$child_id = $GLOBALS['db']->getCol($sql);

		if (!empty($child_id)) {
			foreach ($child_id as $key => $val) {
				get_seller_select_category($val, $relation, $self, $user_id);
			}
		}

		if ($self == false) {
			unset($cat_list[0]);
		}

		return $cat_list;
	}
}

function get_seller_category_list($cat_id = 0, $relation = 0, $user_id = 0)
{
	$where = '';

	if ($user_id) {
		$where .= ' AND user_id = \'' . $user_id . '\'';
	}

	if ($relation == 0) {
		$parent_id = $GLOBALS['db']->getOne(' SELECT parent_id FROM ' . $GLOBALS['ecs']->table('merchants_category') . ' WHERE cat_id = \'' . $cat_id . '\' ' . $where);
	}
	else if ($relation == 1) {
		$parent_id = $GLOBALS['db']->getOne(' SELECT parent_id FROM ' . $GLOBALS['ecs']->table('merchants_category') . ' WHERE cat_id = \'' . $cat_id . '\' ' . $where);
	}
	else if ($relation == 2) {
		$parent_id = $cat_id;
	}

	$parent_id = (empty($parent_id) ? 0 : $parent_id);
	$category_list = $GLOBALS['db']->getAll(' SELECT cat_id, cat_name FROM ' . $GLOBALS['ecs']->table('merchants_category') . ' WHERE parent_id = \'' . $parent_id . '\' ' . $where);

	foreach ($category_list as $key => $val) {
		if ($cat_id == $val['cat_id']) {
			$is_selected = 1;
		}
		else {
			$is_selected = 0;
		}

		$category_list[$key]['is_selected'] = $is_selected;
	}

	return $category_list;
}

function set_default_filter($goods_id = 0, $cat_id = 0, $user_id = 0, $cat_type_show = 0, $table = 'category')
{
	if ($cat_id) {
		$parent_cat_list = get_select_category($cat_id, 1, true, $user_id, $table);
		$filter_category_navigation = get_array_category_info($parent_cat_list, $table);
		$GLOBALS['smarty']->assign('filter_category_navigation', $filter_category_navigation);
	}

	if ($user_id) {
		$seller_shop_cat = seller_shop_cat($user_id);
	}
	else {
		$seller_shop_cat = array();
	}

	$GLOBALS['smarty']->assign('filter_category_list', get_category_list($cat_id, 0, $seller_shop_cat, $user_id, 2, $table));
	$GLOBALS['smarty']->assign('filter_brand_list', search_brand_list($goods_id));
	$GLOBALS['smarty']->assign('cat_type_show', $cat_type_show);
	return true;
}

function set_seller_default_filter($goods_id = 0, $cat_id = 0, $user_id = 0)
{
	if (0 < $cat_id) {
		$seller_parent_cat_list = get_seller_select_category($cat_id, 1, true, $user_id);
		$seller_filter_category_navigation = get_seller_array_category_info($seller_parent_cat_list);
		$GLOBALS['smarty']->assign('seller_filter_category_navigation', $seller_filter_category_navigation);
	}

	$GLOBALS['smarty']->assign('seller_filter_category_list', get_seller_category_list($cat_id, 0, $user_id));
	$GLOBALS['smarty']->assign('seller_cat_type_show', 1);
	return true;
}

function get_seller_every_category($cat_id = 0)
{
	$parent_cat_list = get_seller_category_array($cat_id, 1, true);
	$filter_category_navigation = get_seller_array_category_info($parent_cat_list);
	$cat_nav = '';

	if ($filter_category_navigation) {
		foreach ($filter_category_navigation as $key => $val) {
			if ($key == 0) {
				$cat_nav .= $val['cat_name'];
			}
			else if (0 < $key) {
				$cat_nav .= ' > ' . $val['cat_name'];
			}
		}
	}

	return $cat_nav;
}

function get_seller_category_array($cat_id = 0, $relation = 0, $self = true)
{
	$cat_list[] = intval($cat_id);

	if ($relation == 0) {
		return $cat_list;
	}
	else if ($relation == 1) {
		do {
			$sql = ' select parent_id from ' . $GLOBALS['ecs']->table('merchants_category') . ' where cat_id=\'' . $cat_id . '\' ';
			$parent_id = $GLOBALS['db']->getOne($sql);

			if (!empty($parent_id)) {
				$cat_list[] = $parent_id;
				$cat_id = $parent_id;
			}
		} while (!empty($parent_id));

		if ($self == false) {
			unset($cat_list[0]);
		}

		$cat_list[] = 0;
		return array_reverse(array_unique($cat_list));
	}
	else if ($relation == 2) {
	}
}

function get_seller_array_category_info($arr = array())
{
	if ($arr) {
		$sql = ' SELECT cat_id, cat_name FROM ' . $GLOBALS['ecs']->table('merchants_category') . ' WHERE cat_id ' . db_create_in($arr);
		return $GLOBALS['db']->getAll($sql);
	}
	else {
		return false;
	}
}

function seller_shop_cat($user_id = 0)
{
	$seller_shop_cat = '';

	if ($user_id) {
		$sql = 'SELECT user_shopMain_category FROM ' . $GLOBALS['ecs']->table('merchants_shop_information') . ' WHERE user_id = \'' . $user_id . '\'';
		$seller_shop_cat = $GLOBALS['db']->getOne($sql, true);
	}

	$arr = array();
	$arr['parent'] = '';

	if ($seller_shop_cat) {
		$seller_shop_cat = explode('-', $seller_shop_cat);

		foreach ($seller_shop_cat as $key => $row) {
			if ($row) {
				$cat = explode(':', $row);
				$arr[$key]['cat_id'] = $cat[0];
				$arr[$key]['cat_tree'] = $cat[1];
				$arr['parent'] .= $cat[0] . ',';

				if ($cat[1]) {
					$arr['parent'] .= $cat[1] . ',';
				}
			}
		}
	}

	$arr['parent'] = substr($arr['parent'], 0, -1);
	return $arr;
}

function get_seller_cat_info($cat_id)
{
	$sql = 'SELECT * FROM ' . $GLOBALS['ecs']->table('merchants_category') . ' WHERE cat_id = \'' . $cat_id . '\' LIMIT 1';
	$row = $GLOBALS['db']->getRow($sql);

	if ($row) {
		$row['is_show_merchants'] = $row['is_show'];
	}

	return $row;
}

function get_admin_goods_info($goods_id = 0, $select = array())
{
	if ($select && is_array($select)) {
		$select = implode(',', $select);
	}
	else {
		$select = '*';
	}

	$sql = 'SELECT ' . $select . ' FROM ' . $GLOBALS['ecs']->table('goods') . ' WHERE goods_id = \'' . $goods_id . '\' LIMIT 1';
	$row = $GLOBALS['db']->getRow($sql);

	if ($row) {
		if (isset($row['user_cat']) && !empty($row['user_cat'])) {
			$cat_info = get_seller_cat_info($row['user_cat']);
			$row['user_cat_name'] = $cat_info['cat_name'];
		}

		if (isset($row['user_id'])) {
			$row['shop_name'] = get_shop_name($row['user_id'], 1);
		}
	}

	return $row;
}

function get_every_category($cat_id = 0, $table = 'category')
{
	$parent_cat_list = get_category_array($cat_id, 1, true, $table);
	$filter_category_navigation = get_array_category_info($parent_cat_list, $table);
	$cat_nav = '';

	if ($filter_category_navigation) {
		foreach ($filter_category_navigation as $key => $val) {
			if ($key == 0) {
				$cat_nav .= $val['cat_name'];
			}
			else if (0 < $key) {
				$cat_nav .= ' > ' . $val['cat_name'];
			}
		}
	}

	return $cat_nav;
}

function get_category_array($cat_id = 0, $relation = 0, $self = true, $table = 'category')
{
	$cat_list[] = intval($cat_id);

	if ($relation == 0) {
		return $cat_list;
	}
	else if ($relation == 1) {
		do {
			$sql = ' SELECT parent_id FROM ' . $GLOBALS['ecs']->table($table) . ' WHERE cat_id=\'' . $cat_id . '\' ';
			$parent_id = $GLOBALS['db']->getOne($sql);

			if (!empty($parent_id)) {
				$cat_list[] = $parent_id;
				$cat_id = $parent_id;
			}
		} while (!empty($parent_id));

		if ($self == false) {
			unset($cat_list[0]);
		}

		$cat_list[] = 0;
		return array_reverse(array_unique($cat_list));
	}
	else if ($relation == 2) {
	}
}

function get_array_category_info($arr = array(), $table = 'category')
{
	if ($arr) {
		$arr = get_del_str_comma($arr);
		$sql = ' SELECT cat_id, cat_name FROM ' . $GLOBALS['ecs']->table($table) . ' WHERE cat_id ' . db_create_in($arr);
		$category_list = $GLOBALS['db']->getAll($sql);

		foreach ($category_list as $key => $val) {
			$category_list[$key]['url'] = build_uri($table, array('cid' => $val['cat_id']), $val['cat_name']);
		}

		return $category_list;
	}
	else {
		return false;
	}
}

function get_add_edit_goods_cat_list($goods_id = 0, $cat_id = 0, $table = 'category', $sin_prefix = '', $user_id = 0, $seller_shop_cat = array())
{
	if (empty($sin_prefix)) {
		$select_category_rel = '';
		$select_category_rel .= insert_select_category(0, 0, 0, 'cat_id1', 1, $table, $seller_shop_cat);
		$GLOBALS['smarty']->assign($sin_prefix . 'select_category_rel', $select_category_rel);
	}

	if (empty($sin_prefix)) {
		$select_category_pak = '';
		$select_category_pak .= insert_select_category(0, 0, 0, 'cat_id2', 1, $table, $seller_shop_cat);
		$GLOBALS['smarty']->assign($sin_prefix . 'select_category_pak', $select_category_pak);
	}

	if ($_REQUEST['act'] == 'add') {
		$select_category_html = '';

		if ($sin_prefix) {
			$select_category_html .= insert_seller_select_category(0, 0, 0, 'user_cat', 0, $table, array(), $user_id);
		}
		else {
			$select_category_html .= insert_select_category(0, 0, 0, 'cat_id', 0, $table, $seller_shop_cat);
		}

		$GLOBALS['smarty']->assign($sin_prefix . 'select_category_html', $select_category_html);
	}
	else {
		if (($_REQUEST['act'] == 'edit') || ($_REQUEST['act'] == 'copy')) {
			$goods = get_admin_goods_info($goods_id, array('cat_id', 'user_cat'));
			$select_category_html = '';

			if ($sin_prefix) {
				$parent_cat_list = get_seller_select_category($cat_id, 1, true, $user_id);
				$cat_id = $goods['user_cat'];
			}
			else {
				$parent_cat_list = get_select_category($cat_id, 1, true);
				$cat_id = $goods['cat_id'];
			}

			for ($i = 0; $i < count($parent_cat_list); $i++) {
				if ($sin_prefix) {
					$select_category_html .= insert_seller_select_category(pos($parent_cat_list), next($parent_cat_list), $i, 'user_cat', 0, $table, array(), $user_id);
				}
				else {
					$select_category_html .= insert_select_category(pos($parent_cat_list), next($parent_cat_list), $i, 'cat_id', 0, $table, $seller_shop_cat);
				}
			}

			$GLOBALS['smarty']->assign($sin_prefix . 'select_category_html', $select_category_html);
			$parent_and_rank = (empty($cat_id) ? '0_0' : $cat_id . '_' . (count($parent_cat_list) - 2));
			$GLOBALS['smarty']->assign($sin_prefix . 'parent_and_rank', $parent_and_rank);
		}
	}
}

function get_admin_user_info($id = 0)
{
	$sql = 'SELECT u.user_id, u.email, u.user_name, u.user_money, u.mobile_phone, u.pay_points, nick_name' . ' FROM ' . $GLOBALS['ecs']->table('users') . ' AS u ' . ' WHERE u.user_id = \'' . $id . '\'';
	return $GLOBALS['db']->getRow($sql);
}

function get_dialog_goods_attr_type($attr_id = 0, $goods_id = 0)
{
	$sql = 'SELECT goods_attr_id, attr_id, attr_value FROM ' . $GLOBALS['ecs']->table('goods_attr') . ' WHERE attr_id = \'' . $attr_id . '\' AND goods_id = \'' . $goods_id . '\' ORDER BY attr_sort';
	$res = $GLOBALS['db']->getAll($sql);

	if ($res) {
		foreach ($res as $key => $row) {
			if ($goods_id) {
				$res[$key]['is_selected'] = 1;
			}
			else {
				$res[$key]['is_selected'] = 0;
			}
		}
	}

	return $res;
}

function seller_grade_list()
{
	$sql = 'SELECT user_id FROM ' . $GLOBALS['ecs']->table('merchants_shop_information') . ' WHERE merchants_audit = 1 ORDER BY user_id ASC';
	return $GLOBALS['db']->getAll($sql);
}

function get_pin_regions()
{
	$arr = array();
	$letters = range('A', 'Z');
	$pin_regions = read_static_cache('pin_regions', '/data/sc_file/');

	if ($pin_regions !== false) {
		foreach ($letters as $key => $row) {
			foreach ($pin_regions as $pk => $prow) {
				if ($row == $prow['initial']) {
					$arr[$row][$pk] = $prow;
				}
			}

			if ($arr[$row]) {
				$arr[$row] = get_array_sort($arr[$row], 'region_id');
			}
		}
	}

	ksort($arr);
	return $arr;
}

function get_updel_goods_attr($goods_id = 0)
{
	$admin_id = get_admin_id();

	if ($admin_id) {
		if ($goods_id) {
			$sql = 'UPDATE ' . $GLOBALS['ecs']->table('goods_attr') . ' SET goods_id = \'' . $goods_id . '\' WHERE admin_id = \'' . $admin_id . '\' AND goods_id = 0';
		}
		else {
			$sql = 'DELETE FROM ' . $GLOBALS['ecs']->table('goods_attr') . ' WHERE admin_id = \'' . $admin_id . '\' AND goods_id = 0';
		}

		$GLOBALS['db']->query($sql);
	}
}

function get_goods_attr_nameId($goods_id = 0, $attr_id = 0, $attr_value = '', $select = 'goods_attr_id', $type = 0)
{
	if ($type == 1) {
		$sql = 'SELECT ' . $select . ' FROM ' . $GLOBALS['ecs']->table('goods_attr') . ' WHERE goods_id = \'' . $goods_id . '\' AND goods_attr_id = \'' . $attr_id . '\'';
	}
	else {
		$sql = 'SELECT ' . $select . ' FROM ' . $GLOBALS['ecs']->table('goods_attr') . ' WHERE goods_id = \'' . $goods_id . '\' AND attr_id = \'' . $attr_id . '\' ' . ' AND attr_value = \'' . $attr_value . '\'';
	}

	return $GLOBALS['db']->getOne($sql);
}

function get_seller_info($ru_id = 0, $select = array())
{
	if ($select && is_array($select)) {
		$select = implode(',', $select);
	}
	else {
		$select = '*';
	}

	$sql = 'SELECT ' . $select . ' FROM ' . $GLOBALS['ecs']->table('seller_shopinfo') . ' WHERE ru_id = \'' . $ru_id . '\'';
	return $GLOBALS['db']->getRow($sql);
}

function get_seller_region($region = array(), $ru_id = 0)
{
	if ($region) {
		$sql = 'SELECT concat(IFNULL(p.region_name, \'\'), \'\', IFNULL(t.region_name, \'\'), \'\', IFNULL(d.region_name, \'\')) AS region ' . 'FROM ' . $GLOBALS['ecs']->table('region') . ' AS p, ' . $GLOBALS['ecs']->table('region') . ' AS t, ' . $GLOBALS['ecs']->table('region') . ' AS d ' . 'WHERE p.region_id = \'' . $region['province'] . '\' AND t.region_id = \'' . $region['city'] . '\' AND d.region_id = \'' . $region['district'] . '\'';
	}
	else {
		$sql = 'SELECT concat(IFNULL(p.region_name, \'\'), \'\', IFNULL(t.region_name, \'\'), \'\', IFNULL(d.region_name, \'\'), \'\', IFNULL(s.region_name, \'\')) AS region ' . 'FROM ' . $GLOBALS['ecs']->table('seller_shopinfo') . ' AS ss ' . 'LEFT JOIN ' . $GLOBALS['ecs']->table('region') . ' AS p ON ss.province = p.region_id ' . 'LEFT JOIN ' . $GLOBALS['ecs']->table('region') . ' AS t ON ss.city = t.region_id ' . 'LEFT JOIN ' . $GLOBALS['ecs']->table('region') . ' AS d ON ss.district = d.region_id ' . 'WHERE ss.ru_id = \'' . $ru_id . '\'';
	}

	return $GLOBALS['db']->getOne($sql);
}

function get_goods_unset_attr($goods_id = 0, $attr_arr = array())
{
	$arr = array();

	if ($attr_arr) {
		$where_select = array();

		if (empty($goods_id)) {
			$admin_id = get_admin_id();
			$where_select['admin_id'] = $admin_id;
		}

		$where_select['goods_id'] = $goods_id;

		foreach ($attr_arr as $key => $row) {
			if ($row) {
				$where_select['attr_value'] = $row[0];
				$attr_info = get_goods_attr_id($where_select, array('ga.goods_id', 'ga.attr_value', 'a.attr_id', 'a.attr_type'), 2, 1);
				if ($attr_info && ($row[0] == $attr_info['attr_value'])) {
					unset($row);
				}
				else {
					$arr[$key] = $row;
				}
			}
		}
	}

	return $arr;
}

function get_goods_transport_info($tid, $table = 'goods_transport')
{
	$sql = 'SELECT * FROM ' . $GLOBALS['ecs']->table($table) . ' WHERE tid = \'' . $tid . '\'';
	return $GLOBALS['db']->getRow($sql);
}

function get_goods_extend($goods_id)
{
	$extend_sql = 'SELECT * FROM ' . $GLOBALS['ecs']->table('goods_extend') . ' WHERE goods_id = \'' . $goods_id . '\'';
	return $GLOBALS['db']->getRow($extend_sql);
}

function get_goods_gallery_album($type = 0, $id = 0, $select = array(), $id_name = 'album_id', $order = '')
{
	$where = 1;

	if ($id) {
		$where .= ' AND ' . $id_name . ' = \'' . $id . '\'';
	}

	if ($select && is_array($select)) {
		$select = implode(',', $select);
	}
	else {
		$select = '*';
	}

	if ($type == 2) {
		$where .= ' LIMIT 1';
	}

	$sql = 'SELECT ' . $select . ' FROM' . $GLOBALS['ecs']->table('gallery_album') . ' WHERE ' . $where . ' ' . $order;

	if ($type == 1) {
		$album_list = $GLOBALS['db']->getAll($sql);

		if ($album_list) {
			foreach ($album_list as $key => $row) {
				$album_list[$key]['add_time'] = local_date($GLOBALS['_CFG']['time_format'], $row['add_time']);
			}
		}
	}
	else if ($type == 2) {
		$album_list = $GLOBALS['db']->getRow($sql);
	}
	else {
		$album_list = $GLOBALS['db']->getOne($sql, true);
	}

	return $album_list;
}

function gallery_pic_album($type = 0, $id = 0, $select = array(), $id_name = 'pic_id', $order = '')
{
	$where = 1;

	if ($id) {
		$where .= ' AND ' . $id_name . ' = \'' . $id . '\'';
	}

	if ($select && is_array($select)) {
		$select = implode(',', $select);
	}
	else {
		$select = '*';
	}

	if ($type == 2) {
		$where .= ' LIMIT 1';
	}

	$sql = 'SELECT ' . $select . ' FROM' . $GLOBALS['ecs']->table('pic_album') . ' WHERE ' . $where . ' ' . $order;

	if ($type == 1) {
		$pic_list = $GLOBALS['db']->getAll($sql);

		if ($pic_list) {
			foreach ($pic_list as $key => $row) {
				$pic_list[$key]['add_time'] = local_date($GLOBALS['_CFG']['time_format'], $row['add_time']);
			}
		}
	}
	else if ($type == 2) {
		$pic_list = $GLOBALS['db']->getRow($sql);
	}
	else {
		$pic_list = $GLOBALS['db']->getOne($sql, true);
	}

	return $pic_list;
}

function seller_page($list, $nowpage, $show = '10')
{
	$arr = array();

	if ($list['page_count'] < $show) {
		$show = $list['page_count'];
	}

	if (($show % 2) == 0) {
		$begin = $nowpage - ceil($show / 2);
		$end = $nowpage + floor($show / 2);
	}
	else {
		$begin = $nowpage - floor($show / 2);
		$end = $nowpage + ceil($show / 2);
	}

	if (1 < $show) {
		if (((ceil($show / 2) + 1) < $nowpage) && ($nowpage <= $list['page_count'] - ceil($show / 2))) {
			for ($i = $begin; $i < $end; $i++) {
				$arr[$i] = $i;
			}
		}
		else {
			if (((ceil($show / 2) + 1) < $nowpage) && (($list['page_count'] - $show - 1) < $nowpage)) {
				for ($i = $list['page_count'] - $show - 1; $i <= $list['page_count']; $i++) {
					$arr[$i] = $i;
				}
			}
			else {
				for ($i = 1; $i <= $show; $i++) {
					$arr[$i] = $i;
				}
			}
		}
	}
	else {
		$arr[1] = 1;
	}

	return $arr;
}

function get_choose_cat($ids)
{
	$sql = ' SELECT cat_id, cat_name FROM ' . $GLOBALS['ecs']->table('category') . ' WHERE cat_id ' . db_create_in($ids);
	return $GLOBALS['db']->getAll($sql);
}

function get_choose_goods($ids)
{
	$sql = ' SELECT goods_id, goods_name FROM ' . $GLOBALS['ecs']->table('goods') . ' WHERE goods_id ' . db_create_in($ids);
	return $GLOBALS['db']->getAll($sql);
}

function get_areaRegion_info_list($ra_id)
{
	if (0 < $ra_id) {
		$where_raId = ' AND mr.ra_id = \'' . $ra_id . '\'';
	}

	$sql = 'SELECT rw.region_id, rw.region_name FROM ' . $GLOBALS['ecs']->table('merchants_region_info') . ' AS mr ' . ' LEFT JOIN ' . $GLOBALS['ecs']->table('region') . ' AS r ON mr.region_id = r.region_id' . ' LEFT JOIN ' . $GLOBALS['ecs']->table('region_warehouse') . ' AS rw ON r.region_id = rw.regionId' . ' where 1' . $where_raId;
	return $GLOBALS['db']->getAll($sql);
}

function get_table_info($table = '', $where = 1, $select = array())
{
	$res = array();

	if ($table) {
		if ($select && is_array($select)) {
			$select = implode(',', $select);
		}
		else {
			$select = (empty($select) ? '*' : $select);
		}

		$sql = 'SELECT ' . $select . ' FROM ' . $GLOBALS['ecs']->table($table) . ' WHERE ' . $where . ' LIMIT 1';
		$res = $GLOBALS['db']->getRow($sql);
	}

	return $res;
}

function get_order_drp_money($total_fee = 0, $ru_id = 0, $order_id = 0, $order = array())
{
	$should_amount = 0;
	$where = '';

	if ($order_id) {
		$where .= ' AND oi.order_id = \'' . $order_id . '\'';
	}
	else {
		$where .= order_query_sql('confirm_take', 'oi.');
		$where .= ' AND og.ru_id = \'' . $ru_id . '\'';
		$where .= ' AND (SELECT count(*) FROM ' . $GLOBALS['ecs']->table('order_info') . ' AS oi2 WHERE oi2.main_order_id = oi.order_id LIMIT 1) = 0';
	}

	$res = array();
	$sql = 'SELECT SUM(og.drp_money) AS drp_money FROM ' . $GLOBALS['ecs']->table('order_info') . ' as oi ' . ' LEFT JOIN ' . $GLOBALS['ecs']->table('order_goods') . ' AS og ON og.order_id = oi.order_id ' . ' WHERE 1 ' . $where;
	$order_drp = $GLOBALS['db']->getRow($sql);

	if ($order_id) {
		$goods_rate = get_alone_goods_rate($order_id, 0, $order);

		if ($goods_rate['rate_activity']) {
			$value['total_fee'] = $value['total_fee'] + $goods_rate['rate_activity'];
		}

		$res['rate_activity'] = $goods_rate['rate_activity'];
		if ($goods_rate && $goods_rate['total_fee']) {
			$total_fee = $value['total_fee'] - $goods_rate['total_fee'];
		}

		$should_amount = $goods_rate['should_amount'];
	}

	if (0 < $total_fee) {
		$res['total_fee'] = $total_fee - $order_drp['drp_money'];
	}
	else {
		$res['total_fee'] = 0;
	}

	$res['drp_money'] = $order_drp['drp_money'];
	$res['should_amount'] = $should_amount;
	return $res;
}

function get_seller_account_log()
{
	$result = get_filter();

	if ($result === false) {
		$filter['sort_by'] = empty($_REQUEST['sort_by']) ? 'sal.change_time' : trim($_REQUEST['sort_by']);
		$filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);
		$filter['keywords'] = empty($_REQUEST['keywords']) ? '' : trim($_REQUEST['keywords']);
		$filter['user_id'] = empty($_REQUEST['ru_id']) ? 0 : intval($_REQUEST['ru_id']);
		$adminru = get_admin_ru_id();
		$ex_where = ' WHERE mis.merchants_audit = 1';

		if (0 < $adminru['ru_id']) {
			$ex_where .= ' AND sal.user_id="' . $adminru['ru_id'] . '" ';
		}
		else if (0 < $filter['user_id']) {
			$ex_where .= ' AND sal.user_id="' . $filter['user_id'] . '" ';
		}
		else if ($filter['keywords']) {
			$sql = 'SELECT user_id FROM' . $GLOBALS['ecs']->table('users') . ' WHERE(user_name LIKE \'%' . mysql_like_quote($filter['keywords']) . '%\' OR nick_name LIKE \'%' . mysql_like_quote($filter['keywords']) . '%\') ';
			$user_id = $GLOBALS['db']->getOne($sql);
			$ex_where .= ' AND sal.user_id="' . $user_id . '" ';
		}

		$filter['store_search'] = empty($_REQUEST['store_search']) ? 0 : intval($_REQUEST['store_search']);
		$filter['merchant_id'] = isset($_REQUEST['merchant_id']) ? intval($_REQUEST['merchant_id']) : 0;
		$filter['store_keyword'] = isset($_REQUEST['store_keyword']) ? trim($_REQUEST['store_keyword']) : '';
		$store_where = '';
		$store_search_where = '';

		if ($filter['store_search'] != 0) {
			if ($ru_id == 0) {
				if ($_REQUEST['store_type']) {
					$store_search_where = 'AND mis.shopNameSuffix = \'' . $_REQUEST['store_type'] . '\'';
				}

				if ($filter['store_search'] == 1) {
					$ex_where .= ' AND mis.user_id = \'' . $filter['merchant_id'] . '\' ';
				}
				else if ($filter['store_search'] == 2) {
					$store_where .= ' AND mis.rz_shopName LIKE \'%' . mysql_like_quote($filter['store_keyword']) . '%\'';
				}
				else if ($filter['store_search'] == 3) {
					$store_where .= ' AND mis.shoprz_brandName LIKE \'%' . mysql_like_quote($filter['store_keyword']) . '%\' ' . $store_search_where;
				}

				if (1 < $filter['store_search']) {
					$ex_where .= ' AND mis.user_id > 0 ' . $store_where . ' ';
				}
			}
		}

		$sql = 'SELECT count(*) FROM ' . $GLOBALS['ecs']->table('merchants_account_log') . ' AS sal ' . ' LEFT JOIN ' . $GLOBALS['ecs']->table('merchants_shop_information') . ' AS mis ON sal.user_id = mis.user_id ' . ' ' . $ex_where;
		$filter['record_count'] = $GLOBALS['db']->getOne($sql);
		$filter = page_and_size($filter);
		$sql = 'SELECT sal.* FROM ' . $GLOBALS['ecs']->table('merchants_account_log') . ' AS sal ' . ' LEFT JOIN ' . $GLOBALS['ecs']->table('merchants_shop_information') . ' AS mis ON sal.user_id = mis.user_id ' . ' ' . $ex_where . ' ' . ' ORDER BY ' . $filter['sort_by'] . ' ' . $filter['sort_order'] . ' LIMIT ' . $filter['start'] . ',' . $filter['page_size'];
		$filter['keywords'] = stripslashes($filter['keywords']);
		set_filter($filter, $sql);
	}
	else {
		$sql = $result['sql'];
		$filter = $result['filter'];
	}

	$res = $GLOBALS['db']->getAll($sql);
	$arr = array();

	for ($i = 0; $i < count($res); $i++) {
		$res[$i]['shop_name'] = get_shop_name($res[$i]['user_id'], 1);
		$res[$i]['change_time'] = local_date($GLOBALS['_CFG']['time_format'], $res[$i]['change_time']);
	}

	$arr = array('log_list' => $res, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
	return $arr;
}

function get_del_update_goods_null($goods_id = 0, $type = 0)
{
	$admin_id = get_admin_id();
	$table_list = array('products', 'products_warehouse', 'products_area', 'goods_attr', 'warehouse_attr', 'warehouse_area_attr');

	foreach ($table_list as $key => $table) {
		if ($type) {
			$other['goods_id'] = $goods_id;
			$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table($table), $other, 'UPDATE', 'goods_id = 0 AND admin_id = \'' . $admin_id . '\'');
		}
		else {
			$sql = 'DELETE FROM ' . $GLOBALS['ecs']->table($table) . ' WHERE goods_id = 0 AND admin_id = \'' . $admin_id . '\'';
			$GLOBALS['db']->query($sql);
		}
	}
}

function get_del_edit_goods_img($goods_id)
{
	$sql = 'SELECT goods_thumb, goods_img, original_img ' . ' FROM ' . $GLOBALS['ecs']->table('goods') . ' WHERE goods_id = \'' . $goods_id . '\' LIMIT 1';
	$row = $GLOBALS['db']->getRow($sql);

	if ($row) {
		if ($result['data']['goods_thumb'] && ($row['goods_thumb'] != $result['data']['goods_thumb']) && (strpos($row['goods_thumb'], 'data/gallery_album') === false)) {
			dsc_unlink(ROOT_PATH . $row['goods_thumb']);
			$arr_img[] = $row['goods_thumb'];
		}

		if ($result['data']['goods_img'] && ($row['goods_img'] != $result['data']['goods_img']) && (strpos($row['goods_img'], 'data/gallery_album') === false)) {
			dsc_unlink(ROOT_PATH . $row['goods_img']);
			$arr_img[] = $row['goods_img'];
		}

		if ($result['data']['original_img'] && ($row['original_img'] != $result['data']['original_img']) && (strpos($k['original_img'], 'data/gallery_album') === false)) {
			dsc_unlink(ROOT_PATH . $row['original_img']);
			$arr_img[] = $row['original_img'];
		}

		get_oss_del_file($arr_img);
	}
}

function get_del_goodsimg_null()
{
	$admin_id = get_admin_id();

	if (isset($_SESSION['goods'][$admin_id])) {
		foreach ($_SESSION['goods'][$admin_id] as $key => $row) {
			$sql = 'SELECT COUNT(*) FROM ' . $GLOBALS['ecs']->table('goods') . ' WHERE original_img = \'' . $row['original_img'] . '\' OR goods_img = \'' . $row['goods_img'] . '\' OR goods_thumb = \'' . $row['goods_thumb'] . '\'';
			$count = $GLOBALS['db']->getOne($sql);
			if (($key == 0) && !$count) {
				if ($row['original_img'] && (strpos($row['original_img'], 'data/gallery_album') === false)) {
					dsc_unlink(ROOT_PATH . $row['original_img']);
					$arr_img[] = $row['original_img'];
				}

				if ($row['goods_img'] && (strpos($row['goods_img'], 'data/gallery_album') === false)) {
					dsc_unlink(ROOT_PATH . $row['goods_img']);
					$arr_img[] = $row['goods_img'];
				}

				if ($row['goods_thumb'] && (strpos($row['goods_thumb'], 'data/gallery_album') === false)) {
					dsc_unlink(ROOT_PATH . $row['goods_thumb']);
					$arr_img[] = $row['goods_thumb'];
				}

				get_oss_del_file($arr_img);
			}
		}

		unset($_SESSION['goods'][$admin_id]);
	}
	else {
		if (isset($_SESSION['goods']) && empty($_SESSION['goods'])) {
			unset($_SESSION['goods']);
		}
	}
}

function get_del_goods_gallery()
{
	$admin_id = get_admin_id();
	if (isset($_SESSION['thumb_img_id' . $admin_id]) && $_SESSION['thumb_img_id' . $admin_id]) {
		$res = $GLOBALS['db']->getAll(' SELECT img_url,thumb_url,img_original FROM' . $GLOBALS['ecs']->table('goods_gallery') . ' WHERE goods_id = 0 AND img_id' . db_create_in($_SESSION['thumb_img_id' . $admin_id]));

		if (!empty($res)) {
			foreach ($res as $k) {
				if ($k['img_url'] && (strpos($k['img_url'], 'data/gallery_album') === false)) {
					dsc_unlink(ROOT_PATH . $k['img_url']);
					$arr_img[] = $row['img_url'];
				}

				if ($k['thumb_url'] && (strpos($k['thumb_url'], 'data/gallery_album') === false)) {
					dsc_unlink(ROOT_PATH . $k['thumb_url']);
					$arr_img[] = $row['thumb_url'];
				}

				if ($k['img_original'] && (strpos($k['img_original'], 'data/gallery_album') === false)) {
					dsc_unlink(ROOT_PATH . $k['img_original']);
					$arr_img[] = $row['img_original'];
				}

				get_oss_del_file($arr_img);
			}
		}

		$GLOBALS['db']->query('DELETE FROM' . $GLOBALS['ecs']->table('goods_gallery') . ' WHERE goods_id = 0 AND img_id' . db_create_in($_SESSION['thumb_img_id' . $admin_id]));
		unset($_SESSION['thumb_img_id' . $admin_id]);
	}
}

function get_return_money($left_money = 0, $rigth_money = 0)
{
	$money = $left_money;

	if ($left_money <= 0) {
		if (!(strpos($left_money, '-') === false)) {
			$new_frozen_money = substr($left_money, 1);

			if ($rigth_money) {
				if (($rigth_money <= 0) || ($rigth_money < $new_frozen_money)) {
					$money = 0;
				}
			}
		}
	}

	return $money;
}

function get_up_settings($groups = '')
{
	global $db;
	global $ecs;
	global $_LANG;
	$where = ' AND parent_id > 0';

	if (!empty($groups)) {
		$where .= ' AND shop_group = \'' . $groups . '\'';
	}

	$sql = 'SELECT * FROM ' . $GLOBALS['ecs']->table('shop_config') . ' WHERE type<>\'hidden\' ' . $where . ' ORDER BY parent_id, sort_order, id';
	$item_list = $GLOBALS['db']->getAll($sql);
	$code_arr = array('shop_logo', 'no_picture', 'watermark', 'shop_slagon', 'wap_logo', 'two_code_logo', 'ectouch_qrcode', 'ecjia_qrcode', 'index_down_logo', 'site_commitment', 'user_login_logo', 'login_logo_pic', 'business_logo');

	foreach ($item_list as $key => $item) {
		$pid = $item['parent_id'];
		$item['name'] = isset($_LANG['cfg_name'][$item['code']]) ? $_LANG['cfg_name'][$item['code']] : $item['code'];
		$item['desc'] = isset($_LANG['cfg_desc'][$item['code']]) ? $_LANG['cfg_desc'][$item['code']] : '';

		if ($item['code'] == 'sms_shop_mobile') {
			$item['url'] = 1;
		}

		if ($item['store_range']) {
			$item['store_options'] = explode(',', $item['store_range']);

			foreach ($item['store_options'] as $k => $v) {
				$item['display_options'][$k] = isset($_LANG['cfg_range'][$item['code']][$v]) ? $_LANG['cfg_range'][$item['code']][$v] : $v;
			}
		}

		if ($item) {
			if (($item['type'] == 'file') && in_array($item['code'], $code_arr) && $item['value']) {
				$item['del_img'] = 1;

				if (strpos($item['value'], '../') === false) {
					$item['value'] = '../' . $item['value'];
				}
			}
			else {
				$item['del_img'] = 0;
			}
		}

		$group_list[] = $item;
	}

	return $group_list;
}

function get_type_cat_arr($cat_id = 0, $type = 0, $arr = 0, $ru_id = 0)
{
	$adminru = get_admin_ru_id();

	if ($ru_id == 0) {
		$ru_id = $adminru['ru_id'];
	}

	$where = '';

	if (0 < $ru_id) {
		$where = ' AND user_id = \'' . $ru_id . '\'';
	}

	if ($type == 2) {
		$sql = 'SELECT level,cat_id,parent_id FROM' . $GLOBALS['ecs']->table('goods_type_cat') . 'WHERE cat_id = \'' . $cat_id . '\' ' . $where . ' LIMIT 1';
		$cat_list = $GLOBALS[db]->getRow($sql);
	}
	else {
		$sql = 'SELECT cat_id ,cat_name ,level FROM' . $GLOBALS['ecs']->table('goods_type_cat') . 'WHERE parent_id = \'' . $cat_id . '\' ' . $where;
		$cat_list = $GLOBALS[db]->getAll($sql);
	}

	if ($type == 1) {
		$cat_string = $cat_id . ',';

		if (!empty($cat_list)) {
			foreach ($cat_list as $k => $v) {
				$cat_string .= get_type_cat_arr($v['cat_id'], 1);
			}
		}

		if ($arr == 1) {
			$cat_string = substr($cat_string, 0, strlen($cat_string) - 1);
		}

		return $cat_string;
	}
	else if ($type == 2) {
		if (0 < $cat_list['parent_id']) {
			$sql = 'SELECT cat_id,parent_id,cat_name,sort_order,level FROM' . $GLOBALS['ecs']->table('goods_type_cat') . 'WHERE parent_id = \'' . $cat_list['parent_id'] . '\' ' . $where;
			$cat_tree = $GLOBALS['db']->getAll($sql);
			return array('checked_id' => $cat_list['parent_id'], 'arr' => $cat_tree);
		}
		else {
			return array('checked_id' => $cat_id, 'arr' => '');
		}
	}
	else {
		return $cat_list;
	}
}

function getCatNun($cat_keys = array())
{
	$adminru = get_admin_ru_id();
	$where = '';

	if (0 < $adminru['ru_id']) {
		$where = ' AND user_id = \'' . $adminru['ru_id'] . '\'';
	}

	if (!empty($cat_keys)) {
		$sql = 'SELECT COUNT(*) FROM' . $GLOBALS['ecs']->table('goods_type') . 'WHERE c_id in(' . $cat_keys . ') ' . $where;
		$count = $GLOBALS[db]->getOne($sql);
	}
	else {
		$count = 0;
	}

	return $count;
}

function get_typecat($level = 1)
{
	$adminru = get_admin_ru_id();
	$result = get_filter();

	if ($result === false) {
		$filter['parent_id'] = empty($_REQUEST['parent_id']) ? 0 : intval($_REQUEST['parent_id']);
		$filter['level'] = $level;
		$filter['keywords'] = empty($_REQUEST['keywords']) ? '' : trim($_REQUEST['keywords']);
		$where = ' WHERE level =  \'' . $filter['level'] . '\'';

		if (0 < $adminru['ru_id']) {
			$where .= ' AND user_id =\'' . $adminru['ru_id'] . '\'';
		}

		if ($filter['keywords']) {
			$where .= ' AND cat_name LIKE \'%' . mysql_like_quote($filter['keywords']) . '%\' ';
		}

		if (0 < $filter['parent_id']) {
			$where .= ' AND parent_id = \'' . $filter['parent_id'] . '\' ';
		}

		$sql = 'SELECT COUNT(*) FROM' . $GLOBALS['ecs']->table('goods_type_cat') . $where . ' GROUP BY cat_id';
		$filter['record_count'] = count($GLOBALS['db']->getAll($sql));
		$filter = page_and_size($filter);
		$sql = 'SELECT cat_id,parent_id,cat_name,sort_order,user_id,level FROM' . $GLOBALS['ecs']->table('goods_type_cat') . $where . ' GROUP BY cat_id' . ' LIMIT ' . $filter['start'] . ',' . $filter['page_size'];
		set_filter($filter, $sql);
	}
	else {
		$sql = $result['sql'];
		$filter = $result['filter'];
	}

	$all = $GLOBALS['db']->getAll($sql);

	foreach ($all as $key => $val) {
		$all[$key]['shop_name'] = get_shop_name($val['user_id'], 1);
		$all[$key]['parent_name'] = $GLOBALS[db]->getOne('SELECT cat_name FROM' . $GLOBALS[ecs]->table('goods_type_cat') . 'WHERE cat_id = \'' . $val['parent_id'] . '\'');
		$cat_keys = get_type_cat_arr($val['cat_id'], 1, 1);
		$all[$key]['type_num'] = getcatnun($cat_keys);
	}

	return array('type' => $all, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
}

function get_setting_groups($groups = '')
{
	global $_LANG;
	$group_list = array();
	$list = get_up_settings($groups);

	foreach ($list as $key => $val) {
		$group_list[$val['parent_id']]['vars'][] = $val;
	}

	foreach ($group_list as $key => $val) {
		$data = get_table_date('shop_config', 'id=\'' . $key . '\'', array('*'));
		$data['name'] = isset($_LANG['cfg_name'][$data['code']]) ? $_LANG['cfg_name'][$data['code']] : $data['code'];
		$data['desc'] = isset($_LANG['cfg_desc'][$data['code']]) ? $_LANG['cfg_desc'][$data['code']] : '';
		$data = array_merge($data, $val);
		$group_list[$key] = $data;
	}

	return $group_list;
}

function get_seller_shopinfo_changelog($ru_id = 0)
{
	$diff_data = array();
	$changelog = get_table_date('seller_shopinfo_changelog', 'ru_id=\'' . $ru_id . '\'', array('data_key', 'data_value'), 1);

	foreach ($changelog as $key => $val) {
		$diff_data[$val['data_key']] = $val['data_value'];
	}

	return $diff_data;
}

function create_ueditor_editor($input_name, $input_value = '', $input_height = 486, $type = 0)
{
	global $smarty;
	$FCKeditor = '<input type="hidden" id="' . $input_name . '" name="' . $input_name . '" value="' . htmlspecialchars($input_value) . '" /><iframe id="' . $input_name . '_frame" src="../plugins/seller_ueditor/ecmobanEditor.php?item=' . $input_name . '" width="100%" height="' . $input_height . '" frameborder="0" scrolling="no"></iframe>';

	if ($type == 1) {
		return $FCKeditor;
	}
	else {
		$smarty->assign('FCKeditor', $FCKeditor);
	}
}

function get_goods_warehouse_area_list($goods_id = 0, $model = 0, $warehouse_id = 0)
{
	$result = get_filter();

	if ($result === false) {
		$filter['keywords'] = empty($_REQUEST['keywords']) ? '' : trim($_REQUEST['keywords']);
		if (isset($_REQUEST['is_ajax']) && ($_REQUEST['is_ajax'] == 1)) {
			$filter['keywords'] = json_str_iconv($filter['keywords']);
		}

		$filter['goods_id'] = !isset($_REQUEST['goods_id']) ? $goods_id : intval($_REQUEST['goods_id']);
		$filter['warehouse_id'] = !isset($_REQUEST['warehouse_id']) ? $warehouse_id : intval($_REQUEST['warehouse_id']);
		$filter['model'] = !isset($_REQUEST['model']) ? $model : intval($_REQUEST['model']);
		$filter['region_sn'] = !isset($_REQUEST['region_sn']) ? '' : addslashes(trim($_REQUEST['region_sn']));
		$filter['sort_by'] = empty($_REQUEST['sort_by']) ? ' rw.region_id' : trim($_REQUEST['sort_by']);
		$filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);
		$where = ' 1 ';
		$sql_where = '';
		$select = '';
		$leftJion = '';

		if ($filter['model'] == 1) {
			$where .= ' AND rw.region_type = 0';
			$leftJion = ', ' . $GLOBALS['ecs']->table('warehouse_goods') . ' AS wg ';
			$sql_where .= ' AND rw.region_id = wg.region_id AND wg.goods_id = \'' . $filter['goods_id'] . '\'';
			$select .= ', wg.w_id, wg.region_sn, wg.region_number, wg.warehouse_price, wg.warehouse_promote_price';

			if ($filter['region_sn']) {
				$where .= ' AND wg.region_sn = \'' . $filter['region_sn'] . '\'';
			}
		}
		else if ($filter['model'] == 2) {
			if ($filter['warehouse_id']) {
				$where .= ' AND rw.parent_id = \'' . $filter['warehouse_id'] . '\'';
			}

			$where .= ' AND rw.region_type = 1';
			$select .= ', (SELECT rw2.region_name FROM ' . $GLOBALS['ecs']->table('region_warehouse') . ' AS rw2 WHERE rw2.region_id = rw.parent_id) AS warehouse_name ';
			$leftJion = ', ' . $GLOBALS['ecs']->table('warehouse_area_goods') . ' AS wag ';
			$sql_where .= ' AND rw.region_id = wag.region_id AND wag.goods_id = \'' . $filter['goods_id'] . '\'';
			$select .= ', wag.a_id, wag.region_sn, wag.region_number, wag.region_price, wag.region_promote_price';

			if ($filter['region_sn']) {
				$where .= ' AND wag.region_sn = \'' . $filter['region_sn'] . '\'';
			}
		}

		$sql = 'SELECT count(*) FROM ' . $GLOBALS['ecs']->table('region_warehouse') . ' AS rw ' . $leftJion . ' WHERE ' . $where . ' ' . $sql_where;
		$filter['record_count'] = $GLOBALS['db']->getOne($sql);
		$filter = page_and_size($filter, 1);
		$sql = 'SELECT rw.* ' . $select . ' FROM ' . $GLOBALS['ecs']->table('region_warehouse') . ' AS rw ' . $leftJion . ' WHERE ' . $where . ' ' . $sql_where . ' ORDER BY ' . $filter['sort_by'] . ' ' . $filter['sort_order'] . ' LIMIT ' . $filter['start'] . ',' . $filter['page_size'];
		$filter['keywords'] = stripslashes($filter['keywords']);
		set_filter($filter, $sql);
	}
	else {
		$sql = $result['sql'];
		$filter = $result['filter'];
	}

	$res = $GLOBALS['db']->getAll($sql);
	$arr = array('list' => $res, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count'], 'query' => 'goods_wa_query');
	return $arr;
}

function get_goods_model($goods_id)
{
	$sql = 'SELECT goods_id, goods_sn, model_attr, user_id FROM ' . $GLOBALS['ecs']->table('goods') . ' WHERE goods_id = \'' . $goods_id . '\' LIMIT 1';
	return $GLOBALS['db']->getRow($sql);
}

function get_goods_product_list($goods_id = 0, $model = 0, $warehouse_id = 0, $area_id = 0)
{
	$result = get_filter();

	if ($result === false) {
		$filter['keywords'] = empty($_REQUEST['keywords']) ? '' : trim($_REQUEST['keywords']);
		if (isset($_REQUEST['is_ajax']) && ($_REQUEST['is_ajax'] == 1)) {
			$filter['keywords'] = json_str_iconv($filter['keywords']);
		}

		$filter['product_sn'] = !isset($_REQUEST['product_sn']) ? '' : addslashes(trim($_REQUEST['product_sn']));
		$filter['goods_id'] = !isset($_REQUEST['goods_id']) ? $goods_id : intval($_REQUEST['goods_id']);
		$filter['model'] = !isset($_REQUEST['model']) ? $model : intval($_REQUEST['model']);
		$filter['sort_by'] = empty($_REQUEST['sort_by']) ? 'product_id' : trim($_REQUEST['sort_by']);
		$filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);
		$where = '';

		if ($filter['model'] == 1) {
			$filter['warehouse_id'] = !isset($_REQUEST['warehouse_id']) ? $warehouse_id : intval($_REQUEST['warehouse_id']);
			$table = 'products_warehouse';
			$where .= ' AND warehouse_id = \'' . $filter['warehouse_id'] . '\'';
		}
		else if ($filter['model'] == 2) {
			$filter['area_id'] = !isset($_REQUEST['area_id']) ? $area_id : intval($_REQUEST['area_id']);
			$table = 'products_area';
			$where .= ' AND area_id = \'' . $filter['area_id'] . '\'';
		}
		else {
			$table = 'products';
		}

		if ($filter['product_sn']) {
			$where .= ' AND product_sn = \'' . $filter['product_sn'] . '\'';
		}

		$sql = 'SELECT count(*) FROM ' . $GLOBALS['ecs']->table($table) . ' WHERE goods_id = \'' . $filter['goods_id'] . '\' ' . $where;
		$filter['record_count'] = $GLOBALS['db']->getOne($sql);
		$filter = page_and_size($filter, 1);
		$sql = 'SELECT * FROM ' . $GLOBALS['ecs']->table($table) . ' WHERE goods_id = \'' . $filter['goods_id'] . '\' ' . $where . ' ORDER BY ' . $filter['sort_by'] . ' ' . $filter['sort_order'] . ' LIMIT ' . $filter['start'] . ',' . $filter['page_size'];
		$filter['keywords'] = stripslashes($filter['keywords']);
		set_filter($filter, $sql);
	}
	else {
		$sql = $result['sql'];
		$filter = $result['filter'];
	}

	$res = $GLOBALS['db']->getAll($sql);

	for ($i = 0; $i < count($res); $i++) {
		$goods_attr_id = str_replace('|', ',', $res[$i]['goods_attr']);
		$sql = 'SELECT attr_value FROM ' . $GLOBALS['ecs']->table('goods_attr') . ' WHERE goods_id = \'' . $res[$i]['goods_id'] . '\' AND goods_attr_id IN(' . $goods_attr_id . ')';
		$attr_value = $GLOBALS['db']->getAll($sql);
		$res[$i]['attr_value'] = get_goods_attr_value($attr_value);
	}

	$arr = array('product_list' => $res, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count'], 'query' => 'sku_query');
	return $arr;
}

function get_goods_attr_value($attr_value)
{
	$str = '';

	if ($attr_value) {
		foreach ($attr_value as $key => $val) {
			$str .= '【' . $val['attr_value'] . '】';
		}
	}

	return $str;
}

function goods_parse_url($url)
{
	$parse_url = @parse_url($url);
	return !empty($parse_url['scheme']) && !empty($parse_url['host']);
}

function get_area_goods($goods_id)
{
	$sql = 'select rw.region_id, rw.region_name from ' . $GLOBALS['ecs']->table('link_area_goods') . ' as lag' . ' left join ' . $GLOBALS['ecs']->table('region_warehouse') . ' as rw on lag.region_id = rw.region_id' . ' where lag.goods_id = \'' . $goods_id . '\'';
	return $GLOBALS['db']->getAll($sql);
}

function my_array_merge($array1, $array2)
{
	$new_array = $array1;

	foreach ($array2 as $key => $val) {
		$new_array[$key] = $val;
	}

	return $new_array;
}

function get_goods_change_logs($goods_id)
{
	include_once ROOT_PATH . 'includes/lib_order.php';
	$result = get_filter();

	if ($result === false) {
		$filter['keyword'] = empty($_REQUEST['keyword']) ? '' : trim($_REQUEST['keyword']);
		if (isset($_REQUEST['is_ajax']) && ($_REQUEST['is_ajax'] == 1)) {
			$filter['keyword'] = json_str_iconv($filter['keyword']);
		}

		$filter['start_time'] = empty($_REQUEST['start_time']) ? '' : trim($_REQUEST['start_time']);
		$filter['end_time'] = empty($_REQUEST['end_time']) ? '' : trim($_REQUEST['end_time']);
		$filter['sort_by'] = empty($_REQUEST['sort_by']) ? 'gcl.log_id' : trim($_REQUEST['sort_by']);
		$filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);
		$filter['goodsId'] = empty($_REQUEST['goodsId']) ? 0 : intval($_REQUEST['goodsId']);
		$filter['operation_type'] = !isset($_REQUEST['operation_type']) ? -1 : intval($_REQUEST['operation_type']);
		$where = ' WHERE 1 ';

		if (!empty($goods_id)) {
			$where .= ' AND gcl.goods_id = ' . $goods_id . ' ';
		}
		else {
			return false;
		}

		if (!empty($filter['keyword'])) {
			$where .= ' AND g.goods_name LIKE \'%' . mysql_like_quote($filter['keyword']) . '%\'';
		}

		if (!empty($filter['start_time']) || !empty($filter['end_time'])) {
			$filter['start_time'] = local_strtotime($filter['start_time']);
			$filter['end_time'] = local_strtotime($filter['end_time']);
			$where .= ' AND gcl.handle_time > \'' . $filter['start_time'] . '\' AND gcl.handle_time < \'' . $filter['end_time'] . '\'';
		}

		$sql = 'SELECT COUNT(*) FROM ' . $GLOBALS['ecs']->table('goods_change_log') . ' as gcl ' . ' LEFT JOIN ' . $GLOBALS['ecs']->table('goods') . ' as g ON gcl.goods_id = g.goods_id' . $where;
		$filter['record_count'] = $GLOBALS['db']->getOne($sql);
		$filter = page_and_size($filter);
		$list = array();
		$sql = 'SELECT gcl.*, au.user_name AS admin_name FROM ' . $GLOBALS['ecs']->table('goods_change_log') . ' as gcl ' . ' LEFT JOIN ' . $GLOBALS['ecs']->table('goods') . ' as g ON gcl.goods_id = g.goods_id' . ' LEFT JOIN ' . $GLOBALS['ecs']->table('admin_user') . ' as au ON gcl.user_id = au.user_id ' . $where . ' GROUP BY gcl.log_id ORDER by ' . $filter['sort_by'] . ' ' . $filter['sort_order'];
		$res = $GLOBALS['db']->selectLimit($sql, $filter['page_size'], $filter['start']);
		$filter['keyword'] = stripslashes($filter['keyword']);
		set_filter($filter, $sql, $param_str);
	}
	else {
		$sql = $result['sql'];
		$filter = $result['filter'];
	}

	while ($rows = $GLOBALS['db']->fetchRow($res)) {
		$rows['shop_price'] = price_format($rows['shop_price']);
		$rows['shipping_fee'] = price_format($rows['shipping_fee']);
		$rows['handle_time'] = local_date($GLOBALS['_CFG']['time_format'], $rows['handle_time']);
		$list[] = $rows;
	}

	return array('list' => $list, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
}

function is_distribution($ru_id)
{
	$field = get_table_file_name($GLOBALS['ecs']->table('merchants_steps_fields'), 'is_distribution');

	if ($field['bool']) {
		$sql = ' SELECT is_distribution FROM ' . $GLOBALS['ecs']->table('merchants_steps_fields') . ' WHERE user_id = \'' . $ru_id . '\' ';
		$one = $GLOBALS['db']->getOne($sql);

		if ($one == '是') {
			return true;
		}
		else {
			return false;
		}
	}
	else {
		return false;
	}
}

function is_mer($goods_id)
{
	$sql = ' SELECT user_id FROM ' . $GLOBALS['ecs']->table('goods') . ' WHERE goods_id = \'' . $goods_id . '\' ';
	$one = $GLOBALS['db']->getOne($sql);

	if ($one == 0) {
		return false;
	}
	else {
		return $one;
	}
}

function get_areaRegion_list()
{
	$sql = 'select ra_id, ra_name from ' . $GLOBALS['ecs']->table('merchants_region_area') . ' where 1 order by ra_sort asc';
	$res = $GLOBALS['db']->getAll($sql);
	$arr = array();

	foreach ($res as $key => $row) {
		$arr[$key]['ra_id'] = $row['ra_id'];
		$arr[$key]['ra_name'] = $row['ra_name'];
		$arr[$key]['area'] = get_arearegion_info_list($row['ra_id']);
	}

	return $arr;
}

function update_goods_stock($goods_id, $value, $warehouse_id = 0)
{
	if ($goods_id) {
		$sql = 'UPDATE ' . $GLOBALS['ecs']->table('warehouse_goods') . "\r\n                SET region_number = region_number + " . $value . ",\r\n                    last_update = '" . gmtime() . "'\r\n                WHERE goods_id = '" . $goods_id . '\' and region_id = \'' . $warehouse_id . '\'';
		$result = $GLOBALS['db']->query($sql);
		clear_cache_files();
		return $result;
	}
	else {
		return false;
	}
}

function handle_volume_price($goods_id, $is_volume, $number_list, $price_list, $id_list)
{
	if ($is_volume) {
		foreach ($price_list as $key => $price) {
			$volume_number = $number_list[$key];
			$volume_id = (isset($id_list[$key]) && !empty($id_list[$key]) ? $id_list[$key] : 0);

			if (!empty($price)) {
				if ($volume_id) {
					$sql = 'SELECT id FROM ' . $GLOBALS['ecs']->table('volume_price') . ' WHERE goods_id = \'' . $goods_id . '\' AND (volume_price = \'' . $price . '\' OR volume_number = \'' . $volume_number . '\')';

					if ($GLOBALS['db']->getOne($sql)) {
						$sql = 'UPDATE ' . $GLOBALS['ecs']->table('volume_price') . ' SET volume_number = \'' . $volume_number . '\', volume_price = \'' . $price . '\' WHERE id = \'' . $volume_id . '\'';
						$GLOBALS['db']->query($sql);
					}
				}
				else {
					$sql = 'SELECT id FROM ' . $GLOBALS['ecs']->table('volume_price') . ' WHERE goods_id = \'' . $goods_id . '\' AND (volume_price = \'' . $price . '\' OR volume_number = \'' . $volume_number . '\')';

					if (!$GLOBALS['db']->getOne($sql)) {
						$sql = 'INSERT INTO ' . $GLOBALS['ecs']->table('volume_price') . ' (price_type, goods_id, volume_number, volume_price) ' . 'VALUES (\'1\', \'' . $goods_id . '\', \'' . $volume_number . '\', \'' . $price . '\')';
						$GLOBALS['db']->query($sql);
					}
				}
			}
		}
	}
	else {
		$sql = 'DELETE FROM ' . $GLOBALS['ecs']->table('volume_price') . ' WHERE price_type = \'1\' AND goods_id = \'' . $goods_id . '\'';
		$GLOBALS['db']->query($sql);
	}
}

function get_store_id($order_id = 0)
{
	$sql = 'SELECT store_id FROM' . $GLOBALS['ecs']->table('store_order') . ' WHERE order_id = \'' . $order_id . '\'';
	return $GLOBALS['db']->getOne($sql);
}

function return_integral_rank($ret_id = 0, $user_id = 0, $order_sn = 0, $rec_id = 0, $refound_pay_points = 0)
{
	$sql = ' SELECT IF(g.give_integral != -1,g.give_integral*o.return_number,org.goods_price*o.return_number) as give_integral , IF(g.rank_integral != -1,g.rank_integral*o.return_number,org.goods_price*o.return_number) as rank_integral FROM ' . $GLOBALS['ecs']->table('goods') . ' AS g ' . 'LEFT JOIN ' . $GLOBALS['ecs']->table('order_return') . ' AS ord ON ord.goods_id = g.goods_id ' . 'LEFT JOIN ' . $GLOBALS['ecs']->table('order_goods') . ' AS org ON org.rec_id = \'' . $rec_id . '\' ' . 'LEFT JOIN ' . $GLOBALS['ecs']->table('order_return_extend') . ' AS o ON o.ret_id = ord.ret_id  WHERE o.ret_id = \'' . $ret_id . '\'';
	$return_integral = $GLOBALS['db']->getRow($sql);
	$gave_custom_points = $return_integral['give_integral'];

	if (!empty($return_integral)) {
		log_account_change($user_id, 0, 0, '-' . $return_integral['rank_integral'], '-' . $gave_custom_points, sprintf($GLOBALS['_LANG']['return_order_gift_integral'], $order_sn), ACT_OTHER, 1);
		return NULL;
	}
}

function get_warehouse_area_goods($warehouse_id, $goods_id, $table)
{
	$sql = 'SELECT region_number FROM ' . $GLOBALS['ecs']->table($table) . ' WHERE region_id = \'' . $warehouse_id . '\' AND goods_id = \'' . $goods_id . '\'';
	return $GLOBALS['db']->getOne($sql);
}

if (!defined('IN_ECS')) {
	exit('Hacking attempt');
}

?>
