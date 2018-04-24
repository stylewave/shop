<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class WechatMenu extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'wechat_menu';
	public $timestamps = false;
	protected $fillable = array('wechat_id', 'pid', 'name', 'type', 'key', 'url', 'sort', 'status');
	protected $guarded = array();
}

?>
