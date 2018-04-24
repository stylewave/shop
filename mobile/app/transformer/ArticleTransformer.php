<?php
// by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace app\transformer;

class ArticleTransformer extends Transformer
{
	public function transform(array $map)
	{
		return array('id' => $map['article_id'], 'title' => $map['title']);
	}
}

?>
