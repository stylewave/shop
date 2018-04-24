<?php
//zend by 旺旺dongshaolin2008所有  禁止倒卖 一经发现停止任何服务
function create_html($out = '', $cache_id = 0, $cachename = '', $suffix = '', $topic_type = 0)
{
	$smarty = new cls_template();
	$smarty->cache_lifetime = $_CFG['cache_time'];

	if ($topic_type == 1) {
		$smarty->cache_dir = ROOT_PATH . 'data/topic';
		$seller_tem = 'topic_' . $cache_id;
	}
	else if ($topic_type == 2) {
		$smarty->cache_dir = ROOT_PATH . 'data';
		$seller_tem = '';
	}
	else if ($topic_type == 3) {
		$smarty->cache_dir = ROOT_PATH . 'data/home_Templates';
		$seller_tem = $GLOBALS['_CFG']['template'];
	}
	else {
		$smarty->cache_dir = ROOT_PATH . 'data/seller_templates';

		if (0 < $cache_id) {
			$seller_tem = 'seller_tem_' . $cache_id;
		}
		else {
			$seller_tem = 'seller_tem';
		}
	}

	if ($topic_type != 2) {
		$suffix = $suffix . '/temp';
	}

	$back = '';

	if ($out) {
		$out = str_replace("\r", '', $out);

		while (strpos($out, "\n\n") !== false) {
			$out = str_replace("\n\n", "\n", $out);
		}

		$hash_dir = $smarty->cache_dir . '/' . $seller_tem . '/' . $suffix;

		if (!is_dir($hash_dir)) {
			mkdir($hash_dir, 511, true);
		}

		if ($cachename) {
			$files = explode('.', $cachename);
			$files_count = count($files) - 1;
			$suffix_name = $files[$files_count];

			if (2 < count($files)) {
				$path = count($files) - 1;
				$name = '';

				if ($files[$path]) {
					foreach ($files[$path] as $row) {
						$name .= $row . '.';
					}

					$name = substr($name, 0, -1);
				}

				$file_path = explode('/', $name);

				if (2 < $file_path) {
					$path = count($file_path) - 1;
					$cachename = $file_path[$path];
				}
				else {
					$cachename = $file_path[0];
				}
			}
			else {
				$cachename = $files[0];
			}

			$file_put = write_static_file_cache($cachename, $out, $suffix_name, $hash_dir . '/');
		}
		else {
			$file_put = false;
		}

		if ($file_put === false) {
			trigger_error('can\'t write:' . $hash_dir . '/' . $cachename);
			$back = '';
		}
		else {
			$back = $cachename;
		}

		$smarty->template = array();
	}
	else {
		$back = '';
	}

	return $back;
}

function get_html_file($name)
{
	$smarty = new cls_template();

	if (file_exists($name)) {
		$smarty->_current_file = $name;
		$name = read_static_flie_cache($name);
		$source = $smarty->fetch_str($name);
	}
	else {
		$source = '';
	}

	return $source;
}

function get_seller_templates($ru_id = 0, $type = 0, $tem = '', $pre_type = 0)
{
	if ($type == 0) {
		$seller_templates = 'pc_page';
	}
	else {
		$seller_templates = 'pc_html';
	}

	$arr = '';

	if ($tem == '') {
		$sql = 'SELECT seller_templates FROM' . $GLOBALS['ecs']->table('seller_shopinfo') . ' WHERE ru_id=' . $ru_id;
		$arr['tem'] = $GLOBALS['db']->getOne($sql);
		$dir = ROOT_PATH . 'data/seller_templates/seller_tem_' . $ru_id . '/store_tpl_1';
		if (($arr['tem'] == '') || !file_exists($dir . '/pc_page.php')) {
			$file_html = ROOT_PATH . 'data/seller_templates/seller_tem/store_tpl_1';

			if (!is_dir($dir)) {
				mkdir($dir, 511, true);
			}

			recurse_copy($file_html, $dir);
			$sql = 'UPDATE ' . $GLOBALS['ecs']->table('seller_shopinfo') . ' SET seller_templates = \'store_tpl_1\' WHERE ru_id = \'' . $ru_id . '\'';
			$GLOBALS['db']->query($sql);
			$arr['tem'] = 'store_tpl_1';
		}
	}
	else {
		$arr['tem'] = $tem;
	}

	$arr['is_temp'] = 0;
	$filename = ROOT_PATH . 'data/seller_templates' . '/seller_tem_' . $ru_id . '/' . $arr['tem'] . '/' . $seller_templates . '.php';

	if ($pre_type == 1) {
		$pre_file = ROOT_PATH . 'data/seller_templates' . '/seller_tem_' . $ru_id . '/' . $arr['tem'] . '/temp';

		if (is_dir($pre_file)) {
			$filename = $pre_file . '/' . $seller_templates . '.php';
			$arr['is_temp'] = 1;
		}
	}

	$arr['out'] = get_html_file($filename);
	return $arr;
}

