<?php
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  $idper=$_SESSION['identi'];
  $sql="SELECT ec.idEstadoCar as est, ec.idEmpleadoCargo, ec.FechaVac, ec.FechaAsu, cl.Tipo, ma.ModAcceso, eca.EstadoCar, c.Denominacion AS cargo, d.Denominacion, cc.CondicionCar FROM empleadocargo ec INNER JOIN condicionlab cl ON ec.idCondicionLab=cl.idCondicionLab INNER JOIN modacceso ma ON ec.idModAcceso=ma.idModAcceso INNER JOIN estadocar eca ON ec.idEstadoCar=eca.idEstadoCar INNER JOIN cargo c ON ec.idCargo=c.idCargo INNER JOIN cardependencia cd ON ec.idEmpleadoCargo=cd.idEmpleadoCargo INNER JOIN dependencia d ON cd.idDependencia=d.idDependencia INNER JOIN condicioncar cc ON ec.idCondicionCar=cc.idCondicionCar WHERE ec.idEmpleado=$idper and cd.oficial=1 ORDER BY ec.idEstadoCar ASC, ec.idEmpleadoCargo DESC";
  $ccar=mysqli_query($cone,$sql);
  $qec="SELECT idEmpleadoCargo, FechaVac, FechaAsu FROM empleadocargo WHERE idEmpleado=$idper and idEstadoCar=1";
  $cec=mysqli_query($cone,$qec);
  $hoy = date("Y");
  $anos= $hoy + 1;
  $pv = trim($hoy." - ".$anos);
  $cpev=mysqli_query($cone,"SELECT * FROM periodovacacional WHERE PeriodoVacacional='$pv'");

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
            <li class="active"><a href="#tab_1" data-toggle="tab"><i class="fa fa-barcode text-blue"></i> Mis Marcaciones</a></li>
            <li><a href="#tab_2" data-toggle="tab"><i class="fa fa-plane text-blue"></i> Mis Vacaciones</a></li>
            <li><a href="#tab_3" data-toggle="tab"><i class="fa fa-car text-blue"></i> Mis Comisiones de Servicio</a></li>
            <li><a href="#tab_4" data-toggle="tab"><i class="fa fa-user-md text-blue"></i> Mis Licencias</a></li>
          </ul>
          <div class="tab-content">
            
            <div class="tab-pane active" id="tab_1">
              <!--Encabezado-->
              <div class="row">
                <div class="col-sm-12">
                  <h4 class="text-blue" style="font-size: 22px; font-weight:600;"><i class="fa fa-user text-orange"></i> <b><?php echo nomempleado($cone,$idper); ?></b></h4>
                  <input type="hidden" id="idper" value="<?php echo $idper?>"> <!--envía id de personal-->
                </div>
              </div>
              <!--Fin Encabezado-->
              <!--div resultados-->
              <div class="row" id="repasi">
                <div class="col-md-12" id="repasi">
                <?php

                $cm=mysqli_query($cone,"SELECT * FROM marcacion WHERE idEmpleado=$idper ORDER BY Marcacion DESC LIMIT 240;");
                  if(mysqli_num_rows($cm)>0){

                  ?>
                  <div class="row">
                     <div class="col-sm-6">
                      <p style="font-size: 17px;" class="text-primary"><i class="fa fa-black-tie text-yellow"></i> <?php echo cargoe($cone, $idper);?></p>
                     </div>
                     <div class="col-sm-6">
                      <p style="font-size: 17px;" class="text-primary text-right"><i class="fa fa-institution text-yellow"></i> <?php echo dependenciae($cone, $idper);?></p>
                     </div>
                  </div>
                  <div class="table-responsive">
                  <table id="dtrepasi" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th width="30">#</th>
                        <th>DÍA</th>
                        <th>FECHA</th>
                        <th>MARCACIÓN</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                      $n=0;
                      while ($rm=mysqli_fetch_assoc($cm)){
                      $n++;
                    ?>
                      <tr>
                        <td><?php echo $n; ?></td>
                        <td><?php echo nombredia($rm['Marcacion']); ?></td>
                        <td class="text-orange"><span class="hidden"> <?php echo $rm['Marcacion'] ?></span> <?php echo date('d/m/Y', strtotime($rm['Marcacion'])); ?></td>
                        <td class="text-yellow"><?php echo date('h:i:s A', strtotime($rm['Marcacion'])); ?></td>
                      <?php
                      }
                      ?>
                    </tbody>
                  </table>
                  </div>
                  <?php
                  }else{
                    echo mensajewa("No se encontraron marcaciones.");
                  }
                    mysqli_free_result($cm);
                  ?>
                </div>
              </div>
              <!--fin div resultados-->
            </div>
            <!-- /.tab-pane 1 -->

            <div class="tab-pane " id="tab_2">
              <!--Encabezado-->
              <div class="row">
                <div class="col-sm-7">
                  <h4 class="text-blue" style="font-size: 22px; font-weight:600;"><b><i class="fa fa-user text-orange"></i> <?php echo nomempleado($cone,$idper); ?> </b></h4>
                </div>
                  <?php
                  if ($rec=mysqli_fetch_assoc($cec)) {
                    $idec=$rec['idEmpleadoCargo'];
                    if ($rpev=mysqli_fetch_assoc($cpev)) {
                      $pervac=$rpev['idPeriodoVacacional'];
                    }
                    //include("m_inclusiones/a_vacaciones/a_ofechas.php");
                  ?>
                  <div class="col-sm-5"> <!--Botón Programar vacaciones-->
                    <h4 class="text-maroon text-right"><i class="fa fa-info-circle text-orange"></i> Las vacaciones ahora se programan en <a href="https://sistemas2.mpfn.gob.pe/" target="_blank">Sistemas2</a></h4>
                  </div>
                  <?php
                  }
                 ?>
              </div>
              <!--Fin Encabezado-->

              <!--div resultados-->
              <div class="row" id="reva">
                <div class="col-md-12" id="vac">
                  <?php
                  $n=0;
                  $v=true;
                  while($rcar=mysqli_fetch_assoc($ccar)){
                    $n++;
                    $car=$rcar['idEmpleadoCargo'];
                    $q="SELECT v.idProVacaciones, pv.PeriodoVacacional, pv.idPeriodoVacacional, v.FechaIni, v.FechaFin, v.Estado, v.Condicion FROM provacaciones as v INNER JOIN periodovacacional AS pv ON v.idPeriodoVacacional = pv.idPeriodoVacacional INNER JOIN empleadocargo AS ec ON v.idEmpleadoCargo=ec.idEmpleadoCargo WHERE ec.idEmpleadoCargo=$car ORDER BY v.FechaIni DESC";
                    $cvac=mysqli_query($cone,$q);
                    $vis=false;

                    //echo $v."-";
                      if (mysqli_num_rows($cvac)>0){
                        ?>
                        <div class="row">
                          <?php
                          $cond=$rcar['CondicionCar']=="NINGUNO" ? "" : " (".substr($rcar['CondicionCar'], 0, 1).")";
                            if ($rcar['est']==1) {
                             $col="text-primary";
                             $vis= true;
                            }else{
                              $col="text-muted";
                            }
                         ?>
                           <div class="col-sm-6">
                             <p style="font-size: 17px;" class="<?php echo $col ?>"><i class="fa fa-black-tie text-yellow"></i> <?php echo $rcar['cargo'].$cond." (".$rcar['EstadoCar'].")"  ?></p>
                           </div>
                           <div class="col-sm-6">
                              <p style="font-size: 17px;" class="<?php echo $col ?> text-right"><i class="fa fa-institution text-yellow"></i> <?php echo $rcar['Denominacion']; ?></p>
                           </div>
                        </div>
                        <!--Fin div row-->
                        <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="dtable<?php echo $n ?>" > <!--Tabla que Lista las vacaciones-->
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>PERÍODO</th>
                              <th>RESOLUCIÓN</th>
                              <th>FEC. RES.</th>
                              <th>CONDICIÓN</th>
                              <th>DÍAS</th>
                              <th>INICIA</th>
                              <th>TERMINA</th>
                              <th>ESTADO</th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $tot=0;
                            $sol=0;
                            $msg="";
                            $msg1="";
                            $res=0;
                            $p="";
                            $m=0;
                              while($rvac=mysqli_fetch_assoc($cvac)){
                                $m++;
                                $d=$rvac['idProVacaciones'];
                                $qd="SELECT concat(d.Numero,'-',d.Ano,'-',d.Siglas) AS Resolucion, d.FechaDoc FROM provacaciones as v  INNER JOIN aprvacaciones as av ON v.idProVacaciones= av.idProVacaciones INNER JOIN doc AS d ON av.idDoc=d.idDoc WHERE v.idProVacaciones=$d";
                                $cdoc=mysqli_query($cone,$qd);
                                  if ($rdoc=mysqli_fetch_assoc($cdoc)) {
                                    $doc=$rdoc["Resolucion"];
                                    $fdoc=fnormal($rdoc["FechaDoc"]);

                                  }else {
                                    $doc="Resolución Pendiente";
                                    $fdoc="---";

                                  }
                                  if ($rvac['Estado']=='0') {
                                    $est="info";
                                    $cap="Pendiente";
                                    $hoy = date("Y-m-d");
                                    $ini = $rvac['FechaIni'];
                                    $p=intervalo($ini, $hoy)-1;
                                    if ($rvac['idPeriodoVacacional']==$pervac) {
                                      $sol=intervalo ($rvac['FechaFin'], $rvac['FechaIni']);
                                    }else {
                                      $sol=0;
                                    }
                                    if ($p>0 && $p<15){
                                      $peri=$rvac['PeriodoVacacional'];
                                      if ($p==1) {
                                        $msg="Mañana inician tus vacaciones del período ".$peri.", debes hacer Entrega de Cargo.";
                                      }else{
                                        $msg="Faltan ".$p." días para iniciar tus vacaciones del período ".$peri.", prepara tu Entrega de Cargo.";
                                      }
                                    }
                                  }elseif($rvac['Estado']=='1') {
                                    $est="success";
                                    $cap="Ejecutado";
                                    if ($rvac['idPeriodoVacacional']==$pervac) {
                                      $sol=intervalo ($rvac['FechaFin'], $rvac['FechaIni']);
                                    }else {
                                      $sol=0;
                                    }
                                  }elseif ($rvac['Estado']=='2') {
                                    $est="danger";
                                    $cap="Cancelado";
                                    $sol=0;
                                  }elseif ($rvac['Estado']=='3') {
                                    $est="primary";
                                    $cap="Ejecutandose";
                                    if ($rvac['idPeriodoVacacional']==$pervac) {
                                      $sol=intervalo ($rvac['FechaFin'], $rvac['FechaIni']);
                                    }else {
                                      $sol=0;
                                    }
                                  }elseif ($rvac['Estado']=='5'){
                                    $est="default";
                                    $cap="Suspendida";
                                    if ($rvac['idPeriodoVacacional']==$pervac) {
                                      $sol=intervalo ($rvac['FechaFin'], $rvac['FechaIni']);
                                    }else {
                                      $sol=0;
                                    }
                                  }elseif ($rvac['Estado']=='6') {
                                    $est="default";
                                    $cap="Solicitada";
                                    if ($rvac['idPeriodoVacacional']==$pervac) {
                                      $sol=intervalo ($rvac['FechaFin'], $rvac['FechaIni']);
                                    }else {
                                      $sol=0;
                                    }
                                  }elseif ($rvac['Estado']=='7'){
                                    $est="purple";
                                    $cap="Aceptada";
                                    if ($rvac['idPeriodoVacacional']==$pervac) {
                                      $sol=intervalo ($rvac['FechaFin'], $rvac['FechaIni']);
                                    }else {
                                      $sol=0;
                                    }
                                  }elseif ($rvac['Estado']=='4') {
                                    $est="warning";
                                    $cap="Planificada";
                                    if ($rvac['idPeriodoVacacional']==$pervac) {
                                      $sol=intervalo ($rvac['FechaFin'], $rvac['FechaIni']);
                                    }else {
                                      $sol=0;
                                    }
                                  }
                                  $con="";
                                  if($rvac['Condicion']=='1'){
                                    $con="PROGRAMADAS";
                                    }else {
                                          $con="REPROGRAMADAS";
                                          }
                                  $dt=intervalo ($rvac['FechaFin'], $rvac['FechaIni']);
                                  $tot= $tot + $sol;
                                  if ($mpp>9) { //el valor de $mpp está en a_ofechas.php
                                    if ($tot<31){
                                      $res=30-$tot;
                                      if ($res>0) {
                                        $msg1="Tienes ".$res." días de vacaciones por solicitar para el periodo ".$pv.".";
                                      }elseif($res == 0) {
                                        $msg1="";
                                        $v=false;
                                      }
                                    }else{
                                      $res=$tot-30;
                                      $msg1="Has excedido en ".$res."-".$tot." días las vacaciones solicitadas para el periodo ".$pv.".";
                                      $v=false;
                                    }
                                  }else {
                                    $v=false;
                                    $msg1="";
                                  }
                                  ?>
                              <tr> <!--Fila de vacaciones-->
                                <td><?php echo $m; ?></td>
                                <td style="font-size: 12px;"><?php echo $rvac['PeriodoVacacional']?></td> <!--columna PERÍODO-->
                                <td style="font-size: 12px;"><?php echo $doc?></td> <!--columna NÚMERO DE RESOLUCIÓN-->
                                <td style="font-size: 12px;"><?php echo $fdoc?></td> <!--columna FECHA DOCUMENTO-->
                                <td style="font-size: 12px;"><?php echo $con ?></td> <!--columna CONDICIÓN-->
                                <td class="text-orange"><?php echo $dt ?></td> <!--columna CAMTIDAD DE DIAS-->
                                <td><?php echo "<span class='hidden'>".$rvac['FechaIni']."</span> ".fnormal($rvac['FechaIni'])?></td> <!--columna INICIO-->
                                <td><?php echo fnormal($rvac['FechaFin'])?></td> <!--columna FIN-->
                                <td><span class='label label-<?php echo $est?>'><?php echo $cap?></span></td> <!--columna ESTADO-->
                                <td>
                                  <?php
                                  if ($rvac['Estado']=='6') {
                                  ?>
                                    <button class="btn btn-xs bg-yellow" id="b_elipro" title="Eliminar programación" onclick="elipro(<?php echo $rvac['idProVacaciones'].", '".fnormal($rvac['FechaIni'])."', '".fnormal($rvac['FechaFin'])."'"; ?>)"><i class="fa fa-trash"></i></button>
                                  <?php
                                  }
                                  ?>
                                </td> <!--columna EDITAR-->
                              </tr>
                              <?php
                                }
                               ?>
                          </tbody>
                          <!--fin tbody-->
                        </table>
                        </div>
                        <!--fin table-->
                        <div class="row">
                          <div class="col-sm-9"> <!--Mensaje-->
                            <span class="text-red" > <?php echo $msg ?> </span>
                          </div>
                            <?php
                            if ($vis==false || $msg=="" ) {

                            }else{
                            ?>
                              <div class="col-sm-3"> <!--Botón Entrega de Cargo-->
                                <!-- <button id="b_entcar" class="btn btn-info" data-toggle="modal" data-target="#m_entregacargo" onclick="entcar()">Entrega de Cargo</button> -->
                              </div>
                            <?php
                            }
                            if ($vis){
                            ?>
                             <div class="col-sm-12">
                               <span class="text-green" > <?php echo $msg1 ?> </span>
                               <input type="hidden" name="df" id="df" value="<?php echo $res ?>">
                             </div>
                            <?php
                            }
                            ?>
                        </div>
                        <!--fin div row-->
                        <?php
                      }else {
                        //echo mensajewa("No tiene vacaciones programadas como ". $rcar['cargo'].".");
                      }
                  }

                  ?>
                  </div>
                </div>
                <!--fin div resultados-->
              </div>
              
            <!-- /.tab-pane 2 -->

            <div class="tab-pane" id="tab_3">
              <!--Encabezado-->
              <div class="row">
                <div class="col-sm-12">
                  <h4 class="text-blue" style="font-size: 22px; font-weight:600;"><b><i class="fa fa-user text-orange"></i> <?php echo nomempleado($cone,$idper); ?></b></h4>
                </div>
                <div class="col-sm-3">
                  <input type="hidden" id="idper" value="<?php echo $idper?>"> <!--envía id de personal-->
                </div>
              </div>
              <!--Fin Encabezado-->
              <!--div resultados-->
              <div class="row" id="comser">
                <div class="col-md-12" id="cs">
                  <?php

                    $q="SELECT cs.estadoren, cs.idComServicios, concat(d.Numero,'-',d.Ano,'-',d.Siglas) AS Resolucion, d.FechaDoc, cs.FechaIni, cs.FechaFin, cs.Estado, cs.origen, cs.destino, cs.Descripcion, cs.fecenvren FROM comservicios cs INNER JOIN doc d ON cs.idDoc=d.idDoc WHERE cs.idEmpleado=$idper AND cs.Estado=1 ORDER BY cs.FechaIni DESC;";

                    $ccs=mysqli_query($cone,$q);

                      if (mysqli_num_rows($ccs)>0){                        
                        ?>
                        <div class="row">
                           <div class="col-sm-6">
                             <p style="font-size: 17px;" class="<?php echo $col ?>"><i class="fa fa-black-tie text-yellow"></i> <?php echo cargoe($cone, $idper);?></p>
                           </div>
                           <div class="col-sm-6">
                              <p style="font-size: 17px;" class="<?php echo $col ?> text-right"><i class="fa fa-institution text-yellow"></i> <?php echo dependenciae($cone, $idper);?></p>
                           </div>
                        </div>
                        <!--Fin div row-->
                        <div class="table-responsive">
                        <table id="dtcomser" class="table table-bordered table-hover"> <!--Tabla que Lista las comisiones-->
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>ORIGEN</th>
                              <th>DESTINO</th>
                              <th>FECHAS</th>
                              <th>DOCUMENTO</th>
                              <th>ENVIÓ</th>
                              <th>RENDICIÓN</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $vv="";
                            $cv="";
                            $n=0;
                            while($rcs=mysqli_fetch_assoc($ccs)){
                              $n++;                    
                              //if ($rcs['Estado']==1) {
                                switch ($rcs['estadoren']) {
                                  case 0:
                                    $vv="danger";
                                    $cv="<i class='fa fa-thumbs-down'></i> Pendiente";
                                    break;                
                                  case 1:
                                    $vv="primary";
                                    $cv="<i class='fa fa-hand-peace-o'></i> Enviada";
                                    break;
                                  case 2:
                                    $vv="warning";
                                    $cv="<i class='fa fa-hand-o-left'></i> Observada";
                                    break;
                                  case 3:
                                    $vv="info";
                                    $cv="<i class='fa fa-thumbs-up'></i> Aceptada";
                                    break;  
                                  case 4:
                                    $vv="success";
                                    $cv="<i class='fa fa-thumbs-up'></i> Rendida";
                                    break;
                                  case 5:
                                    $vv="warning";
                                    $cv="Sin viáticos";
                                    break;
                                  case 6:
                                    $vv="danger";
                                    $cv="Anulada";
                                    break;
                                  case 7:
                                    $vv="warning";
                                    $cv="Fuera plazo";
                                    break;
                                } 
                               //}elseif ($rcs['Estado']==2){
                                //$v="danger";
                                //$c="Cancelada";
                               //}
                            ?>
                            <tr> <!--Fila de comisiones-->
                                <td><?php echo $n; ?></td>
                                <td><?php echo $rcs['origen']; ?></td> <!--columna LUGAR-->
                                <td><?php echo $rcs['destino']; ?></td> <!--columna INICIO-->
                                <td style="font-size: 13px;"><?php echo date('d/m/Y H:i', strtotime($rcs['FechaFin']))." ".date('d/m/Y H:i', strtotime($rcs['FechaIni'])); ?></td> <!--columna FIN-->
                                <td style="font-size: 13px;">
                                  <a href="#" title="<?php echo $rcs['Descripcion']; ?>"><?php echo $rcs['Resolucion']?></a>
                                </td> <!--columna NÚMERO DE RESOLUCIÓN-->
                                <td><?php echo ftnormal($rcs['fecenvren']); ?></td> <!--columna NÚMERO DE RESOLUCIÓN-->
                                <td>
                                  <?php if($rcs['FechaIni']>'2018-12-01'){ ?>
                                    <?php if($rcs['estadoren']=='5' || $rcs['estadoren']=='6' || $rcs['estadoren']=='7'){ ?>
                                      <?php echo erviaticos($rcs['estadoren']) ?>
                                    <?php }else{ ?>
                                      <button type="button" class="btn btn-<?php echo $vv;?> btn-xs" title="Estado Rendición" onclick="fo_rendir('agrre',<?php echo $rcs['idComServicios']; ?>)"><?php echo $cv; ?></button>
                                    <?php } ?>
                                  <?php } ?>                              
                                </td> <!--columna RENDIR-->
                              </tr>
                            <?php
                            }
                            ?>
                          </tbody>
                          <!--fin tbody-->
                        </table>
                        </div>
                        <!--fin table-->
                        <?php
                        }else {
                          echo mensajewa("No tiene Programadas Comisiones de Servicio");
                        }
                      ?>
                </div>
              </div>
              <!--fin div resultados-->
            </div>
            <!-- /.tab-pane 3 -->

            <div class="tab-pane" id="tab_4">
            <div class="row">
              <div class="col-sm-12">
                  <h4 class="text-blue" style="font-size: 22px; font-weight:600;"><i class="fa fa-user text-orange"></i> <b><?php echo nomempleado($cone,$idper); ?></b></h4>
                  <input type="hidden" id="idper" value="<?php echo $idper?>"> <!--envía id de personal-->
                </div>
              </div>
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
                          $ec=$rcar['idEmpleadoCargo'];
                      		$cond=$rcar['CondicionCar']=="NINGUNO" ? "" : " (".substr($rcar['CondicionCar'], 0, 1).")";
                      			$c=mysqli_query($cone,"SELECT li.idLicencia, li.idTipoLic, TipoLic, MotivoLic, FechaIni, FechaFin, Numero, Ano, Siglas, li.Estado, do.Descripcion FROM licencia li INNER JOIN aprlicencia al ON li.idLicencia=al.idLicencia INNER JOIN doc do ON al.idDoc=do.idDoc INNER JOIN tipdoclicencia tdl ON li.idTipDocLicencia=tdl.idTipDocLicencia INNER JOIN tipolic tl ON li.idTipoLic=tl.idTipoLic INNER JOIN espmedica em ON li.idEspMedica=em.idEspMedica INNER JOIN empleadocargo ec ON li.idEmpleadoCargo=ec.idEmpleadoCargo WHERE li.idEmpleadoCargo=$ec AND DATE_FORMAT(FechaIni,'%Y')=DATE_FORMAT(now(),'%Y') ORDER BY FechaIni DESC");

                      			if(mysqli_num_rows($c)>0){
                      				$dat=true;
                      				$con++;
                        	?>
                              <div class="table-responsive">
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
                        						<td><a href="#" title="<?php echo $r['Descripcion']; ?>"><?php echo $r['Numero']."-".$r['Ano']."-".$r['Siglas']; ?></a></td>
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
                              </div>
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
                		echo mensajewa("Para el $ano, no presenta licencias.");
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
                <!--fin col-md-12-->
              </div>
              <!--fin div resultados-->
            </div>
            <!-- /.tab-pane 4 -->

            

            
            
          </div>
          <!-- /.tab-content -->
        </div>
        <!-- fin nav-tabs-custom -->
      </div> <!-- /.col-md-12 -->
    </div> <!-- /.row -->
  </section>
  <!-- /.content -->
<?php
}else{
  header('Location: ../index.php');
}
?>

