<?php 
/**
 * 检索直播间的streamname
 */
if(isset($_POST['broadcast'])){
	global $sql;
	$p=$_POST;
	$streamname=$p["streamname"];
	$context="select * from whitelist where `streamname`='{$streamname}'";
	$connect=$sql->connect();
	$res=$sql->query($connect,$context);
	$res=$sql->fetch_array($res);
	if(count($res)){
		if($res['stream_state']==0){
		echo json_encode(array(
		"status"=>"warning",
		"describe"=>"直播未开始.",
		"aud_num"=>0,
		));
		die();
	}elseif(isset($_POST['getaud'])){
		echo json_encode(array(
		"status"=>"success",
		"aud_num"=>$res['aud_num'],
		));
		die();
	}else{
		echo json_encode(array(
		"status"=>"success",
		"describe"=>"开始播放直播流..",
		));
		die();
	}
	}else{
		echo json_encode(array(
		"status"=>"danger",
		"describe"=>"StreamName不存在,请稍后重试..",
		));
		die();
	}
}
?>