function get_seller_template_info($template_name = '', $ru_id = 0, $theme = '')
{
	if (empty($template_style) || ($template_style == '')) {
		$template_style = '';
	}

	if (0 < $ru_id) {
		$seller_tem = 'seller_tem_' . $ru_id;
	}
	else {
		$seller_tem = 'seller_tem';
	}

	$info = array();
	$ext = array('png', 'gif', 'jpg', 'jpeg');
	$info['code'] = $template_name;
	$info['screenshot'] = '';

	if ($theme == '') {
		foreach ($ext as $val) {
			if (file_exists('../data/seller_templates/' . $seller_tem . '/' . $template_name . '/screenshot.' . $val)) {
				$info['screenshot'] = '../data/seller_templates/' . $seller_tem . '/' . $template_name . '/screenshot.' . $val;
				break;
			}
		}

		foreach ($ext as $val) {
			if (file_exists('../data/seller_templates/' . $seller_tem . '/' . $template_name . '/template.' . $val)) {
				$info['template'] = '../data/seller_templates/' . $seller_tem . '/' . $template_name . '/template.' . $val;
				break;
			}
		}

		$info_path = '../data/seller_templates/' . $seller_tem . '/' . $template_name . '/tpl_info.txt';
	}
	else {
		foreach ($ext as $val) {
			if (file_exists('../data/home_Templates/' . $theme . '/' . $template_name . '/screenshot.' . $val)) {
				$info['screenshot'] = '../data/home_Templates/' . $theme . '/' . $template_name . '/screenshot.' . $val;
				break;
			}
		}

		foreach ($ext as $val) {
			if (file_exists('../data/home_Templates/' . $theme . '/' . $template_name . '/template.' . $val)) {
				$info['template'] = '../data/home_Templates/' . $theme . '/' . $template_name . '/template.' . $val;
				break;
			}
		}

		$info_path = '../data/home_Templates/' . $theme . '/' . $template_name . '/tpl_info.txt';
	}

	if (file_exists($info_path) && !empty($template_name)) {
		$custom_content = addslashes(iconv('GB2312', 'UTF-8', $info_path));
		$arr = @array_slice(file($info_path), 0, 9);
		$arr[1] = addslashes(iconv('GB2312', 'UTF-8', $arr[1]));
		$arr[2] = addslashes(iconv('GB2312', 'UTF-8', $arr[2]));
		$arr[3] = addslashes(iconv('GB2312', 'UTF-8', $arr[3]));
		$arr[4] = addslashes(iconv('GB2312', 'UTF-8', $arr[4]));
		$arr[5] = addslashes(iconv('GB2312', 'UTF-8', $arr[5]));
		$arr[6] = addslashes(iconv('GB2312', 'UTF-8', $arr[6]));
		$arr[7] = addslashes(iconv('GB2312', 'UTF-8', $arr[7]));
		$arr[8] = addslashes(iconv('GB2312', 'UTF-8', $arr[8]));
		$template_name = explode('：', $arr[1]);
		$template_uri = explode('：', $arr[2]);
		$template_desc = explode('：', $arr[3]);
		$template_version = explode('：', $arr[4]);
		$template_author = explode('：', $arr[5]);
		$author_uri = explode('：', $arr[6]);
		$tpl_dwt_code = explode('：', $arr[7]);
		$win_goods_type = explode('：', $arr[8]);
		$info['name'] = isset($template_name[1]) ? trim($template_name[1]) : '';
		$info['uri'] = isset($template_uri[1]) ? trim($template_uri[1]) : '';
		$info['desc'] = isset($template_desc[1]) ? trim($template_desc[1]) : '';
		$info['version'] = isset($template_version[1]) ? trim($template_version[1]) : '';
		$info['author'] = isset($template_author[1]) ? trim($template_author[1]) : '';
		$info['author_uri'] = isset($author_uri[1]) ? trim($author_uri[1]) : '';
		$info['dwt_code'] = isset($tpl_dwt_code[1]) ? trim($tpl_dwt_code[1]) : '';
		$info['win_goods_type'] = isset($win_goods_type[1]) ? trim($win_goods_type[1]) : '';
		$info['sort'] = substr($info['code'], -1, 1);
	}
	else {
		$info['name'] = '';
		$info['uri'] = '';
		$info['desc'] = '';
		$info['version'] = '';
		$info['author'] = '';
		$info['author_uri'] = '';
		$info['dwt_code'] = '';
		$info['sort'] = '';
	}

	return $info;
}

