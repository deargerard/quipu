<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1)){
      if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_rescarpersonal"){
            $idec=iseguro($cone,$_POST['idec']);
            $ini=fmysql(iseguro($cone,$_POST['ini']));
            $fin=fmysql(iseguro($cone,$_POST['fin']));
            $mot=iseguro($cone,$_POST['mot']);
            $numres=imseguro($cone,$_POST['numres']);
            $numdoc=imseguro($cone,$_POST['numdoc']);
            $resp=$_SESSION['identi'];
            if(isset($idec) && !empty($idec) && isset($ini) && !empty($ini) && isset($mot) && !empty($mot) && isset($numres) && !empty($numres)){
                  $sql="INSERT INTO estadoempcar (idEmpleadocargo, Estado, FechaIni, FechaFin, Motivo, NumResolucion, NumDocumento, Responsable) VALUES ($idec, 'RESERVADO', '$ini', '$fin', '$mot', '$numres', '$numdoc', $resp)";
                  if(mysqli_query($cone,$sql)){
                        mysqli_query($cone,"UPDATE empleadocargo SET Estado='RESERVADO' WHERE idEmpleadocargo=$idec");
                        echo "<h4 class='text-olive'>Listo: Cargo reservado correctamente.</h4><br>";
                  }else{
                        echo "<h4 class='text-maroon'>Error: ". mysqli_error($cone)."</h4>";
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