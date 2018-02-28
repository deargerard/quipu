<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],2)){

                      $ch=mysqli_query($cone,"SELECT * FROM horario ORDER BY idHorario DESC;");
                      if(mysqli_num_rows($ch)>0){
                      ?>
                        <br>
                        <table class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>HORARIO</th>
                              <th>R. MARCAR</th>
                              <th>H. ING.</th>
                              <th>H. SAL. REF.</th>
                              <th>H. ING. REF.</th>
                              <th>H. SAL.</th>
                              <th>S. SIG. DÍA</th>
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
                              <td><?php echo $rh['ReqMarcacion']==1 ? "Si" : "No"; ?></td>
                              <td><?php echo is_null($rh['Ingreso']) ? "" : date("H:i",strtotime($rh['Ingreso'])); ?></td>
                              <td><?php echo is_null($rh['SalidaRef']) ? "" : date("H:i",strtotime($rh['SalidaRef'])); ?></td>
                              <td><?php echo is_null($rh['IngresoRef']) ? "" : date("H:i",strtotime($rh['IngresoRef'])); ?></td>
                              <td><?php echo is_null($rh['Salida']) ? "" : date("H:i",strtotime($rh['Salida'])); ?></td>
                              <td><?php echo $rh['SalSigDia']==1 ? "Si" : "No"; ?></td>
                              <td><?php echo $rh['Estado']==1 ? "<span class='label label-success'>Activo</span>" : "<span class='label label-danger'>Cancelado</span>"; ?></td>
                              <?php if(accesoadm($cone,$_SESSION['identi'],2)){ ?>
                              <td><button class="btn btn-default btn-xs" data-toggle="modal" data-target="#m_esthorario" onclick="esthor(<?php echo $rh['idHorario']; ?>);"><i class="fa fa-toggle-on"></i> <?php echo $rh['Estado']==1 ? "Cancelar" : "Activar"; ?></button></td>
                              <?php } ?>
                            </tr>
                      <?php
                        }
                      ?>
                          </tbody>
                        </table>
                      <?php
                      }else{
                        echo mensajewa("No se encontraron turnos.");
                      }

}else{
  echo accrestringidoa();
}
                  ?>