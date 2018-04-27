<?php
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  if(accesocon($cone,$_SESSION['identi'],2)){
?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Asistencia
      </h1>
      <ol class="breadcrumb">
        <li><a href="dboard.php"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="active">Asistencia</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Marcaciones diarias</a></li>
              <li><a href="#tab_2" data-toggle="tab">Marcación mensual</a></li>
              <li><a href="#tab_3" data-toggle="tab">Control Asistencia</a></li>
              <li><a href="#tab_4" data-toggle="tab">Permisos</a></li>
              <li><a href="#tab_5" data-toggle="tab">Horarios</a></li>
              <li><a href="#tab_6" data-toggle="tab">Días Libres</a></li>
              <li><a href="#tab_7" data-toggle="tab">Vigilantes</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">

                <!--Formulario busqueda-->
                <form class="form-inline" id="f_badiaria">
                  <div class="form-group has-feedback valida">
                      <span class="fa fa-calendar form-control-feedback"></span>
                      <input type="text" class="form-control" id="fec" name="fec" placeholder="Fecha">
                  </div>
                  <button type="submit" class="btn btn-default" id="b_badiaria">Buscar</button>
                </form>
                <!--Fin formulario busqueda-->
                <!--Div resultados-->
                <div class="d_adiaria">
                  <h4><i class="fa fa-calendar-check-o text-gray"></i> <span class="text-orange">Buscar</span></h4>
                </div>
                <!--Fin div resultados-->

              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                <!--Formulario busqueda-->
                <form class="form-inline" id="f_baempleado">
                  <div class="form-group has-feedback valida">
                      <span class="fa fa-calendar form-control-feedback"></span>
                      <input type="text" class="form-control" id="mesano" name="mesano" placeholder="Mes/Año">
                  </div>
                  <div class="form-group valida">
                      <select class="form-control select2pertot" name="emp" id="emp" style="width: 350px;">
                      </select>
                  </div>

                  <button type="submit" class="btn btn-default" id="b_baempleado">Buscar</button>
                </form>
                <!--Fin formulario busqueda-->
                <!--Div resultados-->
                <div class="d_aempleado">
                  <h4><i class="fa fa-calendar text-gray"></i> <span class="text-orange">Buscar</span></h4>
                </div>
                <!--Fin div resultados-->
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3">
                <!--Formulario busqueda-->
                <form class="form-inline" id="f_bcaempleado">
                  <div class="form-group has-feedback valida">
                      <span class="fa fa-calendar form-control-feedback"></span>
                      <input type="text" class="form-control" id="mesanoc" name="mesanoc" placeholder="Mes/Año">
                  </div>
                  <div class="form-group valida">
                      <select class="form-control select2pertot" name="per" id="per" style="width: 350px;">
                      </select>
                  </div>
                  <div class="form-group">
                    <select name="car" id="car" class="form-control select2" style="width: 250px;">
                      <option>--</option>
                    </select>
                  </div>

                  <button type="submit" class="btn btn-default" id="b_bcaempleado">Buscar</button>
                </form>
                <!--Fin formulario busqueda-->
                <!--Div resultados-->
                <div id="d_caempleado">
                  <h4><i class="fa fa-calendar text-gray"></i> <span class="text-orange">Buscar</span></h4>
                </div>
                <!--Fin div resultados-->
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_4">
                <div class="row">
                  <div class="col-md-12">
                    <!--Formulario busqueda-->
                    <form class="form-inline" id="f_bpermisos">
                      <div class="form-group has-feedback valida">
                          <span class="fa fa-calendar form-control-feedback"></span>
                          <input type="text" class="form-control" id="anop" name="anop" placeholder="Año">
                      </div>
                      <div class="form-group valida">
                          <select class="form-control select2peract" name="perp" id="perp" style="width: 350px;">
                          </select>
                      </div>

                      <button type="submit" class="btn btn-default" id="b_bpermisos">Buscar</button>
                    </form>
                    <!--Fin formulario busqueda-->
                    <!--Div resultados-->
                    <div class="d_permisos">
                      <h4><i class="fa fa-calendar-plus-o text-gray"></i> <span class="text-orange">Buscar</span></h4>
                    </div>
                    <!--Fin div resultados-->
                  </div>
                </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_5">
                <div class="row">
                  <div class="col-md-12">
                    <!--Formulario busqueda-->
                    <form class="form-inline" id="f_bhorarios">
                      <button type="button" class="btn btn-default" onclick="acthor();"> Buscar Horarios</button>
                      <?php if(accesoadm($cone,$_SESSION['identi'],2)){ ?>
                      <button type="button" class="btn btn-info" id="b_ahorario" data-toggle="modal" data-target="#m_ahorario" onclick="agrhor();"><i class="fa fa-calendar-o"></i> Agregar Horario</button>
                      <?php } ?>
                    </form>
                    <!--Fin formulario busqueda-->
                    <!--Div resultados-->
                    <div class="d_horarios">
                      <h4><i class="fa fa-calendar-o text-gray"></i> <span class="text-orange">Buscar</span></h4>
                    </div>
                    <!--Fin div resultados-->
                  </div>
                </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_6">
                <div class="row">
                  <div class="col-md-12">
                    <!--Formulario busqueda-->
                    <form class="form-inline" id="f_bdlibres">
                      <div class="form-group has-feedback valida">
                          <span class="fa fa-calendar form-control-feedback"></span>
                          <input type="text" class="form-control" id="anodl" name="anodl" placeholder="Año">
                      </div>
                      <button type="button" class="btn btn-default" id="b_bdlibres" onclick="actdlib();">Buscar</button>
                      <?php if(accesoadm($cone,$_SESSION['identi'],2)){ ?>
                      <button type="button" class="btn btn-info" id="b_adlibre" data-toggle="modal" data-target="#m_adlibre"><i class="fa fa-calendar-times-o"></i> Agregar Día Libre</button>
                      <?php } ?>
                    </form>
                    <!--Fin formulario busqueda-->
                    <!--Div resultados-->
                    <div class="d_dlibres">
                      <h4><i class="fa fa-calendar-times-o text-gray"></i> <span class="text-orange">Buscar</span></h4>
                    </div>
                    <!--Fin div resultados-->
                  </div>
                </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_7">
                <div class="row">
                  <div class="col-md-12">
                    <!--Formulario busqueda-->
                    <form class="form-inline" id="f_bvigilante">
                      <div class="form-group valida">
                        <input type="text" name="vig" id="vig" class="form-control" placeholder="Nombre Vigilante" style="width: 300px;">
                      </div>
                      <?php if(accesoadm($cone,$_SESSION['identi'],2)){ ?>
                      <button type="button" class="btn btn-info" id="b_fvigilante" data-toggle="modal" data-target="#m_nvigilante"><i class="fa fa-user-secret"></i> Nuevo Vigilante</button>
                      <?php } ?>
                    </form>
                    <!--Fin formulario busqueda-->
                    <!--Div resultados-->
                    <div class="d_vigilante">
                      <h4><i class="fa fa-user-secret text-gray"></i> <span class="text-orange">Buscar</span></h4>
                    </div>
                    <!--Fin div resultados-->
                  </div>
                </div>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
      </div>

    </section>
    <!-- /.content -->

<!--Modal nuevo vigilante-->
<div class="modal fade" id="m_nvigilante" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus text-gray"></i> <span class="text-orange">Nuevo Vigilante</span></h4>
      </div>
      <div class="modal-body" id="d_nvigilante">
        <form id="f_nvigilante" action="" class="form-horizontal">

        </form>        
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gnvigilante" form="f_nvigilante">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  
</div>
<!--Fin Modal nuevo vigilante-->
<!--Modal editar vigilante-->
<div class="modal fade" id="m_evigilante" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa fa-pencil text-gray"></i> <span class="text-orange">Editar Vigilante</span></h4>
      </div>
      <div class="modal-body" id="d_evigilante">
        <form id="f_evigilante" action="" class="form-horizontal">

        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gevigilante" form="f_evigilante">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--Fin Modal editar vigilante-->
<!--Modal cambiar contraseña-->
<div class="modal fade" id="m_ccontrasena" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-lock text-gray"></i> <span class="text-orange">Cambiar contraseña</span></h4>
      </div>
      <div class="modal-body" id="d_ccontrasena">
        <form id="f_ccontrasena" action="" class="form-horizontal">
          
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gccontrasena" form="f_ccontrasena">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--Fin Modal cambiar contraseña-->
<!--Modal estado vigilante-->
<div class="modal fade" id="m_estvigilante" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">  
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-toggle-on text-gray"></i> <span class="text-orange">Cambiar estado</span></h4>
      </div>
      <div class="modal-body" id="d_dvigilante">
        <form id="f_estvigilante" action="" class="form-horizontal">

        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger" id="b_sievigilante" form="f_estvigilante">Si</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--Fin Modal estado vigilante-->
<!--Modal agregar marcación-->
<div class="modal fade" id="m_amarcacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus text-gray"></i> <span class="text-orange">Agregar Marcación</span></h4>
      </div>
      <div class="modal-body">
        <form id="f_amarcacion" action="" class="form-horizontal">

        </form>        
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gamarcacion" form="f_amarcacion">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--Fin Modal agregar marcación-->
<!--Modal editar marcación-->
<div class="modal fade" id="m_emarcacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-edit text-gray"></i> <span class="text-orange">Editar Marcación</span></h4>
      </div>
      <div class="modal-body">
        <form id="f_emarcacion" action="" class="form-horizontal">

        </form>        
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gemarcacion" form="f_emarcacion">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--Fin Modal editar marcación-->
<!--Modal eliminar marcación-->
<div class="modal fade" id="m_elmarcacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">  
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-trash text-gray"></i> <span class="text-orange">Eliminar Marcación</span></h4>
      </div>
      <div class="modal-body">
        <form id="f_elmarcacion" class="form-horizontal">

        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger" id="b_sielmarcacion" form="f_elmarcacion">Si</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--Fin Modal eliminar marcación-->
<!--Modal agregar permiso-->
<div class="modal fade" id="m_apermiso" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus text-gray"></i> <span class="text-orange">Agregar Permiso</span></h4>
      </div>
      <div class="modal-body">
        <form id="f_apermiso" action="" class="form-horizontal">

        </form>        
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gapermiso" form="f_apermiso">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--Fin Modal agregar permiso-->
<!--Modal editar permiso-->
<div class="modal fade" id="m_epermiso" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-edit text-gray"></i> <span class="text-orange">Editar Permiso</span></h4>
      </div>
      <div class="modal-body">
        <form id="f_epermiso" action="" class="form-horizontal">

        </form>        
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gepermiso" form="f_epermiso">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--Fin Modal editar permiso-->
<!--Modal estado permiso-->
<div class="modal fade" id="m_estpermiso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">  
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-toggle-on text-gray"></i> <span class="text-orange">Cambiar Estado</span></h4>
      </div>
      <div class="modal-body">
        <form id="f_estpermiso" class="form-horizontal">

        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger" id="b_siepermiso" form="f_estpermiso">Si</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--Fin Modal estado permiso-->
<!--Modal detalle permiso-->
<div class="modal fade" id="m_dpermiso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">  
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-file-text text-gray"></i> <span class="text-orange">Detalle Permiso</span></h4>
      </div>
      <div class="modal-body" id="d_dpermiso">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--Fin Modal detalle permiso-->
<!--Modal agregar permiso-->
<div class="modal fade" id="m_ahorario" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus text-gray"></i> <span class="text-orange">Agregar Horario</span></h4>
      </div>
      <div class="modal-body">
        <form id="f_ahorario" class="form-horizontal">

        </form>        
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gahorario" form="f_ahorario">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--Fin Modal agregar permiso-->
<!--Modal estado horario-->
<div class="modal fade" id="m_esthorario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">  
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-toggle-on text-gray"></i> <span class="text-orange">Cambiar Estado</span></h4>
      </div>
      <div class="modal-body">
        <form id="f_esthorario" class="form-horizontal">

        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger" id="b_siehorario" form="f_esthorario">Si</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--Fin Modal estado horario-->
<!--Modal agregar día libre-->
<div class="modal fade" id="m_adlibre" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus text-gray"></i> <span class="text-orange">Agregar Día Libre</span></h4>
      </div>
      <div class="modal-body">
        <form id="f_adlibre" class="form-horizontal">

        </form>        
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gadlibre" form="f_adlibre">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--Fin Modal agregar día libre-->
<!--Modal estado día libre-->
<div class="modal fade" id="m_estdlibre" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">  
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-toggle-on text-gray"></i> <span class="text-orange">Cambiar Estado</span></h4>
      </div>
      <div class="modal-body">
        <form id="f_estdlibre" class="form-horizontal">

        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger" id="b_siedlibre" form="f_estdlibre">Si</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--Fin Modal estado día libre-->
<!--Modal agregar día libre-->
<div class="modal fade" id="m_hmensual" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-calendar-check-o text-gray"></i> <span class="text-orange">Horario Mensual</span></h4>
      </div>
      <div class="modal-body">
        <form id="f_hmensual" class="form-horizontal">

        </form>        
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_ghmensual" form="f_hmensual">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--Fin Modal agregar día libre-->

<?php
  }else{
    echo accrestringidop();
  }
}else{
header('Location: ../index.php');
}
?>