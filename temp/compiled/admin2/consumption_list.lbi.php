<table class="table_div table_heng">
    <tr class="first_tr">
        <td class="first_td">满</td>
        <?php $_from = $this->_var['consumption_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'con');if (count($_from)):
    foreach ($_from AS $this->_var['con']):
?>
        <td>
            <input type="text" name="cfull[]" value="<?php echo $this->_var['con']['cfull']; ?>" class="text w50" autocomplete="off" />
            <input type="hidden" name="c_id[]" value="<?php echo empty($this->_var['con']['id']) ? '0' : $this->_var['con']['id']; ?>" autocomplete="off" />
        </td>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        <td>
        	<input type="text" name="cfull[]" value="" class="text w50" autocomplete="off" />
            <input type="hidden" name="c_id[]" value="0" class="text w50" autocomplete="off" />
        </td>
        <td class="last_td" rowspan="3"><a href="javascript:void(0);" class="addTd" onClick="add_clonetd(this);"></a></td>
    </tr>
    <tr  class="first_tr">
        <td class="first_td">立减</td>
        <?php $_from = $this->_var['consumption_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'con');if (count($_from)):
    foreach ($_from AS $this->_var['con']):
?>
        <td><input type="text" name="creduce[]" value="<?php echo $this->_var['con']['creduce']; ?>" class="text w50" autocomplete="off" /></td>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        <td><input type="text" name="creduce[]" value="" class="text w50" autocomplete="off" /></td>
    </tr>
    <tr>
        <td class="first_td">操作</td>
        <?php $_from = $this->_var['consumption_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'con');if (count($_from)):
    foreach ($_from AS $this->_var['con']):
?>
        <td><a href="javascript:;" class="btn btn25 blue_btn" data-id="<?php echo $this->_var['con']['id']; ?>" ectype="remove_cfull">删除</a></td>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        <td><a href="javascript:;" class="btn btn25 blue_btn" data-id="0" ectype="remove_cfull">删除</a></td>
    </tr>
</table>