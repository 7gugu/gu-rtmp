<body>
<?php 
//本来是要做MVC的,但是video.js加载不了RTMP
//所以就这个页面做成了php渲染
	global $sql;
	@$streamname=$_GET['streamname'];
	$context="select * from whitelist where `streamname`='{$streamname}'";
	$connect=$sql->connect();
	$res=$sql->query($connect,$context);
	$res=$sql->fetch_array($res);
	if($res['stream_state']==0){
		alert("warning","直播未开播!","index.php?mod=search");
		die();
	}
?>
<div class="am-g">
 <!--主舞台区域-->
<div id="stage_show">
<button type="button" name="button_search" id="button_search" onclick="window.location='index.php?mod=search'" class="am-btn am-btn-default am-btn-sm am-fl" style="margin-left:10px;">退出房间</button>
<br><br>
<legend id="title" style="margin-left:10px;width:99%"><?php echo $res['title']; ?></legend>
<!--视屏播放区-->
<div class="am-u-sm-12 am-u-md-8" id="stage_video" >
    <!--引入播放器样式-->
    <link href="http://vjs.zencdn.net/5.19/video-js.min.css" rel="stylesheet">
    <!--引入播放器js-->
    <script src="./assets/js/video.min.js"></script>
    <script src="./assets/js/videojs-flash.min.js"></script>
<!--vjs-big-play-centered 播放按钮居中-->
<!--poster默认的显示界面，就是还没点播放，给你显示的界面-->
<!--controls 规定浏览器应该为视频提供播放控件-->
<!--preload="auto" 是否提前加载-->
<!--autoplay 自动播放-->
<!--loop=true 自动循环-->

<video id="my-player" class="video-js vjs-default-skin vjs-big-play-centered" controls   width="955" height="505"  autoplay data-setup='{}'>
    <source src='<?php echo RTMP_URL."?streamname=".$streamname; ?>' type='rtmp/flv' />
</video>
</div>
<!--聊天区-->
 <div class="am-u-sm-12 am-u-md-4" id="stage_chat">
<label id="aud_num">观众人数:0</label>
<?php loadalert(); ?>
 <pre id="message_show" class="am-pre-scrollable" style="max-height: 35rem;">
[系统]:请文明发言,争做文明好市民
</pre>
 <div class="am-input-group">
      <input type="text" class="am-form-field" id="message" placeholder="输入你的评论吧!" id="message" required>
      <span class="am-input-group-btn">
        <button class="am-btn am-btn-secondary" type="button" onclick="send_mes()" id="button_send">发送</button>
      </span>
    </div>
  </div>
</div>
</div>
<div id="last" style="display:none;">1</div>
<script>
var streamname="<?php echo $res['streamname']; ?>";
get_audience();
setInterval(function(){get_audience();},60000);
setInterval(function(){get_mes();},10000);
function get_audience(){
	$.ajax({
  type: 'POST',
  async: false,
  url: 'index.php',
  data: { broadcast: true, getaud:true , streamname: streamname },
  success:function(data){
	  var response=$.parseJSON(data);
	  if(response.status=="success"){
	  $("#aud_num").text("观众人数:"+response.aud_num);
	  }
  }
	});
	}
	
function send_mes(){
	var message=$("#message").val()+"\n";
	$.ajax({
  type: 'POST',
  async: false,
  url: 'index.php',
  data: { chat: true, send:true , streamname: streamname , username:'<?php if(isset($_SESSION['username'])){echo $_SESSION['username'];}else{echo "unknown";} ?>' , message:message },
  beforeSend:function(){
			alert_info("评论发送中..");
			$("#button_send").attr("disabled",true);
			$("#message").attr("disabled",true);
	},
  success:function(data){
	  var response=$.parseJSON(data);
	  if(response.status=="success"){
		  alert_success(response.describe);
		  $("#message_show").append("[<?php if(isset($_SESSION['username'])){echo $_SESSION['username'];}else{echo "Unknown";} ?>]:"+message);
	  }else if(response.status=="danger"){
		  alert_danger(response.describe);
	  }else if(response.status=="warning"){
		  alert_warning(response.describe);
	  }
	  setTimeout(function(){
			  remove_alert();
		  },2000);
	  setTimeout(function(){
		$("#button_send").attr("disabled",false);
		$("#message").attr("disabled",false);
		  },5000);
  }
	});
}

function get_mes(){
	var message=$("#message").val(),i,last=$("#last").text(),scrollHeight;
	$.ajax({
  type: 'POST',
  async: false,
  url: 'index.php',
  data: { chat: true, get:true , streamname: streamname ,username:'<?php if(isset($_SESSION['username'])){echo $_SESSION['username'];}else{echo "Unknown";} ?>',last:last },
  success:function(data){
	  var response=$.parseJSON(data);
	  if(response.status=="success"){
		  for(i=0;i<response.message.length;i++){
			$("#message_show").append(response.message[i]);
		  }
		    scrollHeight = $('#message_show').prop("scrollHeight");
			$('#message_show').animate({scrollTop:scrollHeight}, 400);
		  $("#last").text(response.last);
	  }else if(response.status=="danger"){
		  alert_danger(response.describe);
	  }
  }
	});
}
</script>
</body>