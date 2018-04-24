<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace App\Behavior;

class RevisionNameBehavior
{
	/**
     * @var array
     */
	private $convert = array();

	public function run()
	{
		if (cache('transform') === 1) {
			return false;
		}

		$root_path = str_replace('\\', '/', dirname(dirname(__DIR__))) . '/';
		$list = array('app/api', 'app/contracts', 'app/repositories');

		foreach ($list as $item) {
			$this->getConvert($root_path . $item);
		}

		$this->transform();
	}

	private function getConvert($item)
	{
		$list = glob($item . '/*');

		foreach ($list as $vo) {
			if (is_dir($vo)) {
				$this->getConvert($vo);
				$this->convert[] = $vo;
			}
		}
	}

	private function transform()
	{
		foreach ($this->convert as $item) {
			$name = dirname($item) . '/' . ucfirst(basename($item));
			rename($item, $name);
		}

		cache('transform', 1);
	}
}


?>
