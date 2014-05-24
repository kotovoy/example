<?php
	session_start();
	$rand = mt_rand(1000, 9999);
	$_SESSION["rand"] = $rand;
	$im = imageCreateTrueColor(90, 50); 
	$green = imageColorAllocate($im, 225, 220, 94);
	imagefilledrectangle($im, 0, 0, imageSX($im), imageSY($im), $green); 
	$c = imageColorAllocate($im, 0, 0, 0); 
	$angle = mt_rand(0, 20) - 10;
	imageTtfText($im, 20, $angle, 10, 35, $c, "fonts/verdana.ttf", $rand); 
	header("Content-type: image/png");
	imagePng($im);
	imageDestroy($im);
?>