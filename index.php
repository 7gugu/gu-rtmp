<?php
/**
 * 页面路由系统
 * @param string mod 请求页面名
 */
session_start();
require dirname(__FILE__).'/init.php';
if(isset($_GET['mod'])){
    $mode=htmlspecialchars($_GET['mod']);
    template('control');
}elseif(isset($_GET['publish'])){
	include_once './lib/publish.php';//rtmp鉴权
}
else{
    redirect('index.php?mod');
}
loadfoot();
die;
?>