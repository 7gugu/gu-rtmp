<header class="am-topbar .am-with-topbar-fixed-top">
    <h1 class="am-topbar-brand">
        <a href="#"><?php echo SYSTEM_NAME;?></a>
    </h1>

    <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#doc-topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

    <div class="am-collapse am-topbar-collapse" id="doc-topbar-collapse">
        <ul class="am-nav am-nav-pills am-topbar-nav">
            <li <?php if(strstr($_GET['mod'],"broadcast")||strstr($_GET['mod'],"search"))echo "class='am-active'"; ?>><a href="index.php?mod=search">公共直播间</a></li>
            <li <?php if(strstr($_GET['mod'],"room"))echo "class='am-active'"; ?>><a href="index.php?mod=user:room">房间信息</a></li>
            <li <?php if(strstr($_GET['mod'],"setting"))echo "class='am-active'"; ?>><a href="index.php?mod=user:setting">设置信息</a></li>
			<?php if(@$_SESSION['access']==2){ ?>
            <li <?php if(strstr($_GET['mod'],"account"))echo "class='am-active'"; ?>><a href="index.php?mod=admin:account">管理账户</a></li>
            <li <?php if(strstr($_GET['mod'],"about"))echo "class='am-active'"; ?>><a href="index.php?mod=admin:about">关于系统</a></li>
			<?php } ?>
        </ul>
        <div class="am-topbar-right">
		<?php
		if(!isset($_SESSION['username'])&&!isset($_SESSION['password'])){
		?>
            <button onclick="window.location='index.php?mod=signin'" class="am-btn am-btn-primary am-topbar-btn am-btn-sm">登录</button>
			<?php 
		}else{
			?>
			<button onclick="window.location='index.php?mod=signout'" class="am-btn am-btn-primary am-topbar-btn am-btn-sm">注销</button>
			<?php
		}
			?>
        </div>
    </div>
</header>