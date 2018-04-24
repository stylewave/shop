<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class WarehouseFreight extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'warehouse_freight';
	public $timestamps = false;
	protected $fillable = array('user_id', 'warehouse_id', 'shipping_id', 'region_id', 'configure');
	protected $guarded = array();
}

?>
