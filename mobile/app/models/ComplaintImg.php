<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class ComplaintImg extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'complaint_img';
	protected $primaryKey = 'img_id';
	public $timestamps = false;
	protected $fillable = array('order_id', 'complaint_id', 'user_id', 'img_file');
	protected $guarded = array();
}

?>
