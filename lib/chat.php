<?php 
global $sql;
if(isset($_POST['chat'])){
	$connect=$sql->connect();
	/**
	* 接受发出的聊天信息
	*/
	if(isset($_POST['send'])){
		$streamname=trim($_POST['streamname']);
		$username=trim($_POST['username']);
		$message=trim($_POST['message']);
		if($username=="unknown"||$username==""){
			echo json_encode(array(
					"status"=>"danger",
					"describe"=>"请登录后再评论!",
			));
			die();
		}
		if($message==""){
			echo json_encode(array(
					"status"=>"warning",
					"describe"=>"消息不可为空!",
			));
			die();
		}
		if($streamname==""){
			echo json_encode(array(
					"status"=>"warning",
					"describe"=>"StreamName不可为空!",
			));
			die();
		}
	$updated_time=$created_time=date("Y-m-d H:i:s");
	$context="insert into chat(username,context,streamname,updated_time,created_time)values('{$username}','{$message}','{$streamname}','{$updated_time}','{$created_time}')";
    $res=$sql->query($connect,$context);
	if($res){
		echo json_encode(array(
					"status"=>"success",
					"describe"=>"评论发送成功!",
			));
			die();
	}else{
		echo json_encode(array(
					"status"=>"warning",
					"describe"=>"请勿频繁发送评论!",
			));
			die();
	}
	}
	/**
	* 检索发出的聊天信息[50条]
	*/
	if(isset($_POST['get'])){
		$streamname=$_POST['streamname'];
		$username=$_POST['username'];
		$last=$_POST['last'];
		$end=$last+20;
		if($streamname==""){
			echo json_encode(array(
					"status"=>"warning",
					"describe"=>"StreamName不可为空!",
			));
			die();
		}
		//检索聊天池
		$context="select * from chat where `streamname`='{$streamname}' and `id` between {$last} and {$end} order by `created_time` limit 20";
		$res=$sql->query($connect,$context);
		//$res=$sql->fetch_array($res);
		if($res){
			$count=0;
			$last=0;
			$message_arr=array();
			while($row=mysqli_fetch_row($res)){         
				if($username!=$row[1]){
					$message_arr[$count]="[".$row[1]."]:".$row[2]."\n";
					$count++;
				}
				$last=$row[0];
			}
			echo json_encode(array(
					"status"=>"success",
					"describe"=>"聊天数据请求成功!",
					"message"=>$message_arr,
					"last"=>$last,
			));
		}else{
			echo json_encode(array(
					"status"=>"danger",
					"describe"=>"聊天模块出现了一些问题,请稍后重试!",
			));
			die();
		}
		die();
	}
}