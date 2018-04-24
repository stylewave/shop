
<?php if ($this->_var['user_id']): ?>
	<a href="<?php echo $this->_var['site_domain']; ?>user.php" class="nick_name"><?php echo $this->_var['info']['nick_name']; ?></a>
<?php else: ?>
	<a href="<?php echo $this->_var['site_domain']; ?>user.php">登录</a>
    |
    <a href="user.php?act=register">注册</a>
<?php endif; ?>

    