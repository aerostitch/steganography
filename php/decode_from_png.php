<?php
/*
 * Script from PHP Solution magazine of 2007-03
 */

include "image.inc.php";
include "steganography.inc.php";

$key = "secret key";
$image = new Image;
$cipher = new Steganography;

$image->greyscale = false;
$image->load_or_create_png('encoded_image.png');
echo $cipher->decode($key, $image)."\n";
$image->unload();
?>
