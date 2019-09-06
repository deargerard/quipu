<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],15)){
	$per=iseguro($cone,$_POST["per"]);
	$estcs=$_POST["estcs"];

	if(isset($per) && !empty($per) && isset($estcs) && isset($estcs)){

		$west="(";

		for ($i=0; $i < count($estcs); $i++) {
			$west.= $i==(count($estcs)-1) ? " cs.Estado=$estcs[$i])" : "cs.Estado=$estcs[$i] OR ";
			}

		$q="SELECT cs.idComServicios, concat(d.Numero,'-',d.Ano,'-',d.Siglas) AS Resolucion, d.FechaDoc, cs.FechaIni, cs.FechaFin, cs.Estado, cs.Vehiculo, cs.origen, cs.destino, cs.Descripcion FROM comservicios cs INNER JOIN doc d ON cs.idDoc=d.idDoc WHERE cs.idEmpleado=$per AND $west ORDER BY cs.FechaIni DESC;";
		//echo $q;
		$ccs=mysqli_query($cone,$q);

		if (mysqli_num_rows($ccs)>0) {
		 ?>
		 <hr>
		<table id="dtcomsertra" class="table table-bordered table-hover"> <!--Tabla que Lista las comisiones-->
			  <thead>
					<tr>
						<th style="font-size:12px;">#</th>
						<th style="font-size:12px;">ORIGEN</th>
						<th style="font-size:12px;">DESTINO</th>
						<th style="font-size:12px;">INICIA</th>
		        		<th style="font-size:12px;">TERMINA</th>
						<th style="font-size:12px;">NÚMERO DE RESOLUCIÓN</th>
						<th style="font-size:12px;">FECHA RES.</th>
		        		<th style="font-size:12px;">ESTADO</th>
					</tr>
				</thead>
		<tbody>
			<?php
			$est="";
			$cap="";
			$n=0;
			while($rcs=mysqli_fetch_assoc($ccs)){
				$n++;
				if ($rcs['Estado']==1) {
					$est="success";
					$cap="Activa";
				}elseif ($rcs['Estado']==2){
					$est="danger";
					$cap="Cancelada";
				}
						?>
				<tr> <!--Fila de comisiones-->
					<td><?php echo $n; ?></td> <!--columna DESCRIPCIÓN-->
					<td><?php echo $rcs['origen']; ?></td> <!--columna DESCRIPCIÓN-->
					<td><?php echo $rcs['destino']; ?></td> <!--columna DESCRIPCIÓN-->
					<td><?php echo date('d/m/Y H:i', strtotime($rcs['FechaIni'])); ?></td> <!--columna INICIO-->
					<td><?php echo date('d/m/Y H:i', strtotime($rcs['FechaFin'])); ?></td> <!--columna FIN-->
					<td><a href="#" title="<?php echo $rcs['Descripcion']; ?>"><?php echo $rcs['Resolucion']; ?></a></td> <!--columna NÚMERO DE RESOLUCIÓN-->
					<td><?php echo fnormal($rcs['FechaDoc']); ?></td> <!--columna FECHA DOCUMENTO-->
					<!-- <td><?php //echo $dt ?></td> columna CAMTIDAD DE DIAS-->
					<td><span class='label label-<?php echo $est?>'><?php echo $cap?></span></td> <!--columna ESTADO-->
        </tr>
				<?php
					}
				 ?>
		</tbody>

	</table>
	<script>
	$('#dtcomsertra').DataTable();
	</script>
<?php
	}else {
		echo mensajewa("No se encontraron resultados");
	}
		mysqli_close($cone);

	}else{
		echo mensajeda("Error: Debe seleccionar al menos un valor en cada campo");
	}

}else{
  echo accrestringidoa();
}
?>
