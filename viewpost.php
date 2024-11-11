<html>
<head>
	<title>Login Page</title>
</head>
<style>
</style>
<body style="margin: 0;">
	<?php
		require('navBar.php');
		$conn = mysqli_connect($servername, $username, $password, $database);
		
		$postId = $_GET['postId'];
		$quantity = 10; 
		
		//get all the comments related to that post
		$postsQuery = "SELECT * FROM `post_comments` WHERE `post_Id` = '$postId' ORDER BY `date` ASC LIMIT $quantity;";
		$result = mysqli_query($conn,$postsQuery);
		$comments = mysqli_fetch_all($result, MYSQLI_ASSOC);
		
		$postContent = "SELECT * FROM `posts` WHERE `id` = '$postId'";
		$result = mysqli_query($conn,$postContent);
		$post = mysqli_fetch_all($result, MYSQLI_ASSOC)[0];
	?>
	
	<div style="margin:10px;border:black 2px solid; padding:10px 5px">
		<span> <?php echo "<span style='text-transform: uppercase;'> {$post['userName']} </span>" . "       " . "<span style='opacity:40%'> {$post['time']} </span>" ?>  </span><br/>
		<p style="margin:5px 0px"> <?php echo $post['content'] ?></p>
		<div>
			<span>likes: <?php echo $post['likes'] ?></span>
			<span>comments: <?php echo $post['comments'] ?></span>
		</div>
	</div>
	<h3>Comments</h3>
	<form action='' method='POST' style="display: <?php echo ($userId != $post['userId']) ? 'block' : 'none'; ?>;">
		<input type="text" name='comment' placeholder='Post a comment about this post....'/>
		<input type="submit" value="Post">
	</form>
	<?php foreach($comments as $comment){?>
		<p style="margin:10px 5px;border:black 2px solid; padding:10px 5px"> <?php echo $comment['content'] ?></p>
	<?php }?>
	
	<?php
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$comment = $_POST['comment'];
			$postComment = "INSERT INTO `post_comments`(`id`, `post_Id`, `user_Id`, `content`, `date`) VALUES (uuid(),'$postId','$userId','$comment',CURRENT_TIME)";
			$result = mysqli_query($conn,$postComment);
			if ($result){
				echo('your comment was successful posted');
				$numberOfComments = $post['comments']+1;
				$updateComments = "UPDATE `posts` SET `comments`= '$numberOfComments' WHERE `id` = '$postId'";
				$result = mysqli_query($conn,$updateComments);
			}else{
				echo('error: your comment was not posted');				
			}
			mysqli_close($conn);	
		}
	?>
</body>

</html>