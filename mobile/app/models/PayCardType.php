<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class PayCardType extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'pay_card_type';
	protected $primaryKey = 'type_id';
	public $timestamps = false;
	protected $fillable = array('type_name', 'type_money', 'type_prefix', 'use_end_date');
	protected $guarded = array();
}

?>
