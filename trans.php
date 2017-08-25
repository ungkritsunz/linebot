<?php
 require_once "GoogleTranslate.php";
 $word = $_REQUEST['word'];
$GT = NEW GoogleTranslate();
$response = $GT->translate('th','en',$word);  /// ตรง en เราสามารถเปลี่ยนเป็น ภาษาอื่นได้
//echo "<pre>";
echo $word."   =   ".$response;
?>

<!-- /// ตรง en เราสามารถเปลี่ยนเป็น ภาษาอื่นได้  เช่น เกาหลี = ko ,สเปน = sp -->

<!-- //// แปลไทยเป็น ญี่ปุ่น -->
<?php
//  require_once "GoogleTranslate.php";
//  $word = $_REQUEST['word'];
// $GT = NEW GoogleTranslate();
// $response = $GT->translate('th','ja',$word);
// //echo "<pre>";
// echo $word."   =   ".$response;
?>

<!-- //// แปลเป็นอังกฤษไทย  -->

<?php
//  require_once "GoogleTranslate.php";
//  $word = $_REQUEST['word'];
// $GT = NEW GoogleTranslate();
// $response = $GT->translate('en','th',$word);
// //echo "<pre>";
// echo $word."   =   ".$response;
?>