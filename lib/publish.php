<?php

global $sql;
if(isset($_GET['play'])&&isset($_GET['publish'])){
	$context="select * from whitelist where `streamname`='{$streamname}'";
	$res=$sql->query($connect,$context);
	$res=$sql->fetch_array($res);
	$aud_num=$res['aud_num']++;
	$context="update whitelist set `aud_num`='{$aud_num}' where `streamname`='{$streamname}'";
	$res=$sql->query($connect,$context);
	exit();
}
if(isset($_GET['play_done'])&&isset($_GET['publish'])){
	$context="select * from whitelist where `streamname`='{$streamname}'";
	$res=$sql->query($connect,$context);
	$res=$sql->fetch_array($res);
	if($res['aud_num']>0){
	$aud_num=$res['aud_num']--;
	}
	$context="update whitelist set `aud_num`='{$aud_num}' where `streamname`='{$streamname}'";
	$res=$sql->query($connect,$context);
	exit();
}

if(isset($_GET['publish'])){
$connect=$sql->connect();
$aud_num=0;
if(isset($_POST['streamname'])){
	$streamname=trim($_POST['streamname']);
}else{
	$arr=array(
	"code"=>"001",
	"des"=>"直播流名称缺省!"
	);
	echo json_encode($arr);
	header("HTTP/1.1 403 Forbidden");
	exit();
}
//获取流密钥
if(isset($_POST['key'])){
	$key=trim($_POST['key']);
}else{
	$arr=array(
	"code"=>"002",
	"des"=>"直播流秘钥缺省!"
	);
	echo json_encode($arr);
	header("HTTP/1.1 403 Forbidden");
	exit();
}
//推流状态更新
if(isset($_GET['done'])){
		$context="update whitelist set `stream_state`='0' where `streamname`='{$streamname}'";
		$sql->query($connect,$context);
		//用这个删除直播间的聊天内容,简单省事
		$context="delete from account where streamname='{$streamname}'";
		$sql->query($connect,$context);
		die();
	}else{
		$context="update whitelist set `stream_state`='1' where `streamname`='{$streamname}'";、
}
$context="select count(*) from whitelist where `streamname`='{$streamname}' and  `key` ='{$key}'";
$res=$sql->query($connect,$context);
$res=$sql->fetch_array($res);
$sql->close($connect);
if($res[0]>0){
	$arr=array(
	"code"=>"003",
	"des"=>"直播推流成功!"
	);
	echo json_encode($arr);	
	exit();
}else{
	$arr=array(
	"code"=>"004",
	"des"=>"直播流未在白名单!"
	);
	echo json_encode($arr);	
	header("HTTP/1.1 403 Forbidden");
	exit();
}
}

