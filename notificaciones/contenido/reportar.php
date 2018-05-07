<?php
if(acceso($cone,$idusu,2)){
?>
          <!-- Forms Section-->
          <section class="forms"> 
            <div class="container-fluid">
              <div class="row">
                <!-- Resultado documentos registrados-->
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-header d-flex align-items-center">
                      <h3 class="h4">Mis documentos por reportar</h3>
                    </div>
                    <div class="card-body" id="d_mdocumento">
            
                      <?php
                      $cd=mysqli_query($cone, "SELECT * FROM documento WHERE idResponsable=$idusu AND (Estado=1 OR Estado=4) ORDER BY FecRegistro, idDocumento DESC;");
                      if(mysqli_num_rows($cd)>0){
                      ?>
                      <table class="table table-bordered table-hover" id="dt_reportar">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>N° Doc</th>
                            <th>Documento</th>
                            <th>F. Reg.</th>
                            <th>F. Rec.</th>
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
                            <td><small><?php echo fnormal($rd['FecRegistro']); ?></small></td>
                            <td><small><?php echo fnormal($rd['FecRecepcion']); ?></small></td>
                            <td><small><?php echo $rd['Origen']; ?></small></td>
                            <td><small><?php echo $rd['Destino']; ?></small></td>
                            <td><?php echo estadodoc($rd['Estado']); ?></td>
                            <td>
                              <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#m_redocumento" onclick="redocumento(<?php echo $rd['idDocumento']; ?>)" title="Reportar"><i class="fa fa-motorcycle"></i></button>
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
                        echo mensajewa("No tiene documentos para reportar");
                      }
                      mysqli_free_result($cd);
                      ?>


                    </div>
                  </div>
                </div>

              </div>
            </div>
          </section>


<?php
}else{
 echo mensajewa("Acceso restringido");
}
?>