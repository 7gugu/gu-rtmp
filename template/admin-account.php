<body>
<div class="am-g">
    <div class="am-u-sm-12 am-u-md-8 am-u-md-centered">
	<legend>管理用户</legend>
		<?php loadalert(); ?>
		<?php loadlist(); ?>
		<?php loadpagination(); ?>
	</div>
</div>
</div>
 <script>
 function reset_password(id){
	 if(!confirm("确定重置用户<"+$("#"+id).text()+">的密码吗?"))return;
	 $.ajax({
  type: 'POST',
  async: false,
  url: 'index.php?mod',
  data: { reset_password: true,username:"<?php echo $_SESSION['username']; ?>",password:"<?php echo $_SESSION['password']; ?>",accountid:id},
  beforeSend:function(){
	alert_info("重置中,请稍后..");
			},
  success:function(data){
	  remove_alert();
	  var response=$.parseJSON(data);
	  if(response.status=="success"){
		  alert_success(response.describe);
		  setTimeout(function(){
			  remove_alert();
		  },2000);
	  }else if(response.status=="warning"){
		  alert_warning(response.describe);
	  }else if(response.status=="danger"){
		  alert_danger(response.describe);
	  }
  }
	});
 }
 
 function delete_user(id){
	 if(!confirm("确定删除用户<"+$("#"+id).text()+">吗?"))return;
	 $.ajax({
  type: 'POST',
  async: false,
  url: 'index.php?mod',
  data: { delete_user: true,username:"<?php echo $_SESSION['username']; ?>",password:"<?php echo $_SESSION['password']; ?>",accountid:id},
  beforeSend:function(){
	alert_info("删除中,请稍后..");
			},
  success:function(data){
	  remove_alert();
	  var response=$.parseJSON(data);
	  if(response.status=="success"){
		  alert_success(response.describe);
		  setTimeout(function(){
			  remove_alert();
			  location.reload(force)
		  },2000);
	  }else if(response.status=="warning"){
		  alert_warning(response.describe);
	  }else if(response.status=="danger"){
		  alert_danger(response.describe);
	  }
  }
	});
 }
 </script>
</body>