<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],11)){
	if(isset($_POST['ano']) && !empty($_POST['ano'])){
		$ano=iseguro($cone,$_POST['ano']);

                  $cbol=mysqli_query($cone,"SELECT * FROM boletin WHERE DATE_FORMAT(Fecha,'%Y')=$ano ORDER BY Fecha DESC");
                  if(mysqli_num_rows($cbol)>0){
                  ?>
                  <h3 class="text-maroon">Boletines del <?php echo $ano; ?>.</h3>
                  <table class="table" id="dtboletin">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Descripción</th>
                        <th>Boletin</th>
                        <th>Fec. Publicación</th>
                        <th>Por</th>
                        <th>Estado</th>
                        <th>Acción</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $a=0;
                      while($rbol=mysqli_fetch_assoc($cbol)){
                        $a++;
                      ?>
                      <tr>
                        <td><?php echo $a; ?></td>
                        <td><?php echo $rbol['Descripcion']; ?></td>
                        <td><a href="<?php echo 'files_intranet/'.$rbol['Adjunto']; ?>" target="_blank"><i class="fa fa-file-pdf-o"></i></a></td>
                        <td><?php echo fnormal($rbol['Fecha']); ?></td>
                        <td><?php echo nomempleado($cone, $rbol['idEmpleado']); ?></td>
                        <td><?php echo estado($rbol['Estado']); ?></td>
                        <td>
                          <div class="btn-group">
                            <button class="btn btn-warning btn-xs dropdown-toggle" data-toggle="dropdown">
                              <i class="fa fa-cog"></i>&nbsp;
                              <span class="caret"></span>
                              <span class="sr-only">Desplegar menú</span>
                            </button>
                            <ul class="dropdown-menu pull-right" role="menu">
                              <li><a href="#" onclick="edibol(<?php echo $rbol['idBoletin']; ?>)" data-toggle="modal" data-target="#m_eboletin">Editar boletín</a></li>
                              <li><a href="#" onclick="cambol(<?php echo $rbol['idBoletin']; ?>)" data-toggle="modal" data-target="#m_cboletin">Cambiar boletín</a></li>
                              <?php if($rbol['Estado']==1){ ?>
                              <li><a href="#" onclick="desbol(<?php echo $rbol['idBoletin']; ?>)" data-toggle="modal" data-target="#m_dboletin">Desactivar</a></li>
                              <?php }else{ ?>
                              <li><a href="#" onclick="actbol(<?php echo $rbol['idBoletin']; ?>)" data-toggle="modal" data-target="#m_aboletin">Activar</a></li>
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
                    $('#dtboletin').DataTable();
                  </script>
                  <?php
                  }else{
                    echo mensajewa("No existen boletines para el año $ano.");
                  }
                  mysqli_free_result($cbol);

    }else{
    	echo mensajeda("Error: No se recibieron datos.");
    }
}else{
  echo accrestringidoa();
}
                  ?>