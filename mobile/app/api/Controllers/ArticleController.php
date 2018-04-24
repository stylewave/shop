<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace App\Api\Controllers;

class ArticleController extends Controller
{
	public function index()
	{
		$article = \App\Models\Article::all();
		return $this->collection($article, new ArticleTransformer());
	}
}

?>
