<?php
session_start();
include_once 'config.php'; // loads config variables

if (!isset($GET_img))
	exit(0);

$session = $_SESSION[$CONFIG_name.'sessioncode'];
$code = $session[$GET_img];
$code=substr(strtoupper(md5("Mytext".$code)), 0,6);
captcha(135,40,$code);

exit(0);


function captcha($width,$height,$code) {

$font="./font/ChalkboardBold.ttf";

$font_size = 17;
$image = imagecreate($width, $height);
$background_color = imagecolorallocate($image, 50, 50, 50);
$text_color = imagecolorallocate($image, 251, 78, 0);
$noise_color = imagecolorallocate($image, 254, 254, 254);

for( $i=0; $i<($width*$height)/3; $i++ ) imagefilledellipse($image, mt_rand(0,$width), mt_rand(0,$height), 1, 1, $noise_color);
for( $i=0; $i<($width*$height)/150; $i++ ) imageline($image, mt_rand(0,$width), mt_rand(0,$height), mt_rand(0,$width), mt_rand(0,$height), $noise_color);
$x=3;$y=20;

imagettftext($image, $font_size, rand(-25,25), $x, $y+(rand()%10), $text_color, $font , $code[0]);
imagettftext($image, $font_size, rand(-25,25), $x+23, $y+(rand()%10), $text_color, $font , $code[1]);
imagettftext($image, $font_size, rand(-25,25), $x+46, $y+(rand()%10), $text_color, $font , $code[2]);
imagettftext($image, $font_size, rand(-25,25), $x+69, $y+(rand()%10), $text_color, $font , $code[3]);
imagettftext($image, $font_size, rand(-25,25), $x+92, $y+(rand()%10), $text_color, $font , $code[4]);
imagettftext($image, $font_size, rand(-25,25), $x+115, $y+(rand()%10), $text_color, $font , $code[5]);

header('Content-Type: image/jpeg');
imagejpeg($image);
imagedestroy($image);
}

?>
