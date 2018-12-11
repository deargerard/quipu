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
      function erviaticos($est){
        switch ($est) {
          case 0:
            return "<span class='label label-danger'>Pendiente</span>";
            break;
          case 1:
            return "<span class='label label-info'>Enviado</span>";
            break;
          case 2:
            return "<span class='label label-warning'>Observado</span>";
            break;
          case 3:
            return "<span class='label label-success'>Rendido</span>";
            break;
        }
      }
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
                  $c1=mysqli_query($cone,"SELECT cs.idComServicios, cs.FechaIni, cs.FechaFin, cs.estadoren, cs.idDistrito, e.ApellidoPat, e.ApellidoMat, e.nombres FROM comservicios cs INNER JOIN empleado e ON cs.idEmpleado=e.idEmpleado WHERE DATE_FORMAT(FechaIni, '%Y-%m')='$anio-$mes' ORDER BY FechaIni DESC;");
                  if(mysqli_num_rows($c1)>0){
                  ?>
                  <table class="table table-hover table-bordered" id="dtable">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>NOMBRE</th>
                        <th>DESDE</th>
                        <th>HASTA</th>
                        <th>LUGAR</th>
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
                        <td><?php echo $r1['ApellidoPat']." ".$r1['ApellidoMat']." ".$r1['nombres']; ?></td>
                        <td><?php echo ftnormal($r1['FechaIni']); ?></td>
                        <td><?php echo ftnormal($r1['FechaFin']); ?></td>
                        <td><?php echo disprodep($cone, $r1['idDistrito']); ?></td>
                        <td><?php echo erviaticos($r1['estadoren']); ?></td>
                        <td>
                          <div class="btn-group btn-group-xs" role="group" aria-label="Basic">
                            <button type="button" class="btn btn-default" title="Planilla" onclick="fo_viaticos('verpla',<?php echo $r1['idComServicios']; ?>,0);"><i class="fa fa-file-text"></i></button>
                            <button type="button" class="btn btn-default" title="Rendición" onclick="fo_viaticos('vercom',<?php echo $r1['idComServicios']; ?>,0);"><i class="fa fa-file-text-o"></i></button>
                            <button type="button" class="btn btn-default" title="Info" onclick="fo_viaticos('verinf',<?php echo $r1['idComServicios']; ?>,0);"><i class="fa fa-info-circle"></i></button>
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