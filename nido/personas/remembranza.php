<?php
//Inicio la sesion 
session_start();

include("../conexion.php");
include("../funciones.php");

$ResPersona=mysqli_fetch_array(mysqli_query($conn, "SELECT Nombre FROM personas WHERE Id='".$_POST["idpersona"]."' LIMIT 1"));

$cadena='<div class="c100 card">
            <h2><i class="fa-solid fa-photo-film"></i> Cargar remembranza de '.$ResPersona["Nombre"].'</h2>
            <form name="fadcargarcep" id="fadcargarcep" enctype="multipart/form-data">
                <div class="c100">
                    <label for="videoremem" class="filupp">
                        <span class="filupp-file-name js-value">Remembranza:</span>
                        <input type="file" name="videoremem" accept=".mp4" id="videoremem"/>
                    </label>
                </div>
                <div class="c100">
                    <input type="hidden" name="hacer" id="hacer" value="guardaremembranza"">
                    <input type="hidden" name="idpersona" id="idpersona" value="'.$_POST["idpersona"].'">
                    <input type="submit" name="botcargarremembranza" id="botcargarremembranza" value="Guardar>>">
                </div>
            </form>
        </div>';

echo $cadena;

?>
<script>
//funciones input file
$(document).on('change','input[type="file"]',function(){
	// this.files[0].size recupera el tamaño del archivo
	// alert(this.files[0].size);
	
	var fileName = this.files[0].name;
	var fileSize = this.files[0].size;

	if(fileSize > 200000000){
		alert('El archivo no debe superar los 20MB');
		this.value = '';
		this.files[0].name = '';
	}else{
		// recuperamos la extensión del archivo
		var ext = fileName.split('.').pop();
		
		// Convertimos en minúscula porque 
		// la extensión del archivo puede estar en mayúscula
		ext = ext.toLowerCase();
    
		// console.log(ext);
		switch (ext) {
			case 'mp4': break;
			default:
				alert('El archivo no tiene la extensión adecuada');
				this.value = ''; // reset del valor
				this.files[0].name = '';
		}
	}

});

$(document).ready(function() {

// get the name of uploaded file
  $('input[type="file"]').change(function(){
      var value = $("input[type='file']").val();
      $('.js-value').text(value);
  });

});
</script>