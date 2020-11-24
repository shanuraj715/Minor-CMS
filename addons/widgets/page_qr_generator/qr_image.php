<?php 

header("Content-Type: image/png");

require_once('libs/vendor/autoload.php');

use Endroid\QrCode\QrCode;

$text = $_GET['page'];

$qrcode = new QrCode($text);

echo $qrcode->writeString();



?>