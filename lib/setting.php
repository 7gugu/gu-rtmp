<?php 
/**
 * 拉取用户的个人信息
 */
if(isset($_POST['information'])){
	global $sql;
	$username=$_POST['username'];
	$password=$_POST['password'];
	$connect=$sql->connect();
	$context="select * from account where `username`='{$username}' and `password`='{$password}'";
	$res=$sql->query($connect,$context);
	$res=$sql->fetch_array($res);
	if($res){
		echo json_encode(array(
		"status"=>"success",
		"describe"=>"数据已更新.",
		"nickname"=>$res['nickname'],
		));
	}else{
		echo json_encode(array(
		"status"=>"danger",
		"describe"=>"获取失败,请稍后重试..",
		));
	}
	$sql->close($connect);
	die();
}

/**
 * 更新用户的个人信息
 */
if(isset($_POST['update_information'])){
	global $sql;
	$username=$_POST['username'];
	$password=$_POST['password'];
	$connect=$sql->connect();
	if(isset($_POST['newpassword'])&&($_POST['newpassword']!='false')){
		$context="update account set `password`='{$_POST['newpassword']}' where `password`='{$password}' and `username`='{$username}'";
	}
	if(isset($_POST['newnickname'])&&($_POST['newnickname']!='false')){
		$context="update account set `nickname`='{$_POST['newnickname']}' where `password`='{$password}' and `username`='{$username}'";
	}
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
}

?>