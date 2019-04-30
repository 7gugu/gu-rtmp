<?php

$sql = new mysql;

/**
 * 验证账户的有效性
 */
if(isset($_SESSION['username'])){
    $username=$_SESSION['username'];
    $password=$_SESSION['password'];
    $connect=$sql->connect();
    $context="select * from account where `username`='{$username}' and  `password` ='{$password}' limit 1";
    $res=$sql->query($connect,$context);
    $res=$sql->fetch_array($res);
    $sql->close($connect);
    $count=count($res);
    if($count==1){
        $_SESSION['access']=$res[0]['access'];
    }elseif(isset($_SESSION['access'])&&$count==0){
		unset($_SESSION['access']);
		unset($_SESSION['username']);
		unset($_SESSION['password']);
		alert("warning","身份信息错误!","index.php?mod=signin");
	}
}

/**
 * 转换认证凭据COOKIE->SESSION
 */
if(isset($_COOKIE['token'])){
		$token=$_COOKIE['token'];
		$connect=$sql->connect();
		$context="select count(*) from account where `token`='{$token}'";
        $res=$sql->query($connect,$context);
        $res=$sql->fetch_array($res);
		setcookie("token","",time()-30);
		setcookie("redirect","",time()-30);
		if($res[0]==1){
		$context="select * from account where `token`='{$token}'";
        $res=$sql->query($connect,$context);
        $res=$sql->fetch_array($res);
		$_SESSION['username']=$res['username'];
		$_SESSION['password']=$res['password'];
		$_SESSION['nickname']=$res['nickname'];
        $_SESSION['access']=$res['access'];
		redirect($_COOKIE['redirect']);
		}else{
			alert("warning","凭据已失效,请重新登陆","index.php?mod=signin");
		}
		$sql->close($connect);
		
	die();
}

/**
 * 登录账户
 */
if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['signin'])){
    $username=htmlspecialchars($_POST['username']);
    $password=htmlspecialchars($_POST['password']);
    $connect=$sql->connect();
    $context="select count(*) from account where `username`='{$username}' and  `password` ='{$password}' ";
    $res=$sql->query($connect,$context);
    $res=$sql->fetch_array($res);
    if($res[0]==1){
		$token=md5(time().$username);
		setcookie("token",$token,time()+30);
		setcookie("redirect","index.php?mod=user:run",time()+30);
		$context="update account set `token`='{$token}' where `username`='{$username}' and `password`='{$password}'";
		$res=$sql->query($connect,$context);
		echo json_encode(array(
		"status"=>"success",
		"describe"=>"登陆成功,请等待",
		));
		die();
    }elseif($res[0]==0){
		echo json_encode(array(
		"status"=>"danger",
		"describe"=>"用户不存在",
		));
		die();
	}else{
        echo json_encode(array(
		"status"=>"warning",
		"describe"=>"用户名或密码错误",
		));
		die();
    }
    $sql->close($connect);
	echo json_encode(array(
		"status"=>"danger",
		"describe"=>"登录系统错误...",
		));
	die();
}

/**
 * 注册账户
 */
if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['signup'])){
	if(!AUTH_STATE){
		echo json_encode(array(
		"status"=>"warning",
		"describe"=>"本站已关闭注册",
		));
		die();
	}
	$post=$_POST;
	$username=htmlspecialchars($post['username']);
	$password=htmlspecialchars($post['password']);
	$cfmpassword=htmlspecialchars($post['cfmpassword']);
	$email=htmlspecialchars($post['email']);
	if($username==""||$password==""){
		echo json_encode(array(
		"status"=>"warning",
		"describe"=>"请填写用户名或密码",
		));
		die();
	}
	if($cfmpassword!=$password){
		echo json_encode(array(
		"status"=>"warning",
		"describe"=>"密码与重复密码不一致",
		));
		die();
	}
	if($email==""){
		echo json_encode(array(
		"status"=>"warning",
		"describe"=>"请填写邮箱",
		));
		die();
	}
	$nickname=$username;
	$updated_time=$created_time=date("Y-m-d H:i:s");
	$connect=$sql->connect();
	$context="select count(*) from account where `username`='{$username}'";
	$res=$sql->query($connect,$context);
	$res=$sql->fetch_array($res);
	if($res[0]>=1){
		echo json_encode(array(
		"status"=>"warning",
		"describe"=>"用户名已存在.",
		));
		die();
	}
	$context="select count(*) from account where `email`='{$email}'";
	$res=$sql->query($connect,$context);
	$res=$sql->fetch_array($res);
	if($res[0]>=1){
		echo json_encode(array(
		"status"=>"warning",
		"describe"=>"邮箱已存在.",
		));
		die();
	}
	$pattern = '1234567890'; 
	$key=$streamname="";
    for($i=0;$i<8;$i++)   
    {   
        $key .= $pattern{mt_rand(0,9)};    //生成php随机数   
    } 
	$pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ'; 	
	for($i=0;$i<12;$i++)   
    {   
        $streamname .= $pattern{mt_rand(0,35)};    //生成php随机数   
    }   
	$context="insert into account(`username`,`password`,`email`,`access`,`nickname`,`updated_time`,`created_time`)values('{$username}','{$password}','{$email}','1','{$nickname}','{$updated_time}','{$created_time}')";
    $res=$sql->query($connect,$context);
	if($res){
		$context="insert into whitelist(`username`,`streamname`,`key`,`updated_time`,`created_time`,`stream_state`)values('{$username}','{$streamname}','{$key}','{$updated_time}','{$created_time}','0')";
		$sql->query($connect,$context);
		echo json_encode(array(
		"status"=>"success",
		"describe"=>"注册成功,正在跳转..",
		));
		die();
	}else{
		echo json_encode(array(
		"status"=>"danger",
		"describe"=>"注册失败,请稍后重试..",
		));
		die();
	}
	$sql->close($connect);
	die();
}

?>