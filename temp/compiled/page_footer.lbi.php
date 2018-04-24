<div class="footer">
    <div class="dsc-service">
        <div class="w w1200 relative">
            <ul class="service-list">
                <li>
                    <div class="service-tit service-zheng"><i class="iconfont icon-zheng"></i></div>
                    <div class="service-txt"><?php echo $this->_var['lang']['Authentic_guarantee']; ?></div>
                </li>
                <li>
                    <div class="service-tit service-qi"><i class="iconfont icon-qi"></i></div>
                    <div class="service-txt"><?php echo $this->_var['lang']['7_days_return']; ?></div>
                </li>
                <li>
                    <div class="service-tit service-hao"><i class="iconfont icon-grin"></i></div>
                    <div class="service-txt"><?php echo $this->_var['lang']['Rave_reviews']; ?></div>
                </li>
                <li>
                    <div class="service-tit service-shan"><i class="iconfont icon-light"></i></div>
                    <div class="service-txt"><?php echo $this->_var['lang']['Lightning_delivery']; ?></div>
                </li>
                <li class="last">
                    <div class="service-tit service-quan"><i class="iconfont icon-trophy"></i></div>
                    <div class="service-txt"><?php echo $this->_var['lang']['Authority_of_honor']; ?></div>
                </li>
            </ul>
        </div>
    </div>
    <div class="dsc-help">
        <div class="w w1200">
            <div class="help-list">
                <?php $_from = $this->_var['helps']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'help_cat');$this->_foreach['no'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['no']['total'] > 0):
    foreach ($_from AS $this->_var['help_cat']):
        $this->_foreach['no']['iteration']++;
?>
                <?php if ($this->_foreach['no']['iteration'] < 6): ?>
                <div class="help-item">
                    <h3><?php echo $this->_var['help_cat']['cat_name']; ?></h3>
                    <ul>
                    <?php $_from = $this->_var['help_cat']['article']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');$this->_foreach['help_cat'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['help_cat']['total'] > 0):
    foreach ($_from AS $this->_var['item']):
        $this->_foreach['help_cat']['iteration']++;
?>
                    <?php if ($this->_foreach['help_cat']['iteration'] < 4): ?>
                    <li><a href="<?php echo $this->_var['item']['url']; ?>"  title="<?php echo htmlspecialchars($this->_var['item']['title']); ?>" target="_blank"><?php echo $this->_var['item']['short_title']; ?></a></li>
                    <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </ul>
                </dl>
                </div>
                <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>  
            </div>
            <div class="help-cover">
                <div class="help-ctn">
                    <div class="help-ctn-mt">
                        <span>服务热线</span>
                        <strong><?php echo $this->_var['service_phone']; ?></strong>
                    </div>
                    <div class="help-ctn-mb">
                        <?php if ($this->_var['kf_im_switch']): ?>

                        <a id="IM" IM_type="dsc" onclick="openWin(this)" href="javascript:;" class="btn-ctn"><i class="iconfont icon-csu"></i>咨询客服</a>
                        <?php else: ?>
                            <?php if ($this->_var['basic_info']['kf_type'] == 1): ?>
                            <a href="http://www.taobao.com/webww/ww.php?ver=3&touid=<?php echo $this->_var['basic_info']['kf_ww']; ?>&siteid=cntaobao&status=1&charset=utf-8" class="btn-ctn" target="_blank"><i class="iconfont icon-csu"></i><?php echo $this->_var['lang']['con_cus_service']; ?></a>
                            <?php else: ?>
                            <a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $this->_var['basic_info']['kf_qq']; ?>&site=qq&menu=yes" class="btn-ctn" target="_blank"><i class="iconfont icon-csu"></i><?php echo $this->_var['lang']['con_cus_service']; ?></a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="help-scan">
                    <ul class="tabs">
                    	<li class="curr">网页版</li>
                        <li>手机版</li>
                    </ul>
                    <div class="code">
                    	<div class="code_tp"><img src="<?php echo $this->_var['site_domain']; ?><?php echo $this->_var['ecjia_qrcode']; ?>" /></div>
                        <div class="code_tp" style="display:none;"><img src="<?php echo $this->_var['site_domain']; ?><?php echo $this->_var['ectouch_qrcode']; ?>"></div>
                    </div>
                    <!--<div class="ico" ectype="switch" title="切换"><i class="iconfont icon-switch"></i></div>-->
                </div>
            </div>
        </div>
    </div>
    <div class="dsc-copyright">
        <div class="w w1200">
            <?php if ($this->_var['navigator_list']['bottom']): ?> 
            <p class="copyright_links">
                <?php $_from = $this->_var['navigator_list']['bottom']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'nav_0_97734900_1524563165');$this->_foreach['nav_bottom_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nav_bottom_list']['total'] > 0):
    foreach ($_from AS $this->_var['nav_0_97734900_1524563165']):
        $this->_foreach['nav_bottom_list']['iteration']++;
