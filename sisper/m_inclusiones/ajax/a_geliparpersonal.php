<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){
      
            $idpa=iseguro($cone,$_POST['idpa']);

            if(isset($idpa) && !empty($idpa)){
                  
                  $sql="UPDATE pariente SET estado=0 WHERE idPariente=$idpa";
                  if(mysqli_query($cone,$sql)){
                        echo "Listo: Pariente eliminado correctamente.";
                  }else{
                        echo "Error: ". mysqli_error($cone);
                  }
                  mysqli_close($cone); 
            }else{
                  echo "Error: No lleno correctamente el formulario.";
            }
      
}else{
      echo accrestringidoa();
}
?>