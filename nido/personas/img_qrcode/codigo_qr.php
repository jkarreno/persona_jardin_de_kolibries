<?php
//Inicio la sesion 
session_start();

include("../../conexion.php");
include("../../funciones.php");

include ("../../../phpqrcode/qrlib.php"); 

$ResPersona = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM personas WHERE Id = '".$_POST["idpersona"]."' LIMIT 1"));

// set it to writable location, a place for temp generated PNG files 
$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
// html PNG location prefix 
$PNG_WEB_DIR = 'img_qrcodes/';
if (!File_exists($PNG_TEMP_DIR)){mkdir($PNG_TEMP_DIR);}  
$filename = $ResPersona["IdNombre"].'.png'; 
$errorCorrectionLevel = 'H'; 
$matrixPointSize = 20; 
QRcode::png ("https://persona.jardindekolibries.com/?idp=".$ResPersona["IdNombre"], $filename, $errorCorrectionLevel, $matrixPointSize, 2); 
$QR = $filename; 
$logo ="kolibri.png";

If ($logo!=FALSE) 
{
    $QR = imagecreatefromstring(file_get_contents($QR)); 
    $logo = imagecreatefromstring(file_get_contents($logo)); 
    $QR_width = imagesx($QR); 
    // QR code Image Width 
    $QR_height = imagesy($QR); 
    // QR code Image Height 
    $logo_width = imagesx($logo); 
    // logo image width 
    $logo_height = imagesy($logo); 
    // logo image height 
    $logo_qr_width =  $QR_width/3; 
    $scale = $logo_width/$logo_qr_width; 
    $logo_qr_height = $logo_height/$scale; 
    $from_width = ($QR_width-$logo_qr_width)/2; 
    $from_height = ($QR_height-$logo_qr_height)/2; 
    // re-combine the image and resize 
    imagecopyresampled($QR, $logo, $from_width, $from_height, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
} 
// display generated file 
imagepng($QR, $filename);



$cadena='<div class="c100 card">
            <h2><i class="fa-solid fa-qrcode"></i> Código QR para '.$ResPersona["Nombre"].'</h2>
            <div class="c100" style="text-align: center;">
                <img src="https://persona.jardindekolibries.com/nido/personas/img_qrcode/'.$filename.'" border="0">
            </div>
        </div>';

        unlink('error_log');
echo $cadena;