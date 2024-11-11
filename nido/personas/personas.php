<?php
//Inicio la sesion 
session_start();

include("../conexion.php");
include("../funciones.php");

$mensaje='';

if(isset($_POST["hacer"]))
{
    //agregar persona
    if($_POST["hacer"]=='guardarpersona')
    {
        $nombrepersona=str_replace(' ', '-', $_POST["nombre"]);

        //carga el archivo foto
        if($_FILES['fotopersona']!='')
        {
            $nombre_archivo_fp = $_FILES['fotopersona']['name']; 

            $ext_fp=explode('.', $nombre_archivo_fp);

            if (is_uploaded_file($_FILES['fotopersona']['tmp_name']))
            { 
                if(copy($_FILES['fotopersona']['tmp_name'], 'fotos/'. $nombrepersona . '.'.$ext_fp[1]))
                {
                    $copyfile=1;
                }
                else
                {
                    $copyfile=21;
                }
            }
            else
            {
                $copyfile=31;
            }
        }
        //carga el archivo imagen
        if($_FILES['imagenpersona']!='')
        {
            $nombre_archivo_ip = $_FILES['imagenpersona']['name']; 

            $ext_ip=explode('.', $nombre_archivo_ip);

            if (is_uploaded_file($_FILES['imagenpersona']['tmp_name']))
            { 
                if(copy($_FILES['imagenpersona']['tmp_name'], 'imagenes/'.$nombrepersona.'.'.$ext_ip[1]))
                {
                    $copyfile=1;
                }
                else
                {
                    $copyfile=22;
                }
            }
            else
            {
                $copyfile=32;
            }
        }
    
        //carga el archivo imagen frase
        if($_FILES['imagenfrase']!='')
        {
            $nombre_archivo_if = $_FILES['imagenfrase']['name']; 

            $ext_if=explode('.', $nombre_archivo_if);

            if (is_uploaded_file($_FILES['imagenfrase']['tmp_name']))
            { 
                if(copy($_FILES['imagenfrase']['tmp_name'], 'imagenesfrase/'.$nombrepersona.'.'.$ext_if[1]))
                {
                    $copyfile=1;
                }
                else
                {
                    $copyfile=23;
                }
            }
            else
            {
                $copyfile=33;
            }
        }

        if($copyfile==1)
        {
            mysqli_query($conn, "INSERT INTO personas (Nombre, IdNombre, Sexo, Nacimiento, Deceso, Titulo1, Titulo2, TituloFrase, Frase, AutorFrase, Biografia, Frase2, Autor2, Paquete, Agente)
                                                VALUES ('".utf8_decode($_POST["nombre"])."', '".utf8_decode($nombrepersona)."', '".$_POST["sexo"]."', '".$_POST["annon"]."', '".$_POST["annod"]."', 
                                                        '".utf8_decode($_POST["titulo1"])."', '".utf8_decode($_POST["titulo2"])."', '".utf8_decode($_POST["titulofrase"])."', '".utf8_decode($_POST["frase"])."', 
                                                        '".utf8_decode($_POST["autor"])."', '".utf8_decode($_POST["biografia"])."', '".utf8_decode($_POST["frase2"])."', '".utf8_decode($_POST["autor2"])."', 
                                                        '".$_POST["paquete"]."', '".$_SESSION["Id"]."')");

            $mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-thumbs-up"></i> Se agrego a '.$_POST["nombre"].' a la base de datos</div>'; 
        }
        else{
            $mensaje=$copyfile;
        }
    }
    if($_POST["hacer"]=='guardaremembranza')
    {
        $ResPersona=mysqli_fetch_array(mysqli_query($conn, "SELECT Nombre FROM personas WHERE Id='".$_POST["idpersona"]."' LIMIT 1"));
        //carga el video remembranza
        if($_FILES['videoremem']!='')
        {
            $nombre_archivo_rm =$_FILES['videoremem']['name']; 

            $ext_rm=explode('.', $nombre_archivo_rm);

            if (is_uploaded_file($_FILES['videoremem']['tmp_name']))
            { 
                if(copy($_FILES['videoremem']['tmp_name'], 'videos/'. $_POST["idpersona"] . '_remembranza.'.$ext_rm[1]))
                {
                    $copyfile=1;
                }
                else
                {
                    $copyfile=2;
                }
            }
            else
            {
                $copyfile=3;
            }
        }

        if($copyfile==1)
        {
            $mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-thumbs-up"></i> Se agrego la remembranza de '.$ResPersona["Nombre"].'</div>'; 
        }
        else{
            $mensaje='<div class="mesaje" id="mesaje"><i class="fa-solid fa-triangle-exclamation"></i> ocurrio un error, no se pudo cargar el archivo, intente nuevamente</div>'; 
        }
    }
}

$ResPersonas = mysqli_query($conn, "SELECT * FROM personas ORDER BY Id DESC");


$cadena=$mensaje.'<div class="c100 card" id="tabla_personas">
            <h2><i class="fa-solid fa-users"></i> Personas</h2>
                <table id="table_personas" class="stripe row-border order-column nowrap" style="width: 100%">
                    <thead>
                        <tr>
                            <th class="tleads"></th>
                            <th class="tleads">Nombre</th>
                            <th class="tleads">Nacimiento</th>
                            <th class="tleads">Deceso</th>
                            <th class="tleads">Sexo</th>
                            <th class="tleads">Agente</th>
                            <th class="tleads">Plan</th>
                            <th class="tleads">Remembranza</th>
                            <th class="tleads">Foto</th>
                            <th class="tleads">Memorial</th>
                            <th class="tleads">Editar</th>
                            <th class="tleads">Borrar</th>
                        </tr>
                    </thead>
                    <tbody>';
while($RResP = mysqli_fetch_array($ResPersonas))
{
    $ResP = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM Paquetes WHERE Id = '".$RResP["Paquete"]."' LIMIT 1"));
    $ResA = mysqli_fetch_array(mysqli_query($conn, "SELECT Nombre FROM usuarios WHERE Id = '".$RResP["Agente"]."' LIMIT 1"));
    $sexo = ($RResP["Sexo"]== 'H') ? 'Hombre' : 'Mujer';

    $cadena.='          <tr>
                            <td>'.$RResP["Id"].'</td>
                            <td>'.utf8_encode($RResP["Nombre"]).'</td>
                            <td>'.$RResP["Nacimiento"].'</td>
                            <td>'.$RResP["Deceso"].'</td>
                            <td>'.$sexo.'</td>
                            <td>'.$ResA["Nombre"].'</td>
                            <td>'.$ResP["Paquete"].'</td>
                            <td align="center"><a href="#" onclick="remembranza(\''.$ResP["Id"].'\')"><i class="fa-solid fa-photo-film"></i></a></td>
                            <td align="center"><a href="#" onclick=""><i class="fa-regular fa-image"></i></a></td>
                            <td align="center"><a href="#" onclick=""><i class="fa-solid fa-film"></i></a></td>
                            <td align="center"><a href="#" onclick=""><i class="fa-solid fa-user-pen"></i></a></td>
                            <td align="center"><a href="#" onclick=""><i class="fa-solid fa-trash-can"></i></a></td>
                        </tr>';
}
$cadena.='          </tbody>
                </table>
        </div>';

echo $cadena;

?>
<script>
$(document).ready( function () {
    var table = $('#table_personas').DataTable({
        scrollX: true,
        scrollY: 500,
        scrollCollapse: true,
        scroller:       true,
        deferRender:    true,
        paging: true,
        pageLength: 50,
        language: {
            decimal: '.',
            thousands: ',',
            url: '//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json'
        },
        order: [[0, 'desc']],
        dom: 'Bfrtip',
        buttons: [
            {
                text: 'Agregar persona', 
                action: function(e, dt, node, config ){
                    limpiar();
                    abrirmodal();
                    nueva_persona();
                } 
            }
        ]
    });
});



function nueva_persona(){
    $.ajax({
				type: 'POST',
				url : 'personas/nueva_persona.php'
	}).done (function ( info ){
		$('#modal-body').html(info);
	});
}

function remembranza(idpersona){
    limpiar();
    abrirmodal();
    $.ajax({
				type: 'POST',
				url : 'personas/remembranza.php'
	}).done (function ( info ){
		$('#modal-body').html(info);
	});
}


//mostrar mensaje despues de los cambios
setTimeout(function() { 
    $('#mesaje').fadeOut('fast'); 
}, 1000)