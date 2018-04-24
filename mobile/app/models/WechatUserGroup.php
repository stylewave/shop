<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class WechatUserGroup extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'wechat_user_group';
	public $timestamps = false;
	protected $fillable = array('wechat_id', 'group_id', 'name', 'count', 'sort');
	protected $guarded = array();
}

?>
