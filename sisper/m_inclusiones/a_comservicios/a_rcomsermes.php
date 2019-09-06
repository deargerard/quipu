<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],15)){
	$mesini=iseguro($cone, $_POST["mesini"]);
	$mesfin=iseguro($cone, $_POST["mesfin"]);
	$estcs=$_POST["estcs"];

	if(isset($mesini) && !empty($mesini) && isset($mesfin) && !empty($mesfin) && isset($estcs) && !empty($estcs)){

		$mesini=fmysql("01/".$mesini);
		$mesfin=fmysql("01/".$mesfin);
		$mesfin=strtotime('+ 1 month',strtotime ($mesfin) );
		$mesfin=date('Y-m-j', $mesfin);
		$mesfin=strtotime('- 1 day',strtotime ($mesfin) );
		$mesfin=date('Y-m-j', $mesfin);

		$wecs="(";

		for ($k=0; $k < count($estcs); $k++) {
			$wecs.= $k==(count($estcs)-1) ? " cs.Estado=$estcs[$k])" : "cs.Estado=$estcs[$k] OR ";
		}

			$c="SELECT e.idEmpleado, e.NumeroDoc, cs.FechaIni, cs.FechaFin, concat(d.Numero,'-',d.Ano,'-',d.Siglas) AS Resolucion, cs.Descripcion, cs.Estado, cs.origen, cs.destino from comservicios cs INNER JOIN empleado e ON e.idEmpleado=cs.idEmpleado INNER JOIN doc d ON cs.idDoc=d.idDoc where (FechaIni BETWEEN '$mesini' AND '$mesfin') AND $wecs";
			//echo $c." -- ".$mesini." -- ".$mesfin;
			$ccs=mysqli_query($cone,$c);
			if (mysqli_num_rows($ccs)>0) {
		?>
		<hr>
		<table id="dtcomsermes" class="table table-bordered table-hover"> <!--Tabla que Lista las comisiones-->
					  <thead>
							<tr>
								<!-- <th style="font-size:12px;">DNI</th> -->
								<th style="font-size:12px;">EMPLEADO</th>
								<th style="font-size:12px;">CARGO</th>
								<th style="font-size:12px;">ORIGEN</th>
								<th style="font-size:12px;">DESTINO</th>
			          			<th style="font-size:12px;">INICIA</th>
								<th style="font-size:12px;">TERMINA</th>
								<th style="font-size:12px;">RESOLUCIÓN</th>
			          			<th style="font-size:12px;">ESTADO</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$est="";
							$cap="";
							while($rcs=mysqli_fetch_assoc($ccs)){

								if ($rcs['Estado']==1) {
									$est="success";
									$cap="Activa";
								}elseif ($rcs['Estado']==2){
									$est="danger";
									$cap="Cancelada";
								}
										?>
								<tr style="font-size:12px;"> <!--Fila de comisiones-->
									<!-- <td><?php //echo $rcs['NumeroDoc']?></td> --> <!--columna DNI-->
									<td><?php echo nomempleado($cone, $rcs['idEmpleado'])?></td> <!--columna APELLIDOS Y NOMBRES-->
									<td style="font-size:12px;"><?php echo cargoe($cone, $rcs['idEmpleado'])?></td> <!--columna CARGO-->
									<td><?php echo $rcs['origen']?></td> <!--columna DESCRIPCIÓN-->
									<td><?php echo $rcs['destino']?></td> <!--columna DESCRIPCIÓN-->
									<td><?php echo date('d/m/Y H:i', strtotime($rcs['FechaIni']))?></td> <!--columna INICIO-->
									<td><?php echo date('d/m/Y H:i', strtotime($rcs['FechaFin']))?></td> <!--columna FIN-->
									<td><a href="#" title="<?php echo $rcs['Descripcion']?>"><?php echo $rcs['Resolucion']?></a></td> <!--columna NÚMERO DE RESOLUCIÓN-->
									<td><span class='label label-<?php echo $est?>'><?php echo $cap?></span></td> <!--columna ESTADO-->
				        </tr>
								<?php
									}
								 ?>
						</tbody>
			</table>
			<script>
			$('#dtcomsermes').DataTable({
				"order": [[4,"desc"]]
			});
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
