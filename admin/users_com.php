<?php
//zend by QQ:124861234  月梦网络  禁止倒卖 一经发现停止任何服务
function user_com_date($result)
{
	if (empty($result)) {
		return i('没有符合您要求的数据！^_^');
	}

	$data = i('编号,企业名称,金额' . "\n");
	$count = count($result);

	for ($i = 0; $i < $count; $i++) {
		if (empty($result[$i]['ru_name'])) {
			$result[$i]['ru_name'] = '商城会员';
		}

		$data .= i($result[$i]['company_id']) . ',' . i($result[$i]['code']) . ',' . i($result[$i]['ru_name']) . ',' . i($result[$i]['companyName']) . ',' . i($result[$i]['je']) ."\n";
	}

	return $data;
}

function i($strInput)
{
	return iconv('utf-8', 'gb2312', $strInput);
}

function user_com_list()
{
	$result = get_filter();

	if ($result === false) {
		$filter['keywords'] = empty($_REQUEST['keywords']) ? '' : trim($_REQUEST['keywords']);
		if (isset($_REQUEST['is_ajax']) && ($_REQUEST['is_ajax'] == 1)) {
			$filter['keywords'] = json_str_iconv($filter['keywords']);
		}

		$filter['rank'] = empty($_REQUEST['rank']) ? 0 : intval($_REQUEST['rank']);
		$filter['pay_points_gt'] = empty($_REQUEST['pay_points_gt']) ? 0 : intval($_REQUEST['pay_points_gt']);
		$filter['pay_points_lt'] = empty($_REQUEST['pay_points_lt']) ? 0 : intval($_REQUEST['pay_points_lt']);
		$filter['mobile_phone'] = empty($_REQUEST['mobile_phone']) ? 0 : addslashes($_REQUEST['mobile_phone']);
		$filter['email'] = empty($_REQUEST['email']) ? 0 : addslashes($_REQUEST['email']);
		$filter['sort_by'] = empty($_REQUEST['sort_by']) ? 'u.company_id' : trim($_REQUEST['sort_by']);
		$filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);
		$ex_where = ' WHERE 1 ';
		$filter['store_search'] = empty($_REQUEST['store_search']) ? 0 : intval($_REQUEST['store_search']);
		$filter['merchant_id'] = isset($_REQUEST['merchant_id']) ? intval($_REQUEST['merchant_id']) : 0;
		$filter['store_keyword'] = isset($_REQUEST['store_keyword']) ? trim($_REQUEST['store_keyword']) : '';
		$store_where = '';
		$store_search_where = '';

		if ($filter['store_search'] != 0) {
			if ($ru_id == 0) {
				if ($_REQUEST['store_type']) {
					$store_search_where = 'AND msi.shopNameSuffix = \'' . $_REQUEST['store_type'] . '\'';
				}

				if ($filter['store_search'] == 1) {
					$ex_where .= ' AND u.user_id = \'' . $filter['merchant_id'] . '\' ';
				}
				else if ($filter['store_search'] == 2) {
					$store_where .= ' AND msi.rz_shopName LIKE \'%' . mysql_like_quote($filter['store_keyword']) . '%\'';
				}
				else if ($filter['store_search'] == 3) {
					$store_where .= ' AND msi.shoprz_brandName LIKE \'%' . mysql_like_quote($filter['store_keyword']) . '%\' ' . $store_search_where;
				}

				if (1 < $filter['store_search']) {
					$ex_where .= ' AND (SELECT msi.user_id FROM ' . $GLOBALS['ecs']->table('merchants_shop_information') . ' as msi ' . ' WHERE msi.user_id = u.user_id ' . $store_where . ') > 0 ';
				}
			}
		}

		if ($filter['keywords']) {
			$ex_where .= ' AND (u.companyName LIKE \'%' . mysql_like_quote($filter['keywords']) . '%\' OR u.companyName LIKE \'%' . mysql_like_quote($filter['keywords']) . '%\')';
		}

		if ($filter['mobile_phone']) {
			$ex_where .= ' AND u.mobile_phone = \'' . $filter['mobile_phone'] . '\'';
		}

		if ($filter['email']) {
			$ex_where .= ' AND u.email = \'' . $filter['email'] . '\'';
		}

		if ($filter['rank']) {
			$sql = 'SELECT min_points, max_points, special_rank FROM ' . $GLOBALS['ecs']->table('user_rank') . ' WHERE rank_id = \'' . $filter['rank'] . '\'';
			$row = $GLOBALS['db']->getRow($sql);

			if (0 < $row['special_rank']) {
				$ex_where .= ' AND u.user_rank = \'' . $filter['rank'] . '\' ';
			}
			else {
				$ex_where .= ' AND u.rank_points >= ' . intval($row['min_points']) . ' AND u.rank_points < ' . intval($row['max_points']);
			}
		}

		if ($filter['pay_points_gt']) {
			$ex_where .= ' AND u.pay_points < \'' . $filter['pay_points_gt'] . '\' ';
		}

		if ($filter['pay_points_lt']) {
			$ex_where .= ' AND u.pay_points >= \'' . $filter['pay_points_lt'] . '\' ';
		}

		$filter['record_count'] = $GLOBALS['db']->getOne('SELECT COUNT(*) FROM ' . $GLOBALS['ecs']->table('company') . ' AS u ' . $ex_where);
		$filter = page_and_size($filter);
		$sql = 'SELECT u.company_id, u.code, u.companyName, u.je' . ' FROM ' . $GLOBALS['ecs']->table('company') . ' AS u ' . $ex_where . ' ORDER by ' . $filter['sort_by'] . ' ' . $filter['sort_order'] . ' LIMIT ' . $filter['start'] . ',' . $filter['page_size'];
		$filter['keywords'] = stripslashes($filter['keywords']);
		set_filter($filter, $sql);
	}
	else {
		$sql = $result['sql'];
		$filter = $result['filter'];
	}
   
	$user_list = $GLOBALS['db']->getAll($sql);
	$count = count($user_list); 
	$arr = array('user_list' => $user_list, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']); 
	return $arr;
}

