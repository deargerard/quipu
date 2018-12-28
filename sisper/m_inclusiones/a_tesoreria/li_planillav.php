<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
  if(isset($_POST['v1']) && !empty($_POST['v1'])){
    $v1=iseguro($cone, $_POST['v1']);
      if(accesocon($cone,$_SESSION['identi'],16)){
        $cc=mysqli_query($cone, "SELECT cs.*, d.Numero, d.Ano, d.Siglas, e.ApellidoPat, e.ApellidoMat, e.Nombres, e.NumeroDoc, td.TipoDoc FROM comservicios cs INNER JOIN doc d ON cs.idDoc=d.idDoc INNER JOIN empleado e ON cs.idEmpleado=e.idEmpleado INNER JOIN tipodoc td ON d.idTipoDoc=d.idTipoDoc WHERE idComServicios=$v1;");
        if($rc=mysqli_fetch_assoc($cc)){
          $idec=idecxidexfecha($cone, $rc['idEmpleado'], date('Y-m-d', strtotime($rc['FechaIni'])));
          //calculamos el numerde horas
          $d1=new DateTime($rc['FechaIni']);
          $d2=new DateTime($rc['FechaFin']);
          $dif=$d1->diff($d2);
          $ho=($dif->days)*60+$dif->i;
          if($ho>=24){
?>
        <table class="table table-bordered table-hover">
          <tr>
            <th>Apellidos y Nombres</th>
            <td colspan="5"><?php echo $rc['ApellidoPat']." ".$rc['ApellidoMat']." ".$rc['Nombres']; ?></td>
            <td colspan="3" align="right">
              <?php if(accesoadm($cone,$_SESSION['identi'],16)){ ?>
              <button class="btn bg-yellow btn-sm" onclick="fo_viaticos1('agrcon', <?php echo $v1; ?>, 0);"><i class="fa fa-plus"></i></button>
              <?php } ?>
              <button class="btn bg-yellow btn-sm"><i class="fa fa-cloud-download"></i></button>
            </td>
          </tr>
          <tr>
            <th>Dependencia</th>
            <td colspan="3"><?php echo dependenciaxiecxfecha($cone, $idec, date('Y-m-d', strtotime($rc['FechaIni']))); ?></td>
            <th colspan="2">D.N.I.</th>
            <td colspan="3"><?php echo $rc['NumeroDoc']; ?></td>
          </tr>
          <tr>
            <th>Cargo</th>
            <td colspan="3"><?php echo cargoiec($cone, idecxidexfecha($cone, $rc['idEmpleado'], date('Y-m-d', strtotime($rc['FechaIni'])))); ?></td>
            <th colspan="2">Regimen</th>
            <td colspan="3"><?php echo condicionlabxiec($cone, $idec); ?></td>
          </tr>
          <tr>
            <th>Mnemonico</th>
            <td><?php echo $rc['mnemonico']; ?></td>
            <th colspan="2">N° de Cuenta</th>
            <td colspan="5"></td>
          </tr>
          <tr>
            <th>Lugar de la comisión</th>
            <td><?php echo disprodep($cone, $rc['idDistrito']); ?></td>
            <th colspan="2">Doc. Autoriza</th>
            <td colspan="5"><?php echo $rc['TipoDoc']." ".$rc['Numero']."-".$rc['Ano']."-".$rc['Siglas']; ?></td>
          </tr>
          <tr>
            <th>Motivo de la comisión</th>
            <td colspan="9"></td>
          </tr>
          <tr>
            <th>Fecha salida</th>
            <td><?php echo date('d/m/Y', strtotime($rc['FechaIni'])); ?></td>
            <th colspan="2">Fecha retorno</th>
            <td colspan="3"><?php echo date('d/m/Y', strtotime($rc['FechaFin'])); ?></td>
            <th colspan="2">TOTAL HORAS</th>
          </tr>
          <tr>
            <th>Hola salida</th>
            <td><?php echo date('H:i', strtotime($rc['FechaIni'])); ?> Horas</td>
            <th colspan="2">Hola retorno</th>
            <td colspan="3"><?php echo date('H:i', strtotime($rc['FechaFin'])); ?> Horas</td>
            <td colspan="2"><?php echo $ho; ?></td>
          </tr>
          <tr>
            <th colspan="2">CONCEPTO</th>
            <th colspan="6">DÍAS</th>
            <th rowspan="2">TOTAL</th>
          </tr>
          <tr>
            <th colspan="2">Viáticos</th>
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>4</th>
            <th>5</th>
            <th>6</th>
          </tr>
<?php
          $cco=mysqli_query($cone, "SELECT idteconceptov, conceptov FROM teconceptov WHERE nanexo=1 AND tipo=1;");
          if(mysqli_num_rows($cco)>0){
            $mg=array();
            while($rco=mysqli_fetch_assoc($cco)){
              $idco=$rco['idteconceptov'];
              $ccg=mysqli_query($cone, "SELECT * FROM tedetplanillav WHERE idComServicios=$v1 AND idteconceptov=$idco;");
              $sh=0;
              if(mysqli_num_rows($ccg)>0){
                while ($rcg=mysqli_fetch_assoc($ccg)){
                  $mg[$idco][$rcg['dia']]=$rcg['monto'];
                  $sh=$sh+$rcg['monto'];
                }
              }
              mysqli_free_result($ccg);
              
?>
          <tr>
            <td colspan="2"><?php echo $rco['conceptov']; ?></td>
            <td>
<?php
            if($mg[$idco][1]>0){
            echo $mg[$idco][1];
?>
                <div class="btn-group btn-group-xs">
                  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#"><i class="fa fa-pencil"></i> Editar</a></li>
                    <li><a href="#"><i class="fa fa-trash"></i> Eliminar</a></li>
                  </ul>
                </div>

<?php
            }
?>
</td>
            <td><?php echo $mg[$idco][2]; ?></td>
            <td><?php echo $mg[$idco][3]; ?></td>
            <td><?php echo $mg[$idco][4]; ?></td>
            <td><?php echo $mg[$idco][5]; ?></td>
            <td><?php echo $mg[$idco][6]; ?></td>
            <td><?php echo number_format((float)$sh, 2, '.', ''); ?></td>
          </tr>
<?php
            }
          }
          mysqli_free_result($cco);
              echo "<pre>";
              print_r($mg);
              echo "</pre>";
?>
          <tr>
            <th colspan="2">Sub Total</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
          </tr>
<?php
          $coc=mysqli_query($cone, "SELECT idteconceptov, conceptov FROM teconceptov WHERE nanexo=1 AND tipo=2;");
          if(mysqli_num_rows($coc)>0){
            $nf=mysqli_num_rows($coc);
            $ti=true;
            while ($roc=mysqli_fetch_assoc($coc)){
?>
          <tr>
            <?php if($ti){ ?>
            <th rowspan="<?php echo $nf; ?>">Otras Asignaciones</th>
            <?php } ?>
            <td><?php echo $roc['conceptov']; ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
<?php
              $ti=false;
            }
          }
?>
          <tr>
            <th colspan="2">TOTAL</th>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <th></th>
          </tr>
        </table>
<?php
          }else{
            echo "comisiones menores a un día";
          }
        }else{
          echo mensajewa("Datos inválidos.");
        }
        mysqli_free_result($cc);
      }else{
        echo accrestringidoa();
      }
  }else{
    echo mensajewa("Faltan datos");
  }
mysqli_close($cone);
?>