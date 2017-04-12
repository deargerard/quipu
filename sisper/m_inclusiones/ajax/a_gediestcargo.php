<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1)){
      if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_ediestcargo"){
            $emca=iseguro($cone,$_POST['emca']);
            $idec=iseguro($cone,$_POST['idec']);
            $estcar=iseguro($cone,$_POST['estcar']);
            $ini=fmysql(iseguro($cone,$_POST['ini']));
            $fin=fmysql(iseguro($cone,$_POST['fin']));
            $numres=imseguro($cone,$_POST['numres']);
            $mot=iseguro($cone,$_POST['mot']);

            if(isset($idec) && !empty($idec) && isset($estcar) && !empty($estcar) && isset($ini) && !empty($ini) && isset($numres) && !empty($numres)){
                  $c=mysqli_query($cone, "SELECT idEstadoCargo FROM estadocargo WHERE idEmpleadoCargo=$emca AND idEstadoCargo!=$idec AND FechaIni>='$ini';");
                  if($r=mysqli_fetch_assoc($c)){
                        echo mensajewa("Error: La fecha de inicio no puede ser menor a fechas de estados anteriores.");
                  }else{
                        $sql="UPDATE estadocargo SET idEstadoCar=$estcar, FechaIni='$ini', FechaFin='$fin', NumResolucion='$numres', Motivo='$mot' WHERE idEstadoCargo=$idec";
                        if(mysqli_query($cone,$sql)){
                              //$ideca=mysqli_insert_id($cone);
                              if(!mysqli_query($cone,"UPDATE empleadocargo SET idEstadoCar=$estcar WHERE idEmpleadoCargo=$emca")){
                                    echo mensajewa("Error: ".mysqli_error($cone)." Al actualizar el estado del cargo.");
                              }
                              //obtenemos el id del empleado para cambiarle el estado
                              $ce=mysqli_query($cone,"SELECT idEmpleado FROM empleadocargo WHERE idEmpleadoCargo=$emca");
                              $re=mysqli_fetch_assoc($ce);
                              $ide=$re['idEmpleado'];
                              if($estcar==2 || $estcar==3){
                                    if(!mysqli_query($cone,"UPDATE empleado SET Estado=0 WHERE idEmpleado=$ide")){
                                          echo mensajewa("Error: ".mysqli_error($cone)." Al cambiar estado del empleado.");
                                    }
                              }elseif ($estcar==1) {
                                    if(!mysqli_query($cone,"UPDATE empleado SET Estado=1 WHERE idEmpleado=$ide")){
                                          echo mensajewa("Error: ".mysqli_error($cone)." Al cambiar estado del empleado.");
                                    }
                              }
                              echo mensajesu("Listo: Estado editado correctamente.");
                        }else{
                              echo mensajeda("Error: No se pudo editar. ". mysqli_error($cone));
                        }
                  }
                  mysqli_free_result($c);
                  mysqli_close($cone);     
            }else{
                  echo mensajeda("Error: No lleno correctamente el formulario.");
            }

      }
}else{
      echo accrestringidoa();
}
?>