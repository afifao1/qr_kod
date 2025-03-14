<?php
declare(strict_types=1);

namespace Controllers;

require 'vendor/autoload.php';

use chillerlan\QRCode\QRCode;
class Web implements QRCodeInterface{
    function handleGenerateCommand($text){
        return (new QRCode)->render($text,'file.svg');
    }
    
    function handleReadCommand($content){
        $tmp_name=$_FILES['read']['tmp_name'];     
        return move_uploaded_file($tmp_name,'qr.jpg');
    }
}