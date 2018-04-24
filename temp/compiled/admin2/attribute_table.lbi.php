<?php if ($this->_var['attr_group']): ?>
<!--<?php if ($this->_var['full_page']): ?>-->
<a href="goods_attr_price.php?act=add&goods_id=<?php echo $this->_var['goods_id']; ?>&goods_type=<?php echo $this->_var['goods_type']; ?>" class="btn btn25 blue_btn ga_price" target="_blank" style="display:none">选择批量上传</a>
<table class="table_head" width="100%">
    <thead>
        <tr>
            <th width="10%"><?php $_from = $this->_var['attribute_array']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'attribute');$this->_foreach['attribute'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['attribute']['total'] > 0):
    foreach ($_from AS $this->_var['attribute']):
        $this->_foreach['attribute']['iteration']++;
?><?php echo $this->_var['attribute']['attr_name']; ?><?php if (! ($this->_foreach['attribute']['iteration'] == $this->_foreach['attribute']['total'])): ?>，<?php endif; ?><?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?></th>
            <th width="5%" <?php if ($this->_var['model_name'] == ''): ?>class="hide"<?php endif; ?>><?php echo $this->_var['model_name']; ?></th>
            <th width="15%" class="hide"><em class="require-field">*</em>市场价<i class="sc_icon sc_icon_edit pointer pro_market"></i></th>
            <th width="8%" <?php if ($this->_var['goods_attr_price'] == 0): ?>class="hide"<?php endif; ?>><em class="require-field">*</em>本店价<i class="sc_icon sc_icon_edit pointer pro_shop"></i></th>
            <th width="8%"><em class="require-field">*</em>库存<i class="sc_icon sc_icon_edit pointer pro_number"></i></th>
            <th width="8%"><em class="require-field">*</em>预警值<i class="sc_icon sc_icon_edit pointer pro_warning"></i></th>
            <th width="10%">商品货号</th>
            <th width="10%">商品条形码</th>
            <th width="5%">操作</th>
        </tr>
    </thead>
</table>
<!--<?php endif; ?>-->
<div id="listDiv">     
    <div class="step_item_table2">
        <table class="table_attr" width="100%">
            <tbody>
                <?php $_from = $this->_var['attr_group']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'group');if (count($_from)):
    foreach ($_from AS $this->_var['group']):
