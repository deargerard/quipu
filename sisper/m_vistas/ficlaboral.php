<?php
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  $idper=$_SESSION['identi'];
  $sql="SELECT ec.idEstadoCar as est, ec.idEmpleadoCargo, ec.FechaVac, ec.FechaAsu, cl.Tipo, ma.ModAcceso, eca.EstadoCar, c.Denominacion AS cargo, d.Denominacion, cc.CondicionCar FROM empleadocargo ec INNER JOIN condicionlab cl ON ec.idCondicionLab=cl.idCondicionLab INNER JOIN modacceso ma ON ec.idModAcceso=ma.idModAcceso INNER JOIN estadocar eca ON ec.idEstadoCar=eca.idEstadoCar INNER JOIN cargo c ON ec.idCargo=c.idCargo INNER JOIN cardependencia cd ON ec.idEmpleadoCargo=cd.idEmpleadoCargo INNER JOIN dependencia d ON cd.idDependencia=d.idDependencia INNER JOIN condicioncar cc ON ec.idCondicionCar=cc.idCondicionCar WHERE ec.idEmpleado=$idper and cd.oficial=1 ORDER BY ec.idEmpleadoCargo DESC";
  $ccar=mysqli_query($cone,$sql);
?>
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Ficha Laboral
    </h1>
    <ol class="breadcrumb">
      <li><a href="dboard.php"><i class="fa fa-home"></i> Inicio</a></li>
      <li>Perfil</li>
      <li class="active">Ficha Laboral</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <!-- Custom Tabs -->
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab">Mis Vacaciones</a></li>
            <li><a href="#tab_2" data-toggle="tab">Mis Licencias</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
              <!--Formulario de encabezado-->
              <form action="" id="f_rreva" class="form-inline">
              <p><h4 class="text-blue"><strong><i class="fa fa-user"></i> <?php echo nomempleado($cone,$idper); ?> </strong></h4></p>
              </form>
              <!--Fin Formulario de encabezado-->
              <!--div resultados-->
              <div class="row">
                <div class="col-md-12" id="vac">
                  <?php
                    $n=0;
                  while($rcar=mysqli_fetch_assoc($ccar)){
                    $n++;
                    $car=$rcar['idEmpleadoCargo'];
                    $q="SELECT v.idProVacaciones, pv.PeriodoVacacional, concat(d.Numero,'-',d.Ano,'-',d.Siglas) AS Resolucion, d.FechaDoc, v.FechaIni, v.FechaFin, v.Estado, v.Condicion, av.idAprVacaciones FROM provacaciones as v INNER JOIN periodovacacional AS pv ON v.idPeriodoVacacional = pv.idPeriodoVacacional INNER JOIN aprvacaciones as av ON v.idProVacaciones= av.idProVacaciones INNER JOIN doc AS d ON av.idDoc=d.idDoc INNER JOIN empleadocargo AS ec ON v.idEmpleadoCargo=ec.idEmpleadoCargo WHERE idEmpleado = $idper AND ec.idEmpleadoCargo=$car";

                    $cvac=mysqli_query($cone,$q);
                  		if (mysqli_num_rows($cvac)>0) {
                  		 ?>
                       <div class="row">
                         <?php
                     		  $cond=$rcar['CondicionCar']=="NINGUNO" ? "" : " (".substr($rcar['CondicionCar'], 0, 1).")";
                           if ($rcar['est']==1) {
                             $col="text-blue";
                           }else{
                             $col="";
                           }
                         ?>
                       <div class="col-sm-5">
                       			<h4 ><small class="<?php echo $col ?> text-center" style="font-weight: bold"><i class="fa fa-black-tie"></i> <?php echo $rcar['cargo'].$cond." (".$rcar['EstadoCar'].")"  ?></small></h4>
                       </div>
                       <div class="col-sm-7">
                       			<h4 ><small class="<?php echo $col ?> text-center" style="font-weight: bold"><i class="fa fa-institution"></i> <?php echo $rcar['Denominacion']; ?></small></h4>
                       </div>

                     </div>
                  		<table class="table table-bordered table-hover" id="dtable<?php echo $n ?>" > <!--Tabla que Lista las vacaciones-->
                  			  <thead>
                  					<tr>
                  						<th>PERÍODO</th>
                  						<th>RESOLUCIÓN</th>
                  						<th>FECHA RES.</th>
                  						<th>PROGRAMACIÓN</th>
                  						<th>DÍAS</th>
                  						<th>INICIA</th>
                  	          <th>TERMINA</th>
                  	          <th>ESTADO</th>
                  					</tr>
                  				</thead>
                  		<tbody>
                  			<?php
                  			$tot=0;
                  					while($rvac=mysqli_fetch_assoc($cvac)){
                  						if ($rvac['Estado']=='0') {
                  							$est="info";
                  							$cap="Pendiente";
                  						}elseif($rvac['Estado']=='1') {
                  							$est="success";
                  							$cap="Ejecutado";
                  							//$eje= intervalo($rvac['FechaFin'], $rvac['FechaIni']) + $eje;
                  						}elseif ($rvac['Estado']=='2') {
                  							$est="danger";
                  							$cap="Cancelado";
                  						}elseif ($rvac['Estado']=='3') {
                  							$est="primary";
                  							$cap="Ejecutandose";
                  						}elseif ($rvac['Estado']=='5'){
                  							$est="default";
                  							$cap="Suspendida";
                  						}else {
                  							$est="warning";
                  							$cap="Planificada";
                  						}
                  						$con="";
                  						if($rvac['Condicion']=='1'){
                  							$con="PROGRAMADAS";
                  							}else {
                  										$con="REPROGRAMADAS";
                  										}
                  						$dt=intervalo ($rvac['FechaFin'], $rvac['FechaIni']);
                  						$tot=$tot+1;
                  						?>
                  				<tr> <!--Fila de vacaciones-->
                  					<td><?php echo $rvac['PeriodoVacacional']?></td> <!--columna PERÍODO-->
                  					<td><?php echo $rvac['Resolucion']?></td> <!--columna NÚMERO DE RESOLUCIÓN-->
                  					<td><?php echo fnormal($rvac['FechaDoc'])?></td> <!--columna FECHA DOCUMENTO-->
                  					<td><?php echo $con ?></td> <!--columna CONDICIÓN-->
                  					<td><?php echo $dt ?></td> <!--columna CAMTIDAD DE DIAS-->
                  					<td><?php echo "<span class='hidden'>".$rvac['FechaIni']."</span> ".fnormal($rvac['FechaIni'])?></td> <!--columna INICIO-->
                  					<td><?php echo fnormal($rvac['FechaFin'])?></td> <!--columna FIN-->
                  					<td><span class='label label-<?php echo $est?>'><?php echo $cap?></span></td> <!--columna ESTADO-->
                          </tr>
                  				<?php
                  					}
                  				 ?>
                  		</tbody>
                  	</table>
                  <?php
                  	 }else {
                  		echo mensajewa("No tiene vacaciones programadas como ". $rcar['cargo'].".");
                  	 }
               }
              ?>
                </div>
              </div>
              <!--fin div resultados-->
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="tab_2">
              <!--Formulario de encabezado-->
              <form action="" id="f_rreva" class="form-inline">
              <p><h4 class="text-blue"><strong><i class="fa fa-user"></i> <?php echo nomempleado($cone,$idper); ?> </strong></h4></p>
              </form>
              <!--Fin Formulario de encabezado-->
              <!--div resultados-->
              <div class="row">
                <div class="col-md-12" id="lic">
                <?php
              	$ano=date('Y');
              	$ccar=mysqli_query($cone,$sql);
                if(mysqli_num_rows($ccar)>0){
                	$dat=false;
                	$dit=0;
                	$ditt=0;
                	$lt=0;
                	$ltt=0;
                	$litt=0;
                	$con=0;
                	while ($rcar=mysqli_fetch_assoc($ccar)) {
                    $idec=$rcar['idEmpleadoCargo'];
                		$cond=$rcar['CondicionCar']=="NINGUNO" ? "" : " (".substr($rcar['CondicionCar'], 0, 1).")";
                			$c=mysqli_query($cone,"SELECT li.idLicencia, li.idTipoLic, TipoLic, MotivoLic, FechaIni, FechaFin, Numero, Ano, Siglas, li.Estado FROM licencia li INNER JOIN aprlicencia al ON li.idLicencia=al.idLicencia INNER JOIN doc do ON al.idDoc=do.idDoc INNER JOIN tipdoclicencia tdl ON li.idTipDocLicencia=tdl.idTipDocLicencia INNER JOIN tipolic tl ON li.idTipoLic=tl.idTipoLic INNER JOIN espmedica em ON li.idEspMedica=em.idEspMedica INNER JOIN empleadocargo ec ON li.idEmpleadoCargo=ec.idEmpleadoCargo WHERE li.idEmpleadoCargo=$idec AND DATE_FORMAT(FechaIni,'%Y')=DATE_FORMAT(now(),'%Y') ORDER BY FechaIni DESC");

                			if(mysqli_num_rows($c)>0){
                				$dat=true;
                				$con++;
                	?>
                			<table class="table table-hover table-bordered">
                				<thead>
                          <?php
                            if ($rcar['est']==1) {
                              $col="text-blue";
                            }else{
                              $col="";
                            }
                          ?>
                					<tr class="<?php echo $col ?>">
                            <div class="col-sm-5">
                            			<h4 ><small class="<?php echo $col ?> text-center" style="font-weight: bold"><i class="fa fa-black-tie"></i> <?php echo $rcar['cargo'].$cond." (".$rcar['EstadoCar'].")"   ?></small></h4>
                            </div>
                            <div class="col-sm-7">
                            			<h4><small class="<?php echo $col ?> text-center" style="font-weight: bold"><i class="fa fa-institution"></i> <?php echo $rcar['Denominacion']; ?></small></h4>
                            </div>
                					</tr>
                					<tr>
                						<th>#</th>
                						<th>TIPO LIC.</th>
                						<th>DESDE</th>
                						<th>HASTA</th>
                						<th># DÍAS</th>
                						<th>RESOLUCIÓN</th>
                						<th>ESTADO</th>
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
                  ?>
                </div>
              </div>
              <!--fin div resultados-->
            </div>
            <!-- /.tab-pane -->
          </div>
          <!-- /.tab-content -->
        </div>
        <!-- nav-tabs-custom -->
      </div> <!-- /.col-md-12 -->
    </div> <!-- /.row -->
  </section>

  <!-- /.content -->
  <?php

}else{
  header('Location: ../index.php');
}
?>
