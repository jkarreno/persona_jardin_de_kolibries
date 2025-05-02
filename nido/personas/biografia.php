<?php
//Inicio la sesion 
session_start();

include("../conexion.php");
include("../funciones.php");

$mensaje = '';

if(isset($_POST["hacer"]))
{
    if($_POST["hacer"] == "guardarparrafo"){

        $ResNumOrden = mysqli_query($conn, "SELECT Orden FROM biografia WHERE IdPersona = '".$_POST["idpersona"]."' ORDER BY Orden DESC LIMIT 1");
        if(mysqli_num_rows($ResNumOrden) > 0){
            $RResNumOrden = mysqli_fetch_array($ResNumOrden);
            $numorden = $RResNumOrden["Orden"] + 1;
        }else{
            $numorden = 100;
        }

        $sql = "INSERT INTO biografia (IdPersona, Parrafo, Orden) VALUES ('".$_POST["idpersona"]."', '".$_POST["parrafo"]."', '".$numorden."')";
        mysqli_query($conn, $sql);

        $mensaje = '<div class="mesaje">Se guardo la biografia correctamente</div>';
    }
    else if($_POST["hacer"] == "actualizarparrafo"){
        $sql = "UPDATE biografia SET Parrafo = '".$_POST["parrafo"]."' WHERE Id = '".$_POST["idparrafo"]."' LIMIT 1";
        mysqli_query($conn, $sql);

        $mensaje = '<div class="mesaje">Se actualizo la biografia correctamente</div>';
    }
    else if($_POST["hacer"] == "borrarparrafo"){
        $sql = "DELETE FROM biografia WHERE Id = '".$_POST["idparrafo"]."' LIMIT 1";
        mysqli_query($conn, $sql);

        $mensaje = '<div class="mesaje">Se borro la biografia correctamente</div>';
    }
    else if($_POST["hacer"] == "ordenarparrafos"){
        $ResNumOrden = mysqli_query($conn, "SELECT Orden FROM biografia WHERE Id = '".$_POST["idparrafo"]."' LIMIT 1");
        $RResNumOrden = mysqli_fetch_array($ResNumOrden);
        $numorden = $RResNumOrden["Orden"];

        if($_POST["direccion"] == "up"){
            $sql = "UPDATE biografia SET Orden = '".$numorden."' WHERE IdPersona = '".$_POST["idpersona"]."' AND Orden = '".($numorden-1)."' LIMIT 1";
            mysqli_query($conn, $sql);
            $sql = "UPDATE biografia SET Orden = '".($numorden-1)."' WHERE Id = '".$_POST["idparrafo"]."' LIMIT 1";
            mysqli_query($conn, $sql);
        }else{
            $sql = "UPDATE biografia SET Orden = '".$numorden."' WHERE IdPersona = '".$_POST["idpersona"]."' AND Orden = '".($numorden+1)."' LIMIT 1";
            mysqli_query($conn, $sql);
            $sql = "UPDATE biografia SET Orden = '".($numorden+1)."' WHERE Id = '".$_POST["idparrafo"]."' LIMIT 1";
            mysqli_query($conn, $sql);
        }

        $mensaje = '<div class="mesaje">Se ordeno la biografia correctamente</div>';
        
    }
}
$ResPersona = mysqli_fetch_array(mysqli_query($conn, "SELECT Nombre FROM personas WHERE Id = '".$_POST["idpersona"]."' LIMIT 1"));

$cadena=$mensaje.'<div class="c100 card">
            <h2><i class="fa-solid fa-book"></i> Biografia de '.utf8_encode($ResPersona["Nombre"]).'</h2>';
if(isset($_POST["formulario"]))
{
    if($_POST["formulario"] == "editarparrafo")
    {
        $ResParrafo = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM biografia WHERE Id = '".$_POST["idparrafo"]."' LIMIT 1"));
        $cadena.='<form name="feditbiografia" id="feditbiografia">
                <div class="c100">
                    <label class="l_form">Parrafo</label>
                    <input type="text" name="parrafo" id="parrafo" value="'.utf8_encode($ResParrafo["Parrafo"]).'">
                </div>';
        $cadena.='<div class="c100">
                    <input type="hidden" name="hacer" id="hacer" value="actualizarparrafo">
                    <input type="hidden" name="idparrafo" id="idparrafo" value="'.$_POST["idparrafo"].'">
                    <input type="hidden" name="idpersona" id="idpersona" value="'.$_POST["idpersona"].'">
                    <input type="submit" name="boteditbio" id="boteditbioa" value="Guardar Biografia">
                </div>
            </form>';
    }
}
else
{
    $cadena.='  <form name="faddbiografia" id="faddbiografia">
                    <div class="c100">
                        <label class="l_form">Parrafo</label>
                        <input type="text" name="parrafo" id="parrafo">
                    </div>
                    <div class="c100">
                        <input type="hidden" name="hacer" id="hacer" value="guardarparrafo">
                        <input type="hidden" name="idpersona" id="idpersona" value="'.$_POST["idpersona"].'">
                        <input type="submit" name="botsavebio" id="botsavebioa" value="Guardar Biografia">
                    </div>
                </form>';
}

