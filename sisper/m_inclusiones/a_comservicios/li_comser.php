<?php 
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  $idper=$_SESSION['identi'];
?>
<div class="col-md-12" id="cs">
<?php
$q="SELECT cs.estadoren, cs.idComServicios, concat(d.Numero,'-',d.Ano,'-',d.Siglas) AS Resolucion, d.FechaDoc, cs.FechaIni, cs.FechaFin, cs.Estado, cs.origen, cs.destino, cs.Descripcion, cs.fecenvren FROM comservicios cs INNER JOIN doc d ON cs.idDoc=d.idDoc WHERE cs.idEmpleado=$idper AND cs.Estado=1 ORDER BY cs.FechaIni DESC;";

$ccs=mysqli_query($cone,$q);

if (mysqli_num_rows($ccs)>0){                        
  ?>
  <div class="row">
     <div class="col-sm-4">
       <h4 ><small class="<?php echo $col ?> text-center" style="font-weight: bold"><i class="fa fa-black-tie"></i> <?php echo cargoe($cone, $idper)." (ACTIVO)";?></small></h4>
     </div>
     <div class="col-sm-5">
        <h4 ><small class="<?php echo $col ?> text-center" style="font-weight: bold"><i class="fa fa-institution"></i> <?php echo dependenciae($cone, $idper);?></small></h4>
     </div>
  </div>
  <!--Fin div row-->
  <table id="dtcomser" class="table table-bordered table-hover"> <!--Tabla que Lista las comisiones-->
    <thead>
      <tr>
        <th>#</th>
        <th>DESCRIPCIÓN DE LA COMISIÓN</th>
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
          } 
         //}elseif ($rcs['Estado']==2){
          //$v="danger";
          //$c="Cancelada";
         //}
      ?>
      <tr> <!--Fila de comisiones-->
          <td><?php echo $n; ?></td>
          <td><?php echo strlen($rcs['Descripcion'])>100 ? substr(html_entity_decode($rcs['Descripcion']), 0, 100)."..." : $rcs['Descripcion']; ?></td> <!--columna DESCRIPCIÓN-->
          <td><?php echo $rcs['origen']; ?></td> <!--columna LUGAR-->
          <td><?php echo $rcs['destino']; ?></td> <!--columna INICIO-->
          <td><?php echo date('d/m/Y H:i', strtotime($rcs['FechaFin']))." ".date('d/m/Y H:i', strtotime($rcs['FechaIni'])); ?></td> <!--columna FIN-->
          <td><?php echo $rcs['Resolucion']?></td> <!--columna NÚMERO DE RESOLUCIÓN-->         
          <td><?php echo ftnormal($rcs['fecenvren']); ?></td> <!--columna NÚMERO DE RESOLUCIÓN-->
          <td>
            <?php if($rcs['FechaIni']>'2018-12-01'){ ?>            
            <button type="button" class="btn btn-<?php echo $vv;?> btn-xs" title="Estado Rendición" onclick="fo_rendir('agrre',<?php echo $rcs['idComServicios']; ?>)"><?php echo $cv; ?></button>
            <?php } ?>                              
          </td> <!--columna RENDIR-->
        </tr>
      <?php
      }
      ?>
    </tbody>
    <!--fin tbody-->
  </table>
  <!--fin table-->
  <script>
    $('#dtcomser').DataTable();
  </script>
  <?php
  }else {
    echo mensajewa("No tiene Programadas Comisiones de Servicio");
  }
?>
</div>
<?php
}else{
  header('Location: ../../index.php');
}
?>
