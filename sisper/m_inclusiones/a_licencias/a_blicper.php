<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],4)){

if(isset($_POST['licper']) && !empty($_POST['licper']) && isset($_POST['ano']) && !empty($_POST['ano']) && isset($_POST['est'])){
	$licper=iseguro($cone,$_POST['licper']);
	$ano=iseguro($cone,$_POST['ano']);
	$est=$_POST['est'];

	$wca="(";
	for ($j=0; $j < count($est); $j++) {
		$wca.=$j==(count($est)-1) ? " li.Estado=$est[$j])" : "li.Estado=$est[$j] OR ";
	}

	$ciec=mysqli_query($cone,"SELECT idEmpleadoCargo FROM empleadocargo WHERE idEmpleado=$licper AND idEstadoCar=1;");
	if($riec=mysqli_fetch_assoc($ciec)){
		$iec=$riec['idEmpleadoCargo'];
	}
?>
<div class="row">
	<div class="col-md-2">
<?php  
	if(accesoadm($cone,$_SESSION['identi'],4)){
?>
		<button class="btn btn-info btn-block" id="b_nuelic" data-toggle="modal" data-target="#m_nuelic" onclick="nuelic(<?php echo $iec.", ".$ano; ?>)">Nueva</button>
<?php  
	}
?>
	</div>
	<div class="col-md-10">
		<h4 class="text-aqua"><strong><i class="fa fa-user"></i> <?php echo nomempleado($cone,$licper); ?></strong> | <small><i class="fa fa-black-tie"></i> <?php echo cargoe($cone,$licper); ?></small></h4>
	</div>
</div>
<br>
<?php

$cc=mysqli_query($cone,"SELECT idEmpleadoCargo, Denominacion, Tipo, idEstadoCar, CondicionCar FROM empleadocargo ec INNER JOIN cargo c ON ec.idCargo=c.idCargo INNER JOIN condicionlab cl ON ec.idCondicionLab=cl.idCondicionLab INNER JOIN condicioncar cc ON ec.idCondicionCar=cc.idCondicionCar WHERE ec.idEmpleado=$licper ORDER BY idEmpleadoCargo DESC;");
if(mysqli_num_rows($cc)>0){
	$dat=false;
	$dit=0;
	$ditt=0;
	$lt=0;
	$ltt=0;
	$litt=0;
	$con=0;
	while ($rc=mysqli_fetch_assoc($cc)) {
		$idec=$rc['idEmpleadoCargo'];
		$cond=$rc['CondicionCar']=="NINGUNO" ? "" : " (".substr($rc['CondicionCar'], 0, 1).")";
			$c=mysqli_query($cone,"SELECT li.idLicencia, li.idTipoLic, TipoLic, MotivoLic, FechaIni, FechaFin, Numero, Ano, Siglas, li.Estado FROM licencia li INNER JOIN aprlicencia al ON li.idLicencia=al.idLicencia INNER JOIN doc do ON al.idDoc=do.idDoc INNER JOIN tipdoclicencia tdl ON li.idTipDocLicencia=tdl.idTipDocLicencia INNER JOIN tipolic tl ON li.idTipoLic=tl.idTipoLic INNER JOIN espmedica em ON li.idEspMedica=em.idEspMedica INNER JOIN empleadocargo ec ON li.idEmpleadoCargo=ec.idEmpleadoCargo WHERE li.idEmpleadoCargo=$idec AND $wca AND DATE_FORMAT(FechaIni,'%Y')='$ano' ORDER BY FechaIni DESC;");
			
			if(mysqli_num_rows($c)>0){
				$dat=true;
				$con++;
		?>
			<table class="table table-hover table-bordered">
				<thead>
					<tr class="text-blue">
						<th colspan="5"><i class="fa fa-black-tie"></i> <?php echo $rc['Denominacion'].$cond; ?></th>
						<th colspan="3"><i class="fa fa-suitcase"></i> <?php echo substr($rc['Tipo'],0,9); ?></th>
					</tr>
					<tr>
						<th>#</th>
						<th>TIPO LIC.</th>
						<th>DESDE</th>
						<th>HASTA</th>
						<th># DÍAS</th>
						<th># DOC.</th>
						<th>ESTADO</th>
						<th>ACCIÓN</th>
					</tr>
				</thead>
				<tbody>
		<?php
				$nd=0;
				$ndl=0;
				$nl=0;
				$lc=0;
				$lit=0;
				while ($r=mysqli_fetch_assoc($c)) {
					$nl++;
			        $f1=$r['FechaFin'];
			        $f2=$r['FechaIni'];
			        $f1=date_create($f1);
			        $f2=date_create($f2);
			        $tie=date_diff($f1, $f2);
			        $dias=$tie->format('%a')+1;
			        if($r['idTipoLic']==1 AND $r['Estado']==1){
			        	$nd=$nd+$dias;
			        	$lit++;
			        }
			        if($r['Estado']==1){
			        	$ndl=$ndl+$dias;
			        }else{
			        	$lc++;
			        }
				
		?>
					<tr>
						<td><?php echo $nl; ?></td>
						<td class="text-purple"><?php echo "<strong>".$r['MotivoLic']."</strong> (".$r['TipoLic'].")"; ?></td>
						<td><?php echo fnormal($r['FechaIni']); ?></td>
						<td><?php echo fnormal($r['FechaFin']); ?></td>
						<td><?php echo $dias; ?> día(s)</td>
						<td><?php echo $r['Numero']."-".$r['Ano']."-".$r['Siglas']; ?></td>
						<td><?php echo $r['Estado']==0 ? "<span class='label label-danger'>Cancelada</span>" : "<span class='label label-success'>Activa</span>"; ?></td>

						<td>

		                  <div class="btn-group">
		                    <button class="btn btn-warning btn-xs dropdown-toggle" data-toggle="dropdown">
		                      <i class="fa fa-cog"></i>&nbsp;
		                      <span class="caret"></span>
		                      <span class="sr-only">Desplegar menú</span>
		                    </button>
		                    <ul class="dropdown-menu pull-right" role="menu">
		                      <li><a href="#" data-toggle="modal" data-target="#m_detlic" onclick="detlic(<?php echo $r['idLicencia'] ?>)">Detalle</a></li>
		<?php
							if(accesoadm($cone,$_SESSION['identi'],4) && $rc['idEstadoCar']==1){
								if($r['Estado']==1){
		?>
		                      <li><a href="#" data-toggle="modal" data-target="#m_edilic" onclick="edilic(<?php echo $r['idLicencia'].",".$ano ?>)">Editar</a></li>
		<?php
								}
		?>
		                      <li class="divider"></li>
		                      <li><a href="#" data-toggle="modal" data-target="#m_estlic" onclick="estlic(<?php echo $r['idLicencia'] ?>)"><?php echo $r['Estado']==1 ? "Cancelar" : "Activar"; ?></a></li>
		<?php
							}
		?>
		                    </ul>
		                  </div>

							
						</td>
					</tr>
		<?php
				}
				$lt=$nl-$lc;
		?>
				<tr>
					<td colspan="4" class="text-olive"><strong><?php echo $lt; ?> licencia(s)</strong>, haciendo un total de <strong><?php echo $ndl; ?> día(s)</strong></td>
					<td colspan="4" class="<?php echo $nd>=20 ? 'text-maroon' : 'text-olive'; ?>"><strong><?php echo $lit; ?> licencia(s)</strong> por incapacidad temporal, haciendo un total de <strong><?php echo $nd; ?> día(s)</strong></td>
				</tr>
				</tbody>
			</table>
		<?php
			}else{
				$lt=0;
				$ndl=0;
				$nd=0;
				$lit=0;
			}
			$dit=$dit+$nd;
			$ditt=$ditt+$ndl;
			$ltt=$ltt+$lt;
			$litt=$litt+$lit;
	}
	if(!$dat){
		echo mensajewa("Para el $ano, según el criterio de búsqueda, no presenta licencias.");
	}
	if ($con>1) {
	?>
			<table class="table table-bordered table-hover">
				<tr>
					<td class="text-olive" width="48%"><strong><?php echo $ltt; ?> licencia(s)</strong>, haciendo un total de <strong><?php echo $ditt; ?> día(s)</strong>, correspondientes al <?php echo $ano; ?></td>
					<td class="<?php echo $dit>=20 ? 'text-maroon' : 'text-olive'; ?>" width="52%"><strong><?php echo $litt; ?> licencia(s)</strong> por incapacidad temporal, haciendo un total de <strong><?php echo $dit; ?> día(s)</strong>, correspondientes al <?php echo $ano; ?></td>
				</tr>
			</table>
	<?php
	}
}else{
	echo mensajewa("Error: No se enviaron datos válidos.");
}
	mysqli_free_result($c);
	mysqli_close($cone);
}else{
	echo mensajewa("Error: Todos los campos son obligatorios.");
}
}else{
  echo accrestringidoa();
}
?>