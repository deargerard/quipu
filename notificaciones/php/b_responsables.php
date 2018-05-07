<?php
session_start();
include 'cone.php';
include 'func.php';
include '../const.php';
$idusu=$_SESSION['idusu'];
if(isset($_SESSION['nusu']) && !empty($_SESSION['nusu']) && isset($_SESSION['idusu']) && !empty($_SESSION['idusu'])){
	if(isset($_POST['per']) && !empty($_POST['per']) && isset($_POST['est']) && !empty($_POST['est']) && isset($_POST['feci']) && !empty($_POST['fecf']) && isset($_POST['tfec']) && !empty($_POST['tfec'])){
		$per=iseguro($cone,$_POST['per']);
		$est=iseguro($cone,$_POST['est']);
		$feci=fmysql(iseguro($cone,$_POST['feci']));
		$fecf=fmysql(iseguro($cone,$_POST['fecf']));
		$tfec=iseguro($cone,$_POST['tfec']);

		if($per=="t"){
			$pe="";
		}else{
			$pe="AND idResponsable=$per";
		}

		switch ($tfec) {
			case 'freg':
				$tf='FecRegistro';
				$tfb='Fec Registro';
				break;

			case 'frec':
				$tf='FecRecepcion';
				$tfb='Fec Recepción';
				break;

			case 'fnot':
				$tf='FecNotificacion';
				$tfb='Fec Not./Dev.';
				break;

			case 'frep':
				$tf='FecDevolucion';
				$tfb='Fec Reporte';
				break;

		}

		if($est=="t"){
			$es="";
		}else{
			$es="AND Estado=$est";
		}




					  $q="SELECT * FROM documento WHERE ($tf BETWEEN '$feci' AND '$fecf') $pe $es ORDER BY $tf DESC;";
                      $cd=mysqli_query($cone, $q);
                      if(mysqli_num_rows($cd)>0){
                      ?>
                      <table class="table table-bordered table-hover" id="dt_responsables">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>N° Doc</th>
                            <th>Documento</th>
                            <th class="text-info"><?php echo $tfb; ?></th>
                            <th>Responsable</th>
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
                            <td><small><?php echo nomusuario($cone, $rd['idResponsable']); ?></small></td>
                            <td><small><?php echo $rd['Origen']; ?></small></td>
                            <td><small><?php echo $rd['Destino']; ?></small></td>
                            <td><?php echo estadodoc($rd['Estado']); ?></td>
                            <td>
                              
                              <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                              	<?php if(($rd['Estado']==1 || $rd['Estado']==4) && acceso($cone,$idusu,1)){ ?>
	                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#m_eddocumento" onclick="eddocumento('res',<?php echo $rd['idDocumento']; ?>)" title="Editar"><i class="fa fa-edit"></i></button>
	                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#m_eldocumento" onclick="eldocumento('res',<?php echo $rd['idDocumento']; ?>)" title="Eliminar"><i class="fa fa-trash"></i></button>
                                <?php } ?>
	                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#m_dedocumento" onclick="dedocumento(<?php echo $rd['idDocumento']; ?>)" title="Detalle"><i class="fa fa-file-text-o"></i></button>
	                            <?php if(($rd['Estado']==2 || $rd['Estado']==3) && acceso($cone,$idusu,1)){ ?>
	                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#m_readocumento" onclick="readocumento('res',<?php echo $rd['idDocumento']; ?>)" title="Reabrir"><i class="fa fa-folder-open"></i></button>
	                            <?php } ?>
                              </div>
                            </td>
                          </tr>
                      <?php
                        }
                      ?>
                        </tbody>
                      </table>
                      <script>
                        $("#dt_responsables").DataTable({
                          dom: 'Bfrtip',
                          buttons: [
                            {
                                extend: 'copy',
                                text: '<i class="fa fa-copy"></i>',
                                titleAttr: 'Copiar'
                            },
                            {
                                extend: 'csv',
                                text: '<i class="fa fa-file-text-o"></i>',
                                titleAttr: 'CSV'
                            },
                            {
                                extend: 'excel',
                                text: '<i class="fa fa-file-excel-o"></i>',
                                titleAttr: 'Excel'
                            },
                            {
                                extend: 'pdf',
                                text: '<i class="fa fa-file-pdf-o"></i>',
                                titleAttr: 'PDF'
                            },
                            {
                                extend: 'print',
                                text: '<i class="fa fa-print"></i>',
                                titleAttr: 'Imprimir'
                            }
                          ]
                        });
                      </script>
                      <?php
                      }else{
                        echo mensajewa("No se hallaron resultados");
                      }
                      mysqli_free_result($cd);





	}else{
		echo mensajewa("Todos los campos son obligatorios");
	}
}else{
	echo mensajewa("Acceso restringido");
}