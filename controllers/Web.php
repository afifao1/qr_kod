<?php
namespace Controllers\Web;

require 'vendor/autoload.php';

use chillerlan\QRCode\QRCode;
class Web{

function createQRCode($text){
    return (new QRCode)->render($text,'file.svg');
}

function readQRCode($content){
        $tmp_name=$_FILES['read']['tmp_name'];     
       return move_uploaded_file($tmp_name,'qr.jpg');
}
}