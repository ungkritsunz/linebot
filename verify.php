<?php
$access_token = 'y3aNFkkeuf8tR8fXhNQU0LvyrfM3Vhw0So3PjsQ1gxNh/5wKOJFABxLtZgezsePRNZEm7QocgsYopcv7vH4Lr+9Lz806DgeCTpeFKas8xayGjMlYqd4lUMCaaDWIOwUiWc2AhEiLnUFHFyp9pYvAFAdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;