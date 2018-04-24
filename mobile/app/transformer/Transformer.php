<?php
// by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace app\transformer;

abstract class Transformer implements \app\contracts\transformer\TransformerInterface
{
	public function transformCollection(array $map)
	{
		return array_map(array($this, 'transform'), $map);
	}
//cichengxupojielaiziyujinmengwangluo banquanshuyushanghaishangchuangsuoyou jinzhidaomai yijingfaxiantingzhirenhefuwu
	abstract public function transform(array $map);
}

?>
