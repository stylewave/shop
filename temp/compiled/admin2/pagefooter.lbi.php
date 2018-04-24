<div id="footer">
    <p><?php echo $this->_var['lang']['copyright']; ?></p>
</div>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/jquery.picTip.js')); ?>
<script type="text/javascript">
$(function(){
	
	/* 检查账单 */
  	startCheckBill();
	
	/* 检测配送地区缓存文件是否存在 */
	sellerShippingArea();
	
	<?php if ($this->_var['cat_belongs'] == 0): ?>
		$.jqueryAjax('dialog.php', 'is_ajax=1&act=dialog_upgrade', function(data){
			var content = data.content;
			pb({
				id:"categroy_dialog",
				title:"温馨提示",
				width:788,
				content:content,
				ok_title:"确定",
				drag:false,
				foot:false,
				cl_cBtn:false
			});			
		});
	<?php endif; ?>

	$("*[data-toggle='tooltip']").tooltip({
		position: {
			my: "left top+5",
			at: "left bottom"
		}
	});
});
</script>