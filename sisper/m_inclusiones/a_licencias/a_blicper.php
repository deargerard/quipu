<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],4)){

if(isset($_POST['licper']) && !empty($_POST['licper']) && isset($_POST['ano']) && !empty($_POST['ano'])){
	$licper=iseguro($cone,$_POST['licper']);
	$ano=iseguro($cone,$_POST['ano']);
	$vcan=iseguro($cone,$_POST['vcan']);
	$bcan=$vcan=="c" ? "" : "AND li.Estado=1";
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
	while ($rc=mysqli_fetch_assoc($cc)) {
		$idec=$rc['idEmpleadoCargo'];
		$cond=$rc['CondicionCar']=="NINGUNO" ? "" : " (".substr($rc['CondicionCar'], 0, 1).")";
			$c=mysqli_query($cone,"SELECT li.idLicencia, li.idTipoLic, TipoLic, MotivoLic, FechaIni, FechaFin, Numero, Ano, Siglas, li.Estado FROM licencia li INNER JOIN aprlicencia al ON li.idLicencia=al.idLicencia INNER JOIN doc do ON al.idDoc=do.idDoc INNER JOIN tipdoclicencia tdl ON li.idTipDocLicencia=tdl.idTipDocLicencia INNER JOIN tipolic tl ON li.idTipoLic=tl.idTipoLic INNER JOIN espmedica em ON li.idEspMedica=em.idEspMedica INNER JOIN empleadocargo ec ON li.idEmpleadoCargo=ec.idEmpleadoCargo WHERE li.idEmpleadoCargo=$idec $bcan AND DATE_FORMAT(FechaIni,'%Y')='$ano' ORDER BY FechaIni DESC;");
			
			if(mysqli_num_rows($c)>0){
				$dat=true;
		?>
			<table class="table table-hover table-bordered">
				<thead>
					<tr class="text-blue">
						<th colspan="5"><i class="fa fa-black-tie"></i> <?php echo $rc['Denominacion'].$cond; ?></th>
						<th colspan="2"><i class="fa fa-suitcase"></i> <?php echo substr($rc['Tipo'],0,9); ?></th>
					</tr>
					<tr>
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
				while ($r=mysqli_fetch_assoc($c)) {
			        $f1=$r['FechaFin'];
			        $f2=$r['FechaIni'];
			        $f1=date_create($f1);
			        $f2=date_create($f2);
			        $tie=date_diff($f1, $f2);
			        $dias=$tie->format('%a')+1;
			        if($r['idTipoLic']==1 AND $r['Estado']==1){
			        	$nd=$nd+$dias;
			        }
				
		?>
					<tr>
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
		?>
				<tr>
					<td colspan="7" class="<?php echo $nd>=20 ? 'text-maroon' : 'text-olive'; ?>"><strong class="text-green"><?php echo $nd; ?></strong> día(s) de licencias por incapacidad temporal en total</td>
				</tr>
				</tbody>
			</table>
		<?php
			}
	}
	if(!$dat){
		echo mensajewa("Para el $ano, no presenta licencias.");
	}
}else{
	echo mensajewa("Error: No se enviaron datos válidos.");
}
	mysqli_free_result($c);
	mysqli_close($cone);
}else{
	echo mensajewa("Error: Personal y año, son campos obligatorios.");
}
}else{
  echo accrestringidoa();
}
?>