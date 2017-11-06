<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(vacceso($cone,$_SESSION['identi'],$_SESSION['docide'],$_SESSION['nomusu'])){
    if(escoordinador($cone,$_SESSION['identi'])){
    	if(isset($_POST['idcoo']) && !empty($_POST['idcoo'])){
    		echo "<div id='titulo' class='text-orange'></div>";
    		$idcoo=iseguro($cone,$_POST['idcoo']);
			$qt=mysqli_query($cone,"SELECT ec.idEmpleadoCargo, ec.idEmpleado FROM dependencia d INNER JOIN cardependencia cd ON d.idDependencia=cd.idDependencia INNER JOIN empleadocargo ec ON cd.idEmpleadoCargo=ec.idEmpleadoCargo INNER JOIN empleado e ON ec.idEmpleado=e.idEmpleado INNER JOIN cargo ca ON ec.idCargo=ca.idCargo INNER JOIN sistemalab sl ON ca.idSistemaLab=sl.idSistemaLab WHERE cd.Estado=1 AND d.idCoordinacion=$idcoo AND ec.idEstadoCar=1 AND (d.Observacion!='e' OR sl.SistemaLab!='FISCAL') AND (ec.idCargo!=32 AND ec.idCargo!=34) ORDER BY e.ApellidoPat ASC, e.ApellidoMat ASC;");
			$b=true;
			if (mysqli_num_rows($qt)>0) {
				$u="";
				while($rt=mysqli_fetch_assoc($qt)){
					$idec=$rt['idEmpleadoCargo'];
					$qpv=mysqli_query($cone,"SELECT idProVacaciones, FechaIni, FechaFin FROM provacaciones WHERE idEmpleadoCargo=$idec AND Estado=6;");
					if (mysqli_num_rows($qpv)>0) {
						$c=0;
						while($rpv=mysqli_fetch_assoc($qpv)){
							$idpv=$rpv['idProVacaciones'];
							$d=intervalo($rpv['FechaFin'],$rpv['FechaIni']);
							$c=$c+$d;
							$u.="UPDATE provacaciones SET Estado=7 WHERE idProVacaciones=$idpv;";
						}
						if($c!=30){
							echo "<small class='text-primary'>- <strong>".nomempleado($cone,$rt['idEmpleado'])."</strong> tiene pendientes $c días por programar.</small><br>";
							$b=false;
						}
					}else{
						echo "<small class='text-primary'>- <strong>".nomempleado($cone,$rt['idEmpleado'])."</strong> no programó vacaciones.</small><br>";
						$b=false;
					}
				}
			}else{			
				echo mensajewa("Atención: Está coordinación no cuenta con trabajadores.");
			}
			if($b){
				$up=explode(";",$u);
				for ($i=0; $i < count($up); $i++) {
					if($up[$i]!=""){
						mysqli_query($cone,$up[$i]);
					}
				}
				echo "<div class='text-olive'><i class='fa fa-check-square'></i> Programación de vacaciones aceptada y enviada.</div>";
			}else{
?>
				<script>
					$('#titulo').html('<i class="fa fa-warning"></i> ADVERTENCIA: No se puede aceptar y enviar la programación, porque:');
				</script>
<?php
			}

		}else{
			echo mensajewa("Error: No envio datos.");
		}
	}else{
		echo mensajewa("Error: No sea pende, no es coordinador.");
	}
}else{
	echo mensajeda("Error: Acceso denegado.");
}
?>