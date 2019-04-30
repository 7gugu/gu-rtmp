<?php 
/**
 * 主播房间管理-逻辑模块
 */
if(isset($_POST['room'])){
	global $sql;
	$username=$_POST["username"];
	$connect=$sql->connect();
	if(isset($_POST['update'])){
		$newtitle=$_POST['newtitle'];
		$context="update whitelist set `title`='{$newtitle}' where `username`='{$username}'";
	$res=$sql->query($connect,$context);
	$res=$sql->affected_rows($connect);
	if($res){
		echo json_encode(array(
		"status"=>"success",
		"describe"=>"数据已更新.",
		));
	}else{
		echo json_encode(array(
		"status"=>"danger",
		"describe"=>"更新失败,请稍后重试..",
		));
	}
	$sql->close($connect);
	die();
	}else{
	$context="select * from whitelist where `username`='{$username}'";
	$res=$sql->query($connect,$context);
	$res=$sql->fetch_array($res);
	if(count($res)){
		echo json_encode(array(
		"status"=>"success",
		"describe"=>"数据请求成功",
		"url"=>RTMP_URL,
		"streamname"=>$res['streamname'],
		"key"=>$res['key'],
		"title"=>$res['title'],
		"state"=>$res['stream_state'],
		));
		die(); 
	}else{
		echo json_encode(array(
		"status"=>"danger",
		"describe"=>"数据请求不存在,请稍后重试..",
		));
		die();
		}
	}
}
?>