<?php
session_start();
include 'cone.php';
include 'func.php';
include '../const.php';
$idusu=$_SESSION['idusu'];
$fecha=date("dmyHi");
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=Exportar_$fecha.xls");
header("Pragma: no-cache");
header("Expires: 0");
if(isset($_SESSION['nusu']) && !empty($_SESSION['nusu']) && isset($_SESSION['idusu']) && !empty($_SESSION['idusu'])){
	if(isset($_GET['pera']) && !empty($_GET['pera']) && isset($_GET['esta']) && !empty($_GET['esta']) && isset($_GET['fecia']) && !empty($_GET['fecfa']) && isset($_GET['tfeca']) && !empty($_GET['tfeca'])){
		$pera=iseguro($cone,$_GET['pera']);
		$esta=iseguro($cone,$_GET['esta']);
		$fecia=fmysql(iseguro($cone,$_GET['fecia']));
		$fecfa=fmysql(iseguro($cone,$_GET['fecfa']));
		$tfeca=iseguro($cone,$_GET['tfeca']);

		if($pera=="t"){
			$pe="";
		}else{
			$pe="AND idAsignador=$pera";
		}

		switch ($tfeca) {
			case 'frega':
				$tf='FecRegistro';
				$tfb='Fec Registro';
				break;

			case 'freca':
				$tf='FecRecepcion';
				$tfb='Fec Recepción';
				break;

			case 'fnota':
				$tf='FecNotificacion';
				$tfb='Fec Not./Dev.';
				break;

			case 'frepa':
				$tf='FecDevolucion';
				$tfb='Fec Reporte';
				break;

		}

		if($esta=="t"){
			$es="";
		}else{
			$es="AND Estado=$esta";
		}


					  $q="SELECT * FROM documento WHERE ($tf BETWEEN '$fecia' AND '$fecfa') $pe $es ORDER BY $tf DESC;";
                      $cd=mysqli_query($cone, $q);
                      if(mysqli_num_rows($cd)>0){
                      ?>
                      <table border="1">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Num Doc</th>
                            <th>Documento</th>
                            <th>Origen</th>
                            <th>Destino</th>
                            <th>Responsable</th>
                            <th>Asignador</th>
                            <th>F. Recepci&oacute;n</th>
                            <th>F. Registro</th>
                            <th>F. Not./Dev.</th>
                            <th>F. Reporte</th>
                            <th>Estado</th>
                            <th>Modo Notificaci&oacute;n</th>
                            <th>Reabierto</th>
                            <th>Observaciones</th>
                          </tr>
                        </thead>
                        <tbody>

                      <?php
                        $n=0;
                        while($rd=mysqli_fetch_assoc($cd)){
                          $n++;
                      ?>
                          <tr>
                            <td><?php echo $n; ?></td>
                            <td><small><?php echo 'D-'.$rd['idDocumento']; ?></small></td>
                            <td><small><?php echo $rd['Documento']; ?></small></td>
                            <td><small><?php echo $rd['Origen']; ?></small></td>
                            <td><small><?php echo $rd['Destino']; ?></small></td>
                            <td><small><?php echo nomusuario($cone,$rd['idResponsable']); ?></small></td>
                            <td><small><?php echo nomusuario($cone, $rd['idAsignador']); ?></small></td>
                            <td><small><?php echo fnormal($rd['FecRecepcion']); ?></small></td>
                            <td><small><?php echo fnormal($rd['FecRegistro']); ?></small></td>
                            <td><small><?php echo fnormal($rd['FecNotificacion']); ?></small></td>
                            <td><small><?php echo fnormal($rd['FecDevolucion']); ?></small></td>
                            <td><small><?php echo estadodoc($rd['Estado']); ?></small></td>
                            <td><small><?php echo modnotificacion($rd['ModNotificacion']); ?></small></td>
                            <td><small><?php echo $rd['Reabierto']==1 ? "Si" : "No"; ?></small></td>
                            <td><small><?php echo $rd['Observaciones']; ?></small></td>
                          </tr>
                      <?php
                        }
                      ?>
                        </tbody>
                      </table>
                      <?php
                      }else{
                        echo "No se hallaron resultados";
                      }
                      mysqli_free_result($cd);





	}else{
		echo "Todos los campos son obligatorios";
	}
}else{
	echo "Acceso restaringido";
}