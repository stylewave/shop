<?php
//zend by 旺旺dongshaolin2008所有  禁止倒卖 一经发现停止任何服务
function msg_list()
{
	$filter['keywords'] = empty($_REQUEST['keywords']) ? '' : trim($_REQUEST['keywords']);
	if (isset($_REQUEST['is_ajax']) && ($_REQUEST['is_ajax'] == 1)) {
		$filter['keywords'] = json_str_iconv($filter['keywords']);
	}

	$filter['msg_type'] = isset($_REQUEST['msg_type']) ? intval($_REQUEST['msg_type']) : -1;
	$filter['sort_by'] = empty($_REQUEST['sort_by']) ? 'f.msg_id' : trim($_REQUEST['sort_by']);
	$filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);
	$where = '';

	if ($filter['keywords']) {
		$where .= ' AND f.msg_title LIKE \'%' . mysql_like_quote($filter['keywords']) . '%\' ';
	}

	if ($filter['msg_type'] != -1) {
		$where .= ' AND f.msg_type = \'' . $filter['msg_type'] . '\' ';
	}

	$sql = 'SELECT count(*) FROM ' . $GLOBALS['ecs']->table('feedback') . ' AS f' . ' WHERE parent_id = \'0\' ' . $where;
	$filter['record_count'] = $GLOBALS['db']->getOne($sql);
	$filter = page_and_size($filter);
	$sql = 'SELECT f.msg_id, f.user_name, f.msg_title, f.msg_type, f.order_id, f.msg_status, f.msg_time, f.msg_area, COUNT(r.msg_id) AS reply ' . 'FROM ' . $GLOBALS['ecs']->table('feedback') . ' AS f ' . 'LEFT JOIN ' . $GLOBALS['ecs']->table('feedback') . ' AS r ON r.parent_id=f.msg_id ' . 'WHERE f.parent_id = 0 ' . $where . ' ' . 'GROUP BY f.msg_id ' . 'ORDER by ' . $filter['sort_by'] . ' ' . $filter['sort_order'] . ' ' . 'LIMIT ' . $filter['start'] . ', ' . $filter['page_size'];
	$msg_list = $GLOBALS['db']->getAll($sql);

	foreach ($msg_list as $key => $value) {
		if (0 < $value['order_id']) {
			$msg_list[$key]['order_sn'] = $GLOBALS['db']->getOne('SELECT order_sn FROM ' . $GLOBALS['ecs']->table('order_info') . ' WHERE order_id= ' . $value['order_id']);
		}

		$msg_list[$key]['msg_time'] = local_date($GLOBALS['_CFG']['time_format'], $value['msg_time']);
		$msg_list[$key]['msg_type'] = $GLOBALS['_LANG']['type'][$value['msg_type']];
	}

	$filter['keywords'] = stripslashes($filter['keywords']);
	$arr = array('msg_list' => $msg_list, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
	return $arr;
}

function get_feedback_detail($id)
{
	global $ecs;
	global $db;
	global $_CFG;
	$sql = 'SELECT T1.*, T2.msg_id AS reply_id, T2.user_name  AS reply_name, u.email AS reply_email, ' . 'T2.msg_content AS reply_content , T2.msg_time AS reply_time, T2.user_name AS reply_name ' . 'FROM ' . $ecs->table('feedback') . ' AS T1 ' . 'LEFT JOIN ' . $ecs->table('admin_user') . ' AS u ON u.user_id=\'' . $_SESSION['seller_id'] . '\' ' . 'LEFT JOIN ' . $ecs->table('feedback') . ' AS T2 ON T2.parent_id=T1.msg_id ' . 'WHERE T1.msg_id = \'' . $id . '\'';
	$msg = $db->GetRow($sql);

	if ($msg) {
		$msg['msg_time'] = local_date($_CFG['time_format'], $msg['msg_time']);
		$msg['reply_time'] = local_date($_CFG['time_format'], $msg['reply_time']);
	}

	return $msg;
}

