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
			$sql = "SELECT id, ask, ans FROM detail";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					if($row["ask"]==$event['message']['text']){
						
						switch ($row["ask"]) {
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
							default:
								$text = $row["ans"];
						}

					}
				}
			}
			if(count($textEat)>0){
				$k = array_rand($textEat);
				$v = $array[$k];
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
?>

