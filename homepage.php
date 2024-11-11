<html>
<head>
	<title>Home</title>
</head>
<style>
	.post{
		border-radius: 0;
		border: 1px solid black;
		max-width:350px;
		margin:5px;
		padding: 5px;
		border-radius:12px;
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
	<div>
	 <?php
		require('navBar.php');
	 ?>
	</div>
	
	<?php		
		$quantity = 3;
		
		//session_start();
		// $userInfo = array("name" => $_SESSION['userName'], "surname"=> $_SESSION['userSurname'], "id" => $_SESSION['userId']);
		
		$postsQuery = "SELECT * FROM `posts` WHERE `userId` = '$userId' ORDER BY `time` ASC LIMIT $quantity;";
		$conn = mysqli_connect($servername, $username, $password, $database);
		$result = mysqli_query($conn,$postsQuery);
		$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
		
		if($_SERVER['REQUEST_METHOD'] == 'POST'){		
			$post = $_POST['newpost'];
			$query = "INSERT INTO `posts` (`id`,`content`,`userId`,`userName`,`time`) VALUES (uuid(), '$post', '$userId', '$userName', CURRENT_TIMESTAMP)";
			$conn = mysqli_connect($servername, $username, $password, $database);
			$result = mysqli_query($conn,$query);
			mysqli_close($conn);	
		} 
	?>
	<div>
		<h1>Welcome <?php echo $userInfo['name'] ?> <?php echo $userInfo['surname']?></h1>
	</div>
	<form action='' class='post' method='POST'>
		<textarea placeholder='whats happening today?...' name='newpost' style='min-height:50px;min-width:150px;max-width:350px;width:100%;display:flex;border: 0;padding: 10px;margin-bottom:10px;'></textarea>
		<input type='submit' id='submitButton' value='Post'/>
	</form>
	
	<h1>Your Post</h1>
	<div>
		<div style='display: <?php echo $posts == null ? 'block' : 'none'?>;'>
			<h3  style='opacity:45%;text-align: center;'> not posts by you yet </h3>
		</div>
		<?php foreach($posts as $post){?>
			<a href="<?php echo "viewpost.php?postId={$post['id']} " ?>">
				<div style="padding: 7.5px; margin: 5px;border:black solid 1px;">				
					<span> <?php echo "<span style='text-transform: uppercase;'> {$post['userName']} </span>" . "       " . "<span style='opacity:40%'> {$post['time']} </span>" ?>  </span><br/>
					<p style="margin:5px 0px"> <?php echo $post['content'] ?></p>
					<div>
						<span>likes: <?php echo $post['likes'] ?></span>
						<span>comments: <?php echo $post['comments'] ?></span>
					</div>				
				</div>
			</a>
		<?php }?>
		<div><a>VIEW ALL POSTS</a></div>
	</div>
</body>
</html>
