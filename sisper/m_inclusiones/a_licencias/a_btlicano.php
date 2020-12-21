<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],4)){

if(isset($_POST['tlice']) && !empty($_POST['tlice']) && isset($_POST['anio']) && !empty($_POST['anio']) && isset($_POST['est'])){
	$tlic=$_POST['tlice'];
	$anio=iseguro($cone,$_POST['anio']);
	$est=$_POST['est'];

	$wca="(";
	for ($j=0; $j < count($est); $j++) {
		$wca.=$j==(count($est)-1) ? " li.Estado=$est[$j])" : "li.Estado=$est[$j] OR ";
	}

	$wtl="(";
	for ($l=0; $l < count($tlic); $l++) {
		$wtl.=$l==(count($tlic)-1) ? " idTipoLic=$tlic[$l])" : "idTipoLic=$tlic[$l] OR ";
	}
	$dat=false;
	$tdi=0;
	$cli=mysqli_query($cone,"SELECT * FROM tipolic WHERE $wtl AND Estado=1 ORDER BY MotivoLic ASC");
	if(mysqli_num_rows($cli)>0){
	?>
	<div class="row">
		<div class="col-md-12">
			<h4 class="text-aqua text-center"><strong><i class="fa fa-calendar"></i> <?php echo $anio; ?></strong></h4>
		</div>
	</div>
			<?php
		$ntl=0;
		$ct=0;
		while ($rli=mysqli_fetch_assoc($cli)) {
			$ct++;
			$idli=$rli['idTipoLic'];
				$c=mysqli_query($cone,"SELECT ec.idEmpleado, c.Denominacion, cc.CondicionCar, tl.TipoLic, tl.MotivoLic, li.idLicencia, FechaIni, FechaFin, Numero, Ano, Siglas, li.Estado, cl.Tipo FROM licencia li INNER JOIN aprlicencia al ON li.idLicencia=al.idLicencia INNER JOIN doc do ON al.idDoc=do.idDoc INNER JOIN tipolic tl ON li.idTipoLic=tl.idTipoLic INNER JOIN empleadocargo ec ON li.idEmpleadoCargo=ec.idEmpleadoCargo INNER JOIN cargo c ON c.idCargo=ec.idCargo INNER JOIN condicioncar cc ON cc.idCondicionCar=ec.idCondicionCar INNER JOIN condicionlab cl ON cl.idCondicionLab=ec.idCondicionLab WHERE $wca AND li.idTipoLic=$idli AND DATE_FORMAT(FechaIni,'%Y')='$anio' ORDER BY FechaIni ASC;");
				if(mysqli_num_rows($c)>0){
					$dat=true;
			?>
				<table class="table table-hover table-bordered" id="tablatla<?php echo $ct; ?>">
					<thead>
						<tr class="text-blue">
							<th colspan="9"><i class="fa fa-stethoscope"></i> <?php echo $rli['MotivoLic']." (".$rli['TipoLic'].")"; ?> <button class="btn bg-orange btn-xs pull-right" id="exta<?php echo $ct; ?>" title="Exportar a Excel"><i class="fa fa-file-excel-o"></i></button></th>
						</tr>
						<tr>
							<th>#</th>
							<th>PERSONAL</th>
							<th>CARGO</th>
							<th>COND. LAB.</th>
							<th>DESDE</th>
							<th>HASTA</th>
							<th># DÍAS</th>
							<th># DOC.</th>
							<th>ESTADO</th>
						</tr>
					</thead>
					<tbody>
			<?php
					$nd=0;
					$co=0;
					$lc=0;
					$nl=0;
					while ($r=mysqli_fetch_assoc($c)) {
						$co++;
				        $f1=$r['FechaFin'];
				        $f2=$r['FechaIni'];
				        $f1=date_create($f1);
				        $f2=date_create($f2);
				        $tie=date_diff($f1, $f2);
				        $dias=$tie->format('%a')+1;
				        if($r['Estado']==1){
				        	$nd=$nd+$dias;
				        }else{
				        	$lc++;
				        }
				        if ($r['CondicionCar']=="NINGUNO") {
				        	$condi="";
				        }else{
				        	$condi=" (".substr($r['CondicionCar'],0,1).")";
				        }
					
			?>
						<tr>
							<td><?php echo $co; ?></td>
							<td><a href="#" data-toggle="modal" data-target="#m_detlic" onclick="detlic(<?php echo $r['idLicencia'] ?>)"><?php echo nomempleado($cone,$r['idEmpleado']); ?></a></td>
							<td><?php echo $r['Denominacion'].$condi; ?></td>
							<td><?php echo substr($r['Tipo'],0,9); ?></td>
							<td><?php echo date('d-m-Y', strtotime($r['FechaIni'])); ?></td>
							<td><?php echo $r['FechaFin']; ?></td>
							<td><?php echo $dias; ?></td>
							<td><?php echo $r['Numero']."-".$r['Ano']."-".$r['Siglas']; ?></td>
							<td><?php echo $r['Estado']==0 ? "<span class='label label-danger'>Cancelada</span>" : "<span class='label label-success'>Activa</span>"; ?></td>
						</tr>
			<?php
					}
					$tdi=$tdi+$nd;
					$nl=$co-$lc;
			?>
						<tr>
							<td class="text-olive" colspan="9"><strong><?php echo $nl; ?> licencia(s)</strong>, haciendo un total de <strong> <?php echo $nd; ?> día(s)</strong></td>
						</tr>
					</tbody>
				</table>
				<script>
				        var wbtla<?php echo $ct; ?> = XLSX.utils.table_to_book(document.getElementById('tablatla<?php echo $ct; ?>'), {sheet:"Quipu"});
				        var wbouttla<?php echo $ct; ?> = XLSX.write(wbtla<?php echo $ct; ?>, {bookType:'xlsx', bookSST:true, type: 'binary'});
				        function s2ab(s) {
				                        var buf = new ArrayBuffer(s.length);
				                        var view = new Uint8Array(buf);
				                        for (var i=0; i<s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
				                        return buf;
				        }
				        $("#exta<?php echo $ct; ?>").click(function(){
				        	saveAs(new Blob([s2ab(wbouttla<?php echo $ct; ?>)],{type:"application/octet-stream"}), 'licencias.xlsx');
				        });
				</script>
			<?php
				}else{
					$nl=0;
				}
			mysqli_free_result($c);
			$ntl=$ntl+$nl;
		}

		mysqli_free_result($cli);
		if(!$dat){
			echo mensajewa("No se hallaron resultados.");
		}else{
?>
				<table class="table table-bordered table-hover">
					<tr>
						<td class="text-maroon"><strong><?php echo $ntl; ?> licencia(s)</strong>, haciendo un total de <strong><?php echo $tdi; ?> día(s)</strong>, para todas las licencias seleccionadas correspondientes al <?php echo $anio; ?></td>
					</tr>
				</table>
<?php
		}
		mysqli_close($cone);
	}else{
		echo mensajewa("Error: No se recibieron datos válidos");
	}
}else{
	echo mensajewa("Error: Tipo de licencia y año son campos obligatorios.");
}
}else{
  echo accrestringidoa();
}
?>