$cadena.='  <table id="table_biografia" class="stripe row-border order-column nowrap" style="width: 100%" width="100%">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>Num.</th>
                        <th>Biografia</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>';
$ResBiografia = mysqli_query($conn, "SELECT * FROM biografia WHERE IdPersona = '".$_POST["idpersona"]."' ORDER BY Orden ASC"); 
$num = 1; $nump = mysqli_num_rows($ResBiografia);
while($RResB = mysqli_fetch_array($ResBiografia))
{
    $cadena.='      <tr>
                        <td>'.(($num>=1 AND $num<$nump) ? '<a href="#" onclick="ordena_parrafo(\''.$RResB["Id"].'\', \'down\')"><i class="fa-solid fa-arrow-down-long"></i></a>' : '').'</td>
                        <td>'.(($num<=$nump AND $num>1) ? '<a href="#" onclick="ordena_parrafo(\''.$RResB["Id"].'\', \'up\')"><i class="fa-solid fa-arrow-up"></i></a>' : '').'</td>
                        <td>'.$num.'</td>
                        <td style="white-space: normal !important; word-break: break-word;">'.utf8_encode($RResB["Parrafo"]).'</td>
                        <td><a href="#" onclick="editar_parrafo(\''.$RResB["Id"].'\')"><i class="fa-solid fa-pen"></i></a></td>
                        <td><a href="#" onclick="borrar_parrafo(\''.$RResB["Id"].'\')"><i class="fa-solid fa-trash-can"></i></a></td>
                    </tr>';

    $num++;
}
$cadena.='      </tbody>
            </table>
        </div>';

echo $cadena;
?>
<script>
$(document).ready( function () {
    var table = $('#table_biografia').DataTable({
        scrollX: true,
        scrollY: 500,
        scrollCollapse: true,
        scroller: true,
        deferRender: true,
        paging: false,
        pageLength: 50,
        language: {
            decimal: '.',
            thousands: ',',
            url: '//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json'
        },
        order: [[0, 'desc']],
        dom: 'Bfrtip'
    });
});

$("#faddbiografia").on("submit", function(e){
    e.preventDefault();
	var formData = new FormData(document.getElementById("faddbiografia"));

	$.ajax({
		url: "personas/biografia.php",
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

$("#feditbiografia").on("submit", function(e){
    e.preventDefault();
	var formData = new FormData(document.getElementById("feditbiografia"));

	$.ajax({
		url: "personas/biografia.php",
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

function editar_parrafo(idparrafo){
    limpiar();
    $.ajax({
        url: "personas/biografia.php",
        type: "POST",
        dataType: "HTML",
        data: "formulario=editarparrafo&idparrafo=" + idparrafo + "&idpersona=<?php echo $_POST["idpersona"]; ?>",
        cache: false,
    }).done(function(echo){
        $("#modal-body").html(echo);
    });
}
function borrar_parrafo(idparrafo){
    limpiar();
    $.ajax({
        url: "personas/biografia.php",
        type: "POST",
        dataType: "HTML",
        data: "hacer=borrarparrafo&idparrafo=" + idparrafo + "&idpersona=<?php echo $_POST["idpersona"]; ?>",
        cache: false,
    }).done(function(echo){
        $("#modal-body").html(echo);
    });
}
function ordena_parrafo(idparrafo, direccion){
    limpiar();
    $.ajax({
        url: "personas/biografia.php",
        type: "POST",
        dataType: "HTML",
        data: "hacer=ordenarparrafos&idparrafo=" + idparrafo + "&direccion=" + direccion + "&idpersona=<?php echo $_POST["idpersona"]; ?>",
        cache: false,
    }).done(function(echo){
        $("#modal-body").html(echo);
    });
}
</script>

<?php
//Created with human intelligence by @jkarreno 2024 - 2025
//May the force be with you
//move your stars
//always ready
?>