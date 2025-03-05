<?php
require 'vendor/autoload.php';

use chillerlan\QRCode\QRCode;

$data = $_POST['data'];
(new QRCode)->render($data,'file.svg');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>QR skaner</h1>
    <form action="" method="POST">
    <input type="text" placeholder ="Enter link or text" name="data">
    <button type="submit">Send</button><br>
    <?php
        echo '<img src="'.(new QRCode)->render($data).'" alt="QR Code" width ="200" height=200"/>';
    ?>
    </form>
</body>
</html>
