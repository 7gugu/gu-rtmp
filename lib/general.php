<?php
/**
 * 加载系统或插件的模板（或文件）
 * @param string $file 文件路径
 * @return mixed
 */
function template($file) {
        return include SYSTEM_ROOT . 'template/' . $file . '.php';
}

/**
 * 重定向链接
 * @param string $url 目标URL
 */
function redirect($url) {
    header("Location: ".$url);
}

/**
 * 加载提示框
 * @return 返回alert的模板数据
 */
function loadalert() {
    return include SYSTEM_ROOT . 'template/common/alert.php';
}

/**
 * 加载头部
 * @param string $title 页面标题
 */
function loadhead($title = '') {
    ob_start();
    include_once SYSTEM_ROOT ."template/common/head.php";
}

/**
 * 加载列表组件
 */
function loadlist() {
    global $sql;
	$mod=explode(':',$_GET['mod']);
	if($mod[0]==""){return;}
	$table="history";
	if($mod[1]=="history"){$table="sportlog";}
	if($mod[1]=="account"&&$_SESSION['access']==2){$table="account";}
	if($_SESSION['access']==2&&$mod[0]=="admin"){
		$context="SELECT count(*) FROM `{$table}`";
	}else{
		$context="SELECT count(*) FROM `{$table}` where `username`='{$_SESSION['username']}' ";
	}
	$connect=$sql->connect();
	$result=$sql->query($connect,$context);
	$res=$sql->fetch_array($result);
	$perNumber=5;
    @$page=$_GET['page'];
	$totalNumber=$res[0];
    $totalPage=ceil($totalNumber/$perNumber);//四舍五入取一个亿作为总页数
    if (!isset($page)) {
        $page=1;
    }
	$startCount=($page-1)*$perNumber; //分页开始,根据此方法计算出开始的记录
	if($_SESSION['access']==2&&$mod[0]=="admin"){
		$context= "SELECT * FROM `{$table}` limit $startCount,$perNumber";//合成查询语句
	}else{
		$context= "SELECT * FROM `{$table}` where `username`='{$_SESSION['username']}' order by Id desc limit $startCount,$perNumber";//合成查询语句
	}
    $result=$sql->query($connect,$context); //根据前面的计算出开始的记录和记录数
	$num=0;
	if($mod[1]=="account"&&$_SESSION['access']==2){
		foreach($result as $data){
			if($data['username']==$_SESSION['username']){continue;}
		$num++;
		echo "<section class='am-panel am-panel-default'>";
		echo "<div class='am-panel-bd am-radius'><h3 class='am-panel-title'><div style='display:inline' name='".$data['Id']."' id='".$data['Id']."'>".$data['username']."</div> <span class='am-badge am-badge-secondary am-radius'>".$data['created_time']."</span>
		<div class=\"am-fr\" >
		<button type='button' name='button_reset' id='button_reset' onclick=\"reset_password(".$data['Id'].")\" class='am-btn am-btn-warning am-btn-sm '>重置密码</button>&nbsp;
		<button type='button' name='button_delete' id='button_delete' onclick=\"delete_user(".$data['Id'].")\" class='am-btn am-btn-danger am-btn-sm '>删除用户</button>
		</div>
		</h3>
		";
		echo "</div></section>";
		}
		if(!$num){
		echo "<section class='am-panel am-panel-default'><div class='am-panel-bd'>暂无用户数据!</div></section>";
		}
	}else{
	foreach($result as $data){
		$num++;
		echo "<section class='am-panel am-panel-default'>";
		echo "<header class='am-panel-hd'><h3 class='am-panel-title'>户外跑 <span class='am-badge am-badge-warning am-radius'>".$data['start_time']."</span></h3></header>";
		echo "<div class='am-panel-bd'><table class='am-table am-table-bordered'><thead><tr><th>距离</th><th>卡路里</th><th>时长</th></tr></thead><tbody>";
		echo "<tr><td>".$data['distance']."公里</td><td>".$data['kcal']."千卡</td><td>".$data['totalTime']."</td></tr>";
		echo "</tbody></table><div id='".$data['Id']."' style='height:400px;'></div></div></section>";
		?>
		<script>
			 Highcharts.setOptions({ global: { useUTC: false } }); 
       var chart = Highcharts.chart('<?php echo $data['Id']; ?>',{
	chart: {
		type: 'areaspline'
	},
	title: {
		text: '配速'
	},
	xAxis: {
		allowDecimals: false,
		type: 'datetime',
		
	},
	yAxis: {
		title: {
			text: '配速'
		},
		labels: {
			formatter: function () {
				return this.value ;
			}
		}
	},
	tooltip: {
		pointFormat: ' 配速:<b>{point.y:,.2f}</b>'
	},
	plotOptions: {
		area: {
			pointStart: <?php echo strtotime($data['start_time'])*1000 ;?>,
			marker: {
				enabled: false,
				symbol: 'circle',
				radius: 2,
				states: {
					hover: {
						enabled: true
					}
				}
			}
		}
	},
	series: [{
		name: '我',
		data: [
		<?php 
		$pace=json_decode($data['pace']);
		$start=strtotime($data['start_time'])*1000;
		for($i=0;$i<count($pace);$i++){
			echo "[".$start.",".$pace[$i]."],";
			$start=$start+30*1000;
		}
		?>
		]
	}]
});
    </script>
		<?php
	}
	if(!$num){
		echo "<section class='am-panel am-panel-default'><div class='am-panel-bd'>暂无运动数据!</div></section>";
		}
	}

	
}

