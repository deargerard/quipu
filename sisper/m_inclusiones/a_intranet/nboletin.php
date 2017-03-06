<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],11)){
  if(isset($_FILES["bol"])){
    if($_FILES["bol"]["error"]>0){
        echo mensajeda("Error: No se pudo obtener el archivo adjunto.");
    }else{
        if(isset($_POST['des']) && !empty($_POST['des']) && isset($_POST['fecb']) && !empty($_POST['fecb'])){
            $des=iseguro($cone,$_POST['des']);
            $fecb=fmysql(iseguro($cone,$_POST['fecb']));
            $idu=$_SESSION['identi'];

                $limite_kb=6144;
                if($_FILES['bol']['size']<=$limite_kb*1024){
                    $c="INSERT INTO boletin (Descripcion, Fecha, Estado, idEmpleado) VALUES ('$des', '$fecb', 1, $idu)";
                    if(mysqli_query($cone,$c)){
                        $id=mysqli_insert_id($cone);
                        $nomadj='b'.$id.'_'.url($_FILES['bol']['name']);
                        $ruta="../../files_intranet/".$nomadj;
                        $subir=@move_uploaded_file($_FILES['bol']['tmp_name'], $ruta);
                        if($subir){
                            $q="UPDATE boletin SET Adjunto='$nomadj' WHERE idBoletin=$id";
                            if(mysqli_query($cone,$q)){
                                echo mensajesu("Listo: Boletín guardado.");
                            }else{
                                unlink($ruta);
                                mysqli_query($cone,"DELETE FROM boletin WHERE idBoletin=$id");
                                echo mensajeda("Error: No se pudo registrar la información.");
                            }

                        }else{
                            echo mensajeda("Error: No se pudo guardar el boletín.");
                        }
                    }else{
                        echo mensajeda("Error: No se pudo registrar la información.");
                    }
                }else{
                    echo mensajeda("Error: El archivo supero los 2Mb permitidos.");
                }

        }else{
            echo mensajeda("Error: Todos los campos son obligatorios.");
        }
    }
  }else{
    echo mensajesu("Error: No adjunto ningún archivo.");
  }
}else{
  echo accrestringidoa();
}