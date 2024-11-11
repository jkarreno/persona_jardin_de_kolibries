<?php
$cadena='<form name="fenviarecuerdo" id="fenviarecuerdo" enctype="multipart/form-data">
            <div class="c100">
                <label class="l_form">Descripción :</label>
                <textarea id="descripcion" name="descripcion" rows="3"></textarea> 
            </div>
            <div class="c100">
                <label class="l_form">Imagen del recuerdo :</label>
                <input type="file" name="foto" id="foto">
            </div>
            <div class="c100">
                <input type="hidden" name="idpersona" id="idpersona" value="'.$_POST["idpersona"].'">
                <input type="hidden" name="hacer" id="hacer" value="sendrecuerdo">
                <input type="submit" name="botenviamensaje" id="botenviamensaje" value="Enviar mensaje">
            </div>
        </form>';

echo $cadena;

?>
<script>
$("#fenviarecuerdo").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("fenviarecuerdo"));

	$.ajax({
        url: "mensajedos.php",
		type: "POST",
		dataType: "HTML",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(echo){
		$("#contenedor").html(echo);
	});
});
</script>