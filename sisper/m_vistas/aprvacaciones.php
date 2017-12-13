<?php
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  if(accesoadm($cone,$_SESSION['identi'],14)){
    $hoy = date("Y");
    $anos= $hoy + 1;
    $pv = trim($hoy." - ".$anos);
    $cpev=mysqli_query($cone,"SELECT * FROM periodovacacional WHERE PeriodoVacacional='$pv'");
    if ($rpev=mysqli_fetch_assoc($cpev)) {
      $pervac=$rpev['idPeriodoVacacional'];
    }
?>
<!-- Cabecera -->
<section class="content-header">
  <h1>
  Vacaciones
  </h1>
  <ol class="breadcrumb">
    <li><a href="dboard.php"><i class="fa fa-home"></i> Inicio</a></li>
    <li>Vacaciones</li>
    <li class="active">Aprobación</li>
  </ol>
</section>
<!-- /.Cabecera -->
<!-- Sección de Busqueda -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
       <!-- Default box -->
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Aprobación</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Minimizar">
                <i class="fa fa-minus"></i></button>
            </div>
          </div>
          <div class="box-body">
            <!--div resultados-->
            <div class="row">
              <div class="col-md-12" id="r_aprova">


                <?php
                $c="SELECT sl.idSistemaLab, e.NumeroDoc, e.idEmpleado, ca.Denominacion as cargo, d.Denominacion, cl.Tipo, ec.FechaVac, pva.idPeriodoVacacional, pva.PeriodoVacacional, pv.FechaIni, pv.FechaFin, pv.Estado, pv.Condicion FROM provacaciones pv INNER JOIN empleadocargo ec ON pv.idEmpleadoCargo=ec.idEmpleadoCargo INNER JOIN empleado e ON ec.idEmpleado=e.idEmpleado INNER JOIN condicionlab cl ON ec.idCondicionLab=cl.idCondicionLab INNER JOIN cargo ca ON ec.idCargo=ca.idCargo INNER JOIN cardependencia cd ON ec.idEmpleadoCargo=cd.idEmpleadoCargo INNER JOIN dependencia d ON cd.idDependencia=d.idDependencia INNER JOIN periodovacacional pva ON pv.idPeriodoVacacional=pva.idPeriodoVacacional INNER JOIN sistemalab sl ON ca.idSistemaLab=sl.idSistemaLab WHERE pv.idPeriodoVacacional=$pervac AND cd.Estado=1 AND pv.Estado=7 ORDER BY e.ApellidoPat, e.ApellidoMat, e.Nombres, pv.FechaIni ASC;";
          			//echo $c;
          			$cpv=mysqli_query($cone,$c);
          			if (mysqli_num_rows($cpv)>0) {
          		?>

          		<button type="button" id="b_aprovac" name="boton" class="btn bg-aqua" data-toggle="modal" data-target="#maprobar" onclick="aprovacf();">Aprobar Vacaciones</button>

          		<hr>
          		<table id="dtvare" class="table table-bordered table-hover"> <!--Tabla que Lista las vacaciones-->
          					  <thead>
          							<tr>
          								<th style="font-size:12px;">DNI</th>
          								<th style="font-size:12px;">EMPLEADO</th>
          								<th style="font-size:12px;">CARGO</th>
          								<th style="font-size:12px;">DEPENDENCIA</th>
          								<th style="font-size:12px;">FECH. VAC</th>
          								<th style="font-size:12px;">DIAS</th>
          			          <th style="font-size:12px;">INICIA</th>
          								<th style="font-size:12px;">TERMINA</th>
          			          <th style="font-size:12px;">ESTADO</th>

          							</tr>
          						</thead>
          				<tbody>
          					<?php
          						$est="";
          						$cap="";
          						//$tot=0;
          							while($rpc=mysqli_fetch_assoc($cpv)){
          								if ($rpc['Estado']=='6') {
          									$est="default";
          									$cap="Solicitada";
          								}elseif($rpc['Estado']=='7') {
          									$est="purple";
          									$cap="Aceptada";
          								}
          								$dt=intervalo ($rpc['FechaFin'], $rpc['FechaIni']);
          								//$tot=$tot+1;
          					?>
          						<tr> <!--Fila de vacaciones-->
          							<td style="font-size:11px;"><?php echo $rpc['NumeroDoc']?></td> <!--columna CÓDIGO-->
          							<td style="font-size:11px;"><?php echo nomempleado($cone, $rpc['idEmpleado'])?></td> <!--columna APELLIDOS Y NOMBRES-->
          							<td style="font-size:11px;"><?php echo $rpc['cargo']?></td> <!--columna CARGO-->
          							<td style="font-size:11px;"><?php echo $rpc['Denominacion']?></td> <!--columna DEPENDENCIA-->
          							<td style="font-size:11px;"><?php echo fnormal($rpc['FechaVac'])?></td> <!--columna ALTA-->
          							<td style="font-size:12px;"><?php echo $dt ?></td> <!--columna CAMTIDAD DE DIAS-->
          							<td style="font-size:12px;"><?php echo "<span class='hidden'>".$rpc['FechaIni']."</span> ".fnormal($rpc['FechaIni'])?></td> <!--columna INICIO-->
          							<td style="font-size:12px;"><?php echo fnormal($rpc['FechaFin'])?></td> <!--columna FIN-->
          							<td style="font-size:11px;"><span class='label label-<?php echo $est?>'><?php echo $cap?></span></td> <!--columna ESTADO-->

          						</tr>
          						<?php
          							}
          						 ?>
          				</tbody>
          			</table>
          			<div class="modal fade" id="maprobar" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Aprobar Programacion Vacaciones</h4>
                      </div>
                      <div class="modal-body" id="r_aprovac">

                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="b_gaprovac">Guardar</button>
                      </div>
                    </div>
                  </div>
                </div>
          			<!--Modal nuevo documento-->
          	    <div class="modal fade" id="m_nuedocu" role="dialog" aria-labelledby="myModalLabel">
          	      <form id="f_nuedocu" action="" class="form-horizontal">
          	      <div class="modal-dialog modal-sm" role="document">
          	        <div class="modal-content">
          	          <div class="modal-header">
          	            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          	            <h4 class="modal-title" id="myModalLabel">Nuevo Documento</h4>
          	          </div>
          	          <div class="modal-body" id="r_nuedocu">

          	          </div>
          	          <div class="modal-footer">
          	            <button type="submit" class="btn bg-teal" id="b_gnuedocu">Guardar</button>
          	            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          	          </div>
          	        </div>
          	      </div>
          	      </form>
          	    </div>
              <!--Fin Modal nuevo documento-->

          		<?php

          	}else {
          			echo mensajewa("No existen vacaciones pendientes de aprobar");
          		}
          		mysqli_close($cone);
                 ?>
              </div>
            </div>
            <!--fin div resultados-->
          </div>
          <!-- /.box-body -->
          <div class="box-footer">

          </div>
          <!-- /.box-footer-->
        </div>
        <!-- /.box -->
    </div>
  </div>

  </section>
  <!-- /.Sección de Busqueda -->


  <?php
  }else{
  echo accrestringidop();
  }
  }else{
  header('Location: ../index.php');
  }
  ?>
