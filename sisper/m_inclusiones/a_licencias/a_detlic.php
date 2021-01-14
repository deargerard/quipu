<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],4)){
  if(isset($_POST['id']) && !empty($_POST['id'])){
    $idli=iseguro($cone,$_POST['id']);
    $q="SELECT tl.TipoLic, tl.MotivoLic, l.FechaIni, l.FechaFin, l.Motivo, l.Medico, l.Colegiatura, em.EspMedica, tdl.DocLicencia, l.NumDoc, d.Numero, d.Ano, d.Siglas, d.FechaDoc, d.Legajo, l.Estado FROM licencia l INNER JOIN tipolic tl ON l.idTipoLic=tl.idTipoLic INNER JOIN espmedica em ON l.idEspMedica=em.idEspMedica INNER JOIN tipdoclicencia tdl ON l.idTipDocLicencia=tdl.idTipDocLicencia INNER JOIN aprlicencia al ON l.idLicencia=al.idLicencia INNER JOIN doc d ON al.idDoc=d.idDoc WHERE l.idLicencia=$idli;";
    $c=mysqli_query($cone, $q);
    if($r=mysqli_fetch_assoc($c)){
      $f1=$r['FechaFin'];
      $f2=$r['FechaIni'];
      $f1=date_create($f1);
      $f2=date_create($f2);
      $tie=date_diff($f1, $f2);
      $dias=$tie->format('%a')+1;
?>
  <div class="row">
    <div class="col-sm-12">
      <table class="table table-bordered table-hover">
        <tr>
          <th colspan="6"><h4 class="text-maroon"><strong><?php echo $r['MotivoLic']; ?></strong> <span>(<?php echo $r['TipoLic']; ?>)</span></h4></th>
        </tr>
        <tr>
          <th>Desde</th>
          <td><?php echo fnormal($r['FechaIni']); ?></td>
          <th>Hasta</th>
          <td><?php echo fnormal($r['FechaFin']); ?></td>
          <th># Días</th>
          <td><strong><span class="text-red"><?php echo $dias; ?></span></strong></td>
        </tr>
        <tr>
          <th>Motivo</th>
          <td colspan="5"><?php echo $r['Motivo']; ?></td>
        </tr>
<?php
        if ($r['MotivoLic']=="Por incapacidad temporal") {
?>
        <tr>
          <th>Médico</th>
          <td colspan="3"><?php echo $r['Medico']; ?></td>
          <th># Coleg.</th>
          <td><?php echo $r['Colegiatura']; ?></td>
        </tr>
        <tr>
          <th>Espec.</th>
          <td colspan="5"><?php echo $r['EspMedica']; ?></td>
        </tr>
        <tr>
          <th>T. Doc.</th>
          <td colspan="3"><?php echo $r['DocLicencia']; ?></td>
          <th># Doc.</th>
          <td><?php echo $r['NumDoc']; ?></td>
        </tr>
<?php
        }
?>
        <tr>
          <th># Resl.</th>
          <td colspan="3"><?php echo $r['Numero']."-".$r['Ano']."-".$r['Siglas']; ?></td>
          <th>F. Resl.</th>
          <td><?php echo fnormal($r['FechaDoc']); ?></td>
        </tr>
        <tr>
          <th>Legajo</th>
          <td colspan="4"><?php echo $r['Legajo']; ?></td>
          <td><?php echo $r['Estado']==0 ? "<span class='label label-danger'>Cancelada</span>" : "<span class='label label-success'>Activa</span>"; ?></td>
        </tr>
                   
        <tr>
          <th colspan="4" class="text-center"><span class="text-maroon">ENCARGATURA</span></th>
          <?php
          if ($r['Estado']==1) {
          ?>
            <th colspan="1" class="block-center"><button type="button" class="btn btn-block btn-info btn-xs" data-toggle="modal" data-target="#m_nencargatura" onclick="nueencali(<?php echo $idli?>)">AGREGAR</button></th>
          <?php
          }
          ?>
        </tr>
        <tr>
          <td colspan="6">
            <div class="" id="r_encargatura">
              <table class="table table-bordered">
                <?php
                  $cen=mysqli_query($cone, "SELECT * FROM encargatura where idLicencia=$idli;");
                  if(mysqli_num_rows($cen)>0){
                  ?>
                    <tr>
                      <th><span class="text-<?php echo $color;?>">Encargado</span></th>
                      <th><span class="text-<?php echo $color;?>">Inicio</span></th>
                      <th><span class="text-<?php echo $color;?>">Fin </span></th>
                      <th><span class="text-<?php echo $color;?>">Tipo </span></th>
                      <th><span class="text-<?php echo $color;?>">Acion </span></th>
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
                  <td>
                    <div class="btn-group btn-group-xs" role="group" aria-label="Basic">
                      <button type="button" class="btn btn-default" title="Editar" onclick="fo_accion('edienc',<?php echo $ren["idEncargatura"] ?>)"><i class="fa fa-pencil"></i></button>
                      <button type="button" class="btn btn-default" title="Eliminar" onclick="fo_accion('elienc',<?php echo  $ren["idEncargatura"] ?>)"><i class="fa fa-trash"></i></button>
                    </div>
                  </td> 
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
      echo mensajewa("Error: Los datos enviados no son válidos.");
    }
  }else{
    echo mensajewa("Error: No se enviaron datos.");
  }
}else{
  echo accrestringidoa();
}
?>
