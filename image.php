<?php
error_reporting(E_ALL);

header("Content-Type: image/png");
$im = @imagecreatefromjpeg("imgs/profilepicture.jpg")
    or die("Cannot Initialize new GD image stream");

$color_fondo = imagecolorallocate($im, 0, 0, 0);
$color_texto = imagecolorallocate($im, 15, 14, 15);

if(!true){
	imagestringup($im, 5, 5, 500,  "Christian", $color_texto);
	imagestringup($im, 5, 5, 500,  "Maidana", $color_texto);
}else{
	imagestring($im, 5, 5, 5,  "Christian", $color_texto);
	imagestring($im, 5, 5, 20,  "Maidana", $color_texto);
}


imagepng($im);
imagedestroy($im);
?>