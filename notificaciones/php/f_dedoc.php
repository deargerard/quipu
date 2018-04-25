<?php
session_start();
include 'cone.php';
include 'func.php';
include '../const.php';
$idusu=$_SESSION['idusu'];
if(acceso($cone,$idusu,3)){
	if(isset($_POST['idd']) && !empty($_POST['idd'])){
		$idd=iseguro($cone, $_POST['idd']);
		$cd=mysqli_query($cone,"SELECT d.*, td.Tipo, g.Numero as num, g.Fecha FROM doc d INNER JOIN guia g ON d.idGuia=g.idGuia INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc WHERE idDoc=$idd;");
		if($rd=mysqli_fetch_assoc($cd)){
?>
    <table class="table table-bordered">
      <tr>
        <th>GUÍA</th>
        <td><?php echo $rd['num']."-".date('Y', strtotime($rd['Fecha'])); ?></td>
      </tr>
      <tr>
        <th>TIPO</th>
        <td><?php echo $rd['Tipo']; ?></td>
      </tr>
      <tr>
        <th>NÚMERO</th>
        <td><?php echo $rd['Numero']; ?></td>
      </tr>
      <tr>
        <th>ORIGEN</th>
        <td><?php echo $rd['Origen']; ?></td>
      </tr>
      <tr>
        <th>REMITENTE</th>
        <td><?php echo $rd['Remitente']; ?></td>
      </tr>
      <tr>
        <th>DESTINO</th>
        <td><?php echo $rd['Destino']; ?></td>
      </tr>
      <tr>
        <th>DESTINATARIO</th>
        <td><?php echo $rd['Destinatario']; ?></td>
      </tr>
      <tr>        
        <th>INGRESADO POR</th>
        <td><?php echo nomusuario($cone, $rd['idUsuario']); ?></td>
      </tr>
      <tr>        
        <th>DEVOLUCIÓN CARGO</th>
        <td><?php echo $rd['Cargo']==1 ? "Si" : "No"; ?></td>
      </tr>
    </table>
<?php
		}else{
			echo mensajewa("No envió datos válidos.");
		}
    mysqli_free_result($cd);
	}else{
		echo mensajewa("No envió datos.");
	}
}else{
	echo mensajewa("Acceso restingido.");
}
?>