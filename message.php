<html>
<head>
	<title>messages</title>
</head>
	<style>

	</style>
<body>
	<?php
		require('./classes/messageClass.php');
		require('navBar.php');
		
		$conn = mysqli_connect($servername, $username, $password, $database);
		$messageObj = new Message($conn);
		$rows = $messageObj->getSummaryOfMessages($userId);
	?>
	<h1>MESSAGES</h1>
	<div>
		<?php foreach($rows as $key=>$message){?>
			<a href="<?php echo "messageuser.php?chatId={$message['chatId']}" ?>">
				<div style="padding: 7.5px; margin: 5px;border:black solid 1px;">	
					<h3 style='margin: 5px 0'> from: <?php echo $message['name'] ?> </h3>
					<p style="margin:5px 0px"> <?php echo $message['content'] ?></p>
				</div>
			</a>
		<?php }?>
	</div>
</body>
</html>