<?php
	require('./classes/messageClass.php');
	require('navBar.php');
	$rows;
	
	if(isset($_GET['chatId'])){
		$chatId = $_GET['chatId'];
	}
	if(isset($_GET['from'])){
		$from = $_GET['from'];
	}
	if(isset($_GET['to'])){
		$to = $_GET['to'];
	}
	if(isset($chatId)){	
		$conn = mysqli_connect($servername, $username, $password, $database);
		$messageObj = new Message($conn);
		$rows = $messageObj->getAllMessages($chatId);
		$chatMessage = $messageObj->getChatById($chatId)[0];
		$from = $chatMessage['fromId'];
		$to = $chatMessage['toId'];
	}else{		
		$conn = mysqli_connect($servername, $username, $password, $database);
		$messageObj = new Message($conn);
		
		$from = $_GET['from'];
		$to = $_GET['to'];
		
		$rows = $messageObj->getAllChatsBetweenTwo($from,$to);
	}
	
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$messageObj->sendNewMessage($from,$to,$_POST['message']);
	}
?>
<html>
<body>
	<div style='display: <?php echo !isset($rows) || $rows == [] ? 'block' : 'none'?>;'>
		<h3  style='opacity:45%;text-align: center;'> not messages yet </h3>
	</div>
	
	<?php foreach($rows as $row){?>
		<div style='display:grid;grid-template-columns:5fr 1fr;border:1px solid black;margin: 10px 5px;padding: 10px;'>
			<div>
				<p><?php echo $row['content']?></p>
			</div>
			<div>
				<span style='display: <?php echo $row['sender'] == $userId ? 'block' : 'none' ?>;'> YOU</span>
				<span style='display: <?php echo $row['sender'] != $userId ? 'block' : 'none' ?>;'> OTHER</span>
				<p style='margin:0;'> <?php echo $row['date'] ?></p>
			</div>
		</div>
	<?php } ?>
	
	<form action='' method='POST' style='justify-content: space-between;position: absolute;bottom: 0;border: 2px solid black;display: flex;width: 90vw;padding: 10px;'>
		<input style='border:0; width:100%;' type='text' name='message' placeholder='send a message'/>
		<input type='submit' value='send'/>
	</form>
</body>
</html>