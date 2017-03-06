<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1)){
      if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_cescarpersonal"){
            $idec=iseguro($cone,$_POST['idec']);
            $fecces=fmysql(iseguro($cone,$_POST['fecces']));
            $mot=iseguro($cone,$_POST['mot']);
            $numres=imseguro($cone,$_POST['numres']);
            $numdoc=imseguro($cone,$_POST['numdoc']);
            $resp=$_SESSION['identi'];
            if(isset($idec) && !empty($idec) && isset($fecces) && !empty($fecces) && isset($mot) && !empty($mot) && isset($numres) && !empty($numres)){
                  $sql="INSERT INTO estadoempcar (idEmpleadocargo, Estado, FechaIni, Motivo, NumResolucion, NumDocumento, Responsable) VALUES ($idec, 'CESADO', '$fecces', '$mot', '$numres', '$numdoc', $resp)";
                  if(mysqli_query($cone,$sql)){
                        mysqli_query($cone,"UPDATE empleadocargo SET Estado='CESADO' WHERE idEmpleadocargo=$idec");
                        $cec=mysqli_query($cone,"SELECT idEmpleado FROM empleadocargo WHERE idEmpleadocargo=$idec");
                        $rec=mysqli_fetch_assoc($cec);
                        $emp=$rec['idEmpleado'];
                        mysqli_query($cone,"UPDATE empleado SET Estado=0 WHERE idEmpleado=$emp");
                        echo "<h4 class='text-maroon'>Listo: Cargo cesado correctamente.</h4><br>";
                        mysqli_free_result($cec);
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