<!--Modal Nuevas programacion-->
<div class="modal fade" id="m_programarvacaciones" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_provacaciones" action="" class="form-horizontal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Vacaciones <?php echo $pv ?></h4>
      </div>
      <div class="modal-body" id="r_provacaciones">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gpvac">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal Nueva programacion-->

<!--Modal editar programacion-->
<div class="modal fade" id="m_editarprogramacion" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_ediprogramacion" action="" class="form-horizontal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Vacaciones <?php echo $pv ?></h4>
      </div>
      <div class="modal-body" id="r_ediprogramacion">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gepro">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal editar programacion-->

<!-- Modal1 -->
<div class="modal fade" id="modal1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" id="ta_modal1">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title ti_modal1" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        <form id="fo_rcomision" role="form" autocomplete="off" class="form-horizontal">
          
        </form>        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn bg-teal" id="gu_modal1" form="fo_rcomision" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Procesando">Guardar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal2 -->
<div class="modal fade" id="modal2" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" id="ta_modal2">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title ti_modal2" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        <form id="fo_drendicion" role="form" autocomplete="off" class="form-horizontal">
          
        </form>        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn bg-teal" id="gu_modal2" form="fo_drendicion" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Procesando"></i> Guardar</button>
      </div>
    </div>
  </div>
</div> 
<!--Fin Modal-->

<!-- Modal3 -->
<div class="modal fade" id="modal3" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" id="ta_modal3">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title ti_modal3" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        <form id="fo_aprov" role="form" autocomplete="off" >
          
        </form>        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn bg-teal" id="gu_modal3" form="fo_aprov" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Procesando"></i> Guardar</button>
      </div>
    </div>
  </div>
</div> 
<!--Fin Modal-->
