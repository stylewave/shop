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
                    <li>供货商隶属于管理员下级的角色，请注意勾选管理员。</li>
                    <li>标识“<em>*</em>”的选项为必填项，其余为选填项。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="mian-info">
                    <form method="post" action="gallery_album.php" name="theForm" enctype="multipart/form-data"  id="album_form">
                        <div class="switch_info user_basic" style="display:block;">
                            <div class="item">
                                <div class="label"><?php echo $this->_var['lang']['require_field']; ?>&nbsp;<?php echo $this->_var['lang']['album_mame']; ?>：</div>
                                <div class="label_value">
                                    <input type="text" name='album_mame' value='<?php echo $this->_var['album_info']['album_mame']; ?>' class="text" autocomplete="off" />
                                    <div class="form_prompt"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label"><?php echo $this->_var['lang']['album_cover']; ?>：</div>
                                <div class="label_value">
                                    <div class="type-file-box">
                                        <input type="button" name="button" id="button" class="type-file-button" value="" />
                                        <input type="file" class="type-file-file"  name="album_cover" data-state="imgfile" size="30" hidefocus="true" value="" />
                                        <?php if ($this->_var['album_info']['album_cover']): ?>
                                        <span class="show">
                                            <a href="../<?php echo $this->_var['album_info']['album_cover']; ?>" target="_blank" class="nyroModal"><i class="icon icon-picture" onmouseover="toolTip('<img src=../<?php echo $this->_var['album_info']['album_cover']; ?>>')" onmouseout="toolTip()"></i></a>
                                        </span>
                                        <?php endif; ?>
                                        <input type="hidden" name="file_url" value="<?php echo $this->_var['album_info']['album_cover']; ?>" class="type-file-text"  autocomplete="off" readonly />
                                    </div>
                                    <div class="form_prompt"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label"><?php echo $this->_var['lang']['album_desc']; ?>：</div>
                                <div class="label_value">
                                    <textarea class="textarea" name="album_desc" id="role_describe"><?php echo $this->_var['album_info']['album_desc']; ?></textarea>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label"><?php echo $this->_var['lang']['sort_order']; ?>：</div>
                                <div class="label_value">
                                    <input type="text" name='sort_order' value='<?php if ($this->_var['album_info']['sort_order']): ?><?php echo $this->_var['album_info']['sort_order']; ?><?php else: ?>50<?php endif; ?>' class="text" autocomplete="off" id="suppliers_name"/>
                                    <div class="form_prompt"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label">&nbsp;</div>
                                <div class="label_value info_btn">
                                    <a href="javascript:;" class="button" id="submitBtn"><?php echo $this->_var['lang']['button_submit']; ?></a>
                                    <input type="hidden" name="act" value="<?php echo $this->_var['form_action']; ?>" />
                                    <input type="hidden" name="id" value="<?php echo $this->_var['album_info']['album_id']; ?>" />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php echo $this->fetch('library/pagefooter.lbi'); ?>
    
    <script type="text/javascript">
	$(function(){
		$(".move_list").perfectScrollbar(); //滚动轴
		
		$("#submitBtn").click(function(){
			if($("#album_form").valid()){
				$("#album_form").submit();
			}
		});
	
		$('#album_form').validate({
			errorPlacement:function(error, element){
				var error_div = element.parents('div.label_value').find('div.form_prompt');
				element.parents('div.label_value').find(".notic").hide();
				error_div.append(error);
			},
			rules : {
				album_mame : {
					required : true
				}	
			},
			messages : {
				album_mame : {
					required : '<i class="icon icon-exclamation-sign"></i>'+album_mame_null
				}
			}
		});
	});
    </script>
</body>
</html>
