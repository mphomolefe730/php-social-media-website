<html>
<head>
	<title>profile</title>
</head>
	<style>
		img{
			width:100px;
			height:100px;
			border-radius: 50px;
			object-fit:cover;
			margin:10px;
		}
		label{
			display:block;
		}		
		#submitButton{
			margin:10px;
			padding: 15px;
			color: white;
			background-color: rgba(255,0,0,1);
			border-radius:12px;
			border:0;
		}
	</style>
<body>
	 <?php
		require('navBar.php');
		$profile= [];
		if ($_SERVER['REQUEST_METHOD'] == "POST"){
			
		}
		$query = "SELECT * FROM `profiles` WHERE `userId` = '$userId'";
		$conn = mysqli_connect($servername, $username, $password, $database);
		$result = mysqli_query($conn,$query);
		$profile = mysqli_fetch_all($result, MYSQLI_ASSOC)[0];
		mysqli_close($conn);
	 ?>
	<h1 style='margin:5px'>Profile</h1>
	<div>
		<img src='<?php echo $profile['path']?>'/> 
	</div> 	
	<input style='margin:10px' type='image' value='Upload New Profile Picture'/>
	<form action='' method='post'>
		<div style='margin:10px'>
			<label>Name:</label>
			<input type='text' value="<?php echo htmlspecialchars($userName ?? '') ?>"/>
		</div>
		<div style='margin:10px'>
			<label>Surname:</label>
			<input type='text' value="<?php echo htmlspecialchars($userSurname ?? '') ?>"/>
		</div>
		<input id='submitButton' type='submit' value='submit'/>
	</form>
</body>
</html>