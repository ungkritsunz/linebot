<?php
$access_token = 'y3aNFkkeuf8tR8fXhNQU0LvyrfM3Vhw0So3PjsQ1gxNh/5wKOJFABxLtZgezsePRNZEm7QocgsYopcv7vH4Lr+9Lz806DgeCTpeFKas8xayGjMlYqd4lUMCaaDWIOwUiWc2AhEiLnUFHFyp9pYvAFAdB04t89/1O/w1cDnyilFU=';
$arr = array('ดีจ้า' => 'ดีคับ');
$ans = 'hello';
$ask = 'bello';
$newArr = array($ans=>$ask);
$resultMerge = array_merge($arr, $newArr);
$responseMessage = array_search('ดีคับ', $resultMerge);
echo $responseMessage;
// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data

if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
            // $text = $event['message']['text'];
            $inputText = $event['message']['type'] == 'text';
            
            $responseMessage = array_search($inputText, $arr);
            if($responseMessage!=null){
                $text = $responseMessage;
                if(strpos($inputText,"==")!=null){
                    $findStr = strpos($str,"==");
                    $subStrAns = substr($inputText,0,$findStr);
                    $subStrAsk = substr($str,$findStr+2);
                    $newArr = array($subStrAns=>$subStrAsk);
                    $arr = array_merge($arr, $newArr);
                    $text = "รู้แล้ว";
                  }
            }else{
                $text = "ไม่รู้จัก";
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

?>

