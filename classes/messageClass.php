<?php
	class Message {
		private $conn;
		
		public function __construct($conn){
			$this->conn = $conn;
		}
		
		public function getSummaryOfMessages($userId){
			//$query = "SELECT * FROM `messages` WHERE `fromId`='$userId' or `toId` = '$userId' ORDER BY `date` DESC LIMIT 10";
			$query = "SELECT * FROM `messages` LEFT JOIN `messages_logs` ON `messages`.id = `messages_logs`.chatid AND (`messages`.fromId = '$userId' OR `messages`.toId = '$userId') LEFT JOIN `users` on `users`.id = '$userId' limit 1;";
			$result = mysqli_query($this->conn, $query);
            $date = mysqli_fetch_all($result,MYSQLI_ASSOC);
            return $date;
		}
		public function getAllChatsBetweenTwo($userId,$recieverUseId){			
			$checkOne = "SELECT `id`, `fromId`, `toId`, `date` FROM `messages` WHERE (`fromId` = '$userId' or `toId` = '$userId') or (`fromId` = '$recieverUseId' or `toId` = '$recieverUseId')";
			$newMessageResult = mysqli_query($this->conn, $checkOne);
			$messageBetweenTwo = mysqli_fetch_all($newMessageResult);
			$messageBetweenTwo[0][0];
			if ($messageBetweenTwo[0][0] != null){
				return $this->getAllMessages($messageBetweenTwo[0][0]);
			}else{
				return null;
			}
		}
		public function getAllMessages($chatId){			
			$query = "SELECT * FROM `messages_logs` WHERE `chatId` = '$chatId' ORDER BY `date` DESC LIMIT 10";
			$result = mysqli_query($this->conn, $query);
            $data = mysqli_fetch_all($result,MYSQLI_ASSOC);
            return $data;
		}
		public function getChatById($chatId){
			$query = "SELECT * FROM `messages` WHERE `id` = '$chatId'";
			$result = mysqli_query($this->conn, $query);
            $data = mysqli_fetch_all($result,MYSQLI_ASSOC);
            return $data;
		}
		
		public function sendNewMessage($userId,$recieverUseId,$messageContent){
			//check if they've communicated before, if not create a new entry
			$checkOne = "SELECT * FROM `messages` WHERE (`fromId` = '$userId' AND `toId` = '$recieverUseId') or (`fromId` = '$recieverUseId' AND `toId` = '$userId') ";
			$newMessageResult = mysqli_query($this->conn, $checkOne);
			$data = mysqli_fetch_all($newMessageResult)[0];
			
			if ($data != null){
				$chatId = $data[0];
				$newMessageLogQuery = "INSERT INTO `messages_logs`(`id`, `chatId`,`sender`, `content`, `date`) VALUES (uuid(),'$chatId','$userId','$messageContent',CURRENT_TIME)";				
				$newMessageLogResult = mysqli_query($this->conn, $newMessageLogQuery);
			}else{
				$newMessageQuery = "INSERT INTO `messages`(`id`, `fromId`, `toId`, `date`) VALUES (uuid(),'$userId','$recieverUseId',CURRENT_TIME)";
				$newMessageResult = mysqli_query($this->conn, $newMessageQuery);
				
				$checkOne = "SELECT * FROM `messages` WHERE (`fromId` = '$userId' AND `toId` = '$recieverUseId') or (`fromId` = '$recieverUseId' AND `toId` = '$userId') ";
				$newMessageResult = mysqli_query($this->conn, $checkOne);
				$data = mysqli_fetch_all($newMessageResult);
				
				$chatId = $data['id'];
				$newMessageLogQuery= "INSERT INTO `messages_logs`(`id`, `chatId`, `sender`, `content`, `date`) VALUES (uuid(),'$chatId','$userId','$messageContent',CURRENT_TIME)";	
				$newMessageLogResult = mysqli_query($this->conn, $newMessageLogQuery);				
			}
		}
	}
?>