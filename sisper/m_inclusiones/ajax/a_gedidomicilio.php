<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){
      if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_edidomicilio"){
            $idpe=iseguro($cone,$_POST['idpe']);
            $conviv=iseguro($cone,$_POST['conviv']);
            $dir=imseguro($cone,$_POST['dir']);
            $urb=imseguro($cone,$_POST['urb']);
            $disubi=iseguro($cone,$_POST['disubi']);
            $ti=iseguro($cone,$_POST['ti']);
            if(isset($idpe) && !empty($idpe) && isset($conviv) && !empty($conviv) && isset($dir) && !empty($dir) && isset($disubi) && !empty($disubi)){
                  if($ti==0){
                        $sql="INSERT INTO domicilio (idEmpleado, Condicion, Direccion, Urbanizacion, idDistrito) VALUES($idpe, '$conviv', '$dir', '$urb', $disubi)";
                  }else{
                        $sql="UPDATE domicilio SET Condicion='$conviv', Direccion='$dir', Urbanizacion='$urb', idDistrito=$disubi WHERE idEmpleado=$idpe";
                  }
                  if(mysqli_query($cone,$sql)){
                        echo "<h4 class='text-olive'>Listo: Los datos del domicilio fueron editados correctamente.</h4>";
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