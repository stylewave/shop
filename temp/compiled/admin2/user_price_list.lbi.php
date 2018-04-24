<table class="table_div">
	<tr>
		<?php $_from = $this->_var['user_rank_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'user_rank');$this->_foreach['user_rank'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['user_rank']['total'] > 0):
    foreach ($_from AS $this->_var['user_rank']):
        $this->_foreach['user_rank']['iteration']++;
?>
		<th class="th"><?php echo $this->_var['user_rank']['rank_name']; ?></th>
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	</tr>
	<tr>
		<?php $_from = $this->_var['user_rank_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'user_rank');$this->_foreach['user_rank'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['user_rank']['total'] > 0):
    foreach ($_from AS $this->_var['user_rank']):
        $this->_foreach['user_rank']['iteration']++;
?>
		<td class="td">
			<span id="nrank_<?php echo $this->_var['user_rank']['rank_id']; ?>"></span>
			<input type="text" id="rank_<?php echo $this->_var['user_rank']['rank_id']; ?>" name="user_price[]" class="text w50" autocomplete="off" value="<?php echo empty($this->_var['member_price_list'][$this->_var['user_rank']['rank_id']]) ? '-1' : $this->_var['member_price_list'][$this->_var['user_rank']['rank_id']]; ?>" onkeyup="if(parseInt(this.value)<-1){this.value='-1';};set_price_note(<?php echo $this->_var['user_rank']['rank_id']; ?>)" size="8" class="text_3" <?php if (($this->_foreach['user_rank']['iteration'] == $this->_foreach['user_rank']['total'])): ?>style="width:40px;"<?php endif; ?> />
			<input type="hidden" name="user_rank[]" value="<?php echo $this->_var['user_rank']['rank_id']; ?>" />														
		</td>
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	</tr>
</table>