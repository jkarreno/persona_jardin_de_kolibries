<?php

$idpersona=$_POST["idpersona"];

if(!isset($_POST["contrasenna_video"])){
    $cadena='<div class="form-contrasenna">
                <img src="https://jardindekolibries.com/wp-content/uploads/2021/08/logo-jardinkolibries-02.jpg" />
                <form name="fpassvideomem" id="fpassvideomem">
                    <label class="l_form">Ingrese la contrase&ntilde;a para ver el video memorial:</label>
                    <input type="password" id="contrasenna_video" name="contrasenna_video" />
                    <input type="hidden" name="idpersona" id="idpersona" value="'.$idpersona.'" />
                    <input type="submit" name="botsenpass" id="botsendpass" value="Ver Video">
                </form>
            </div>';
}
else
{   
    $contrasenna_video=md5($_POST["contrasenna_video"]);

    include("nido/conexion.php");

    $consulta="SELECT * FROM videomemorial WHERE IdPersona='$idpersona' AND Contrasenna='$contrasenna_video' LIMIT 1";
    $resultado=mysqli_query($conn, $consulta);
    $num_filas=mysqli_num_rows($resultado);

    if($num_filas>0){
        $video=mysqli_fetch_array($resultado);
        $cadena='<video autoplay muted loop playsinline controlslist="nodownload" id="mivideo" width="100%" controls autoplay="autoplay" src="videos/'.$video["Video"].'" type="video/mp4">
                    </video>';
    }
    else{
        $cadena='<div class="form-contrasenna">
                    <img src="https://jardindekolibries.com/wp-content/uploads/2021/08/logo-jardinkolibries-02.jpg" />
                    <form name="fpassvideomem" id="fpassvideomem">
                        <label class="l_form">Contrase&ntilde;a incorrecta. Intente de nuevo:</label>
                        <input type="password" id="contrasenna_video" name="contrasenna_video" />
                        <input type="hidden" name="idpersona" id="idpersona" value="'.$idpersona.'" />
                        <input type="submit" name="botsenpass" id="botsendpass" value="Ver Video">
                    </form>
                </div>';
    }
}

echo $cadena;

?>

<script>
$("#fpassvideomem").on("submit", function(e){
    e.preventDefault();
	var formData = new FormData(document.getElementById("fpassvideomem"));

	$.ajax({
        url: "video_memorial.php",
        type: "POST",
		dataType: "HTML",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(echo){
		$("#modal-body").html(echo);
	});
});

</script>