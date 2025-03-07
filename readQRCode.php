<?php
require 'vendor/autoload.php';

use chillerlan\QRCode\QRCode;

$tmp_name=$_FILES['read']['tmp_name'];

move_uploaded_file($tmp_name,'qr.jpg');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Read QRCode</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="file" name="read">
        <button type="submit">Send</button><br>
        <?php
        $result=(new QRCode())->readFromFile('qr.jpg');
        $content = $result->data;
        echo ($content);
        ?>
    </form>
</body>
</html>

