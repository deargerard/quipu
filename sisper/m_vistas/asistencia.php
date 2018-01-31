<?php
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  if(accesoadm($cone,$_SESSION['identi'],2)){
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
              <li><a href="#tab_3" data-toggle="tab">Vigilantes</a></li>
              <li><a href="#tab_4" data-toggle="tab">--</a></li>
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
                  <h3><i class="fa fa-calendar-check-o text-gray"></i> <span class="text-orange">Buscar</span></h3>
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
                      <select class="form-control select2peract" name="emp" id="emp" style="width: 300px;">
                      </select>
                  </div>

                  <button type="submit" class="btn btn-default" id="b_baempleado">Buscar</button>
                </form>
                <!--Fin formulario busqueda-->
                <!--Div resultados-->
                <div class="d_aempleado">
                  <h3><i class="fa fa-calendar-check-o text-gray"></i> <span class="text-orange">Buscar</span></h3>
                </div>
                <!--Fin div resultados-->
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3">
                <div class="row">
                  <div class="col-md-12">
                    <!--Formulario busqueda-->
                    <form class="form-inline" id="f_bvigilante">
                      <div class="form-group valida">
                        <label class="sr-only" for="vig"></label>
                        <div class="input-group">
                          <select class="form-control" name="vig" id="vig">
                            <option value="">VIGILANTE</option>
                            <?php
                            $cvi=mysqli_query($cone,"SELECT * FROM vigilante ORDER BY Apellidos, Nombres ASC");
                            if(mysqli_num_rows($cvi)>0){
                              while($rvi=mysqli_fetch_assoc($cvi)){
                            ?>
                            <option value="<?php echo $rvi['idVigilante']; ?>"><?php echo $rvi['Apellidos'].', '.$rvi['Nombres']; ?></option>
                            <?php
                              }
                            }
                            mysqli_free_result($cvi);
                            ?>
                          </select>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-default" id="b_bvigilante">Buscar</button>
                      <button type="button" class="btn btn-info" id="b_fvigilante" data-toggle="modal" data-target="#m_nvigilante">Nuevo Vigilante</button>
                    </form>
                    <!--Fin formulario busqueda-->
                    <!--Div resultados-->
                    <div class="d_vigilante">
                      <?php
                        $cv=mysqli_query($cone,"SELECT * FROM vigilante ORDER BY idVigilante DESC LIMIT 10");
                        if(mysqli_num_rows($cv)>0){
                      ?>
                      <h3 class="text-maroon">Últimos 10 vigilantes registrados.</h3>
                      <table class="table" id="dtvigilante">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>NOMBRE</th>
                            <th>DNI</th>
                            <th>ULT. INGRESO</th>
                            <th>ESTADO</th>
                            <th>ACCIÓN</th>
                          </tr>
                        </thead>
                        <tbody>
                      <?php
                          $p=0;
                          while($rv=mysqli_fetch_assoc($cv)){
                            $p++;
                            if($rv['UltIngreso']=="0000-00-00 00:00:00"){
                              $ui="Aún no ingresa";
                            }else{
                              $date = date_create($rv['UltIngreso']);
                              $ui=date_format($date, 'd/m/Y H:i:s');
                            }
                      ?>
                          <tr>
                            <td><?php echo $p; ?></td>
                            <td><?php echo $rv['Apellidos'].', '.$rv['Nombres']; ?></td>
                            <td><?php echo $rv['DNI']; ?></td>
                            <td><?php echo $ui; ?></td>
                            <td><?php echo estado($rv['Estado']); ?></td>
                            <td>
                              <div class="btn-group">
                                <button class="btn btn-warning btn-xs dropdown-toggle" data-toggle="dropdown">
                                  <i class="fa fa-cog"></i>&nbsp;
                                  <span class="caret"></span>
                                  <span class="sr-only">Desplegar menú</span>
                                </button>
                                <ul class="dropdown-menu pull-right" role="menu">
                                  <li><a href="#" onclick="edivig(<?php echo $rv['idVigilante']; ?>)" data-toggle="modal" data-target="#m_evigilante">Editar</a></li>
                                  <li><a href="#" onclick="convig(<?php echo $rv['idVigilante']; ?>)" data-toggle="modal" data-target="#m_ccontrasena">Cambiar contraseña</a></li>
                                  <?php if($rv['Estado']==1){ ?>
                                  <li><a href="#" onclick="desvig(<?php echo $rv['idVigilante']; ?>)" data-toggle="modal" data-target="#m_dvigilante">Desactivar</a></li>
                                  <?php }else{ ?>
                                  <li><a href="#" onclick="actvig(<?php echo $rv['idVigilante']; ?>)" data-toggle="modal" data-target="#m_avigilante">Activar</a></li>
                                  <?php } ?>
                                </ul>
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
                          mensajeda("Error: No existen vigilantes registrados.");
                        }
                      ?>

                    </div>
                    <!--Fin div resultados-->
                  </div>
                </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_4">
                <button type="button" class="btn btn-info" id="b_fimagen" data-toggle="modal" data-target="#m_nimagen">Nueva Imagen</button>
                <!--Div resultados-->
                <div class="d_imagen">
                  <?php
                  $ccom=mysqli_query($cone,"SELECT * FROM slider ORDER BY idSlider ASC LIMIT 10");
                  if(mysqli_num_rows($ccom)>0){
                  ?>
                  <h3 class="text-maroon">Imagenes de carrusel.</h3>
                  <table class="table">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Imagen</th>
                        <th>Por</th>
                        <th>Estado</th>
                        <th>Acción</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $a=0;
                      while($rcom=mysqli_fetch_assoc($ccom)){
                        $a++;
                      ?>
                      <tr>
                        <td><?php echo $a; ?></td>
                        <td><a href="#" onclick="verimg(<?php echo $rcom['idSlider']; ?>)" data-toggle="modal" data-target="#m_vimagen"><?php echo $rcom['Imagen']; ?></a></td>
                        <td><?php echo nomempleado($cone, $rcom['idEmpleado']); ?></td>
                        <td><?php echo estado($rcom['Estado']) ?></td>
                        <td>
                          <div class="btn-group">
                            <button class="btn btn-warning btn-xs dropdown-toggle" data-toggle="dropdown">
                              <i class="fa fa-cog"></i>&nbsp;
                              <span class="caret"></span>
                              <span class="sr-only">Desplegar menú</span>
                            </button>
                            <ul class="dropdown-menu pull-right" role="menu">
                              <li><a href="#" onclick="eliimg(<?php echo $rcom['idSlider']; ?>)" data-toggle="modal" data-target="#m_eimagen">Eliminar</a></li>
                              <?php if($rcom['Estado']==1){ ?>
                              <li><a href="#" onclick="desimg(<?php echo $rcom['idSlider']; ?>)" data-toggle="modal" data-target="#m_dimagen">Desactivar</a></li>
                              <?php }else{ ?>
                              <li><a href="#" onclick="actimg(<?php echo $rcom['idSlider']; ?>)" data-toggle="modal" data-target="#m_aimagen">Activar</a></li>
                              <?php } ?>
                            </ul>
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
                    echo mensajewa("No existen imagenes.");
                  }
                  mysqli_free_result($ccom);
                  ?>
                </div>
                <!--Fin div resultados-->
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
      <form id="f_nvigilante" action="" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nuevo Vigilante</h4>
      </div>
      <div class="modal-body" id="d_nvigilante">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gnvigilante">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
      </form>
    </div>
  </div>
  
</div>
<!--Fin Modal nuevo vigilante-->
<!--Modal editar vigilante-->
<div class="modal fade" id="m_evigilante" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="f_evigilante" action="" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Vigilante</h4>
      </div>
      <div class="modal-body" id="d_evigilante">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gevigilante">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--Fin Modal editar vigilante-->
<!--Modal cambiar contraseña-->
<div class="modal fade" id="m_ccontrasena" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="f_ccontrasena" action="" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Cambiar Contraseña</h4>
      </div>
      <div class="modal-body" id="d_ccontrasena">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gccontrasena">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--Fin Modal cambiar contraseña-->
<!--Modal desactivar comunicado-->
<div class="modal fade" id="m_dvigilante" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="f_dvigilante" action="" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Desactivar Vigilante</h4>
      </div>
      <div class="modal-body" id="d_dvigilante">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger" id="b_sidvigilante">Si</button>
        <button type="button" class="btn btn-default" id="b_nodvigilante" data-dismiss="modal">No</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--Fin Modal desactivar comunicado-->
<!--Modal activar comunicado-->
<div class="modal fade" id="m_avigilante" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="f_avigilante" action="" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Activar Vigilante</h4>
      </div>
      <div class="modal-body" id="d_avigilante">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger" id="b_siavigilante">Si</button>
        <button type="button" class="btn btn-default" id="b_noavigilante" data-dismiss="modal">No</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--Fin Modal activar comunicado-->


<!-- Modal Comunicado-->
<div class="modal fade" id="m_vcomunicado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-bell-o text-orange"></i> Comunicado</h4>
      </div>
      <div class="modal-body d_rcomunicado">
        
      </div>
    </div>
  </div>
</div>

<!--Modal nuevo boletín-->
<div class="modal fade" id="m_nboletin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="f_nboletin" action="" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nuevo Boletín</h4>
      </div>
      <div class="modal-body" id="d_nboletin">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gnboletin">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--Fin Modal nuevo boletín-->

<!--Modal cambiar boletín-->
<div class="modal fade" id="m_cboletin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="f_cboletin" action="" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Cambiar Boletín</h4>
      </div>
      <div class="modal-body" id="d_cboletin">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gcboletin">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--Fin Modal cambiar boletín-->

<!--Modal desactivar boletín-->
<div class="modal fade" id="m_dboletin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="f_dboletin" action="" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Desactivar Boletín</h4>
      </div>
      <div class="modal-body" id="d_dboletin">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger" id="b_sidboletin">Si</button>
        <button type="button" class="btn btn-default" id="b_nodboletin" data-dismiss="modal">No</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--Fin Modal desactivar boletín-->

<!--Modal activar boletín-->
<div class="modal fade" id="m_aboletin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="f_aboletin" action="" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Activar Boletín</h4>
      </div>
      <div class="modal-body" id="d_aboletin">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger" id="b_siaboletin">Si</button>
        <button type="button" class="btn btn-default" id="b_noaboletin" data-dismiss="modal">No</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--Fin Modal activar boletín-->

<!--Modal nuevo categoría documento-->
<div class="modal fade" id="m_ncategoria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="f_ncategoria" action="" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nueva categoria</h4>
      </div>
      <div class="modal-body" id="d_ncategoria">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gncategoria">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--Fin Modal nuevo categoría documento-->

<!--Modal editar categoría documento-->
<div class="modal fade" id="m_ecategoria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="f_ecategoria" action="" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar categoria</h4>
      </div>
      <div class="modal-body" id="d_ecategoria">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gecategoria">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--Fin Modal editar categoría documento-->

<!--Modal desactivar boletín-->
<div class="modal fade" id="m_dcategoria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="f_dcategoria" action="" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Desactivar Categoría</h4>
      </div>
      <div class="modal-body" id="d_dcategoria">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger" id="b_sidcategoria">Si</button>
        <button type="button" class="btn btn-default" id="b_nodcategoria" data-dismiss="modal">No</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--Fin Modal desactivar boletín-->

<!--Modal activar boletín-->
<div class="modal fade" id="m_acategoria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="f_acategoria" action="" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Activar Categoría</h4>
      </div>
      <div class="modal-body" id="d_acategoria">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger" id="b_siacategoria">Si</button>
        <button type="button" class="btn btn-default" id="b_noacategoria" data-dismiss="modal">No</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--Fin Modal activar boletín-->

<!--Modal nuevo documento-->
<div class="modal fade" id="m_ndocumento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="f_ndocumento" action="" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nuevo Documento</h4>
      </div>
      <div class="modal-body" id="d_ndocumento">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gndocumento">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--Fin Modal nuevo documento-->
<!--Modal editar documento-->
<div class="modal fade" id="m_edocumento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="f_edocumento" action="" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Documento</h4>
      </div>
      <div class="modal-body" id="d_edocumento">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gedocumento">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--Fin Modal editar documento-->
<!--Modal cambiar documento-->
<div class="modal fade" id="m_cdocumento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="f_cdocumento" action="" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Cambiar Documento</h4>
      </div>
      <div class="modal-body" id="d_cdocumento">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gcdocumento">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--Fin Modal cambiar documdocdocumento-->
<!--Modal desactivar documento-->
<div class="modal fade" id="m_ddocumento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="f_ddocumento" action="" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Desactivar Documento</h4>
      </div>
      <div class="modal-body" id="d_ddocumento">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger" id="b_siddocumento">Si</button>
        <button type="button" class="btn btn-default" id="b_noddocumento" data-dismiss="modal">No</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--Fin Modal desactivar documento-->
<!--Modal activar documento-->
<div class="modal fade" id="m_adocumento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="f_adocumento" action="" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Activar Documento</h4>
      </div>
      <div class="modal-body" id="d_adocumento">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger" id="b_siadocumento">Si</button>
        <button type="button" class="btn btn-default" id="b_noadocumento" data-dismiss="modal">No</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--Fin Modal activar documento-->

<!--Modal nuevo imagen-->
<div class="modal fade" id="m_nimagen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="f_nimagen" action="" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nueva Imagen</h4>
      </div>
      <div class="modal-body" id="d_nimagen">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gnimagen">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--Fin Modal nuevo imagen-->
<!--Modal eliminar imagen-->
<div class="modal fade" id="m_eimagen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="f_eimagen" action="" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Eliminar Imagen</h4>
      </div>
      <div class="modal-body" id="d_eimagen">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger" id="b_sieimagen">Si</button>
        <button type="button" class="btn btn-default" id="b_noeimagen" data-dismiss="modal">No</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--Fin Modal eliminar imagen-->
<!--Modal desactivar imagen-->
<div class="modal fade" id="m_dimagen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="f_dimagen" action="" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Desactivar Imagen</h4>
      </div>
      <div class="modal-body" id="d_dimagen">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger" id="b_sidimagen">Si</button>
        <button type="button" class="btn btn-default" id="b_nodimagen" data-dismiss="modal">No</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--Fin Modal desactivar imagen-->
<!--Modal activar imagen-->
<div class="modal fade" id="m_aimagen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="f_aimagen" action="" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Activar Imagen</h4>
      </div>
      <div class="modal-body" id="d_aimagen">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger" id="b_siaimagen">Si</button>
        <button type="button" class="btn btn-default" id="b_noaimagen" data-dismiss="modal">No</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--Fin Modal activar imagen-->
<!--Modal activar imagen-->
<div class="modal fade" id="m_vimagen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Imagen</h4>
      </div>
      <div class="modal-body" id="d_vimagen">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>

    </div>
  </div>
</div>
<!--Fin Modal activar imagen-->

<?php
  }else{
    echo accrestringidop();
  }
}else{
header('Location: ../index.php');
}
?>