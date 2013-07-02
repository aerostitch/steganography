<?php
/*
 * Script from PHP Solution magazine of 2007-03
 * Only for PNG images
 */
class Steganography{
  function encode($text, $key, $image){
	  # Use the 1st pixel to put the message length
	  if(empty($text) || empty($key)) return false;
	  $text_len = strlen($text);
	  $pixel = 1;
	  $r = $text_len >> 2;
	  $g = ($text_len - ($r << 2)) >> 1;
	  $b = $text_len - ($r << 2) - ($g << 1);
	  $color = $image->pixel_color($r, $g, $b);
	  $image->set_pixel($pixel, $color);

	  # Use the given key to encode the message
	  $key_len = strlen($key);
	  $key_index = $color_index = $i = 0;
	  while($i < $text_len){
		  # Find next pixel using the key as distribution key
		  $pixel += ord($key[$key_index]);
		  $rgb = $image->get_pixel($pixel);
		  # Encode data using the private key
		  $crypted_value = ord($text[$i] ^$key[$key_index]);

		  if($image->greyscale){
			  $color = $image->pixel_color($crypted_value,
				  	$crypted_value, $crypted_value);
		  }else{
			  $color = $image->pixel_color($rgb,
				  $color_index, $crypted_value);
		  }
		  $image->set_pixel($pixel, $color);
		  $i += 1;
		  $key_index = ($i % $key_len);
		  $color_index = ($i % 3);
	  }
	  return true;
  }

  function decode($key, $image){
	  # Message length lies in the 1st pixel
	  $pixel = 1;
	  $rgb = $image->get_pixel($pixel);
	  $text = "";
	  $text_len = ($rgb[0] << 2) + ($rgb[1] << 1) + $rgb[2];
	  $key_len = strlen($key);
	  $key_index = $color_index = $i = 0;
	  while ($i < $text_len){
		  # Find next pixel to decode
		  $pixel += ord($key[$key_index]);
		  $rgb = $image->get_pixel($pixel);
		  # Decode data using private key
		  $byte = chr($rgb[$color_index]) ^ $key[$key_index];
		  $text .= $byte;
		  $i += 1;
		  $key_index = ($i % $key_len);
		  $color_index = ($i % 3);
	  }
	  return $text;
  }
}

?>
