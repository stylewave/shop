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
                        	<a href="http://help.ecmoban.com/article-6878.html" target="_blank">商城计划任务操作说明</a>
                        </div>
                    </div>			
                    <?php endif; ?>	
				</div>
                <ul>
                	<li>展示计划任务列表、计划任务描述、版本、插件记者等信息。</li>
                    <li>可开启或关闭计划任务，计划任务可安装、卸载、编辑等操作。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="common-content">
                	<div class="list-div" id="listDiv">
                    	<table cellpadding="0" cellspacing="0" border="0">
                        	<thead>
                            	<tr>
                                    <th width="13%"><div class="tDiv"><?php echo $this->_var['lang']['cron_name']; ?></div></th>
                                    <th width="20%"><div class="tDiv"><?php echo $this->_var['lang']['cron_desc']; ?></div></th>
                                    <th width="16%"><div class="tDiv"><?php echo $this->_var['lang']['cron_this']; ?></div></th>
                                    <th width="16%"><div class="tDiv"><?php echo $this->_var['lang']['cron_next']; ?></div></th>
                                    <th width="3%"><div class="tDiv"><?php echo $this->_var['lang']['if_open']; ?></div></th>
                                    <th width="22%" class="handle"><?php echo $this->_var['lang']['handler']; ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $_from = $this->_var['modules']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'module');if (count($_from)):
    foreach ($_from AS $this->_var['module']):
?>
                            	<tr>
                                    <td><div class="tDiv"><?php if ($this->_var['module']['install'] == 1): ?><?php echo $this->_var['module']['name']; ?><?php else: ?><?php echo $this->_var['module']['name']; ?><?php endif; ?></div></td>
                                    <td><div class="tDiv"><?php echo nl2br($this->_var['module']['desc']); ?></div></td>
                                    <td><div class="tDiv"><?php echo $this->_var['module']['thistime']; ?></div></td>
                                    <td><div class="tDiv"><?php echo $this->_var['module']['nextime']; ?></div></td>
                                    <td>
                                    	<div class="tDiv">
                                            <?php if ($this->_var['module']['install'] == "1"): ?>
                                            <div class="switch <?php if ($this->_var['module']['enable'] == 1): ?>active<?php endif; ?>" title="<?php if ($this->_var['module']['enable'] == 1): ?>是<?php else: ?>否<?php endif; ?>" onclick="listTable.switchBt(this, 'toggle_show', '<?php echo $this->_var['module']['code']; ?>')">
                                            	<div class="circle"></div>
                                            </div>
                                            <input type="hidden" value="0" name="">
                                            <?php else: ?>－<?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="handle">
                                        <div class="tDiv a3">
                                        <?php if ($this->_var['module']['install'] == "1"): ?>
                                            <a href="javascript:confirm_redirect(lang_removeconfirm, 'cron.php?act=uninstall&code=<?php echo $this->_var['module']['code']; ?>')" class="btn_trash"><i class="icon icon-trash"></i><?php echo $this->_var['lang']['uninstall']; ?></a>
                                            <a href="cron.php?act=edit&code=<?php echo $this->_var['module']['code']; ?>"  title="<?php echo $this->_var['lang']['edit']; ?>" class="btn_edit"><i class="icon icon-edit"></i><?php echo $this->_var['lang']['edit']; ?></a>
                                            <a href="cron.php?act=do&code=<?php echo $this->_var['module']['code']; ?>" title="<?php echo $this->_var['lang']['cron_do']; ?>" class="btn_region"><i class="icon icon-cog"></i><?php echo $this->_var['lang']['cron_do']; ?></a>
                                        <?php else: ?>
                                        	<a href="cron.php?act=install&code=<?php echo $this->_var['module']['code']; ?>"  title="<?php echo $this->_var['lang']['install']; ?>" class="btn_inst"><i class="sc_icon sc_icon_inst"></i><?php echo $this->_var['lang']['install']; ?></a>
                                        <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; else: ?>
                                    <tr><td class="no-records" colspan="12"><?php echo $this->_var['lang']['no_records']; ?></td></tr>
                                <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<?php echo $this->fetch('library/pagefooter.lbi'); ?>
</body>
</html>
