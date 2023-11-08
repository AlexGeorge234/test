<?php
	// 告知浏览器我们是html，解码用utf-8，header()表示向客户端发送一个原始的http包头
	header('Content-type:text/html; charset=utf-8');
	
	// 处理用户登录信息
	// $_POST[]的变量应该是请求的html页面中，通过name被复制的变量
	if (isset($_POST['logon'])) {
		#接受用户的登录消息，trim去掉字符串中的空格
		$user = trim($_POST['user']);
		$password = trim($_POST['password']);
		$password2 = trim($_POST['password2']);
		// 判断提交的登录信息
		if (($user == "") || ($password == "")) {
			// 若为空，视为未填写，提示错误，并3秒后返回注册界面
			header('refresh:3; url=logon.html');
			echo "用户名或密码不能为空，系统将在3秒后跳转到注册界面，请重新填写注册信息!";
			exit;
		}else if($password != $password2){
			// 若两次密码不同，提示错误，并3秒后返回注册界面
			header('refresh:3; url=logon.html');
			echo "两次密码不同，系统将在3秒后跳转到注册界面，请重新填写注册信息!";
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
		$sql = "select * from login where user = '$user'";
		$result = mysqli_query($con, $sql);
		$num = mysqli_num_rows($result);
		if ($num){
			header('refresh:3; url=logon.html');
			echo "用户名已存在，系统将在3秒后跳转到注册界面，请重新填写注册信息!";
			exit;
		}else {
			$sql = "INSERT INTO login (user, password) VALUES ('$user', '$password')";
			 
			if (mysqli_query($con, $sql)) {				
				header('refresh:1; url=index.html');
				echo "注册成功! 正跳转登录页面。";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}			
			mysqli_close($con);
		}
	}
?>