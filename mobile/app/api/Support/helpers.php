<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
function url()
{
}

if (!function_exists('get_image_path')) {
	function get_image_path($image = '', $path = '')
	{
		if (strtolower(substr($image, 0, 4)) == 'http') {
			$url = $image;
		}
		else {
			$no_picture = 'no_image.jpg';
			$path = (empty($path) ? '' : rtrim($path, '/') . '/');
			$img_path = $path . $image;

			if (empty($image)) {
				$url = $no_picture;
			}
			else {
				$url = $img_path;
			}
		}

		return $url;
	}
}

if (!function_exists('price_format')) {
	function price_format($price, $change_price = true)
	{
		$shopconfig = app('App\\Repositories\\ShopConfig\\ShopConfigRepository');
		$priceFormat = $shopconfig->getShopConfigByCode('price_format');
		$currencyFormat = $shopconfig->getShopConfigByCode('currency_format');

		if ($price === '') {
			$price = 0;
		}

		if ($change_price && (defined('ECS_ADMIN') === false)) {
			switch ($priceFormat) {
			case 0:
				$price = number_format($price, 2, '.', '');
				break;

			case 1:
				$price = preg_replace('/(.*)(\\.)([0-9]*?)0+$/', '\\1\\2\\3', number_format($price, 2, '.', ''));

				if (substr($price, -1) == '.') {
					$price = substr($price, 0, -1);
				}

				break;

			case 2:
				$price = substr(number_format($price, 2, '.', ''), 0, -1);
				break;

			case 3:
				$price = intval($price);
				break;

			case 4:
				$price = number_format($price, 1, '.', '');
				break;

			case 5:
				$price = round($price);
				break;
			}
		}
		else {
			@$price = number_format($price, 2, '.', '');
		}

		return sprintf($currencyFormat, $price);
	}
}

if (!function_exists('make_semiangle')) {
	function make_semiangle($str)
	{
		$arr = array('０' => '0', '１' => '1', '２' => '2', '３' => '3', '４' => '4', '５' => '5', '６' => '6', '７' => '7', '８' => '8', '９' => '9', 'Ａ' => 'A', 'Ｂ' => 'B', 'Ｃ' => 'C', 'Ｄ' => 'D', 'Ｅ' => 'E', 'Ｆ' => 'F', 'Ｇ' => 'G', 'Ｈ' => 'H', 'Ｉ' => 'I', 'Ｊ' => 'J', 'Ｋ' => 'K', 'Ｌ' => 'L', 'Ｍ' => 'M', 'Ｎ' => 'N', 'Ｏ' => 'O', 'Ｐ' => 'P', 'Ｑ' => 'Q', 'Ｒ' => 'R', 'Ｓ' => 'S', 'Ｔ' => 'T', 'Ｕ' => 'U', 'Ｖ' => 'V', 'Ｗ' => 'W', 'Ｘ' => 'X', 'Ｙ' => 'Y', 'Ｚ' => 'Z', 'ａ' => 'a', 'ｂ' => 'b', 'ｃ' => 'c', 'ｄ' => 'd', 'ｅ' => 'e', 'ｆ' => 'f', 'ｇ' => 'g', 'ｈ' => 'h', 'ｉ' => 'i', 'ｊ' => 'j', 'ｋ' => 'k', 'ｌ' => 'l', 'ｍ' => 'm', 'ｎ' => 'n', 'ｏ' => 'o', 'ｐ' => 'p', 'ｑ' => 'q', 'ｒ' => 'r', 'ｓ' => 's', 'ｔ' => 't', 'ｕ' => 'u', 'ｖ' => 'v', 'ｗ' => 'w', 'ｘ' => 'x', 'ｙ' => 'y', 'ｚ' => 'z', '（' => '(', '）' => ')', '〔' => '[', '〕' => ']', '【' => '[', '】' => ']', '〖' => '[', '〗' => ']', '“' => '[', '”' => ']', '‘' => '[', '’' => ']', '｛' => '{', '｝' => '}', '《' => '<', '》' => '>', '％' => '%', '＋' => '+', '—' => '-', '－' => '-', '～' => '-', '：' => ':', '。' => '.', '、' => ',', '，' => '.', '、' => '.', '；' => ',', '？' => '?', '！' => '!', '…' => '-', '‖' => '|', '”' => '"', '’' => '`', '‘' => '`', '｜' => '|', '〃' => '"', '　' => ' ');
		return strtr($str, $arr);
	}
}

?>
