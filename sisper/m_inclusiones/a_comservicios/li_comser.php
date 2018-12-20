<?php 
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  $idper=$_SESSION['identi'];
?>
<div class="col-md-12" id="cs">
<?php
$q="SELECT cs.estadoren, cs.idComServicios, concat(d.Numero,'-',d.Ano,'-',d.Siglas) AS Resolucion, d.FechaDoc, cs.FechaIni, cs.FechaFin, cs.Estado, SUBSTRING(cs.Descripcion, 1, 100) as Descripcion, di.NombreDis FROM comservicios cs INNER JOIN doc d ON cs.idDoc=d.idDoc INNER JOIN distrito di ON cs.idDistrito=di.idDistrito WHERE cs.idEmpleado=$idper AND cs.Estado=1;";

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
        <th>DESCRIPCIÓN DE LA COMISIÓN</th>
        <th>LUGAR</th>
        <th>INICIA</th>
        <th>TERMINA</th>
        <th>NÚMERO DE RESOLUCIÓN</th>        
        <th>RENDICIÓN</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $v="";
      $c="";
      while($rcs=mysqli_fetch_assoc($ccs)){                     
        //if ($rcs['Estado']==1) {
          switch ($rcs['estadoren']) {
            case 0:
              $v="danger";
              $c="<i class='fa fa-thumbs-down'></i> Pendiente";
              break;                
            case 1:
              $v="primary";
              $c="<i class='fa fa-hand-peace-o'></i> Enviada";
              break;
            case 2:
              $v="warning";
              $c="<i class='fa fa-hand-o-left'></i> Observada";
              break;
            case 3:
              $v="info";
              $c="<i class='fa fa-thumbs-up'></i> Aceptada";
              break;  
            case 4:
              $v="success";
              $c="<i class='fa fa-thumbs-up'></i> Rendida";
              break;                                
          } 
         //}elseif ($rcs['Estado']==2){
          //$v="danger";
          //$c="Cancelada";
         //}
      ?>
      <tr> <!--Fila de comisiones-->
          <td><?php echo $rcs['Descripcion']?></td> <!--columna DESCRIPCIÓN-->
          <td><?php echo $rcs['NombreDis']?></td> <!--columna LUGAR-->
          <td><?php echo date('d/m/Y H:i', strtotime($rcs['FechaIni']))?></td> <!--columna INICIO-->
          <td><?php echo date('d/m/Y H:i', strtotime($rcs['FechaFin']))?></td> <!--columna FIN-->
          <td><?php echo $rcs['Resolucion']?></td> <!--columna NÚMERO DE RESOLUCIÓN-->         
          <td>               
            <button type="button" class="btn btn-<?php echo $v;?> btn-xs" title="Estado Rendición" onclick="fo_rendir('agrre',<?php echo $rcs['idComServicios']; ?>)"><?php echo $c; ?></button>                                  
          </td> <!--columna RENDIR-->
        </tr>
      <?php
      }
      ?>
    </tbody>
    <!--fin tbody-->
  </table>
  <!--fin table-->
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
