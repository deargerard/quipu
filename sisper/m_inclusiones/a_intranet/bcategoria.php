<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],11)){
?>
                      <h3 class="text-maroon">Categorías</h3>
                      <?php
                        $ccat=mysqli_query($cone,"SELECT * FROM catdocumento ORDER BY CatDocumento ASC");
                        if(mysqli_num_rows($ccat)>0){
                      ?>
                        <table class="table" id="dtcategoria">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Categoría</th>
                              <th>Estado</th>
                              <th>Acción</th>                              
                            </tr>
                          </thead>
                          <tbody>
                      <?php
                        $b=0;
                        while($rcat=mysqli_fetch_assoc($ccat)){
                          $b++;
                      ?>
                            <tr>
                              <td><?php echo $b; ?></td>
                              <td><?php echo $rcat['CatDocumento']; ?></td>
                              <td><?php echo estado($rcat['Estado']); ?></td>
                              <td>
                                <div class="btn-group">
                                  <button class="btn btn-warning btn-xs dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-cog"></i>&nbsp;
                                    <span class="caret"></span>
                                    <span class="sr-only">Desplegar menú</span>
                                  </button>
                                  <ul class="dropdown-menu pull-right" role="menu">
                                    <li><a href="#" onclick="edicat(<?php echo $rcat['idCatDocumento']; ?>)" data-toggle="modal" data-target="#m_ecategoria">Editar Categoría</a></li>
                                    <?php if($rcat['Estado']==1){ ?>
                                    <li><a href="#" onclick="descat(<?php echo $rcat['idCatDocumento']; ?>)" data-toggle="modal" data-target="#m_dcategoria">Desactivar</a></li>
                                    <?php }else{ ?>
                                    <li><a href="#" onclick="actcat(<?php echo $rcat['idCatDocumento']; ?>)" data-toggle="modal" data-target="#m_acategoria">Activar</a></li>
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
                    $('#dtcategoria').DataTable();
                  </script>
                      <?php
                        }else{
                          echo mensajeda("Aun no existen categorías.");
                        }
}else{
  echo accrestringidoa();
}
                  ?>