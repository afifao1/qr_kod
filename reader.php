<?php
ini_set('display_errors',1);
require 'vendor/autoload.php';

use chillerlan\QRCode\QRCode;


$tmp_name=$_FILES['read']['tmp_name'];

move_uploaded_file($tmp_name,'qr.jpg');

$result=(new QRCode())->readFromFile('qr.jpg');
$content = $result->data;
echo ($content);
