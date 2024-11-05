<?php
$cadena='<form name="fenviamensaje" id="fenviamensaje" enctype="multipart/form-data">
            <div class="c100">
                <label class="l_form">Nombre Completo:</label>
                <input type="text" name="nombre" id="nombre">
            </div>
            <div class="c100">
                <label class="l_form">De donde conoces a :</label>
                <input type="text" name="dedonde" id="dedonde" placeholder="Compañero de escuela, familiar, amigo del trabajo, etc.">
            </div>
            <div class="c100">
                <label class="l_form">Mensaje :</label>
                <textarea id="mensaje" name="mensaje" rows="3"></textarea> 
            </div>
            <div class="c100">
                <label class="l_form">Si lo deseas, puedes subir tu foto :</label>
                <input type="file" name="foto" id="foto">
            </div>
            <div class="c100">
                <input type="hidden" name="idpersona" id="idpersona" value="'.$_POST["idpersona"].'">
                <input type="hidden" name="hacer" id="hacer" value="sendmesaje">
                <input type="submit" name="botenviamensaje" id="botenviamensaje" value="Enviar mensaje">
            </div>
        </form>';

echo $cadena;

?>
<script>
$("#fenviamensaje").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("fenviamensaje"));

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