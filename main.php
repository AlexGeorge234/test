<!DOCTYPE html>
<html>
	<head> 
		<meta charset="utf-8">
		<title>个人主页</title> 
	</head>
	<body>
	 
		<div id="container" style="width:1000px">
		 
			<div id="header" style="background-color:#FFA500;text-align:center;">
				<h1 style="margin-bottom:0;">造价控制部</h1>
			</div>
			 
			<div id="menu" style="background-color:#FFD700;height:200px;width:200px;float:left;">
				<b>菜单</b><br>
				<button>账号信息</button><br>
				<button>任务状态</button><br>
				<button>结算合同申报状态表</button>
			</div>
			 
			<div id="content" style="background-color:#EEEEEE;height:200px;width:800px;float:left;">
				<?php
					session_start();
					$user = $_SESSION['user'];
					
					// 连接据库
					$con = mysqli_connect('localhost', 'root','root');
					// 验证数据库的连接状态
					if (mysqli_errno($con)) {
						echo "连接失败，请重试".mysqli_error($con);
						exit;
					}		
					// 设置解码方式
					mysqli_set_charset($con, 'utf-8');
					// 设置数据库
					mysqli_select_db($con,'mydb');
					$sql = "select * from 合同表 where 合同执行人 = '$user'";
					$result = mysqli_query($con, $sql);
					
					if (mysqli_num_rows($result) > 0) {
						// 输出数据
						echo "id: " ."    ". 
							" - 合同编号: " . "            ". 
							" - 合同名称: " . "                                    ". 
							" - 合同执行人: " ."            ". 
							"<br>";
						while($row = $result->fetch_assoc()) {
							echo  $row["Id"]. "    ".
							$row["合同编号"].  "   ". 
							$row["合同名称"]. "   ". 
							$row["合同执行人"]. " ". 
							"<br>";
						}
					} else {
						echo "0 结果";
					}
					
					unset($_SESSION['user']);
					mysqli_close($con);
				?> 
			</div>
			 
			<div id="footer" style="background-color:#FFA500;clear:both;text-align:center;">
				版权 © run.com
			</div>
		 
		</div>
	
	</body>
</html>
