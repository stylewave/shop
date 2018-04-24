<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class SellerDomain extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'seller_domain';
	public $timestamps = false;
	protected $fillable = array('domain_name', 'ru_id', 'is_enable', 'validity_time');
	protected $guarded = array();
}

?>
