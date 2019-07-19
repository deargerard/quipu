<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],13)){

	$numdoc=iseguro($cone,$_POST['numdoc']);
	$fini=fmysql(iseguro($cone,$_POST['fini']));
	$ffin=fmysql(iseguro($cone,$_POST['ffin']));
	$ndoc=iseguro($cone,$_POST['ndoc']);
	$adoc=iseguro($cone,$_POST['adoc']);
	$co=false;
	if(!empty($numdoc)){
		$w="WHERE idDoc=$numdoc";
		$co=true;
	}elseif(!empty($fini) && !empty($ffin)){
		$w="WHERE FechaDoc BETWEEN '$fini' AND '$ffin'";
		$co=true;
	}elseif(!empty($ndoc) && !empty($adoc)){
		$w="WHERE numdoc=$ndoc AND Ano='$adoc'";
		$co=true;
	}

	if($co){
		$cc=mysqli_query($cone,"SELECT idDoc, FechaDoc, Numero, Ano, Siglas, Descripcion, Legajo, TipoDoc, numdoc FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc $w;");
		if(mysqli_num_rows($cc)>0){
?>
		<table class="table table-bordered table-hover" id="dtdocumento">
			<thead>
				<tr>
					<th>FECHA</th>
					<th>N. DOC.</th>
					<th>TIPO</th>
					<th>DOCUMENTO</th>
					<th>LEGAJO</th>
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
				<td><?php echo is_null($rc['numdoc']) ? "SN" : ($rc['numdoc']."-".$rc['Ano']); ?></td>
				<td><?php echo $rc['TipoDoc']; ?></td>
				<td><a href="#" data-toggle="popover" data-placement="left" data-trigger="hover" title="Descripción" data-content="<?php echo $rc['Descripcion'] ?>"><?php echo $rc['Numero']."-".$rc['Ano']."-".$rc['Siglas']; ?></a></td>
				<td><?php echo $rc['Legajo']; ?></td>
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
	                  <li><a href="#" data-toggle="modal" data-target="#m_edidocu" onclick="edidocu(<?php echo $rc['idDoc']; ?>)"><i class="fa fa-edit text-yellow"></i> Editar</a></li>
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
			$('[data-toggle="popover"]').popover();
		</script>
<?php
		}else{
			echo mensajewa("No se encontraron resultados.");
		}
		mysqli_free_result($cc);
		mysqli_close($cone);
	}else{
		echo mensajewa("No ingreso datos para la busqueda.");
	}

}else{
  echo accrestringidoa();
}
?>