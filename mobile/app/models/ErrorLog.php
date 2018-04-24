<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class ErrorLog extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'error_log';
	public $timestamps = false;
	protected $fillable = array('info', 'file', 'time');
	protected $guarded = array();
}

?>
