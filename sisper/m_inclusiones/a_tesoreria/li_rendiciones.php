<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],16)){
	if(isset($_POST['fecb']) && !empty($_POST['fecb'])){
		$fecb=explode('/',iseguro($cone,$_POST['fecb']));
		if(checkdate($fecb[0],1,$fecb[1])){
      $mes=$fecb[0];
      $anio=$fecb[1];
?>
                  <br>
                  <table class="table table-bordered table-hover">
                    <tr>
                      <td>
                        <h4 class="text-orange"><i class="fa fa-calendar text-gray"></i> Rendiciones | <?php echo ucfirst(nombremes($mes))." de ".$anio; ?></h4>
                        <input type="hidden" id="ma" value="<?php echo $mes."/".$anio; ?>">
                      </td>
                      <td>
                        <?php if(accesoadm($cone,$_SESSION['identi'],16)){ ?>
                        <button type="button" class="btn btn-info btn-sm pull-right" onclick="fo_rendiciones('agrren',<?php echo $mes.",".$anio; ?>)"><i class="fa fa-plus"></i> Agregar</button>
                        <?php } ?>
                      </td>
                    </tr>
                  </table>
<?php
                  $c1=mysqli_query($cone,"SELECT r.*, m.nombre AS meta, f.nombre AS fondo, m.mnemonico FROM terendicion r INNER JOIN temeta m ON r.idtemeta=m.idtemeta INNER JOIN tefondo f ON m.idtefondo=f.idtefondo WHERE r.anio=$anio AND r.mes=$mes ORDER BY codigo DESC;");
                  if(mysqli_num_rows($c1)>0){
                  ?>
                  
                  <table class="table table-hover table-bordered" id="dtable">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>CÓDIGO</th>
                        <th>FONDO / META</th>
                        <th>T. RENDICIÓN</th>
                        <th>POR</th>
                        <th>ESTADO</th>
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
                        <td><?php echo $r1['codigo']; ?></td>
                        <td><?php echo $r1['fondo']." / ".$r1['meta']." (".$r1['mnemonico'].")"; ?></td>
                        <td><?php echo $r1['trendicion']==2 ? "VIÁTICOS" : ($r1['trendicion']==1 ? "FOND. Y PROG." : "" ); ?></td>
                        <td><?php echo nomempleado($cone, $r1['empleado']); ?></td>
                        <td><?php echo $r1['estado']==1 ? "<span class='label label-warning'>Abierta</span>" : "<span class='label label-success'>Archivada</span>"; ?></td>
                        <td>
                          <div class="btn-group btn-group-xs" role="group" aria-label="Basic">
                            <?php if(accesoadm($cone,$_SESSION['identi'],16)){ ?>
                            <button type="button" class="btn btn-default" title="Editar" onclick="fo_rendiciones('ediren',<?php echo $r1['idterendicion'].",0"; ?>)"><i class="fa fa-pencil"></i></button>
                            <button type="button" class="btn btn-default" title="Cambiar de mes" onclick="fo_rendiciones('mesren',<?php echo $r1['idterendicion'].", ".$r1['codigo']; ?>)"><i class="fa fa-calendar"></i></button>
                            <?php } ?>
                            <button type="button" class="btn btn-default" title="Ir a documentos" onclick="ldocrendiciones(<?php echo $r1['idterendicion']; ?>);"><i class="fa fa-chevron-circle-right"></i></button>
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
                    echo mensajewa("No se encontraron rendiciones para el mes seleccionado.");
                  }
                  mysqli_free_result($c1);
        }else{
        	echo mensajeda("Error: La fecha ingresada no es válida.");
        }
    }else{
    	echo mensajeda("Error: No se recibieron datos.");
    }
}else{
  echo accrestringidoa();
}
?>