function user_update($user_id, $args)
{
	if (empty($args) || empty($user_id)) {
		return false;
	}

	return $GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('users'), $args, 'update', 'user_id=\'' . $user_id . '\'');
}

define('IN_ECS', true);
require dirname(__FILE__) . '/includes/init.php';
$adminru = get_admin_ru_id();

if ($adminru['ru_id'] == 0) {
	$smarty->assign('priv_ru', 1);
}
else {
	$smarty->assign('priv_ru', 0);
}

if ($_REQUEST['act'] == 'list') {
	admin_priv('users_manage');
	$smarty->assign('menu_select', array('action' => '08_members', 'current' => '03_users_list'));
	$sql = 'SELECT rank_id, rank_name, min_points FROM ' . $ecs->table('user_rank') . ' ORDER BY min_points ASC ';
	$rs = $db->query($sql);
	$ranks = array();

	while ($row = $db->FetchRow($rs)) {
		$ranks[$row['rank_id']] = $row['rank_name'];
	}

	$smarty->assign('user_ranks', $ranks);
	$smarty->assign('ur_here', $_LANG['03_users_list']);
	$smarty->assign('action_link', array('text' => $_LANG['04_users_add'], 'href' => 'users.php?act=add'));
	$smarty->assign('action_link2', array('text' => $_LANG['12_users_export'], 'href' => 'javascript:download_userlist();'));
	$store_list = get_common_store_list();
	$smarty->assign('store_list', $store_list);
	$user_list = user_com_list();
	$smarty->assign('user_list', $user_list['user_list']);
	$smarty->assign('filter', $user_list['filter']);
	$smarty->assign('record_count', $user_list['record_count']);
	$smarty->assign('page_count', $user_list['page_count']);
	$smarty->assign('full_page', 1);
	$smarty->assign('sort_user_id', '<img src="images/sort_desc.gif">');
	assign_query_info();
	$smarty->display('users_com_list.dwt');
}
else if ($_REQUEST['act'] == 'query') {
	$user_list = user_com_list();
	$smarty->assign('user_list', $user_list['user_list']);
	$smarty->assign('filter', $user_list['filter']);
	$smarty->assign('record_count', $user_list['record_count']);
	$smarty->assign('page_count', $user_list['page_count']);
	$store_list = get_common_store_list();
	$smarty->assign('store_list', $store_list);
	$sort_flag = sort_flag($user_list['filter']);
	$smarty->assign($sort_flag['tag'], $sort_flag['img']);
	make_json_result($smarty->fetch('users_com_list.dwt'), '', array('filter' => $user_list['filter'], 'page_count' => $user_list['page_count']));
}
else if ($_REQUEST['act'] == 'add') {
	admin_priv('users_manage');
	$user = array('rank_points' => $_CFG['register_points'], 'pay_points' => $_CFG['register_points'], 'sex' => 0, 'credit_line' => 0);
	$sql = 'SELECT * FROM ' . $ecs->table('reg_fields') . ' WHERE type < 2 AND display = 1 ORDER BY dis_order, id';
	$extend_info_list = $db->getAll($sql); 
	$smarty->assign('form_action', 'insert');
	$smarty->assign('company', $user); 
	assign_query_info();
	$smarty->display('user_com_add.dwt');
}
else if ($_REQUEST['act'] == 'insert') {
	admin_priv('users_manage');
	$code = (empty($_POST['code']) ? '' : trim($_POST['code']));
	$companyName = (empty($_POST['companyName']) ? '' : trim($_POST['companyName']));
	$je = (empty($_POST['je']) ? '' : trim($_POST['je']));
	$users = &init_users();

	 if (empty($code))
	 {
		sys_msg('企业编码不能够为空', 1);
	 }
	 if (empty($companyName))
	 {
		sys_msg('企业名称不能够为空', 1);
	 }
	 if (empty($je))
	 {
		sys_msg('金额不能够为空', 1);
	 }
	$other = array();
	$other['code'] = $code;
	$other['companyName'] = $companyName;
	$other['je'] = $je;
    
	if (!empty($other['code'])) {
		$sql = 'SELECT company_id FROM ' . $ecs->table('company') . ' WHERE code = \'' . $other['code'] . '\'';

		if (0 < $db->getOne($sql)) {
			sys_msg('该企业编码已经存在', 1);
		}
	}
	$str=' (\'' . $code . '\', \'' . $companyName . '\', \'' . $je . '\'),';
   $str = substr($str, 0, -1);
    $sql = 'INSERT INTO ' . $ecs->table('company') . ' (`code`, `companyName`, `je`) VALUES' . $str;
   $db->query($sql); 
	admin_log($_POST['code'], 'add', 'company');
	$link[] = array('text' => $_LANG['go_back'], 'href' => 'users_com.php?act=list');
	sys_msg(sprintf($_LANG['add_success'], htmlspecialchars(stripslashes($_POST['code']))), 0, $link);
}
else if ($_REQUEST['act'] == 'edit') {
	admin_priv('users_manage');
	$user_id = (isset($_GET['id']) && !empty($_GET['id']) ? intval($_GET['id']) : 0);
	$sql = 'SELECT *' . ' FROM ' . $ecs->table('company') . ' WHERE company_id = \'' . $user_id . '\'';
	$row = $db->GetRow($sql);
	  
	$user =  array(); 

	if ($row) {
		$user['company_id'] = $row['company_id'];
		$user['code'] = $row['code'];
		$user['companyName'] = $row['companyName'];
		$user['je'] = date($row['je']);

		 
	}
	else {
		$link[] = array('text' => $_LANG['go_back'], 'href' => 'users_com.php?act=list');
		sys_msg($_LANG['username_invalid'], 0, $links);
	}
 
	$smarty->assign('full_page', 1);
	$smarty->assign('action_link2', array('text' => $_LANG['03_users_list'], 'href' => 'users.php?act=list'));
	 
	$smarty->assign('select_date', $select_date);
	$smarty->assign('company_id', $user['company_id']);
	assign_query_info();
	$smarty->assign('ur_here', $_LANG['users_edit']);
	$smarty->assign('user', $user);
	$smarty->assign('form_action', 'update');
	$smarty->assign('special_ranks', get_rank_list(true));
	$smarty->display('user_com_list_edit.dwt');
}
else if ($_REQUEST['act'] == 'update') {
	admin_priv('users_manage');
	$code = (empty($_POST['code']) ? '' : trim($_POST['code']));
	$companyName = (empty($_POST['companyName']) ? '' : trim($_POST['companyName']));
	$je = (empty($_POST['je']) ? '' : trim($_POST['je'])); 
	$id = (empty($_POST['id']) ? 0 : intval($_POST['id'])); 
	$users = &init_users();

	if (!empty($code)) {
		$sql = 'SELECT company_id FROM ' . $ecs->table('company') . ' WHERE code = \'' . $code. '\' and company_id!=\'' . $id. '\'';

		if (0 < $db->getOne($sql)) {
			sys_msg('该企业编码已经存在', 1);
		}
	}

	$other = array();
	$other['code'] = $code;
	$other['companyName'] = $companyName;
	$other['je'] = $je; 
	   
	$db->autoExecute($ecs->table('company'), $other, 'UPDATE', 'code = \'' . $code . '\'');
	admin_log($code, 'edit', 'company');
	$links[0]['text'] = $_LANG['goto_list'];
	$links[0]['href'] = 'users_com.php?act=list&' . list_link_postfix();
	$links[1]['text'] = $_LANG['go_back'];
	$links[1]['href'] = 'javascript:history.back()';
	sys_msg($_LANG['update_success'], 0, $links);
}

