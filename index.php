<?php
include("nido/conexion.php");

include ("phpqrcode/qrlib.php"); 

//set it to writable location, a place for temp generated PNG files

$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;

//html PNG location prefix

$PNG_WEB_DIR = 'temp/';



// Obtener la URL actual
//$url = $_SERVER['REQUEST_URI'];
//
//// Separar los elementos de la URL por '/'
//$elementos = explode('/', $url);
//
//echo $elementos[0];

$ResP = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM personas WHERE IdNombre = '".strtoupper($_GET["idp"])."' LIMIT 1"));

//genera codigo QR
$filename = 'temp/'.$ResP["Id"].'.png';
$errorCorrectionLevel = 'H'; 
$matrixPointSize = 4; 
$color = [0, 128, 0];
$texto = 'https://persona.jardindekolibries.com/mensaje/?id='.$ResP["Id"];
QRcode::png($texto, $filename, $errorCorrectionLevel, $matrixPointSize, 2, $color);

?>

<!DOCTYPE html>
<html class="html" lang="es">
<head>
	<meta charset="UTF-8">
    <title>Jardin de Kolibries &#169;​</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="estilos.css">
    <link href="nido/fontawesome64/css/fontawesome.css" rel="stylesheet">
  	<link href="nido/fontawesome64/css/brands.css" rel="stylesheet">
  	<link href="nido/fontawesome64/css/solid.css" rel="stylesheet">
