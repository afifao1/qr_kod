<?php
declare(strict_types=1);

namespace Controllers;

interface QRCodeInterface{
    public function createQRCode($text);
    public function readQRCode($content);
}