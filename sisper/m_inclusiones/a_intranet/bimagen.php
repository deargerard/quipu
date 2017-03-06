<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],11)){
?>
                  <?php
                  $ccom=mysqli_query($cone,"SELECT * FROM slider ORDER BY idSlider ASC LIMIT 10");
                  if(mysqli_num_rows($ccom)>0){
                  ?>
                  <h3 class="text-maroon">Imagenes de carrusel.</h3>
                  <table class="table">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Imagen</th>
                        <th>Por</th>
                        <th>Estado</th>
                        <th>Acción</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $a=0;
                      while($rcom=mysqli_fetch_assoc($ccom)){
                        $a++;
                      ?>
                      <tr>
                        <td><?php echo $a; ?></td>
                        <td><a href="#" onclick="verimg(<?php echo $rcom['idSlider']; ?>)" data-toggle="modal" data-target="#m_vimagen"><?php echo $rcom['Imagen']; ?></a></td>
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
                              <li><a href="#" onclick="eliimg(<?php echo $rcom['idSlider']; ?>)" data-toggle="modal" data-target="#m_eimagen">Eliminar</a></li>
                              <?php if($rcom['Estado']==1){ ?>
                              <li><a href="#" onclick="desimg(<?php echo $rcom['idSlider']; ?>)" data-toggle="modal" data-target="#m_dimagen">Desactivar</a></li>
                              <?php }else{ ?>
                              <li><a href="#" onclick="actimg(<?php echo $rcom['idSlider']; ?>)" data-toggle="modal" data-target="#m_aimagen">Activar</a></li>
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
                  <?php
                  }else{
                    echo mensajewa("No existen imagenes.");
                  }
                  mysqli_free_result($ccom);
                  ?>
<?php
}else{
  echo accrestringidoa();
}
                  ?>