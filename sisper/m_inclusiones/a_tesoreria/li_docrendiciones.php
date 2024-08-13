<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],16)){
  $idu=$_SESSION['identi'];
	if(isset($_POST['idr']) && !empty($_POST['idr'])){
		$idr=iseguro($cone,$_POST['idr']);
    $c2=mysqli_query($cone,"SELECT r.*, m.nombre AS meta, m.mnemonico, f.nombre AS fondo, f.idtefondo FROM terendicion r INNER JOIN temeta m ON r.idtemeta=m.idtemeta INNER JOIN tefondo f ON m.idtefondo=f.idtefondo WHERE idterendicion=$idr");
    if($r2=mysqli_fetch_assoc($c2)){
?>
      <br>
      <table class="table table-bordered table-hover">
        <tr>
          <th class="text-orange">
            <i class="fa fa-file-text-o text-gray"></i> DOCUMENTOS
            <input type="hidden" id="ir" value="<?php echo $idr; ?>">
          </th>
          <th class="text-orange">
            <?php echo $r2['fondo']." / ".$r2['meta']." [".$r2['mnemonico']."]"; ?>
          </th>
          <th class="text-orange">
            <?php echo $r2['codigo']; ?>
          </th>
          <td align="right">
              <div class="btn-group btn-group-sm" role="group" aria-label="...">
                <?php if(accesoadm($cone,$_SESSION['identi'],16) && $idu==$r2['empleado']){ ?>
                  <?php if($r2['estado']==1){ ?>
                <button type="button" class="btn btn-info" title="Agregar" onclick="fo_rendiciones('agrdoc',<?php echo $idr.",".$r2['trendicion']; ?>)"><i class="fa fa-plus"></i> Agregar</button>
                  <?php } ?>
                <button type="button" class="btn btn-info" title="<?php echo $r2['estado']==1 ? "Archivar" : "Reabrir"; ?>" onclick="fo_rendiciones('estren',<?php echo $idr.",0"; ?>)"><i class="fa <?php echo $r2['estado']==1 ? "fa-folder" : "fa-folder-open"; ?>"></i> <?php echo $r2['estado']==1 ? "Archivar" : "Reabrir"; ?></button>
                <?php } ?>
                <?php if($r2['trendicion']==1){ ?>
                <a href="m_inclusiones/a_tesoreria/xls_anexo11.php?ren=<?php echo $idr; ?>" class="btn btn-info" title="Exportar" target="_blank"><i class="fa fa-cloud-download"></i> A 10</a>
                <a href="m_inclusiones/a_tesoreria/xls_anexo12.php?ren=<?php echo $idr; ?>&ti=<?php echo $r2['trendicion']; ?>" class="btn btn-info" title="Exportar" target="_blank"><i class="fa fa-cloud-download"></i> A 11</a>
                <?php } ?>
                <a href="m_inclusiones/a_tesoreria/xls_anexo16.php?ren=<?php echo $idr; ?>&ti=<?php echo $r2['trendicion']; ?>" class="btn btn-info" title="Exportar" target="_blank"><i class="fa fa-cloud-download"></i> A 13</a>
                <button type="button" class="btn btn-info" title="Regresar" onclick="lrendiciones(<?php echo "'".$r2['mes']."/".$r2['anio']."'"; ?>);"><i class="fa fa-chevron-circle-left"></i></button>
              </div>
          </td>
        </tr>
        <tr>
          <td>
            <i class="fa fa-calendar text-gray"></i> <?php echo strtoupper(nombremes($r2['mes']))." / ".$r2['anio']; ?>
          </td>
          <td>
            <?php echo $r2['trendicion']==1 ? "FONDOS Y PROGRAMAS" : ($r2['trendicion']==2 ? "VIÁTICOS" : ""); ?>
          </td>  
          <td><?php echo $r2['estado']==1 ? "<span class='label label-warning'>Abierta</span>" : "<span class='label label-success'>Archivada</span>"; ?></td>
          <td><?php echo nomempleado($cone,$r2['empleado']); ?></td>
        </tr>
      </table>
      <div class="table-responsive">
<?php
        if($r2['trendicion']==1){
                  $c1=mysqli_query($cone,"SELECT g.*, tc.tipo, p.razsocial, e.nombre, e.codigo, m.mnemonico, p.ruc FROM tegasto g INNER JOIN tetipocom tc ON g.idtetipocom=tc.idtetipocom INNER JOIN teespecifica e ON g.idteespecifica=e.idteespecifica INNER JOIN terendicion r ON g.idterendicion=r.idterendicion INNER JOIN temeta m ON r.idtemeta=m.idtemeta LEFT JOIN teproveedor p ON g.idteproveedor=p.idteproveedor WHERE g.idterendicion=$idr;");
                  echo mysqli_error($cone);
                  if(mysqli_num_rows($c1)>0){
                    
?>
                  <table class="table table-hover table-bordered" id="dtable1">
                    <thead>
                      <tr>
                        <th>N°</th>
                        <th>FECHA</th>
                        <th>CLASE</th>
                        <th>NUM.</th>
                        <th>PROVEEDOR</th>
                        <th>RUC</th>
                        <th>DETALLE GASTO</th>
                        <th>ESPECIFICA</th>
                        <th>TOTAL</th>
                        <?php if($r2['estado']==1 && accesoadm($cone,$_SESSION['identi'],16)){ ?>
                        <th>ACCIÓN</th>
                        <?php } ?>
                      </tr>
                    </thead>
                    <tbody>
<?php
                      $c=0;
                      $t=0;
                      while($r1=mysqli_fetch_assoc($c1)){
                        $c++;
?>
                      <tr>
                        <td><?php echo $c; ?></td>
                        <td><?php echo fnormal($r1['fechacom']); ?></td>
                        <td><?php echo $r1['tipo']; ?></td>
                        <td><?php echo $r1['numerocom']; ?></td>
                        <td><?php echo $r1['razsocial']; ?></td>
                        <td><?php echo $r1['ruc']; ?></td>
                        <td><?php echo $r1['glosacom']; ?></td>
                        <td><?php echo $r1['codigo']."<br>".$r1['nombre']; ?></td>
                        <td><?php echo $r1['totalcom']; ?></td>
                        <?php if($r2['estado']==1 && accesoadm($cone,$_SESSION['identi'],16)){ ?>
                        <td>
                          <div class="btn-group btn-group-xs" role="group" aria-label="Basic">
                            <button type="button" class="btn btn-default" title="Editar" onclick="fo_rendiciones('edidoc',<?php echo $r1['idtegasto'].", ".$r2['trendicion']; ?>)"><i class="fa fa-pencil"></i></button>
                            <button type="button" class="btn btn-default" title="Mover" onclick="fo_rendiciones('movdoc',<?php echo $r1['idtegasto'].", ".$idr; ?>)"><i class="fa fa-retweet"></i></button>
                            <button type="button" class="btn btn-default" title="Eliminar" onclick="fo_rendiciones('elidoc',<?php echo $r1['idtegasto'].", ".$r2['trendicion']; ?>)"><i class="fa fa-trash"></i></button>
                          </div>
                        </td>
                        <?php } ?>
                      </tr>
<?php
                        $t=$t+$r1['totalcom'];
                      }
?>
                    </tbody>
                    <table class="table table-bordered table-hover">
                      <tr>
                        <th style="width: 85%;">TOTAL</th>
                        <th><?php echo number_format((float)$t, 2, '.', ''); ?></th>
                      </tr>
                    </table>
                  </table>
                  <script>
                    $('#dtable1').DataTable();
                  </script>
<?php
                  }else{
                    echo mensajewa("No se encontraron documentos para la rendición seleccionada.");
                  }
                  mysqli_free_result($c1);
        }elseif($r2['trendicion']==2){
                  $c1=mysqli_query($cone,"SELECT cs.idComServicios, cs.idEmpleado, cs.FechaIni, cs.FechaFin, cs.origen, cs.destino, cs.csivia, cs.orden, SUM(g.totalcom) monto FROM comservicios cs INNER JOIN doc d ON cs.idDoc=d.idDoc INNER JOIN tegasto g ON cs.idComServicios=g.idComServicios WHERE cs.idterendicion=$idr GROUP BY cs.idComServicios ORDER BY cs.orden, cs.csivia ASC;");
                  echo mysqli_error($cone);
                  if(mysqli_num_rows($c1)>0){
?>
                  <table class="table table-hover table-bordered" id="dtable2">
                    <thead>
                      <tr>
                        <th>ORDEN</th>
                        <th>SIVIA</th>
                        <th>NOMBRE</th>
                        <th>DESDE</th>
                        <th>HASTA</th>
                        <th>ORIGEN</th>
                        <th>DESTINO</th>
                        <th>TOTAL</th>
                        <?php if(accesocon($cone,$_SESSION['identi'],16) && $r2['estado']==1){ ?>
                        <th>ACCIÓN</th>
                        <?php } ?>
                      </tr>
                    </thead>
                    <tbody>
<?php
                      $su=0;
                      while($r1=mysqli_fetch_assoc($c1)){
                        $su=$su+$r1['monto'];
?>
                      <tr>
                        <td><?php echo $r1['orden'];; ?></td>
                        <td><?php echo $r1['csivia']; ?></td>
                        <td><?php echo nomempleado($cone, $r1['idEmpleado']); ?></td>
                        <td><?php echo ftnormal($r1['FechaIni']); ?></td>
                        <td><?php echo ftnormal($r1['FechaFin']); ?></td>
                        <td><?php echo $r1['origen']; ?></td>
                        <td><?php echo $r1['destino']; ?></td>
                        <td><?php echo n_2decimales($r1['monto']); ?></td>
                        <?php if(accesocon($cone,$_SESSION['identi'],16) && $r2['estado']==1){ ?>
                        <td>
                          <div class="btn-group btn-group-xs" role="group" aria-label="Basic">
                            <button type="button" class="btn btn-default" title="Orden" onclick="fo_rendiciones('ordvia',<?php echo $r1['idComServicios'].",0"; ?>)"><i class="fa fa-sort-numeric-asc"></i></button>
                            <button type="button" class="btn btn-default" title="Liberar" onclick="fo_rendiciones('libvia',<?php echo $r1['idComServicios'].",0"; ?>)"><i class="fa fa-external-link"></i></button>
                          </div>
                        </td>
                        <?php } ?>
                      </tr>
<?php
                      }
?>
                    </tbody>
                  </table>
                  <table class="table table-hover table-bordered">
                    <tr>
                      <th style="width: 85%;">TOTAL</th>
                      <th><?php echo n_2decimales($su); ?></th>
                    </tr>
                  </table>
                  <script>
                  	$('#dtable2').DataTable();
                  </script>
<?php
                  }else{
                    echo mensajewa("No se encontraron documentos para la rendición seleccionada.");
                  }
                  mysqli_free_result($c1);
        }
?>
      </div>
<?php
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