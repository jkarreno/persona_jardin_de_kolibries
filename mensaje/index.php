<?php
include ('../nido/conexion.php');

$idpersona = $_GET["id"];

$ResP=mysqli_fetch_array(mysqli_query($conn, "SELECT Nombre FROM personas WHERE Id='".$idpersona."' LIMIT 1"));

?>
<!DOCTYPE html>
<html class="html" lang="es">
<head>
	<meta charset="UTF-8">
    <title>Jardin de Kolibries &#169;​</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="estilos.css">
    <link href="../nido/fontawesome64/css/fontawesome.css" rel="stylesheet">
  	<link href="../nido/fontawesome64/css/brands.css" rel="stylesheet">
  	<link href="../nido/fontawesome64/css/solid.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <header class="flex">
        <a href="https://jardindekolibries.com/"><img src="https://jardindekolibries.com/wp-content/uploads/2021/08/logo-jardinkolibries-02.jpg" /></a>
    </header>
    <div class="contenedor" id="contenedor">
        <h2>Envia un mensaje a la familia de <?php echo utf8_encode($ResP["Nombre"]);?> y demuestrales tu cariño con el</h2>

        <div class="boton" onclick="mensaje('<?php echo $idpersona;?>')">
            <p><i class="fa-regular fa-envelope"></i> Mensaje </p>
        </div>

        <div class="boton" onclick="recuerdo('<?php echo $idpersona;?>')">
            <p><i class="fa-solid fa-image"></i> Recuerdo</p>
        </div>
    </div>

    <script>
        //funciones ajax
        function mensaje(idpersona){
            $.ajax({
                type: 'POST',
                url : 'mensaje.php',
                data: 'idpersona=' + idpersona
            }).done (function ( info ){
                $('#contenedor').html(info);
            });
        }
        function recuerdo(idpersona){
            $.ajax({
                type: 'POST',
                url : 'recuerdo.php',
                data: 'idpersona=' + idpersona
            }).done (function ( info ){
                $('#contenedor').html(info);
            });
        }
    </script>
</body>
</html>
