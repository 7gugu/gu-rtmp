<body>
<div class="am-g">
    <div class="am-u-sm-12 am-u-md-8 am-u-md-centered">
       <form class="am-form">
  <fieldset>
    <legend>注册</legend>
	<?php loadalert(); ?>
    <div class="am-form-group">
      <label for="username">用户名</label>
      <input type="text" class="am-radius" id="username" placeholder="输入用户名" required>
    </div>

    <div class="am-form-group">
      <label for="password">密码</label>
      <input type="password" class="am-radius" id="password" placeholder="输入密码" required>
    </div>
	
	<div class="am-form-group">
      <label for="cfmpassword">重复密码</label>
      <input type="password" class="am-radius" id="cfmpassword" placeholder="再次输入密码" required>
    </div>
	
	<div class="am-form-group">
      <label for="email">邮箱</label>
      <input type="email" class="am-radius" id="email" placeholder="输入邮箱" required>
    </div>
	
	<div class="am-cf">
		 <button type="button" name="button_signup" id="button_signup" onclick="submit_data()" class="am-btn am-btn-primary am-btn-sm am-fl">注 册</button>
        <button type="button" name="button_signin" id="button_signin" onclick="window.location='index.php?mod=signin'" class="am-btn am-btn-default am-btn-sm am-fr">登 录</button>
	</div>
  </fieldset>
</form>
    </div>
</div>
</div>
<script>
function submit_data(){
	var username=$("#username").val();
	var password=$("#password").val();
	var cfmpassword=$("#cfmpassword").val();
	var email=$("#email").val();
	 $.ajax({
  type: 'POST',
  async: false,
  url: 'index.php',
  data: { signup: true, username: username , password: password,cfmpassword:cfmpassword,email:email},
  beforeSend:function(){
			$('#button_signup').prop("disabled",true);
			},
  success:function(data){
	  var response=$.parseJSON(data);
	  $('#button_signup').prop("disabled",false);
	  if(response.status=="success"){
		  alert_success(response.describe);
		  setTimeout(function(){
			  window.location="index.php?mod=user:run";
		  },2000);
	  }else if(response.status=="danger"){
		  alert_danger(response.describe);
	  }else if(response.status=="warning"){
		  alert_warning(response.describe);
	  }
  }
	});
}
</script>
</body>