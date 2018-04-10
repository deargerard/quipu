<?php
session_start();
include 'cone.php';
include 'func.php';
include '../const.php';
$idusu=$_SESSION['idusu'];
if(isset($_SESSION['nusu']) && !empty($_SESSION['nusu']) && isset($_SESSION['idusu']) && !empty($_SESSION['idusu'])){
	if(isset($_POST['pera']) && !empty($_POST['pera']) && isset($_POST['esta']) && !empty($_POST['esta']) && isset($_POST['fecia']) && !empty($_POST['fecfa']) && isset($_POST['tfeca']) && !empty($_POST['tfeca'])){
		$pera=iseguro($cone,$_POST['pera']);
		$esta=iseguro($cone,$_POST['esta']);
		$fecia=fmysql(iseguro($cone,$_POST['fecia']));
		$fecfa=fmysql(iseguro($cone,$_POST['fecfa']));
		$tfeca=iseguro($cone,$_POST['tfeca']);

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
                      <table class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>N° Doc</th>
                            <th>Documento</th>
                            <th class="text-info"><?php echo $tfb; ?></th>
                            <th>Asignador</th>
                            <th>Origen</th>
                            <th>Destino</th>
                            <th>Estado</th>
                            <th>Acciones</th>
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
                            <td><small><?php echo fnormal($rd[$tf]); ?></small></td>
                            <td><small><?php echo nomusuario($cone, $rd['idAsignador']); ?></small></td>
                            <td><small><?php echo $rd['Origen']; ?></small></td>
                            <td><small><?php echo $rd['Destino']; ?></small></td>
                            <td><?php echo estadodoc($rd['Estado']); ?></td>
                            <td>
                              
                              <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                              	<?php if(($rd['Estado']==1 || $rd['Estado']==4) && acceso($cone,$idusu,1)){ ?>
	                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#m_eddocumento" onclick="eddocumento('asi',<?php echo $rd['idDocumento']; ?>)" title="Editar"><i class="fa fa-edit"></i></button>
	                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#m_eldocumento" onclick="eldocumento('asi',<?php echo $rd['idDocumento']; ?>)" title="Eliminar"><i class="fa fa-trash"></i></button>
                                <?php } ?>
	                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#m_dedocumento" onclick="dedocumento(<?php echo $rd['idDocumento']; ?>)" title="Detalle"><i class="fa fa-file-text-o"></i></button>
	                            <?php if(($rd['Estado']==2 || $rd['Estado']==3) && acceso($cone,$idusu,1)){ ?>
	                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#m_readocumento" onclick="readocumento('asi',<?php echo $rd['idDocumento']; ?>)" title="Reabrir"><i class="fa fa-folder-open"></i></button>
	                            <?php } ?>
                              </div>
                            </td>
                          </tr>
                      <?php
                        }
                      ?>
                        </tbody>
                      </table>
                      <?php
                      }else{
                        echo mensajewa("No se hallaron resultados");
                      }
                      mysqli_free_result($cd);





	}else{
		echo mensajewa("Todos los campos son obligatorios");
	}
}else{
	echo mensajewa("Acceso restaringido");
}