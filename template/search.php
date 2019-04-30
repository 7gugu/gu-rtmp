<body>
<div class="am-g">
    <div id="stage_search" class="am-u-sm-12 am-u-md-8 am-u-md-centered">
       <form class="am-form" id="streamname_form">
  <fieldset>
    <legend id="room_title">搜索直播间</legend>
	<?php loadalert(); ?>
    <div class="am-form-group">
      <label for="name">直播间名称</label>
      <input type="text" class="am-radius" id="streamname" placeholder="输入StreamName" required>
    </div>
	
	<div class="am-cf">
		 <button type="button" name="button_signup" id="button_signup" onclick="submit_data()" class="am-btn am-btn-primary am-btn-sm am-fl">搜索房间</button>
	</div>
  </fieldset>
</form>
 </div>
 </body>
 <script>
 function submit_data(){
	 var streamname=$("#streamname").val();
	 $.ajax({
  type: 'POST',
  async: false,
  url: 'index.php',
  data: { broadcast: true, streamname: streamname },
  beforeSend:function(){
			alert_info("房间搜索中...")
			},
  success:function(data){
	  remove_alert();
	  var response=$.parseJSON(data);
	  if(response.status=="success"){
			alert_success(response.describe);
			window.location='index.php?mod=broadcast&streamname='+streamname;
	  }else if(response.status=="danger"){
			alert_danger(response.describe);
	  }else if(response.status=="warning"){
			alert_warning(response.describe);
	  }
  }
	});
}

 </script>