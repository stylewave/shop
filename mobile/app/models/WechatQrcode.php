<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class WechatQrcode extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'wechat_qrcode';
	public $timestamps = false;
	protected $fillable = array('wechat_id', 'type', 'expire_seconds', 'scene_id', 'username', 'function', 'ticket', 'qrcode_url', 'endtime', 'scan_num', 'status', 'sort');
	protected $guarded = array();
}

?>
