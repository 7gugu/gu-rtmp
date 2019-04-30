<body>
<div class="am-g">
    <div class="am-u-sm-12 am-u-md-8 am-u-md-centered">
	<legend>设置信息</legend>
		<?php loadalert(); ?>
		<div class="am-form">
	<label for="nickname">修改昵称</label>
    <div class="am-input-group">
      <input type="text" class="am-form-field am-radius" id="newnickname" name="newnickname" placeholder="输入新的昵称">
      <span class="am-input-group-btn">
        <button class="am-btn am-btn-default" type="button" onclick="submit_data(1)">保存修改</button>
      </span>
    </div>
	<hr/>
	<div class="am-panel am-panel-danger">
		 <header class="am-panel-hd">
			<h3 class="am-panel-title">修改密码</h3>
		</header>
		<div class="am-panel-bd">
			<input type="password" class=" am-radius" id="oldpassword" name="oldpassword" placeholder="输入旧的密码" \>
			<br/>
			<input type="password" class=" am-radius" id="password" name="password" placeholder="输入新的密码" \>
			<br>
			<input type="password" class=" am-radius" id="cfmpassword" name="cfmpassword" placeholder="再次输入新的密码" \>
			<br>
			<button class="am-btn am-btn-danger" type="button" onclick="submit_data(2)">保存修改</button>
		</div>
	</div>
	</div>
	</div>
</div>
</div>
 <script>
 function submit_data(type){
	 console.log(type);
	 var newnickname=newpassword=false;
	 if(type==1){
		 newnickname=$("#newnickname").val();
	 }
	 if(type==2){
		 if($("#oldpassword").val()!="<?php echo $_SESSION['password']; ?>"){
			 alert_warning("旧密码错误!");
			 return;
		 }
		 newpassword=$("#password").val();
		 if(newpassword!=$("#cfmpassword").val()){
			 remove_alert();
			 alert_warning("重复密码错误!");
			 return;
		 }
	 }
	    $.ajax({
  type: 'POST',
  async: false,
  url: 'index.php?mod',
  data: { update_information: true,username:"<?php echo $_SESSION['username']; ?>",password:"<?php echo $_SESSION['password']; ?>",newnickname:newnickname,newpassword:newpassword},
  beforeSend:function(){
	remove_alert();
	alert_info("数据提交中..");
			},
  success:function(data){
	  remove_alert();
	  var response=$.parseJSON(data);
	  if(response.status=="success"){
		  alert_success(response.describe);
		  setTimeout(function(){
			  remove_alert();
			  if(type==4){
			  alert_warning("密码已成功修改,请重新登录..");
			  setTimeout(function(){
				  window.location="index.php?mod=signin";
			  },1000);
		  }
		  },2000);
	  }else if(response.status=="danger"){
		  alert_danger(response.describe);
	  }
  }
	});
 }
 
 function getdata(){
	 $.ajax({
  type: 'POST',
  async: false,
  url: 'index.php?mod',
  data: { information: true,username:"<?php echo $_SESSION['username']; ?>",password:"<?php echo $_SESSION['password']; ?>"},
  beforeSend:function(){
	alert_info("数据加载中..");
			},
  success:function(data){
	  remove_alert();
	  var response=$.parseJSON(data);
	  if(response.status=="success"){
		  alert_success(response.describe);
		  $("#newnickname").val(response.nickname);
		  setTimeout(function(){
			  remove_alert();
		  },2000);
	  }else if(response.status=="danger"){
		  alert_danger(response.describe);
	  }
  }
	});
 }
 
 $(document).ready(function(){
   getdata();
});
 </script>
</body>