?>
                <a href="<?php echo $this->_var['nav_0_97734900_1524563165']['url']; ?>" <?php if ($this->_var['nav_0_97734900_1524563165']['opennew'] == 1): ?> target="_blank" <?php endif; ?>><?php echo $this->_var['nav_0_97734900_1524563165']['name']; ?></a> 
                <?php if (! ($this->_foreach['nav_bottom_list']['iteration'] == $this->_foreach['nav_bottom_list']['total'])): ?> 
                | 
                <?php endif; ?> 
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
            </p>
            <?php endif; ?>
            <?php if ($this->_var['img_links'] || $this->_var['txt_links']): ?>
            <p class="copyright_info">
                <?php $_from = $this->_var['img_links']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'link');if (count($_from)):
    foreach ($_from AS $this->_var['link']):
?>
                <a href="<?php echo $this->_var['link']['url']; ?>" target="_blank" title="<?php echo $this->_var['link']['name']; ?>"><img src="<?php echo $this->_var['site_domain']; ?><?php echo $this->_var['link']['logo']; ?>" alt="<?php echo $this->_var['link']['name']; ?>" border="0" /></a>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <?php if ($this->_var['txt_links']): ?>
                <?php $_from = $this->_var['txt_links']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'link');$this->_foreach['nolink'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nolink']['total'] > 0):
    foreach ($_from AS $this->_var['link']):
        $this->_foreach['nolink']['iteration']++;
?>
                <a href="<?php echo $this->_var['link']['url']; ?>" target="_blank" title="<?php echo $this->_var['link']['name']; ?>"><?php echo $this->_var['link']['name']; ?></a>
                <?php if (! ($this->_foreach['nolink']['iteration'] == $this->_foreach['nolink']['total'])): ?> 
                | 
                <?php endif; ?> 
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <?php endif; ?>
            </p>
            <?php endif; ?>
            <?php if ($this->_var['icp_number']): ?> 
            <b><?php echo $this->_var['lang']['icp_number']; ?>:<a href="http://www.miibeian.gov.cn/" target="_blank"><?php echo $this->_var['icp_number']; ?></a> <a target="_blank">POWERED BY 汇斯购商城</a></b>
            <?php endif; ?>
            <p style="display:none"><?php 
$k = array (
  'name' => 'query_info',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?></p>
            <p>&nbsp;</p>
            <?php if ($this->_var['stats_code']): ?>
                <p style="text-align:right; display:none;"><?php echo $this->_var['stats_code']; ?></p>
            <?php endif; ?>
            <?php if ($this->_var['partner_img_links'] || $this->_var['partner_txt_links']): ?>
            <p class="copyright_auth">
                <?php $_from = $this->_var['partner_img_links']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'link');if (count($_from)):
    foreach ($_from AS $this->_var['link']):
?>
                <a href="<?php echo $this->_var['link']['url']; ?>" target="_blank" title="<?php echo $this->_var['link']['name']; ?>"><img src="<?php echo $this->_var['site_domain']; ?><?php echo $this->_var['link']['logo']; ?>" alt="<?php echo $this->_var['link']['name']; ?>" border="0" /></a>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <?php if ($this->_var['txt_links']): ?>
                <?php $_from = $this->_var['partner_txt_links']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'link');$this->_foreach['nolink'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nolink']['total'] > 0):
    foreach ($_from AS $this->_var['link']):
        $this->_foreach['nolink']['iteration']++;
?>
                <a href="<?php echo $this->_var['link']['url']; ?>" target="_blank" title="<?php echo $this->_var['link']['name']; ?>" class="mr0"><?php echo $this->_var['link']['name']; ?></a>
                <?php if (! ($this->_foreach['nolink']['iteration'] == $this->_foreach['nolink']['total'])): ?> 
                | 
                <?php endif; ?> 
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <?php endif; ?>
            </p>    
            <?php else: ?>
            <p class="copyright_auth">&nbsp;</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="hide" id="pd_coupons">
    <span class="success-icon m-icon"></span>
    <div class="item-fore">
        <h3><?php echo $this->_var['lang']['Coupon_redemption_succeed']; ?></h3>
        <div class="txt ftx-03"><?php echo $this->_var['lang']['coupons_prompt']; ?></div>
    </div>
</div>
<div class="hidden">
    <input name="seller_kf_IM" ru_id="<?php echo $_GET['merchant_id']; ?>" value="<?php echo $this->_var['shop_information']['is_IM']; ?>" type="hidden" rev="<?php echo $this->_var['site_domain']; ?>">
    <input name="seller_kf_qq" value="<?php echo $this->_var['basic_info']['kf_qq']; ?>" type="hidden">
    <input name="seller_kf_tel" value="<?php echo $this->_var['basic_info']['kf_tel']; ?>" type="hidden">
</div>
<?php if ($this->_var['site_domain']): ?>
<script type="text/jscript" src="<?php echo $this->_var['site_domain']; ?>js/suggest.js"></script>
<script type="text/jscript" src="<?php echo $this->_var['site_domain']; ?>js/scroll_city.js"></script>
<script type="text/jscript" src="<?php echo $this->_var['site_domain']; ?>js/utils.js"></script>
<?php else: ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'suggest.js,scroll_city.js,utils.js')); ?>
<?php endif; ?>

