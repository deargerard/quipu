<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],16)){
	if(isset($_POST['ide']) && !empty($_POST['ide'])){    
		  $ide=iseguro($cone,$_POST['ide']);
      $c1=mysqli_query($cone,"SELECT * FROM teentrega WHERE idteentrega=$ide");
      if ($r1=mysqli_fetch_assoc($c1)) {

?>
      <br>
      <table class="table table-hover table-bordered">
        <tr>
          <th class="text-olive"><h4><i class="fa fa-money text-gray"></i> Entrega a: </h4></th>
          <th class="text-olive"><h4><?php echo nomempleado($cone,$r1['idEmpleado']); ?></h4></th>
          <th class="text-olive"><h4><?php echo $r1['motivo']; ?></h4></th>                   
          <td align="right">

              <button type="button" class="btn bg-maroon" title="Agregar documento entrega" onclick="fo_entregas('agrdent',<?php echo $ide ?>,0)"><i class="fa fa-plus"></i> Doc. Entrega</button>
              <button type="button" class="btn bg-purple" title="Agregar comprobante" onclick="fo_entregas('agrcomp',<?php echo $ide ?>,0)"><i class="fa fa-plus"></i> Comprobantes</button>
              <button type="button" class="btn bg-purple" title="Agregar viático" onclick="fo_entregas('agrviat',<?php echo $ide ?>,0)"><i class="fa fa-plus"></i> Viáticos</button>              
              <button type="button" class="btn btn-info" title="Regresar" onclick="bentregas(<?php echo $r1['idEmpleado']; ?>);"><i class="fa fa-chevron-circle-left"></i></button>

          </td>
        </tr>        
      </table>

<?php
      $sde=0;
      $c2=mysqli_query($cone,"SELECT de.*, e.motivo, e.idEmpleado, e.idteentrega, e.empleado FROM tedocentrega de INNER JOIN teentrega e ON e.idteentrega = de.idteentrega WHERE de.idteentrega=$ide");
      if(mysqli_num_rows($c2)>0){
?>
      <h5 class="text-orange"> <i class="fa fa-stack-overflow text-gray"></i> Documentos entrega</h5>
      <table class="table table-hover table-bordered">
        <thead>
          <tr>
            <th>N°</th>
            <th>TIPO</th>
            <th>NÚMERO</th>
            <th>MOVIMIENTO</th>
            <th>FECHA</th>
            <th>BENEFICIARIO</th>
            <th>POR</th>
            <th>MONTO</th>  
            <th>ACCIÓN</th>
          </tr>
        </thead>
        <tbody>
<?php
          $c=0;          
          while($r2=mysqli_fetch_assoc($c2)){
            $c++;
            if($r2['tipmov']==1){
              $sde=$sde+$r2['monto'];
            }elseif($r2['tipmov']==2){
              $sde=$sde-$r2['monto'];
            }
?>
            <tr>
              <td><?php echo $c; ?></td>
              <td><?php echo tipdocent($r2['tipo']); ?></td>
              <td><?php echo $r2['numero']; ?></td>
              <td><?php echo $r2['tipmov']==1 ? "ADELANTO" : "DEVOLUCIÓN" ; ; ?></td>
              <td><?php echo fnormal($r2['fecha']); ?></td>
              <td><?php echo $r2['beneficiario']; ?></td>
              <td><?php echo nomempleado($cone, $r2['empleado']); ?></td>
              <td><?php echo $r2['monto']; ?></td>            
              <td>
                <div class="btn-group btn-group-xs" role="group" aria-label="Basic">
                  <?php if(accesocon($cone,$_SESSION['identi'],16)){ ?>
                  <button type="button" class="btn btn-default" title="Editar" onclick="fo_entregas('edident',<?php echo $r2['idteentrega'] .','. $r2['idtedocentrega']; ?>)"><i class="fa fa-pencil"></i></button>
                  <button type="button" class="btn btn-default" title="Eliminar" onclick="fo_entregas('elident',<?php echo $r2['idteentrega'] .','. $r2['idtedocentrega']; ?>)"><i class="fa fa-trash"></i></button>
                  <?php } ?>
                  
                </div>
              </td>
            </tr>
<?php
          }
?>
            <tr class="text-orange">
              <th colspan="7" style="text-align: right;">TOTAL</th>
              <th colspan="2"><?php echo n_2decimales($sde); ?></th>
            </tr>
        </tbody>
      </table>
<?php
      }
      mysqli_free_result($c2);
?>

<?php
          $sdc=0;
          $c2=mysqli_query($cone,"SELECT g.idtegasto, g.numerocom, g.glosacom, g.totalcom, g.fechacom, tc.tipo FROM tegasto g INNER JOIN tetipocom tc ON g.idtetipocom = tc.idtetipocom WHERE g.idteentrega=$ide;");
          if(mysqli_num_rows($c2)>0){
?>
      <h5 class="text-orange"> <i class="fa fa-stack-overflow text-gray"></i> Comprobantes</h5>
      <table class="table table-hover table-bordered">
        <thead>
          <tr>
            <th>#</th>
            <th>TIPO</th>
            <th>NÚMERO</th>
            <th>GLOSA</th>
            <th>FECHA</th>
            <th>MONTO</th>  
            <th>ACCIÓN</th>
          </tr>
        </thead>
        <tbody>
<?php
          $c=0;
          while($r2=mysqli_fetch_assoc($c2)){
            $c++;
            $sdc=$sdc+$r2['totalcom'];
?>
            <tr>
              <td><?php echo $c; ?></td>
              <td><?php echo $r2['tipo']; ?></td>
              <td><?php echo $r2['numerocom']; ?></td>
              <td><?php echo $r2['glosacom']; ; ?></td>
              <td><?php echo fnormal($r2['fechacom']); ?></td>
              <td><?php echo $r2['totalcom']; ?></td>            
              <td>
                <div class="btn-group btn-group-xs" role="group" aria-label="Basic">
                  <?php if(accesocon($cone,$_SESSION['identi'],16)){ ?>
                  <button type="button" class="btn btn-default" title="Liberar" onclick="fo_entregas('libcomp',<?php echo $ide .','. $r2['idtegasto']; ?>)"><i class="fa fa-external-link"></i></button>
                  <?php } ?>
                </div>
              </td>
            </tr>
<?php
          }
?>
            <tr class="text-orange">
              <th colspan="5" style="text-align: right;">TOTAL</th>
              <th colspan="2"><?php echo n_2decimales($sdc); ?></th>
            </tr>
        </tbody>
      </table>
<?php
        }
        mysqli_free_result($c2);
?>


<?php
        $sdv=0;
        $c2=mysqli_query($cone,"SELECT cs.idComServicios, cs.FechaIni, cs.FechaFin, cs.destino, cs.idEmpleado, cs.estadoren, d.Numero, d.Ano, d.Siglas, SUM(g.totalcom) tot FROM comservicios cs INNER JOIN doc d ON cs.idDoc=d.idDoc LEFT JOIN tegasto g ON cs.idComServicios = g.idComServicios WHERE cs.idteentrega=$ide GROUP BY idComServicios;");
        if(mysqli_num_rows($c2)>0){
?>
      <h5 class="text-orange"> <i class="fa fa-stack-overflow text-gray"></i> Viáticos</h5>
      <table class="table table-hover table-bordered">
        <thead>
          <tr>
            <th>#</th>
            <th>NOMBRE</th>
            <th>DESTINO</th>
            <th>FECHAS</th>
            <th>DOCUMENTO</th>
            <th>ESTADO</th>
            <th>MONTO</th>
            <th>ACCIÓN</th>
          </tr>
        </thead>
        <tbody>
<?php
          $c=0;
          while($r2=mysqli_fetch_assoc($c2)){
            $c++;
            $sdv=$sdv+$r2['tot'];
?>
            <tr>
              <td><?php echo $c; ?></td>
              <td><?php echo nomempleado($cone, $r2['idEmpleado']); ?></td>
              <td><?php echo $r2['destino']; ?></td>
              <td><?php echo fnormal($r2['FechaIni'])." - ".fnormal($r2['FechaFin']); ?></td>
              <td><?php echo $r2['Numero']."-".$r2['Ano']."-".$r2['Siglas']; ?></td>
              <td><?php echo erviaticos($r2['estadoren']); ?></td>
              <td><?php echo $r2['tot']; ?></td>         
              <td>
                <div class="btn-group btn-group-xs" role="group" aria-label="Basic">
                  <?php if(accesocon($cone,$_SESSION['identi'],16)){ ?>
                  <button type="button" class="btn btn-default" title="Liberar" onclick="fo_entregas('libviat',<?php echo $ide .','. $r2['idComServicios']; ?>)"><i class="fa fa-external-link"></i></button>
                  <?php } ?>
                </div>
              </td>
            </tr>
<?php
          }
?>
            <tr class="text-orange">
              <th colspan="6" style="text-align: right;">TOTAL</th>
              <th colspan="2"><?php echo n_2decimales($sdv); ?></th>
            </tr>
        </tbody>
      </table>
<?php
      }
      mysqli_free_result($c2);
      if($sde>0){
?>
      <table class="table table-hover table-bordered text-maroon">
        <thead>
        <tr>
          <th>TOTAL ENTREGAS</th>
          <?php if($sdc>0){ ?>
          <th>TOTAL COMPROBANTES</th>
          <?php } ?>
          <?php if($sdv>0){ ?>
          <th>TOTAL VIÁTICOS</th>
          <?php } ?>
          <th>SALDO</th>
        </tr>
        </thead>
        <tr>
          <th><?php echo n_2decimales($sde); ?></th>
          <?php if($sdc>0){ ?>
          <th><?php echo n_2decimales($sdc); ?></th>
          <?php } ?>
          <?php if($sdv>0){ ?>
          <th><?php echo n_2decimales($sdv); ?></th>
          <?php } ?>
          <th><?php echo n_2decimales($sde-($sdc+$sdv)); ?></th>
        </tr>
      </table>
<?php
      }
       }
  }else{
  	echo mensajeda("Error: No se recibieron datos.");
  }
}else{
  echo accrestringidoa();
}
?>