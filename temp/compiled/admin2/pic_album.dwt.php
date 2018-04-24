<?php if ($this->_var['full_page']): ?>
<!doctype html>
<html>
<head><?php echo $this->fetch('library/admin_html_head.lbi'); ?></head>

<body class="iframe_body">
	<div class="warpper">
    	<div class="title">商品 - <?php echo $this->_var['ur_here']; ?></div>
        <div class="content">
        	<div class="explanation" id="explanation">
            	<div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                	<li>该页面展示了所有办事处的信息。</li>
                    <li>可删除、编辑办事处。</li>
                </ul>
            </div>
            <div class="flexilist">
            	<!--商品分类列表-->
                <div class="common-head">
                    <div class="fl">
                    	<a href="javascript:void(0)" <?php echo $this->_var['action_link']['spec']; ?> date-id="<?php echo $this->_var['album_id']; ?>"><div class="fbutton"><div class="add" title="<?php echo $this->_var['action_link']['text']; ?>"><span><i class="icon icon-plus"></i><?php echo $this->_var['action_link']['text']; ?></span></div></div></a>
                    </div>
                    <div class="refresh<?php if (! $this->_var['action_link']): ?> ml0<?php endif; ?>">
                    	<div class="refresh_tit" title="刷新数据"><i class="icon icon-refresh"></i></div>
                    	<div class="refresh_span">刷新 - 共<?php echo $this->_var['record_count']; ?>条记录</div>
                    </div>
                </div>
                <div class="common-content">
                    <form method="post" action="gallery_album.php" name="listForm">
                	<div class="list-div" id="listDiv">
                        <?php endif; ?>
                        <table cellpadding="0" cellspacing="0" border="0">
                            <tbody>
                            	<tr>
                                    <td>
                                        <div class="pic-container">
                                            <div class="pic-items">
                                                <?php $_from = $this->_var['pic_album']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'agency');if (count($_from)):
    foreach ($_from AS $this->_var['agency']):
