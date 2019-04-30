<?php 

if(isset($_POST['reset_password'])){
	global $sql;
	$username=$_POST['username'];
	$password=$_POST['password'];
	$accountid=$_POST['accountid'];
	$connect=$sql->connect();
	$context="select * from account where `username`='{$username}' and `password`='{$password}'";
	$res=$sql->query($connect,$context);
	$res=$sql->fetch_array($res);
	if($res["access"]==2){
		$context="update account set `password`='123456' where `Id`='{$accountid}'";
		$res=$sql->query($connect,$context);
		$res=$sql->affected_rows($connect);
		if($res>0){
				echo json_encode(array(
		"status"=>"success",
		"describe"=>"密码重置成功!密码为:123456",
		));
		}else{
			echo json_encode(array(
		"status"=>"warning",
		"describe"=>"密码已恢复初始状态.",
		));
		}
	}else{
			echo json_encode(array(
		"status"=>"danger",
		"describe"=>"权限不足.",
		));
	}
	$sql->close($connect);
	die();
}

if(isset($_POST['delete_user'])){
	global $sql;
	$username=$_POST['username'];
	$password=$_POST['password'];
	$accountid=$_POST['accountid'];
	$connect=$sql->connect();
	$context="select * from account where `username`='{$username}' and `password`='{$password}'";
	$res=$sql->query($connect,$context);
	$res=$sql->fetch_array($res);
	if($res["access"]==2){
		$context="delete from account where Id='{$accountid}'";
		$res=$sql->query($connect,$context);
		$res=$sql->affected_rows($connect);
		if($res>0){
				echo json_encode(array(
		"status"=>"success",
		"describe"=>"用户已删除,正在重载用户数据..",
		));
		}else{
			echo json_encode(array(
		"status"=>"warning",
		"describe"=>"用户删除失败.",
		));
		}
	}else{
			echo json_encode(array(
		"status"=>"danger",
		"describe"=>"权限不足.",
		));
	}
	$sql->close($connect);
	die();
}
?>