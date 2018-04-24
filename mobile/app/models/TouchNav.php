<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class TouchNav extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'touch_nav';
	public $timestamps = false;
	protected $fillable = array('ctype', 'cid', 'name', 'ifshow', 'vieworder', 'opennew', 'url', 'type', 'pic');
	protected $guarded = array();
}

?>
