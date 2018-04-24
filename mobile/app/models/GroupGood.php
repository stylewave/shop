<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace app\models;

class GroupGood extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'group_goods';
	public $timestamps = false;
	protected $fillable = array('parent_id', 'goods_id', 'goods_price', 'admin_id', 'group_id');
	protected $guarded = array();
}

?>
