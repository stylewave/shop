<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class FavourableActivity extends \Illuminate\Database\Eloquent\Model
{
	const FAT_GOODS = 0;
	const FAT_PRICE = 1;
	const FAT_DISCOUNT = 2;
	const FAR_ALL = 0;
	const FAR_CATEGORY = 1;
	const FAR_BRAND = 2;
	const FAR_GOODS = 3;

	protected $table = 'favourable_activity';
	protected $primaryKey = 'act_id';
	public $timestamps = false;
	protected $fillable = array('act_name', 'start_time', 'end_time', 'user_rank', 'act_range', 'act_range_ext', 'min_amount', 'max_amount', 'act_type', 'act_type_ext', 'activity_thumb', 'gift', 'sort_order', 'user_id', 'userFav_type', 'review_status', 'review_content');
	protected $guarded = array();
}

?>
