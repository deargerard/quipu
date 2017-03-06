<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],11)){
	if(isset($_POST['cat']) && !empty($_POST['cat'])){
		$cat=iseguro($cone,$_POST['cat']);
      $c=mysqli_query($cone,"SELECT CatDocumento FROM catdocumento WHERE idCatDocumento=$cat");
      if($r=mysqli_fetch_assoc($c)){

                  $cdoc=mysqli_query($cone,"SELECT * FROM documento WHERE idCatDocumento=$cat ORDER BY Descripcion ASC");
                  if(mysqli_num_rows($cdoc)>0){
                  ?>
                  <h3 class="text-maroon">Documentos de <?php echo $r['CatDocumento']; ?>.</h3>
                  <table class="table" id="dtdocumento">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Descripción</th>
                        <th>Documento</th>
                        <th>Por</th>
                        <th>Estado</th>
                        <th>Acción</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $a=0;
                      while($rdoc=mysqli_fetch_assoc($cdoc)){
                        $a++;
                      ?>
                      <tr>
                        <td><?php echo $a; ?></td>
                        <td><?php echo $rdoc['Descripcion']; ?></td>
                        <td><a href="<?php echo 'files_intranet/'.$rdoc['Adjunto']; ?>" target="_blank"><i class="fa fa-file-text-o"></i></a></td>
                        <td><?php echo nomempleado($cone, $rdoc['idEmpleado']); ?></td>
                        <td><?php echo estado($rdoc['Estado']); ?></td>
                        <td>
                          <div class="btn-group">
                            <button class="btn btn-warning btn-xs dropdown-toggle" data-toggle="dropdown">
                              <i class="fa fa-cog"></i>&nbsp;
                              <span class="caret"></span>
                              <span class="sr-only">Desplegar menú</span>
                            </button>
                            <ul class="dropdown-menu pull-right" role="menu">
                              <li><a href="#" onclick="edidoc(<?php echo $rdoc['idDocumento']; ?>)" data-toggle="modal" data-target="#m_edocumento">Editar Documento</a></li>
                              <li><a href="#" onclick="camdoc(<?php echo $rdoc['idDocumento']; ?>)" data-toggle="modal" data-target="#m_cdocumento">Cambiar Documento</a></li>
                              <?php if($rdoc['Estado']==1){ ?>
                              <li><a href="#" onclick="desdoc(<?php echo $rdoc['idDocumento']; ?>)" data-toggle="modal" data-target="#m_ddocumento">Desactivar</a></li>
                              <?php }else{ ?>
                              <li><a href="#" onclick="actdoc(<?php echo $rdoc['idDocumento']; ?>)" data-toggle="modal" data-target="#m_adocumento">Activar</a></li>
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
                    $('#dtdocumento').DataTable();
                  </script>
                  <?php
                  }else{
                    echo mensajewa("No existen documentos.");
                  }
                  mysqli_free_result($cdoc);
      }else{
        echo mensajeda("Error: No existe la categoría.");
      }
    }else{
    	echo mensajeda("Error: No se recibieron datos.");
    }
}else{
  echo accrestringidoa();
}
                  ?>