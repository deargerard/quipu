<?php
if(acceso($cone,$idusu,3)){
?>
          <!-- Forms Section-->
          <section class="forms"> 
            <div class="container-fluid">
              <div class="row">
                <!-- Formulario Documento-->
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-header d-flex align-items-center">
                      <h3 class="h4">Generar guía</h3>
                    </div>
                    <div class="card-body" id="f_guia">        

                      <form class="form-inline" id="f_geguia">
                        <label class="sr-only" for="des">Destino</label>
                        <select class="form-control mb-2 mr-sm-2 mb-sm-0" name="des" id="des" style="width: 350px;">
                          <option value="">DESTINO</option>
                          <?php
                          $cd=mysqli_query($cone,"SELECT * FROM destino WHERE Estado=1");
                          if(mysqli_num_rows($cd)>0){
                            while($rd=mysqli_fetch_assoc($cd)){
                          ?>
                          <option value="<?php echo $rd['idDestino']; ?>"><?php echo $rd['Destino']; ?></option>
                          <?php
                            }
                          }
                          ?>
                        </select>
                        <label class="sr-only" for="fec">Fecha</label>
                        <input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" name="fec" id="fec" placeholder="Fecha" value="<?php echo date("d/m/Y") ?>">

                        <button type="button" class="btn btn-primary" id="b_geguia">Generar Guía</button>
                        <div id="r_geguia" style="margin: 0 0 0 8px;">

                        </div>

                      </form>

                    </div>
                  </div>
                </div>
                <!-- Resultado documentos registrados-->
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-header d-flex align-items-center">
                      <h3 class="h4">Últimas guías</h3>
                    </div>
                    <div class="card-body" id="d_guia">
            
                      <?php
                      $cd=mysqli_query($cone, "SELECT g.*, d.Destino FROM guia g INNER JOIN destino d ON g.idDestino=d.idDestino ORDER BY idGuia DESC LIMIT 40;");
                      if(mysqli_num_rows($cd)>0){
                      ?>
                      <table class="table table-bordered table-hover" id="dt_guia">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Guía</th>
                            <th>Destino</th>
                            <th>Fecha</th>
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
                            <td><?php echo $rd['Numero']."-".date("Y", strtotime($rd['Fecha'])); ?></td>
                            <td><?php echo $rd['Destino']; ?></td>
                            <td><?php echo fnormal($rd['Fecha']); ?></td>
                            <td>

                              <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#m_edguia" onclick="edguia(<?php echo $rd['idGuia']; ?>)" title="Editar"><i class="fa fa-edit"></i></button>
                                <a href="indoc.php?guia=<?php echo $rd["idGuia"]; ?>" class="btn btn-secondary" title="Ver/Ingresar documentos"><i class="fa fa-chevron-circle-right"></i></a>
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
                        echo mensajewa("Aún no ha resgistrado ninguna guía");
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