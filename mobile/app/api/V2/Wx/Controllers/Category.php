<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace app\api\v2\wx\controllers;

class Category extends \app\api\foundation\Controller
{
	private $categoryService;

	public function __construct(\app\services\CategoryService $categoryService)
	{
		parent::__construct();
		$this->categoryService = $categoryService;
	}

	public function actionIndex()
	{
		$list = $this->categoryService->categoryList();
		return $this->apiReturn(array('category' => $list));
	}
}

?>
