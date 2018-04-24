<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class Tag extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'tag';
	protected $primaryKey = 'tag_id';
	public $timestamps = false;
	protected $fillable = array('user_id', 'goods_id', 'tag_words');
	protected $guarded = array();
}

?>
