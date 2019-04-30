<body>
<div class="am-g">
    <div class="am-u-sm-12 am-u-md-8 am-u-md-centered">
       <form class="am-form" method="POST" action="index.php?mod=signin">
  <fieldset>
    <legend>登录</legend>
	<?php loadalert(); ?>
    <div class="am-form-group">
      <label for="username">用户名</label>
      <input type="text" class="am-radius" id="username" name="username" placeholder="输入用户名" required>
    </div>

    <div class="am-form-group">
      <label for="password">密码</label>
      <input type="password" class="am-radius" id="password" name="password" placeholder="输入密码" required>
    </div>
	
	<div class="am-cf">
		 <button type="button" name="button_signin" id="button_signin" onclick="submit_data()" class="am-btn am-btn-primary am-btn-sm am-fl">登 录</button>
        <button type="button" name="button_signup" id="button_signup" onclick="window.location='index.php?mod=signup'" class="am-btn am-btn-default am-btn-sm am-fr">注 册</button>
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
	if(username==""){alert_warning("请输入用户名");return;}
	if(password==""){alert_warning("请输入密码");return;}
	 $.ajax({
  type: 'POST',
  async: false,
  url: 'index.php',
  data: { signin: true, username: username , password: password},
  beforeSend:function(){
			$('#button_signin').prop("disabled",true);
			},
  success:function(data){
	  var response=$.parseJSON(data);
	  $('#button_signin').prop("disabled",false);
	  if(response.status=="success"){
		  alert_success(response.describe);
		  setTimeout(function(){
			  window.location="index.php?mod=user:room";
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
