<?php
//Inicio la sesion 
session_start();

include("../conexion.php");
include("../funciones.php");

$ResPersona = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM personas WHERE Id = '".$_POST["idpersona"]."' LIMIT 1"));

$cadena='<div class="c100 card">
<h2><i class="fa-solid fa-user-plus"></i> Persona</h2>
<form name="feditpersona" id="feditpersona" enctype="multipart/form-data">
    <div class="c60">
        <label class="l_form">Nombre Completo:</label>
        <input type="text" name="nombre" id="nombre" value="'.$ResPersona["Nombre"].'">
    </div>
    <div class="c30">
        <label class="l_form">Sexo: </label>
        <select name="sexo" id="sexo">
            <option value="0">Seleccione</option>
            <option value="M"'.(($ResPersona["Sexo"]=='M') ? ' selected' : '').'>Mujer</option>
            <option value="H"'.(($ResPersona["Sexo"]=='H') ? ' selected' : '').'>Hombre</option>
        </select>
    </div>

    <div class="c30">
        <label class="l_form">Año Nacimiento:</label>
        <input type="date" id="annon" name="annon" value="'.$ResPersona["Nacimiento"].'">
    </div>
    <div class="c30">
        <label class="l_form">Año Defuncion:</label>
        <input type="date" id="annod" name="annod" value="'.$ResPersona["Deceso"].'">
    </div>
    <div class="c30" style="display: flex; flex-wrap: wrap; align-content: center; align-items: center; justify-content: center; justify-items: center;">
        <label class="l_form">Foto:</label>
        <div class="c40">
            '.((file_exists('fotos/'.$ResPersona["IdNombre"].'.jpg')) ? '<img src="personas/fotos/'.$ResPersona["IdNombre"].'.jpg" alt="Foto" width="100px">' : 'Hola').'
        </div>
        <div class="c50">
            <input type="file" id="fotopersona" name="fotopersona">
        </div>
    </div>

    <div class="c30">
        <label class="l_form">Titulo 1:</label>
        <input type="text" id="titulo1" name="titulo1" value="'.$ResPersona["Titulo1"].'">
    </div>
    <div class="c30">
        <label class="l_form">Titulo 2:</label>
        <input type="text" id="titulo2" name="titulo2" value="'.$ResPersona["Titulo2"].'">
    </div>
    <div class="c30" style="display: flex; flex-wrap: wrap; align-content: center; align-items: center; justify-content: center; justify-items: center;">
        <label class="l_form">Imagen:</label>
        <div class="c40">
            '.((file_exists('imagenes/'.$ResPersona["IdNombre"].'.jpg')) ? '<img src="personas/imagenes/'.$ResPersona["IdNombre"].'.jpg" alt="Foto" width="100px">' : '').'
        </div>
        <div class="c50">
            <input type="file" id="imagenpersona" name="imagenpersona">
        </div>
    </div>

    <div class="c30">
        <label class="l_form">Titulo frase:</label>
        <input type="text" id="titulofrase" name="titulofrase" value="'.$ResPersona["TituloFrase"].'">
    </div>
    <div class="c30">
        <label class="l_form">Frase:</label>
        <input type="text" id="frase" name="frase" value="'.$ResPersona["Frase"].'">
    </div>
    <div class="c30">
        <label class="l_form">Autor:</label>
        <input type="text" id="autor" name="autor" value="'.$ResPersona["AutorFrase"].'">
    </div>

    <div class="c30">
        <label class="l_form">Frase:</label>
        <input type="text" id="frase2" name="frase2" value="'.$ResPersona["Frase2"].'">
    </div>
    <div class="c30">
        <label class="l_form">Autor:</label>
        <input type="text" id="autor2" name="autor2" value="'.$ResPersona["Autor2"].'">
    </div>

    <div class="c30">
        <label class="l_form">Paquete:</label>
        <select name="paquete" id="paquete">
            <option value="1"'.(($ResPersona["Paquete"]==1) ? ' selected': '').'>Alas de cristal</option>
            <option value="2"'.(($ResPersona["Paquete"]==2) ? ' selected': '').'>Vuelo de colibrí</option>
            <option value="3"'.(($ResPersona["Paquete"]==3) ? ' selected': '').'>Dulce nectar</option>
        </select>
    </div>
    <div class="c60">
        <input type="hidden" name="hacer" id="hacer" value="editarpersona">
        <input type="hidden" name="idpersona" id="idpersona" value="'.$ResPersona["Id"].'">
        <input type="submit" name="boteditpersona" id="boteditpersona" value="Guardar Persona">
    </div>
</form>
</div>';

echo $cadena;
?>
<script>

$("#feditpersona").on("submit", function(e){
    cerrarmodal();

	e.preventDefault();
	var formData = new FormData(document.getElementById("feditpersona"));

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

<script>
tinymce.init({
	selector: 'textarea',
    menubar: false,
    toolbar: 'styleselect',
    plugins: 'lists',
    style_formats: [
        { title: 'Párrafo', block: 'p' }
    ],
    forced_root_block: 'p',
});
</script>

<?php
//Created with human intelligence by @jkarreno 2024 - 2025
//May the force be with you
//move your stars
//always ready
?>