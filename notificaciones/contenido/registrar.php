<?php
if(acceso($cone,$idusu,1)){
?>
          <!-- Forms Section-->
          <section class="forms"> 
            <div class="container-fluid">
              <div class="row">
                <!-- Formulario Documento-->
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-header d-flex align-items-center">
                      <h3 class="h4">Registrar y asignar documento</h3>
                    </div>
                    <div class="card-body" id="f_documento">


                      <form id="f_regasi">
                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label for="per">Personal</label>
                            <select class="form-control" name="per" id="per">
                            <?php
                              $cp=mysqli_query($cone, "SELECT u.idUsuario, Nombres, Apellidos FROM usuario u INNER JOIN modusu mu ON u.idUsuario=mu.idUsuario WHERE u.Estado=1 AND mu.idModulo=2 ORDER BY Apellidos, Nombres DESC;");
                              if(mysqli_num_rows($cp)>0){
                                while ($rp=mysqli_fetch_assoc($cp)) {
                            ?>
                              <option value="<?php echo $rp['idUsuario'] ?>"><?php echo $rp['Apellidos'].", ".$rp['Nombres']; ?></option>
                            <?php
                                }
                              }
                              mysqli_free_result($cp);
                            ?>
                            </select>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="doc">Documento</label>
                            <input type="text" class="form-control" name="doc" id="doc" placeholder="Documento">
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label for="ori">Origen</label>
                            <input type="text" class="form-control" name="ori" id="ori" placeholder="Origen">
                          </div>
                          <div class="form-group col-md-6">
                            <label for="des">Destino</label>
                            <input type="text" class="form-control" name="des" id="des" placeholder="Destino">
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label for="fec">Fecha de recepción</label>
                            <input type="text" class="form-control" name="fec" id="fec" value="<?php echo date("d/m/Y") ?>">
                          </div>
                        </div>
                        <button type="button" class="btn btn-primary" id="b_regasi">Registrar/Asignar</button>
                        <br><br>
                        <div id="r_regasi"></div>
                      </form>


                    </div>
                  </div>
                </div>
                <!-- Resultado documentos registrados-->
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-header d-flex align-items-center">
                      <h3 class="h4">Documentos registrados hoy (<?php echo date("d/m/Y"); ?>)</h3>
                    </div>
                    <div class="card-body" id="d_documento">
            
                      <?php
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