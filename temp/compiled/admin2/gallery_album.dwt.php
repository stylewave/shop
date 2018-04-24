<?php if ($this->_var['full_page']): ?>
<!doctype html>
<html>
<head><?php echo $this->fetch('library/admin_html_head.lbi'); ?></head>

<body class="iframe_body">
	<div class="warpper">
    	<div class="title">商品 - <?php echo $this->_var['ur_here']; ?></div>
        <div class="content">
        	<div class="explanation" id="explanation">
            	<div class="ex_tit">
					<i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span>
                    <?php if ($this->_var['open'] == 1): ?>
                    <div class="view-case">
                    	<div class="view-case-tit"><i></i>查看教程</div>
                        <div class="view-case-info">
                        	<a href="http://help.ecmoban.com/article-6398.html" target="_blank">商城图片库功能说明</a>
                        </div>
                    </div>			
                    <?php endif; ?>				
				</div>
                <ul>
                	<li>展示每个店铺的图片空间列表。</li>
                    <li>平台可查看、编辑、删除商家的图片空间。</li>
                    <li>平台可以对商家违规的图片进行删除。</li>
                </ul>
            </div>
            <div class="flexilist">
            	<!--商品分类列表-->
                <div class="common-head">
                    <div class="fl">
                    	<a href="<?php echo $this->_var['action_link']['href']; ?>"><div class="fbutton"><div class="add" title="<?php echo $this->_var['action_link']['text']; ?>"><span><i class="icon icon-plus"></i><?php echo $this->_var['action_link']['text']; ?></span></div></div></a>
                    </div>
                    <div class="refresh<?php if (! $this->_var['action_link']): ?> ml0<?php endif; ?>">
                    	<div class="refresh_tit" title="刷新数据"><i class="icon icon-refresh"></i></div>
                    	<div class="refresh_span">刷新 - 共<?php echo $this->_var['record_count']; ?>条记录</div>
                    </div>
                    <div class="search">
			<?php echo $this->fetch('library/search_store.lbi'); ?>
                    	<div class="input">
                        	<input type="text" name="album_mame" class="text nofocus" placeholder="相册名称" autocomplete="off" /><button class="btn" name="secrch_btn"></button>
                        </div>
                    </div>
                </div>
                <div class="common-content">
                    <form method="post" action="gallery_album.php" name="listForm" onsubmit="return confirm(batch_drop_confirm);">
                	<div class="list-div" id="listDiv">
                        <?php endif; ?>
                    	<table cellpadding="0" cellspacing="0" border="0">
                            <thead>
                                <tr>
                                    <th width="3%" class="sign"><div class="tDiv"><input type="checkbox" name="all_list" class="checkbox" id="all_list" /><label for="all_list" class="checkbox_stars"></label></div></th>
                                    <th width="5%"><div class="tDiv"><?php echo $this->_var['lang']['record_id']; ?></div></th>
                                    <th width="15%"><div class="tDiv"><?php echo $this->_var['lang']['album_mame']; ?></div></th>
                                    <th width="7%"><div class="tDiv"><?php echo $this->_var['lang']['gallery_count']; ?></div></th>
                                    <th width="15%"><div class="tDiv"><?php echo $this->_var['lang']['shop_name']; ?></div></th>
                                    <th width="15%"><div class="tDiv"><?php echo $this->_var['lang']['album_cover']; ?></div></th>
                                    <th width="15%"><div class="tDiv"><?php echo $this->_var['lang']['album_desc']; ?></div></th>
                                    <th width="10%"><div class="tDiv"><?php echo $this->_var['lang']['sort_order']; ?></div></th>
                                    <th width="15%" class="handle"><?php echo $this->_var['lang']['handler']; ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $_from = $this->_var['gallery_album']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'agency');if (count($_from)):
    foreach ($_from AS $this->_var['agency']):
