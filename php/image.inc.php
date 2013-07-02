<?php
/*
 * Script from PHP Solution magazine of 2007-03
 * Only for PNG images
 */
class Image{
  var $im;
  var $im_width;
  var $im_height;
  var $greyscale = false;
  function load_or_create_png($imgname){
	$im = @imagecreatefrompng($imgname);
	if(!$im) {
		$im = imagecreatetruecolor(300,300);
		$bgc = imagecolorallocate($im, 255, 255, 255);
		imagefilledrectangle($im, 0, 0, 300, 300, $bgc);
	}
	$this->im_width = imagesx($im);
	$this->im_height = imagesy($im);
	$this->im = $im;
	return $im;
  }

  function unload() {
	if($this->im){
		@imagedestroy($this->im);
	}
  }

  function save_png($imgname){
	  if($this->im){
		  @imagepng($this->im, $imgname);
	  }
  }

  /*
   * Returns an array of the R, G and B values of a given pixel
   */
  function get_pixel($index){
	  $x = $this->pixel_x($index);
	  $y = $this->pixel_y($index);
	  $color = imagecolorat($this->im, $x, $y);
	  return array( ($color >> 16) & 0xFF, # R
		  ($color >> 8) & 0xFF,        # G
		  $color & 0xFF                # B
	  );
  }

  function set_pixel($index, $color){
	  $x = $this->pixel_x($index);
	  $y = $this->pixel_y($index);
	  imagesetpixel($this->im, $x, $y, $color);
  }

  function pixel_color($r, $g, $b){
	  return ($r << 16) | ($g << 8) | $b;
  }

  function change_color_component($rgb, $component, $value){
	  $rgb[$component] = $value;
	  return $this->pixel_color($rgb[0], $rgb[1], $rgb[2]);
  }

  function pixel_index($x, $y){
	  return $y * $this->im_width + $x +1;
  }

  function pixel_x($index){
	  return ($index-1) % $this->im_width;
  }
  function pixel_y($index){
	  return intval(($index - 1) / $this->im_width);
  }
}

?>
