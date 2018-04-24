<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class PayLog extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'pay_log';
	protected $primaryKey = 'log_id';
	public $timestamps = false;
	protected $fillable = array('order_id', 'order_amount', 'order_type', 'is_paid', 'openid', 'transid');
	protected $guarded = array();
}

?>
