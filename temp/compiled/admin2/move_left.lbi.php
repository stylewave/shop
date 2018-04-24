<ul>
	<?php $_from = $this->_var['filter_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'filter');if (count($_from)):
    foreach ($_from AS $this->_var['filter']):
?>
	<li data-value="<?php echo $this->_var['filter']['value']; ?>" data-text="<?php echo $this->_var['filter']['text']; ?>"><i class="sc_icon sc_icon_ok"></i><a href="javascript:void(0);"><?php echo $this->_var['filter']['text']; ?></a></li>
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</ul>