</head>
<body>
    <header class="flex">
        <div>
            <div>
                <a href="https://jardindekolibries.com/"><img src="https://jardindekolibries.com/wp-content/uploads/2021/08/logo-jardinkolibries-02.jpg" /></a>
            </div>
        </div>
    </header>

    <section id="nombre" class="flex">
        <div class="c50">
            <div class="qr">
                <!--codigo qr -->
                <a href="#" onclick="abrirmodal()"><img src="temp/<?php echo $ResP["Id"].'.png';?>"></a>
            </div>
            <h2 style="display: block; text-align: center; color: #545a62;"><?php echo utf8_encode($ResP["Nombre"]);?></h2>
            <h2 style="display: block; text-align: center; color: #e4007d;"><?php echo $ResP["Nacimiento"].'-'.$ResP["Deceso"];?></h2>
        </div>
        <div class="c50">
            <img width="1024" height="595" src="nido/personas/fotos/<?php echo $ResP["IdNombre"];?>.jpg" />	
        </div>
    </section>

    <section id="recuerdos" class="flex">
        <div class="c100 flex" style="background: #ffffff; padding-top: 100px;">
            <div class="c50" style="padding: 20px;">
                <h2 style="color: #e4007d;"><?php echo utf8_encode($ResP["Titulo1"]);?></h2>
                <h2 style="color: #545a62;"><?php echo utf8_encode($ResP["Titulo2"]);?></h2>
                <img decoding="async" width="1024" height="576" src="nido/personas/imagenes/<?php echo $ResP["IdNombre"];?>.jpg" />
                <h2 style="color: #545a62;"><?php echo utf8_encode($ResP["TituloFrase"]);?></h2>
                <p style="color: #7A7A7A"><?php echo utf8_encode($ResP["Frase"]);?></p>
                <h2 class="h2center" style="color: #5A595F"><?php echo utf8_encode($ResP["AutorFrase"]);?></h2>
            </div>
            <div class="c50" style="padding: 20px; border-top: 1px solid #e4007d;">
                <?php echo utf8_encode($ResP["Biografia"]);?>
            </div>
        </div>
    </section>
    <section style="padding-top: 0;">
        <div class="c100 flex">
            <h2 class="titulo">Recuerdos</h2>
            <div class="recuerdos">
                <div>
                    <img loading="lazy" decoding="async" width="768" height="432" src="https://jardindekolibries.com/wp-content/uploads/2021/08/mb-06-768x432.jpg"/>
                    <span>Fin de semana en la playa</span>
                </div>
                <div>
                    <img loading="lazy" decoding="async" width="768" height="432" src="https://jardindekolibries.com/wp-content/uploads/2021/08/mb-06-768x432.jpg"/>
                    <span>Fin de semana en la playa</span>
                </div>
                <div>
                    <img loading="lazy" decoding="async" width="768" height="432" src="https://jardindekolibries.com/wp-content/uploads/2021/08/mb-06-768x432.jpg"/>
                    <span>Fin de semana en la playa</span>
                </div>
                <div>
                    <img loading="lazy" decoding="async" width="768" height="432" src="https://jardindekolibries.com/wp-content/uploads/2021/08/mb-06-768x432.jpg"/>
                    <span>Fin de semana en la playa</span>
                </div>
                <div>
                    <img loading="lazy" decoding="async" width="768" height="432" src="https://jardindekolibries.com/wp-content/uploads/2021/08/mb-06-768x432.jpg"/>
                    <span>Fin de semana en la playa</span>
                </div>
                <div>
                    <img loading="lazy" decoding="async" width="768" height="432" src="https://jardindekolibries.com/wp-content/uploads/2021/08/mb-06-768x432.jpg"/>
                    <span>Fin de semana en la playa</span>
                </div>
                <div>
                    <img loading="lazy" decoding="async" width="768" height="432" src="https://jardindekolibries.com/wp-content/uploads/2021/08/mb-06-768x432.jpg"/>
                    <span>Fin de semana en la playa</span>
                </div>
                <div>
                    <img loading="lazy" decoding="async" width="768" height="432" src="https://jardindekolibries.com/wp-content/uploads/2021/08/mb-06-768x432.jpg"/>
                    <span>Fin de semana en la playa</span>
                </div>
                <div>
                    <img loading="lazy" decoding="async" width="768" height="432" src="https://jardindekolibries.com/wp-content/uploads/2021/08/mb-06-768x432.jpg"/>
                    <span>Fin de semana en la playa</span>
                </div>
            </div>
        </div>
    </section>

    <section class="frase flex">
            <p><?php echo utf8_encode($ResP["Frase2"]);?></p>
            <span><?php echo utf8_encode($ResP["Autor2"]);?></span>
    </section>

    <section class="mensajes">
        <h2 class="titulo">Mensajes</h2>
        <?php
            $ResMensajes = mysqli_query($conn, "SELECT * FROM mensajes WHERE IdPersona = '".$ResP["Id"]."' ORDER BY Id ASC");
            while($RResM = mysqli_fetch_array($ResMensajes))
            {
                echo '<div class="mensaje">
                        <p>'.$RResM["Mensaje"].'</p>
                        <div>
                            <div class="persona">
                                <img src="https://persona.jardindekolibries.com/mensaje/files/'.$RResM["Foto"].'" />
                            </div>
                            <div class="nombrepersona">
                                <h2>'.$RResM["Nombre"].'</h2>
                                <span>'.$RResM["DeDonde"].'</span>
                            </div>
                        </div>
                    </div>';
            }
        ?>
        <div class="mensaje">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>
            <div>
                <div class="persona">
                    <img src="https://jardindekolibries.com/wp-content/uploads/2021/08/mb-gente-03.jpg" />
                </div>
                <div class="nombrepersona">
                    <h2>Javier Domínguez</h2>
                    <span>Compañero de preparatoria</span>
                </div>
            </div>
        </div>
        <div class="mensaje">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>
            <div>
                <div class="persona">
                    <img src="https://jardindekolibries.com/wp-content/uploads/2021/08/mb-gente-03.jpg" />
                </div>
                <div class="nombrepersona">
                    <h2>Javier Domínguez</h2>
                    <span>Compañero de preparatoria</span>
                </div>
            </div>
        </div>
        <div class="mensaje">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>
            <div>
                <div class="persona">
                    <img width="500" height="500" src="https://jardindekolibries.com/wp-content/uploads/2021/08/mb-gente-03.jpg" />
                </div>
                <div class="nombrepersona">
                    <h2>Javier Domínguez</h2>
                    <span>Compañero de preparatoria</span>
                </div>
            </div>
        </div>
        <div class="mensaje">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>
            <div>
                <div class="persona">
                    <img width="500" height="500" src="https://jardindekolibries.com/wp-content/uploads/2021/08/mb-gente-03.jpg" />
                </div>
                <div class="nombrepersona">
                    <h2>Javier Domínguez</h2>
                    <span>Compañero de preparatoria</span>
                </div>
            </div>
        </div>
        <div class="mensaje">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>
            <div>
                <div class="persona">
                    <img width="500" height="500" src="https://jardindekolibries.com/wp-content/uploads/2021/08/mb-gente-03.jpg" />
                </div>
                <div class="nombrepersona">
                    <h2>Javier Domínguez</h2>
                    <span>Compañero de preparatoria</span>
                </div>
            </div>
        </div>
        <div class="mensaje">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>
            <div>
                <div class="persona">
                    <img width="500" height="500" src="https://jardindekolibries.com/wp-content/uploads/2021/08/mb-gente-03.jpg" />
                </div>
                <div class="nombrepersona">
                    <h2>Javier Domínguez</h2>
                    <span>Compañero de preparatoria</span>
                </div>
            </div>
        </div>
    </section>

    <section>
        <h2 class="titulo">Videos</h2>
        <div class="video">
            <div class="vid">
                <iframe width="100%" height="300" src="https://www.youtube.com/embed/g1i2REK7bVQ?si=S8g1lWhvh-yFFiwU" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
            <div class="videsc">
                <h2>Viaje a Europa</h2>
                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
        </div>
        <div class="video">
            <div class="vid">
                <iframe width="100%" height="300" src="https://www.youtube.com/embed/g1i2REK7bVQ?si=S8g1lWhvh-yFFiwU" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
            <div class="videsc">
                <h2>Viaje a Europa</h2>
                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
        </div>
        <div class="video">
            <div class="vid">
                <iframe width="100%" height="300" src="https://www.youtube.com/embed/g1i2REK7bVQ?si=S8g1lWhvh-yFFiwU" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
            <div class="videsc">
                <h2>Viaje a Europa</h2>
                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
        </div>
    </section>

    <section class="memorial">
        <div>
            <img loading="lazy" decoding="async" width="150" height="150" src="https://jardindekolibries.com/wp-content/uploads/2021/09/icono-jardines-memo3-blanco-150x150.png" />
            <h2>VIDEO MEMORIAL</h2>
            <hr>
        </div>
        <div>
            <img loading="lazy" decoding="async" width="150" height="150" src="https://jardindekolibries.com/wp-content/uploads/2021/09/icono-jardines-arb-gen2-150x150.png" />
            <h2>ARBÓL MEMORIAL</h2>
            <hr>
        </div>
    </section>

    <footer>
        <div>
            Jardín de Kolibríes Copyright 2024
        </div>
    </footer>

    <!-- The Modal -->
    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-body" id="modal-body">
                    <img src="<?php echo $filename;?>" style="height: 80%;" />
                    <p style="displya: block; width: 100%; font-family: 'Akrobat Bold', sans-serif; color: #7A7A7A; font-size:20px; text-align: center;">Escanea el código y deja un mensaje a la familia </p>
            </div>
    
        </div>
    </div>
</body>
</html>
<script>
//definimos el modal
var modal = document.getElementById('myModal');

function limpiar(){
    document.getElementById("modal-body").innerHTML="";
}

function abrirmodal(){
	modal.style.display = "block";
}
function cerrarmodal(){
	modal.style.display = "none";
}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
	if (event.target == modal) {
		modal.style.display = "none";
	}
}
</script>
