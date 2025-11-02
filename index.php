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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <header class="flex">
        <div>
            <div>
                <a href="https://jardindekolibries.com/"><img src="https://jardindekolibries.com/wp-content/uploads/2021/08/logo-jardinkolibries-02.jpg" /></a>
            </div>
        </div>
    </header>

    <?php if(file_exists('videos/'.$ResP["Id"].'_remembranza.mp4'))
        {
    ?>
    <section id="remembranza">
        <video autoplay muted loop playsinline controlslist="nodownload" id="mivideo" width="100%" controls autoplay="autoplay" src="videos/<?php echo $ResP["Id"];?>_remembranza.mp4" type="video/mp4">
        </video>
    </section>
    <?php
        }  
    ?>

    <section id="nombre" class="flex">
        <div class="c50">
            <div class="qr">
                <!--codigo qr -->
                <a href="#" onclick="abrirmodal()"><img src="temp/<?php echo $ResP["Id"].'.png';?>"></a>
            </div>
            <h2 class="nombre_persona"><?php echo $ResP["Nombre"];?></h2>
            <h2 class="fechas_persona"><span><?php echo fecha($ResP["Nacimiento"]).'</span><span> a </span><span>'.fecha($ResP["Deceso"]);?></span></h2>
        </div>
        <div class="c50 flex">
            <img src="nido/personas/fotos/<?php echo $ResP["IdNombre"];?>.jpg" />	
        </div>
    </section>

    <section id="recuerdos" class="flex">
        <div class="c100 flex" style="background: #ffffff; padding-top: 100px;">
            <div class="c50" style="padding: 20px;">
                <h2 style="color: #e4007d;"><?php echo $ResP["Titulo1"];?></h2>
                <h2 style="color: #545a62;"><?php echo $ResP["Titulo2"];?></h2>
                <img decoding="async" width="1024" height="576" src="nido/personas/imagenes/<?php echo $ResP["IdNombre"];?>.jpg" />
                <h2 style="color: #545a62;"><?php echo $ResP["TituloFrase"];?></h2>
                <p style="color: #7A7A7A"><?php echo $ResP["Frase"];?></p>
                <h2 class="h2center" style="color: #5A595F"><?php echo $ResP["AutorFrase"];?></h2>
            </div>
            <div class="c50" style="padding: 20px; border-top: 1px solid #e4007d;">
                <?php 
                    $ResBio = mysqli_query($conn, "SELECT * FROM biografia WHERE IdPersona='".$ResP["Id"]."' ORDER BY Orden ASC");
                    while($RResB=mysqli_fetch_array($ResBio))
                    {
                        echo '<p>'.$RResB["Parrafo"].'</p>';
 
                    }
                ?>
            </div>
        </div>
    </section>
    <section style="padding-top: 0;">
        <div class="c100 flex">
            <h2 class="titulo">Recuerdos</h2>
            <div class="recuerdos">
                <?php
                    $ResRecuerdos = mysqli_query($conn, "SELECT * FROM recuerdos WHERE IdPersona='".$ResP["Id"]."' ORDER BY Id ASC");
                    while($RResR=mysqli_fetch_array($ResRecuerdos))
                    {
                        echo ' <div>
                                <img loading="lazy" decoding="async" width="768" height="432" src="mensaje/files/'.$RResR["Foto"].'"/>
                                <span>'.$RResR["Descripcion"].'</span>
                            </div>';
                    }
                ?>
            </div>
        </div>
    </section>

    <section class="frase flex">
            <p><?php echo $ResP["Frase2"];?></p>
            <span><?php echo $ResP["Autor2"];?></span>
    </section>

    <section class="mensajes">
        <h2 class="titulo">Mensajes</h2>
        <div class="botmensaje">
            <a href="https://persona.jardindekolibries.com/mensaje/?id=<?php echo $ResP["Id"];?>" target="_blank" class="tab-flotante">
                <img src="images/escribir.png" />
            </a>
        </div>
        <?php
            $ResMensajes = mysqli_query($conn, "SELECT * FROM mensajes WHERE IdPersona = '".$ResP["Id"]."' ORDER BY Id ASC");
            while($RResM = mysqli_fetch_array($ResMensajes))
            {
                $imagen = ($RResM["Foto"] == '' OR $RResM["Foto"] == NULL) ? 'kolibri.jpg' : $RResM["Foto"];
                echo '<div class="mensaje">
                        <p>'.$RResM["Mensaje"].'</p>
                        <div>
                            <div class="persona">
                                <img src="https://persona.jardindekolibries.com/mensaje/files/'.$imagen.'" />
                            </div>
                            <div class="nombrepersona">
                                <h2>'.$RResM["Nombre"].'</h2>
                                <span>'.$RResM["DeDonde"].'</span>
                            </div>
                        </div>
                    </div>';
            }
        ?>
    </section>

    <!--<section>
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
    </section>-->

    <?php
        $ResVM = mysqli_query($conn, "SELECT * FROM videomemorial WHERE IdPersona = '".$ResP["Id"]."' LIMIT 1");
        if(mysqli_num_rows($ResVM) > 0)
        {
    ?>
    <section class="memorial">
        <?php
            if(mysqli_num_rows($ResVM) > 0)
            {
        ?>
        <div onclick="memorial('<?php echo $ResP["Id"];?>');">
            <img loading="lazy" decoding="async" width="150" height="150" src="https://jardindekolibries.com/wp-content/uploads/2021/09/icono-jardines-memo3-blanco-150x150.png" />
            <h2>VIDEO MEMORIAL</h2>
            <hr>
        </div>
        <?php
            }
        ?>
        <div>
            <img loading="lazy" decoding="async" width="150" height="150" src="https://jardindekolibries.com/wp-content/uploads/2021/09/icono-jardines-arb-gen2-150x150.png" />
            <h2>ARBÓL MEMORIAL</h2>
            <hr>
        </div>
    </section>
    <?php
        }
    ?>

    <footer>
        <div>
            Jardín de Kolibríes Copyright 2025 &#169;​ - Todos los derechos reservados.
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

