<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],11)){
	if(isset($_POST['fecha1']) && !empty($_POST['fecha1']) && isset($_POST['fecha2']) && !empty($_POST['fecha2'])){
		$fec1=iseguro($cone,$_POST['fecha1']);
		$fec2=iseguro($cone,$_POST['fecha2']);
		$fech1=fmysql($fec1);
		$fech2=fmysql($fec2);
		if($fech2>=$fech1){

                  $cnot=mysqli_query($cone,"SELECT idNoticia, Fecha, Titular, Imagen, Estado, idEmpleado FROM noticia WHERE Fecha>='$fech1' AND Fecha<='$fech2' ORDER BY Fecha DESC");
                  if(mysqli_num_rows($cnot)>0){
                  ?>
                  <h3 class="text-maroon">Noticias del <?php echo $fec1; ?> al <?php echo $fec2; ?>.</h3>
                  <table class="table table-hover table-bordered" id="dtable">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Titular</th>
                        <th>Imagen</th>
                        <th>Por</th>
                        <th>Estado</th>
                        <th>Acción</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $c=0;
                      while($rnot=mysqli_fetch_assoc($cnot)){
                        $c++;
                        if($rnot['Imagen']==""){
                          $a=false;
                        }else{
                          $a=true;
                        }
                      ?>
                      <tr>
                        <td><?php echo $c; ?></td>
                        <td><?php echo fnormal($rnot['Fecha']); ?></td>
                        <td><?php echo $rnot['Titular']; ?></td>
                        <td><a href="files_intranet/<?php echo $rnot['Imagen']; ?>" target="_blank"><?php echo end(explode('_', $rnot['Imagen'])); ?></a></td>
                        <td><?php echo nomempleado($cone, $rnot['idEmpleado']); ?></td>
                        <td><?php echo estado($rnot['Estado']) ?></td>
                        <td>
                          <div class="btn-group">
                            <button class="btn btn-warning btn-xs dropdown-toggle" data-toggle="dropdown">
                              <i class="fa fa-cog"></i>&nbsp;
                              <span class="caret"></span>
                              <span class="sr-only">Desplegar menú</span>
                            </button>
                            <ul class="dropdown-menu pull-right" role="menu">
                              <li><a href="#" onclick="edinot(<?php echo $rnot['idNoticia']; ?>)" data-toggle="modal" data-target="#m_enoticia">Editar</a></li>
                              <li><a href="#" onclick="imanot(<?php echo $rnot['idNoticia']; ?>)" data-toggle="modal" data-target="#m_inoticia">Imagen</a></li>
                              <?php if($a){ ?>
                              <li><a href="#" onclick="estnot(<?php echo $rnot['idNoticia']; ?>)" data-toggle="modal" data-target="#m_esnoticia"><?php echo $rnot['Estado']==1 ? "Desactivar" : "Activar"; ?></a></li>
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
                    echo mensajewa("No existen noticias.");
                  }
                  mysqli_free_result($cnot);
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