if ($_REQUEST['act'] == 'toggle_is_validated') {
	check_authz_json('users_manage');
	$id = intval($_POST['id']);
	$val = intval($_POST['val']);

	if (user_update($id, array('is_validated' => $val)) != false) {
		clear_cache_files();
		make_json_result($val);
	}
	else {
		make_json_error($db->error());
	}
}
else if ($_REQUEST['act'] == 'batch_remove') {
	admin_priv('users_drop');

	if (isset($_POST['checkboxes'])) {
		$priv_str = $db->getOne('SELECT action_list FROM ' . $ecs->table('admin_user') . ' WHERE user_id = \'' . $_SESSION['admin_id'] . '\'');

		if ($priv_str != 'all') {
			foreach ($_POST['checkboxes'] as $key => $val) {
				$sql = 'SELECT id FROM ' . $GLOBALS['ecs']->table('seller_shopinfo') . ' WHERE ru_id = \'' . $val . '\'';
				$shopinfo = $GLOBALS['db']->getOne($sql);

				if (!empty($shopinfo)) {
					unset($_POST['checkboxes'][$key]);
				}
			}
		}

		$sql = 'SELECT user_name FROM ' . $ecs->table('users') . ' WHERE user_id ' . db_create_in($_POST['checkboxes']);
		$col = $db->getCol($sql);
		$usernames = implode(',', addslashes_deep($col));
		$count = count($col);
		$users = &init_users();
		$users->remove_user($col);
		admin_log($usernames, 'batch_remove', 'users');
		$lnk[] = array('text' => $_LANG['go_back'], 'href' => 'users.php?act=list');
		sys_msg(sprintf($_LANG['batch_remove_success'], $count), 0, $lnk);
	}
	else {
		$lnk[] = array('text' => $_LANG['go_back'], 'href' => 'users.php?act=list');
		sys_msg($_LANG['no_select_user'], 0, $lnk);
	}
}
else if ($_REQUEST['act'] == 'main_user') {
	require_once ROOT_PATH . '/includes/lib_base.php';
	$data = read_static_cache('main_user_str');

	if ($data === false) {
		include_once ROOT_PATH . 'includes/cls_transport.php';
		$ecs_version = VERSION;
		$ecs_lang = $_CFG['lang'];
		$ecs_release = RELEASE;
		$php_ver = PHP_VERSION;
		$mysql_ver = $db->version();
		$ecs_charset = strtoupper(EC_CHARSET);
		$scount = $db->getOne('SELECT COUNT(*) FROM ' . $ecs->table('seller_shopinfo'));
		$no_main_order = ' WHERE 1 AND (select count(*) from ' . $GLOBALS['ecs']->table('order_info') . ' AS oi2 WHERE oi2.main_order_id = o.order_id) = 0 ';
		$sql = 'SELECT COUNT(*) AS oCount, IFNULL(SUM(order_amount), 0) AS oAmount FROM ' . $ecs->table('order_info') . ' AS o ' . $no_main_order;
		$order['stats'] = $db->getRow($sql);
		$ocount = $order['stats']['oCount'];
		$oamount = $order['stats']['oAmount'];
		$goods['total'] = $db->GetOne('SELECT COUNT(*) FROM ' . $ecs->table('goods') . ' WHERE is_delete = 0 AND is_alone_sale = 1 AND is_real = 1');
		$gcount = $goods['total'];
		$ecs_user = $db->getOne('SELECT COUNT(*) FROM ' . $ecs->table('users'));
		$ecs_template = $db->getOne('SELECT value FROM ' . $ecs->table('shop_config') . ' WHERE code = \'template\'');
		$style = $db->getOne('SELECT value FROM ' . $ecs->table('shop_config') . ' WHERE code = \'stylename\'');

		if ($style == '') {
			$style = '0';
		}

		$ecs_style = $style;
		$shop_url = urlencode($ecs->url());
		$httpData = array('domain' => $ecs->get_domain(), 'url' => urldecode($shop_url), 'ver' => $ecs_version, 'lang' => $ecs_lang, 'release' => $ecs_release, 'php_ver' => $php_ver, 'mysql_ver' => $mysql_ver, 'ocount' => $ocount, 'oamount' => $oamount, 'gcount' => $gcount, 'scount' => $scount, 'charset' => $ecs_charset, 'usecount' => $ecs_user, 'template' => $ecs_template, 'style' => $ecs_style);
		$Http = new Http();
		$Http->doPost('http://ecshop.ecmoban.com/dsc_checkver.php', $httpData);
		write_static_cache('main_user_str', $httpData);
	}
}
else if ($_REQUEST['act'] == 'remove') {
	admin_priv('users_drop');
	$company_id = intval($_GET['id']);
   

	$sql = 'DELETE  FROM ' . $ecs->table('company') . ' WHERE company_id = \'' . $company_id . '\'';
	  $db->query($sql); 
	admin_log($company_id, 'remove', 'company');
	$link[] = array('text' => $_LANG['go_back'], 'href' => 'users_com.php?act=list');
	sys_msg(sprintf($_LANG['remove_success'], $company_id), 0, $link);
}
else if ($_REQUEST['act'] == 'address_list') {
	$id = (isset($_GET['id']) ? intval($_GET['id']) : 0);
	$sql = 'SELECT a.*, c.region_name AS country_name, p.region_name AS province, ct.region_name AS city_name, d.region_name AS district_name ' . ' FROM ' . $ecs->table('user_address') . ' as a ' . ' LEFT JOIN ' . $ecs->table('region') . ' AS c ON c.region_id = a.country ' . ' LEFT JOIN ' . $ecs->table('region') . ' AS p ON p.region_id = a.province ' . ' LEFT JOIN ' . $ecs->table('region') . ' AS ct ON ct.region_id = a.city ' . ' LEFT JOIN ' . $ecs->table('region') . ' AS d ON d.region_id = a.district ' . ' WHERE user_id=\'' . $id . '\'';
	$address = $db->getAll($sql);
	$smarty->assign('address', $address);
	$smarty->assign('user_id', $id);
	$smarty->assign('form_action', 'address_list');
	$smarty->assign('full_page', 1);
	$smarty->assign('ur_here', $_LANG['address_list']);

	if (0 < $id) {
		$smarty->assign('action_link2', array('text' => $_LANG['address_list'], 'href' => 'users.php?act=list'));
	}

	assign_query_info();
	$smarty->display('user_list_edit.dwt');
}
else if ($_REQUEST['act'] == 'remove_parent') {
	admin_priv('users_manage');
	$sql = 'UPDATE ' . $ecs->table('users') . ' SET parent_id = 0 WHERE user_id = \'' . $_GET['id'] . '\'';
	$db->query($sql);
	$sql = 'SELECT user_name FROM ' . $ecs->table('users') . ' WHERE user_id = \'' . $_GET['id'] . '\'';
	$username = $db->getOne($sql);
	admin_log(addslashes($username), 'edit', 'users');
	$link[] = array('text' => $_LANG['go_back'], 'href' => 'users.php?act=list');
	sys_msg(sprintf($_LANG['update_success'], $username), 0, $link);
}
else if ($_REQUEST['act'] == 'aff_list') {
	admin_priv('users_manage');
	$smarty->assign('ur_here', $_LANG['03_users_list']);
	$auid = $_GET['auid'];
	$user_list['user_list'] = array();
	$affiliate = unserialize($GLOBALS['_CFG']['affiliate']);
	$smarty->assign('affiliate', $affiliate);
	empty($affiliate) && ($affiliate = array());
	$num = count($affiliate['item']);
	$up_uid = '\'' . $auid . '\'';
	$all_count = 0;

	for ($i = 1; $i <= $num; $i++) {
		$count = 0;

		if ($up_uid) {
			$sql = 'SELECT user_id FROM ' . $ecs->table('users') . ' WHERE parent_id IN(' . $up_uid . ')';
			$query = $db->query($sql);
			$up_uid = '';

			while ($rt = $db->fetch_array($query)) {
				$up_uid .= ($up_uid ? ',\'' . $rt['user_id'] . '\'' : '\'' . $rt['user_id'] . '\'');
				$count++;
			}
		}

		$all_count += $count;

		if ($count) {
			$sql = 'SELECT user_id, user_name, \'' . $i . '\' AS level, email, is_validated, user_money, frozen_money, rank_points, pay_points, reg_time ' . ' FROM ' . $GLOBALS['ecs']->table('users') . ' WHERE user_id IN(' . $up_uid . ')' . ' ORDER by level, user_id';
			$user_list['user_list'] = array_merge($user_list['user_list'], $db->getAll($sql));
		}
	}

	$temp_count = count($user_list['user_list']);

	for ($i = 0; $i < $temp_count; $i++) {
		$user_list['user_list'][$i]['reg_time'] = local_date($_CFG['date_format'], $user_list['user_list'][$i]['reg_time']);
	}

	$user_list['record_count'] = $all_count;
	$smarty->assign('user_list', $user_list['user_list']);
	$smarty->assign('record_count', $user_list['record_count']);
	$smarty->assign('full_page', 1);
	$smarty->assign('action_link', array('text' => $_LANG['back_note'], 'href' => 'users.php?act=edit&id=' . $auid));
	assign_query_info();
	$smarty->display('affiliate_list.dwt');
}
else if ($_REQUEST['act'] == 'export') {
	$filename = date('YmdHis') . '.csv';
	header('Content-type:text/csv');
	header('Content-Disposition:attachment;filename=' . $filename);
	header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
	header('Expires:0');
	header('Pragma:public');
	$user_list = user_com_list();
	echo user_date($user_list['user_list']);
	exit();
}

?>
