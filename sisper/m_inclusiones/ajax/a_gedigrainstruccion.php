<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){
      if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_edigrainstruccion"){
            $idpe=iseguro($cone,$_POST['idpe']);
            $grains=iseguro($cone,$_POST['grains']);
            $nivins=iseguro($cone,$_POST['nivins']);
            $esp=imseguro($cone,$_POST['esp']);
            $ins=imseguro($cone,$_POST['ins']);
            if(isset($grains) && !empty($grains) && isset($nivins) && !empty($nivins) && isset($esp) && !empty($esp) && isset($ins) && !empty($ins)){
                  $sql="UPDATE empleado SET idGradoInstruccion=$nivins, Especialidad='$esp', Institucion='$ins' WHERE idEmpleado=$idpe";
                  if(mysqli_query($cone,$sql)){
                        echo "<h4 class='text-olive'>Listo: Los datos del grado de instrucción fueron editados correctamente.</h4>";
                  }else{
                        echo "<h4 class='text-maroon'>Error: " . mysqli_error($cone)."</h4>";
                  }
                  mysqli_close($cone);
            }else{
                  echo "<h4 class='text-maroon'>Error: No lleno correctamente el formulario.</h4>";
            }
      }
}else{
      echo accrestringidoa();
}
?>