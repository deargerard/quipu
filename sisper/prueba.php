<?php
include ("m_inclusiones/php/conexion_sp.php");
include ("m_inclusiones/php/funciones.php");
?>
<table>
	<tr>
		<td>Dependencia</td>
		<td>Local</td>
	</tr>
	<?php 
	$c=mysqli_query($cone,"SELECT Denominacion, Direccion FROM dependencia as de INNER JOIN local as lo ON de.idLocal=lo.idLocal ORDER BY Denominacion ASC");
	?>
	
	<?php
	while($r=mysqli_fetch_assoc($c)){
	?>
	<tr>
		<td><?php echo $r['Denominacion']; ?></td>
		<td><?php echo $r['Direccion']; ?></td>
	</tr>
	<?php
	}
	?>
	
</table>