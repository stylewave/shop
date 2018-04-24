<table class="table_div table_heng">
    <tr class="first_tr">
        <td class="first_td">数量</td>
        <?php $_from = $this->_var['volume_price_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'volume_price');$this->_foreach['volume_price_tab'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['volume_price_tab']['total'] > 0):
    foreach ($_from AS $this->_var['volume_price']):
        $this->_foreach['volume_price_tab']['iteration']++;
?>
        <td>
            <input type="text" name="volume_number[]" value="<?php echo $this->_var['volume_price']['number']; ?>" class="text w50 td_num" autocomplete="off" />
            <input type="hidden" name="id[]" value="<?php echo empty($this->_var['volume_price']['id']) ? '0' : $this->_var['volume_price']['id']; ?>" class="text w50" autocomplete="off" />
        </td>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        <?php if (! $this->_var['volume_price_list']): ?>
        <td>
            <input type="text" name="volume_number[]" value="" class="text w50 td_num" />
            <input type="hidden" name="id[]" value="0" autocomplete="off" />
        </td>
        <?php endif; ?>
        <td class="last_td" rowspan="3"><a href="javascript:void(0);" class="addTd" onClick="add_clonetd(this);"></a></td>
    </tr>
    <tr  class="first_tr">
        <td class="first_td">价格</td>
        <?php $_from = $this->_var['volume_price_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'volume_price');$this->_foreach['volume_price_tab'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['volume_price_tab']['total'] > 0):
    foreach ($_from AS $this->_var['volume_price']):
        $this->_foreach['volume_price_tab']['iteration']++;
?>
        <td><input type="text" name="volume_price[]" value="<?php echo $this->_var['volume_price']['price']; ?>" class="text w50" autocomplete="off" /></td>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        <?php if (! $this->_var['volume_price_list']): ?>
        <td><input type="text" name="volume_price[]" value="" class="text w50" /></td>
        <?php endif; ?>
    </tr>
    <tr>
        <td class="first_td">操作</td>
        <?php $_from = $this->_var['volume_price_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'volume_price');$this->_foreach['volume_price_tab'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['volume_price_tab']['total'] > 0):
    foreach ($_from AS $this->_var['volume_price']):
        $this->_foreach['volume_price_tab']['iteration']++;
?>
        <td><a href="javascript:;" class="btn btn25 blue_btn" data-id="<?php echo $this->_var['volume_price']['id']; ?>" ectype="remove_volume">删除</a></td>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        <?php if (! $this->_var['volume_price_list']): ?>
        <td><a href="javascript:;" class="btn btn25 blue_btn" data-id="0" ectype="remove_volume">删除</a></td>
        <?php endif; ?>
    </tr>
</table>