<?php
/*
 * Script from PHP Solution magazine of 2007-03
 */

include "image.inc.php";
include "steganography.inc.php";

$message = "message to encode";
$key = "secret key";
$image = new Image;
$cipher = new Steganography;

$image->greyscale = false;
$image->load_or_create_png('oryginalny.png');
$cipher->encode($message, $key, $image);
$image->save_png('encoded_image.png');
$image->unload();
?>
