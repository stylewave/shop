<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class EmailList extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'email_list';
	public $timestamps = false;
	protected $fillable = array('email', 'stat', 'hash');
	protected $guarded = array();
}

?>
