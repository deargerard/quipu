<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],13)){
if(isset($_POST['fini']) && isset($_POST['ffin'])){
	$numdoc=iseguro($cone,$_POST['numdoc']);
	$fini=fmysql(iseguro($cone,$_POST['fini']));
	$ffin=fmysql(iseguro($cone,$_POST['ffin']));
	$co=false;
	if(!empty($numdoc)){
		$w="WHERE idDoc=$numdoc";
		$co=true;
	}elseif(!empty($fini) && !empty($ffin)){
		$w="WHERE FechaDoc BETWEEN '$fini' AND '$ffin'";
		$co=true;
	}

	if($co){
		$cc=mysqli_query($cone,"SELECT idDoc, FechaDoc, Numero, Ano, Siglas, Descripcion, Legajo, TipoDoc FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc $w;");
		if(mysqli_num_rows($cc)>0){
?>
		<table class="table table-bordered table-hover" id="dtdocumento">
			<thead>
				<tr>
					<th>FECHA</th>
					<th>TIPO</th>
					<th>DOCUMENTO</th>
					<th>LEGAJO</th>
					<th>DESCRIPCIÓN</th>
<?php
				if(accesoadm($cone,$_SESSION['identi'],13)){
?>
					<th>ACCIÓN</th>
<?php
				}
?>
				</tr>
			</thead>
			<tbody>
			
		
<?php
			while ($rc=mysqli_fetch_assoc($cc)) {
?>
			<tr>
				<td><span class="hide"><?php echo $rc['FechaDoc']; ?></span><?php echo fnormal($rc['FechaDoc']); ?></td>
				<td><?php echo $rc['TipoDoc']; ?></td>
				<td><?php echo $rc['Numero']."-".$rc['Ano']."-".$rc['Siglas']; ?></td>
				<td><?php echo $rc['Legajo']; ?></td>
				<td><?php echo strlen($rc['Descripcion'])<120 ? $rc['Descripcion'] : substr(utf8_decode($rc['Descripcion'],0,120))."..."; ?></td>
<?php
				if(accesoadm($cone,$_SESSION['identi'],13)){
?>
				<td>

	              <div class="btn-group">
	                <button class="btn btn-warning btn-xs dropdown-toggle" data-toggle="dropdown">
	                  <i class="fa fa-cog"></i>&nbsp;
	                  <span class="caret"></span>
	                  <span class="sr-only">Desplegar menú</span>
	                </button>
	                <ul class="dropdown-menu pull-right" role="menu">


	                  <li><a href="#" data-toggle="modal" data-target="#m_edidocu" onclick="edidocu(<?php echo $rc['idDoc']; ?>)">Editar</a></li>

	                </ul>
	              </div>
				</td>
<?php
				}
?>
			</tr>
<?php
			}
?>
			</tbody>
		</table>
		<script>
			$('#dtdocumento').DataTable();
		</script>
<?php
		}else{
			echo mensajewa("Error: No se enviaron datos válidos.");
		}
		mysqli_free_result($cc);
		mysqli_close($cone);
	}else{
		echo mensajewa("Error: Debe seleccionar un número o un rango de fechas.");
	}

}else{
	echo mensajewa("Error: No se enviaron todos los campos.");
}
}else{
  echo accrestringidoa();
}
?>