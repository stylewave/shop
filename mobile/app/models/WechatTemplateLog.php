<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class WechatTemplateLog extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'wechat_template_log';
	public $timestamps = false;
	protected $fillable = array('wechat_id', 'msgid', 'code', 'openid', 'data', 'url', 'status');
	protected $guarded = array();
}

?>