define('IN_ECS', true);
require dirname(__FILE__) . '/includes/init.php';
admin_priv('feedback_priv');
$exc = new exchange($ecs->table('feedback'), $db, 'msg_id', 'msg_title');
$smarty->assign('menus', $_SESSION['menus']);
$smarty->assign('action_type', 'users');

if ($_REQUEST['act'] == 'add') {
	$smarty->assign('menu_select', array('action' => '04_order', 'current' => '02_order_list'));
	$user_id = (empty($_GET['user_id']) ? 0 : intval($_GET['user_id']));
	$order_id = (empty($_GET['order_id']) ? 0 : intval($_GET['order_id']));
	$order_sn = $db->getOne('SELECT order_sn FROM ' . $ecs->table('order_info') . ' WHERE order_id = \'' . $order_id . '\'');
	$sql = 'SELECT msg_id, user_name, msg_title, msg_type, msg_time, msg_content' . ' FROM ' . $ecs->table('feedback') . ' WHERE user_id =\'' . $user_id . '\' AND order_id = \'' . $order_id . '\'';
	$msg_list = $db->getAll($sql);

	foreach ($msg_list as $key => $val) {
		$msg_list[$key]['msg_time'] = local_date($GLOBALS['_CFG']['time_format'], $val['msg_time']);
	}

	assign_query_info();
	$smarty->assign('ur_here', sprintf($_LANG['msg_for_order'], $order_sn));
	$smarty->assign('action_link', array('text' => $_LANG['order_detail'], 'href' => 'order.php?act=info&order_id=' . $order_id));
	$smarty->assign('msg_list', $msg_list);
	$smarty->assign('order_id', $_GET['order_id']);
	$smarty->assign('user_id', $_GET['user_id']);
	$smarty->display('msg_add.dwt');
}

if ($_REQUEST['act'] == 'insert') {
	$sql = 'INSERT INTO ' . $ecs->table('feedback') . '(parent_id, user_id, user_name, user_email, msg_title, msg_type, msg_content, msg_time, message_img, order_id)' . ' VALUES (0, \'' . $_POST['user_id'] . '\', \'' . $_SESSION['seller_name'] . '\', \' \', ' . ' \'' . $_POST['msg_title'] . '\', 5, \'' . $_POST['msg_content'] . '\', \'' . gmtime() . '\', \'\', \'' . $_POST['order_id'] . '\')';
	$db->query($sql);
	ecs_header('Location: user_msg.php?act=add&order_id=' . $_POST['order_id'] . '&user_id=' . $_POST['user_id'] . "\n");
	exit();
}

if ($_REQUEST['act'] == 'remove_msg') {
	$msg_id = (empty($_GET['msg_id']) ? 0 : intval($_GET['msg_id']));
	$order_id = (empty($_GET['order_id']) ? 0 : intval($_GET['order_id']));
	$user_id = (empty($_GET['user_id']) ? 0 : intval($_GET['user_id']));
	$sql = 'SELECT user_id, order_id, message_img FROM ' . $ecs->table('feedback') . ' WHERE msg_id=\'' . $msg_id . '\'';
	$row = $db->getRow($sql);

	if ($row) {
		if (($row['user_id'] == $user_id) && ($row['order_id'] == $order_id)) {
			if ($row['message_img']) {
				@unlink(ROOT_PATH . DATA_DIR . '/feedbackimg/' . $row['message_img']);
			}

			$sql = 'DELETE FROM ' . $ecs->table('feedback') . ' WHERE msg_id=' . $msg_id . ' LIMIT 1';
			$db->query($sql);
		}
	}

	ecs_header('Location: user_msg.php?act=add&order_id=' . $_GET['order_id'] . '&user_id=' . $_GET['user_id'] . "\n");
	exit();
}

if ($_REQUEST['act'] == 'check') {
	if ($_REQUEST['check'] == 'allow') {
		$sql = 'UPDATE ' . $ecs->table('feedback') . ' SET msg_status = 1 WHERE msg_id = \'' . $_REQUEST['id'] . '\'';
		$db->query($sql);
		clear_cache_files();
		ecs_header('Location: user_msg.php?act=view&id=' . $_REQUEST['id'] . "\n");
		exit();
	}
	else {
		$sql = 'UPDATE ' . $ecs->table('feedback') . ' SET msg_status = 0 WHERE msg_id = \'' . $_REQUEST['id'] . '\'';
		$db->query($sql);
		clear_cache_files();
		ecs_header('Location: user_msg.php?act=view&id=' . $_REQUEST['id'] . "\n");
		exit();
	}
}

