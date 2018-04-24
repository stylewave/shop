<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class Stages extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'stages';
	protected $primaryKey = 'stages_id';
	public $timestamps = false;
	protected $fillable = array('order_sn', 'stages_total', 'stages_one_price', 'yes_num', 'create_date', 'repay_date');
	protected $guarded = array();
}

?>
