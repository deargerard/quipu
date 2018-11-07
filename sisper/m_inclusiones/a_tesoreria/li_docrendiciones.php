<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],16)){
	if(isset($_POST['idr']) && !empty($_POST['idr'])){
		$idr=iseguro($cone,$_POST['idr']);
    $c2=mysqli_query($cone,"SELECT r.*, m.nombre AS meta, m.mnemonico, f.nombre AS fondo, f.idtefondo FROM terendicion r INNER JOIN temeta m ON r.idtemeta=m.idtemeta INNER JOIN tefondo f ON m.idtefondo=f.idtefondo WHERE idterendicion=$idr");
    if($r2=mysqli_fetch_assoc($c2)){
?>
      <br>
      <table class="table table-hover">
        <tr>
          <th><?php echo strtoupper(nombremes($r2['mes']))." / ".$r2['anio']; ?></th>
          <th><?php echo $r2['trendicion']==1 ? "FOND. Y PROG." : ($r2['trendicion']==2 ? "VIÁTICOS" : ""); ?></th>
          <td><?php echo $r2['estado']==1 ? "<span class='label label-success'>Abierta</span>" : "<span class='label label-danger'>Cerrada</span>"; ?></td>
          <td align="right">
            <div class="btn-group btn-group-sm" role="group">
              <button type="button" class="btn btn-info" title="Agregar" onclick="fo_rendiciones('agrdoc',<?php echo $idr.",".$r2['trendicion']; ?>)"><i class="fa fa-plus"></i> Agregar</button>
              <button type="button" class="btn btn-info" title="Cerrar" onclick="fo_rendiciones('cerren',<?php echo $idr.",0"; ?>)"><i class="fa fa-archive"> Cerrar</i></button>
              <button type="button" class="btn btn-info" title="Regresar" onclick="lrendiciones(<?php echo "'".$r2['mes']."/".$r2['anio']."'"; ?>);"><i class="fa fa-chevron-circle-left"></i></button>
            </div>
          </td>
        </tr>
        <tr>
          <th class="text-orange"><?php echo $r2['codigo']; ?></th>
          <th class="text-orange"><?php echo $r2['fondo']." / ".$r2['meta']." (".$r2['mnemonico'].")"; ?></th>  
          <td colspan="2"><?php echo nomempleado($cone,$r2['empleado']); ?></td>
        </tr>
      </table>
<?php
        if($r2['idtefondo']==3){
                  $c1=mysqli_query($cone,"SELECT g.*, tc.tipo, p.razsocial, e.nombre, e.codigo, m.mnemonico, p.ruc FROM tegasto g INNER JOIN tetipocom tc ON g.idtetipocom=tc.idtetipocom INNER JOIN teespecifica e ON g.idteespecifica=e.idteespecifica INNER JOIN terendicion r ON g.idterendicion=r.idterendicion INNER JOIN temeta m ON r.idtemeta=m.idtemeta LEFT JOIN teproveedor p ON g.idteproveedor=p.idteproveedor WHERE g.idterendicion=$idr;");
                  echo mysqli_error($cone);
                  if(mysqli_num_rows($c1)>0){
                    
?>
                  <table class="table table-hover table-bordered" id="dtable">
                    <thead>
                      <tr>
                        <th>N°</th>
                        <th>FECHA</th>
                        <th>CLASE</th>
                        <th>NUM.</th>
                        <th>PROVEEDOR</th>
                        <th>RUC</th>
                        <th>ESPECIFICA</th>
                        <th>MNEMOTECNICO</th>
                        <th>TOTAL</th>
                        <th>POR</th>
                        <th>ACCIÓN</th>
                      </tr>
                    </thead>
                    <tbody>
<?php
                      $c=0;
                      while($r1=mysqli_fetch_assoc($c1)){
                        $c++;
?>
                      <tr>
                        <td><?php echo $c; ?></td>
                        <td><?php echo $r1['fechacom']; ?></td>
                        <td><?php echo $r1['tipo']; ?></td>
                        <td><?php echo $r1['numerocom']; ?></td>
                        <td><?php echo $r1['razsocial']; ?></td>
                        <td><?php echo $r1['ruc']; ?></td>
                        <td><?php echo $r1['mnemonico']; ?></td>
                        <td><?php echo $r1['totalcom']; ?></td>
                        <td><?php echo nomempleado($cone, $r1['empleado']); ?></td>
                        <td>
                          <div class="btn-group btn-group-xs" role="group" aria-label="Basic">
                            <?php if(accesocon($cone,$_SESSION['identi'],16)){ ?>
                            <button type="button" class="btn btn-default" title="Editar" onclick="fo_rendiciones('ediren',<?php echo $r1['idterendicion'].",0"; ?>)"><i class="fa fa-pencil"></i></button>
                            <?php } ?>
                            <button type="button" class="btn btn-default" title="Ir"><i class="fa fa-chevron-circle-right"></i></button>
                          </div>
                        </td>
                      </tr>
<?php
                      }
?>
                    </tbody>
                  </table>
                  <script>
                    $('#dtable').DataTable();
                  </script>
<?php
                  }else{
                    echo mensajewa("No se encontraron documentos para la rendición seleccionada.");
                  }
                  mysqli_free_result($c1);
        }else{
                  $c1=mysqli_query($cone,"SELECT g.*, tc.tipo, p.razsocial, e.nombre, e.codigo, m.mnemonico, p.ruc FROM tegasto g INNER JOIN tetipocom tc ON g.idtetipocom=tc.idtetipocom INNER JOIN teespecifica e ON g.idteespecifica=e.idteespecifica INNER JOIN terendicion r ON g.idterendicion=r.idterendicion INNER JOIN temeta m ON r.idtemeta=m.idtemeta LEFT JOIN teproveedor p ON g.idteproveedor=p.idteproveedor WHERE g.idterendicion=$idr;");
                  echo mysqli_error($cone);
                  if(mysqli_num_rows($c1)>0){
                    
?>
                  <table class="table table-hover table-bordered" id="dtable">
                    <thead>
                      <tr>
                        <th>N°</th>
                        <th>FECHA</th>
                        <th>CLASE</th>
                        <th>NUM.</th>
                        <th>PROVEEDOR</th>
                        <th>RUC</th>
                        <th>ESPECIFICA</th>
                        <th>MNEMOTECNICO</th>
                        <th>TOTAL</th>
                        <th>POR</th>
                        <th>ACCIÓN</th>
                      </tr>
                    </thead>
                    <tbody>
<?php
                      $c=0;
                      while($r1=mysqli_fetch_assoc($c1)){
                        $c++;
?>
                      <tr>
                        <td><?php echo $c; ?></td>
                        <td><?php echo $r1['fechacom']; ?></td>
                        <td><?php echo $r1['tipo']; ?></td>
                        <td><?php echo $r1['numerocom']; ?></td>
                        <td><?php echo $r1['razsocial']; ?></td>
                        <td><?php echo $r1['ruc']; ?></td>
                        <td><?php echo $r1['mnemonico']; ?></td>
                        <td><?php echo $r1['totalcom']; ?></td>
                        <td><?php echo nomempleado($cone, $r1['empleado']); ?></td>
                        <td>
                          <div class="btn-group btn-group-xs" role="group" aria-label="Basic">
                            <?php if(accesocon($cone,$_SESSION['identi'],16)){ ?>
                            <button type="button" class="btn btn-default" title="Editar" onclick="fo_rendiciones('ediren',<?php echo $r1['idterendicion'].",0"; ?>)"><i class="fa fa-pencil"></i></button>
                            <?php } ?>
                            <button type="button" class="btn btn-default" title="Ir"><i class="fa fa-chevron-circle-right"></i></button>
                          </div>
                        </td>
                      </tr>
<?php
                      }
?>
                    </tbody>
                  </table>
                  <script>
                  	$('#dtable').DataTable();
                  </script>
<?php
                  }else{
                    echo mensajewa("No se encontraron documentos para la rendición seleccionada.");
                  }
                  mysqli_free_result($c1);
        }
    }else{
      echo mensajewa("Error, datos inválidos");
    }
    mysqli_free_result($c2);
  }else{
  	echo mensajeda("Error: No se recibieron datos.");
  }
}else{
  echo accrestringidoa();
}
?>