if ($_REQUEST['act'] == 'list_all') {
	assign_query_info();
	$smarty->assign('menu_select', array('action' => '08_members', 'current' => '08_unreply_msg'));
	$msg_list = msg_list();
	$page_count_arr = seller_page($msg_list, $_REQUEST['page']);
	$smarty->assign('page_count_arr', $page_count_arr);
	$smarty->assign('msg_list', $msg_list['msg_list']);
	$smarty->assign('filter', $msg_list['filter']);
	$smarty->assign('record_count', $msg_list['record_count']);
	$smarty->assign('page_count', $msg_list['page_count']);
	$smarty->assign('full_page', 1);
	$smarty->assign('sort_msg_id', '<img src="images/sort_desc.gif">');
	$smarty->assign('ur_here', $_LANG['08_unreply_msg']);
	$smarty->assign('full_page', 1);
	$smarty->assign('current', 'user_msg');
	$smarty->display('msg_list.dwt');
}
else if ($_REQUEST['act'] == 'query') {
	$msg_list = msg_list();
	$page_count_arr = seller_page($msg_list, $_REQUEST['page']);
	$smarty->assign('page_count_arr', $page_count_arr);
	$smarty->assign('msg_list', $msg_list['msg_list']);
	$smarty->assign('filter', $msg_list['filter']);
	$smarty->assign('record_count', $msg_list['record_count']);
	$smarty->assign('page_count', $msg_list['page_count']);
	$sort_flag = sort_flag($msg_list['filter']);
	$smarty->assign($sort_flag['tag'], $sort_flag['img']);
	$smarty->assign('current', 'user_msg');
	make_json_result($smarty->fetch('msg_list.dwt'), '', array('filter' => $msg_list['filter'], 'page_count' => $msg_list['page_count']));
}
else if ($_REQUEST['act'] == 'remove') {
	$msg_id = intval($_REQUEST['id']);
	check_authz_json('feedback_priv');
	$msg_title = $exc->get_name($msg_id);
	$img = $exc->get_name($msg_id, 'message_img');

	if ($exc->drop($msg_id)) {
		if (!empty($img)) {
			@unlink(ROOT_PATH . DATA_DIR . '/feedbackimg/' . $img);
		}

		$sql = 'DELETE FROM ' . $ecs->table('feedback') . ' WHERE parent_id = \'' . $msg_id . '\' LIMIT 1';
		$db->query($sql, 'SILENT');
		admin_log(addslashes($msg_title), 'remove', 'message');
		$url = 'user_msg.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);
		ecs_header('Location: ' . $url . "\n");
		exit();
	}
	else {
		make_json_error($GLOBALS['db']->error());
	}
}

