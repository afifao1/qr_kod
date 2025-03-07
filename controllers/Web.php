<?php
require 'vendor/autoload.php';

use chillerlan\QRCode\QRCode;

class Web{

function createQRCode($data){
    return (new QRCode)->render($data,'file.svg');
}

function readQRCode($content){
        $tmp_name=$_FILES['read']['tmp_name'];     
       return move_uploaded_file($tmp_name,'qr.jpg');
}
}