?>
                            	<tr>
                                    <td class="sign"><div class="tDiv"><input type="checkbox" name="checkboxes[]" class="checkbox" value="<?php echo $this->_var['agency']['album_id']; ?>" id="checkbox_<?php echo $this->_var['agency']['album_id']; ?>" /><label for="checkbox_<?php echo $this->_var['agency']['album_id']; ?>" class="checkbox_stars"></label></div></td>
                                    <td><div class="tDiv"><?php echo $this->_var['agency']['album_id']; ?></div></td>
                                    <td><div class="tDiv"><?php echo htmlspecialchars($this->_var['agency']['album_mame']); ?></div></td>
                                    <td><div class="tDiv"><?php echo nl2br($this->_var['agency']['gallery_count']); ?></div></td>
                                    <td><div class="tDiv red"><?php echo nl2br($this->_var['agency']['shop_name']); ?></div></td>
                                    <td>
                                        <div class="tDiv">
                                            <?php if ($this->_var['agency']['album_cover']): ?>
                                            <span class="show">
                                                <a href="../<?php echo $this->_var['agency']['album_cover']; ?>" class="nyroModal"><i class="icon icon-picture" onmouseover="toolTip('<img src=../<?php echo $this->_var['agency']['album_cover']; ?>>')" onmouseout="toolTip()"></i></a>
                                            </span>
                                            <?php else: ?>
                                            <span class="show">
                                                <a href="#" class="nyroModal"><i class="icon icon-picture" onmouseover="toolTip('<img src=../data/gallery_album/hover_image.png>')" onmouseout="toolTip()"></i></a>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td><div class="tDiv"><?php echo nl2br($this->_var['agency']['album_desc']); ?></div></td>
                                    <td><div class="tDiv"><input type="text" name="sort_order" class="text w40" value="<?php echo $this->_var['agency']['sort_order']; ?>" onkeyup="listTable.editInput(this, 'edit_sort_order', <?php echo $this->_var['agency']['album_id']; ?>)"/></div></td>
                                    <td class="handle">
                                        <div class="tDiv a2">
                                            <a href="gallery_album.php?act=view&id=<?php echo $this->_var['agency']['album_id']; ?>" title="<?php echo $this->_var['lang']['view']; ?>" class="btn_see mr10"><i class="sc_icon sc_icon_see"></i><?php echo $this->_var['lang']['view']; ?></a>
                                            <a href="gallery_album.php?act=edit&id=<?php echo $this->_var['agency']['album_id']; ?>" title="<?php echo $this->_var['lang']['edit']; ?>" class="btn_edit"><i class="icon icon-edit"></i><?php echo $this->_var['lang']['edit']; ?></a>
                                            <a href="javascript:;" onclick="listTable.remove(<?php echo $this->_var['agency']['album_id']; ?>, '确定删除该相册吗？删除后图片无法找回！')" title="<?php echo $this->_var['lang']['remove']; ?>" class="btn_trash"><i class="icon icon-trash"></i><?php echo $this->_var['lang']['remove']; ?></a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; else: ?>
                                <tr><td class="no-records" colspan="12"><?php echo $this->_var['lang']['no_records']; ?></td></tr>
                                <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                            </tbody>
                            <tfoot>
                            	<tr>
                                    <td colspan="12">
                                        <div class="tDiv">
                                        	<div class="tfoot_btninfo">
                                                <input name="act" type="hidden" value="remove_batch" />
                                                <input name="remove" type="submit" ectype="btnSubmit" value="<?php echo $this->_var['lang']['drop']; ?>" class="btn btn_disabled" disabled />
                                            </div>
                                            <div class="list-page">
                                                <?php echo $this->fetch('library/page.lbi'); ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <?php if ($this->_var['full_page']): ?>
                    </div>
                    </form>
                </div>
            </div>
	</div>
	</div>
 <?php echo $this->fetch('library/pagefooter.lbi'); ?>
 
<script type="text/javascript">

listTable.recordCount = '<?php echo $this->_var['record_count']; ?>';
listTable.pageCount = '<?php echo $this->_var['page_count']; ?>';

<?php $_from = $this->_var['filter']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
listTable.filter.<?php echo $this->_var['key']; ?> = '<?php echo $this->_var['item']; ?>';
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    
$(".ps-container").perfectScrollbar();


</script>     
</body>
</html>
<?php endif; ?>
