<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class MerchantsPercent extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'merchants_percent';
	protected $primaryKey = 'percent_id';
	public $timestamps = false;
	protected $fillable = array('percent_value', 'sort_order', 'add_time');
	protected $guarded = array();
}

?>
