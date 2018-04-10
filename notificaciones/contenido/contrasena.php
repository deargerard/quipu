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
                      <h3 class="h4">Cambiar contraseña</h3>
                    </div>
                    <div class="card-body" id="f_documento">


                      <form id="f_contrasena">
                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label for="cact">Contraseña Actual</label>
                            <input type="password" class="form-control" name="cact" id="cact">
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label for="cnue">Nueva contraseña</label>
                            <input type="password" class="form-control" name="cnue" id="cnue">
                          </div>
                          <div class="form-group col-md-6">
                            <label for="crep">Repetir nueva contraseña</label>
                            <input type="password" class="form-control" name="crep" id="crep">
                          </div>
                        </div>
                        <button type="submit" class="btn btn-primary" id="b_contrasena">Cambiar</button>
                        <br><br>
                        <div id="r_contrasena"></div>
                      </form>


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