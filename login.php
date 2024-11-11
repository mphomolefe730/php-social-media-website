<html>
<head>
	<title>Login Page</title>
</head>
<style>
body{
	margin:0;
}
#main{
	display:grid;
	height:100svh;
}
form{
	text-align: center;	
	padding: 10px;
}
.container{
	margin:10px;
}
label{
	display:block;
}
#submitButton{
	padding: 15px;
	color: white;
	background-color: #0056b8;
	border-radius:12px;
	border:0;
}
@media screen and (min-width: 480px){	
	
}
</style>
<body>
	<?php	
		if ($_SERVER["REQUEST_METHOD"] == "POST"){			
			$servername = "127.0.0.1";
			$username = "root";
			$password = "";
			$database = "social_media";
			
			$conn = mysqli_connect($servername, $username, $password, $database);
			$userInputPassword = $_POST['password'];
			$email = $_POST['email'];
			$errors = [];	
			$sql = "SELECT `name`, `surname`, `email`, `password`, `id` FROM `users` WHERE `email` like '$email'";
			
			$result = mysqli_query($conn, $sql);
			$loginInfo = mysqli_fetch_all($result, MYSQLI_ASSOC);
			
			if($loginInfo == null){
				$errors['empty'] = 'Please Enter All Fields';
			}else{				
				$hashedPassword = $loginInfo[0]['password'];
				if(password_verify($userInputPassword,$hashedPassword)){
					session_start();
					$_SESSION['userName'] = $loginInfo[0]['name'];
					$_SESSION['userSurname'] = $loginInfo[0]['surname'];
					$_SESSION['userId'] = $loginInfo[0]['id'];
					header('Location: homepage.php');
					exit();
				}else{
					$errors['WrongPassword'] = 'Incorrect Information, wrong email or password';
				}
			}
			
			mysqli_close($conn);	
		}
	?>
	<div id='main'>
		<div style="background-color:#0056b8;">
			<img src='images/social_media_cover_image.webp' width='250px'>
		</div>
		<div>
			<form method='POST' action=''>
				<h1>LOGIN PAGE</h1>
				<div class='container'>
					<label>Email: <label>
					<input type='email' name='email' value='<?php echo $email ?? "" ?>'/>
				</div>
				<div class='container'>
					<label>Password: <label>
					<input type='password' name='password'/>
				</div>
				<p style='color:red;'><?php echo $errors['WrongPassword'] ?? "" ?></p>
				<p style='color:red;'><?php echo $errors['empty'] ?? "" ?></p>
				<div>
					<p>No account? <a href='register.php'>register</a></p>
				</div>
				<div>
					<input type='submit' value='SUBMIT' id='submitButton'/>
				</div>
			</form>
		</div>	
	</div>
</body>
</html>
