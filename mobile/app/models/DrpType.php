<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class DrpType extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'drp_type';
	public $timestamps = false;
	protected $fillable = array('user_id', 'cat_id', 'goods_id', 'type', 'add_time');
	protected $guarded = array();
}

?>