function object_to_array($obj)
{
	$_arr = (is_object($obj) ? get_object_vars($obj) : $obj);

	if ($_arr) {
		foreach ($_arr as $key => $val) {
			$val = (is_array($val) || is_object($val) ? object_to_array($val) : $val);
			$arr[$key] = $val;
		}
	}
	else {
		$arr = array();
	}

	return $arr;
}

function getleft_attr($type = 0, $ru_id = 0, $tem = '', $theme = '')
{
	$sql = 'SELECT bg_color ,img_file ,if_show,bgrepeat,align,fileurl FROM' . $GLOBALS['ecs']->table('templates_left') . ' WHERE ru_id = \'' . $ru_id . '\' AND type = \'' . $type . '\' AND seller_templates = \'' . $tem . '\' AND theme = \'' . $theme . '\'';
	return $GLOBALS['db']->getRow($sql);
}

function del_DirAndFile($dirName)
{
	if (is_dir($dirName)) {
		if ($handle = opendir($dirName)) {
			while (false !== ($item = readdir($handle))) {
				if (($item != '.') && ($item != '..')) {
					if (is_dir($dirName . '/' . $item)) {
						del_DirAndFile($dirName . '/' . $item);
					}
					else {
						unlink($dirName . '/' . $item);
					}
				}
			}

			closedir($handle);
			return rmdir($dirName);
		}
	}
	else {
		return true;
	}
}

function recurse_copy($src, $des, $type = 0)
{
	$dir = opendir($src);

	if (!is_dir($des)) {
		mkdir($des, 511, true);
	}

	while (false !== ($file = readdir($dir))) {
		if (($file != '.') && ($file != '..')) {
			if (is_dir($src . '/' . $file)) {
				recurse_copy($src . '/' . $file, $des . '/' . $file);
			}
			else if ($type == 0) {
				copy($src . '/' . $file, $des . '/' . $file);
			}
			else {
				$comtent = read_static_flie_cache($src . '/' . $file);
				$files = explode('.', $file);
				$files_count = count($files) - 1;
				$suffix_name = $files[$files_count];

				if (2 < count($files)) {
					$path = count($files) - 1;
					$name = '';

					if ($files[$path]) {
						foreach ($files[$path] as $row) {
							$name .= $row . '.';
						}

						$name = substr($name, 0, -1);
					}

					$file_path = explode('/', $name);

					if (2 < $file_path) {
						$path = count($file_path) - 1;
						$cachename = $file_path[$path];
					}
					else {
						$cachename = $file_path[0];
					}
				}
				else {
					$cachename = $files[0];
				}

				write_static_file_cache($cachename, $comtent, $suffix_name, $des . '/');
			}
		}
	}

	closedir($dir);
}

function get_new_dirName($ru_id = 0, $des = '')
{
	if ($des == '') {
		$des = ROOT_PATH . 'data/seller_templates/seller_tem_' . $ru_id;
	}

	if (!is_dir($des)) {
		return 'backup_tpl_1';
	}
	else {
		$res = array();
		$dir = opendir($des);

		while (false !== ($file = readdir($dir))) {
			if (($file != '.') && ($file != '..')) {
				if (is_dir($des . '/' . $file)) {
					$arr = explode('_', $file);

					if ($arr[2]) {
						$res[] = $arr[2];
					}
				}
			}
		}

		closedir($dir);

		if ($res) {
			$suffix = MAX($res) + 1;
			return 'backup_tpl_' . $suffix;
		}
		else {
			return 'backup_tpl_1';
		}
	}
}

