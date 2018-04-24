<?php
// by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace app\contracts\transformer;

interface TransformerInterface
{
	public function transformCollection(array $map);

	public function transform(array $map);
}


?>
