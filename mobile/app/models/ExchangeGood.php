<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace app\models;

class ExchangeGood extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'exchange_goods';
	protected $primaryKey = 'goods_id';
	public $timestamps = false;
	protected $fillable = array('user_id', 'exchange_integral', 'is_exchange', 'is_hot', 'is_best');
	protected $guarded = array();
}

?>
