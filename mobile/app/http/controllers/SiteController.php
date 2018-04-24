<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace app\http\controllers;

class SiteController extends \yii\web\Controller
{
	public function actions()
	{
		return array(
	'error' => array('class' => 'yii\\web\\ErrorAction')
	);
	}

	public function actionIndex()
	{
		return 'ready.';
	}
}

?>
