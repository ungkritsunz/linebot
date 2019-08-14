<?php
 require_once "GoogleTranslate.php";
$url = parse_url(getenv("CLEARDB_DATABASE_URL"));
$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);			
$conn = new mysqli($server, $username, $password, $db);
$text='';
$textEat=array();
$access_token = 'y3aNFkkeuf8tR8fXhNQU0LvyrfM3Vhw0So3PjsQ1gxNh/5wKOJFABxLtZgezsePRNZEm7QocgsYopcv7vH4Lr+9Lz806DgeCTpeFKas8xayGjMlYqd4lUMCaaDWIOwUiWc2AhEiLnUFHFyp9pYvAFAdB04t89/1O/w1cDnyilFU=';
$checkWord = "";
// Fix Ip Here
$publicIp001 = "1.20.90.190";
// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
function getIP(){
    // ตรวจสอบ IP กรณีการใช้งาน share internet
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }else{
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			$sql = "SELECT id, ask, ans FROM detail";
			$result = $conn->query($sql);
			if($event['message']['text']=="ip"){
				$text = getIP();
			}
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					if($row["ask"]==$event['message']['text']){
						
						switch ($row["ask"]) {
							case "OPEN TOSF":
								$url = 'http://'.$publicIp001.':9999/LED=ON'; 
								
								$data = "fn=login&test=1";
								
								try{
								$ch = curl_init();
								curl_setopt( $ch, CURLOPT_URL, $url );
								curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
								curl_setopt( $ch, CURLOPT_POST, true );
								curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
								curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
								$content = curl_exec( $ch );
								curl_close($ch);
								}catch(Exception $ex){
								
								echo $ex;
								}
							$text = "เปิดแล้วค่า";
								break;

							case "CLOSE TOSF":
								$url = 'http://'.$publicIp001.':9999/LED=OFF'; 
								
								$data = "fn=login&test=1";
								
								try{
								$ch = curl_init();
								curl_setopt( $ch, CURLOPT_URL, $url );
								curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
								curl_setopt( $ch, CURLOPT_POST, true );
								curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
								curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
								$content = curl_exec( $ch );
								curl_close($ch);
								
								}catch(Exception $ex){
								
								echo $ex;
								}
							$text = "ปิดแล้วค่ะ";
								break;
								case "เปิดสวิตซ์":
								$url = 'http://'.$publicIp001.':9999/LED=ON'; 
								
								$data = "fn=login&test=1";
								
								try{
								$ch = curl_init();
								curl_setopt( $ch, CURLOPT_URL, $url );
								curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
								curl_setopt( $ch, CURLOPT_POST, true );
								curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
								curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
								$content = curl_exec( $ch );
								curl_close($ch);
								
								}catch(Exception $ex){
								
								echo $ex;
								}
							$text = 'http://'.$publicIp001.':9999/LED=ON';
								break;

							case "ปิดสวิตซ์":
								$url = 'http://'.$publicIp001.':9999/LED=OFF'; 
								
								$data = "fn=login&test=1";
								
								try{
								$ch = curl_init();
								curl_setopt( $ch, CURLOPT_URL, $url );
								curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
								curl_setopt( $ch, CURLOPT_POST, true );
								curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
								curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
								$content = curl_exec( $ch );
								curl_close($ch);
								
								}catch(Exception $ex){
								
								echo $ex;
								}
							$text = "ปิดแล้วค่า";
								break;

							case "งาน":
								$text .= $row["ans"]."\n";
								break;
							case "หนี้":
								$text .= $row["ans"]."\n";
								break;
							case "เตือน":
								$text .= $row["ans"]."\n";
								break;
							case "กินไรดี":
								array_push($textEat,$row["ans"]);
								break;
							case "ซันจู":
								$text .= $row["ans"]."\n";
								break;
							default:
								$text = $row["ans"];
						}

					}
				}
			}
			if(count($textEat)>0){
				$k = array_rand($textEat);
				$v = $textEat[$k];
				$text = $v;
			}
			if($event['message']['text']=="keyword"){
				$text = " แปล = ไทย -> อังกฤษ \n en = อังกฤษ -> ไทย \n ja = ไทย -> ญี่ปุ่น \n sp = ไทย -> สเปน \nko = ไทย -> เกาหลี \n ch = ไทย -> จีน \n de = ไทย -> เยอรมัน";
			}
			if($text==''){
				if(strpos($event['message']['text']," ")>0){
					$findStr = strpos($event['message']['text']," ");
					$subStrAsk = substr($event['message']['text'],0,$findStr);
					$subStrAns = substr($event['message']['text'],$findStr+1);
					switch ($subStrAsk) {
						case "แปล":
							$word = $subStrAns;
							$GT = NEW GoogleTranslate();
							$response = $GT->translate('th','en',$word);  
							$text = $word."   =   ".$response." จ้า";
							break;
						case "en":
							$word = $subStrAns;
							$GT = NEW GoogleTranslate();
							$response = $GT->translate('en','th',$word);  
							$text = $word."   =   ".$response." จ้า";
							break;
						case "ja":
							$word = $subStrAns;
							$GT = NEW GoogleTranslate();
						 	$response = $GT->translate('th','ja',$word);  
							$text = $word."   =   ".$response." จ้า";
							break;
						case "sp":
							$word = $subStrAns;
							$GT = NEW GoogleTranslate();
							$response = $GT->translate('th','sp',$word);  
							$text = $word."   =   ".$response." จ้า";
							break;
						case "ko":
							$word = $subStrAns;
							$GT = NEW GoogleTranslate();
							$response = $GT->translate('th','ko',$word); 
							$text = $word."   =   ".$response." จ้า";
							break;
						case "ch":
							$word = $subStrAns;
							$GT = NEW GoogleTranslate();
							$response = $GT->translate('th','zh-CN',$word); 
							$text = $word."   =   ".$response." จ้า";
							break;
						case "de":
							$word = $subStrAns;
							$GT = NEW GoogleTranslate();
							$response = $GT->translate('th','de',$word); 
							$text = $word."   =   ".$response." จ้า";
							break;
					}
					
				}			
			} 			

			if($text==''){
				if(strpos($event['message']['text'],"--")>0){
					$findStr = strpos($event['message']['text'],"--");
					$subStrAsk = substr($event['message']['text'],0,$findStr);
					$subStrAns = substr($event['message']['text'],$findStr+2);
					if($subStrAsk=='ลบ'){
						$sql = "DELETE FROM heroku_359cfa1beb94615.detail WHERE ans = '$subStrAns' ";
					}
					
					if ($conn->query($sql) === TRUE) {
						$text =  "ลบแล้วจ้าา";
					} else {
						$text =  "ลบไม่ออกก  เขียน ลบ-- ตามด้วยคำที่จะลบน้าา";
					}

				}else{
					//$text = 'อันนี้ไม่รู้จักก';
				  }				
			}  
			if($text=='' && strpos($event['message']['text'],"ลบ--")==null){
				if(strpos($event['message']['text'],"==")>0){
					$findStr = strpos($event['message']['text'],"==");
					$subStrAsk = substr($event['message']['text'],0,$findStr);
					$subStrAns = substr($event['message']['text'],$findStr+2);

					$sql = "INSERT INTO heroku_359cfa1beb94615.detail (id, ask, ans)
					VALUES (NULL, '$subStrAsk', '$subStrAns')";
					
					if ($conn->query($sql) === TRUE) {
						$text =  "โอเคค จำได้แล้วว";
					} else {
						$text =  "จำไม่ได้บอกเลย";
					}

				}else{
					//$text = 'อันนี้ไม่รู้จักก';
				  }				
			}   
			//ลบบ			    
            
			// Get replyToken
			$replyToken = $event['replyToken'];

			// Build message to reply back
			$messages = [
				'type' => 'text',
				'text' => $text
			];

			// Make a POST Request to Messaging API to reply to sender
			// $url = 'https://api.line.me/v2/bot/message/reply';
			// $data = [
			// 	'replyToken' => $replyToken,
			// 	'messages' => [$messages],
			// ];
			$url = 'https://api.line.me/v2/bot/message/push';
			$data = array (
				'to' => 'Ud5aa526b2ce8b0bb3be2f3d019c673e7',
				'messages' => 
				array (
				  0 => 
				  array (
					'type' => 'flex',
					'altText' => 'this is flex messages sunsosay',
					'contents' => 
					array (
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
$conn->close();
?>