function memorial(idpersona){
    limpiar();
    abrirmodal();

    $.ajax({
				type: 'POST',
				url : 'video_memorial.php',
                data: 'idpersona=' + idpersona
	}).done (function ( info ){
		$('#modal-body').html(info);
	});
}

//detecta la orientación del video
document.addEventListener('DOMContentLoaded', function() {
  const video = document.getElementById('mivideo');
  const remembranza = document.getElementById('remembranza');

  video.addEventListener('loadedmetadata', function() {
    const { videoWidth, videoHeight } = video;
    const isMobile = window.innerWidth <= 760;

    // 🔧 Resetear estilos antes de aplicar nuevos
    video.style.width = '';
    video.style.height = '';
    video.style.objectFit = '';
    remembranza.style.objectFit = '';

    if (isMobile) {
      if (videoHeight > videoWidth) {
        // 📱 Vertical → alto completo
        video.style.width = 'auto';
        video.style.height = '100vh';
        remembranza.style.height = '100vh';
        video.style.objectFit = 'contain';
      } else {
        // 📱 Horizontal → ocupa toda la pantalla
        video.style.width = '100%';
        video.style.height = 'auto';
        remembranza.style.height = 'auto';
        video.style.objectFit = 'cover';
      }
    } else {
      if (videoHeight > videoWidth) {
        // 💻 Vertical en escritorio
        video.style.objectFit = 'contain';
        video.style.height = '100vh';
        remembranza.style.height = '100vh';
        video.style.width = 'auto';
      } else {
        // 💻 Horizontal en escritorio
        video.style.objectFit = 'cover';
        video.style.width = '100%';
        remembranza.style.width = '100%';
        video.style.height = 'auto';
      }
    }
  });
});

document.addEventListener('DOMContentLoaded', function() {
  const mensajesSection = document.querySelector('.mensajes');
  const tabFlotante = document.querySelector('.tab-flotante');
  
  if (!mensajesSection || !tabFlotante) return;

  let ticking = false;
  
  function updateTabPosition() {
    const sectionRect = mensajesSection.getBoundingClientRect();
    const sectionTop = sectionRect.top;
    const sectionBottom = sectionRect.bottom;
    const offset = 20; // Distancia desde el top
    const tabHeight = tabFlotante.offsetHeight;
    
    if (sectionTop <= offset && sectionBottom > (offset + tabHeight)) {
      // Fijar al top del viewport
      tabFlotante.classList.add('fixed');
      tabFlotante.classList.remove('bottom');
    } else if (sectionBottom <= (offset + tabHeight)) {
      // Fijar al final de la sección
      tabFlotante.classList.remove('fixed');
      tabFlotante.classList.add('bottom');
    } else {
      // Posición inicial dentro de la sección
      tabFlotante.classList.remove('fixed');
      tabFlotante.classList.remove('bottom');
    }
    
    ticking = false;
  }
  
  window.addEventListener('scroll', function() {
    if (!ticking) {
      window.requestAnimationFrame(updateTabPosition);
      ticking = true;
    }
  });
  
  // Ejecutar una vez al cargar
  updateTabPosition();
});
</script>
<?php
function fecha($fecha)
{
    $mes='';

	switch($fecha[5].$fecha[6])
	{
		case '01'; $mes='Enero'; break;
		case '02'; $mes='Febrero'; break;
		case '03'; $mes='Marzo'; break;
		case '04'; $mes='Abril'; break;
		case '05'; $mes='Mayo'; break;
		case '06'; $mes='Junio'; break;
		case '07'; $mes='Julio'; break;
		case '08'; $mes='Agosto'; break;
		case '09'; $mes='Septiembre'; break;
		case '10'; $mes='Octubre'; break;
		case '11'; $mes='Noviembre'; break;
		case '12'; $mes='Diciembre'; break;
	}
	
	$fechanew=$fecha[8].$fecha[9].' - '.$mes.' - '.$fecha[0].$fecha[1].$fecha[2].$fecha[3];
	
	return $fechanew;
}
?>

<?php
//Created with human intelligence by @jkarreno 2024 - 2025
//May the force be with you
//move your stars
//always ready
?>
