<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],9)){
$idper=$_POST['idper'];
$pervac=$_POST['pervac'];
$sql="SELECT ec.idEstadoCar as est, ec.idEmpleadoCargo, ec.FechaVac, ec.FechaAsu, cl.Tipo, ma.ModAcceso, eca.EstadoCar, c.Denominacion AS cargo, d.Denominacion, cc.CondicionCar FROM empleadocargo ec INNER JOIN condicionlab cl ON ec.idCondicionLab=cl.idCondicionLab INNER JOIN modacceso ma ON ec.idModAcceso=ma.idModAcceso INNER JOIN estadocar eca ON ec.idEstadoCar=eca.idEstadoCar INNER JOIN cargo c ON ec.idCargo=c.idCargo INNER JOIN cardependencia cd ON ec.idEmpleadoCargo=cd.idEmpleadoCargo INNER JOIN dependencia d ON cd.idDependencia=d.idDependencia INNER JOIN condicioncar cc ON ec.idCondicionCar=cc.idCondicionCar WHERE ec.idEmpleado=$idper and cd.oficial=1 ORDER BY ec.idEstadoCar ASC,  ec.idEmpleadoCargo DESC";
$ccar=mysqli_query($cone,$sql);
$qec="SELECT idEmpleadoCargo, FechaVac, FechaAsu FROM empleadocargo WHERE idEmpleado=$idper and idEstadoCar=1";
$cec=mysqli_query($cone,$qec);
$hoy = date("Y");
$anos= $hoy + 1;
$pv = trim($hoy." - ".$anos);
if ($rec=mysqli_fetch_assoc($cec)) {
  $idec=$rec['idEmpleadoCargo'];
include("a_ofechas.php");
}
$z=true;
?>
<!--div resultados-->
<div class="col-md-12" id="vac">
  <?php
    $n=0;
  while($rcar=mysqli_fetch_assoc($ccar)){
    $n++;
    $car=$rcar['idEmpleadoCargo'];
    $q="SELECT v.idProVacaciones, pv.PeriodoVacacional, v.FechaIni, v.FechaFin, v.Estado, v.Condicion FROM provacaciones as v INNER JOIN periodovacacional AS pv ON v.idPeriodoVacacional = pv.idPeriodoVacacional INNER JOIN empleadocargo AS ec ON v.idEmpleadoCargo=ec.idEmpleadoCargo WHERE ec.idEmpleadoCargo=$car";

    $cvac=mysqli_query($cone,$q);
    $vis=false;
      if (mysqli_num_rows($cvac)>0) {
       ?>
       <div class="row">
         <?php
          $cond=$rcar['CondicionCar']=="NINGUNO" ? "" : " (".substr($rcar['CondicionCar'], 0, 1).")";
           if ($rcar['est']==1) {
             $col="text-blue";
             $vis= true;
           }else{
             $col="";
           }
         ?>
       <div class="col-sm-4">
            <h4 ><small class="<?php echo $col ?> text-center" style="font-weight: bold"><i class="fa fa-black-tie"></i> <?php echo $rcar['cargo'].$cond." (".$rcar['EstadoCar'].")"  ?></small></h4>
       </div>
       <div class="col-sm-5">
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
              <th></th>
            </tr>
          </thead>
      <tbody>
        <?php
        $tot=0;
        $sol=0;
        $tot=0;
        $msg="";
        $msg1="";
        $res=0;
        $p="";
            while($rvac=mysqli_fetch_assoc($cvac)){
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
              }elseif ($rvac['Estado']=='2') {
                $est="danger";
                $cap="Cancelado";
              }elseif ($rvac['Estado']=='3') {
                $est="primary";
                $cap="Ejecutandose";
              }elseif ($rvac['Estado']=='5'){
                $est="default";
                $cap="Suspendida";
              }elseif ($rvac['Estado']=='6') {
                $est="default";
                $cap="Solicitada";
                $sol=intervalo ($rvac['FechaFin'], $rvac['FechaIni']);
              }elseif ($rvac['Estado']=='7'){
                $est="purple";
                $cap="Aceptada";
                if ($rvac['idPeriodoVacacional']=$pervac) {
                  $sol=intervalo ($rvac['FechaFin'], $rvac['FechaIni']);
                }
              }elseif ($rvac['Estado']=='4') {
                $est="warning";
                $cap="Planificada";
                if ($rvac['idPeriodoVacacional']=$pervac) {
                  $sol=intervalo ($rvac['FechaFin'], $rvac['FechaIni']);
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

              if ($tot<31){
                $res=30-$tot;
                if ($res>0) {
                  $msg1="Tienes ".$res." días de vacaciones por solicitar para el periodo ".$pv.".";
                }elseif($res == 0) {
                  $msg1="";
                  $z=false;
                }
              }else{
                $res=$tot-30;
                $msg1="Haz exedido en ".$res." días las vacaciones solicitadas para el periodo ".$pv.".";
                $z=false;
              }
              ?>
          <tr> <!--Fila de vacaciones-->
            <td><?php echo $rvac['PeriodoVacacional']?></td> <!--columna PERÍODO-->
            <td><?php echo $doc?></td> <!--columna NÚMERO DE RESOLUCIÓN-->
            <td><?php echo $fdoc?></td> <!--columna FECHA DOCUMENTO-->
            <td><?php echo $con ?></td> <!--columna CONDICIÓN-->
            <td><?php echo $dt ?></td> <!--columna CAMTIDAD DE DIAS-->
            <td><?php echo "<span class='hidden'>".$rvac['FechaIni']."</span> ".fnormal($rvac['FechaIni'])?></td> <!--columna INICIO-->
            <td><?php echo fnormal($rvac['FechaFin'])?></td> <!--columna FIN-->
            <td><span class='label label-<?php echo $est?>'><?php echo $cap?></span></td> <!--columna ESTADO-->
            <td>
              <?php
              if ($rvac['Estado']=='6') {
              ?>
                <a href="#" data-toggle="modal" data-target="#m_editarprogramacion"><i class="fa fa-pencil" onclick="edipro(<?php echo $rvac['idProVacaciones'].", '".$fii."', '".$ffi."', '".$fff."'" ?>)"></i></a>
              <?php
              }
              ?>
            </td> <!--columna EDITAR-->
          </tr>
          <?php
            }
           ?>
      </tbody>
    </table>
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
<?php
     }else {
      echo mensajewa("No tiene vacaciones programadas como ". $rcar['cargo'].".");
     }
}

?>
</div>
<!--fin div resultados-->
<script>
$("#b_provac").<?php echo $z ? "show();" : "hide();";?>

<?php for ($i=1; $i < ($n+1); $i++) {  ?>

  $("#dtable<?php echo $i ?>").DataTable({
    "order": [[7,"asc"]]
  });
<?php } ?>
</script>
<?php
}else{
  echo accrestringidoa();
}
?>
