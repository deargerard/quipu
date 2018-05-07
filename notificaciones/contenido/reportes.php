<?php
if(isset($_SESSION['nusu']) && !empty($_SESSION['nusu']) && isset($_SESSION['idusu']) && !empty($_SESSION['idusu'])){
?>
          <!-- Forms Section-->
          <section class="forms"> 
            <div class="container-fluid">
              <div class="row">
                <!-- Formulario Documento-->
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-header d-flex align-items-center">
                      <h3 class="h4">Consultas</h3>
                    </div>
                    <div class="card-body" id="f_documento">




                      <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active" id="home-tab" data-toggle="tab" href="#responsables" role="tab" aria-controls="home" aria-selected="true">Responsables</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="profile-tab" data-toggle="tab" href="#asignadores" role="tab" aria-controls="profile" aria-selected="false">Asignadores</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="profile-tab" data-toggle="tab" href="#bdocumento" role="tab" aria-controls="profile" aria-selected="false">Buscar Documento</a>
                        </li>
                      </ul>
                      <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="responsables" role="tabpanel" aria-labelledby="home-tab">
                          <br>
                          <form id="f_rresponsables">
                              <div class="form-row">
                                <div class="form-group col-md-6">
                                  <label for="per">Personal</label>
                                  <select class="form-control" name="per" id="per">
                                    <option value="t">TODOS</option>
                                  <?php
                                    $cp=mysqli_query($cone, "SELECT u.idUsuario, Nombres, Apellidos FROM usuario u INNER JOIN modusu mu ON u.idUsuario=mu.idUsuario WHERE mu.idModulo=2 AND mu.Estado=1 AND u.Estado=1 ORDER BY Apellidos, Nombres DESC;");
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
                                <div class="form-group col-md-2">
                                  <label for="est">Estado</label>
                                  <select class="form-control" name="est" id="est">
                                    <option value="t">Todos</option>
                                    <option value="1">Pendiente</option>
                                    <option value="2">Notificado</option>
                                    <option value="3">Devuelto</option>
                                    <option value="4">Reabierto</option>
                                    <option value="5">Eliminado</option>
                                  </select>
                                </div>
                                <div class="form-group col-md-2">
                                  <label for="feci">Fecha Inicial</label>
                                  <input type="text" class="form-control" name="feci" id="feci">
                                </div>
                                <div class="form-group col-md-2">
                                  <label for="fecf">Fecha Final</label>
                                  <input type="text" class="form-control" name="fecf" id="fecf">
                                </div>
                              </div>
                              <div class="form-row">
                                <div class="form-group col-md-3">
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tfec" id="freg" value="freg">
                                    <label class="form-check-label" for="freg">F. Registro</label>
                                  </div>
                                </div>
                                <div class="form-group col-md-3">
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tfec" id="frec" value="frec">
                                    <label class="form-check-label" for="frec">F. Recepción</label>
                                  </div>
                                </div>
                                <div class="form-group col-md-3">
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tfec" id="fnot" value="fnot">
                                    <label class="form-check-label" for="fnot">F. Not./Dev.</label>
                                  </div>
                                </div>
                                <div class="form-group col-md-3">
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tfec" id="frep" value="frep">
                                    <label class="form-check-label" for="frep">F. Reporte</label>
                                  </div>
                                </div>
                              </div>
                              <button type="submit" class="btn btn-primary" id="b_responsables">Buscar</button>
                              <button type="button" class="btn btn-info" id="b_eresponsables">Exportar</button>
                              <br><br>
                              <div id="r_responsables"></div>
                            </form>


                        </div>
                        <div class="tab-pane fade" id="asignadores" role="tabpanel" aria-labelledby="profile-tab">
                          <br>
                          <form id="f_rasignadores">
                              <div class="form-row">
                                <div class="form-group col-md-6">
                                  <label for="pera">Personal</label>
                                  <select class="form-control" name="pera" id="pera">
                                    <option value="t">Todos</option>
                                  <?php
                                    $cp=mysqli_query($cone, "SELECT u.idUsuario, Nombres, Apellidos FROM usuario u INNER JOIN modusu mu ON u.idUsuario=mu.idUsuario WHERE mu.idModulo=1 AND mu.Estado=1 AND u.Estado=1 ORDER BY Apellidos, Nombres DESC;");
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
                                <div class="form-group col-md-2">
                                  <label for="esta">Estado</label>
                                  <select class="form-control" name="esta" id="esta">
                                    <option value="t">Todos</option>
                                    <option value="1">Pendiente</option>
                                    <option value="2">Notificado</option>
                                    <option value="3">Devuelto</option>
                                    <option value="4">Reabierto</option>
                                    <option value="5">Eliminado</option>
                                  </select>
                                </div>
                                <div class="form-group col-md-2">
                                  <label for="fecia">Fecha Inicial</label>
                                  <input type="text" class="form-control" name="fecia" id="fecia">
                                </div>
                                <div class="form-group col-md-2">
                                  <label for="fecfa">Fecha Final</label>
                                  <input type="text" class="form-control" name="fecfa" id="fecfa">
                                </div>
                              </div>
                              <div class="form-row">
                                <div class="form-group col-md-3">
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tfeca" id="frega" value="frega">
                                    <label class="form-check-label" for="frega">F. Registro</label>
                                  </div>
                                </div>
                                <div class="form-group col-md-3">
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tfeca" id="freca" value="freca">
                                    <label class="form-check-label" for="freca">F. Recepción</label>
                                  </div>
                                </div>
                                <div class="form-group col-md-3">
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tfeca" id="fnota" value="fnota">
                                    <label class="form-check-label" for="fnota">F. Not./Dev.</label>
                                  </div>
                                </div>
                                <div class="form-group col-md-3">
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tfeca" id="frepa" value="frepa">
                                    <label class="form-check-label" for="frepa">F. Reporte</label>
                                  </div>
                                </div>
                              </div>
                              <button type="submit" class="btn btn-primary" id="b_raignadores">Buscar</button>
                              <button type="button" class="btn btn-info" id="b_easignadores">Exportar</button>
                              <br><br>
                              <div id="r_asignadores"></div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="bdocumento" role="tabpanel" aria-labelledby="profile-tab">
                          <br>
                          <form id="f_bdocumento" class="form-inline">
                            <div class="form-group mx-sm-3 mb-2">
                              <label for="bdoc">Documento: D-</label>
                              <input type="text" class="form-control" name="bdoc" id="bdoc" placeholder="1234">
                            </div>
                            <button type="submit" class="btn btn-primary mb-2" id="b_bdocumento">Buscar</button>
                          </form>
                        </div>
                      </div>




  


                    </div>
                  </div>
                </div>
                <!-- Resultado documentos registrados-->
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-body" id="d_reportes">
                      <span class="text-success">Resultados</span>
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