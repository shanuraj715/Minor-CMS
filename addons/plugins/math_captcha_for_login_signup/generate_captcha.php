<?php
session_start();
// header('Content-Type: image/png');
$text1 = $_GET['val1'];

settype($text1, 'integer');

$text2 = $_GET['val2'];

settype($text2, 'integer');

$text1 = (($text1 * 3) / 6) - 5;

$text2 = (($text2 * 3) / 6) - 5;

$operator = urlencode($_GET['op']);

$text = $text1 . ' ' . $operator . ' ' . $text2 . ' = ';

$height = 25; //CAPTCHA image height
$width = 100; //CAPTCHA image width

// $_SESSION["captcha_answer"] = $ans;

$image_p = imagecreate($width, $height);
$black = imagecolorallocate($image_p, 41, 128, 185);
$white = imagecolorallocate($image_p, 255, 255, 255);
$font_size = 5; 
imagestring($image_p, $font_size, 5, 3, $text, $white);
imagejpeg($image_p, null, 160);
?>