function getAlbumList($album_id = 0)
{
	$filter['album_id'] = !empty($_REQUEST['album_id']) ? intval($_REQUEST['album_id']) : 0;
	$filter['sort_name'] = !empty($_REQUEST['sort_name']) && ($_REQUEST['sort_name'] != 'undefined') ? intval($_REQUEST['sort_name']) : 2;

	if (0 < $album_id) {
		$filter['album_id'] = $album_id;
	}

	$where = ' WHERE 1';

	if (0 < $filter['album_id']) {
		$where .= ' AND album_id = \'' . $filter['album_id'] . '\'';
	}

	if (0 < $filter['sort_name']) {
		switch ($filter['sort_name']) {
		case '1':
			$where .= ' ORDER BY add_time ASC';
			break;

		case '2':
			$where .= ' ORDER BY add_time DESC';
			break;

		case '3':
			$where .= ' ORDER BY pic_size ASC';
			break;

		case '4':
			$where .= ' ORDER BY pic_size DESC';
			break;

		case '5':
			$where .= ' ORDER BY pic_name ASC';
			break;

		case '6':
			$where .= ' ORDER BY pic_name DESC';
			break;
		}
	}

	$sql = 'SELECT COUNT(*) FROM ' . $GLOBALS['ecs']->table('pic_album') . $where;
	$filter['record_count'] = $GLOBALS['db']->getOne($sql);
	$filter = page_and_size($filter, 3);
	$where .= ' LIMIT ' . $filter['start'] . ',' . $filter['page_size'];
	$sql = 'SELECT * FROM ' . $GLOBALS['ecs']->table('pic_album') . $where;
	$recommend_brands = $GLOBALS['db']->getAll($sql);
	$arr = array();

	foreach ($recommend_brands as $key => $row) {
		$row['pic_file'] = get_image_path($row['pic_id'], $row['pic_file']);
		$row['pic_thumb'] = get_image_path($row['pic_id'], $row['pic_thumb']);
		$row['pic_image'] = get_image_path($row['pic_id'], $row['pic_image']);
		$arr[] = $row;
	}

	$filter['page_arr'] = seller_page($filter, $filter['page'], 14);
	return array('list' => $arr, 'filter' => $filter);
}

function getGoodslist($where = '', $sort = '', $search = '', $leftjoin = '')
{
	$sql = 'SELECT COUNT(*) FROM ' . $GLOBALS['ecs']->table('goods') . ' AS g ' . $leftjoin . $where;
	$filter['record_count'] = $GLOBALS['db']->getOne($sql);
	$filter = page_and_size($filter);
	$where .= $sort . ' LIMIT ' . $filter['start'] . ',' . $filter['page_size'];
	$sql = 'SELECT g.promote_start_date, g.promote_end_date, g.promote_price, g.goods_name, g.goods_id, g.goods_thumb, g.shop_price, g.market_price, g.original_img ' . $search . ' FROM ' . $GLOBALS['ecs']->table('goods') . ' AS g ' . $leftjoin . $where;
	$goods_list = $GLOBALS['db']->getAll($sql);
	$filter['page_arr'] = seller_page($filter, $filter['page']);
	return array('list' => $goods_list, 'filter' => $filter);
}

function resetBarnd($brand_id = array(), $table = 'goods', $category = 'goods_id')
{
	if ($brand_id) {
		if ($table == 'goods') {
			$sql = 'SELECT ' . $category . ' FROM' . $GLOBALS['ecs']->table('goods') . 'WHERE ' . $category . ' in (' . $brand_id . ')';
		}
		else if ($table == 'brand') {
			$where = ' WHERE be.is_recommend=1 AND b.brand_id in (' . $brand_id . ')';
			$sql = 'SELECT b.brand_id FROM ' . $GLOBALS['ecs']->table('brand') . ' as b left join ' . $GLOBALS['ecs']->table('brand_extend') . ' AS be on b.brand_id=be.brand_id ' . $where;
		}

		$ids = $GLOBALS['db']->getAll($sql);

		if (!empty($ids)) {
			return implode(',', arr_foreach($ids));
		}
		else {
			return '';
		}
	}
	else {
		return '';
	}
}

