<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1)){
      if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_nueestcargo"){
            $idec=iseguro($cone,$_POST['idec']);
            $estcar=iseguro($cone,$_POST['estcar']);
            $ini=fmysql(iseguro($cone,$_POST['ini']));
            $fin=fmysql(iseguro($cone,$_POST['fin']));
            $numres=imseguro($cone,$_POST['numres']);
            $mot=iseguro($cone,$_POST['mot']);
            $nfec=@strtotime('-1 day', strtotime($ini));
            $nfec=@date('Y-m-d', $nfec);
            if(isset($idec) && !empty($idec) && isset($estcar) && !empty($estcar) && isset($ini) && !empty($ini) && isset($numres) && !empty($numres)){
                  $sql="INSERT INTO estadocargo (idEmpleadoCargo, idEstadoCar, FechaIni, FechaFin, NumResolucion, Motivo, Estado) VALUES ($idec, $estcar, '$ini', '$fin', '$numres', '$mot', 1)";
                  if(mysqli_query($cone,$sql)){
                        $ideca=mysqli_insert_id($cone);
                        if(!mysqli_query($cone,"UPDATE estadocargo SET FechaFin='$nfec' WHERE idEmpleadoCargo=$idec AND Estado=1 AND idEstadoCargo!=$ideca")){
                              echo "<h4 class='text-maroon'>Error: ".mysqli_error($cone)." Al actualizar finalización del estado anterior.</h4>";
                        }
                        if(!mysqli_query($cone,"UPDATE estadocargo SET Estado=0 WHERE idEmpleadoCargo=$idec AND idEstadoCargo!=$ideca")){
                              echo "<h4 class='text-maroon'>Error: ".mysqli_error($cone)." Al actualizar los estados de los estados anteriores.</h4>";
                        }
                        if(!mysqli_query($cone,"UPDATE empleadocargo SET idEstadoCar=$estcar WHERE idEmpleadoCargo=$idec")){
                              echo "<h4 class='text-maroon'>Error: ".mysqli_error($cone)." Al actualizar el estado del cargo.</h4>";
                        }
                        //obtenemos el id del empleado para cambiarle el estado
                        $ce=mysqli_query($cone,"SELECT idEmpleado FROM empleadocargo WHERE idEmpleadoCargo=$idec");
                        $re=mysqli_fetch_assoc($ce);
                        $ide=$re['idEmpleado'];
                        if($estcar==2 || $estcar==3){
                              if(!mysqli_query($cone,"UPDATE empleado SET Estado=0 WHERE idEmpleado=$ide")){
                                    echo "<h4 class='text-maroon'>Error: ".mysqli_error($cone)." Al cambiar estado del empleado.</h4>";
                              }
                        }elseif ($estcar==1) {
                              if(!mysqli_query($cone,"UPDATE empleado SET Estado=1 WHERE idEmpleado=$ide")){
                                    echo "<h4 class='text-maroon'>Error: ".mysqli_error($cone)." Al cambiar estado del empleado.</h4>";
                              }
                        }
                        echo "<h4 class='text-olive'>Listo: Nuevo estado registrado correctamente.</h4><br>";
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