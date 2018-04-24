<!doctype html>
<html>
<head><?php echo $this->fetch('library/admin_html_head.lbi'); ?></head>
 
<body class="iframe_body">
	<div class="warpper">
    	<div class="title"><a href="<?php echo $this->_var['action_link']['href']; ?>" class="s-back"><?php echo $this->_var['lang']['back']; ?></a>系统设置 - <?php echo $this->_var['ur_here']; ?></div>
            <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>请认真填写链接名称、链接地址等信息。</li>
                    <li>标识“<em>*</em>”的选项为必填项，其余为选填项。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="mian-info">
                    <form action="friend_partner.php" method="post" name="theForm" enctype="multipart/form-data"  id="link_form">
                        <div class="switch_info user_basic">
                            <div class="item">
                                <div class="label"><?php echo $this->_var['lang']['require_field']; ?><?php echo $this->_var['lang']['link_name']; ?>：</div>
                                <div class="label_value">
                                    <input type="text" name='link_name' value='<?php echo htmlspecialchars($this->_var['link_arr']['link_name']); ?>' class="text" autocomplete="off"/>
                                    <div class="notic m20"><?php echo $this->_var['lang']['link_name_desc']; ?></div>
                                    <div class="form_prompt"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label"><?php echo $this->_var['lang']['require_field']; ?><?php echo $this->_var['lang']['link_url']; ?>：</div>
                                <div class="label_value">
                                    <input type="text" name='link_url' value='<?php echo htmlspecialchars($this->_var['link_arr']['link_url']); ?>' class="text" autocomplete="off"/>
                                    <div class="form_prompt"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label"><?php echo $this->_var['lang']['show_order']; ?>：</div>
                                <div class="label_value">
                                    <input type="text" name='show_order' <?php if ($this->_var['link_arr']['show_order']): ?> value="<?php echo $this->_var['link_arr']['show_order']; ?>" <?php else: ?> value="50" <?php endif; ?> class="text" autocomplete="off"/>
                                </div>
                            </div>
                            
                            <div class="item shop_logo" >
                                <div class="label"><?php echo $this->_var['lang']['link_logo']; ?>：</div>
                                <div class="label_value">
                                    <div class="type-file-box">
                                        <input type="button" name="button" id="button" class="type-file-button" value="">
                                        <input type="file" class="type-file-file" id="legal_person_fileImg" name="link_img" data-state="imgfile" size="30" hidefocus="true" value="">
                                        <?php if ($this->_var['link_logo']): ?>
                                        <span class="show">
                                        	<a href="../<?php echo $this->_var['link_logo']; ?>" target="_blank" class="nyroModal"><i class="icon icon-picture" onmouseover="toolTip('<img src=../<?php echo $this->_var['link_logo']; ?>>')" onmouseout="toolTip()"></i></a>
                                        </span>
										<span class="show"><a href="javascript:;" onclick="delPic(<?php echo $this->_var['link_arr']['link_id']; ?>)" >删除</a></span>
                                        <?php endif; ?>
                                        <input type="text" name="textfile" class="type-file-text" <?php if ($this->_var['link_logo']): ?>value="../<?php echo $this->_var['link_logo']; ?>"<?php endif; ?> id="textfield" readonly>
                                    </div>
                                    <div class="notic m20"><?php echo $this->_var['lang']['logo_notice']; ?></div>
                                </div>
                            </div>
                            
                            <div class="item">
                                <div class="label"><?php echo $this->_var['lang']['url_logo']; ?>：</div>
                                <div class="label_value">
                                    <input type="text" name='url_logo'  class="text" autocomplete="off" value="<?php echo $this->_var['link_logo']; ?>"/>
                                    <div class="notic m20"><?php echo $this->_var['lang']['url_logo_value']; ?></div>
                                </div>
                            </div>
                      
                            <div class="item">
                                <div class="label">&nbsp;</div>
                                <div class="label_value info_btn">
                                    <input type="submit" value="<?php echo $this->_var['lang']['button_submit']; ?>" class="button"  id="submitBtn"/>
                                    <input type="hidden" name="act" value="<?php echo $this->_var['form_act']; ?>" />
                                    <input type="hidden" name="id" value="<?php echo $this->_var['link_arr']['link_id']; ?>" />
                                    <input type="hidden" name="type" value="<?php echo $this->_var['type']; ?>" />
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
			//点击查看图片
			$('.nyroModal').nyroModal();
			
            $("#submitBtn").click(function(){
				if($("#link_form").valid()){
					$("#link_form").submit();
				}
            });

            $('#link_form').validate({
				errorPlacement:function(error, element){
					var error_div = element.parents('div.label_value').find('div.form_prompt');
					element.parents('div.label_value').find(".notic").hide();
					error_div.append(error);
				},
				rules : {
					link_name : {
						required : true
					},
					link_url : {
						required : true
					}
				},
				messages : {
					link_name : {
						required : '<i class="icon icon-exclamation-sign"></i>'+link_name_empty
					},
					link_url : {
						required : '<i class="icon icon-exclamation-sign"></i>'+link_url_empty
					}
				}
            });
        });
		
		function delPic(id){
			if(window.confirm('你确定要删除该图片吗？')){
				Ajax.call('friend_partner.php?is_ajax=1&act=delPic&link_id=' + id,'',Response,'GET','JSON');
			}
			
		}
		function Response(result){
			if(result.error == 0){
				location.reload(true);
			}
		}
		
    </script>
</body>
</html>
