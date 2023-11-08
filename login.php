<?php
	// 告知浏览器我们是html，解码用utf-8，header()表示向客户端发送一个原始的http包头
	header('Content-type:text/html; charset=utf-8');
	session_start(); 
	// 处理用户登录信息
	// $_POST[]的变量应该是请求的html页面中，通过name被复制的变量
	if (isset($_POST['login'])) {
		#接受用户的登录消息，trim去掉字符串中的空格
		$user = trim($_POST['user']);
		$password = trim($_POST['password']);
		// 判断提交的登录信息
		if (($user == "") || ($password == "")) {
			// 若为空，视为未填写，提示错误，并3秒后返回登录界面
			header('refresh:3; url=index.html');
			echo "用户名或密码不能为空，系统将在3秒后跳转到登录界面，请重新填写登录信息!";
			exit;
		}
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
		// 查看输入的用户名用户密码与数据库中的值是否相同
		$sql = "select * from login where user = '$user' and password = '$password'";
		$result = mysqli_query($con, $sql);
		$num = mysqli_num_rows($result);
		if (!$num){
			header('refresh:3; url=index.html');
			echo "用户名或密码错误，系统将在3秒后跳转到登录界面，请重新填写登录信息!";
			exit;
		}else {
			
			header('refresh:1; url=main.php');
			echo "登录成功!";
			// 将用户名存入sesion
			$_SESSION['user']=$user;
			mysqli_close($con);
		}
	}
?>