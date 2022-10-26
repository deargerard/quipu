<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1)){
      if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_nueestcargo"){
            $idec=iseguro($cone,$_POST['idec']);
            $estcar=iseguro($cone,$_POST['estcar']);
            $ini=fmysql(iseguro($cone,$_POST['ini']));
            $fven=vacio(fmysql(iseguro($cone,$_POST['fven'])));
            $numres=imseguro($cone,$_POST['numres']);
            $mot=iseguro($cone,$_POST['mot']);
            if($estcar==3){
                  $fea=$ini;
            }else{
                  $fea=date('Y-m-d',strtotime('-1 day',strtotime($ini)));
            }
            if(isset($idec) && !empty($idec) && isset($estcar) && !empty($estcar) && isset($ini) && !empty($ini) && isset($numres) && !empty($numres)){

                  $c=mysqli_query($cone,"SELECT idEstadoCargo FROM estadocargo WHERE idEmpleadoCargo=$idec AND FechaIni>='$ini';");
                  if($r=mysqli_fetch_assoc($c)){
                        echo mensajewa("Error: La fecha de inicio, no puede ser menor a las fechas de inicio de los estados anteriores.");
                  }else{
                        $sql="INSERT INTO estadocargo (idEmpleadoCargo, idEstadoCar, FechaIni, Vence, NumResolucion, Motivo, Estado) VALUES ($idec, $estcar, '$ini', $fven, '$numres', '$mot', 1)";

                        if(mysqli_query($cone,$sql)){
                              $ideca=mysqli_insert_id($cone);
                              if(!mysqli_query($cone,"UPDATE estadocargo SET Estado=0, FechaFin='$fea' WHERE idEmpleadoCargo=$idec AND Estado=1 AND idEstadoCargo!=$ideca")){
                                    echo mensajewa("Error: ".mysqli_error($cone)." Al actualizar el estado y la fecha fin del estado anterior");
                              }
                              //Si el estado es cese, agregamos la fecha fin a su actual desplazamiento
                              if($estcar==3){
                                    if(!mysqli_query($cone,"UPDATE cardependencia SET FecFin='$ini' WHERE idEmpleadoCargo=$idec AND Estado=1;")){
                                          echo mensajewa("Error: ".mysqli_error($cone)." Al actualizar la fecha fin del último desplazamiento");
                                    }
                              }
                              if(!mysqli_query($cone,"UPDATE empleadocargo SET idEstadoCar=$estcar WHERE idEmpleadoCargo=$idec")){
                                    echo mensajewa("Error: ".mysqli_error($cone)." Al actualizar el estado del cargo.");
                              }
                              //obtenemos el id del empleado para cambiarle el estado
                              $ce=mysqli_query($cone,"SELECT idEmpleado FROM empleadocargo WHERE idEmpleadoCargo=$idec");
                              if($re=mysqli_fetch_assoc($ce)){
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

                                    // if($estcar==3){
                                    //       if(!mysqli_query($cone,"UPDATE empleado SET CorreoIns=NULL WHERE idEmpleado=$ide")){
                                    //             echo mensajewa("Error: ".mysqli_error($cone)." Al eliminar registro del correo institucional");
                                    //       }
                                    // }
                              }
                              mysqli_free_result($ce);
                              echo mensajesu("Listo: Nuevo estado registrado correctamente.");
                              if($estcar==2){
                                    if(!mysqli_query($cone,"UPDATE provacaciones SET Estado=5 WHERE idEmpleadoCargo=$idec AND (Estado=0 OR Estado=4 OR Estado=6 OR Estado=7);")){
                                          echo mensajeda("Error: ".mysqli_error($cone)." Al cambiar estado del las vacaciones.");
                                    }else{
                                          echo mensajewa("Noticia: Sus vacaciones pendientes, planificadas, solicitadas o aceptadas se suspendieron.");
                                    }
                              }elseif($estcar==3){
                                    if(!mysqli_query($cone,"UPDATE provacaciones SET Estado=2 WHERE idEmpleadoCargo=$idec AND (Estado=0 OR Estado=4 OR Estado=6 OR Estado=7);")){
                                          echo mensajeda("Error: ".mysqli_error($cone)." Al cambiar estado del las vacaciones.");
                                    }else{
                                          echo mensajewa("Noticia: Sus vacaciones pendientes, planificadas, solicitadas o aceptadas se cancelaron.");
                                    }
                              }

                        }else{
                              echo mensajeda("Error: No se pudo registrar. ". mysqli_error($cone));
                        }
                        //enviamos correo
                        include_once '../../m_email/fcorreo.php';
                        include_once '../../m_email/c_estper.php';
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