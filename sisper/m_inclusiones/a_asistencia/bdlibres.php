<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],2)){
  if(isset($_POST['anodl']) && !empty($_POST['anodl'])){
    $anodl=iseguro($cone, $_POST['anodl']);

                      $ch=mysqli_query($cone,"SELECT * FROM dialibre WHERE DATE_FORMAT(Fecha, '%Y')='$anodl' ORDER BY idDiaLibre DESC;");
                      if(mysqli_num_rows($ch)>0){
                      ?>
                        <br>
                        <table class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>DESCRIPCIÓN</th>
                              <th>FECHA</th>
                              <th>REGISTRADA POR</th>
                              <th>ESTADO</th>
                              <?php if(accesoadm($cone,$_SESSION['identi'],2)){ ?>
                              <th>ACCIÓN</th>
                              <?php } ?>
                            </tr>
                          </thead>
                          <tbody>
                      <?php
                      $n=0;
                        while ($rh=mysqli_fetch_assoc($ch)) {
                          $n++;
                      ?>
                            <tr>
                              <td><?php echo $n; ?></td>
                              <td><?php echo $rh['Descripcion']; ?></td>
                              <td><?php echo fnormal($rh['Fecha']); ?></td>
                              <td><?php echo nomempleado($cone, $rh['Por']); ?></td>
                              <td><?php echo $rh['Estado']==1 ? "<span class='label label-success'>Activo</span>" : "<span class='label label-danger'>Cancelado</span>"; ?></td>
                              <?php if(accesoadm($cone,$_SESSION['identi'],2)){ ?>
                              <td><button class="btn btn-default btn-xs" data-toggle="modal" data-target="#m_estdlibre" onclick="estdlib(<?php echo $rh['idDiaLibre']; ?>);"><i class="fa fa-toggle-on"></i> <?php echo $rh['Estado']==1 ? "Cancelar" : "Activar"; ?></button></td>
                              <?php } ?>
                            </tr>
                      <?php
                        }
                      ?>
                          </tbody>
                        </table>
                      <?php
                      }else{
                        echo mensajewa("No se encontraron dias libres.");
                      }
  }else{
    echo mensajewa("Elija un año.");
  }
}else{
  echo accrestringidoa();
}
                  ?>