function strFilter($str)
{
	$str = str_replace('`', '', $str);
	$str = str_replace('·', '', $str);
	$str = str_replace('~', '', $str);
	$str = str_replace('!', '', $str);
	$str = str_replace('！', '', $str);
	$str = str_replace('@', '', $str);
	$str = str_replace('#', '', $str);
	$str = str_replace('$', '', $str);
	$str = str_replace('￥', '', $str);
	$str = str_replace('%', '', $str);
	$str = str_replace('^', '', $str);
	$str = str_replace('……', '', $str);
	$str = str_replace('&', '', $str);
	$str = str_replace('*', '', $str);
	$str = str_replace('(', '', $str);
	$str = str_replace(')', '', $str);
	$str = str_replace('（', '', $str);
	$str = str_replace('）', '', $str);
	$str = str_replace('-', '', $str);
	$str = str_replace('_', '', $str);
	$str = str_replace('——', '', $str);
	$str = str_replace('+', '', $str);
	$str = str_replace('=', '', $str);
	$str = str_replace('|', '', $str);
	$str = str_replace('\\', '', $str);
	$str = str_replace('[', '', $str);
	$str = str_replace(']', '', $str);
	$str = str_replace('【', '', $str);
	$str = str_replace('】', '', $str);
	$str = str_replace('{', '', $str);
	$str = str_replace('}', '', $str);
	$str = str_replace(';', '', $str);
	$str = str_replace('；', '', $str);
	$str = str_replace(':', '', $str);
	$str = str_replace('：', '', $str);
	$str = str_replace('\'', '', $str);
	$str = str_replace('"', '', $str);
	$str = str_replace('“', '', $str);
	$str = str_replace('”', '', $str);
	$str = str_replace(',', '', $str);
	$str = str_replace('，', '', $str);
	$str = str_replace('<', '', $str);
	$str = str_replace('>', '', $str);
	$str = str_replace('《', '', $str);
	$str = str_replace('》', '', $str);
	$str = str_replace('.', '', $str);
	$str = str_replace('。', '', $str);
	$str = str_replace('/', '', $str);
	$str = str_replace('、', '', $str);
	$str = str_replace('?', '', $str);
	$str = str_replace('？', '', $str);
	return trim($str);
}

function get_floor_style($mode = '')
{
	$arr = array();

	switch ($mode) {
	case 'homeFloor':
		$arr = array('1,2,3', '1,2,3', '2,3', '1,2,3');
		break;

	case 'homeFloorModule':
		$arr = array('1,3', '1,3', '1,3', '1,3');
		break;

	case 'homeFloorThree':
		$arr = array('2', '1,2,3', '1,3', '2,3');
		break;

	case 'homeFloorFour':
		$arr = array('2', '1', '2', '');
		break;

	case 'homeFloorFive':
		$arr = array('1,2', '1,2,3', '1,2,3', '1,2,3', '1,2,3');
		break;

	case 'homeFloorSix':
		$arr = array('1,2', '1,2', '1,2', '1');
		break;

	case 'homeFloorSeven':
		$arr = array('1,2', '1,2', '1,2', '1,2', '1,2');
		break;
	}

	return $arr;
}

