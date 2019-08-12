<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],4)){
  if(isset($_POST['id']) && !empty($_POST['id'])){
    $id=iseguro($cone,$_POST['id']);
    $q="SELECT tl.TipoLic, tl.MotivoLic, l.FechaIni, l.FechaFin, l.Motivo, l.Medico, l.Colegiatura, em.EspMedica, tdl.DocLicencia, l.NumDoc, d.Numero, d.Ano, d.Siglas, d.FechaDoc, d.Legajo, l.Estado FROM licencia l INNER JOIN tipolic tl ON l.idTipoLic=tl.idTipoLic INNER JOIN espmedica em ON l.idEspMedica=em.idEspMedica INNER JOIN tipdoclicencia tdl ON l.idTipDocLicencia=tdl.idTipDocLicencia INNER JOIN aprlicencia al ON l.idLicencia=al.idLicencia INNER JOIN doc d ON al.idDoc=d.idDoc WHERE l.idLicencia=$id;";
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