?>
                                                <div class="item" id="pic_<?php echo $this->_var['agency']['pic_id']; ?>">
                                                    <div class="image">
                                                        <div class="base-msg">
                                                            <div class="img-container"><img src="<?php echo $this->_var['agency']['pic_file']; ?>" /></div>
                                                            <div class="checkbox_item">
                                                                <input type="checkbox" name="checkboxes[]" value="<?php echo $this->_var['agency']['pic_id']; ?>" class="ui-checkbox" id="checkbox_<?php echo $this->_var['agency']['pic_id']; ?>" />
                                                                <label for="checkbox_<?php echo $this->_var['agency']['pic_id']; ?>" class="ui-label"></label>
                                                            </div>
                                                            <div class="img-width"><?php echo $this->_var['agency']['pic_spec']; ?>(<?php echo $this->_var['agency']['pic_size']; ?>)</div>
                                                            <div class="img-handle">
                                                                <a href="javaScript:void(0);" class="btn_see" onclick="album_move('<?php echo $this->_var['agency']['pic_id']; ?>')"><i class="sc_icon icon-move"></i>转移相册</a>
                                                                <a href="javaScript:void(0);" class="btn_see" onclick="remove_pic('<?php echo $this->_var['agency']['pic_id']; ?>')"><i class="sc_icon icon-trash"></i>移除</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <i class="icon icon-remove"  onclick="remove_pic('<?php echo $this->_var['agency']['pic_id']; ?>')"></i>
                                                </div>
                                                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="12">
                                        <div class="tDiv">
                                            <div class="tfoot_btninfo">
                                              <div class="shenhe">
                                              	<div class="checkbox_item fl font12 mt5 mr5">
                                                	<input type="checkbox" name="all_list" class="ui-checkbox" id="all_list" /><label for="all_list" class="ui-label">全选</label>
                                                </div>
                                                <div id="remove_type" class="imitate_select select_w120">
                                                    <div class="cite"><?php echo $this->_var['lang']['drop']; ?></div>
                                                    <ul>
                                                        <li><a href="javascript:;" data-value="remove" class="ftx-01"><?php echo $this->_var['lang']['drop']; ?></a></li>
                                                        <li><a href="javascript:;" data-value="transfer" class="ftx-01">转移相册</a></li>
                                                    </ul>
                                                    <input name="type" type="hidden" value="remove" id="type_value">
                                                </div>
                                                <div id="album_id" class="imitate_select select_w120" style="display:none">
                                                    <div class="cite"><?php echo $this->_var['lang']['select_please']; ?></div>
                                                    <ul>
                                                        <li><a href="javascript:;" data-value="-1" class="ftx-01"><?php echo $this->_var['lang']['select_please']; ?></a></li>
                                                        <?php $_from = $this->_var['album_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
                                                        <li><a href="javascript:;" data-value="<?php echo $this->_var['list']['album_id']; ?>" class="ftx-01"><?php echo $this->_var['list']['album_mame']; ?></a></li>
                                                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                                    </ul>
                                                    <input name="album_id" type="hidden" value="-1">
                                                </div>
                                                  <input type="hidden" name="act" value="batch" />
                                                  <input type="hidden" name="old_album_id" value="<?php echo $this->_var['album_id']; ?>" />
                                                  <input type="submit" name="drop" id="btnSubmit" value="<?php echo $this->_var['lang']['button_submit']; ?>" class="btn" ectype="btnSubmit" />
                                              </div>
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
	<?php echo $this->smarty_insert_scripts(array('files'=>'../js/plupload.full.min.js,spectrum-master/spectrum.js,jquery.purebox.js')); ?>
	<script type="text/javascript">
    listTable.recordCount = '<?php echo $this->_var['record_count']; ?>';
    listTable.pageCount = '<?php echo $this->_var['page_count']; ?>';
    listTable.query = 'pic_query';
    
    <?php $_from = $this->_var['filter']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
    listTable.filter.<?php echo $this->_var['key']; ?> = '<?php echo $this->_var['item']; ?>';
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        
    $(".ps-container").perfectScrollbar();
    
    $.divselect("#remove_type","#type_value",function(obj){
        var val = obj.attr("data-value");
        if(val == 'transfer'){
            $("#album_id").show()
        }else{
            $("#album_id").hide();
        }
    });
    
    /*添加图片*/
    $(document).on("click","a[ectype='addpic_album']",function(){
		var album_id ="<?php echo $this->_var['album_id']; ?>";
		$.jqueryAjax('dialog.php', 'is_ajax=1&act=pic_album' + '&id=' + album_id + '&temp=addBatchWarehouse', function(data){
			var content = data.content;
			pb({
				id:"categroy_dialog",
				title:"上传图片",
				width:788,
				content:content,
				ok_title:"确定",
				drag:false,
				foot:false,
				cl_cBtn:false,
			});
			
		});
	});
	
	function remove_pic(id){
		if(confirm("确定删除吗？")){
			Ajax.call('gallery_album.php', "act=pic_remove&id=" + id, remove_picResponse, 'POST', 'JSON');
		}
	}
	   
	function remove_picResponse(data){
		if(data.error == 0){
			$("#pic_"+data.id).remove();
		}else{
			alert(data.content);
		}
	}
    
    //鼠标停留出发显示
    $(document).on("mouseover",".image",function(){
		$(this).find(".img-width").hide();
		$(this).find(".img-handle").show();
    })
	
    $(document).on("mouseout",".image",function(){
        $(this).find(".img-width").show();
        $(this).find(".img-handle").hide();
    })
    
	function album_move(pic_id){
		if(pic_id > 0){
			Ajax.call('dialog.php', 'act=album_move' + '&pic_id=' + pic_id, album_moveResponse, 'POST', 'JSON');
		}else{
			alert("请选择转移图片！");
		}
	}
    
	function album_moveResponse(result){
		var content = result.content;
		pb({
			id: "album_move",
			title: "转移相册",
			width: 600,
			content: content,
			ok_title: "确定",
			drag: true,
			foot: true,
			cl_cBtn: false,
			onOk: function () {
				var album_id = $("#album_move").find("input[name='album_id']").val();
				if(album_id != result.old_album_id && album_id != 0){
					Ajax.call('get_ajax_content.php', 'act=album_move_back' + '&pic_id=' + result.pic_id + "&album_id=" + album_id, album_move_backResponse, 'POST', 'JSON');
				}
			}
		});
	}
	
	function album_move_backResponse(result){
		if(result.pic_id > 0){
			$("#pic_"+result.pic_id).remove();
		}
	}
    </script>
</body>
</html>
<?php endif; ?>
