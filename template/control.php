<?php if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); }
global $mode;
if(isset($_SESSION['access'])){$access=$_SESSION['access'];}else{$access="0";}//0游客1用户2管理员
$parse=array();
if(strstr($mode , ':')) {$parse = explode(':',$mode);}else{$parse[0]=$mode;$parse[1]="";}
switch ($parse[0]) {
    case 'signin':
        loadhead('登录');
        template('header');
        template('signin');
        break;
    case 'signup':
        loadhead('注册');
        template('header');
        template('signup');
        break;
	case 'broadcast':
        loadhead('公共直播间');
        template('header');
        template('broadcast');
        break;
	case 'search':
        loadhead('公共直播间');
        template('header');
        template('search');
        break;
    case 'user':
        if ($access < 1) alert('warning','请先登录后再操作！','index.php?mod=signin');//使用session来储存权限
        switch($parse[1]) {
            case 'room':
                loadhead('我的房间');
                template('header');
                template('room');
                break;
            case 'setting':
                loadhead('设置信息');
                template('header');
                template('setting');
				break;
            case 'signout':
                loadhead('登出系统');
                template('header');
				unset($_SESSION['username']);
				unset($_SESSION['password']);
				unset($_SESSION['access']);
                template('signout');
                break;
            default:
                loadhead('我的房间');
                template('header');
                template('room');
                break;
        }
        break;
    case 'admin':
        if ($access < 2) alert('danger','权限不足！','index.php?mod');//使用session来储存权限
        switch($parse[1]) {
            case 'account':
                loadhead('管理用户');
                template('header');
                template('admin-account');
                break;
            case 'about':
                loadhead('关于系统');
                template('header');
                template('admin-about');
                break;
            default:
                loadhead('管理用户');
                template('header');
                template('admin-account');
                break;
        }
        break;
    default:
        loadhead('登录');
        template('header');
        template('signin');
        break;
}
?>