if ($_REQUEST['act'] == 'batch') {
	admin_priv('feedback_priv');
	$action = (isset($_POST['sel_action']) ? trim($_POST['sel_action']) : 'def');

	if (isset($_POST['checkboxes'])) {
		switch ($action) {
		case 'remove':
			$db->query('DELETE FROM ' . $ecs->table('feedback') . ' WHERE ' . db_create_in($_POST['checkboxes'], 'msg_id'));
			$db->query('DELETE FROM ' . $ecs->table('feedback') . ' WHERE ' . db_create_in($_POST['checkboxes'], 'parent_id'));
			break;

		case 'allow':
			$db->query('UPDATE ' . $ecs->table('feedback') . ' SET msg_status = 1  WHERE ' . db_create_in($_POST['checkboxes'], 'msg_id'));
			break;

		case 'deny':
			$db->query('UPDATE ' . $ecs->table('feedback') . ' SET msg_status = 0,msg_area =1  WHERE ' . db_create_in($_POST['checkboxes'], 'msg_id'));
			break;

		default:
			break;
		}

		clear_cache_files();
		$action = ($action == 'remove' ? 'remove' : 'edit');
		admin_log('', $action, 'adminlog');
		$link[] = array('text' => $_LANG['back_list'], 'href' => 'user_msg.php?act=list_all');
		sys_msg(sprintf($_LANG['batch_drop_success'], count($_POST['checkboxes'])), 0, $link);
	}
	else {
		$link[] = array('text' => $_LANG['back_list'], 'href' => 'user_msg.php?act=list_all');
		sys_msg($_LANG['no_select_comment'], 0, $link);
	}
}
else if ($_REQUEST['act'] == 'view') {
	$smarty->assign('menu_select', array('action' => '08_members', 'current' => '08_unreply_msg'));
	$smarty->assign('send_fail', !empty($_REQUEST['send_ok']));
	$smarty->assign('msg', get_feedback_detail(intval($_REQUEST['id'])));
	$smarty->assign('ur_here', $_LANG['reply']);
	$smarty->assign('action_link', array('text' => $_LANG['08_unreply_msg'], 'href' => 'user_msg.php?act=list_all'));
	assign_query_info();
	$smarty->assign('current', 'user_msg');
	$smarty->display('msg_info.dwt');
}
else if ($_REQUEST['act'] == 'action') {
	if (empty($_REQUEST['parent_id'])) {
		$sql = 'INSERT INTO ' . $ecs->table('feedback') . ' (msg_title, msg_time, user_id, user_name , ' . 'user_email, parent_id, msg_content) ' . 'VALUES (\'reply\', \'' . gmtime() . '\', \'' . $_SESSION['seller_id'] . '\', ' . '\'' . $_SESSION['seller_name'] . '\', \'' . $_POST['user_email'] . '\', ' . '\'' . $_REQUEST['msg_id'] . '\', \'' . $_POST['msg_content'] . '\') ';
		$db->query($sql);
	}
	else {
		$sql = 'UPDATE ' . $ecs->table('feedback') . ' SET user_email = \'' . $_POST['user_email'] . '\', msg_content=\'' . $_POST['msg_content'] . '\', msg_time = \'' . gmtime() . '\' WHERE msg_id = \'' . $_REQUEST['parent_id'] . '\'';
		$db->query($sql);
	}

	if (!empty($_POST['send_email_notice']) || isset($_POST['remail'])) {
		$sql = 'SELECT user_name, user_email, msg_title, msg_content ' . 'FROM ' . $ecs->table('feedback') . ' WHERE msg_id =\'' . $_REQUEST['msg_id'] . '\'';
		$message_info = $db->getRow($sql);
		$template = get_mail_template('user_message');
		$message_content = $message_info['msg_title'] . "\r\n" . $message_info['msg_content'];
		$smarty->assign('user_name', $message_info['user_name']);
		$smarty->assign('message_note', $_POST['msg_content']);
		$smarty->assign('message_content', $message_content);
		$smarty->assign('shop_name', '<a href=\'' . $ecs->seller_url() . '\'>' . $_CFG['shop_name'] . '</a>');
		$smarty->assign('send_date', date('Y-m-d'));
		$content = $smarty->fetch('str:' . $template['template_content']);

		if (send_mail($message_info['user_name'], $message_info['user_email'], $template['template_subject'], $content, $template['is_html'])) {
			$send_ok = 0;
		}
		else {
			$send_ok = 1;
		}
	}

	ecs_header('Location: ?act=view&id=' . $_REQUEST['msg_id'] . '&send_ok=' . $send_ok . "\n");
	exit();
}
else if ($_REQUEST['act'] == 'drop_file') {
	$file = $_GET['file'];
	@unlink('../' . DATA_DIR . '/feedbackimg/' . $file);
	$db->query('UPDATE ' . $ecs->table('feedback') . ' SET message_img = \'\' WHERE msg_id = \'' . $_GET['id'] . '\'');
	ecs_header('Location: user_msg.php?act=view&amp;id=' . $_GET['id'] . "\n");
	exit();
}

?>