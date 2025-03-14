<?php
declare(strict_types=1);

namespace Controllers;

interface QRCodeInterface{
    public function handleGenerateCommand($text);
    public function handleReadCommand($content);
}