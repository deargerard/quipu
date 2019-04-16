<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],1)){

?>
<hr>
<h4 class="text-maroon"><strong><i class="fa fa-wheelchair"></i> Personal con discapacidad</strong></h4>
<?php
$c=mysqli_query($cone, "SELECT e.idEmpleado, d.diamedico, d.otipayubio, d.cerdis, d.feccerdis, d.conadis, d.fecconadis, td.tipod, tab.tipoa, ts.tipos, tlp.tipol, gl.gradol, ol.origenl FROM empleado e INNER JOIN discapacidad d ON e.idEmpleado=d.idEmpleado INNER JOIN tipdiscapacidad td ON d.idtipdiscapacidad=td.idtipdiscapacidad INNER JOIN tipayubio tab ON d.idtipayubio=tab.idtipayubio INNER JOIN tipseg ts ON d.idtipseg=ts.idtipseg INNER JOIN tiplimper tlp ON d.idtiplimper=tlp.idtiplimper INNER JOIN gralim gl ON d.idgralim=gl.idgralim INNER JOIN orilim ol ON d.idorilim=ol.idorilim ORDER BY e.ApellidoPat, e.ApellidoMat, e.Nombres ASC;");
?>
  <table class="table table-bordered table-hover">
<?php
if(mysqli_num_rows($c)>0){
?>
  <thead>
  <tr>
    <th>#</th>
    <th>NOMBRE</th>
    <th>CARGO</th>
    <th>DEPENDENCIA</th>
    <th>TIPO DISCAPACIDAD</th>
    <th>LIMITACIÓN PERPANENTE</th>
    <th>GRADO LIMITACIÓN</th>
  </tr>
  </thead>
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
    <td><?php echo $r['tipod']; ?></td>
    <td><?php echo $r['tipol']; ?></td>
    <td><?php echo $r['gradol']; ?></td>
  </tr>
<?php
  }
}else{
?>
  <tr>
    <td colspan="5">No existen personal con discapacidad</td>
  </tr>
<?php
}
mysqli_free_result($c);
?>
  </table>

<?php
}else{
  echo accrestringidoa();
}
?>