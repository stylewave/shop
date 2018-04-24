<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class VolumePrice extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'volume_price';
	public $timestamps = false;
	protected $fillable = array('price_type', 'goods_id', 'volume_number', 'volume_price');
	protected $guarded = array();
}

?>
