<?php
//zend by 旺旺dongshaolin2008所有  禁止倒卖 一经发现停止任何服务
ob_start();
include dirname(__FILE__) . '/res/exemple05.php';
$content = ob_get_clean();
require_once dirname(__FILE__) . '/../html2pdf.class.php';

try {
	$html2pdf = new HTML2PDF('P', 'A4', 'fr');
	$html2pdf->pdf->SetDisplayMode('fullpage');
	$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
	$html2pdf->Output('exemple05.pdf');
}
catch (HTML2PDF_exception $e) {
	echo $e;
	exit();
}

?>
