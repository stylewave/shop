<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class StoreAction extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'store_action';
	protected $primaryKey = 'action_id';
	public $timestamps = false;
	protected $fillable = array('parent_id', 'action_code', 'relevance', 'action_name');
	protected $guarded = array();
}

?>
