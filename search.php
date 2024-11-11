<html>
<head>
	<title>Search</title>
</head>
	<style>
		.post{
			margin:5px;
			padding: 5px;
			border-radius:12px;
		}
		#submitButton{
			padding: 10px;
			color: white;
			background-color:  #0056b8;
			border-radius:12px;
			border:0;
		}
	</style>
<body>
	 <?php
		require('navBar.php');
		$users = array();
		if($_SERVER['REQUEST_METHOD'] == 'POST'){		
			$search = $_POST['search'];
			$query = "SELECT `name`,`surname`,`id` FROM `users` WHERE `name` like '%$search%' limit 10";
			
			$conn = mysqli_connect($servername, $username, $password, $database);
			$result = mysqli_query($conn,$query);
			$users = mysqli_fetch_all($result, MYSQLI_ASSOC);
			mysqli_close($conn);	
		} 
	 ?>
	<h1>Search User</h1>	
	<form action='' class='post' method='POST'>
		<input type='text' name='search' placeholder='Search by name' style='border: 1px solid black;padding: 10px;border-radius:12px;'/>
		<input type='submit' id='submitButton' value='Search'/>
	</form>
	
	<h1>Search Results</h1>
	<div>
		<?php foreach($users as $key=>$user){ ?>
			<div  style="padding: 7.5px; margin: 5px;border:black solid 1px;">
				<a href="viewprofile.php?profile=<?php echo $user['id']?>">
					<span><?php echo htmlspecialchars($key+1)?></span><span> <?php echo htmlspecialchars($user['name']) . "  " . htmlspecialchars($user['surname'])?></span>				
				</a>
			</div> 
		<?php }?>
	</div>
</body>
</html>