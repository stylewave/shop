<!doctype html>
<html>
<head><?php echo $this->fetch('library/admin_html_head.lbi'); ?></head>

<body class="iframe_body">
	<div class="warpper">
    	<div class="title"><a href="<?php echo $this->_var['action_link']['href']; ?>" class="s-back"><?php echo $this->_var['lang']['back']; ?></a>商品 - <?php echo $this->_var['ur_here']; ?></div>
        <div class="content">
        	<div class="explanation" id="explanation">
            	<div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                	<li>标识“<em>*</em>”的选项为必填项，其余为选填项。</li>
                    <li>请合理创建商品类型名称。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="common-content">
                    <div class="mian-info">
                        <form action="goods_type.php" method="post" name="theForm" enctype="multipart/form-data" id="goods_type_form">
                            <div class="switch_info">
                                <div class="item">
                                    <div class="label"><?php echo $this->_var['lang']['require_field']; ?>&nbsp;<?php echo $this->_var['lang']['goods_type_name']; ?>：</div>
                                    <div class="label_value">
										<input type="text" name="cat_name" value="<?php echo htmlspecialchars($this->_var['goods_type']['cat_name']); ?>" size="40" class="text" autocomplete="off" />
                                    	<div class="form_prompt"></div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="label"><?php echo $this->_var['lang']['the_cat']; ?>：</div>
                                    <div ectype="type_cat">
                                        <div id="parent_id1" class="imitate_select select_w145">
                                            <div class="cite"><?php echo $this->_var['lang']['top_level']; ?></div>
                                            <ul>
                                                <li><a href="javascript:;" data-value="0" data-level='1' class="ftx-01"><?php echo $this->_var['lang']['top_level']; ?></a></li>
                                                <?php $_from = $this->_var['cat_level']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');if (count($_from)):
    foreach ($_from AS $this->_var['cat']):
?>
                                                <li><a href="javascript:;" data-value="<?php echo $this->_var['cat']['cat_id']; ?>" data-level="<?php echo $this->_var['cat']['level']; ?>" class="ftx-01"><?php echo $this->_var['cat']['cat_name']; ?></a></li>
                                                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                            </ul>
                                            <input type="hidden" value="<?php echo empty($this->_var['cat_tree1']['checked_id']) ? '0' : $this->_var['cat_tree1']['checked_id']; ?>" id="parent_id_val1">
                                        </div>
                                         <?php if ($this->_var['cat_tree1']['arr']): ?>
                                        <div id="parent_id2" class="imitate_select select_w145">
                                            <div class="cite">请选择</div>
                                            <ul>
                                                <li><a href="javascript:;" data-value="0" data-level='2' class="ftx-01">请选择</a></li>
                                                <?php $_from = $this->_var['cat_tree1']['arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');if (count($_from)):
    foreach ($_from AS $this->_var['cat']):
?>
                                                <li><a href="javascript:;" data-value="<?php echo $this->_var['cat']['cat_id']; ?>" data-level="<?php echo $this->_var['cat']['level']; ?>" class="ftx-01"><?php echo $this->_var['cat']['cat_name']; ?></a></li>
                                                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                            </ul>
                                            <input type="hidden" value="<?php echo empty($this->_var['cat_tree']['checked_id']) ? '0' : $this->_var['cat_tree']['checked_id']; ?>" id="parent_id_val2">
                                        </div>
                                        <?php endif; ?>
                                         <?php if ($this->_var['cat_tree']['arr']): ?>
                                        <div id="parent_id<?php if ($this->_var['cat_tree1']['arr']): ?>3<?php else: ?>2<?php endif; ?>" class="imitate_select select_w145">
                                            <div class="cite">请选择</div>
                                            <ul>
                                                <li><a href="javascript:;" data-value="0" data-level='<?php if ($this->_var['cat_tree1']['arr']): ?>3<?php else: ?>2<?php endif; ?>' class="ftx-01">请选择</a></li>
                                                <?php $_from = $this->_var['cat_tree']['arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');if (count($_from)):
    foreach ($_from AS $this->_var['cat']):
?>
                                                <li><a href="javascript:;" data-value="<?php echo $this->_var['cat']['cat_id']; ?>" data-level="<?php echo $this->_var['cat']['level']; ?>" class="ftx-01"><?php echo $this->_var['cat']['cat_name']; ?></a></li>
                                                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                            </ul>
                                            <input type="hidden" value="<?php echo empty($this->_var['goods_type']['c_id']) ? '0' : $this->_var['goods_type']['c_id']; ?>" id="parent_id_val<?php if ($this->_var['cat_tree1']['arr']): ?>3<?php else: ?>2<?php endif; ?>">
                                        </div>
                                        <?php endif; ?>
                                        <input name="parent_id" type="hidden" value="<?php echo empty($this->_var['goods_type']['c_id']) ? '0' : $this->_var['goods_type']['c_id']; ?>">
                                    </div>
                                </div>
                                <div class="item" style="display:none">
                                    <div class="label"><?php echo $this->_var['lang']['goods_type_status']; ?>:</div>
                                    <div class="label_value">
										<?php echo $this->html_radios(array('name'=>'enabled','options'=>$this->_var['lang']['arr_goods_status'],'checked'=>$this->_var['goods_type']['enabled'])); ?>
                                    </div>
                                </div>								
                                <div class="item">
                                    <div class="label"><?php echo $this->_var['lang']['attr_groups']; ?>：</div>
                                    <div class="label_value">
										<textarea name="attr_group" rows="5" cols="40" class="textarea"><?php echo htmlspecialchars($this->_var['goods_type']['attr_group']); ?></textarea>
										<p class="fl bf100"><label class="blue_label ml0" id="noticeAttrGroups"><?php echo $this->_var['lang']['notice_attr_groups']; ?></label></p>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="label">&nbsp;</div>
                                    <div class="label_value info_btn">
										<input type="hidden" name="cat_id" value="<?php echo $this->_var['goods_type']['cat_id']; ?>" />
										<input type="submit" value="<?php echo $this->_var['lang']['button_submit']; ?>" class="button" id="submitBtn" />
										<input type="reset" value="<?php echo $this->_var['lang']['button_reset']; ?>" class="button button_reset" />
										<input type="hidden" name="act" value="<?php echo $this->_var['form_act']; ?>" />
                                    </div>
                                </div>								
                            </div>
                        </form>
                    </div>
                </div>
            </div>
		</div>
    </div>
 <?php echo $this->fetch('library/pagefooter.lbi'); ?>
	<script type="text/javascript">
	$(function(){
		//表单验证
		$("#submitBtn").click(function(){
			if($("#goods_type_form").valid()){
				$("#goods_type_form").submit();
			}
		});
	
		$('#goods_type_form').validate({
			errorPlacement:function(error, element){
				var error_div = element.parents('div.label_value').find('div.form_prompt');
				element.parents('div.label_value').find(".notic").hide();
				error_div.append(error);
			},
			rules:{
				cat_name:{
					required : true
				}
			},
			messages:{
				cat_name:{
					required : '<i class="icon icon-exclamation-sign"></i>'+type_name_empty
				}
			}			
		});
	});	
         $.divselect("#parent_id1","#parent_id_val1",function(obj){
            get_childcat(obj,1);
        });
        $.divselect("#parent_id3","#parent_id_val3",function(obj){
            var val = obj.attr("data-value");
            $("input[name='parent_id']").val(val);
        });
        $.divselect("#parent_id2","#parent_id_val2",function(obj){
             get_childcat(obj,1);
        });
	</script>
</body>
</html>
