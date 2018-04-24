<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class NoticeLog extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'notice_log';
	public $timestamps = false;
	protected $fillable = array('goods_id', 'email', 'send_ok', 'send_type', 'send_time');
	protected $guarded = array();
}

?>
