<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class LinkBrand extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'link_brand';
	public $timestamps = false;
	protected $fillable = array('bid', 'brand_id');
	protected $guarded = array();
}

?>
