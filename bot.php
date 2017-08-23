<?php
$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);


$conn = new mysqli($server, $username, $password, $db);
$sql = "SELECT id, ask, ans FROM detail";
$result = $conn->query($sql);
$text='';
$access_token = 'y3aNFkkeuf8tR8fXhNQU0LvyrfM3Vhw0So3PjsQ1gxNh/5wKOJFABxLtZgezsePRNZEm7QocgsYopcv7vH4Lr+9Lz806DgeCTpeFKas8xayGjMlYqd4lUMCaaDWIOwUiWc2AhEiLnUFHFyp9pYvAFAdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data

if ($result->num_rows > 0) {
	// output data of each row
	while($row = $result->fetch_assoc()) {

		echo "id: " . $row["id"]. " - ask: " . $row["ask"]. " " . $row["ans"]. "<br>";
	}
} 

if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
            // $text = $event['message']['text'];
            //$inputText = $event['message']['type'];
			//$responseMessage = array_search($event['message']['text'], $arr);
			
			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
					if($row["ask"]==$event['message']['text']){
						$text = $row["ans"];
					}
					//echo "id: " . $row["id"]. " - ask: " . $row["ask"]. " " . $row["ans"]. "<br>";
				}
			} 
			if($text==''){
				$text = 'I dont know';
			}

			if(strpos($event['message']['text'],"==")>0){
                $findStr = strpos($event['message']['text'],"==");
                $subStrAns = substr($event['message']['text'],0,$findStr);
				$subStrAsk = substr($event['message']['text'],$findStr+2);
				$text = 'i know';
                // $newArr = array($subStrAns=>$subStrAsk);
				// $arr = array_merge($arr, $newArr);
				// 	foreach($arr as $arrs){
				// 		$text = $text.'+'.$arrs;
				// 	}
                  // $text = "รู้แล้ว".$arr.'จ้า';
            }else{
				$text = 'ไม่รู้จักจ้า++ :'.$event['message']['text'].' :'.$responseMessage;
		  	}
            
            
			// Get replyToken
			$replyToken = $event['replyToken'];

			// Build message to reply back
			$messages = [
				'type' => 'text',
				'text' => $text
			];

			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);

			echo $result . "\r\n";
		}
	}
}
$conn->close();
echo 'addd';
?>