<?php if ($this->_var['site_domain']): ?>
<?php if ($this->_var['area_htmlType'] != 'goods' && $this->_var['area_htmlType'] != 'exchange'): ?>
	<script type="text/javascript" src="<?php echo $this->_var['site_domain']; ?>js/warehouse_area.js"></script>
<?php else: ?>
	<script type="text/javascript" src="<?php echo $this->_var['site_domain']; ?>js/warehouse.js"></script>
<?php endif; ?>
<?php else: ?>
<?php if ($this->_var['area_htmlType'] != 'goods' && $this->_var['area_htmlType'] != 'exchange' && $this->_var['area_htmlType'] != 'presale' && $this->_var['area_htmlType'] != 'group_buy'): ?>
    <?php echo $this->smarty_insert_scripts(array('files'=>'warehouse_area.js')); ?>
<?php else: ?>
    <?php echo $this->smarty_insert_scripts(array('files'=>'warehouse.js')); ?>
<?php endif; ?>
<?php endif; ?>

<?php if ($this->_var['suspension_two']): ?>
<script>var seller_qrcode='<img src="<?php echo $this->_var['site_domain']; ?><?php echo $this->_var['seller_qrcode_img']; ?>" alt="<?php echo $this->_var['seller_qrcode_text']; ?>" width="164" height="164">'; //by wu</script>
<?php echo $this->_var['suspension_two']; ?>
<?php endif; ?>

<script type="text/javascript">
	//IM
    function openWin(obj) {
		
		var where_goods = "";
		if($(obj).attr('goods_id')){
			where_goods = '&goods_id=' + $(obj).attr('goods_id');
		}
		
		var where_seller = "";
		if($(obj).attr('ru_id')){
			where_seller = '&ru_id=' + $(obj).attr('ru_id');
		}

        if($(obj).attr('IM_type') != 'dsc'){
            var where = where_goods + where_seller;
        }else{
            var where = '';
        }
        var url='online.php?act=service' + where                   //转向网页的地址;
        var name='webcall';                         //网页名称，可为空;
        var iWidth=700;                          //弹出窗口的宽度;
        var iHeight=500;                         //弹出窗口的高度;
        //获得窗口的垂直位置
        var iTop = (window.screen.availHeight - 30 - iHeight) / 2;
        //获得窗口的水平位置
        var iLeft = (window.screen.availWidth - 10 - iWidth) / 2;
        window.open(url, name, 'height=' + iHeight + ',,innerHeight=' + iHeight + ',width=' + iWidth + ',innerWidth=' + iWidth + ',top=' + iTop + ',left=' + iLeft + ',status=no,toolbar=no,menubar=no,location=no,resizable=no,scrollbars=0,titlebar=no');
    }
</script>