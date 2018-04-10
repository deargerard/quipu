<?php
session_start();
include 'cone.php';
include 'func.php';
include '../const.php';
$idusu=$_SESSION['idusu'];
if(acceso($cone,$idusu,1)){
                      $cd=mysqli_query($cone, "SELECT * FROM documento WHERE idAsignador=$idusu AND FecRegistro=DATE_FORMAT(NOW(), '%Y-%m-%d') ORDER BY idDocumento DESC;");
                      if(mysqli_num_rows($cd)>0){
?>
                      <table class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>N° Doc</th>
                            <th>Documento</th>
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
                            <td><small><?php echo nomusuario($cone, $rd['idResponsable']); ?></small></td>
                            <td><small><?php echo $rd['Origen']; ?></small></td>
                            <td><small><?php echo $rd['Destino']; ?></small></td>
                            <td><?php echo estadodoc($rd['Estado']); ?></td>
                            <td>
                              <?php if($rd['Estado']==1){ ?>
                              <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#m_eddocumento" onclick="eddocumento('doc',<?php echo $rd['idDocumento']; ?>)" title="Editar"><i class="fa fa-edit"></i></button>
                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#m_eldocumento" onclick="eldocumento('doc',<?php echo $rd['idDocumento']; ?>)" title="Eliminar"><i class="fa fa-trash"></i></button>
                              </div>
                              <?php } ?>
                            </td>
                          </tr>
                      <?php
                        }
                      ?>
                        </tbody>
                      </table>
<?php
                      }else{
                        echo mensajewa("Aún no ha resgistrado ningún documento");
                      }
                      mysqli_free_result($cd);
}else{
  echo mensajewa("Acceso restingido.");
}
?>