<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){
      if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_edisispension"){
            $idpe=iseguro($cone,$_POST['idpe']);
            $penins=iseguro($cone,$_POST['penins']);
            $cuspp=imseguro($cone,$_POST['cuspp']);
            $fecafi=fmysql(iseguro($cone,$_POST['fecafi']));
            $ti=iseguro($cone,$_POST['ti']);
            if(isset($penins) && !empty($penins) && isset($cuspp) && !empty($cuspp)){
                  if($ti==0){
                        $sql="INSERT INTO pensionempleado (idEmpleado, idSistemaPension, CUSPP, FecAfiliacion) VALUES ($idpe, $penins, '$cuspp', '$fecafi')";
                  }else{
                       $sql="UPDATE pensionempleado SET idSistemaPension=$penins, CUSPP='$cuspp', FecAfiliacion='$fecafi' WHERE idEmpleado=$idpe"; 
                  }    
                  if(mysqli_query($cone,$sql)){
                        echo "<h4 class='text-olive'>Listo: Los datos del sistema de pensión fueron editados correctamente.</h4>";
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