<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace app\http\search\controllers;

class Index extends \app\http\base\controllers\Frontend
{
	public function actionIndex()
	{
		$this->assign('page_title', L('search'));
		$this->display();
	}
}

?>
