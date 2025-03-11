<?php
declare(strict_types=1);

namespace Controllers;

use chillerlan\QRCode\QRCode;

class Web implements QRCodeInterface{
    public function createQRCode($text){
        return (new QRCode)->render($text,'file.svg');
    }
    
    public function readQRCode($content){
        $tmp_name=$_FILES['read']['tmp_name'];     
        return move_uploaded_file($tmp_name,'qr.jpg');
    }

    public function index(){
      echo 'Index page';
    }
}
