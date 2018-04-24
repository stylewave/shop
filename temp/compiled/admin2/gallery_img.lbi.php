<ul id="ul_pics">
	<?php $_from = $this->_var['img_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('i', 'img');if (count($_from)):
    foreach ($_from AS $this->_var['i'] => $this->_var['img']):
?>
	<li id="gallery_<?php echo $this->_var['img']['img_id']; ?>">
		<div class="img" onclick="img_default(<?php echo $this->_var['img']['img_id']; ?>)"><img src="<?php if ($this->_var['img']['thumb_url']): ?><?php echo $this->_var['img']['thumb_url']; ?><?php else: ?><?php echo $this->_var['img']['img_url']; ?><?php endif; ?>" width="160" height="160" id="external_img_url<?php echo $this->_var['img']['img_id']; ?>" /></div>
		<div class="info">
			<span class="zt red"><?php if ($this->_var['min_img_id'] == $this->_var['img']['img_id']): ?>主图<?php endif; ?></span>
			<div class="sort">
				<span>排序：</span>
				<input type="text" value="<?php echo empty($this->_var['img']['img_desc']) ? $this->_var['lang']['n_a'] : $this->_var['img']['img_desc']; ?>" name="old_img_desc[<?php echo $this->_var['img']['img_id']; ?>]" class="stext" autocomplete="off" onChange="listTable.editInput(this, 'edit_img_desc', <?php echo $this->_var['img']['img_id']; ?>)" />
				<input type="hidden" value="<?php echo htmlspecialchars($this->_var['img']['img_id']); ?>" name="img_id[]" />
			</div>
			<a href="javascript:void(0);" data-imgid="<?php echo $this->_var['img']['img_id']; ?>" class="delete_img"><i class="icon icon-trash"></i></a>
		</div>
        <div class="info"><input name="external_url" type="text" class="text w130 external_url_<?php echo $this->_var['img']['img_id']; ?>" ectype="external_url" value="<?php echo $this->_var['img']['external_url']; ?>" title="<?php echo $this->_var['img']['external_url']; ?>" data-imgid="<?php echo $this->_var['img']['img_id']; ?>" placeholder="图片外部链接地址" onfocus="if (this.value == '图片外部链接地址'){this.value='http://';this.style.color='#000';}"></div>
	</li>
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</ul>