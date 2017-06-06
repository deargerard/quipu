<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],4)){

	if(isset($_POST['clab']) && !empty($_POST['clab']) && isset($_POST['mes']) && !empty($_POST['mes'])){
		$clab=iseguro($cone,$_POST['clab']);
		$mes=iseguro($cone,$_POST['mes']);
		$vcancm=iseguro($cone,$_POST['vcancm']);
		$vc=$vcancm=="c" ? "" : "li.Estado=1 AND";
		$cclab=$clab=="t" ? "" : "idCondicionLab=$clab AND";
		$dat=false;
		$c=mysqli_query($cone,"SELECT * FROM condicionlab WHERE $cclab Estado=1 ORDER BY Tipo ASC;");
		if(mysqli_num_rows($c)>0){
?>
			<div class="row">
				<div class="col-md-12">
					<h4 class="text-aqua text-center"><strong><i class="fa fa-calendar"></i> <?php echo $mes; ?></strong></h4>
				</div>
			</div>
<?php
			while($r=mysqli_fetch_assoc($c)){
				$icl=$r['idCondicionLab'];
				$c1=mysqli_query($cone,"SELECT ec.idEmpleado, c.Denominacion, cc.CondicionCar, tl.MotivoLic, tl.TipoLic, li.FechaIni, li.FechaFin, d.Numero, d.Ano, d.Siglas, li.Estado FROM licencia li INNER JOIN aprlicencia al ON li.idLicencia=al.idLicencia INNER JOIN doc d ON al.idDoc=d.idDoc INNER JOIN tipolic tl ON li.idTipoLic=tl.idTipoLic INNER JOIN empleadocargo ec ON li.idEmpleadoCargo=ec.idEmpleadoCargo INNER JOIN cargo c ON ec.idCargo=c.idCargo INNER JOIN condicioncar cc ON ec.idCondicionCar=cc.idCondicionCar WHERE $vc ec.idCondicionLab=$icl AND DATE_FORMAT(FechaIni,'%m/%Y')='$mes' ORDER BY FechaIni ASC;");
				if (mysqli_num_rows($c1)>0) {
					$dat=true;
?>
					<table class="table table-bordered table-hover">
						<thead>
							<tr class="text-blue">
								<th colspan="9"><i class="fa fa-suitcase"></i> <?php echo $r['Tipo']; ?></th>
							</tr>
							<tr>
								<th>#</th>
								<th>PERSONAL</th>
								<th>CARGO</th>
								<th>TIPO LICENCIA</th>
								<th>DESDE</th>
								<th>HASTA</th>
								<th># DÍAS</th>
								<th># DOC</th>
								<th>ESTADO</th>
							</tr>
						</thead>
						<tbody>

<?php
					$num=0;
					$nd=0;
					while ($r1=mysqli_fetch_assoc($c1)) {
						$num++;
				        $f1=$r1['FechaFin'];
				        $f2=$r1['FechaIni'];
				        $f1=date_create($f1);
				        $f2=date_create($f2);
				        $tie=date_diff($f1, $f2);
				        $dias=$tie->format('%a')+1;
				        if($r1['Estado']==1){
				        	$nd=$nd+$dias;
				        }
						$con=$r1['CondicionCar']="NINGUNO" ? "" : " (".substr($r1['CondicionCar'],0,1).")";
?>
							<tr>
								<td><?php echo $num; ?></td>
								<td><?php echo nomempleado($cone,$r1['idEmpleado']); ?></td>
								<td><?php echo $r1['Denominacion'].$con; ?></td>
								<td><?php echo $r1['MotivoLic']." <br>(".$r1['TipoLic'].")"; ?></td>
								<td><?php echo fnormal($r1['FechaIni']); ?></td>
								<td><?php echo fnormal($r1['FechaFin']); ?></td>
								<td><?php echo $dias; ?></td>
								<td><?php echo $r1['Numero']."-".$r1['Ano']."-".$r1['Siglas']; ?></td>
								<td><?php echo $r1['Estado']==0 ? "<span class='label label-danger'>Cancelada</span>" : "<span class='label label-success'>Activa</span>"; ?></td>
							</tr>
<?php						
					}
?>
							<tr class="text-olive">
								<td colspan="9">Total <strong class="text-green"><?php echo $nd; ?></strong> día(s)</td>
							</tr>
						</tbody>
					</table>
<?php
				}
				mysqli_free_result($c1);
			}
		}
		if(!$dat){
			echo mensajewa("No se encontraron resultados.");
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