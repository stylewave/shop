<?php
//zend by 旺旺dongshaolin2008所有  禁止倒卖 一经发现停止任何服务
function get_sysnav()
{
	$adminru = get_admin_ru_id();
	global $_LANG;
	$catlist = cat_list(0, 0, 0, 'merchants_category', array(), 0, $adminru['ru_id']);

	foreach ($catlist as $key => $val) {
		$val['url'] = build_uri('merchants_store', array('cid' => $val['cat_id'], 'urid' => $adminru['ru_id']), $val['cat_name']);
		$sysmain[] = array('cat_id' => $val['cat_id'], 'cat_name' => $val['cat_name'], 'url' => $val['url']);
	}

	return $sysmain;
}

define('IN_ECS', true);
require dirname(__FILE__) . '/includes/init.php';
require_once ROOT_PATH . '/' . ADMIN_PATH . '/includes/lib_goods.php';
include_once ROOT_PATH . '/includes/cls_image.php';
$image = new cls_image($_CFG['bgcolor']);
require ROOT_PATH . '/includes/cls_json.php';
require ROOT_PATH . '/includes/lib_visual.php';
$admin_id = get_admin_id();
$adminru = get_admin_ru_id();

if ($_REQUEST['act'] == 'dialog_content') {
	$json = new JSON();
	$result = array('content' => '', 'sgs' => '');
	$temp = (!empty($_REQUEST['temp']) ? $_REQUEST['temp'] : '');
	$smarty->assign('temp', $temp);
	$result['sgs'] = $temp;
	$result['content'] = $GLOBALS['smarty']->fetch('library/dialog.lbi');
	exit($json->encode($result));
}
else if ($_REQUEST['act'] == 'dialog_warehouse') {
	$json = new JSON();
	$result = array('content' => '', 'sgs' => '');
	$temp = (!empty($_REQUEST['temp']) ? $_REQUEST['temp'] : '');
	$user_id = (!empty($_REQUEST['user_id']) ? intval($_REQUEST['user_id']) : $adminru['ru_id']);
	$goods_id = (!empty($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0);
	$smarty->assign('temp', $temp);
	$result['sgs'] = $temp;
	$grade_rank = get_seller_grade_rank($user_id);
	$smarty->assign('grade_rank', $grade_rank);
	$smarty->assign('integral_scale', $_CFG['integral_scale']);
	$warehouse_list = get_warehouse_list();
	$smarty->assign('warehouse_list', $warehouse_list);
	$smarty->assign('user_id', $user_id);
	$smarty->assign('goods_id', $goods_id);
	$result['content'] = $GLOBALS['smarty']->fetch('library/dialog.lbi');
	exit($json->encode($result));
}
else if ($_REQUEST['act'] == 'dialog_img') {
	$json = new JSON();
	$result = array('content' => '', 'sgs' => '');
	$temp = (!empty($_REQUEST['temp']) ? $_REQUEST['temp'] : '');
	$smarty->assign('temp', $temp);
	$goods_id = (!empty($_REQUEST['goods_id']) ? $_REQUEST['goods_id'] : '');
	$smarty->assign('goods_id', $goods_id);
	$result['sgs'] = $temp;
	$result['content'] = $GLOBALS['smarty']->fetch('library/dialog.lbi');
	exit($json->encode($result));
}
else if ($_REQUEST['act'] == 'dialog_add') {
	$json = new JSON();
	$result = array('content' => '', 'sgs' => '');
	$temp = (!empty($_REQUEST['temp']) ? $_REQUEST['temp'] : '');
	$smarty->assign('temp', $temp);
	$result['sgs'] = $temp;
	$country_list = get_regions();
	$smarty->assign('countries', $country_list);
	$result['content'] = $GLOBALS['smarty']->fetch('library/dialog.lbi');
	exit($json->encode($result));
}
else if ($_REQUEST['act'] == 'extension_category') {
	$json = new JSON();
	$result = array('content' => '', 'sgs' => '');
	$temp = (!empty($_REQUEST['temp']) ? $_REQUEST['temp'] : '');
	$smarty->assign('temp', $temp);
	$result['sgs'] = $temp;
	$goods_id = (empty($_REQUEST['goods_id']) ? 0 : intval($_REQUEST['goods_id']));
	$goods = get_admin_goods_info($goods_id, array('user_id'));
	$goods['user_id'] = empty($goods['user_id']) ? $adminru['ru_id'] : $goods['user_id'];

	if ($goods['user_id']) {
		$seller_shop_cat = seller_shop_cat($goods['user_id']);
	}

	$level_limit = 3;
	$category_level = array();

	for ($i = 1; $i <= $level_limit; $i++) {
		$category_list = array();

		if ($i == 1) {
			if ($goods['user_id']) {
				$category_list = get_category_list(0, 0, $seller_shop_cat, $goods['user_id'], $i);
			}
			else {
				$category_list = get_category_list();
			}
		}

		$smarty->assign('cat_level', $i);
		$smarty->assign('category_list', $category_list);
		$category_level[$i] = $smarty->fetch('library/get_select_category.lbi');
	}

	$smarty->assign('category_level', $category_level);

	if (0 < $goods_id) {
		$other_cat_list1 = array();
		$sql = 'SELECT ga.cat_id FROM ' . $ecs->table('goods_cat') . ' as ga ' . ' WHERE ga.goods_id = \'' . $goods_id . '\'';
		$other_cat1 = $db->getCol($sql);
		$other_category = array();

		foreach ($other_cat1 as $key => $val) {
			$other_category[$key]['cat_id'] = $val;
			$other_category[$key]['cat_name'] = get_every_category($val);
		}

		$smarty->assign('other_category', $other_category);
	}

	$smarty->assign('goods_id', $goods_id);
	$result['content'] = $GLOBALS['smarty']->fetch('library/extension_category.lbi');
	exit($json->encode($result));
}
else if ($_REQUEST['act'] == 'add_attr_img') {
	$json = new JSON();
	$result = array('error' => 0, 'message' => '', 'content' => '');
	$goods_id = (!empty($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0);
	$goods_name = (!empty($_REQUEST['goods_name']) ? trim($_REQUEST['goods_name']) : '');
	$attr_id = (!empty($_REQUEST['attr_id']) ? intval($_REQUEST['attr_id']) : 0);
	$goods_attr_id = (!empty($_REQUEST['goods_attr_id']) ? intval($_REQUEST['goods_attr_id']) : 0);
	$goods_attr_name = (!empty($_REQUEST['goods_attr_name']) ? trim($_REQUEST['goods_attr_name']) : '');
	$goods_date = array('goods_name');
	$goods_info = get_table_date('goods', 'goods_id = \'' . $goods_id . '\'', $goods_date);

	if (!isset($goods_info['goods_name'])) {
		$goods_info['goods_name'] = $goods_name;
	}

	$goods_attr_date = array('attr_img_flie, attr_img_site, attr_checked, attr_gallery_flie');
	$goods_attr_info = get_table_date('goods_attr', 'goods_id = \'' . $goods_id . '\' and attr_id = \'' . $attr_id . '\' and goods_attr_id = \'' . $goods_attr_id . '\'', $goods_attr_date);
	$attr_date = array('attr_name');
	$attr_info = get_table_date('attribute', 'attr_id = \'' . $attr_id . '\'', $attr_date);
	$smarty->assign('goods_info', $goods_info);
	$smarty->assign('attr_info', $attr_info);
	$smarty->assign('goods_attr_info', $goods_attr_info);
	$smarty->assign('goods_attr_name', $goods_attr_name);
	$smarty->assign('goods_id', $goods_id);
	$smarty->assign('attr_id', $attr_id);
	$smarty->assign('goods_attr_id', $goods_attr_id);
	$smarty->assign('form_action', 'insert_attr_img');
	$result['content'] = $GLOBALS['smarty']->fetch('library/goods_attr_img_info.lbi');
	exit($json->encode($result));
}
else if ($_REQUEST['act'] == 'insert_attr_img') {
	$json = new JSON();
	$result = array('error' => 0, 'message' => '', 'content' => '', 'is_checked' => 0);
	$goods_id = (!empty($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0);
	$goods_attr_id = (!empty($_REQUEST['goods_attr_id']) ? intval($_REQUEST['goods_attr_id']) : 0);
	$attr_id = (!empty($_REQUEST['attr_id']) ? intval($_REQUEST['attr_id']) : 0);
	$goods_attr_name = (!empty($_REQUEST['goods_attr_name']) ? $_REQUEST['goods_attr_name'] : '');
	$img_url = (!empty($_REQUEST['img_url']) ? $_REQUEST['img_url'] : '');
	$allow_file_types = '|GIF|JPG|JEPG|PNG|';

	if (!empty($_FILES['attr_img_flie'])) {
		$other['attr_img_flie'] = get_upload_pic('attr_img_flie');
		get_oss_add_file(array($other['attr_img_flie']));
	}
	else {
		$other['attr_img_flie'] = '';
	}

	$goods_attr_date = array('attr_img_flie, attr_img_site');
	$goods_attr_info = get_table_date('goods_attr', 'goods_id = \'' . $goods_id . '\' and attr_id = \'' . $attr_id . '\' and goods_attr_id = \'' . $goods_attr_id . '\'', $goods_attr_date);

	if (empty($other['attr_img_flie'])) {
		$other['attr_img_flie'] = $goods_attr_info['attr_img_flie'];
	}
	else {
		@unlink(ROOT_PATH . $goods_attr_info['attr_img_flie']);
	}

	$other['attr_img_site'] = !empty($_REQUEST['attr_img_site']) ? $_REQUEST['attr_img_site'] : '';
	$other['attr_checked'] = !empty($_REQUEST['attr_checked']) ? intval($_REQUEST['attr_checked']) : 0;
	$other['attr_gallery_flie'] = $img_url;

	if ($other['attr_checked'] == 1) {
		$db->autoExecute($ecs->table('goods_attr'), array('attr_checked' => 0), 'UPDATE', 'attr_id = ' . $attr_id . ' and goods_id = ' . $goods_id);
		$result['is_checked'] = 1;
	}

	$db->autoExecute($ecs->table('goods_attr'), $other, 'UPDATE', 'goods_attr_id = ' . $goods_attr_id . ' and attr_id = ' . $attr_id . ' and goods_id = ' . $goods_id);
	$result['goods_attr_id'] = $goods_attr_id;
	exit($json->encode($result));
}
else if ($_REQUEST['act'] == 'drop_attr_img') {
	$json = new JSON();
	$result = array('error' => 0, 'message' => '', 'content' => '');
	$goods_id = (isset($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0);
	$goods_attr_id = (isset($_REQUEST['goods_attr_id']) ? intval($_REQUEST['goods_attr_id']) : 0);
	$attr_id = (isset($_REQUEST['attr_id']) ? intval($_REQUEST['attr_id']) : 0);
	$goods_attr_name = (isset($_REQUEST['goods_attr_name']) ? trim($_REQUEST['goods_attr_name']) : '');
	$sql = 'select attr_img_flie from ' . $ecs->table('goods_attr') . ' where goods_attr_id = \'' . $goods_attr_id . '\'';
	$attr_img_flie = $db->getOne($sql);
	get_oss_del_file(array($attr_img_flie));
	@unlink(ROOT_PATH . $attr_img_flie);
	$other['attr_img_flie'] = '';
	$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('goods_attr'), $other, 'UPDATE', 'goods_attr_id = \'' . $goods_attr_id . '\'');
	$result['goods_attr_id'] = $goods_attr_id;
	exit($json->encode($result));
}
else if ($_REQUEST['act'] == 'choose_attrImg') {
	$json = new JSON();
	$result = array('error' => 0, 'message' => '', 'content' => '');
	$admin_id = get_admin_id();
	$goods_id = (empty($_REQUEST['goods_id']) ? 0 : intval($_REQUEST['goods_id']));
	$goods_attr_id = (empty($_REQUEST['goods_attr_id']) ? 0 : intval($_REQUEST['goods_attr_id']));
	$on_img_id = (isset($_REQUEST['img_id']) ? intval($_REQUEST['img_id']) : 0);
	$sql = 'SELECT attr_gallery_flie FROM ' . $GLOBALS['ecs']->table('goods_attr') . ' WHERE goods_attr_id = \'' . $goods_attr_id . '\' AND goods_id = \'' . $goods_id . '\'';
	$attr_gallery_flie = $GLOBALS['db']->getOne($sql);
	$thumb_img_id = $_SESSION['thumb_img_id' . $admin_id];
	if (empty($goods_id) && $thumb_img_id) {
		$where = ' goods_id = 0 AND img_id ' . db_create_in($thumb_img_id);
	}
	else {
		$where = ' goods_id = \'' . $goods_id . '\'';
	}

	$sql = 'SELECT img_id, thumb_url, img_url FROM ' . $GLOBALS['ecs']->table('goods_gallery') . ' WHERE ' . $where;
	$img_list = $GLOBALS['db']->getAll($sql);
	$str = '<ul>';

	foreach ($img_list as $idx => $row) {
		if ($attr_gallery_flie == $row['img_url']) {
			$str .= '<li id="gallery_' . $row['img_id'] . '" onClick="gallery_on(this,' . $row['img_id'] . ',' . $goods_id . ',' . $goods_attr_id . ')" class="on"><img src="../' . $row['thumb_url'] . '" width="87" /><i><img src="images/yes.png"></i></li>';
		}
		else {
			$str .= '<li id="gallery_' . $row['img_id'] . '" onClick="gallery_on(this,' . $row['img_id'] . ',' . $goods_id . ',' . $goods_attr_id . ')"><img src="../' . $row['thumb_url'] . '" width="87" /><i><img src="images/gallery_yes.png" width="30" height="30"></i></li>';
		}
	}

	$str .= '</ul>';
	$result['content'] = $str;
	exit($json->encode($result));
}
else if ($_REQUEST['act'] == 'insert_gallery_attr') {
	$json = new JSON();
	$result = array('error' => 0, 'message' => '', 'content' => '');
	$goods_id = intval($_REQUEST['goods_id']);
	$goods_attr_id = intval($_REQUEST['goods_attr_id']);
	$gallery_id = intval($_REQUEST['gallery_id']);

	if (!empty($gallery_id)) {
		$sql = 'SELECT img_id, img_url FROM ' . $ecs->table('goods_gallery') . 'WHERE img_id=\'' . $gallery_id . '\'';
		$img = $db->getRow($sql);
		$result['img_id'] = $img['img_id'];
		$result['img_url'] = $img['img_url'];
		$sql = 'UPDATE ' . $ecs->table('goods_attr') . ' SET attr_gallery_flie = \'' . $img['img_url'] . '\' WHERE goods_attr_id = \'' . $goods_attr_id . '\' AND goods_id = \'' . $goods_id . '\'';
		$db->query($sql);
	}
	else {
		$result['error'] = 1;
	}

	$result['goods_attr_id'] = $goods_attr_id;
	exit($json->encode($result));
}
else if ($_REQUEST['act'] == 'add_goods_model_price') {
	$json = new JSON();
	$result = array('error' => 0, 'message' => '', 'content' => '');
	$goods_id = (!empty($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0);
	$warehouse_id = 0;
	$area_id = 0;
	$goods = get_goods_model($goods_id);
	$smarty->assign('goods', $goods);
	$warehouse_list = get_warehouse_list();

	if ($warehouse_list) {
		$warehouse_id = $warehouse_list[0]['region_id'];
		$sql = 'SELECT region_id FROM ' . $ecs->table('region_warehouse') . ' WHERE parent_id = \'' . $warehouse_list[0]['region_id'] . '\'';
		$area_id = $db->getOne($sql, true);
	}

	$smarty->assign('warehouse_list', $warehouse_list);
	$smarty->assign('warehouse_id', $warehouse_id);
	$smarty->assign('area_id', $area_id);
	$list = get_goods_warehouse_area_list($goods_id, $goods['model_attr'], $warehouse_id);
	$smarty->assign('warehouse_area_list', $list['list']);
	$smarty->assign('warehouse_area_filter', $list['filter']);
	$smarty->assign('warehouse_area_record_count', $list['record_count']);
	$smarty->assign('warehouse_area_page_count', $list['page_count']);
	$smarty->assign('query', $list['query']);
	$smarty->assign('full_page', 1);
	$result['content'] = $GLOBALS['smarty']->fetch('library/goods_price_list.lbi');
	exit($json->encode($result));
}
else if ($_REQUEST['act'] == 'goods_wa_query') {
	$json = new JSON();
	$result = array('error' => 0, 'message' => '', 'content' => '');
	$list = get_goods_warehouse_area_list();
	$smarty->assign('warehouse_area_list', $list['list']);
	$smarty->assign('warehouse_area_filter', $list['filter']);
	$smarty->assign('warehouse_area_record_count', $list['record_count']);
	$smarty->assign('warehouse_area_page_count', $list['page_count']);
	$smarty->assign('query', $list['query']);
	$goods = get_goods_model($list['filter']['goods_id']);
	$smarty->assign('goods', $goods);
	make_json_result($smarty->fetch('goods_price_list.lbi'), '', array('pb_filter' => $list['filter'], 'pb_page_count' => $list['page_count'], 'class' => 'goodslistDiv'));
}
else if ($_REQUEST['act'] == 'add_warehouse_price') {
	$json = new JSON();
	$result = array('error' => 0, 'message' => '', 'content' => '');
	$goods_id = (!empty($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0);
	$attr_id = (isset($_REQUEST['attr_id']) && !empty($_REQUEST['attr_id']) ? intval($_REQUEST['attr_id']) : 0);
	$goods_attr_id = (isset($_REQUEST['goods_attr_id']) && !empty($_REQUEST['goods_attr_id']) ? intval($_REQUEST['goods_attr_id']) : 0);
	$goods_attr_name = (!empty($_REQUEST['goods_attr_name']) ? trim($_REQUEST['goods_attr_name']) : '');
	$action_link = array('href' => 'goods.php?act=edit&goods_id=' . $goods_id . '&extension_code=', 'text' => $_LANG['goods_info']);

	if (empty($goods_attr_id)) {
		$goods_attr_id = get_goods_attr_nameId($goods_id, $attr_id, $goods_attr_name);
	}

	if (empty($attr_id)) {
		$attr_id = get_goods_attr_nameId($goods_id, $goods_attr_id, $goods_attr_name, 'attr_id', 1);
	}

	$goods_date = array('goods_name');
	$goods_info = get_table_date('goods', 'goods_id = \'' . $goods_id . '\'', $goods_date);
	$attr_date = array('attr_name');
	$attr_info = get_table_date('attribute', 'attr_id = \'' . $attr_id . '\'', $attr_date);
	$warehouse_area_list = get_fine_warehouse_all(0, $goods_id, $goods_attr_id);
	$smarty->assign('goods_info', $goods_info);
	$smarty->assign('attr_info', $attr_info);
	$smarty->assign('goods_attr_name', $goods_attr_name);
	$smarty->assign('warehouse_area_list', $warehouse_area_list);
	$smarty->assign('goods_id', $goods_id);
	$smarty->assign('attr_id', $attr_id);
	$smarty->assign('goods_attr_id', $goods_attr_id);
	$smarty->assign('form_action', 'insert_warehouse_price');
	$smarty->assign('action_link', $action_link);
	$result['content'] = $GLOBALS['smarty']->fetch('library/goods_warehouse_price_info.lbi');
	exit($json->encode($result));
}
else if ($_REQUEST['act'] == 'insert_warehouse_price') {
	$json = new JSON();
	$result = array('error' => 0, 'message' => '', 'content' => '');
	$goods_id = (!empty($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0);
	if (isset($_REQUEST['goods_attr_id']) && is_array($_REQUEST['goods_attr_id'])) {
		$goods_attr_id = (!empty($_REQUEST['goods_attr_id']) ? $_REQUEST['goods_attr_id'] : array());
	}
	else {
		$goods_attr_id = (!empty($_REQUEST['goods_attr_id']) ? intval($_REQUEST['goods_attr_id']) : 0);
	}

	if (isset($_REQUEST['attr_id']) && is_array($_REQUEST['attr_id'])) {
		$attr_id = (!empty($_REQUEST['attr_id']) ? $_REQUEST['attr_id'] : array());
	}
	else {
		$attr_id = (!empty($_REQUEST['attr_id']) ? intval($_REQUEST['attr_id']) : 0);
	}

	if (isset($_REQUEST['warehouse_name']) && is_array($_REQUEST['warehouse_name'])) {
		$warehouse_name = (!empty($_REQUEST['warehouse_name']) ? $_REQUEST['warehouse_name'] : array());
	}
	else {
		$warehouse_name = (!empty($_REQUEST['warehouse_name']) ? intval($_REQUEST['warehouse_name']) : 0);
	}

	$goods_attr_name = (!empty($_REQUEST['goods_attr_name']) ? $_REQUEST['goods_attr_name'] : '');
	get_warehouse_area_attr_price_insert($warehouse_name, $goods_id, $goods_attr_id, 'warehouse_attr');
	$result['goods_attr_id'] = $goods_attr_id;
	exit($json->encode($result));
}
else if ($_REQUEST['act'] == 'add_area_price') {
	$json = new JSON();
	$result = array('error' => 0, 'message' => '', 'content' => '');
	$goods_id = (!empty($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0);
	$attr_id = (isset($_REQUEST['attr_id']) && !empty($_REQUEST['attr_id']) ? intval($_REQUEST['attr_id']) : 0);
	$goods_attr_id = (isset($_REQUEST['goods_attr_id']) && !empty($_REQUEST['goods_attr_id']) ? intval($_REQUEST['goods_attr_id']) : 0);
	$goods_attr_name = (!empty($_REQUEST['goods_attr_name']) ? trim($_REQUEST['goods_attr_name']) : '');
	$action_link = array('href' => 'goods.php?act=edit&goods_id=' . $goods_id . '&extension_code=', 'text' => $_LANG['goods_info']);

	if (empty($goods_attr_id)) {
		$goods_attr_id = get_goods_attr_nameId($goods_id, $attr_id, $goods_attr_name);
	}

	if (empty($attr_id)) {
		$attr_id = get_goods_attr_nameId($goods_id, $goods_attr_id, $goods_attr_name, 'attr_id', 1);
	}

	$goods_date = array('goods_name');
	$goods_info = get_table_date('goods', 'goods_id = \'' . $goods_id . '\'', $goods_date);
	$attr_date = array('attr_name');
	$attr_info = get_table_date('attribute', 'attr_id = \'' . $attr_id . '\'', $attr_date);
	$warehouse_area_list = get_fine_warehouse_area_all(0, $goods_id, $goods_attr_id);
	$smarty->assign('goods_info', $goods_info);
	$smarty->assign('attr_info', $attr_info);
	$smarty->assign('goods_attr_name', $goods_attr_name);
	$smarty->assign('warehouse_area_list', $warehouse_area_list);
	$smarty->assign('goods_id', $goods_id);
	$smarty->assign('attr_id', $attr_id);
	$smarty->assign('goods_attr_id', $goods_attr_id);
	$smarty->assign('form_action', 'insert_area_price');
	$smarty->assign('action_link', $action_link);
	$result['content'] = $GLOBALS['smarty']->fetch('library/goods_area_price_info.lbi');
	exit($json->encode($result));
}
else if ($_REQUEST['act'] == 'del_goods_attr') {
	$json = new JSON();
	$result = array('error' => 0, 'message' => '', 'content' => '');
	$goods_id = (isset($_REQUEST['goods_id']) && !empty($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0);
	$attr_id = (isset($_REQUEST['attr_id']) && !empty($_REQUEST['attr_id']) ? intval($_REQUEST['attr_id']) : 0);
	$goods_attr_id = (isset($_REQUEST['goods_attr_id']) && !empty($_REQUEST['goods_attr_id']) ? intval($_REQUEST['goods_attr_id']) : 0);
	$attr_value = (isset($_REQUEST['attr_value']) && !empty($_REQUEST['attr_value']) ? addslashes($_REQUEST['attr_value']) : '');

	if ($goods_attr_id) {
		$where = 'goods_attr_id = \'' . $goods_attr_id . '\'';
	}
	else {
		$where = 'goods_id = \'' . $goods_id . '\' AND attr_value = \'' . $attr_value . '\' AND attr_id = \'' . $attr_id . '\' AND admin_id = \'' . $admin_id . '\'';
	}

	$sql = 'SELECT product_id,goods_attr FROM' . $ecs->table('products') . 'WHERE goods_id = \'' . $goods_id . '\'';
	$products = $db->getAll($sql);

	if (!empty($products)) {
		foreach ($products as $k => $v) {
			if ($v['goods_attr']) {
				$goods_attr = explode('|', $v['goods_attr']);

				if (in_array($goods_attr_id, $goods_attr)) {
					$sql = 'DELETE FROM' . $ecs->table('products') . 'WHERE product_id = \'' . $v['product_id'] . '\' AND goods_id = \'' . $goods_id . '\'';
					$db->query($sql);
				}
			}
		}
	}

	$sql = 'DELETE FROM ' . $GLOBALS['ecs']->table('goods_attr') . ' WHERE ' . $where;
	$GLOBALS['db']->query($sql);
	$goods_info = get_admin_goods_info($goods_id, array('model_attr'));

	if ($goods_info['model_attr'] == 1) {
		$table = 'products_warehouse';
	}
	else if ($goods_info['model_attr'] == 2) {
		$table = 'products_area';
	}
	else {
		$table = 'products';
	}

	$where = ' AND goods_id = \'' . $goods_id . '\'';
	$ecs->get_del_find_in_set($goods_attr_id, $where, $table, 'goods_attr', '|');
	exit($json->encode($result));
}
else if ($_REQUEST['act'] == 'insert_area_price') {
	$json = new JSON();
	$result = array('error' => 0, 'message' => '', 'content' => '');
	$goods_id = (!empty($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0);
	if (isset($_REQUEST['goods_attr_id']) && is_array($_REQUEST['goods_attr_id'])) {
		$goods_attr_id = (!empty($_REQUEST['goods_attr_id']) ? $_REQUEST['goods_attr_id'] : array());
	}
	else {
		$goods_attr_id = (!empty($_REQUEST['goods_attr_id']) ? intval($_REQUEST['goods_attr_id']) : 0);
	}

	if (isset($_REQUEST['attr_id']) && is_array($_REQUEST['attr_id'])) {
		$attr_id = (!empty($_REQUEST['attr_id']) ? $_REQUEST['attr_id'] : array());
	}
	else {
		$attr_id = (!empty($_REQUEST['attr_id']) ? intval($_REQUEST['attr_id']) : 0);
	}

	if (isset($_REQUEST['area_name']) && is_array($_REQUEST['area_name'])) {
		$area_name = (!empty($_REQUEST['area_name']) ? $_REQUEST['area_name'] : array());
	}
	else {
		$area_name = (!empty($_REQUEST['area_name']) ? intval($_REQUEST['area_name']) : 0);
	}

	$goods_attr_name = (!empty($_REQUEST['goods_attr_name']) ? $_REQUEST['goods_attr_name'] : '');
	get_warehouse_area_attr_price_insert($area_name, $goods_id, $goods_attr_id, 'warehouse_area_attr');
	$result['goods_attr_id'] = $goods_attr_id;
	exit($json->encode($result));
}
else if ($_REQUEST['act'] == 'add_sku') {
	$json = new JSON();
	$result = array('error' => 0, 'message' => '', 'content' => '');
	$goods_id = (!empty($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0);
	$user_id = (!empty($_REQUEST['user_id']) ? intval($_REQUEST['user_id']) : 0);
	$warehouse_id = 0;
	$area_id = 0;
	$goods = get_goods_model($goods_id);
	$warehouse_list = get_warehouse_list();

	if ($warehouse_list) {
		$warehouse_id = $warehouse_list[0]['region_id'];
		$sql = 'SELECT region_id FROM ' . $ecs->table('region_warehouse') . ' WHERE parent_id = \'' . $warehouse_list[0]['region_id'] . '\'';
		$area_id = $db->getOne($sql, true);
	}

	$smarty->assign('warehouse_id', $warehouse_id);
	$smarty->assign('area_id', $area_id);
	$smarty->assign('goods', $goods);
	$smarty->assign('warehouse_list', $warehouse_list);
	$smarty->assign('goods_id', $goods_id);
	$smarty->assign('user_id', $user_id);
	$smarty->assign('goods_attr_price', $GLOBALS['_CFG']['goods_attr_price']);
	$product_list = get_goods_product_list($goods_id, $goods['model_attr'], $warehouse_id, $area_id);
	$smarty->assign('product_list', $product_list['product_list']);
	$smarty->assign('sku_filter', $product_list['filter']);
	$smarty->assign('sku_record_count', $product_list['record_count']);
	$smarty->assign('sku_page_count', $product_list['page_count']);
	$smarty->assign('query', $product_list['query']);
	$smarty->assign('full_page', 1);
	$result['content'] = $GLOBALS['smarty']->fetch('library/goods_attr_list.lbi');
	exit($json->encode($result));
}
else if ($_REQUEST['act'] == 'sku_query') {
	$json = new JSON();
	$result = array('error' => 0, 'message' => '', 'content' => '');
	$smarty->assign('goods_attr_price', $GLOBALS['_CFG']['goods_attr_price']);
	$product_list = get_goods_product_list();
	$smarty->assign('product_list', $product_list['product_list']);
	$smarty->assign('sku_filter', $product_list['filter']);
	$smarty->assign('sku_record_count', $product_list['record_count']);
	$smarty->assign('sku_page_count', $product_list['page_count']);
	$smarty->assign('query', $product_list['query']);
	$goods = array('goods_id' => $product_list['filter']['goods_id'], 'model_attr' => $product_list['filter']['model'], 'warehouse_id' => $product_list['filter']['warehouse_id'], 'area_id' => $product_list['filter']['area_id']);
	$smarty->assign('goods', $goods);
	make_json_result($smarty->fetch('goods_attr_list.lbi'), '', array('pb_filter' => $product_list['filter'], 'pb_page_count' => $product_list['page_count'], 'class' => 'attrlistDiv'));
}
else if ($_REQUEST['act'] == 'add_attr_sku') {
	$json = new JSON();
	$result = array('error' => 0, 'message' => '', 'content' => '');
	$goods_id = (!empty($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0);
	$product_id = (!empty($_REQUEST['product_id']) ? intval($_REQUEST['product_id']) : 0);
	$goods_info = get_admin_goods_info($goods_id, array('goods_id', 'goods_name', 'goods_sn', 'model_attr'));
	$smarty->assign('product_id', $product_id);
	$editInput = '';
	$method = '';
	$filed = '';

	if ($goods_info['model_attr'] == 1) {
		$filed = ', warehouse_id';
		$method = 'insert_warehouse_price';
	}
	else if ($goods_info['model_attr'] == 2) {
		$filed = ', area_id';
		$method = 'insert_area_price';
	}
	else {
		$editInput = 'edit_attr_price';
	}

	$product = get_product_info($product_id, 'product_id, product_number, goods_id, product_sn, goods_attr' . $filed, $goods_info['model_attr'], 1);
	$smarty->assign('goods_info', $goods_info);
	$smarty->assign('product', $product);
	$smarty->assign('editInput', $editInput);
	$smarty->assign('method', $method);
	$warehouse_id = (isset($product['warehouse_id']) && !empty($product['warehouse_id']) ? $product['warehouse_id'] : 0);
	$area_id = (isset($product['area_id']) && !empty($product['area_id']) ? $product['area_id'] : 0);

	if (!empty($warehouse_id)) {
		$warehouse_area_id = $warehouse_id;
	}
	else if (!empty($area_id)) {
		$warehouse_area_id = $area_id;
	}

	$warehouse = get_area_info($warehouse_area_id, 1);
	$smarty->assign('warehouse_id', $warehouse_id);
	$smarty->assign('area_id', $area_id);
	$smarty->assign('warehouse', $warehouse);
	$result['method'] = $method;
	$result['content'] = $GLOBALS['smarty']->fetch('library/goods_list_product.lbi');
	exit($json->encode($result));
}
else if ($_REQUEST['act'] == 'shop_banner') {
	$json = new JSON();
	$result = array('content' => '', 'sgs' => '', 'mode' => '');
	$smarty->assign('temp', 'shop_banner');
	$json = new JSON();
	$result = array('content' => '', 'mode' => '');
	$is_vis = (isset($_REQUEST['is_vis']) ? intval($_REQUEST['is_vis']) : 0);
	$inid = (isset($_REQUEST['inid']) ? trim($_REQUEST['inid']) : '');
	$image_type = (isset($_REQUEST['image_type']) ? intval($_REQUEST['image_type']) : 0);

	if ($is_vis == 0) {
		$uploadImage = (isset($_REQUEST['uploadImage']) ? intval($_REQUEST['uploadImage']) : 0);
		$titleup = (isset($_REQUEST['titleup']) ? intval($_REQUEST['titleup']) : 0);
		$result['mode'] = isset($_REQUEST['mode']) ? $_REQUEST['mode'] : '';
		$_REQUEST['spec_attr'] = strip_tags(urldecode($_REQUEST['spec_attr']));
		$_REQUEST['spec_attr'] = json_str_iconv($_REQUEST['spec_attr']);
		$_REQUEST['spec_attr'] = !empty($_REQUEST['spec_attr']) ? stripslashes($_REQUEST['spec_attr']) : '';

		if (!empty($_REQUEST['spec_attr'])) {
			$spec_attr = $json->decode($_REQUEST['spec_attr']);
			$spec_attr = object_to_array($spec_attr);
		}

		$defualt = '';

		if ($result['mode'] == 'lunbo') {
			$defualt = 'shade';
		}
		else if ($result['mode'] == 'advImg1') {
			$defualt = 'yesSlide';
		}

		$spec_attr['slide_type'] = isset($spec_attr['slide_type']) ? $spec_attr['slide_type'] : $defualt;
		$spec_attr['target'] = isset($spec_attr['target']) ? addslashes($spec_attr['target']) : '_blank';
		$pic_src = (isset($spec_attr['pic_src']) && ($spec_attr['pic_src'] != ',') ? $spec_attr['pic_src'] : array());
		$link = (isset($spec_attr['link']) && ($spec_attr['link'] != ',') ? explode(',', $spec_attr['link']) : array());
		$sort = (isset($spec_attr['sort']) && ($spec_attr['sort'] != ',') ? $spec_attr['sort'] : array());
		$bg_color = (isset($spec_attr['bg_color']) ? $spec_attr['bg_color'] : array());
		$title = (!empty($spec_attr['title']) && ($spec_attr['title'] != ',') ? $spec_attr['title'] : array());
		$subtitle = (!empty($spec_attr['subtitle']) && ($spec_attr['subtitle'] != ',') ? $spec_attr['subtitle'] : array());
		$pic_number = (isset($_REQUEST['pic_number']) ? intval($_REQUEST['pic_number']) : 0);
		$result['diff'] = isset($_REQUEST['diff']) ? intval($_REQUEST['diff']) : 0;
		$count = COUNT($pic_src);
		$arr = array();

		for ($i = 0; $i < $count; $i++) {
			if ($pic_src[$i]) {
				$arr[$i + 1]['pic_src'] = get_image_path($i + 1, $pic_src[$i]);
				$arr[$i + 1]['link'] = $link[$i];
				$arr[$i + 1]['sort'] = $sort[$i];
				$arr[$i + 1]['bg_color'] = $bg_color[$i];
				$arr[$i + 1]['title'] = $title[$i];
				$arr[$i + 1]['subtitle'] = $subtitle[$i];
			}
		}

		$smarty->assign('banner_list', $arr);
	}

	$album_list = get_goods_gallery_album(1, $adminru['ru_id'], array('album_id', 'album_mame'), 'ru_id');
	$smarty->assign('album_list', $album_list);

	if (!empty($album_list)) {
		$pic_list = getAlbumList($album_list[0]['album_id']);
		$smarty->assign('pic_list', $pic_list['list']);
		$smarty->assign('filter', $pic_list['filter']);
		$smarty->assign('album_id', $album_list[0]['album_id']);
	}

	$smarty->assign('is_vis', $is_vis);

	if ($is_vis == 0) {
		$smarty->assign('pic_number', $pic_number);
		$smarty->assign('mode', $result['mode']);
		$smarty->assign('spec_attr', $spec_attr);
		$smarty->assign('uploadImage', $uploadImage);
		$smarty->assign('titleup', $titleup);
		$result['content'] = $GLOBALS['smarty']->fetch('library/shop_banner.lbi');
	}
	else {
		$smarty->assign('image_type', 0);
		$smarty->assign('log_type', 'image');
		$smarty->assign('image_type', $image_type);
		$smarty->assign('inid', $inid);
		$result['content'] = $GLOBALS['smarty']->fetch('library/album_dialog.lbi');
	}

	exit($json->encode($result));
}
else if ($_REQUEST['act'] == 'attr_input_type') {
	$json = new JSON();
	$result = array('content' => '', 'sgs' => '');
	$attr_id = (isset($_REQUEST['attr_id']) && !empty($_REQUEST['attr_id']) ? intval($_REQUEST['attr_id']) : 0);
	$goods_id = (isset($_REQUEST['goods_id']) && !empty($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0);
	$smarty->assign('attr_id', $attr_id);
	$smarty->assign('goods_id', $goods_id);
	$goods_attr = get_dialog_goods_attr_type($attr_id, $goods_id);
	$smarty->assign('goods_attr', $goods_attr);
	$result['content'] = $GLOBALS['smarty']->fetch('library/attr_input_type.lbi');
	exit($json->encode($result));
}
else if ($_REQUEST['act'] == 'insert_attr_input') {
	$json = new JSON();
	$result = array('content' => '', 'sgs' => '');
	$attr_id = (isset($_REQUEST['attr_id']) ? intval($_REQUEST['attr_id']) : 0);
	$goods_id = (isset($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0);
	$goods_attr_id = (isset($_REQUEST['goods_attr_id']) ? $_REQUEST['goods_attr_id'] : array());
	$attr_value_list = (isset($_REQUEST['attr_value_list']) ? $_REQUEST['attr_value_list'] : array());

	if ($goods_id) {
		$where = ' AND goods_id = \'' . $goods_id . '\'';
	}
	else {
		$where = ' AND goods_id = 0 AND admin_id = \'' . $admin_id . '\'';
	}

	foreach ($attr_value_list as $key => $attr_value) {
		if ($attr_value) {
			if ($goods_attr_id[$key]) {
				$sql = 'UPDATE ' . $ecs->table('goods_attr') . ' SET attr_value = \'' . $attr_value . '\' WHERE goods_attr_id = \'' . $goods_attr_id[$key] . '\' LIMIT 1';
			}
			else {
				$sql = 'SELECT MAX(attr_sort) AS attr_sort FROM ' . $GLOBALS['ecs']->table('goods_attr') . ' WHERE attr_id = \'' . $attr_id . '\'' . $where;
				$max_attr_sort = $GLOBALS['db']->getOne($sql);

				if ($max_attr_sort) {
					$key = $max_attr_sort + 1;
				}
				else {
					$key += 1;
				}

				$sql = 'INSERT INTO ' . $ecs->table('goods_attr') . ' (attr_id, goods_id, attr_value, attr_sort, admin_id)' . 'VALUES (\'' . $attr_id . '\', \'' . $goods_id . '\', \'' . $attr_value . '\', \'' . $key . '\', \'' . $admin_id . '\')';
			}

			$db->query($sql);
		}
	}

	$result['attr_id'] = $attr_id;
	$result['goods_id'] = $goods_id;
	$goods_attr = get_dialog_goods_attr_type($attr_id, $goods_id);
	$smarty->assign('goods_attr', $goods_attr);
	$smarty->assign('attr_id', $attr_id);
	$result['content'] = $GLOBALS['smarty']->fetch('library/attr_input_type_list.lbi');
	exit($json->encode($result));
}
else if ($_REQUEST['act'] == 'del_input_type') {
	$json = new JSON();
	$result = array('content' => '', 'sgs' => '');
	$goods_id = (isset($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0);
	$attr_id = (isset($_REQUEST['attr_id']) ? intval($_REQUEST['attr_id']) : 0);
	$goods_attr_id = (isset($_REQUEST['goods_attr_id']) ? intval($_REQUEST['goods_attr_id']) : 0);
	$sql = 'DELETE FROM ' . $ecs->table('goods_attr') . ' WHERE goods_attr_id = \'' . $goods_attr_id . '\'';
	$db->query($sql);
	$goods_info = get_admin_goods_info($goods_id, array('model_attr'));

	if ($goods_info['model_attr'] == 1) {
		$table = 'products_warehouse';
	}
	else if ($goods_info['model_attr'] == 2) {
		$table = 'products_area';
	}
	else {
		$table = 'products';
	}

	$where = ' AND goods_id = \'' . $goods_id . '\'';
	$ecs->get_del_find_in_set($goods_attr_id, $where, $table, 'goods_attr', '|');
	$goods_attr = get_dialog_goods_attr_type($attr_id, $goods_id);
	$smarty->assign('goods_attr', $goods_attr);
	$smarty->assign('attr_id', $attr_id);
	$result['attr_id'] = $attr_id;
	$result['attr_content'] = $GLOBALS['smarty']->fetch('library/attr_input_type_list.lbi');
	exit($json->encode($result));
}
else if ($_REQUEST['act'] == 'del_volume') {
	$json = new JSON();
	$result = array('content' => '', 'sgs' => '');
	$goods_id = (isset($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0);
	$volume_id = (isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0);
	$sql = 'DELETE FROM ' . $ecs->table('volume_price') . ' WHERE id = \'' . $volume_id . '\'';
	$db->query($sql);
	$volume_price_list = get_volume_price_list($goods_id);

	if (!$volume_price_list) {
		$sql = 'UPDATE ' . $ecs->table('goods') . ' SET is_volume = 0 WHERE goods_id = \'' . $goods_id . '\'';
		$db->query($sql);
	}

	exit($json->encode($result));
}
else if ($_REQUEST['act'] == 'del_cfull') {
	$json = new JSON();
	$result = array('content' => '', 'sgs' => '');
	$goods_id = (isset($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0);
	$volume_id = (isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0);
	$sql = 'DELETE FROM ' . $ecs->table('goods_consumption') . ' WHERE id = \'' . $volume_id . '\'';
	$db->query($sql);
	$consumption_list = get_goods_con_list($goods_id, 'goods_consumption');

	if (!$consumption_list) {
		$sql = 'UPDATE ' . $ecs->table('goods') . ' SET is_fullcut = 0 WHERE goods_id = \'' . $goods_id . '\'';
		$db->query($sql);
	}

	exit($json->encode($result));
}
else if ($_REQUEST['act'] == 'add_external_url') {
	$json = new JSON();
	$result = array('content' => '', 'sgs' => '', 'error' => 0);
	$goods_id = (isset($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0);
	$smarty->assign('goods_id', $goods_id);
	$result['content'] = $GLOBALS['smarty']->fetch('library/external_url_list.lbi');
	$result['goods_id'] = $goods_id;
	exit($json->encode($result));
}
else if ($_REQUEST['act'] == 'insert_external_url') {
	$json = new JSON();
	$result = array('content' => '', 'sgs' => '', 'error' => 0);
	$goods_id = (isset($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0);
	$external_url_list = (isset($_REQUEST['external_url_list']) ? $_REQUEST['external_url_list'] : array());
	$proc_thumb = (isset($GLOBALS['shop_id']) && (0 < $GLOBALS['shop_id']) ? false : true);
	$http = $GLOBALS['ecs']->http();

	if ($external_url_list) {
		$sql = 'SELECT MAX(img_desc) FROM ' . $ecs->table('goods_gallery') . ' WHERE goods_id = \'' . $goods_id . '\'';
		$desc = $db->getOne($sql, true);
		$admin_id = get_admin_id();
		$admin_temp_dir = 'seller';
		$admin_temp_dir = ROOT_PATH . 'temp' . '/' . $admin_temp_dir . '/' . 'admin_' . $admin_id;

		if (!file_exists($admin_temp_dir)) {
			make_dir($admin_temp_dir);
		}

		foreach ($external_url_list as $key => $image_urls) {
			if ($image_urls) {
				if (!empty($image_urls) && ($image_urls != $GLOBALS['_LANG']['img_file']) && ($image_urls != 'http://') && ((strpos($image_urls, 'http://') !== false) || (strpos($image_urls, 'https://') !== false))) {
					if (get_http_basename($image_urls, $admin_temp_dir)) {
						$image_url = trim($image_urls);
						$down_img = $admin_temp_dir . '/' . basename($image_url);
						$img_wh = $GLOBALS['image']->get_width_to_height($down_img, $GLOBALS['_CFG']['image_width'], $GLOBALS['_CFG']['image_height']);
						$GLOBALS['_CFG']['image_width'] = isset($img_wh['image_width']) ? $img_wh['image_width'] : $GLOBALS['_CFG']['image_width'];
						$GLOBALS['_CFG']['image_height'] = isset($img_wh['image_height']) ? $img_wh['image_height'] : $GLOBALS['_CFG']['image_height'];
						if (($GLOBALS['_CFG']['image_width'] != 0) || ($GLOBALS['_CFG']['image_height'] != 0)) {
							$goods_img = $image->make_thumb(array('img' => $down_img, 'type' => 1), $GLOBALS['_CFG']['image_width'], $GLOBALS['_CFG']['image_height']);
						}
						else {
							$goods_img = $image->make_thumb(array('img' => $down_img, 'type' => 1));
						}

						if ($proc_thumb) {
							$thumb_url = $GLOBALS['image']->make_thumb(array('img' => $down_img, 'type' => 1), $GLOBALS['_CFG']['thumb_width'], $GLOBALS['_CFG']['thumb_height']);
							$thumb_url = reformat_image_name('gallery_thumb', $goods_id, $thumb_url, 'thumb');
						}
						else {
							$thumb_url = $GLOBALS['image']->make_thumb(array('img' => $down_img, 'type' => 1));
							$thumb_url = reformat_image_name('gallery_thumb', $goods_id, $thumb_url, 'thumb');
						}

						$img_original = reformat_image_name('gallery', $goods_id, $down_img, 'source');
						$img_url = reformat_image_name('gallery', $goods_id, $goods_img, 'goods');
						$desc += 1;
						$sql = 'INSERT INTO ' . $GLOBALS['ecs']->table('goods_gallery') . ' (goods_id, img_url, img_desc, thumb_url, img_original) ' . 'VALUES (\'' . $goods_id . '\', \'' . $img_url . '\', \'' . $desc . '\', \'' . $thumb_url . '\', \'' . $img_original . '\')';
						$GLOBALS['db']->query($sql);
						$thumb_img_id[] = $GLOBALS['db']->insert_id();
						@unlink($down_img);
					}
				}

				get_oss_add_file(array($img_url, $thumb_url, $img_original));
			}
		}

		if (!empty($_SESSION['thumb_img_id' . $_SESSION['seller_id']])) {
			$_SESSION['thumb_img_id' . $_SESSION['seller_id']] = array_merge($thumb_img_id, $_SESSION['thumb_img_id' . $_SESSION['seller_id']]);
		}
		else {
			$_SESSION['thumb_img_id' . $_SESSION['seller_id']] = $thumb_img_id;
		}
	}

	$sql = 'SELECT * FROM ' . $ecs->table('goods_gallery') . ' WHERE goods_id = \'' . $goods_id . '\' ORDER BY img_desc';
	$img_list = $db->getAll($sql);
	if (isset($GLOBALS['shop_id']) && (0 < $GLOBALS['shop_id'])) {
		foreach ($img_list as $key => $gallery_img) {
			$img_list[$key] = $gallery_img;
			$gallery_img['img_original'] = get_image_path($gallery_img['goods_id'], $gallery_img['img_original'], true);
			$img_list[$key]['img_url'] = $gallery_img['img_original'];
			$gallery_img['thumb_url'] = get_image_path($gallery_img['goods_id'], $gallery_img['thumb_url'], true);
			$img_list[$key]['thumb_url'] = $gallery_img['thumb_url'];
		}
	}
	else {
		foreach ($img_list as $key => $gallery_img) {
			$img_list[$key] = $gallery_img;

			if (!empty($gallery_img['external_url'])) {
				$img_list[$key]['img_url'] = $gallery_img['external_url'];
				$img_list[$key]['thumb_url'] = $gallery_img['external_url'];
			}
			else {
				$gallery_img['thumb_url'] = get_image_path($gallery_img['goods_id'], $gallery_img['thumb_url'], true);
				$img_list[$key]['thumb_url'] = $gallery_img['thumb_url'];
			}
		}
	}

	$smarty->assign('img_list', $img_list);
	$smarty->assign('goods_id', $goods_id);
	$result['content'] = $GLOBALS['smarty']->fetch('library/gallery_img.lbi');
	$result['goods_id'] = $goods_id;
	exit($json->encode($result));
}
else if ($_REQUEST['act'] == 'insert_gallery_url') {
	$json = new JSON();
	$result = array('content' => '', 'sgs' => '', 'error' => 0);
	$http = $GLOBALS['ecs']->http();
	$goods_id = (isset($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0);
	$img_id = (isset($_REQUEST['img_id']) ? intval($_REQUEST['img_id']) : 0);
	$external_url = (isset($_REQUEST['external_url']) ? addslashes(trim($_REQUEST['external_url'])) : '');
	$sql = 'SELECT img_id FROM ' . $ecs->table('goods_gallery') . ' WHERE external_url = \'' . $external_url . '\' AND goods_id = \'' . $goods_id . '\' AND img_id <> ' . $img_id;
	if ($db->getOne($sql, true) && !empty($external_url)) {
		$result['error'] = 1;
	}
	else {
		$sql = 'UPDATE ' . $ecs->table('goods_gallery') . ' SET external_url = \'' . $external_url . '\'' . ' WHERE img_id = \'' . $img_id . '\'';
		$db->query($sql);
	}

	$result['img_id'] = $img_id;

	if (!empty($external_url)) {
		$result['external_url'] = $external_url;
	}
	else {
		$sql = 'SELECT thumb_url FROM ' . $ecs->table('goods_gallery') . ' WHERE img_id = \'' . $img_id . '\'';
		$thumb_url = $db->getOne($sql, true);
		$thumb_url = get_image_path($img_id, $thumb_url, true);
		$result['external_url'] = $thumb_url;
	}

	exit($json->encode($result));
}
else if ($_REQUEST['act'] == 'pic_album') {
	$json = new JSON();
	$result = array('content' => '', 'sgs' => '');
	$album_id = (isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0);
	$smarty->assign('album_id', $album_id);
	$smarty->assign('temp', $_REQUEST['act']);
	$album_list = get_goods_gallery_album(1, $adminru['ru_id'], array('album_id', 'album_mame'), 'ru_id');
	$smarty->assign('album_list', $album_list);
	$album_mame = get_goods_gallery_album(0, $album_id, array('album_mame'));
	$smarty->assign('album_mame', $album_mame);
	$result['content'] = $GLOBALS['smarty']->fetch('library/dialog.lbi');
	exit($json->encode($result));
}
else if ($_REQUEST['act'] == 'goods_info') {
	$json = new JSON();
	$result = array('content' => '', 'mode' => '');
	$search_type = (isset($_REQUEST['search_type']) ? trim($_REQUEST['search_type']) : '');
	$cat_id = (!empty($_REQUEST['cat_id']) ? intval($_REQUEST['cat_id']) : 0);
	$goods_type = (isset($_REQUEST['goods_type']) ? intval($_REQUEST['goods_type']) : 0);
	$good_number = (isset($_REQUEST['good_number']) ? intval($_REQUEST['good_number']) : 0);
	$_REQUEST['spec_attr'] = strip_tags(urldecode($_REQUEST['spec_attr']));
	$_REQUEST['spec_attr'] = json_str_iconv($_REQUEST['spec_attr']);
	$_REQUEST['spec_attr'] = !empty($_REQUEST['spec_attr']) ? stripslashes($_REQUEST['spec_attr']) : '';

	if (!empty($_REQUEST['spec_attr'])) {
		$spec_attr = $json->decode(stripslashes($_REQUEST['spec_attr']));
		$spec_attr = object_to_array($spec_attr);
	}

	$spec_attr['is_title'] = isset($spec_attr['is_title']) ? $spec_attr['is_title'] : 0;
	$spec_attr['itemsLayout'] = isset($spec_attr['itemsLayout']) ? $spec_attr['itemsLayout'] : 'row4';
	$result['mode'] = isset($_REQUEST['mode']) ? addslashes($_REQUEST['mode']) : '';
	$result['diff'] = isset($_REQUEST['diff']) ? intval($_REQUEST['diff']) : 0;
	$lift = (isset($_REQUEST['lift']) ? trim($_REQUEST['lift']) : '');
	$spec_attr['goods_ids'] = resetBarnd($spec_attr['goods_ids']);

	if ($spec_attr['goods_ids']) {
		$goods_info = explode(',', $spec_attr['goods_ids']);

		foreach ($goods_info as $k => $v) {
			if (!$v) {
				unset($goods_info[$k]);
			}
		}

		if (!empty($goods_info)) {
			$where = ' WHERE g.is_on_sale=1 AND g.is_delete=0 AND g.goods_id' . db_create_in($goods_info) . ' AND g.user_id = \'' . $adminru['ru_id'] . '\'';

			if ($GLOBALS['_CFG']['review_goods'] == 1) {
				$where .= ' AND g.review_status > 2 ';
			}

			$sql = 'SELECT g.goods_name,g.goods_id,g.goods_thumb,g.original_img,g.shop_price FROM ' . $ecs->table('goods') . ' AS g ' . $where;
			$goods_list = $db->getAll($sql);

			foreach ($goods_list as $k => $v) {
				$goods_list[$k]['shop_price'] = price_format($v['shop_price']);
				$goods_list[$k]['goods_thumb'] = get_image_path($v['goods_id'], $v['goods_thumb']);
			}

			$smarty->assign('goods_list', $goods_list);
			$smarty->assign('goods_count', count($goods_list));
		}
	}

	set_default_filter($cat_id, 0, $adminru['ru_id']);
	$smarty->assign('parent_category', get_every_category($cat_id));
	$select_category_html = '';
	$seller_shop_cat = seller_shop_cat($adminru['ru_id']);
	$select_category_html = insert_select_category(0, 0, 0, 'cat_id', 0, 'category', $seller_shop_cat);
	$smarty->assign('select_category_html', $select_category_html);
	$smarty->assign('brand_list', get_brand_list());
	$smarty->assign('arr', $spec_attr);
	$smarty->assign('temp', 'goods_info');
	$smarty->assign('goods_type', $goods_type);
	$smarty->assign('mode', $result['mode']);
	$smarty->assign('cat_id', $cat_id);
	$smarty->assign('lift', $lift);
	$smarty->assign('good_number', $good_number);
	$smarty->assign('search_type', $search_type);
	$result['content'] = $GLOBALS['smarty']->fetch('library/shop_banner.lbi');
	exit($json->encode($result));
}
else if ($_REQUEST['act'] == 'custom') {
	$json = new JSON();
	$result = array('content' => '', 'mode' => '');
	$custom_content = (isset($_REQUEST['custom_content']) ? unescape($_REQUEST['custom_content']) : '');
	$custom_content = (!empty($custom_content) ? stripslashes($custom_content) : '');
	$result['mode'] = isset($_REQUEST['mode']) ? addslashes($_REQUEST['mode']) : '';
	$result['diff'] = isset($_REQUEST['diff']) ? intval($_REQUEST['diff']) : 0;

	if ($GLOBALS['_CFG']['open_oss'] == 1) {
		$bucket_info = get_bucket_info();
		$endpoint = $bucket_info['endpoint'];
	}
	else {
		$endpoint = (!empty($GLOBALS['_CFG']['site_domain']) ? $GLOBALS['_CFG']['site_domain'] : '');
	}

	if ($custom_content && $endpoint) {
		$desc_preg = get_goods_desc_images_preg($endpoint, $custom_content);
		$custom_content = $desc_preg['goods_desc'];
	}

	$FCKeditor = create_ueditor_editor('custom_content', $custom_content, 486, 1);
	$smarty->assign('FCKeditor', $FCKeditor);
	$smarty->assign('temp', $_REQUEST['act']);
	$result['content'] = $GLOBALS['smarty']->fetch('library/shop_banner.lbi');
	exit($json->encode($result));
}
else if ($_REQUEST['act'] == 'header') {
	$json = new JSON();
	$result = array('content' => '', 'mode' => '');
	$arr = array();
	$smarty->assign('temp', $_REQUEST['act']);
	$_REQUEST['spec_attr'] = !empty($_REQUEST['spec_attr']) ? stripslashes($_REQUEST['spec_attr']) : '';
	$_REQUEST['spec_attr'] = urldecode($_REQUEST['spec_attr']);
	$_REQUEST['spec_attr'] = json_str_iconv($_REQUEST['spec_attr']);

	if (!empty($_REQUEST['spec_attr'])) {
		$spec_attr = json_decode($_REQUEST['spec_attr'], true);
	}

	$spec_attr['header_type'] = isset($spec_attr['header_type']) ? $spec_attr['header_type'] : 'defalt_type';
	$custom_content = (isset($spec_attr['custom_content']) ? unescape($spec_attr['custom_content']) : '');
	$custom_content = (!empty($custom_content) ? stripslashes($custom_content) : '');
	$result['mode'] = isset($_REQUEST['mode']) ? addslashes($_REQUEST['mode']) : '';
	$spec_attr['suffix'] = isset($_REQUEST['suffix']) ? addslashes($_REQUEST['suffix']) : '';
	$FCKeditor = create_ueditor_editor('custom_content', $custom_content, 486, 1);
	$smarty->assign('FCKeditor', $FCKeditor);
	$smarty->assign('content', $spec_attr);
	$result['content'] = $GLOBALS['smarty']->fetch('library/shop_banner.lbi');
	exit($json->encode($result));
}
else if ($_REQUEST['act'] == 'navigator') {
	$json = new JSON();
	$result = array('content' => '', 'mode' => '');
	$topic_type = (isset($_REQUEST['topic_type']) ? trim($_REQUEST['topic_type']) : '');
	$spec_attr['target'] = '';
	$_REQUEST['spec_attr'] = !empty($_REQUEST['spec_attr']) ? stripslashes($_REQUEST['spec_attr']) : '';
	$_REQUEST['spec_attr'] = urldecode($_REQUEST['spec_attr']);
	$_REQUEST['spec_attr'] = json_str_iconv($_REQUEST['spec_attr']);

	if (!empty($_REQUEST['spec_attr'])) {
		$spec_attr = json_decode($_REQUEST['spec_attr'], true);
	}

	$result['diff'] = isset($_REQUEST['diff']) ? intval($_REQUEST['diff']) : 0;

	if ($topic_type == 'topic_type') {
		unset($spec_attr['target']);
		$navigator = $spec_attr;
	}
	else {
		$where = ' where ru_id = ' . $adminru['ru_id'];
		$sql = 'SELECT id, name,ifshow,  vieworder,  url ' . ' FROM ' . $GLOBALS['ecs']->table('merchants_nav') . $where . ' ORDER by vieworder';
		$navigator = $db->getAll($sql);
	}

	$spec_attr['target'] = isset($spec_attr['target']) ? $spec_attr['target'] : '_blank';
	$smarty->assign('navigator', $navigator);
	$smarty->assign('topic_type', $topic_type);
	$smarty->assign('temp', $_REQUEST['act']);
	$sysmain = get_sysnav();
	$smarty->assign('sysmain', $sysmain);
	$smarty->assign('attr', $spec_attr);
	$result['mode'] = isset($_REQUEST['mode']) ? addslashes($_REQUEST['mode']) : '';
	$result['content'] = $GLOBALS['smarty']->fetch('library/shop_banner.lbi');
	exit($json->encode($result));
}
else if ($_REQUEST['act'] == 'template_information') {
	$json = new JSON();
	$result = array('content' => '', 'mode' => '');
	$code = (isset($_REQUEST['code']) ? addslashes($_REQUEST['code']) : '');
	$adminru = get_admin_ru_id();

	if ($code) {
		$smarty->assign('template', get_seller_template_info($code, $adminru['ru_id']));
	}

	$smarty->assign('code', $code);
	$smarty->assign('ru_id', $adminru['ru_id']);
	$smarty->assign('temp', $_REQUEST['act']);
	$result['content'] = $GLOBALS['smarty']->fetch('library/shop_banner.lbi');
	exit($json->encode($result));
}
else if ($_REQUEST['act'] == 'album_move') {
	$json = new JSON();
	$result = array('content' => '', 'pic_id' => '', 'old_album_id' => '');
	$pic_id = (isset($_REQUEST['pic_id']) ? intval($_REQUEST['pic_id']) : 0);
	$temp = (!empty($_REQUEST['act']) ? $_REQUEST['act'] : '');
	$smarty->assign('temp', $temp);
	$album_list = get_goods_gallery_album(1, $adminru['ru_id'], array('album_id', 'album_mame'), 'ru_id');
	$smarty->assign('album_list', $album_list);
	$album_id = gallery_pic_album(0, $pic_id, array('album_id'));
	$smarty->assign('album_id', $album_id);
	$result['pic_id'] = $pic_id;
	$result['old_album_id'] = $album_id;
	$result['content'] = $GLOBALS['smarty']->fetch('library/dialog.lbi');
	exit($json->encode($result));
}
else if ($_REQUEST['act'] == 'add_albun_pic') {
	$json = new JSON();
	$result = array('content' => '', 'pic_id' => '', 'old_album_id' => '');
	$temp = (!empty($_REQUEST['act']) ? $_REQUEST['act'] : '');
	$smarty->assign('temp', $temp);
	$result['content'] = $GLOBALS['smarty']->fetch('library/dialog.lbi');
	exit($json->encode($result));
}
else if ($_REQUEST['act'] == 'homeFloor') {
	$json = new JSON();
	$result = array('content' => '', 'mode' => '');
	$result['act'] = $_REQUEST['act'];
	$lift = (isset($_REQUEST['lift']) ? trim($_REQUEST['lift']) : '');
	$result['hierarchy'] = isset($_REQUEST['hierarchy']) ? trim($_REQUEST['hierarchy']) : '';
	$result['diff'] = isset($_REQUEST['diff']) ? intval($_REQUEST['diff']) : 0;
	$result['mode'] = isset($_REQUEST['mode']) ? trim($_REQUEST['mode']) : '';
	$_REQUEST['spec_attr'] = !empty($_REQUEST['spec_attr']) ? stripslashes($_REQUEST['spec_attr']) : '';
	$_REQUEST['spec_attr'] = urldecode($_REQUEST['spec_attr']);
	$_REQUEST['spec_attr'] = json_str_iconv($_REQUEST['spec_attr']);

	if (!empty($_REQUEST['spec_attr'])) {
		$spec_attr = json_decode($_REQUEST['spec_attr'], true);
	}

	$brand_ids = (!empty($spec_attr['brand_ids']) ? trim($spec_attr['brand_ids']) : '');
	$cat_id = (!empty($spec_attr['cat_id']) ? intval($spec_attr['cat_id']) : 0);
	$parent = '';
	$spec_attr['catChild'] = '';
	$spec_attr['Selected'] = '';

	if (0 < $cat_id) {
		$parent = get_cat_info($spec_attr['cat_id'], array('parent_id'));

		if (0 < $parent['parent_id']) {
			$spec_attr['catChild'] = cat_list($parent['parent_id']);
			$spec_attr['Selected'] = $parent['parent_id'];
		}
		else {
			$spec_attr['catChild'] = cat_list($spec_attr['cat_id']);
			$spec_attr['Selected'] = $cat_id;
		}

		$spec_attr['juniorCat'] = cat_list($cat_id);
	}

	$arr = array();

	if ($spec_attr['cateValue']) {
		foreach ($spec_attr['cateValue'] as $k => $v) {
			$arr[$k]['cat_id'] = $v;
			$arr[$k]['cat_goods'] = $spec_attr['cat_goods'][$k];
		}
	}

	$spec_attr['catInfo'] = $arr;

	if ($spec_attr['rightAdvTitle']) {
		foreach ($spec_attr['rightAdvTitle'] as $k => $v) {
			if ($v) {
				$spec_attr['rightAdvTitle'][$k] = $v;
			}
		}
	}

	if ($spec_attr['rightAdvSubtitle']) {
		foreach ($spec_attr['rightAdvSubtitle'] as $k => $v) {
			if ($v) {
				$spec_attr['rightAdvSubtitle'][$k] = $v;
			}
		}
	}

	$floor_style = array();
	$floor_style = get_floor_style($result['mode']);
	$seller_shop_cat = seller_shop_cat($adminru['ru_id']);
	$cat_list = cat_list(0, 0, 0, 'category', $seller_shop_cat, 1);
	$imgNumberArr = getAdvNum($result['mode']);
	$imgNumberArr = json_encode($imgNumberArr);
	$smarty->assign('cat_list', $cat_list);
	$smarty->assign('temp', $_REQUEST['act']);
	$smarty->assign('mode', $result['mode']);
	$smarty->assign('lift', $lift);
	$smarty->assign('spec_attr', $spec_attr);
	$smarty->assign('hierarchy', $result['hierarchy']);
	$smarty->assign('floor_style', $floor_style);
	$smarty->assign('imgNumberArr', $imgNumberArr);
	$result['content'] = $GLOBALS['smarty']->fetch('library/shop_banner.lbi');
	exit($json->encode($result));
}

if ($_REQUEST['act'] == 'getmap_html') {
	$json = new JSON();
	$result = array('content' => '', 'sgs' => '');
	$temp = (!empty($_REQUEST['act']) ? $_REQUEST['act'] : '');
	$smarty->assign('temp', $temp);
	$result['sgs'] = $temp;
	$result['content'] = $GLOBALS['smarty']->fetch('library/dialog.lbi');
	exit($json->encode($result));
}

?>
