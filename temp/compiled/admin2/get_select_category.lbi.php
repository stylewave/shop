<li data-cat_name="" data-cat_id="0" data-cat_level="<?php echo $this->_var['cat_level']; ?>"><a href="javascript:void(0);"><i class="sc_icon"></i>请选择分类</a></li>
<?php $_from = $this->_var['category_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'category');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['category']):
?>
<li <?php if ($this->_var['category']['is_selected']): ?>class="current"<?php endif; ?> data-goodsid="<?php echo empty($this->_var['goods']['goods_id']) ? '0' : $this->_var['goods']['goods_id']; ?>" data-cat_id="<?php echo $this->_var['category']['cat_id']; ?>" data-cat_name="<?php echo $this->_var['category']['cat_name']; ?>" data-cat_level="<?php echo $this->_var['cat_level']; ?>">
<a href="javascript:void(0);"><i class="sc_icon"></i><?php echo $this->_var['category']['cat_name']; ?></a>
</li>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>