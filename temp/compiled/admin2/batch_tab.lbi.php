<div class="tabs_info">
    <ul>
    	<li <?php if ($this->_var['menu_select']['current'] == '15_batch_edit'): ?>class="curr"<?php endif; ?>><a href="goods_batch.php?act=select">商品批量修改</a></li>
        <li <?php if ($this->_var['menu_select']['current'] == '12_batch_pic'): ?>class="curr"<?php endif; ?>><a href="picture_batch.php">图片批量处理</a></li>
        <li <?php if ($this->_var['menu_select']['current'] == '13_batch_add'): ?>class="curr"<?php endif; ?>><a href="goods_batch.php?act=add">商品批量上传</a></li>
        <li <?php if ($this->_var['menu_select']['current'] == '14_goods_export'): ?>class="curr"<?php endif; ?>><a href="goods_export.php?act=goods_export">商品批量导出</a></li>
        <li <?php if ($this->_var['menu_select']['current'] == 'goods_auto'): ?>class="curr"<?php endif; ?>><a href="goods_auto.php?act=list">批量自动上下架</a></li>
        
        <?php if ($this->_var['menu_select']['current'] == 'warehouse_attr_batch'): ?>
        <li <?php if ($this->_var['menu_select']['current'] == 'warehouse_attr_batch'): ?>class="curr"<?php endif; ?>><a href="goods_warehouse_attr_batch.php?act=add">仓库属性批量上传</a></li>
        <?php endif; ?>
        
        <?php if ($this->_var['menu_select']['current'] == 'area_attr_batch'): ?>
        <li <?php if ($this->_var['menu_select']['current'] == 'area_attr_batch'): ?>class="curr"<?php endif; ?>><a href="goods_area_attr_batch.php?act=add">地区属性批量上传</a></li>
        <?php endif; ?>
        
        <?php if ($this->_var['menu_select']['current'] == 'back_area_batch_list'): ?>
        <li <?php if ($this->_var['menu_select']['current'] == 'back_area_batch_list'): ?>class="curr"<?php endif; ?>><a href="goods_area_batch.php?act=add">商品地区批量上传</a></li>
        <?php endif; ?>
        
        <?php if ($this->_var['menu_select']['current'] == 'warehouse_batch'): ?>
        <li <?php if ($this->_var['menu_select']['current'] == 'warehouse_batch'): ?>class="curr"<?php endif; ?>><a href="goods_warehouse_batch.php?act=add">仓库库存批量上传</a></li>
        <?php endif; ?>
        
        <?php if ($this->_var['menu_select']['current'] == 'produts_batch'): ?>
        <li <?php if ($this->_var['menu_select']['current'] == 'produts_batch'): ?>class="curr"<?php endif; ?>><a href="goods_produts_batch.php?act=add&goods_id=<?php echo $this->_var['goods_id']; ?>">商品货品批量上传</a></li>
        <?php endif; ?>
        
        <?php if ($this->_var['menu_select']['current'] == 'produts_warehouse_batch'): ?>
        <li <?php if ($this->_var['menu_select']['current'] == 'produts_warehouse_batch'): ?>class="curr"<?php endif; ?>><a href="goods_produts_warehouse_batch.php?act=add&goods_id=<?php echo $this->_var['goods_id']; ?>&warehouse_id=<?php echo $this->_var['warehouse_id']; ?>">仓库商品货品批量上传</a></li>
        <?php endif; ?>
        
        <?php if ($this->_var['menu_select']['current'] == 'produts_area_batch'): ?>
        <li <?php if ($this->_var['menu_select']['current'] == 'produts_area_batch'): ?>class="curr"<?php endif; ?>><a href="goods_produts_area_batch.php?act=add&goods_id=<?php echo $this->_var['goods_id']; ?>&area_id=<?php echo $this->_var['area_id']; ?>">地区商品货品批量上传</a></li>
        <?php endif; ?>
    </ul>
</div>