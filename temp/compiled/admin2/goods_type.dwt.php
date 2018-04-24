<?php if ($this->_var['full_page']): ?>
<!doctype html>
<html>
<head><?php echo $this->fetch('library/admin_html_head.lbi'); ?></head>

<body class="iframe_body">
	<div class="warpper">
    	<div class="title">商品 - <?php echo $this->_var['ur_here']; ?></div>
        <div class="content">		
            <div class="tabs_info">
            	<ul>
                    <li <?php if ($this->_var['act_type'] == 'manage'): ?>class="curr"<?php endif; ?>><a href="<?php echo $this->_var['action_link2']['href']; ?>"><?php echo $this->_var['action_link2']['text']; ?></a></li>
                    <li <?php if ($this->_var['act_type'] == 'cat_list'): ?>class="curr"<?php endif; ?>><a href="<?php echo $this->_var['action_link1']['href']; ?>"><?php echo $this->_var['action_link1']['text']; ?></a></li>
                </ul>
            </div>
        	<div class="explanation" id="explanation">
            	<div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                	<li>该页面展示了商城所有的商品类型。</li>
                    <li>每个商品类型下管理不同的商品属性。</li>
                    <li>可以对商品类型进行编辑和删除操作。</li>
                </ul>
            </div>
            <div class="flexilist">
            	<!--商品列表-->
                <div class="common-head">
                    <div class="fl">
                    	<a href="goods_type.php?act=add"><div class="fbutton"><div class="add" title="新建商品类型"><span><i class="icon icon-plus"></i>新建商品类型</span></div></div></a>
                    </div>				
                    <div class="refresh">
                    	<div class="refresh_tit" title="刷新数据"><i class="icon icon-refresh"></i></div>
                    	<div class="refresh_span">刷新 - 共<?php echo $this->_var['record_count']; ?>条记录</div>
                    </div>
                    <div class="search">
                    	<div id="" class="imitate_select select_w140">
                            <div class="cite"><?php echo $this->_var['lang']['select_please']; ?></div>
                            <ul>
                            	<li><a href="javascript:;" data-value="-1" class="ftx-01"><?php echo $this->_var['lang']['select_please']; ?></a></li>
                                <li><a href="javascript:;" data-value="0" class="ftx-01"><?php echo $this->_var['lang']['platform_self']; ?></a></li>
                                <?php $_from = $this->_var['store_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'store');if (count($_from)):
    foreach ($_from AS $this->_var['store']):
?>
                                <li><a href="javascript:;" data-value="<?php echo $this->_var['store']['ru_id']; ?>" class="ftx-01"><?php echo $this->_var['store']['store_name']; ?></a></li>
                                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                            </ul>
                            <input name="merchant_id" type="hidden" value="-1">
                        </div>
                    	<div class="input">
                        	<input type="text" name="keyword" class="text nofocus w140" placeholder="商品类型名称" autocomplete="off">
							<button class="btn" name="secrch_btn"></button>
                        </div>
                    </div>
                </div>
                <div class="common-content">
                	<div class="list-div" id="listDiv">
						<?php endif; ?>
                    	<table cellpadding="0" cellspacing="0" border="0">
                        	<thead>
                            	<tr>
                                	<th width="5%"><div class="tDiv"><?php echo $this->_var['lang']['record_id']; ?></div></th>
                                    <th width="15%"><div class="tDiv"><?php echo $this->_var['lang']['goods_type_name']; ?></div></th>
                                    <th width="10%"><div class="tDiv"><?php echo $this->_var['lang']['goods_steps_name']; ?></div></th>
                                    <th width="20%"><div class="tDiv"><?php echo $this->_var['lang']['attr_groups']; ?></div></th>
                                    <th width="10%"><div class="tDiv">类型分类</div></th>
                                    <th width="10%"><div class="tDiv"><?php echo $this->_var['lang']['attribute_number']; ?></div></th>
                                    <th width="10%"><div class="tDiv"><?php echo $this->_var['lang']['goods_type_status']; ?></div></th>
                                    <th width="20%" class="handle"><?php echo $this->_var['lang']['handler']; ?></th>
                                </tr>
                            </thead>
                            <tbody>
								<?php $_from = $this->_var['goods_type_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods_type');if (count($_from)):
    foreach ($_from AS $this->_var['goods_type']):
?>
                            	<tr>
                                	<td><div class="tDiv"><?php echo $this->_var['goods_type']['cat_id']; ?></div></td>
                                    <td>
                                        <div class="tDiv">
                                            <?php if ($this->_var['attr_set_up'] == 1): ?>
                                            <span onclick="javascript:listTable.edit(this, 'edit_type_name', <?php echo $this->_var['goods_type']['cat_id']; ?>)"><?php echo $this->_var['goods_type']['cat_name']; ?></span>
                                            <?php else: ?>
                                            <?php echo $this->_var['goods_type']['cat_name']; ?>
                                            <?php endif; ?>
                                        </div>
                                    </td>
									<td>
                                        <div class="tDiv">
                                            <?php if ($this->_var['goods_type']['user_name']): ?><font class="red"><?php echo $this->_var['goods_type']['user_name']; ?></font><?php else: ?><font class="blue3"><?php echo $this->_var['lang']['self']; ?></font><?php endif; ?>
                                        </div>
                                    </td>
									<td><div class="tDiv"><?php echo $this->_var['goods_type']['attr_group']; ?></div></td>
                                                                        <td><div class="tDiv"><?php echo $this->_var['goods_type']['gt_cat_name']; ?></div></td>
                                                                        
									<td><div class="tDiv"><?php echo $this->_var['goods_type']['attr_count']; ?></div></td>
									<td><div class="tDiv"><img src="images/<?php if ($this->_var['goods_type']['enabled']): ?>yes<?php else: ?>no<?php endif; ?>.png" title="<?php echo $this->_var['lang']['click']; ?>" class="pointer"/></div></td>                              
                                    <td class="handle">
                                        <div class="tDiv a3">
                                            <a href="attribute.php?act=list&goods_type=<?php echo $this->_var['goods_type']['cat_id']; ?>" class="btn_see"><i class="sc_icon sc_icon_see"></i><?php echo $this->_var['lang']['attribute']; ?></a>
                                            <?php if ($this->_var['attr_set_up'] == 1): ?>	
                                            <a href="goods_type.php?act=edit&cat_id=<?php echo $this->_var['goods_type']['cat_id']; ?>" class="btn_edit"><i class="icon icon-edit"></i><?php echo $this->_var['lang']['edit']; ?></a>
                                            <a href="javascript:;" onclick="listTable.remove(<?php echo $this->_var['goods_type']['cat_id']; ?>, '<?php echo $this->_var['lang']['remove_confirm']; ?>')" class="btn_trash"><i class="icon icon-trash"></i><?php echo $this->_var['lang']['remove']; ?></a>										
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
								<?php endforeach; else: ?>
								<tr><td class="no-records" colspan="20"><?php echo $this->_var['lang']['no_records']; ?></td></tr>								
								<?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                            </tbody>
                            <tfoot>
                            	<tr>
                                    <td colspan="12">
                                    	<div class="list-page">
                                           <?php echo $this->fetch('library/page.lbi'); ?>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
						<?php if ($this->_var['full_page']): ?>
                    </div>
                </div>
                <!--商品列表end-->
            </div>
		</div>
	</div>
 	<?php echo $this->fetch('library/pagefooter.lbi'); ?>
	<script type="text/javascript" language="JavaScript">
	  listTable.recordCount = '<?php echo $this->_var['record_count']; ?>';
	  listTable.pageCount = '<?php echo $this->_var['page_count']; ?>';

	  <?php $_from = $this->_var['filter']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
	  listTable.filter.<?php echo $this->_var['key']; ?> = '<?php echo $this->_var['item']; ?>';
	  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	</script>
	
</body>
</html>
<?php endif; ?>
