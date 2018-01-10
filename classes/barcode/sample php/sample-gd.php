<?php
  include('../php-barcode.php');

  // -------------------------------------------------- //
  //                  PROPERTIES
  // -------------------------------------------------- //
  
  // download a ttf font here for example : http://www.dafont.com/fr/nottke.font
  //$font     = './NOTTB___.TTF';
  // - -

  $code = 'geotag_001';

  $length = strlen($code); // barcode, of course ;)

  $image_x = $length * 40;
  $image_y = 150;
  
  $fontSize = 10;   // GD1 in px ; GD2 in point
  $marge    = 10;   // between barcode and hri in pixel
  $x        = $image_x / 2;  // barcode center
  $y        = $image_y / 2;  // barcode center
  $height   = 80;   // barcode height in 1D ; module size in 2D
  $width    = 2;    // barcode height in 1D ; not use in 2D
  $angle    = 0;   // rotation in degrees : nb : non horizontable barcode might not be usable because of pixelisation
  
  
  $type     = 'code128';
  
  // -------------------------------------------------- //
  //                    USEFUL
  // -------------------------------------------------- //
  
  function drawCross($im, $color, $x, $y){
    //imageline($im, $x - 10, $y, $x + 10, $y, $color);
    //imageline($im, $x, $y- 10, $x, $y + 10, $color);
  }
  
  // -------------------------------------------------- //
  //            ALLOCATE GD RESSOURCE
  // -------------------------------------------------- //
  
  $im     = imagecreatetruecolor($image_x, $image_y);
  $black  = ImageColorAllocate($im,0x00,0x00,0x00);
  $white  = ImageColorAllocate($im,0xff,0xff,0xff);
  $red    = ImageColorAllocate($im,0xff,0x00,0x00);
  $blue   = ImageColorAllocate($im,0x00,0x00,0xff);
  imagefilledrectangle($im, 0, 0, $image_x, $image_y, $white);
  
  // -------------------------------------------------- //
  //                      BARCODE
  // -------------------------------------------------- //
  $data = Barcode::gd($im, $black, $x, $y, $angle, $type, array('code'=>$code), $width, $height);
  
  // -------------------------------------------------- //
  //                        HRI
  // -------------------------------------------------- //
  if ( isset($font) ){
    $box = imagettfbbox($fontSize, 0, $font, $data['hri']);
    $len = $box[2] - $box[0];
    Barcode::rotate(-$len / 2, ($data['height'] / 2) + $fontSize + $marge, $angle, $xt, $yt);
    imagettftext($im, $fontSize, $angle, $x + $xt, $y + $yt, $blue, $font, $data['hri']);
  }
  // -------------------------------------------------- //
  //                     ROTATE
  // -------------------------------------------------- //
  // Beware ! the rotate function should be use only with right angle
  // Remove the comment below to see a non right rotation
  /** /
  $rot = imagerotate($im, 45, $white);
  imagedestroy($im);
  $im     = imagecreatetruecolor(900, 300);
  $black  = ImageColorAllocate($im,0x00,0x00,0x00);
  $white  = ImageColorAllocate($im,0xff,0xff,0xff);
  $red    = ImageColorAllocate($im,0xff,0x00,0x00);
  $blue   = ImageColorAllocate($im,0x00,0x00,0xff);
  imagefilledrectangle($im, 0, 0, 900, 300, $white);
  
  // Barcode rotation : 90�
  $angle = 90;
  $data = Barcode::gd($im, $black, $x, $y, $angle, $type, array('code'=>$code), $width, $height);
  Barcode::rotate(-$len / 2, ($data['height'] / 2) + $fontSize + $marge, $angle, $xt, $yt);
  imagettftext($im, $fontSize, $angle, $x + $xt, $y + $yt, $blue, $font, $data['hri']);
  imagettftext($im, 10, 0, 60, 290, $black, $font, 'BARCODE ROTATION : 90�');
  
  // barcode rotation : 135
  $angle = 135;
  Barcode::gd($im, $black, $x+300, $y, $angle, $type, array('code'=>$code), $width, $height);
  Barcode::rotate(-$len / 2, ($data['height'] / 2) + $fontSize + $marge, $angle, $xt, $yt);
  imagettftext($im, $fontSize, $angle, $x + 300 + $xt, $y + $yt, $blue, $font, $data['hri']);
  imagettftext($im, 10, 0, 360, 290, $black, $font, 'BARCODE ROTATION : 135�');
  
  // last one : image rotation
  imagecopy($im, $rot, 580, -50, 0, 0, 300, 300);
  imagerectangle($im, 0, 0, 299, 299, $black);
  imagerectangle($im, 299, 0, 599, 299, $black);
  imagerectangle($im, 599, 0, 899, 299, $black);
  imagettftext($im, 10, 0, 690, 290, $black, $font, 'IMAGE ROTATION');
  /**/

  // -------------------------------------------------- //
  //                    MIDDLE AXE
  // -------------------------------------------------- //
  /*imageline($im, $x, 0, $x, $image_y, $red);
  imageline($im, 0, $y, $image_x, $y, $red);
  */
  // -------------------------------------------------- //
  //                  BARCODE BOUNDARIES
  // -------------------------------------------------- //
  for($i=1; $i<5; $i++){
    drawCross($im, $blue, $data['p'.$i]['x'], $data['p'.$i]['y']);
  }
  
  // -------------------------------------------------- //
  //                    GENERATE
  // -------------------------------------------------- //
  header('Content-type: image/png');
  imagepng($im);

  imagedestroy($im);
?>