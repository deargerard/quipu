<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],2)){
  if(isset($_POST['anop']) && !empty($_POST['anop']) && isset($_POST['perp']) && !empty($_POST['perp'])){
    $perp=iseguro($cone,$_POST['perp']);
    $anop=iseguro($cone,$_POST['anop']);
?>
<br>
<div class="row">
  <div class="col-md-7">
    <h4><i class='fa fa-user text-gray'></i> <span class="text-orange"><?php echo nomempleado($cone,$perp); ?></span></h4>
  </div>
  <div class="col-md-3">
    <h4><i class='fa fa-calendar text-gray'></i> <span class="text-orange"><?php echo $anop; ?></span></h4>
  </div>
  <div class="col-md-2">
    <?php if(accesoadm($cone,$_SESSION['identi'],2)){ ?>
    <button class="btn btn-sm bg-aqua" data-toggle="modal" data-target="#m_apermiso" onclick="apermiso(<?php echo $perp.", '".$anop."'"; ?>)"><i class="fa fa-plus"></i> Agregar</button>
    <?php } ?>
  </div>
</div>
<?php
  $cp=mysqli_query($cone,"SELECT TipPermiso, idPermiso, FechaIni, FechaFin, Aprobador, p.Estado FROM permiso p INNER JOIN tippermiso tp ON p.idTipPermiso=tp.idTipPermiso WHERE idEmpleado=$perp AND DATE_FORMAT(FechaIni,'%Y')='$anop' ORDER BY FechaIni DESC;");
      if(mysqli_num_rows($cp)>0){
?>
<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>#</th>
      <th>MOTIVO</th>
      <th>INICIA</th>
      <th>FINALIZA</th>
      <th>APROBADOR</th>
      <th>ESTADO</th>
      <th>ACCIÓN</th>
    </tr>
  </thead>
  <tbody>
<?php
        $n=0;
        while ($rp=mysqli_fetch_assoc($cp)) {
          $n++;
?>
    <tr>
      <td><?php echo $n; ?></td>
      <td><?php echo $rp['TipPermiso']; ?></td>
      <td><?php echo date('d/m/Y h:i A', strtotime($rp['FechaIni'])); ?></td>
      <td><?php echo date('d/m/Y h:i A', strtotime($rp['FechaFin'])); ?></td>
      <td><?php echo nomempleado($cone,$rp['Aprobador']); ?></td>
      <td><?php echo $rp['Estado']==1 ? "<span class='label label-success'>Activo</span>" : "<span class='label label-danger'>Cancelado</span>"; ?></td>
      
      <td>
        <div class="btn-group">
          <button class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-cog"></i>&nbsp;
            <span class="caret"></span>
            <span class="sr-only">Desplegar menú</span>
          </button>
          <ul class="dropdown-menu pull-right" role="menu">
            <?php if(accesoadm($cone,$_SESSION['identi'],2)){ ?>
            <li><a href="#" onclick="ediper(<?php echo $rp['idPermiso'].", ".$perp; ?>)" data-toggle="modal" data-target="#m_epermiso"><i class="fa fa-pencil"></i> Editar</a></li>
            <li><a href="#" onclick="estper(<?php echo $rp['idPermiso']; ?>)" data-toggle="modal" data-target="#m_estpermiso"><i class="fa fa-toggle-on"></i> <?php echo $rp['Estado']==1 ? "Cancelar" : "Activar"; ?></a></li>
            <?php } ?>
            <li><a href="#" onclick="detper(<?php echo $rp['idPermiso']; ?>)" data-toggle="modal" data-target="#m_dpermiso"><i class="fa fa-file-text"></i> Detalle</a></li>
          </ul>
        </div>
      </td>
    </tr>
<?php
        }
?>
  </tbody>
</table>
<?php
      }else{
        echo mensajewa("No se encontraron permisos.");
      }
      mysqli_free_result($cp);
  }else{
    echo mensajeda("Error: No se enviaron los datos.");
  }
}else{
  echo accrestringidoa();
}
                  ?>