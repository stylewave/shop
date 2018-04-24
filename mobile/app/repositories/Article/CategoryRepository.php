<?php
//zend by QQ:2172298892  瑾梦网络  禁止倒卖 一经发现停止任何服务
namespace App\Repositories\Article;

class CategoryRepository implements \App\Contracts\Repository\Article\CategoryRepositoryInterface
{
	public function all($cat_id = 0, $columns = array('*'), $size = 100)
	{
		if (is_array($cat_id)) {
			$field = key($cat_id);
			$value = $cat_id[$field];
			$model = \App\Models\ArticleCat::where($field, '=', $value);
		}
		else {
			$model = \App\Models\ArticleCat::where('parent_id', $cat_id);
		}

		return $model->orderBy('sort_order')->orderBy('cat_id')->paginate($size, $columns)->toArray();
	}

	public function detail($cat_id, $columns = array('*'))
	{
		if (is_array($cat_id)) {
			$field = key($cat_id);
			$value = $cat_id[$field];
			$model = \App\Models\ArticleCat::where($field, '=', $value)->first($columns);
		}
		else {
			$model = \App\Models\ArticleCat::find($cat_id, $columns);
		}

		return $model->toArray();
	}

	public function create(array $data)
	{
		return false;
	}

	public function update(array $data)
	{
		return false;
	}

	public function delete($id)
	{
		return false;
	}
}

?>