/**
 * 加载分页组件
 */
function loadpagination() {
	global $sql;
	$mod=explode(':',$_GET['mod']);
	if($mod[0]==""){return;}
	$table="history";
	if($mod[1]=="history"){$table="sportlog";}
	if($mod[1]=="account"&&$_SESSION['access']==2){$table="account";}
	if($_SESSION['access']==2&&$mod[0]=="admin"){
		$context="SELECT count(*) FROM `{$table}`";
	}else{
		$context="SELECT count(*) FROM `{$table}` where `username`='{$_SESSION['username']}' ";
	}
	$connect=$sql->connect();
	$result=$sql->query($connect,$context);
	$res=$sql->fetch_array($result);
	$perNumber=5;
    @$page=$_GET['page'];
	$totalNumber=$res[0];
    $totalPage=ceil($totalNumber/$perNumber);//四舍五入取一个亿作为总页数
    if (!isset($page)) {
        $page=1;
    }
	echo "<ul data-am-widget='pagination'class='am-pagination am-pagination-default am-fr'>";
	if ($page != 1) { 
		echo " <li class='am-pagination-prev '><a href='index.php?mod=".$_GET['mod']."&page=".($page-1)."' class=''>←</a></li>";
	}else{
		echo " <li class='am-pagination-prev am-disabled'><a href='' class=''>←</a></li>";
	}
	if ($page<$totalPage) {
		echo "<li class='am-pagination-next '><a href='index.php?mod=".$_GET['mod']."&page=".($page+1)."' class=''>→</a></li>";
	}else{
	    echo "<li class='am-pagination-next am-disabled'><a href='' class=''>→</a></li>";
	}
	echo "</ul>";
	$sql->close($connect);
}

/**
 * 加载底部
 */
function loadfoot() {
    include_once SYSTEM_ROOT ."template/common/footer.php";
    ob_end_flush();
}

/**
 * 创建一个提示
 */
function alert($state="info",$content="无",$url=false){
    if($state=="info"){
        $_SESSION['info']=$content;
    }else if($state=="success"){
        $_SESSION['success']=$content;
    }else if($state=="warning"){
        $_SESSION['warning']=$content;
    }else if($state="danger"){
        $_SESSION['danger']=$content;
    }
	if($url){
    redirect($url);
	}
}