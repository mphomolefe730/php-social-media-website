<html>
<head>
	<style>
		a{
			text-decoration: none;
			color:black;
		}
		#navcontainer{
			background-color:  #0056b8;
			padding:10px;
		}
		.buttons{
			padding: 5px 10px;
			color: white;
		}
		*{
			font-family: system-ui;
		}
		body{
			margin:0;
		}
		h1{
			margin:5px;
			text-transform: uppercase;
		}
	</style>
</head>
<body>
	<div id='navcontainer'>
		<nav >
			<span><a class='buttons' href="homepage.php"> Home </a></span>
			<span><a class='buttons' href="search.php"> Search User </a></span>
			<span><a class='buttons' href="message.php"> Messages </a></span>
			<span><a class='buttons' href="profile.php"> Profile </a></span>
			<span><a style="background-color: red;border-radius:12px;" class='buttons' href="logout.php"> Logout </a></span>
		</nav>
	</div>
<?php
	$servername = "127.0.0.1";
	$username = "root";
	$password = "";
	$database = "social_media";
	
	session_start();
	if(isset($_SESSION['userName'])){
		$userInfo = array("name" => $_SESSION['userName'], "surname"=> $_SESSION['userSurname'], "id" => $_SESSION['userId']);
		$userId = $userInfo["id"];
		$userName = $userInfo['name'];
		$userSurname = $userInfo['surname'];
	}else{
		header('location: login.php');
	}
?>
</body>
</html>