function getAdvNum($mode = '', $floorMode = 0)
{
	$arr = array();

	switch ($mode) {
	case 'homeFloor':
		$arr1 = array('leftBanner' => '3', 'leftAdv' => '2', 'rightAdv' => '5');
		$arr2 = array('leftBanner' => '3', 'leftAdv' => '2', 'rightAdv' => '5');
		$arr3 = array('leftAdv' => '2', 'rightAdv' => '5');
		$arr4 = array('leftBanner' => '3', 'leftAdv' => '2', 'rightAdv' => '5');

		if ($floorMode == 1) {
			$arr = $arr1;
		}
		else if ($floorMode == 2) {
			$arr = $arr2;
		}
		else if ($floorMode == 3) {
			$arr = $arr3;
		}
		else if ($floorMode == 4) {
			$arr = $arr4;
		}
		else {
			$arr[1] = $arr1;
			$arr[2] = $arr2;
			$arr[3] = $arr3;
			$arr[4] = $arr4;
		}

		break;

	case 'homeFloorModule':
		$arr1 = array('leftBanner' => '3', 'rightAdv' => '4');
		$arr2 = array('leftBanner' => '3', 'rightAdv' => '3');
		$arr3 = array('leftBanner' => '3', 'rightAdv' => '3');
		$arr4 = array('leftBanner' => '3', 'rightAdv' => '2');

		if ($floorMode == 1) {
			$arr = $arr1;
		}
		else if ($floorMode == 2) {
			$arr = $arr2;
		}
		else if ($floorMode == 3) {
			$arr = $arr3;
		}
		else if ($floorMode == 4) {
			$arr = $arr4;
		}
		else {
			$arr[1] = $arr1;
			$arr[2] = $arr2;
			$arr[3] = $arr3;
			$arr[4] = $arr4;
		}

		break;

	case 'homeFloorThree':
		$arr1 = array('leftAdv' => '5');
		$arr2 = array('leftBanner' => '3', 'leftAdv' => '1', 'rightAdv' => '6');
		$arr3 = array('leftBanner' => '3', 'rightAdv' => '8');
		$arr4 = array('leftAdv' => '2', 'rightAdv' => '8');

		if ($floorMode == 1) {
			$arr = $arr1;
		}
		else if ($floorMode == 2) {
			$arr = $arr2;
		}
		else if ($floorMode == 3) {
			$arr = $arr3;
		}
		else if ($floorMode == 4) {
			$arr = $arr4;
		}
		else {
			$arr[1] = $arr1;
			$arr[2] = $arr2;
			$arr[3] = $arr3;
			$arr[4] = $arr4;
		}

		break;

	case 'homeFloorFour':
		$arr1 = array('leftAdv' => '2');
		$arr2 = array('leftBanner' => '3');
		$arr3 = array('leftAdv' => '2');
		$arr4 = array();

		if ($floorMode == 1) {
			$arr = $arr1;
		}
		else if ($floorMode == 2) {
			$arr = $arr2;
		}
		else if ($floorMode == 3) {
			$arr = $arr3;
		}
		else if ($floorMode == 4) {
			$arr = $arr4;
		}
		else {
			$arr[1] = $arr1;
			$arr[2] = $arr2;
			$arr[3] = $arr3;
			$arr[4] = $arr4;
		}

		break;

	case 'homeFloorFive':
		$arr1 = array('leftBanner' => '3', 'leftAdv' => '3');
		$arr2 = array('leftBanner' => '3', 'leftAdv' => '3', 'rightAdv' => '3');
		$arr3 = array('leftBanner' => '3', 'leftAdv' => '3', 'rightAdv' => '2');
		$arr4 = array('leftBanner' => '3', 'leftAdv' => '3', 'rightAdv' => '1');
		$arr5 = array('leftBanner' => '3', 'leftAdv' => '3', 'rightAdv' => '2');

		if ($floorMode == 1) {
			$arr = $arr1;
		}
		else if ($floorMode == 2) {
			$arr = $arr2;
		}
		else if ($floorMode == 3) {
			$arr = $arr3;
		}
		else if ($floorMode == 4) {
			$arr = $arr4;
		}
		else if ($floorMode == 5) {
			$arr = $arr5;
		}
		else {
			$arr[1] = $arr1;
			$arr[2] = $arr2;
			$arr[3] = $arr3;
			$arr[4] = $arr4;
			$arr[5] = $arr5;
		}

		break;

	case 'homeFloorSix':
		$arr1 = array('leftBanner' => '3', 'leftAdv' => '4');
		$arr2 = array('leftBanner' => '3', 'leftAdv' => '2');
		$arr3 = array('leftBanner' => '3', 'leftAdv' => '1');
		$arr4 = array('leftBanner' => '3');

		if ($floorMode == 1) {
			$arr = $arr1;
		}
		else if ($floorMode == 2) {
			$arr = $arr2;
		}
		else if ($floorMode == 3) {
			$arr = $arr3;
		}
		else if ($floorMode == 4) {
			$arr = $arr4;
		}
		else {
			$arr[1] = $arr1;
			$arr[2] = $arr2;
			$arr[3] = $arr3;
			$arr[4] = $arr4;
		}

		break;

	case 'homeFloorSeven':
		$arr1 = array('leftBanner' => '3', 'leftAdv' => '1');
		$arr2 = array('leftBanner' => '3', 'leftAdv' => '1');
		$arr3 = array('leftBanner' => '3', 'leftAdv' => '1');
		$arr4 = array('leftBanner' => '3', 'leftAdv' => '1');
		$arr5 = array('leftBanner' => '3', 'leftAdv' => '1');

		if ($floorMode == 1) {
			$arr = $arr1;
		}
		else if ($floorMode == 2) {
			$arr = $arr2;
		}
		else if ($floorMode == 3) {
			$arr = $arr3;
		}
		else if ($floorMode == 4) {
			$arr = $arr4;
		}
		else if ($floorMode == 5) {
			$arr = $arr5;
		}
		else {
			$arr[1] = $arr1;
			$arr[2] = $arr2;
			$arr[3] = $arr3;
			$arr[4] = $arr4;
			$arr[5] = $arr5;
		}

		break;
	}

	return $arr;
}


?>