?>
                <?php if ($this->_var['group']['attr_info']): ?>
                <tr>
                    <td class="td_bg_blue" width="10%"><?php $_from = $this->_var['group']['attr_info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'one');$this->_foreach['one'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['one']['total'] > 0):
    foreach ($_from AS $this->_var['one']):
        $this->_foreach['one']['iteration']++;
?><?php echo $this->_var['one']['attr_value']; ?><input type="hidden" name="attr[<?php echo $this->_var['one']['attr_id']; ?>][]" value="<?php echo $this->_var['one']['attr_value']; ?>" /><?php if (! ($this->_foreach['one']['iteration'] == $this->_foreach['one']['total'])): ?>，<?php endif; ?><?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?></td>		
                    <td width="5%" <?php if ($this->_var['region_name'] == ''): ?>class="hide"<?php endif; ?>><?php echo $this->_var['region_name']; ?></td>
                    <td width="15%" class="hide"><input type="text" name="product_market_price[]" class="text w60" autocomplete="off" value="<?php echo empty($this->_var['group']['product_market_price']) ? '0.00' : $this->_var['group']['product_market_price']; ?>" /></td>
                    <td width="8%" <?php if ($this->_var['goods_attr_price'] == 0): ?>class="hide"<?php endif; ?>><input type="text" name="product_price[]" onBlur="listTable.editInput(this, 'edit_product_price', <?php echo empty($this->_var['group']['product_id']) ? '0' : $this->_var['group']['product_id']; ?>, $('#goods_model').val(), 'goods_model');" class="text w60" autocomplete="off" value="<?php echo empty($this->_var['group']['product_price']) ? '0.00' : $this->_var['group']['product_price']; ?>" /></td>
                    <td width="8%"><input type="text" name="product_number[]" onBlur="listTable.editInput(this, 'edit_product_number', <?php echo empty($this->_var['group']['product_id']) ? '0' : $this->_var['group']['product_id']; ?>, $('#goods_model').val(), 'goods_model');" class="text w60" autocomplete="off" value="<?php echo empty($this->_var['group']['product_number']) ? '0' : $this->_var['group']['product_number']; ?>" /></td>
                    <td width="8%"><input type="text" name="product_warn_number[]" onBlur="listTable.editInput(this, 'edit_product_warn_number', <?php echo empty($this->_var['group']['product_id']) ? '0' : $this->_var['group']['product_id']; ?>, $('#goods_model').val(), 'goods_model');" class="text w60" autocomplete="off" value="<?php echo empty($this->_var['group']['product_warn_number']) ? '1' : $this->_var['group']['product_warn_number']; ?>" /></td>
                    <td width="10%"><input type="text" name="product_sn[]" onBlur="listTable.editInput(this, 'edit_product_sn', <?php echo empty($this->_var['group']['product_id']) ? '0' : $this->_var['group']['product_id']; ?>, $('#goods_model').val(), 'goods_model');" class="text w120" autocomplete="off" value="<?php echo $this->_var['group']['product_sn']; ?>" /></td>
                    <td width="10%"><input type="text" name="product_bar_code[]" onBlur="listTable.editInput(this, 'edit_product_bar_code', <?php echo empty($this->_var['group']['product_id']) ? '0' : $this->_var['group']['product_id']; ?>, $('#goods_model').val(), 'goods_model');" class="text w120" autocomplete="off" value="<?php echo $this->_var['group']['bar_code']; ?>" /></td>
                    <td class="handle" width="5%">
                        <?php if ($this->_var['group']['product_id']): ?>
                            <div class="tDiv pl0 a1">
                            <a href="javascript:void(0);" class="btn_trash" onclick="if (confirm('<?php echo $this->_var['lang']['trash_product_confirm']; ?>')) dropProduct('<?php echo $this->_var['group']['product_id']; ?>')"><i class="icon icon-trash"></i>删除</a>
                            </div>
                        <?php else: ?>
                            <?php echo $this->_var['lang']['n_a']; ?>
                        <?php endif; ?>
                        <input type="hidden" name="product_id[]" value="<?php echo empty($this->_var['group']['product_id']) ? '0' : $this->_var['group']['product_id']; ?>" />
                    </td>
                </tr>
                <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </tbody>
        </table>
        <input name="group_attr" type="hidden" value='<?php echo $this->_var['group_attr']; ?>'>
    </div>
    
    <!--<?php if ($this->_var['filter']['page_count'] > 1): ?>-->
    <div id="turn-page" class="attr-turn-page">
        <div class="pagination">
            <ul>
                <li><?php if ($this->_var['filter']['page'] != 1): ?><a href="javascript:listTable.gotoPageFirst()"><?php endif; ?><span>首页</span><?php if ($this->_var['filter']['page'] != 1): ?></a><?php endif; ?></li>
                <li<?php if ($this->_var['filter']['page'] == 1): ?> class="curr"<?php endif; ?>><?php if ($this->_var['filter']['page'] != 1): ?><a href="javascript:listTable.gotoPagePrev()"><?php endif; ?><span class="prev">上一页</span><?php if ($this->_var['filter']['page'] != 1): ?></a><?php endif; ?></li>
                <?php $_from = $this->_var['page_count_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'page_count');$this->_foreach['pageCount'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['pageCount']['total'] > 0):
    foreach ($_from AS $this->_var['page_count']):
        $this->_foreach['pageCount']['iteration']++;
?>
                <?php if ($this->_var['page_count'] == $this->_var['filter']['page']): ?>
                    <li><span class="currentpage"><?php echo $this->_var['page_count']; ?></span></li>
                <?php else: ?>
                    <li><a href="javascript:listTable.gotoPage(<?php echo $this->_var['page_count']; ?>)"><span><?php echo $this->_var['page_count']; ?></span></a></li>
                <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <li<?php if ($this->_var['filter']['page'] == $this->_var['filter']['page_count']): ?> class="curr"<?php endif; ?>><?php if ($this->_var['filter']['page'] != $this->_var['filter']['page_count']): ?><a href="javascript:listTable.gotoPageNext()"><?php endif; ?><span class="next">下一页</span><?php if ($this->_var['filter']['page'] != $this->_var['filter']['page_count']): ?></a><?php endif; ?></li>
                <li><?php if ($this->_var['filter']['page'] != $this->_var['filter']['page_count']): ?><a href="javascript:listTable.gotoPageLast()" class="last"><?php endif; ?><span>末页</span><?php if ($this->_var['filter']['page'] != $this->_var['filter']['page_count']): ?></a><?php endif; ?></li>
            </ul>
        </div>    
    </div>
    <!--<?php endif; ?>-->
    <span class="goods_attr_04_explain">（说明：含有两页以上请用批量上传功能）</span>
    <div class="goods_attr_04_batch">
        <?php if ($this->_var['goods_model'] == 1): ?>
            <a href="javascript:;" class="btn btn35 red_btn" id="produts_warehouse_batch">CSV批量上传</a>
        <?php elseif ($this->_var['goods_model'] == 2): ?>
            <a href="javascript:;" class="btn btn35 red_btn" id="produts_area_batch">CSV批量上传</a>
        <?php else: ?>
            <a href="javascript:;" class="btn btn35 red_btn" id="produts_batch">CSV批量上传</a>
        <?php endif; ?>
        <a href="javascript:;" class="btn btn35 red_btn ml20" id="attr_refresh">刷新</a>
    </div> 
    <input name="arrt_page_count" type="hidden" value='<?php echo $this->_var['filter']['page_count']; ?>'>
</div>

<!--<?php if ($this->_var['full_page']): ?>-->
	<script type="text/javascript">
	
	<!--<?php if ($this->_var['filter']['page_count'] > 1): ?>-->
    listTable.recordCount = <?php echo $this->_var['filter']['record_count']; ?>;
    listTable.pageCount = <?php echo $this->_var['filter']['page_count']; ?>;
    listTable.query = "goods_attribute_query";
    
    <?php $_from = $this->_var['filter']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
    listTable.filter.<?php echo $this->_var['key']; ?> = '<?php echo $this->_var['item']; ?>';
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    <!--<?php endif; ?>-->
	
    $(function(){
        /**
        *货品市场价
        */
        $(".pro_market").click(function(){
            var val = $("form[name='theForm'] :input[name='product_market_price[]']").get(0).value;
            $("form[name='theForm'] :input[name='product_market_price[]']").val(val);
        });
        
        /**
        *货品本店价
        */
        $(".pro_shop").click(function(){
            var val = $("form[name='theForm'] :input[name='product_price[]']").get(0).value;
            $("form[name='theForm'] :input[name='product_price[]']").val(val);
        });
        
        /**
        *货品库存
        */
        $(".pro_number").click(function(){
            var val = $("form[name='theForm'] :input[name='product_number[]']").get(0).value;
            $("form[name='theForm'] :input[name='product_number[]']").val(val);
        });
        
        /**
        *货品库存预警值
        */
        $(".pro_warning").click(function(){
            var val = $("form[name='theForm'] :input[name='product_warn_number[]']").get(0).value;
            $("form[name='theForm'] :input[name='product_warn_number[]']").val(val);
        });
    });
    </script>
<!--<?php endif; ?>-->
<?php endif; ?>