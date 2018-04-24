<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace App\Repositories\Goods;

class GoodsRepository implements \App\Contracts\Repository\Goods\GoodsRepositoryInterface
{
	protected $goods;
	private $field;
	private $userRankRepository;
	private $authService;
	private $memberPriceRepository;
	private $goodsAttrRepository;
	private $volumePriceRepository;

	public function __construct(\App\Repositories\User\UserRankRepository $userRankRepository, \app\services\AuthService $authService, \App\Repositories\User\MemberPriceRepository $memberPriceRepository, GoodsAttrRepository $goodsAttrRepository, VolumePriceRepository $volumePriceRepository)
	{
		$this->setField();
		$this->userRankRepository = $userRankRepository;
		$this->authService = $authService;
		$this->memberPriceRepository = $memberPriceRepository;
		$this->goodsAttrRepository = $goodsAttrRepository;
		$this->volumePriceRepository = $volumePriceRepository;
	}

	public function create(array $data)
	{
	}

	public function get($id)
	{
	}

	public function update(array $data)
	{
	}

	public function delete($id)
	{
	}

	public function search(array $data)
	{
	}

	public function sku($id)
	{
	}

	public function skuAdd()
	{
	}

	public function setField()
	{
		$this->field = array('category' => 'cat_id');
	}

	public function getField($field)
	{
		return $this->field[$field];
	}

	public function find($goods_id)
	{
		return \App\Models\Goods::select('*')->where('goods_id', $goods_id)->first()->toArray();
	}

	public function findBy($field, $value, $page = 1, $size = 10, $columns = array('*'))
	{
		$field = $this->getField($field);
		$begin = ($page - 1) * $size;
		return \App\Models\Goods::select($columns)->where($field, $value)->offset($begin)->limit($size)->get()->toArray();
	}

	public function findByType($type = 'best', $size = 10)
	{
		switch ($type) {
		case 'hot':
			$type = 'is_hot';
			break;

		case 'new':
			$type = 'is_new';
			break;

		default:
			$type = 'is_best';
			break;
		}

		$goods = \App\Models\Goods::select('goods_id', 'cat_id', 'user_cat', 'user_id', 'goods_sn', 'goods_name', 'click_count', 'brand_id', 'provider_name', 'goods_number', 'goods_weight', 'default_shipping', 'market_price', 'cost_price', 'shop_price', 'promote_price', 'promote_start_date', 'promote_end_date', 'warn_number', 'keywords', 'goods_brief', 'goods_desc', 'desc_mobile', 'goods_thumb', 'goods_img', 'original_img', 'is_real', 'extension_code', 'is_on_sale', 'is_alone_sale', 'is_shipping', 'integral', 'add_time', 'sort_order', 'is_delete', 'is_best', 'is_new', 'is_hot', 'is_promote', 'is_volume', 'is_fullcut', 'bonus_type_id', 'last_update', 'goods_type', 'seller_note', 'give_integral', 'rank_integral', 'suppliers_id', 'is_check', 'store_hot', 'store_new', 'store_best', 'group_number', 'is_xiangou', 'xiangou_start_date', 'xiangou_end_date', 'xiangou_num', 'review_status', 'review_content', 'goods_shipai', 'comments_number', 'sales_volume', 'comment_num', 'model_price', 'model_inventory', 'model_attr', 'largest_amount', 'pinyin_keyword', 'goods_product_tag', 'goods_tag', 'stages', 'stages_rate', 'freight', 'shipping_fee', 'tid', 'goods_unit', 'goods_cause', 'dis_commission', 'is_distribution')->where($type, 1)->orderby('goods_id', 'desc')->limit($size)->get()->toArray();
		return $goods;
	}

	public function goodsInfo($id)
	{
		return \App\Models\Goods::select('goods_id', 'goods_name', 'shop_price as goods_price', 'market_price', 'goods_number as stock', 'goods_desc', 'sales_volume as sales', 'goods_thumb')->where('goods_id', $id)->first()->toArray();
	}

	public function goodsProperties($goods_id, $warehouse_id = 0, $area_id = 0)
	{
		$res = \App\Models\GoodsAttr::from('goods_attr as g')->select('*')->join('attribute as a', 'a.attr_id', '=', 'g.attr_id')->where('g.goods_id', $goods_id)->orderby('a.sort_order')->orderby('g.attr_sort', 'ASC')->get()->toArray();
		$attrTypeDesc = array('唯一属性', '单选属性');
		$properties = array();

		foreach ($res as $k => $v) {
			$v['attr_value'] = str_replace("\n", '<br />', $v['attr_value']);

			if ($v['attr_type'] == 0) {
			}
			else {
				$properties['pro'][$v['attr_id']]['attr_type'] = $attrTypeDesc[$v['attr_type']];
				$properties['pro'][$v['attr_id']]['name'] = $v['attr_name'];
				$properties['pro'][$v['attr_id']]['values'][] = array('label' => $v['attr_value'], 'attr_sort' => $v['attr_sort'], 'price' => $v['attr_price'], 'format_price' => price_format(abs($v['attr_price']), false), 'id' => $v['goods_attr_id']);
			}
		}

		return $properties;
	}

