<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],2)){
  if(isset($_POST['idp']) && !empty($_POST['idp'])){
    $idp=iseguro($cone,$_POST['idp']);
    $cp=mysqli_query($cone, "SELECT p.*, TipPermiso FROM permiso p INNER JOIN tippermiso tp ON p.idTipPermiso=tp.idTipPermiso WHERE idPermiso=$idp;");
    if($rp=mysqli_fetch_assoc($cp)){
?>

      <table class="table table-bordered table-hover">
        <tr>
          <th>Personal</th>
          <td colspan="3"><span class="text-blue"><?php echo nomempleado($cone, $rp['idEmpleado']); ?></span></td>
        </tr>
        <tr>
          <th>Motivo</th>
          <td colspan="3"><span class="text-aqua"><?php echo $rp['TipPermiso']; ?></span></td>
        </tr>
        <tr>
          <th>Inicia</th>
          <td><?php echo date("d/m/Y h:i A", strtotime($rp['FechaIni'])); ?></td>
          <th>Finaliza</th>
          <td><?php echo date("d/m/Y h:i A", strtotime($rp['FechaFin'])); ?></td>
        </tr>
        <tr>
          <th>Aprobador</th>
          <td><?php echo nomempleado($cone, $rp['Aprobador']); ?></td>
          <th>Estado</th>
          <td><?php echo $rp['Estado']==1 ? "<span class='label label-success'>Activo</span>" : "<span class='label label-danger'>Cancelado</span>"; ?></td>
        </tr>
        <tr>
          <th>Detalle</th>
          <td colspan="3"><?php echo $rp['Observacion']; ?></td>
        </tr>
        
      </table>

<?php
    }else{
      echo mensajewa("No envió datos válidos.");
    }
  }else{
    echo mensajewa("No envió datos.");
  }
}else{
  echo accrestringidoa();
}
?>
