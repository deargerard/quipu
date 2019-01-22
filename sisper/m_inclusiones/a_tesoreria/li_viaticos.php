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
                        <h4 class="text-orange"><i class="fa fa-calendar text-gray"></i> Viáticos | <?php echo ucfirst(nombremes($mes))." de ".$anio; ?></h4>
                        <input type="hidden" id="mav" value="<?php echo $mes."/".$anio; ?>">
                      </td>
                    </tr>
                  </table>
<?php
                  $c1=mysqli_query($cone,"SELECT cs.idComServicios, cs.FechaIni, cs.FechaFin, cs.estadoren, cs.origen, cs.destino, e.ApellidoPat, e.ApellidoMat, e.nombres, d.Numero, d.Ano, d.Siglas FROM comservicios cs INNER JOIN empleado e ON cs.idEmpleado=e.idEmpleado INNER JOIN doc d ON cs.idDoc=d.idDoc WHERE DATE_FORMAT(FechaIni, '%Y-%m')='$anio-$mes' ORDER BY FechaIni DESC;");
                  if(mysqli_num_rows($c1)>0){
                  ?>
                  <table class="table table-hover table-bordered" id="dtable">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>NOMBRE</th>
                        <th>FECHAS</th>
                        <th>DOCUMENTO</th>
                        <th>ORIGEN</th>
                        <th>DESTINO</th>
                        <th>ESTADO RENDICIÓN</th>
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
                        <td style="font-size: 12px;"><?php echo $r1['ApellidoPat']." ".$r1['ApellidoMat']." ".$r1['nombres']; ?></td>
                        <td style="font-size: 9px;"><?php echo ftnormal($r1['FechaIni'])."<br>".ftnormal($r1['FechaFin']); ?></td>
                        <td style="font-size: 10px;"><?php echo $r1['Numero']."-".$r1['Ano']."<br>".$r1['Siglas']; ?></td>
                        <td style="font-size: 11px;"><?php echo $r1['origen']; ?></td>
                        <td style="font-size: 11px;"><?php echo $r1['destino']; ?></td>
                        <td><?php echo erviaticos($r1['estadoren']); ?></td>
                        <td>
                          <div class="btn-group btn-group-xs" role="group" aria-label="Basic">
                            <button type="button" class="btn btn-default" title="Planilla" onclick="fo_viaticos('verpla',<?php echo $r1['idComServicios']; ?>,0);"><i class="fa fa-file-text"></i></button>
                            <button type="button" class="btn btn-default" title="Comprobantes Rendición" onclick="fo_viaticos('vercom',<?php echo $r1['idComServicios']; ?>,0);"><i class="fa fa-file-text-o"></i></button>
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