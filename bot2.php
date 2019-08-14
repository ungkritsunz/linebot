<?php
$access_token = 'y3aNFkkeuf8tR8fXhNQU0LvyrfM3Vhw0So3PjsQ1gxNh/5wKOJFABxLtZgezsePRNZEm7QocgsYopcv7vH4Lr+9Lz806DgeCTpeFKas8xayGjMlYqd4lUMCaaDWIOwUiWc2AhEiLnUFHFyp9pYvAFAdB04t89/1O/w1cDnyilFU=';
$arr = array('ans' => 'ask');
$inputText='';
$responseMessage=''
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
             $text = $event['message']['text'];
            // $inputText = $event['message']['type'];
            // $responseMessage = array_search($inputText, $arr);

            // if($responseMessage!=null){
            //     $text = $responseMessage.'not null';

            //     if(strpos($inputText,"==")!=null){
            //         $findStr = strpos($str,"==");
            //         $subStrAns = substr($inputText,0,$findStr);
            //         $subStrAsk = substr($str,$findStr+2);
            //         $newArr = array($subStrAns=>$subStrAsk);
            //         $arr = array_merge($arr, $newArr);
            //         $text = "รู้แล้ว";
            //       }

            // }else{  
            //     $text = 'ไม่รู้จักจ้า';
            // }
            
			// Get replyToken
			$replyToken = $event['replyToken'];

			// Build message to reply back
			$messages = [
				'type' => 'text',
				'text' => "test push naja"
			];

			// Make a POST Request to Messaging API to reply to sender
			// $url = 'https://api.line.me/v2/bot/message/reply';
			$url = 'https://api.line.me/v2/bot/message/push';
			$data = array (
				'type' => 'bubble',
				'styles' => 
				array (
				  'footer' => 
				  array (
					'separator' => true,
				  ),
				),
				'body' => 
				array (
				  'type' => 'box',
				  'layout' => 'vertical',
				  'spacing' => 'md',
				  'contents' => 
				  array (
					0 => 
					array (
					  'type' => 'text',
					  'text' => 'RECEIPT',
					  'weight' => 'bold',
					  'color' => '#1DB446',
					  'size' => 'sm',
					),
					1 => 
					array (
					  'type' => 'text',
					  'text' => 'Brown Store',
					  'weight' => 'bold',
					  'size' => 'xxl',
					  'margin' => 'md',
					),
					2 => 
					array (
					  'type' => 'text',
					  'text' => 'Miraina Tower, 4-1-6 Shinjuku, Tokyo',
					  'size' => 'xs',
					  'color' => '#aaaaaa',
					  'wrap' => true,
					),
					3 => 
					array (
					  'type' => 'separator',
					  'margin' => 'xxl',
					),
					4 => 
					array (
					  'type' => 'box',
					  'layout' => 'vertical',
					  'margin' => 'xxl',
					  'spacing' => 'sm',
					  'contents' => 
					  array (
						0 => 
						array (
						  'type' => 'box',
						  'layout' => 'horizontal',
						  'contents' => 
						  array (
							0 => 
							array (
							  'type' => 'text',
							  'text' => 'Energy Drink',
							  'size' => 'sm',
							  'color' => '#555555',
							  'flex' => 0,
							),
							1 => 
							array (
							  'type' => 'text',
							  'text' => '$2.99',
							  'size' => 'sm',
							  'color' => '#111111',
							  'align' => 'end',
							),
						  ),
						),
						1 => 
						array (
						  'type' => 'box',
						  'layout' => 'horizontal',
						  'contents' => 
						  array (
							0 => 
							array (
							  'type' => 'text',
							  'text' => 'Chewing Gum',
							  'size' => 'sm',
							  'color' => '#555555',
							  'flex' => 0,
							),
							1 => 
							array (
							  'type' => 'text',
							  'text' => '$0.99',
							  'size' => 'sm',
							  'color' => '#111111',
							  'align' => 'end',
							),
						  ),
						),
						2 => 
						array (
						  'type' => 'box',
						  'layout' => 'horizontal',
						  'contents' => 
						  array (
							0 => 
							array (
							  'type' => 'text',
							  'text' => 'Bottled Water',
							  'size' => 'sm',
							  'color' => '#555555',
							  'flex' => 0,
							),
							1 => 
							array (
							  'type' => 'text',
							  'text' => '$3.33',
							  'size' => 'sm',
							  'color' => '#111111',
							  'align' => 'end',
							),
						  ),
						),
						3 => 
						array (
						  'type' => 'separator',
						  'margin' => 'xxl',
						),
						4 => 
						array (
						  'type' => 'box',
						  'layout' => 'horizontal',
						  'margin' => 'xxl',
						  'contents' => 
						  array (
							0 => 
							array (
							  'type' => 'text',
							  'text' => 'ITEMS',
							  'size' => 'sm',
							  'color' => '#555555',
							),
							1 => 
							array (
							  'type' => 'text',
							  'text' => '3',
							  'size' => 'sm',
							  'color' => '#111111',
							  'align' => 'end',
							),
						  ),
						),
						5 => 
						array (
						  'type' => 'box',
						  'layout' => 'horizontal',
						  'contents' => 
						  array (
							0 => 
							array (
							  'type' => 'text',
							  'text' => 'TOTAL',
							  'size' => 'sm',
							  'color' => '#555555',
							),
							1 => 
							array (
							  'type' => 'text',
							  'text' => '$7.31',
							  'size' => 'sm',
							  'color' => '#111111',
							  'align' => 'end',
							),
						  ),
						),
						6 => 
						array (
						  'type' => 'box',
						  'layout' => 'horizontal',
						  'contents' => 
						  array (
							0 => 
							array (
							  'type' => 'text',
							  'text' => 'CASH',
							  'size' => 'sm',
							  'color' => '#555555',
							),
							1 => 
							array (
							  'type' => 'text',
							  'text' => '$8.0',
							  'size' => 'sm',
							  'color' => '#111111',
							  'align' => 'end',
							),
						  ),
						),
						7 => 
						array (
						  'type' => 'box',
						  'layout' => 'horizontal',
						  'contents' => 
						  array (
							0 => 
							array (
							  'type' => 'text',
							  'text' => 'CHANGE',
							  'size' => 'sm',
							  'color' => '#555555',
							),
							1 => 
							array (
							  'type' => 'text',
							  'text' => '$0.69',
							  'size' => 'sm',
							  'color' => '#111111',
							  'align' => 'end',
							),
						  ),
						),
					  ),
					),
					5 => 
					array (
					  'type' => 'separator',
					  'margin' => 'xxl',
					),
					6 => 
					array (
					  'type' => 'button',
					  'style' => 'primary',
					  'action' => 
					  array (
						'type' => 'uri',
						'label' => 'Primary style button',
						'uri' => 'https://developers.line.me',
					  ),
					),
					7 => 
					array (
					  'type' => 'button',
					  'style' => 'primary',
					  'action' => 
					  array (
						'type' => 'uri',
						'label' => 'Primary style button',
						'uri' => 'https://developers.line.me',
					  ),
					),
				  ),
				),
			);
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

