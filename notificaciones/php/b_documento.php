<?php
session_start();
include 'cone.php';
include 'func.php';
include '../const.php';
$idusu=$_SESSION['idusu'];
if(isset($_SESSION['nusu']) && !empty($_SESSION['nusu']) && isset($_SESSION['idusu']) && !empty($_SESSION['idusu'])){
  if(isset($_POST['bdoc']) && !empty($_POST['bdoc'])){
		$bdoc=iseguro($cone,trim($_POST['bdoc']));
    $cd=mysqli_query($cone, "SELECT * FROM documento WHERE idDocumento=$bdoc;");
    if($rd=mysqli_fetch_assoc($cd)){
?>
  <table class="table table-bordered table-hover">
    <tr>
      <th>N° Doc.</th>
      <td>D-<?php echo $rd['idDocumento']; ?></td>
      <th>Documento</th>
      <td><?php echo $rd['Documento']; ?></td>
    </tr>
    <tr>
      <th>Responsable</th>
      <td><small><?php echo nomusuario($cone, $rd['idResponsable']); ?></small></td>
      <th>Asignada por</th>
      <td><small><?php echo nomusuario($cone, $rd['idAsignador']); ?></small></td>
    </tr>
    <tr>
      <th>Origen</th>
      <td><small><?php echo $rd['Origen']; ?></small></td>
      <th>Destino</th>
      <td><small><?php echo $rd['Destino']; ?></small></td>
    </tr>
    <tr>
      <th>F. Recepción</th>
      <td><?php echo fnormal($rd['FecRecepcion']); ?></td>
      <th>F. Registro</th>
      <td><?php echo fnormal($rd['FecRegistro']); ?></td>
    </tr>
    <tr>
      <th>F. Not./Dev.</th>
      <td><?php echo fnormal($rd['FecNotificacion']); ?></td>
      <th>F. Reporte</th>
      <td><?php echo fnormal($rd['FecDevolucion']); ?></td>
    </tr>
    <tr>
      <th>Estado</th>
      <td><?php echo estadodoc($rd['Estado']); ?></td>
      <th>Fue Reabierto</th>
      <td><small><?php echo $rd['Reabierto']==1 ? "Si" : "No"; ?></small></td>
    </tr>
    <tr>
      <th>Modo Notificación</th>
      <td colspan="3"><small><?php echo modnotificacion($rd['ModNotificacion']); ?></small></td>
    </tr>
    <tr>
      <th>Observaciones</th>
      <td colspan="3"><small><?php echo $rd['Observaciones']; ?></small></td>
    </tr>
  </table>
<?php
    }else{
      echo mensajewa("No se encontraron resultados");
    }
	}else{
		echo mensajewa("Ingrese un número de documento");
	}
}else{
	echo mensajewa("Acceso restaringido");
}