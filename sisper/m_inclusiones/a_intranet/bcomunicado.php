<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],11)){
	if(isset($_POST['fech1']) && !empty($_POST['fech1']) && isset($_POST['fech2']) && !empty($_POST['fech2'])){
		$fec1=iseguro($cone,$_POST['fech1']);
		$fec2=iseguro($cone,$_POST['fech2']);
		$fech1=fmysql($fec1);
		$fech2=fmysql($fec2);
		if($fech2>=$fech1){

                  $ccom=mysqli_query($cone,"SELECT * FROM comunicado WHERE Fecha>='$fech1' AND Fecha<='$fech2' ORDER BY Fecha DESC");
                  if(mysqli_num_rows($ccom)>0){
                  ?>
                  <h3 class="text-maroon">Comunicados del <?php echo $fec1; ?> al <?php echo $fec2; ?>.</h3>
                  <table class="table table-hover table-bordered" id="dtable">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Descripción</th>
                        <th>Adjunto</th>
                        <th>Por</th>
                        <th>Estado</th>
                        <th>Acción</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $c=0;
                      while($rcom=mysqli_fetch_assoc($ccom)){
                        $c++;
                        if($rcom['Adjunto']==""){
                          $a=false;
                        }else{
                          $a=true;
                        }
                      ?>
                      <tr>
                        <td><?php echo $c; ?></td>
                        <td><?php echo fnormal($rcom['Fecha']); ?></td>
                        <td><a href="#" data-toggle="modal" data-target="#m_vcomunicado" onclick="vcomunicado(<?php echo $rcom["idComunicado"] ?>)"><?php echo $rcom['Descripcion']; ?></a></td>
                        <td><a href="files_intranet/<?php echo $rcom['Adjunto']; ?>" target="_blank"><?php echo end(explode('_', $rcom['Adjunto'])); ?></a></td>
                        <td><?php echo nomempleado($cone, $rcom['idEmpleado']); ?></td>
                        <td><?php echo estado($rcom['Estado']) ?></td>
                        <td>
                          <div class="btn-group">
                            <button class="btn btn-warning btn-xs dropdown-toggle" data-toggle="dropdown">
                              <i class="fa fa-cog"></i>&nbsp;
                              <span class="caret"></span>
                              <span class="sr-only">Desplegar menú</span>
                            </button>
                            <ul class="dropdown-menu pull-right" role="menu">
                              <li><a href="#" onclick="edicom(<?php echo $rcom['idComunicado']; ?>)" data-toggle="modal" data-target="#m_ecomunicado">Editar</a></li>
                              <?php if(!$a){ ?>
                              <li><a href="#" onclick="agradj(<?php echo $rcom['idComunicado']; ?>)" data-toggle="modal" data-target="#m_aadjunto">Adjuntar</a></li>
                              <?php }else{ ?>
                              <li><a href="#" onclick="quiadj(<?php echo $rcom['idComunicado']; ?>)" data-toggle="modal" data-target="#m_qadjunto">Quitar Adjunto</a></li>
                              <?php } ?>
                              <?php if($rcom['Estado']==1){ ?>
                              <li><a href="#" onclick="descom(<?php echo $rcom['idComunicado']; ?>)" data-toggle="modal" data-target="#m_dcomunicado">Desactivar</a></li>
                              <?php }else{ ?>
                              <li><a href="#" onclick="actcom(<?php echo $rcom['idComunicado']; ?>)" data-toggle="modal" data-target="#m_acomunicado">Activar</a></li>
                              <?php } ?>
                            </ul>
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
                    echo mensajewa("No existen comunicados.");
                  }
                  mysqli_free_result($ccom);
        }else{
        	echo mensajeda("Error: La primera fecha debe ser anterior a la segunda.");
        }
    }else{
    	echo mensajeda("Error: No se recibieron datos.");
    }
}else{
  echo accrestringidoa();
}
                  ?>