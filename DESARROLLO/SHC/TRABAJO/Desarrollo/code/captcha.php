<?php
require_once './core/helper/f.php';
f::import('core/helper/Cifrar.php');
$random1=Cifrar::random(4, 'int');
$random2=Cifrar::random(4, 'int');
$texto=$random1.' '.$random2;

$width=149;
$height=27;

$image=imagecreatetruecolor($width, $height);
$font=f::getPatchApp().'/resource/plugin/reCaptcha/fonts/Courier.ttf';
$black=imagecolorallocate($image, 0, 0, 0); // color negro
$white=imagecolorallocate($image, 255, 255, 255); // background color blanco
//$black=$white;
imagefilledrectangle($image, 0, 0, $width, $height, $white);

$lineas=mt_rand(10, 15);
for($i=0; $i < $lineas; $i++)
{
    $max=mt_rand(80, 100);
    
    $r=mt_rand(100, 200);
    $g=mt_rand(100, 200);
    $b=mt_rand(100, 200);
    
    $linescolor=imagecolorallocatealpha($image, $r, $g, $b, $max);
    
    $x1=mt_rand(0, $width);
    $y1=mt_rand(0, $height);

    $x2=mt_rand(0, $width);
    $y2=mt_rand(0, $height);

    imageline($image, $x1, $y1, $x2, $y2, $linescolor);
}
$aumentar=16;
foreach(str_split($texto) as $i=> $d)
{
    $angulo=mt_rand(-15, 15);
    imagettftext($image, 20, $angulo, ($aumentar*$i)+3, 22, $black, $font, $d);
}
f::setSession('captcha', $texto);
header('Content-Type: image/png');
imagepng($image);
imagedestroy($image);