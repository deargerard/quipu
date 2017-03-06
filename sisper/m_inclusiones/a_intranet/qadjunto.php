<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],11)){
    if(isset($_POST['id']) && !empty($_POST['id'])){
        $id=iseguro($cone,$_POST['id']);
        $co=mysqli_query($cone,"SELECT Adjunto FROM comunicado WHERE idComunicado=$id");
        if($ro=mysqli_fetch_assoc($co)){
            $adj=$ro['Adjunto'];
            $c="UPDATE comunicado SET Adjunto='' WHERE idComunicado=$id";
            if(mysqli_query($cone,$c)){
                unlink("../../files_intranet/$adj");
                echo mensajesu("Listo: Se quito el adjunto.");
            }else{
                echo mensajeda("Error: No pudo eliminar.");
            }
        }else{
            echo mensajeda("Error: No se encontro registro.");
        }
    }else{
        echo mensajeda("Error: No envió datos.");
    }
}else{
  echo accrestringidoa();
}
?>