<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],15)){
  if (isset($_POST['idcs']) && !empty($_POST['idcs'])) {
    $idcs=iseguro($cone,$_POST['idcs']);
    $ccs=mysqli_query($cone, "SELECT e.idEmpleado, cs.FechaIni, cs.FechaFin, cs.Descripcion, cs.origen, cs.destino, concat(d.Numero,'-',d.Ano,'-',d.Siglas) AS Resolucion, cs.Estado, cs.Vehiculo FROM comservicios cs INNER JOIN empleado e ON e.idEmpleado=cs.idEmpleado INNER JOIN doc d ON cs.idDoc=d.idDoc WHERE cs.idComServicios=$idcs;");

    if($rcs=mysqli_fetch_assoc($ccs)){
    $dt=intervalo ($rcs['FechaFin'], $rcs['FechaIni']);
    $idec=idecxidexfecha($cone, $rcs['idEmpleado'], date('Y-m-d', strtotime($rcs['FechaIni'])));
    if ($rcs['Vehiculo']==1) {
      $veh="Sí";
    }else {
      $veh="No";
    }
    if ($rcs['Estado']==2) {
      $color="danger";
    ?>
      <div class="row">
        <h4 class="text-danger text-center text-bold"> COMISIÓN CANCELADA</h4>
      </div>
    <?php
    }else {
      $color="aqua";
  }
?>
        <div class="row">
          <div class="col-md-12">
            <table class="table table-bordered table-hover">
              <tr>
                <td colspan="4">
                  <div class="row">
                    <div class="col-md-3">
                      <img src="<?php echo mfotom(DNI($cone,$rcs['idEmpleado'])) ?>" class="img-responsive img-thumbnail">
                    </div>
                    <div class="col-md-9">
                      <table class="table table-bordered table-hover">
                        <tr>
                          <th><span class="text-<?php echo $color;?>">Comisionado</span></th>
                          <th><?php echo nomempleado($cone,$rcs['idEmpleado']); ?></th>
                        </tr>
                        <tr>
                          <th><span class="text-<?php echo $color;?>">Cargo</span></th>
                          <td><?php echo cargocu($cone, $idec); ?></td>
                        </tr>
                        <tr>
                          <th><span class="text-<?php echo $color;?>">Dependencia</span></th>
                          <td><?php echo dependenciaxiecxfecha($cone, $idec, date('Y-m-d', strtotime($rcs['FechaIni']))); ?></td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </td>
              </tr>
              <tr>
                <th><span class="text-<?php echo $color;?>">Inicio</span></th>
                <th><span class="text-<?php echo $color;?>">Fin </span></th>
                <!-- <th><span class="text-<?php //echo $color;?>">Días</span></th> -->
                <th colspan="2"><span class="text-<?php echo $color;?>">Vehículo </span></th>
              </tr>              
              <tr>
                <td><?php echo date('d/m/Y H:i', strtotime($rcs['FechaIni'])); ?></th>
                <td><?php echo date('d/m/Y H:i', strtotime($rcs['FechaFin'])); ?></th>
                <!-- <td><?php //echo $dt?></th> -->
                <td colspan="2"><?php echo $veh?></th>
              </tr>
              <tr>
                <th><span class="text-<?php echo $color;?>">Origen</span></th>
                <th colspan="3"><span class="text-<?php echo $color;?>">Destino</span></th>
              </tr>
              <tr>
                <td><?php echo $rcs['origen']; ?></th>
                <td colspan="3"><?php echo $rcs['destino']; ?></th>
              </tr>

              <tr>
                <th colspan="4"><span class="text-<?php echo $color;?>">Descripción</span></th>
              </tr>
              <tr>
                <td colspan="4"><?php echo $rcs['Descripcion']; ?></td>
              </tr>
              <tr>
                <th colspan="4"><span class="text-<?php echo $color;?>">Documento de aprobación</span></th>
              </tr>
              <tr>
                <td colspan="4"><?php echo $rcs['Resolucion']; ?></td>
              </tr>
              <tr>
                <th colspan="2" class="text-center"><span class="text-<?php echo $color;?>">ENCARGATURA</span></th>
                <?php
                if ($rcs['Estado']==1) {
                ?>
                  <th colspan="2" class="block-center"><button type="button" class="btn btn-block btn-info btn-xs" data-toggle="modal" data-target="#m_nencargatura" onclick="nueenca(<?php echo $idcs?>)">AGREGAR</button></th>
                <?php
                }
                ?>
              </tr>
              <tr>
                <td colspan="4">
                  <div class="" id="r_encargatura">
                    <table class="table table-bordered">
                    <?php
                      $cen=mysqli_query($cone, "SELECT * FROM encargatura where idComServicios=$idcs;");
                      if(mysqli_num_rows($cen)>0){
                    ?>
                    <tr>
                      <th><span class="text-<?php echo $color;?>">Encargado</span></th>
                      <th><span class="text-<?php echo $color;?>">Inicio</span></th>
                      <th><span class="text-<?php echo $color;?>">Fin </span></th>
                      <th><span class="text-<?php echo $color;?>">Tipo </span></th>
                    </tr>
                    <?php
                        while ($ren=mysqli_fetch_assoc($cen)){
                          if ($ren['Tipo']==1) {
                            $t="Des/Coor";
                          }elseif ($ren['Tipo']==2) {
                            $t="Coordinación";
                          }elseif ($ren['Tipo']==3) {
                            $t="Despacho";
                          }
                    ?>
                          <tr>
                            <td><?php echo nomempleado($cone,$ren['idEmpleado']);?></th>
                            <td><?php echo date('d/m/Y H:i', strtotime($ren['Inicio'])); ?></th>
                            <td><?php echo date('d/m/Y H:i', strtotime($ren['Fin'])); ?></th>
                            <td><?php echo $t ?></th>
                          </tr>
                      <?php
                        }
                      }else {
                        ?>
                        <tr>
                          <td> <?php echo mensajewa("No se han registrado encargaturas")?></td>
                        </tr>
                        <?php
                      }
                       ?>
                    </table>
                  </div>
                </td>
              </tr>

            </table>
          </div>
        </div>

      <?php

    }else{
      echo mensajeda("No envió datos válidos.");
    }
    mysqli_free_result($ccs);
  }else{
    echo mensajeda("No envió datos.");
  }
}else{
  echo accrestringidoa();
}
?>
