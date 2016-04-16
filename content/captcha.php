<?php
include("functions.php");
function hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);
   $hex = str_replace(",","",$hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   return $rgb; // returns an array with the rgb values
}


session_start();
$code=rand(1000,9999);
$_SESSION["code"]=$code;
$im = imagecreatetruecolor(50, 20);
imagesavealpha($im,true);
$trans_colour = imagecolorallocatealpha($im, 0, 0, 0, 127);
imagefill($im, 0, 0, $trans_colour);

//We need now a Text-Color corresponding to our chosen style:
//Idea: get the theme-id, then the theme-style-file, open it and extract the corresponding hex color
$theme = 0;
if(isset($_SESSION['user_id'])){
	//Das vom Benutzer gewählte Theme abfragen
    $db = new DB();
    $theme = $db->getTheme($_SESSION['user_id'])[0]['theme'];
    $db->closeConnection();
}
$theme_name = getThemeName($theme);
$style_file = fopen("../styles/".$theme_name.".css", "r");
if($style_file){
	while(($line = fgets($style_file)) !== false) {
		if(strstr($line, '--button-text-color')){
			$text_color = strstr($line, '#');
			$col_array = hex2rgb($text_color);
			$fg = imagecolorallocate($im, $col_array[0], $col_array[1], $col_array[2]);
			//imagestring($im, 5, 7, 0,  $code, $fg);
			imagettftext($im, 15, 5, 5, 19, $fg, "font/captcha.ttf", $code);
			header("Cache-Control: no-cache, must-revalidate");
			header('Content-type: image/png');
			imagepng($im);
			imagedestroy($im);
		}
	}
	fclose($style_file);
} else {
	exit;
}
?>