	public function goodsGallery($id)
	{
		return \App\Models\GoodsGallery::select('thumb_url')->where('goods_id', $id)->get()->toArray();
	}

	public function goodsComment($id)
	{
		return \App\Models\Comment::select('comment_id as id', 'user_name', 'content', 'add_time')->where('id_value', $id)->get()->toArray();
	}

	public function getProductByGoods($goodsId, $goodsAttr)
	{
		$product = \App\Models\Products::select('product_id as id', 'product_sn')->where('goods_id', $goodsId)->where('goods_attr', $goodsAttr)->first();

		if ($product === null) {
			return array();
		}

		return $product->toArray();
	}

	public function cartGoods($rec_id)
	{
		$goods = \App\Models\Goods::join('cart', 'goods.goods_id', '=', 'cart.goods_id')->where('cart.rec_id', $rec_id)->select('goods.goods_name', 'goods.goods_number', 'cart.product_id')->first();

		if ($goods === null) {
			return array();
		}

		return $goods->toArray();
	}

	public function getFinalPrice($goods_id, $goods_num = '1', $is_spec_price = false, $property = array())
	{
		$final_price = '0';
		$volume_price = '0';
		$promote_price = '0';
		$user_price = '0';
		$prefix = 'dsc_';
		$price_list = $this->getVolumePriceList($goods_id, '1');

		if (!empty($price_list)) {
			foreach ($price_list as $value) {
				if ($value['number'] <= $goods_num) {
					$volume_price = $value['price'];
				}
			}
		}

		$goods = \App\Models\Goods::from('goods as g')->select('g.promote_price', 'g.promote_start_date', 'g.promote_end_date', 'mp.user_price')->leftjoin('member_price as mp', 'mp.goods_id', '=', 'g.goods_id')->where('g.goods_id', $goods_id)->where('g.is_delete', 0)->first()->toArray();
		$member_price = $this->userRankRepository->getMemberRankPriceByGid($goods_id);
		$uid = $this->authService->authorization();
		$user_rank = \App\Models\User::select('user_rank')->where('user_id', $uid)->first();

		if (!empty($user_rank)) {
			$user_rank = $user_rank->user_rank;
			$user_price = $this->memberPriceRepository->getMemberPriceByUid($user_rank, $goods_id);
			$goods['user_price'] = $user_price;
		}

		$goods['shop_price'] = isset($user_price) && !empty($user_price) ? $user_price : $member_price;
		if (is_array($goods) && array_key_exists('promote_price', $goods) && (0 < $goods['promote_price'])) {
			$promote_price = $this->bargainPrice($goods['promote_price'], $goods['promote_start_date'], $goods['promote_end_date']);
		}
		else {
			$promote_price = 0;
		}

		$user_price = $goods['shop_price'];
		if (empty($volume_price) && empty($promote_price)) {
			$final_price = $user_price;
		}
		else {
			if (!empty($volume_price) && empty($promote_price)) {
				$final_price = min($volume_price, $user_price);
			}
			else {
				if (empty($volume_price) && !empty($promote_price)) {
					$final_price = min($promote_price, $user_price);
				}
				else {
					if (!empty($volume_price) && !empty($promote_price)) {
						$final_price = min($volume_price, $promote_price, $user_price);
					}
					else {
						$final_price = $user_price;
					}
				}
			}
		}

		if ($is_spec_price) {
			if (!empty($property)) {
				$property_price = $this->goodsAttrRepository->propertyPrice($property);
				$final_price += $property_price;
			}
		}

		return $final_price;
	}

	public function getVolumePriceList($goods_id, $price_type = '1')
	{
		$volume_price = array();
		$temp_index = '0';
		$res = $this->volumePriceRepository->allVolumes($goods_id, $price_type);

		foreach ($res as $k => $v) {
			$volume_price[$temp_index] = array();
			$volume_price[$temp_index]['number'] = $v['volume_number'];
			$volume_price[$temp_index]['price'] = $v['volume_price'];
			$volume_price[$temp_index]['format_price'] = price_format($v['volume_price']);
			$temp_index++;
		}

		return $volume_price;
	}

	public function bargainPrice($price, $start, $end)
	{
		if ($price == 0) {
			return 0;
		}
		else {
			$time = time();
			if (($start <= $time) && ($time <= $end)) {
				return $price;
			}
			else {
				return 0;
			}
		}
	}

	public function getBrandIdByGoodsId($goodsId)
	{
		$brandId = \App\Models\Goods::where('goods_id', $goodsId)->pluck('brand_id');

		if (!empty($brandId)) {
			return $brandId[0];
		}
	}
}

?>
