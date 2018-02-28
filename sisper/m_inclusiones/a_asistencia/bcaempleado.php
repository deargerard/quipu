<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],2)){
  if(isset($_POST['mesanoc']) && !empty($_POST['mesanoc']) && isset($_POST['per']) && !empty($_POST['per']) && isset($_POST['car']) && !empty($_POST['car'])){
    $emp=iseguro($cone,$_POST['per']);
    $car=iseguro($cone,$_POST['car']);
    $mesanoj=iseguro($cone,$_POST['mesanoc']);
    $mesano=explode("/", $mesanoj);
    if(strlen($mesano[0])==2 && strlen($mesano[1])==4){
      //calculamos el numero de días del mes seleccionado
      $ndias=cal_days_in_month(CAL_GREGORIAN, $mesano[0], $mesano[1]);
      //calculamos primer inicio y final del mes y la fecha mes
      $fm=$mesano[1]."-".$mesano[0];
      $fi=$mesano[1]."-".$mesano[0]."-01";
      $ff=$mesano[1]."-".$mesano[0]."-".$ndias;
      //Consultamos si le corresponde marcación
      $q1="SELECT idEstadoCar, FechaIni FROM estadocargo WHERE idEmpleadoCargo=$car AND DATE_FORMAT(FechaIni,'%Y-%m')='$fm' ORDER BY FechaIni DESC LIMIT 1;";
      $q2="SELECT idEstadoCar FROM estadocargo WHERE idEmpleadoCargo=$car AND DATE_FORMAT(FechaIni,'%Y-%m')<'$fm' ORDER BY FechaIni DESC LIMIT 1;";
      $ccm1=mysqli_query($cone,$q1);
      $ccm2=mysqli_query($cone,$q2);
      $cm=false;
      if($rcm1=mysqli_fetch_assoc($ccm1)){
        $cm=true;
        //Como el mes comprende a un inicio o final del cargo calculamos la fecha de inicio o final que se usara para su marcación
        if($rcm1['idEstadoCar']==1){
          $fi=$rcm1['FechaIni'];
        }else{
          $ff=$rcm1['FechaIni'];
        }
      }elseif($rcm2=mysqli_fetch_assoc($ccm2)){
        if($rcm2['idEstadoCar']==1){
          $cm=true;
        }
      }
      mysqli_free_result($ccm1);
      mysqli_free_result($ccm2);
      if($cm){
        echo "<br>Corresponde marcación <br>";
      }else{
        echo "<br>No corresponde marcación <br>";
      }

        echo $fi." | ".$ff;


?>
<br>
<div class="row">
  <div class="col-md-6">
    <h4><i class='fa fa-user text-gray'></i> <span class="text-orange"><?php echo nomempleado($cone,$emp); ?></span></h4>
  </div>
  <div class="col-md-4">
    <h4><i class='fa fa-calendar text-gray'></i> <span class="text-orange"><?php echo strtoupper(nombremes($mesano[0])).' - '.$mesano[1]; ?></span></h4>
  </div>
  <div class="col-md-2 text-right">
    <a href="#" class="btn btn-sm bg-orange" onclick="acasistencia(<?php echo "'".$mesanoj."', ".$emp.", ".$car; ?>);"><i class="fa fa-refresh"></i> Actualizar</a>
  </div>
</div>
<?php
      if(!$cm){
        echo mensajewa("No le corresponde asistencia.");
      }else{
        //validamos si se selecciono el mes actual y fecha final será un día antes del actual.
        if(date('Y-m')==$fm){
          $ff=date('Y-m-d', strtotime("-1 day", strtotime(date('Y-m-d'))));
        }
        echo $ff;
?>
        <input type="hidden" name="mesanoa" id="mesanoa" value="<?php echo $mesanoj; ?>">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <td>DIA</td>
              <td>INGRESO</td>
              <td>SAL. REF.</td>
              <td>ING. REF.</td>
              <td>SALIDA</td>
              <td>JUSTIFICACIÓN</td>
              <td>TARD</td>
              <td>INCIDENTE</td>
              <td>TURNO</td>
            </tr>
          </thead>
          <tbody>
<?php

      $nf=0;
      for ($i=$fi; $i <= $ff; $i=date("Y-m-d", strtotime("+1 day", strtotime($i)))) {
        $fec=$i;
        $nomdia=nombredia($fec);

        //variables
        $mif="";
        $msrf="";
        $mirf="";
        $msf="";
        $ti=0;
        $tir=0;
        $incd="";
        //consultamos si el día tiene justificación para no asistir
        //variables dias justificados
        $dj=false;
        $nj="";
        //Colsultamos licencia
        $cl=mysqli_query($cone, "SELECT d.Numero, d.Ano, d.Siglas FROM empleadocargo ec INNER JOIN licencia l ON ec.idEmpleadoCargo=l.idEmpleadoCargo INNER JOIN aprlicencia al ON l.idLicencia=al.idLicencia INNER JOIN doc d ON al.idDoc=d.idDoc WHERE ('$fec' BETWEEN l.FechaIni AND l.FechaFin) AND ec.idEmpleado=$emp AND l.Estado=1;");
        if($rl=mysqli_fetch_assoc($cl)){
          $dj=true;
          $nj="Licencia<br><small style='font-size:70%;'>".$rl['Numero']."-".$rl['Ano']."-".$rl['Siglas']."</small>";
        }
        //Consultamos vacaciones
        $cv=mysqli_query($cone, "SELECT d.Numero, d.Ano, d.Siglas FROM empleadocargo ec INNER JOIN provacaciones pv ON ec.idEmpleadoCargo=pv.idEmpleadoCargo INNER JOIN aprvacaciones av ON pv.idProVacaciones=av.idProVacaciones INNER JOIN doc d ON av.idDoc=d.idDoc WHERE ('$fec' BETWEEN pv.FechaIni AND pv.FechaFin) AND ec.idEmpleado=$emp AND pv.estado!=2;");
        if($rv=mysqli_fetch_assoc($cv)){
          $dj=true;
          $nj="Vacaciones<br><small style='font-size:70%;'>".$rv['Numero']."-".$rv['Ano']."-".$rv['Siglas']."</small>";
        }
        //Consultamos Comisión de servicio
        $ccs=mysqli_query($cone, "SELECT d.Numero, d.Ano, d.Siglas FROM comservicios cs INNER JOIN doc d ON cs.idDoc=d.idDoc WHERE ('$fec' BETWEEN cs.FechaIni AND cs.FechaFin) AND cs.idEmpleado=$emp AND cs.Estado=1;");
        if($rcs=mysqli_fetch_assoc($ccs)){
          $dj=true;
          $nj="Com. Servicios<br><small style='font-size:70%;'>".$rcs['Numero']."-".$rcs['Ano']."-".$rcs['Siglas']."</small>";
        }

        //validamos si su día tiene justificación
        if(!$dj){
          //consultamos si el día esta considerado como día libre
          $cdl=mysqli_query($cone, "SELECT * FROM dialibre WHERE Fecha='$fec';");
          if($rdl=mysqli_fetch_assoc($cdl)){
            $nj=$rdl['Descripcion'];
          }else{
            //consultamos el horario para el día
            $ceh=mysqli_query($cone,"SELECT idHorario FROM empleadohorario WHERE idEmpleado=$emp AND Fecha='$fec' AND Estado=1;");
            if($reh=mysqli_fetch_assoc($ceh)){
              $idh=$reh['idHorario'];
            }else{
              $idh=1;
            }
            mysqli_free_result($ceh);
            //consultamos datos del horario
            $cdh=mysqli_query($cone, "SELECT ReqMarcacion, Ingreso, SalidaRef, IngresoRef, Salida, SalSigDia FROM horario WHERE idHorario=$idh;");
            if($rdh=mysqli_fetch_assoc($cdh)){
              $rm=$rdh['ReqMarcacion'];
              $ing=$rdh['Ingreso'];
              $salref=$rdh['SalidaRef'];
              $ingref=$rdh['IngresoRef'];
              $sal=$rdh['Salida'];
              $ssd=$rdh['SalSigDia'];
            }
            mysqli_free_result($cdh);

            //consultamos si es necesario buscar marcaciones
            if($rm){
              //validamos si el turno es normal y si el día es sábado o domingo
              if($idh==1 && ($nomdia=="Sábado" || $nomdia=="Domingo")){
                $nj="Día libre";
              }else{
                //buscamos la marcación de ingreso
                $ing1=date('Y-m-d H:i:s',strtotime('-30 minute', strtotime($fec." ".$ing)));
                $ing2=date('Y-m-d H:i:s',strtotime('+75 minute', strtotime($fec." ".$ing)));
                $ingt=date('Y-m-d H:i:s',strtotime('+6 minute', strtotime($fec." ".$ing)));

                $cmi=mysqli_query($cone, "SELECT Marcacion FROM marcacion WHERE idEmpleado=$emp AND (Marcacion BETWEEN '$ing1' AND '$ing2');");
                if($rmi=mysqli_fetch_assoc($cmi)){
                  $mi=$rmi['Marcacion'];
                  $mif=date('h:i A', strtotime($mi));
                  //calcular tardanza
                  if($mi>=$ingt){
                    $ingdt=new DateTime($fec." ".$ing);
                    $midt=new DateTime($mi);
                    $dm=$ingdt->diff($midt);
                    $ti=$dm->i;
                  }

                }else{
                  //no encontro marcación de ingreso
                  $incd="En Falta";
                }
                mysqli_free_result($cmi);
                //buscamos la marcación salida a refrigerio
                if(!is_null($salref)){
                  $salr1=date('Y-m-d H:i:s',strtotime('-75 minute', strtotime($fec." ".$salref)));
                  $salr2=date('Y-m-d H:i:s',strtotime('+15 minute', strtotime($fec." ".$salref)));
                  $cmsr=mysqli_query($cone, "SELECT Marcacion FROM marcacion WHERE idEmpleado=$emp AND (Marcacion BETWEEN '$salr1' AND '$salr2');");
                  if($rmsr=mysqli_fetch_assoc($cmsr)){
                    $msr=$rmsr['Marcacion'];
                    $msrf=date('h:i A', strtotime($msr));
                    //buscamos la marcación de ingreso de refrigerio
                    $ingr1=date('Y-m-d H:i:s',strtotime('-20 minute', strtotime($fec." ".$ingref)));
                    $ingr2=date('Y-m-d H:i:s',strtotime('+75 minute', strtotime($fec." ".$ingref)));
                    $ingrt=date('Y-m-d H:i:s',strtotime('+6 minute', strtotime($fec." ".$ingref)));
                    $cmir=mysqli_query($cone, "SELECT Marcacion FROM marcacion WHERE idEmpleado=$emp AND (Marcacion BETWEEN '$ingr1' AND '$ingr2');");
                    if($rmir=mysqli_fetch_assoc($cmir)){
                      $mir=$rmir['Marcacion'];
                      $mirf=date('h:i A', strtotime($mir));
                      //calculamos la tardanza
                      if($mir>=$ingrt){
                        $ingrefdt=new DateTime($fec." ".$ingref);
                        $mirdt=new DateTime($mir);
                        $dmr=$ingrefdt->diff($mirdt);
                        $tir=$dmr->i;
                      }

                    }else{
                      //acciones cuando no marco el ingreso de refrigerio
                      $incd="En Falta";
                    }
                    mysqli_free_result($cmir);

                  }else{
                    //acciones para cuando no necesita marcar el ingreso de refrigerio
                  }
                  mysqli_free_result($cmsr);
                }else{
                //acciones para cuando no necesita marcar salida a refrigerio
                }
                //buscamos la marcación de salida
                $sal1=date('Y-m-d H:i:s',strtotime('-75 minute', strtotime($fec." ".$sal)));
                $sal2=date('Y-m-d H:i:s',strtotime('+30 minute', strtotime($fec." ".$sal)));
                if($ssd){
                  $sal1=date('Y-m-d H:i:s',strtotime('+1 day', strtotime($sal1)));
                  $sal2=date('Y-m-d H:i:s',strtotime('+1 day', strtotime($sal2)));
                }

                $cms=mysqli_query($cone, "SELECT Marcacion FROM marcacion WHERE idEmpleado=$emp AND (Marcacion BETWEEN '$sal1' AND '$sal2');");
                if($rms=mysqli_fetch_assoc($cms)){
                  $ms=$rms['Marcacion'];
                  $msf=date('h:i A', strtotime($ms));

                }else{
                  //acciones para cuando no marco la salida
                  $incd="En Falta";
                }
                mysqli_free_result($cms);
              }
            }else{
              //accion para el turno que no es necesario marcar
            }

          }
          mysqli_free_result($cdl);
        }

        if($incd=="En Falta"){
          $nf++;
        }

        $tdia=$ti+$tir;
        $tmes=$tmes+$tdia;

?>

            <tr id="<?php echo "fila_".$i; ?>" <?php echo $nomdia=="Domingo" ? 'class="danger"' : ''; ?> <?php echo $nomdia=="Sábado" ? 'class="warning"' : ''; ?>>
              <td><?php echo "<b>".$i."</b><br><small style='font-size: 70%;'>".$nomdia."</small>"; ?></td>
              <td><?php echo $mif."<br>".($ti>0 ? "<small class='text-red' style='font-size: 70%;'> (".$ti.")</small>" : ""); ?></td>
              <td><?php echo $msrf; ?></td>
              <td><?php echo $mirf."<br>".($tir>0 ? "<small class='text-red' style='font-size: 70%;'> (".$tir.")</small>" : ""); ?></td>
              <td><?php echo $msf; ?></td>
              <td><?php echo $nj; ?></td>
              <td><?php echo $tdia; ?></td>
              <td><?php echo "<small>".$incd."</small>"; ?></td>
              <td width="125">
                <select class="form-control" style="width: 120px;" onchange="ghorario(this,<?php echo "'".$fec."', ".$emp; ?>);">
                <?php
                  $ch=mysqli_query($cone, "SELECT idHorario, Descripcion FROM horario WHERE Estado=1 ORDER BY Descripcion ASC;");
                  if(mysqli_num_rows($ch)>0){
                    while($rh=mysqli_fetch_assoc($ch)){
                ?>
                  <option value="<?php echo $rh['idHorario']; ?>" <?php echo $rh['idHorario']==$idh ? "selected" : ""; ?>><?php echo $rh['Descripcion']; ?></option>
                <?php
                    }
                  }
                ?>
                </select>
              </td>
            </tr>
<?php
      }
?>
            <tr>
              <th colspan="7">TOTAL</th>
              <th><?php echo $tmes; ?> Min.</th>
              <th><?php echo $nf; ?> Faltas</th>
              <th></th>
            </tr>
          </tbody>
        </table>


<?php
      }
    }else{
      echo mensajewa("Error: El mes/año no es válido.");
    }
  }else{
    echo mensajeda("Error: No se enviaron los datos.");
  }
}else{
  echo accrestringidoa();
}
                  ?>