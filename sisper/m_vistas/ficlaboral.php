<?php
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  $idper=$_SESSION['identi'];
  $ccar=mysqli_query($cone,"SELECT ec.idEstadoCar as est, ec.idEmpleadoCargo, ec.FechaVac, ec.FechaAsu, cl.Tipo, ma.ModAcceso, eca.EstadoCar, c.Denominacion AS cargo, d.Denominacion FROM empleadocargo ec INNER JOIN condicionlab cl ON ec.idCondicionLab=cl.idCondicionLab INNER JOIN modacceso ma ON ec.idModAcceso=ma.idModAcceso INNER JOIN estadocar eca ON ec.idEstadoCar=eca.idEstadoCar INNER JOIN cargo c ON ec.idCargo=c.idCargo INNER JOIN cardependencia cd ON ec.idEmpleadoCargo=cd.idEmpleadoCargo INNER JOIN dependencia d ON cd.idDependencia=d.idDependencia WHERE ec.idEmpleado=$idper and cd.oficial=1 ORDER BY ec.idEmpleadoCargo DESC");
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

                  while($rcar=mysqli_fetch_assoc($ccar)){
                    $car=$rcar['idEmpleadoCargo'];
                    $q="SELECT v.idProVacaciones, pv.PeriodoVacacional, concat(d.Numero,'-',d.Ano,'-',d.Siglas) AS Resolucion, d.FechaDoc, v.FechaIni, v.FechaFin, v.Estado, v.Condicion, av.idAprVacaciones FROM provacaciones as v INNER JOIN periodovacacional AS pv ON v.idPeriodoVacacional = pv.idPeriodoVacacional INNER JOIN aprvacaciones as av ON v.idProVacaciones= av.idProVacaciones INNER JOIN doc AS d ON av.idDoc=d.idDoc INNER JOIN empleadocargo AS ec ON v.idEmpleadoCargo=ec.idEmpleadoCargo WHERE idEmpleado = $idper AND ec.idEmpleadoCargo=$car";

                    $cvac=mysqli_query($cone,$q);
                  		if (mysqli_num_rows($cvac)>0) {
                  		 ?>
                       <div class="">
                          <hr>
                          <?php
                       		if ($rcar['est']==1) {
                       		?>
                       			<h4 ><small class="text-blue text-center"><i class="fa fa-black-tie"></i> <?php echo $rcar['cargo']; ?></small></h4>
                       		<?php
                       		}else{
                       		 ?>
                       		 <h4 ><small class="text-center"><i class="fa fa-black-tie"></i> <?php echo $rcar['cargo']."  (INACTIVO)"; ?></small></h4>
                       		<?php
                       		}
                       		?>
                          
                       </div>
                  		<table id="dtreva" class="table table-bordered table-hover"> <!--Tabla que Lista las vacaciones-->
                  			  <thead>
                  					<tr>
                  						<th>PERÍODO</th>
                  						<th>NÚMERO DE RESOLUCIÓN</th>
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
                  	<script>
                  	$('#dtreva').DataTable({
                  		"order": [[0,"asc"]]
                  	});
                  	</script>
                  <?php
                  	 }else {
                  		echo mensajewa("No tiene vacaciones programadas como ". $rcar['cargo'].".");
                  	 }
               }
                 mysqli_close($cone);
              ?>
                </div>
              </div>
              <!--fin div resultados-->
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="tab_2">

              <!--Formulario-->
              <form action="" id="f_rvare" class="form-inline">
                <div class="form-group">
                  <label for="bbb" class="sr-only">Período</label>
                  <select data-actions-box="true" name="pervac[]" class="form-control selectpicker" multiple="multiple" multiple data-selected-text-format="count" title="PERÍODO">
                    <?php
                      $cpv=mysqli_query($cone,"SELECT idPeriodoVacacional, PeriodoVacacional FROM periodovacacional WHERE Estado=1 ORDER BY PeriodoVacacional DESC");
                      while($rpv=mysqli_fetch_assoc($cpv)){
                    ?>
                    <option value="<?php echo $rpv['idPeriodoVacacional']; ?>"><?php echo $rpv['PeriodoVacacional']; ?></option>
                    <?php
                      }
                      mysqli_free_result($cpv);
                    ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="aaa" class="sr-only">Sistema</label>
                    <select name="sislab[]" data-actions-box="true" class="form-control selectpicker" multiple="multiple" multiple data-selected-text-format="count" title="SISTEMA">
                      <?php
                        $csl=mysqli_query($cone,"SELECT idSistemaLab, SistemaLab FROM sistemalab WHERE idSistemaLab!=4 AND  idSistemaLab!=5 ORDER BY idSistemaLab ASC");
                        while($rsl=mysqli_fetch_assoc($csl)){
                      ?>
                      <option value="<?php echo $rsl['idSistemaLab']; ?>"><?php echo $rsl['SistemaLab']; ?></option>
                      <?php
                        }
                        mysqli_free_result($csl);
                      ?>
                    </select>
                </div>

                <div class="form-group">
                  <label for="aaa" class="sr-only">Regimen</label>
                  <select data-actions-box="true" name="reglab[]" class="form-control selectpicker" multiple="multiple" multiple data-selected-text-format="count" title="RÉGIMEN">
                    <?php
                      $crl=mysqli_query($cone,"SELECT idCondicionLab, Tipo FROM condicionlab WHERE Estado=1 AND idCondicionLab!=6 AND idCondicionLab!=7 ORDER BY Tipo ASC");
                      while($rrl=mysqli_fetch_assoc($crl)){
                    ?>
                    <option value="<?php echo $rrl['idCondicionLab']; ?>"><?php echo $rrl['Tipo']; ?></option>
                    <?php
                      }
                      mysqli_free_result($crl);
                    ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="bbb" class="sr-only">Estado</label>
                  <select data-actions-box="true" name="estvac[]" class="form-control selectpicker" multiple="multiple" multiple data-selected-text-format="count" title="ESTADO">
                    <option value="4">PLANIFICADAS</option>
                    <option value="0">PENDIENTES</option>
                    <option value="3">EJECUTANDOSE</option>
                    <option value="1">EJECUTADAS</option>
                    <option value="2">CANCELADAS</option>
                    <option value="5">SUSPENDIDAS</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="bbb" class="sr-only">Condición</label>
                  <select name="convac[]" class="form-control selectpicker" multiple="multiple" multiple data-selected-text-format="count" title="CONDICIÓN">
                    <option value="1">PROGRAMADAS</option>
                    <option value="0">REPROGRAMADAS</option>
                  </select>
                </div>
                <button type="submit" id="b_bvare" class="btn btn-default">Buscar</button>
              </form>
              <!--Fin Formulario-->
              <!--div resultados-->
              <div class="row">
                <div class="col-md-12" id="r_vare">

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
