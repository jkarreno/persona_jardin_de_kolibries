<?php
include ('../nido/conexion.php');

if($_POST["hacer"]=='sendmesaje')
{
    if($_FILES['foto']!='')
    {
        $nombre_archivo_r = $_POST["idpersona"].'_'.$_FILES['foto']['name']; 

        $ext_r=explode('.', $nombre_archivo_r);

        if (is_uploaded_file($_FILES['foto']['tmp_name']))
        { 
            if(copy($_FILES['foto']['tmp_name'], 'files/'.$nombre_archivo_r))
            {
                $copyfile=1;
            }
            else
            {
                $copyfile=2;
                $nombre_archivo_r = NULL;
            }
        }
        else
        {
            $copyfile=3;
            $nombre_archivo_r = NULL;
        }
    }
    else{
        $nombre_archivo_r = NULL;
    }

    mysqli_query($conn, "INSERT INTO mensajes (IdPersona, Nombre, DeDonde, Mensaje, Foto)
                                        VALUES ('".$_POST["idpersona"]."', '".$_POST["nombre"]."', 
                                                '".$_POST["dedonde"]."', '".$_POST["mensaje"]."', 
                                                '".$nombre_archivo_r."')") or die(mysqli_error($conn));
}
if($_POST["hacer"]=='sendrecuerdo')
{
    if($_FILES['foto']!='')
    {
        $nombre_archivo_r = $_POST["idpersona"].'_'.$_FILES['foto']['name']; 

        $ext_r=explode('.', $nombre_archivo_r);

        if (is_uploaded_file($_FILES['foto']['tmp_name']))
        { 
            if(copy($_FILES['foto']['tmp_name'], 'files/'.$nombre_archivo_r))
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
    else{
        $copyfile=3;
    }

    if($copyfile==1){
        mysqli_query($conn, "INSERT INTO recuerdos (IdPersona, Descripcion, Foto)
                                            VALUES ('".$_POST["idpersona"]."', '".$_POST["descripcion"]."',
                                                    '".$nombre_archivo_r."')");
    }
}

$cadena='<h1><i class="fa-solid fa-hands-praying"></i></h1>
            <h2>Gracias por compartir los recuerdos con la familia y amigos</h2>';

echo $cadena;