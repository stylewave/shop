<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace app\api\v2\article\controllers;

class HelpController extends \App\Api\Controllers\Controller
{
	/**
     * @var CategoryRepository
     */
	protected $category;
	/**
     * @var ArticleRepository
     */
	protected $article;

	public function __construct(\App\Repositories\Article\CategoryRepository $category, \App\Repositories\Article\ArticleRepository $article)
	{
		$this->category = $category;
		$this->article = $article;
	}

	public function actionList(array $args)
	{
		$help = cache('shop_help');

		if (!$help) {
			$help = array();
			$intro = $this->category->detail(array('cat_type' => INFO_CAT), array('cat_id', 'cat_name'));
			$intro['list'] = $this->article->all($intro['id'], array('title'));
			$help[] = $intro;
			$list = $this->category->all(array('cat_type' => HELP_CAT), array('cat_id', 'cat_name'));

			foreach ($list['data'] as $key => $item) {
				$item['list'] = $this->article->all($item['id'], array('title'));
				$help[] = $item;
			}

			cache('shop_help', $help);
		}

		return $help;
	}
}

?>
