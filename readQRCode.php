<?php
require 'vendor/autoload.php';

use chillerlan\QRCode\QRCode;

// try{
// 	$result = (new QRCode())->readFromFile('image.png'); 
//     echo ($result->data);
// }
// catch(Throwable $e){
//     print_r($e);
// }

$result=$_POST['read'];
var_dump($result);
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
    <form action="" method="POST">
        <input type="file" name="read">
        <button type="submit">Send</button><br>
        <?php $result = (new QRCode())->readFromFile('image.png');
        echo ($result->data);
        ?>
    </form>
</body>
</html>

