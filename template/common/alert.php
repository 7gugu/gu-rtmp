
<div id="alert" name="alert">
<!-- 成功提示框 -->
<?php if(isset($_SESSION['success'])){ ?>
<div class="am-alert am-alert-success" data-am-alert>
    <button type="button" class="am-close">&times;</button>
	<p>
    <span class="am-icon-fw am-icon-check" aria-hidden="true"></span> 
    <?php echo $_SESSION['success']; ?>
	</p>
</div>
	<?php unset($_SESSION['success']); ?>
<?php } ?>
<!-- 错误提示框 -->
<?php if(isset($_SESSION['danger'])){ ?>
<div class="am-alert am-alert-danger" data-am-alert>
  <button type="button" class="am-close">&times;</button>
  <p>
  <span class="am-icon-fw am-icon-close "></span> 
  <?php echo $_SESSION['danger']; ?>
  </p>
</div>
	<?php unset($_SESSION['danger']); ?>
<?php } ?>
<!-- 处理中提示框 -->
<?php if(isset($_SESSION['info'])){ ?>
<div class="am-alert am-alert-info" role="alert" data-am-alert>
    <button type="button" class="am-close">&times;</button>
	<p>
    <span class="am-icon-fw am-icon-spinner am-icon-pulse " aria-hidden="true"></span> 
    <?php echo $_SESSION['info']; ?>
	</p>
</div>
	<?php unset($_SESSION['info']); ?>
<?php } ?>
<!-- 警告提示框 -->
<?php if(isset($_SESSION['warning'])){ ?>
<div class="am-alert am-alert-warning" data-am-alert>
	<button type="button" class="am-close">&times;</button>
	<p>
	<span class="am-icon-fw am-icon-exclamation" aria-hidden="true"></span> 
	<?php echo $_SESSION['warning']; ?>
	</p>
</div>
	<?php unset($_SESSION['warning']); ?>
<?php } ?>
</div>
<?php 

?>
