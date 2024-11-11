<html>
<head>
	<title>Registration Page</title>
</head>
<style>
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
body{
	margin:0;
}
#main{
	display:grid;
	height:100svh;
}
.error{
	color:red;
}

#submitButton{
	padding: 15px;
	color: white;
	background-color:  #0056b8;
	border-radius:12px;
	border:0;
}
</style>
<body>
	<?php
		if ($_SERVER["REQUEST_METHOD"] == "POST"){
			$errors = [];
			//values from form
			$name = $_POST['name'];
			$surname = $_POST['surname'];
			$password = $_POST['password'];
			$email = $_POST['email'];
			$password_hashed = password_hash($password, PASSWORD_DEFAULT);
			
			//valus for database
			$servername = "127.0.0.1";
			$username = "root";
			$password = "";
			$database = "social_media";
			
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			  $errors['email'] = "Invalid email format";
			}	
			if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
			  $errors['name'] = "Only letters and white space allowed";
			}
			if (!preg_match("/^[a-zA-Z-' ]*$/",$surname)) {
			  $errors['surname'] = "Only letters and white space allowed";
			}
			if (empty($_POST['name'])){
				$errors['name'] = 'please enter a name';
			}
			if (empty($_POST['surname'])){
				$errors['surname'] = 'please enter a surname';
			}
			if (empty($_POST['password'])){
				$errors['password'] = 'Invalid password';	
			}
			if ($errors == []){
				//creates account
				$query = "INSERT INTO `users` (`name`, `surname`, `email`, `password`,`id`) VALUES ('$name', '$surname', '$email', '$password_hashed', uuid())";
				$conn = mysqli_connect($servername, $username, $password, $database);
				$result = mysqli_query($conn,$query);
				
				if (!$conn) {
				 die("Connection failed: " . mysqli_connect_error());
				}
				if($result){
					header('Location: login.php');
					exit();
				}

				mysqli_close($conn);		
			}
		}		
	?>
	
	<div id='main'>
		<div style="background-color:#0056b8;">
			<img src='images/social_media_cover_image.webp' width='250px'>
		</div>
		<div>
			<form method='POST' action='' id='contact_form'>
				<h1>Registration PAGE</h1>
				<div class='container'>
					<label>Name: </label>
					<input type="text" name="name" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
					<p style='color:red;'><?php echo $errors['name'] ?? '' ?></p>
				</div>
				<div class='container'>
					<label>Surname: </label>
					<input type='text' name='surname' value="<?php echo htmlspecialchars($_POST['surname'] ?? ''); ?>"/>
					<p style='color:red;'><?php echo $errors['surname'] ?? '' ?></p>
				</div>
				<div class='container'>
					<label>Email: </label>
					<input type='email' name='email' value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"/>
					<p style='color:red;'><?php echo $errors['email'] ?? '' ?></p>
				</div>
				<div class='container'>
					<label>Password: </label>
					<input type='password' name='password'/><span style='color:red;'>
					<p><?php echo $errors['password'] ?? '' ?></p>
				</div>
				<div>
					<p>Have an account? <a href='login.php'>login</a></p>
				</div>
				<div>
					<input type='submit' id='submitButton' name='submitButton' value='SUBMIT'/>
				</div>
				
			</form>
		</div>
	</div>
</body>
</html>
