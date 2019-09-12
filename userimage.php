<?php
require_once("config.php");
require_once("log.php");
require_once("controller/ApiController.php");
require_once("controller/UserController.php");

header("Content-Type: image/png");
$im = @imagecreatefromjpeg("imgs/profilepicture.jpg")
    or die("Cannot Initialize new GD image stream");

$ctrl =  new UserController();

$imageWidth 	= 175;
$imageHeight 	= 175; 

if(Auth::isLoggedIn()){
	$user = $ctrl->getUser();
	$options 	= $user->getImageOptions();

	$firstname 	= $user->getFirstname();
	$lastname 	= $user->getLastname();
	$color  	= $options->color;
	$size 		= $options->size;
	$vpos 		= $options->vposition;
	$hpos 		= $options->hposition;


	$fontHeight 	= imagefontheight( $size );
	$fontWidth 		= imagefontwidth( $size );

	if( eregi( "[#]?([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})", $color, $regex )){
		$color = imagecolorallocate($im, hexdec( $regex[1]), hexdec( $regex[2]),hexdec( $regex[3]) );
	}else{
		$color = imagecolorallocate($im, 255, 255,255);
	}
	$x1 = 0;
	$y1 = 0;
	$x2 = 0;
	$y2 = 0;

	if($vpos == "top"){
		$y1 = 5;
	}elseif($vpos == "middle"){
		$y1 = ($imageHeight / 2) - $fontHeight;
	}else{
		$y1 = $imageHeight - 10 - ($fontHeight*2);
	}
	$y2 = $y1 + $fontHeight + 5;

	if($hpos == "left"){
		$x1 = $x2 = 0;		
	}elseif($hpos == "center"){
		$x1 = $x2 = $imageWidth * 0.5;
		$x1 -= 0.5 * $fontWidth * strlen($firstname);
		$x2 -= 0.5 * $fontWidth * strlen($lastname);
	}else{
		$x1 = $x2 = $imageWidth;
		$x1 -= ($fontWidth * strlen($firstname) + 5);
		$x2 -= ($fontWidth * strlen($lastname) + 5);
	}

	imagestring($im, $size, $x1, $y1,  $firstname, $color);
	imagestring($im, $size, $x2, $y2,  $lastname, $color);

}else{

}

imagepng($im);
imagedestroy($im);
?>