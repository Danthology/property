<?php
include 'session.php';
include 'configure.php';
session_set_save_handler($handler, true);
session_start();
$image_width = 55;
$image_height = 18;
srand(microtime() * 100000);
for ($c_number = "", $i = 0; $i < 4; $i++) {
    $c_number .= dechex(rand(0, 15));
}

$_SESSION["check"] = $c_number;
$image_b = imagecreate($image_width, $image_height);
imagecolorallocate($image_b, 255, 255, 255);
for ($i = 0; $i < strlen($_SESSION["check"]); $i++) {
    $font = mt_rand(3, 5);
    $x = mt_rand(1, 8) + $image_width * $i / 4;
    $y = mt_rand(1, $image_height / 4);
    $color = imagecolorallocate($image_b, mt_rand(0, 100), mt_rand(0, 150), mt_rand(0, 200));
    imagestring($image_b, $font, $x, $y, $_SESSION["check"][$i], $color);
}
header("content-type:image/png");
ob_start ();
imagepng($image_b);
$image_data = ob_get_contents ();
ob_end_clean ();
imagedestroy($image_b);
$image_data_base64 =base64_encode ($image_data);
echo json_encode($image_data_base64);
