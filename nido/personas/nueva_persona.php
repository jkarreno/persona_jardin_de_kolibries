<?php
$cadena='<div class="c100 card">
            <h2><i class="fa-solid fa-user-plus"></i> Persona</h2>
            <form name="faddpersona" id="faddpersona" enctype="multipart/form-data">
                <div class="c60">
                    <label class="l_form">Nombre Completo:</label>
                    <input type="text" name="nombre" id="nombre">
                </div>
                <div class="c30">
                    <label class="l_form">Sexo: </label>
                    <select name="sexo" id="sexo">
                        <option value="0">Seleccione</option>
                        <option value="M">Mujer</option>
                        <option value="H">Hombre</option>
                    </select>
                </div>

                <div class="c30">
                    <label class="l_form">Año Nacimiento:</label>
                    <input type="date" id="annon" name="annon">
                </div>
                <div class="c30">
                    <label class="l_form">Año Defuncion:</label>
                    <input type="date" id="annod" name="annod">
                </div>
                <div class="c30">
                    <label class="l_form">Foto:</label>
                    <input type="file" id="fotopersona" name="fotopersona">
                </div>

                <div class="c30">
                    <label class="l_form">Titulo 1:</label>
                    <input type="text" id="titulo1" name="titulo1">
                </div>
                <div class="c30">
                    <label class="l_form">Titulo 2:</label>
                    <input type="text" id="titulo2" name="titulo2">
                </div>
                <div class="c30">
                    <label class="l_form">Imagen:</label>
                    <input type="file" id="imagenpersona" name="imagenpersona">
                </div>

                <div class="c30">
                    <label class="l_form">Titulo frase:</label>
                    <input type="text" id="titulofrase" name="titulofrase">
                </div>
                <div class="c30">
                    <label class="l_form">Frase:</label>
                    <input type="text" id="frase" name="frase">
                </div>
                <div class="c30">
                    <label class="l_form">Autor:</label>
                    <input type="text" id="autor" name="autor">
                </div>

                <div class="c100">
                    <label class="l_form">Biografia:</label>
                    <textarea name="biografia" id="biografia"></textarea>
                </div>

                <div class="c30">
                    <label class="l_form">Frase:</label>
                    <input type="text" id="frase2" name="frase2">
                </div>
                <div class="c30">
                    <label class="l_form">Autor:</label>
                    <input type="text" id="autor2" name="autor2">
                </div>
                <div class="c30">
                    <label class="l_form">Imagen frase:</label>
                    <input type="file" id="imagenfrase" name="imagenfrase">
                </div>

                <div class="c30">
                    <label class="l_form">Paquete:</label>
                    <select name="paquete" id="paquete">
                        <option value="1">Alas de cristal</option>
                        <option value="2">Vuelo de colibrí</option>
                        <option value="3">Dulce nectar</option>
                    </select>
                </div>
                <div class="c60">
                    <input type="hidden" name="hacer" id="hacer" value="guardarpersona">
                    <input type="submit" name="botsavepersona" id="botsavepersona" value="Guardar Persona">
                </div>
            </form>
        </div>';

echo $cadena;

?>
<script>
$("#faddpersona").on("submit", function(e){
    cerrarmodal();

	e.preventDefault();
	var formData = new FormData(document.getElementById("faddpersona"));

	$.ajax({
		url: "personas/personas.php",
		type: "POST",
		dataType: "HTML",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(echo){
		$("#contenido").html(echo);
	});
});
</script>

<?php
//Created with human intelligence by @jkarreno 2024
//May the force be with you
//move your stars
//always ready
?>