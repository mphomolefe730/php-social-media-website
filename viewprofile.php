<?php
	require('navBar.php');
	$profileUserId = $_GET['profile'];
	$quantity = 10;
	$conn = mysqli_connect($servername, $username, $password, $database);
	
	$postsQuery = "SELECT * FROM `posts` WHERE `userId` = '$profileUserId' ORDER BY `time` ASC LIMIT $quantity;";
	$result = mysqli_query($conn,$postsQuery);
	$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
	
	$query = "SELECT * FROM `profiles` WHERE `userId` = '$profileUserId'";
	$result = mysqli_query($conn,$query);
	
	if(mysqli_fetch_all($result, MYSQLI_ASSOC) == null){
		$profile['path'] = "images\profile-picture.webp";
	}else{
		$profile = mysqli_fetch_all($result, MYSQLI_ASSOC);	
	}
	mysqli_close($conn);
?>
<html>
<style>
	img{
		width:100px;
		height:100px;
		border-radius: 50px;
		object-fit:cover;
		margin:10px;
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
	<h1 style='margin:5px'>Profile</h1>
	<div>
		<img style src='<?php echo $profile['path']?>'/> 
		<button id='submitButton'><a href="messageuser.php?from=<?php echo $userId?>&to=<?php echo $profileUserId?>"> MESSAGE </button>
	</div> 	
	<div style='display: <?php echo !isset($posts) ? 'block' : 'none'?>;'>
		<h3  style='opacity:45%;text-align: center;'> not posts yet </h3>
	</div>
	<?php foreach($posts as $post){?>
		<div style="padding: 7.5px; border-radius: 12px; margin: 5px;min-width:150px;max-width:350px;width:100%;border:black solid 2px;">
			<a href="<?php echo "viewpost.php?postId={$post['id']} " ?>">
				<span> <?php echo "<span style='text-transform: uppercase;'> {$post['userName']} </span>" . "       " . "<span style='opacity:40%'> {$post['time']} </span>" ?>  </span><br/>
				<p style="margin:5px 0px"> <?php echo $post['content'] ?></p>
				<div>
					<span>likes: <?php echo $post['likes'] ?></span>
					<span>comments: <?php echo $post['comments'] ?></span>
				</div>
			</a>
		</div>
	<?php }?>
</body>
</html>