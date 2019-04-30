<body>
<div class="am-g">
    <div class="am-u-sm-12 am-u-md-8 am-u-md-centered">
	<legend>房间信息</legend>
		<?php loadalert(); ?>
		<div class="am-form">
	<label for="title">修改房间标题</label>
    <div class="am-input-group">
      <input type="text" class="am-form-field am-radius" id="newtitle" name="newtitle" placeholder="输入新的标题">
      <span class="am-input-group-btn">
        <button class="am-btn am-btn-default" type="button" onclick="submit_data(1)">保存修改</button>
      </span>
    </div>
	<hr/>
	<label for="stream_state">直播状态</label>
    <div id="streamstate"><span class="am-badge am-badge-secondary am-radius">状态未知.</span></div>
	<hr/>
	<label for="stream_url">推流地址</label>
    <input type="text" class="am-form-field am-radius" id="streamurl" name="streamurl" placeholder="推流地址" disabled>
	<hr/>
	<label for="stream_serect">流名称</label>
    <input type="text" class="am-form-field am-radius" id="serect" name="serect" placeholder="流名称" disabled>
	<hr/>
	</div>
	</div>
</div>
</div>
 <script>
 function submit_data(type){
	 console.log(type);
	 var newtitle=false;
	 if(type==1){
		 newtitle=$("#newtitle").val();
	 }
	    $.ajax({
  type: 'POST',
  async: false,
  url: 'index.php?mod',
  data: { room: true,update:true,username:"<?php echo $_SESSION['username']; ?>",newtitle:newtitle},
  beforeSend:function(){
	remove_alert();
	alert_info("数据提交中..");
			},
  success:function(data){
	  remove_alert();
	  var response=$.parseJSON(data);
	  if(response.status=="success"){
		  alert_success(response.describe);
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
  data: { room: true,username:"<?php echo $_SESSION['username']; ?>"},
  beforeSend:function(){
	alert_info("数据加载中..");
			},
  success:function(data){
	  remove_alert();
	  var response=$.parseJSON(data);
	  if(response.status=="success"){
		  alert_success(response.describe);
		  $("#newtitle").val(response.title);
		  $("#streamurl").val(response.url);
		  $("#serect").val("?streamname="+response.streamname+"&key="+response.key);
		  if(response.state==1){
			  $("#streamstate").html("<span class=\"am-badge am-badge-success am-radius\">推流中.</span>");
		  }else{
			  $("#streamstate").html("<span class=\"am-badge am-badge-danger am-radius\">未推流.</span>");
		  }
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