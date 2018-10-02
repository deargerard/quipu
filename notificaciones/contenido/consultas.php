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
                          <a class="nav-link active" id="bdoc-tab" data-toggle="tab" href="#bdoc" role="tab" aria-controls="home" aria-selected="true">Buscar Documento</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="bguia-tab" data-toggle="tab" href="#bguia" role="tab" aria-controls="home" aria-selected="false">Buscar Guía</a>
                        </li>
                      </ul>
                      <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="bdoc" role="tabpanel" aria-labelledby="bdoc-tab">
                          <br>
                          <form id="f_bdoc" class="form-inline">
                            <div class="form-group mx-sm-3 mb-2">
                              <label for="ndoc">N° Documento&nbsp;&nbsp;</label>
                              <input type="text" class="form-control" name="ndoc" id="ndoc" placeholder="1234">
                              <label for="des">&nbsp;&nbsp;Destinatario&nbsp;&nbsp;</label>
                              <input type="text" class="form-control" name="des" id="des" placeholder="Destinatario...">
                            </div>
                            <button type="submit" class="btn btn-primary mb-2" id="b_bdocumento">Buscar</button>
                          </form>
                        </div>
                        <div class="tab-pane fade" id="bguia" role="tabpanel" aria-labelledby="bguia-tab">
                          <br>
                          <form id="f_bguia" class="form-inline">
                            <div class="form-group mx-sm-3 mb-2">
                              <label for="nguia">N° Guía&nbsp;&nbsp;</label>
                              <input type="text" class="form-control" name="nguia" id="nguia" placeholder="n-aaaa">
                            </div>
                            <button type="submit" class="btn btn-primary mb-2" id="b_bguia">Buscar</button>
                          </form>
                        </div>
                      </div>




                    </div>
                  </div>
                </div>
                <!-- Resultado documentos registrados-->
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-body" id="d_consultas">
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