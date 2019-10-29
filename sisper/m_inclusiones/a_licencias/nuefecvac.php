<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],4)){

	$d=5;
	$fec=date("2017-02-27");
	$nfec=strtotime('+5 day',strtotime($fec));
	echo date('Y-m-d',$nfec)."<br>";

	echo srdias("2017-02-27",5);

	$cec=mysqli_query($cone,"SELECT idEmpleadoCargo, idEmpleado FROM empleadocargo WHERE  (idEstadoCar=1 OR idEstadoCar=2);");
	if(mysqli_num_rows($cec)>0){
?>
	<table>
<?php
		while($rec=mysqli_fetch_assoc($cec)){
			$idec=$rec['idEmpleadoCargo'];
			$ide=$rec['idEmpleado'];
?>
		<tr>
			<td><?php echo nomempleado($cone,$ide); ?></td>
			<td><?php echo cargocu($cone,$idec); ?></td>
		</tr>
<?php
			$clsg=mysqli_query($cone, "SELECT TipoLic, MotivoLic, FechaIni, FechaFin FROM licencia l INNER JOIN tipolic tl ON l.idTipoLic=tl.idTipoLic WHERE idEmpleadoCargo=$idec AND l.Estado=1 AND (l.idTipoLic=12 OR l.idTipoLic=13);");
			if(mysqli_num_rows($clsg)>0){
				$nd=0;
				while($rlsg=mysqli_fetch_assoc($clsg)){
					$d=intervalo($rlsg['FechaFin'],$rlsg['FechaIni']);
					$nd=$nd+$d;
?>
		<tr>
			<td><?php echo $rlsg['MotivoLic']."(".$rlsg['TipoLic'].")"; ?></td>
			<td><?php echo $d; ?></td>
		</tr>
<?php
				}
		$cfi=mysqli_query($cone,"SELECT FechaAsu FROM empleadocargo WHERE idEmpleadoCargo=$idec;");
		if($rfi=mysqli_fetch_assoc($cfi)){
			$fv=srdias($rfi[FechaAsu],$nd);
			if(mysqli_query($cone,"UPDATE empleadocargo SET FechaVac='$fv' WHERE idEmpleadoCargo=$idec;")){
?>
		<tr>
			<td colspan="2">Actualizado</td>
		</tr>
<?php
			}else{
?>
		<tr>
			<td colspan="2">Error al actualizar</td>
		</tr>
<?php
			}
		}

?>
		<tr style="color: red;">
			<td>Total</td>
			<td><?php echo $nd; ?></td>
		</tr>
<?php
			}else{
?>
		<tr style="color: red;">
			<td>Total</td>
			<td>0</td>
		</tr>
<?php
			}
		}
?>
	</table>
<?php

	}else{
		echo mensajewa("No se encontraron ni cargos activos, ni reservados.");
	}

}
mysqli_close($cone);