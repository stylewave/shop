<!doctype html>
<html>
<head><?php echo $this->fetch('library/admin_html_head.lbi'); ?></head>

<body class="iframe_body">
	<div class="warpper">
    	<div class="title">系统设置 - <?php echo $this->_var['ur_here']; ?></div>

        <div class="content">
        	<div class="explanation" id="explanation">
            	<div class="ex_tit">
					<i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span>
                    <?php if ($this->_var['open'] == 1): ?>
                    <div class="view-case">
                    	<div class="view-case-tit"><i></i>查看教程</div>
                        <div class="view-case-info">
                        	<a href="http://help.ecmoban.com/article-6897.html" target="_blank">商城站点地图说明</a>
                        </div>
                    </div>			
                    <?php endif; ?>	
				</div>
                <ul>
                	<li>设置站点地图更新频率和时间。</li>
                    <li>网站地图中定义的更新时间是能够让蜘蛛规律性的来爬取整个网站，检查网站有没有更新的文章或者帖子。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="common-content">
                    <div class="mian-info">
                        <form method="POST" action="" name="theForm">
                            <div class="switch_info">
                                <div class="item">
                                    <div class="label"><?php echo $this->_var['lang']['homepage_changefreq']; ?>：</div>
                                    <div class="label_value">
										<div id="" class="imitate_select select_w120">
											<div class="cite">请选择</div>
											<ul>
												<?php $_from = $this->_var['arr_changefreq']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'data');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['data']):
?>
												<li><a href="javascript:;" data-value="<?php echo $this->_var['data']; ?>" class="ftx-01"><?php echo $this->_var['data']; ?></a></li>
												<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
											</ul>
											<input name="homepage_priority" type="hidden" value="<?php echo $this->_var['config']['homepage_priority']; ?>" id="">
										</div>
										<div id="" class="imitate_select select_w120">
											<div class="cite">请选择</div>
											<ul>
												<?php $_from = $this->_var['lang']['priority']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'data');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['data']):
?>
												<li><a href="javascript:;" data-value="<?php echo $this->_var['key']; ?>" class="ftx-01"><?php echo $this->_var['data']; ?></a></li>
												<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
											</ul>
											<input name="homepage_changefreq" type="hidden" value="<?php echo $this->_var['config']['homepage_changefreq']; ?>" id="">
										</div>										
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="label"><?php echo $this->_var['lang']['category_changefreq']; ?>：</div>
                                    <div class="label_value">
										<div id="" class="imitate_select select_w120">
											<div class="cite">请选择</div>
											<ul>
												<?php $_from = $this->_var['arr_changefreq']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'data');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['data']):
?>
												<li><a href="javascript:;" data-value="<?php echo $this->_var['data']; ?>" class="ftx-01"><?php echo $this->_var['data']; ?></a></li>
												<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
											</ul>
											<input name="category_priority" type="hidden" value="<?php echo $this->_var['config']['category_priority']; ?>" id="">
										</div>
										<div id="" class="imitate_select select_w120">
											<div class="cite">请选择</div>
											<ul>
												<?php $_from = $this->_var['lang']['priority']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'data');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['data']):
?>
												<li><a href="javascript:;" data-value="<?php echo $this->_var['key']; ?>" class="ftx-01"><?php echo $this->_var['data']; ?></a></li>
												<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
											</ul>
											<input name="category_changefreq" type="hidden" value="<?php echo $this->_var['config']['category_changefreq']; ?>" id="">
										</div>	
                                    </div>
                                </div>								
                                <div class="item">
                                    <div class="label"><?php echo $this->_var['lang']['content_changefreq']; ?>：</div>
                                    <div class="label_value">
										<div id="" class="imitate_select select_w120">
											<div class="cite">请选择</div>
											<ul>
												<?php $_from = $this->_var['arr_changefreq']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'data');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['data']):
?>
												<li><a href="javascript:;" data-value="<?php echo $this->_var['data']; ?>" class="ftx-01"><?php echo $this->_var['data']; ?></a></li>
												<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
											</ul>
											<input name="content_priority" type="hidden" value="<?php echo $this->_var['config']['content_priority']; ?>" id="">
										</div>
										<div id="" class="imitate_select select_w120">
											<div class="cite">请选择</div>
											<ul>
												<?php $_from = $this->_var['lang']['priority']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'data');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['data']):
?>
												<li><a href="javascript:;" data-value="<?php echo $this->_var['key']; ?>" class="ftx-01"><?php echo $this->_var['data']; ?></a></li>
												<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
											</ul>
											<input name="content_changefreq" type="hidden" value="<?php echo $this->_var['config']['content_changefreq']; ?>" id="">
										</div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="label">&nbsp;</div>
                                    <div class="label_value info_btn">
										<input type="submit" value="<?php echo $this->_var['lang']['button_submit']; ?>" class="button" />
										<input type="reset" value="<?php echo $this->_var['lang']['button_reset']; ?>" class="button button_reset" />
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
</body>
</html>
