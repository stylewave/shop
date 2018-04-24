<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class EmailSendlist extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'email_sendlist';
	public $timestamps = false;
	protected $fillable = array('email', 'template_id', 'email_content', 'error', 'pri', 'last_send');
	protected $guarded = array();
}

?>
