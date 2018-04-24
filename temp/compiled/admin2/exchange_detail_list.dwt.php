<?php if ($this->_var['full_page']): ?>
<!doctype html>
<html>
<head><?php echo $this->fetch('library/admin_html_head.lbi'); ?></head>


<body class="iframe_body">
<div class="warpper">
    <div class="title">报表 - 积分明细</div>
    <div class="content">
        <div class="tabs_info">
            <ul>
                <li <?php if ($this->_var['menu_select']['current'] == 'exchange_count'): ?>class="curr"<?php endif; ?>><a href="exchange_detail.php?act=detail"><?php echo $this->_var['lang']['exchange_count']; ?></a></li>
            </ul>
        </div>
        <div class="explanation" id="explanation">
            <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
            <ul>
                <li>统计所有商家总赠送消费积分、总赠送等级积分。</li>
            </ul>
        </div>
        <div class="flexilist mt30">
            <div class="common-content">
                <div class="mian-info sale_info">
                    <div class="switch_info">
                        

                        <div class="query_result mt30">
                            <div class="common-head">
                                <div class="fl">
                                    <div class="fbutton m0" id="fbutton_1"><a href="javascript:void(0);"><div class="csv" title="导出数据"><span><i class="icon icon-download-alt"></i>导出列表</span></div></a></div>
                                </div>
                                <div class="refresh">
                                    <div class="refresh_tit" onclick="getList(this)" title="刷新数据"><i class="icon icon-refresh"></i></div>

                                </div>
                            </div>
                            <div class="list-div" id="listDiv" style="position: relative">
                            	<?php endif; ?>
                                <div class="refresh_span" style="position: absolute;left:135px;top: 0px;">刷新 - 共<?php echo $this->_var['record_count']; ?>条记录</div>
                                <table cellpadding="0" cellspacing="0" border="0">
                                    <thead>
                                    <tr>
                                        <th width="25%"><div class="tDiv">商家名称</div></th>
                                        <th width="25%"><div class="tDiv">总赠送消费积分</div></th>
                                        <th width="25%"><div class="tDiv">总赠送等级积分</div></th>
                                        <th width="25%"><div class="tDiv">操作</div></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $_from = $this->_var['detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'vo');if (count($_from)):
    foreach ($_from AS $this->_var['vo']):
?>
                                    <tr>
                                        <td><div class="tDiv"><?php echo $this->_var['vo']['shop_name']; ?></div></td>
                                        <td><div class="tDiv"><?php echo empty($this->_var['vo']['give_integral']) ? '0' : $this->_var['vo']['give_integral']; ?></div></td>
                                        <td><div class="tDiv"><?php echo empty($this->_var['vo']['rank_integral']) ? '0' : $this->_var['vo']['rank_integral']; ?></div></td>
                                        <td>
											<div class="tDiv">
												<a href="exchange_detail.php?act=exchange_goods&user_id=<?php echo $this->_var['vo']['user_id']; ?>">查看商品</a>
												<a href="exchange_detail.php?act=order_view&user_id=<?php echo $this->_var['vo']['user_id']; ?>">查看订单</a>
											</div>
										</td>
                                    </tr>
                                    <?php endforeach; else: ?>
                                    <tr>
                                        <td colspan="12" class="no_record"><div class="tDiv"><?php echo $this->_var['lang']['no_records']; ?></div></td>
                                    </tr>
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
                                <script type="text/javascript">
                                    //分页传值
                                    listTable.recordCount = '<?php echo $this->_var['record_count']; ?>';
                                    listTable.pageCount = '<?php echo $this->_var['page_count']; ?>';
                                    listTable.url = "exchange_detail.php?is_ajax=1";
									listTable.query = "detail_query";

                                    <?php $_from = $this->_var['filter']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
                                    listTable.filter.<?php echo $this->_var['key']; ?> = '<?php echo $this->_var['item']; ?>';
                                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 <?php echo $this->fetch('library/pagefooter.lbi'); ?>
</body>
<script type="text/javascript">
    function getList()
    {
        var act = 'detail_query';
        $.ajax({
            url:"exchange_detail.php?is_ajax=1",
            dataType:"json",
            type:'post',
            data:{
                "act" : act,
            },
            success:function(data){
                $('.list-div').eq(0).html(data.content);
            }
        })
    }

    //导出报表(销售明细)
    $('#fbutton_1').click(function(){
        location.href='exchange_detail.php?act=download';
    })
</script>
</html>
<?php endif; ?>