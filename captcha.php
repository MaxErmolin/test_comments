<?php
    session_start();
    $image = imagecreate(45, 25);
    $fon = imagecolorallocate($image, 245, 235, 255);
    $text_color = imagecolorallocate($image, 0, 0, 0);
    imagettftext($image, 14, 10, 5, 20, $text_color, 'type.ttf', $_SESSION["captcha"]);
    header('Content-type: image/png');
    imagepng($image);
    imagedestroy($image);
?>