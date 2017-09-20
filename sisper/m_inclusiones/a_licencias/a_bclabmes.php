<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],4)){

	if(isset($_POST['clab']) && !empty($_POST['clab']) && isset($_POST['mes']) && !empty($_POST['mes']) && isset($_POST['est'])){
		$clab=$_POST['clab'];
		$mes=iseguro($cone,$_POST['mes']);
		$est=$_POST['est'];

		$vc=$vcancm=="c" ? "" : "li.Estado=1 AND";
		$cclab=$clab=="t" ? "" : "idCondicionLab=$clab AND";

		$wca="(";
		for ($j=0; $j < count($est); $j++) {
			$wca.=$j==(count($est)-1) ? " li.Estado=$est[$j])" : "li.Estado=$est[$j] OR ";
		}

		$wcl="(";
		for ($j=0; $j < count($clab); $j++) {
			$wcl.=$j==(count($clab)-1) ? " idCondicionLab=$clab[$j])" : "idCondicionLab=$clab[$j] OR ";
		}

		$dat=false;
		$c=mysqli_query($cone,"SELECT * FROM condicionlab WHERE $wcl ORDER BY Tipo ASC;");
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
				$c1=mysqli_query($cone,"SELECT ec.idEmpleado, c.Denominacion, cc.CondicionCar, tl.MotivoLic, tl.TipoLic, li.idLicencia, li.FechaIni, li.FechaFin, d.Numero, d.Ano, d.Siglas, li.Estado FROM licencia li INNER JOIN aprlicencia al ON li.idLicencia=al.idLicencia INNER JOIN doc d ON al.idDoc=d.idDoc INNER JOIN tipolic tl ON li.idTipoLic=tl.idTipoLic INNER JOIN empleadocargo ec ON li.idEmpleadoCargo=ec.idEmpleadoCargo INNER JOIN cargo c ON ec.idCargo=c.idCargo INNER JOIN condicioncar cc ON ec.idCondicionCar=cc.idCondicionCar WHERE $wca AND ec.idCondicionLab=$icl AND DATE_FORMAT(FechaIni,'%m/%Y')='$mes' ORDER BY FechaIni ASC;");
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
					$lc=0;
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
				        }else{
				        	$lc++;
				        }
						$con=$r1['CondicionCar']="NINGUNO" ? "" : " (".substr($r1['CondicionCar'],0,1).")";
?>
							<tr>
								<td><?php echo $num; ?></td>
								<td><a href="#" data-toggle="modal" data-target="#m_detlic" onclick="detlic(<?php echo $r1['idLicencia'] ?>)"><?php echo nomempleado($cone,$r1['idEmpleado']); ?></a></td>
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
								<td colspan="9" class="text-olive"><strong><?php echo ($num-$lc); ?> licencia(s)</strong>, haciendo un total de <strong><?php echo $nd; ?> día(s)</strong></td>
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
		echo mensajewa("Error: Todos los campos son obligatorios.");
	}
}else{
  echo accrestringidoa();
}
?>