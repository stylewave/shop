<?php
//zend by 旺旺dongshaolin2008所有  禁止倒卖 一经发现停止任何服务
function customSetup($barcode, $get)
{
	if (isset($get['start'])) {
		$barcode->setStart($get['start'] === 'NULL' ? NULL : $get['start']);
	}
}

$classFile = 'BCGgs1128.barcode.php';
$className = 'BCGgs1128';
$baseClassFile = 'BCGBarcode1D.php';
$codeVersion = '5.2.0';

?>
