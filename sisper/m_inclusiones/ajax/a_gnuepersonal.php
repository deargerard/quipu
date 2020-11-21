<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1)){
      if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_nuepersonal"){
            $apepat=imseguro($cone,$_POST['apepat']);
            $apemat=imseguro($cone,$_POST['apemat']);
            $nom=imseguro($cone,$_POST['nom']);
            $sex=iseguro($cone,$_POST['sex']);
            $fecnac=fmysql(iseguro($cone,$_POST['fecnac']));
            $nac=imseguro($cone,$_POST['nac']);
            $disnac=iseguro($cone,$_POST['disnac']);
            $estciv=iseguro($cone,$_POST['estciv']);
            $tipdoc=iseguro($cone,$_POST['tipdoc']);
            $numdoc=iseguro($cone,$_POST['numdoc']);
            $libmil=imseguro($cone,$_POST['libmil']);
            $aut=imseguro($cone,$_POST['aut']);
            $ruc=iseguro($cone,$_POST['ruc']);
            $corper=inseguro($cone,$_POST['corper']);
            $numcue=iseguro($cone,$_POST['numcue']);
            $entcts=imseguro($cone,$_POST['entcts']);
            $grusan=iseguro($cone,$_POST['grusan']);
            $grains=iseguro($cone,$_POST['grains']);
            $nivins=iseguro($cone,$_POST['nivins']);
            $esp=imseguro($cone,$_POST['esp']);
            $ins=imseguro($cone,$_POST['ins']);
            $penins=iseguro($cone,$_POST['penins']);
            $cuspp=imseguro($cone,$_POST['cuspp']);
            $fecafi=fmysql(iseguro($cone,$_POST['fecafi']));
            $conviv=iseguro($cone,$_POST['conviv']);
            $dir=imseguro($cone,$_POST['dir']);
            $urb=imseguro($cone,$_POST['urb']);
            $disubi=iseguro($cone,$_POST['disubi']);
            $tiptel=iseguro($cone,$_POST['tiptel']);
            $numtel=iseguro($cone,$_POST['numtel']);
            if(isset($apepat) && !empty($apepat) && isset($apemat) && !empty($apemat) && isset($nom) && !empty($nom) && isset($fecnac) && !empty($fecnac) && isset($nac) && !empty($nac) && isset($disnac) && !empty($disnac) && isset($tipdoc) && !empty($tipdoc) && isset($numdoc) && !empty($numdoc)){
                  $cdi=mysqli_query($cone,"SELECT NumeroDoc FROM empleado WHERE NumeroDoc='$numdoc'");
                  if($rdi=mysqli_fetch_assoc($cdi)){
                        echo "<h4 class='text-maroon'>Error: El numero de documento ingresado ya existe.</h4>";
                  }else{
                        $pas=RandomString(10);
                        $pas1=sha1($pas);
                        $fec=@date("Y/m/d");
                        $regpor=$_SESSION['identi'];
                        $sql="INSERT INTO empleado (ApellidoPat, ApellidoMat, Nombres, Sexo, FechaNac, idDistrito, Nacionalidad, TipoDoc, NumeroDoc, LibretaMil, Autogenerado, RUC, idEstadoCivil, CorreoPer, NumeroCuenta, Contrasena, FechaRegistro, Supervisor, RegistradoPor, idGradoInstruccion, Especialidad, Institucion, GrupoSan, EntidadCts, Estado) VALUES ('$apepat', '$apemat', '$nom', '$sex', '$fecnac', $disnac, '$nac', '$tipdoc', '$numdoc', '$libmil', '$aut', '$ruc', $estciv, '$corper', '$numcue', '$pas1', '$fec', 0, $regpor, $nivins, '$esp', '$ins', '$grusan', '$entcts', 0)";
                        if(mysqli_query($cone,$sql)){
                              $idper=mysqli_insert_id($cone);
                              echo "<h4 class='text-olive'>Listo: $apepat $apemat, $nom se registro correctamente.</h4><br>";
                              echo "<h5 class='text-orange'>Usuario: </h5><h5>$numdoc </h5><h5 class='text-orange'>Contraseña: </h5><h5>$pas</h5>";
                              $qd="INSERT INTO domicilio (idEmpleado, Condicion, Direccion, Urbanizacion, idDistrito) VALUES ($idper, '$conviv', '$dir', '$urb', $disubi)";
                              if(!mysqli_query($cone,$qd)){
                                    echo "<h4 class='text-maroon'>Error: No se registro el domicilio.<br>".mysqli_error($cone)."</h4><br>";
                              }
                              $qt="INSERT INTO telefonoemp (idEmpleado, idTipoTelefono, Numero, Estado) VALUES ($idper, $tiptel, '$numtel', 1)";
                              if(!mysqli_query($cone,$qt)){
                                    echo "<h4 class='text-maroon'>Error: No se registro el teléfono.<br>".mysqli_error($cone)."</h4><br>";
                              }
                              $qp="INSERT INTO pensionempleado (idEmpleado, idSistemaPension, CUSPP, FecAfiliacion) VALUES ($idper, $penins, '$cuspp', '$fecafi')";
                              if(!mysqli_query($cone,$qp)){
                                    echo "<h4 class='text-maroon'>Error: No se registro el sistema de pensión.<br>".mysqli_error($cone)."</h4><br>";
                              }
                              $qa="INSERT INTO empleadomodulo (idEmpleado, idModulo, Por, Fecha, Administrar, Consultar) VALUES ($idper, 9, $regpor, '$fec', 1, 0);";
                              if(!mysqli_query($cone, $qa)){
                                    echo "<h4 class='text-maroon'>Error: No se registro los permisos para acceder a su perfil.<br>".mysqli_error($cone)."</h4><br>";
                              }
                              //echo "<a href='carpersonal.php?per=$idper' class='btn btn-primary'>Asignar cargo</a>";

                              //enviamos correo
                              include_once '../../m_email/fcorreo.php';
                              include_once '../../m_email/c_altper.php';

                        }else{
                              echo "<h4 class='text-maroon'>Error: ". mysqli_error($cone)."</h4>";
                        }
                        mysqli_close($cone);
                  }
            }else{
                  echo "<h4 class='text-maroon'>Error: No lleno correctamente el formulario.</h4>";
            }
      }
}else{
      echo accrestringidoa();
}
?>