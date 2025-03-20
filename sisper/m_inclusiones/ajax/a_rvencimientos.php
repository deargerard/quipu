<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],1)){
  $fec=date('Y-m-j');
  $sfec=strtotime('+2 months', strtotime($fec));
  $sfec=date('Y-m-j',$sfec);
  $afec=strtotime('-1 months', strtotime($fec));
  $afec=date('Y-m-j',$afec);
?>
<hr>
<h4 class="text-maroon"><strong>VENCIMIENTOS DE CONTRATOS</strong></h4>
<?php
$c=mysqli_query($cone,"SELECT idEmpleado, FechaVen FROM empleadocargo WHERE idEstadoCar=1 AND (FechaVen>='$afec' AND FechaVen<='$sfec') ORDER BY FechaVen DESC;")
?>
  <table class="table table-bordered table-hover">
<?php
if(mysqli_num_rows($c)>0){
?>
  <tr>
    <th>#</th>
    <th>NOMBRE</th>
    <th>CARGO</th>
    <th>DEPENDENCIA</th>
    <th>F. VENCIMIENTO</th>
  </tr>
<?php
  $n=0;
  while ($r=mysqli_fetch_assoc($c)) {
    $n++;
?>
  <tr>
    <td><?php echo $n; ?></td>
    <td><?php echo nomempleado($cone,$r['idEmpleado']); ?></td>
    <td><?php echo cargoe($cone,$r['idEmpleado']); ?></td>
    <td><?php echo nomdependencia($cone,iddependenciae($cone,$r['idEmpleado'])); ?></td>
    <td class="text-orange"><strong><?php echo fnormal($r['FechaVen']); ?></strong></td>
  </tr>
<?php
  }
}else{
?>
  <tr>
    <td colspan="5">No existen vencimientos</td>
  </tr>
<?php
}
?>
  </table>

<h4 class="text-maroon"><strong>VENCIMIENTO DE DESPLAZAMIENTOS</strong></h4>
<?php
$c=mysqli_query($cone,"SELECT ec.idEmpleado, cd.Vence FROM cardependencia cd INNER JOIN empleadocargo ec ON cd.idEmpleadoCargo=ec.idEmpleadoCargo WHERE idEstadoCar=1 AND cd.estado=1 AND (cd.Vence>='$afec' AND cd.Vence<='$sfec') ORDER BY FecFin DESC;")
?>
  <table class="table table-bordered table-hover">
<?php
if(mysqli_num_rows($c)>0){
?>
  <tr>
    <th>#</th>
    <th>NOMBRE</th>
    <th>CARGO</th>
    <th>DEPENDENCIA</th>
    <th>F. VENCIMIENTO</th>
  </tr>
<?php
  $n=0;
  while ($r=mysqli_fetch_assoc($c)) {
    $n++;
?>
  <tr>
    <td><?php echo $n; ?></td>
    <td><?php echo nomempleado($cone,$r['idEmpleado']); ?></td>
    <td><?php echo cargoe($cone,$r['idEmpleado']); ?></td>
    <td><?php echo nomdependencia($cone,iddependenciae($cone,$r['idEmpleado'])); ?></td>
    <td class="text-maroon"><?php echo fnormal($r['Vence']); ?></td>
  </tr>
<?php
  }
}else{
?>
  <tr>
    <td colspan="5">No existen vencimientos</td>
  </tr>
<?php
}
?>
  </table>

<h4 class="text-maroon"><strong>VENCIMIENTO DE RESERVAS</strong></h4>
<?php
$c=mysqli_query($cone,"SELECT ec.idEmpleado, esc.Vence FROM estadocargo esc INNER JOIN empleadocargo ec ON esc.idEmpleadoCargo=ec.idEmpleadoCargo WHERE ec.idEstadoCar=3 AND esc.Estado=1 AND (esc.Vence>='$afec' AND esc.Vence<='$sfec') ORDER BY FechaFin DESC;")
?>
  <table class="table table-bordered table-hover">
<?php
if(mysqli_num_rows($c)>0){
?>
  <tr>
    <th>#</th>
    <th>NOMBRE</th>
    <th>CARGO</th>
    <th>DEPENDENCIA</th>
    <th>F. VENCIMIENTO</th>
  </tr>
<?php
  $n=0;
  while ($r=mysqli_fetch_assoc($c)) {
    $n++;
?>
  <tr>
    <td><?php echo $n; ?></td>
    <td><?php echo nomempleado($cone,$r['idEmpleado']); ?></td>
    <td><?php echo cargoe($cone,$r['idEmpleado']); ?></td>
    <td><?php echo nomdependencia($cone,iddependenciae($cone,$r['idEmpleado'])); ?></td>
    <td class="text-maroon"><?php echo fnormal($r['Vence']); ?></td>
  </tr>
<?php
  }
}else{
?>
  <tr>
    <td colspan="5">No existen vencimientos</td>
  </tr>
<?php
}
?>
  </table>
<?php
}else{
  echo accrestringidoa();
}
?>