<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class Suppliers extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'suppliers';
	protected $primaryKey = 'suppliers_id';
	public $timestamps = false;
	protected $fillable = array('suppliers_name', 'suppliers_desc', 'is_check');
	protected $guarded = array();
}

?>
