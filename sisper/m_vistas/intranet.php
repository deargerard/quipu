<?php
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  if(accesoadm($cone,$_SESSION['identi'],11)){
?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Intranet
      </h1>
      <ol class="breadcrumb">
        <li><a href="dboard.php"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="active">Intranet</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Comunicados</a></li>
              <li><a href="#tab_2" data-toggle="tab">Boletines</a></li>
              <li><a href="#tab_3" data-toggle="tab">Documentos</a></li>
              <li><a href="#tab_4" data-toggle="tab">Slider</a></li>
              <li><a href="#tab_5" data-toggle="tab">Noticias</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">

                <!--Formulario busqueda-->
                <form class="form-inline" id="f_bcomunicado">
                  <div class="form-group has-feedback valida">
                      <span class="fa fa-calendar form-control-feedback"></span>
                      <input type="text" class="form-control" id="fech1" name="fech1" placeholder="Fecha de inicio">
                  </div>
                  <div class="form-group has-feedback valida">
                      <span class="fa fa-calendar form-control-feedback"></span>
                      <input type="text" class="form-control" id="fech2" name="fech2" placeholder="Fecha de fin">
                  </div>

                  <button type="submit" class="btn btn-default" id="b_bcomunicado">Buscar</button>
                  <button type="button" class="btn btn-info" id="b_fcomunicado" data-toggle="modal" data-target="#m_ncomunicado">Nuevo Comunicado</button>

                </form>
                <!--Fin formulario busqueda-->
                <!--Div resultados-->
                <div class="d_comunicado">
                  <?php
                  $fecha = @date('Y-m-j');
                  $nuevafecha = @strtotime ( '-10 day' , strtotime ( $fecha ) ) ;
                  $nuevafecha = @date ( 'Y-m-j' , $nuevafecha );
                  $ccom=mysqli_query($cone,"SELECT * FROM comunicado WHERE Fecha>='$nuevafecha' AND Fecha<='$fecha' ORDER BY Fecha DESC");
                  if(mysqli_num_rows($ccom)>0){
                  ?>
                  <h3 class="text-maroon">Comunicados del <?php echo fnormal($nuevafecha); ?> al <?php echo fnormal($fecha); ?>.</h3>
                  <table class="table" id="dtcomunicado">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Descripción</th>
                        <th>Adjunto</th>
                        <th>Por</th>
                        <th>Estado</th>
                        <th>Acción</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $c=0;
                      while($rcom=mysqli_fetch_assoc($ccom)){
                        $c++;
                        if($rcom['Adjunto']==""){
                          $a=false;
                        }else{
                          $a=true;
                        }
                      ?>
                      <tr>
                        <td><?php echo $c; ?></td>
                        <td><?php echo fnormal($rcom['Fecha']); ?></td>
                        <td><a href="#" data-toggle="modal" data-target="#m_vcomunicado" onclick="vcomunicado(<?php echo $rcom["idComunicado"] ?>)"><?php echo $rcom['Descripcion']; ?></a></td>
                        <td><a href="files_intranet/<?php echo $rcom['Adjunto']; ?>" target="_blank"><?php echo end(explode('_', $rcom['Adjunto'])); ?></a></td>
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
                              <li><a href="#" onclick="edicom(<?php echo $rcom['idComunicado']; ?>)" data-toggle="modal" data-target="#m_ecomunicado">Editar</a></li>
                              <?php if(!$a){ ?>
                              <li><a href="#" onclick="agradj(<?php echo $rcom['idComunicado']; ?>)" data-toggle="modal" data-target="#m_aadjunto">Adjuntar</a></li>
                              <?php }else{ ?>
                              <li><a href="#" onclick="quiadj(<?php echo $rcom['idComunicado']; ?>)" data-toggle="modal" data-target="#m_qadjunto">Quitar Adjunto</a></li>
                              <?php } ?>
                              <?php if($rcom['Estado']==1){ ?>
                              <li><a href="#" onclick="descom(<?php echo $rcom['idComunicado']; ?>)" data-toggle="modal" data-target="#m_dcomunicado">Desactivar</a></li>
                              <?php }else{ ?>
                              <li><a href="#" onclick="actcom(<?php echo $rcom['idComunicado']; ?>)" data-toggle="modal" data-target="#m_acomunicado">Activar</a></li>
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
                    echo mensajewa("No existen comunicados.");
                  }
                  mysqli_free_result($ccom);
                  ?>
                </div>
                <!--Fin div resultados-->

              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                <!--Formulario busqueda-->
                <form class="form-inline" id="f_bboletin">
                  <div class="form-group">
                    <div class="input-group valida">
                      <select class="form-control" name="ano" id="ano">
                        <option value="">Año</option>
                        <option value="2016">2016</option>
                        <option value="2017">2017</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                      </select>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-default" id="b_bboletin">Buscar</button>
                  <button type="button" class="btn btn-info" id="b_fboletin" data-toggle="modal" data-target="#m_nboletin">Nuevo Boletín</button>
                </form>
                <!--Fin formulario busqueda-->
                <!--Div resultados-->
                <div class="d_boletin">
                  <?php
                  $ano=@date("Y");
                  $cbol=mysqli_query($cone,"SELECT * FROM boletin WHERE DATE_FORMAT(Fecha,'%Y')=$ano ORDER BY Fecha DESC");
                  if(mysqli_num_rows($cbol)>0){
                  ?>
                  <h3 class="text-maroon">Boletines del <?php echo $ano; ?>.</h3>
                  <table class="table" id="dtboletin">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Descripción</th>
                        <th>Boletín</th>
                        <th>Fec. Publicación</th>
                        <th>Por</th>
                        <th>Estado</th>
                        <th>Acción</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $a=0;
                      while($rbol=mysqli_fetch_assoc($cbol)){
                        $a++;
                      ?>
                      <tr>
                        <td><?php echo $a; ?></td>
                        <td><?php echo $rbol['Descripcion']; ?></td>
                        <td><a href="<?php echo 'files_intranet/'.$rbol['Adjunto']; ?>" target="_blank"><i class="fa fa-file-pdf-o"></i></a></td>
                        <td><?php echo fnormal($rbol['Fecha']); ?></td>
                        <td><?php echo nomempleado($cone, $rbol['idEmpleado']); ?></td>
                        <td><?php echo estado($rbol['Estado']); ?></td>
                        <td>
                          <div class="btn-group">
                            <button class="btn btn-warning btn-xs dropdown-toggle" data-toggle="dropdown">
                              <i class="fa fa-cog"></i>&nbsp;
                              <span class="caret"></span>
                              <span class="sr-only">Desplegar menú</span>
                            </button>
                            <ul class="dropdown-menu pull-right" role="menu">
                              <li><a href="#" onclick="edibol(<?php echo $rbol['idBoletin']; ?>)" data-toggle="modal" data-target="#m_eboletin">Editar boletín</a></li>
                              <li><a href="#" onclick="cambol(<?php echo $rbol['idBoletin']; ?>)" data-toggle="modal" data-target="#m_cboletin">Cambiar boletín</a></li>
                              <?php if($rbol['Estado']==1){ ?>
                              <li><a href="#" onclick="desbol(<?php echo $rbol['idBoletin']; ?>)" data-toggle="modal" data-target="#m_dboletin">Desactivar</a></li>
                              <?php }else{ ?>
                              <li><a href="#" onclick="actbol(<?php echo $rbol['idBoletin']; ?>)" data-toggle="modal" data-target="#m_aboletin">Activar</a></li>
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
                    echo mensajewa("No existen boletines para este año.");
                  }
                  mysqli_free_result($cbol);
                  ?>
                </div>
                <!--Fin div resultados-->
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3">
                <div class="row">
                  <div class="col-md-7">
                    <!--Formulario busqueda-->
                    <form class="form-inline" id="f_bdocumento">
                      <div class="form-group valida">
                        <label class="sr-only" for="cat"></label>
                        <div class="input-group">
                          <select class="form-control" name="cat" id="cat">
                            <option value="">Categoría</option>
                            <?php
                            $can=mysqli_query($cone,"SELECT * FROM catdocumento ORDER BY CatDocumento ASC");
                            if(mysqli_num_rows($can)>0){
                              while($ran=mysqli_fetch_assoc($can)){
                            ?>
                            <option value="<?php echo $ran['idCatDocumento']; ?>"><?php echo $ran['CatDocumento']; ?></option>
                            <?php
                              }
                            }
                            mysqli_free_result($can);
                            ?>
                          </select>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-default" id="b_bdocumento">Buscar</button>
                      <button type="button" class="btn btn-info" id="b_fdocumento" data-toggle="modal" data-target="#m_ndocumento">Nuevo Documento</button>
                    </form>
                    <!--Fin formulario busqueda-->
                    <!--Div resultados-->
                    <div class="d_documento">

                    </div>
                    <!--Fin div resultados-->
                  </div>
                  <div class="col-md-5">
                    <button type="button" class="btn btn-info" id="b_fcategoria" data-toggle="modal" data-target="#m_ncategoria">Nueva Categoria</button>
                    <div class="d_categoria">
                      <h3 class="text-maroon">Categorías</h3>
                      <?php
                        $ccat=mysqli_query($cone,"SELECT * FROM catdocumento ORDER BY CatDocumento ASC");
                        if(mysqli_num_rows($ccat)>0){
                      ?>
                        <table class="table" id="dtcategoria">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Categoría</th>
                              <th>Estado</th>
                              <th>Acción</th>                              
                            </tr>
                          </thead>
                          <tbody>
                      <?php
                        $b=0;
                        while($rcat=mysqli_fetch_assoc($ccat)){
                          $b++;
                      ?>
                            <tr>
                              <td><?php echo $b; ?></td>
                              <td><?php echo $rcat['CatDocumento']; ?></td>
                              <td><?php echo estado($rcat['Estado']); ?></td>
                              <td>
                                <div class="btn-group">
                                  <button class="btn btn-warning btn-xs dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-cog"></i>&nbsp;
                                    <span class="caret"></span>
                                    <span class="sr-only">Desplegar menú</span>
                                  </button>
                                  <ul class="dropdown-menu pull-right" role="menu">
                                    <li><a href="#" onclick="edicat(<?php echo $rcat['idCatDocumento']; ?>)" data-toggle="modal" data-target="#m_ecategoria">Editar Categoría</a></li>
                                    <?php if($rcat['Estado']==1){ ?>
                                    <li><a href="#" onclick="descat(<?php echo $rcat['idCatDocumento']; ?>)" data-toggle="modal" data-target="#m_dcategoria">Desactivar</a></li>
                                    <?php }else{ ?>
                                    <li><a href="#" onclick="actcat(<?php echo $rcat['idCatDocumento']; ?>)" data-toggle="modal" data-target="#m_acategoria">Activar</a></li>
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
                          echo mensajeda("Aun no existen categorías.");
                        }
                      ?>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_4">
                <button type="button" class="btn btn-info" id="b_fimagen" data-toggle="modal" data-target="#m_nimagen">Nueva Imagen</button>
                <!--Div resultados-->
                <div class="d_imagen">
                  <?php
                  $ccom=mysqli_query($cone,"SELECT * FROM slider ORDER BY idSlider DESC");
                  if(mysqli_num_rows($ccom)>0){
                  ?>
                  <h3 class="text-maroon">Imagenes de Slider.</h3>
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
              <div class="tab-pane" id="tab_5">

                <!--Formulario busqueda-->
                <form class="form-inline" id="f_bnoticia">
                  <div class="form-group has-feedback valida">
                      <span class="fa fa-calendar form-control-feedback"></span>
                      <input type="text" class="form-control" id="fecha1" name="fecha1" placeholder="Fecha de inicio">
                  </div>
                  <div class="form-group has-feedback valida">
                      <span class="fa fa-calendar form-control-feedback"></span>
                      <input type="text" class="form-control" id="fecha2" name="fecha2" placeholder="Fecha de fin">
                  </div>

                  <button type="submit" class="btn btn-default" id="b_bnoticia">Buscar</button>
                  <button type="button" class="btn btn-info" id="b_fnoticia" data-toggle="modal" data-target="#m_nnoticia">Nueva Noticia</button>

                </form>
                <!--Fin formulario busqueda-->
                <!--Div resultados-->
                <div class="d_noticia">
                  <?php
                  $fecha = @date('Y-m-j');
                  $nuevafecha = @strtotime ( '-10 day' , strtotime ( $fecha ) ) ;
                  $nuevafecha = @date ( 'Y-m-j' , $nuevafecha );
                  $cnot=mysqli_query($cone,"SELECT idNoticia, Fecha, Titular, Imagen, Estado, idEmpleado FROM noticia WHERE Fecha>='$nuevafecha' AND Fecha<='$fecha' ORDER BY Fecha DESC");
                  if(mysqli_num_rows($cnot)>0){
                  ?>
                  <h3 class="text-maroon">Noticias del <?php echo fnormal($nuevafecha); ?> al <?php echo fnormal($fecha); ?>.</h3>
                  <table class="table" id="dtcomunicado">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Titular</th>
                        <th>Imagen</th>
                        <th>Por</th>
                        <th>Estado</th>
                        <th>Acción</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $c=0;
                      while($rnot=mysqli_fetch_assoc($cnot)){
                        $c++;
                        if($rnot['Imagen']==""){
                          $a=false;
                        }else{
                          $a=true;
                        }
                      ?>
                      <tr>
                        <td><?php echo $c; ?></td>
                        <td><?php echo fnormal($rnot['Fecha']); ?></td>
                        <td><?php echo $rnot['Titular']; ?></td>
                        <td><a href="files_intranet/<?php echo $rnot['Imagen']; ?>" target="_blank"><?php echo end(explode('_', $rnot['Imagen'])); ?></a></td>
                        <td><?php echo nomempleado($cone, $rnot['idEmpleado']); ?></td>
                        <td><?php echo estado($rnot['Estado']) ?></td>
                        <td>
                          <div class="btn-group">
                            <button class="btn btn-warning btn-xs dropdown-toggle" data-toggle="dropdown">
                              <i class="fa fa-cog"></i>&nbsp;
                              <span class="caret"></span>
                              <span class="sr-only">Desplegar menú</span>
                            </button>
                            <ul class="dropdown-menu pull-right" role="menu">
                              <li><a href="#" onclick="edinot(<?php echo $rnot['idNoticia']; ?>)" data-toggle="modal" data-target="#m_enoticia">Editar</a></li>
                              <li><a href="#" onclick="imanot(<?php echo $rnot['idNoticia']; ?>)" data-toggle="modal" data-target="#m_inoticia">Imagen</a></li>
                              <?php if($a){ ?>
                              <li><a href="#" onclick="estnot(<?php echo $rnot['idNoticia']; ?>)" data-toggle="modal" data-target="#m_esnoticia"><?php echo $rnot['Estado']==1 ? "Desactivar" : "Activar"; ?></a></li>
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
                    echo mensajewa("No existen noticias.");
                  }
                  mysqli_free_result($cnot);
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

<!--Modal nueva noticia-->
<div class="modal fade" id="m_nnoticia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form id="f_nnoticia" action="" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nueva Noticia</h4>
      </div>
      <div class="modal-body" id="d_nnoticia">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gnnoticia">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
      </form>
    </div>
  </div>
  
</div>
<!--Fin Modal nueva noticia-->

<!--Modal editar noticia-->
<div class="modal fade" id="m_enoticia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form id="f_enoticia" action="" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Noticia</h4>
      </div>
      <div class="modal-body" id="d_enoticia">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_genoticia">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
      </form>
    </div>
  </div>
  
</div>
<!--Fin Modal editar noticia-->
<!--Modal imagen noticia-->
<div class="modal fade" id="m_inoticia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="f_inoticia" action="" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Imagen Noticia</h4>
      </div>
      <div class="modal-body" id="d_inoticia">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_ginoticia">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--Fin Modal imagen noticia-->

<!--Modal estado noticia-->
<div class="modal fade" id="m_esnoticia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="f_esnoticia" action="" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Estado Noticia</h4>
      </div>
      <div class="modal-body" id="d_esnoticia">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger" id="b_siesnoticia">Si</button>
        <button type="button" class="btn btn-default" id="b_noesnoticia" data-dismiss="modal">No</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--Fin Modal estado noticia-->

<!--Modal nuevo comunicado-->
<div class="modal fade" id="m_ncomunicado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form id="f_ncomunicado" action="" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nuevo Comunicado</h4>
      </div>
      <div class="modal-body" id="d_ncomunicado">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gncomunicado">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
      </form>
    </div>
  </div>
  
</div>
<!--Fin Modal nuevo comunicado-->
<!--Modal nuevo comunicado-->
<div class="modal fade" id="m_aadjunto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="f_aadjunto" action="" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Agregar Adjunto</h4>
      </div>
      <div class="modal-body" id="d_aadjunto">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gaadjunto">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--Fin Modal nuevo comunicado-->
<!--Modal editar comunicado-->
<div class="modal fade" id="m_ecomunicado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form id="f_ecomunicado" action="" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Comunicado</h4>
      </div>
      <div class="modal-body" id="d_ecomunicado">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gecomunicado">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--Fin Modal editar comunicado-->
<!--Modal quitar comunicado-->
<div class="modal fade" id="m_qadjunto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="f_qadjunto" action="" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Quitar Adjunto</h4>
      </div>
      <div class="modal-body" id="d_qadjunto">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger" id="b_siqadjunto">Si</button>
        <button type="button" class="btn btn-default" id="b_noqadjunto" data-dismiss="modal">No</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--Fin Modal quitar comunicado-->
<!--Modal desactivar comunicado-->
<div class="modal fade" id="m_dcomunicado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="f_dcomunicado" action="" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Desactivar Comunicado</h4>
      </div>
      <div class="modal-body" id="d_dcomunicado">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger" id="b_sidcomunicado">Si</button>
        <button type="button" class="btn btn-default" id="b_nodcomunicado" data-dismiss="modal">No</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--Fin Modal desactivar comunicado-->
<!--Modal activar comunicado-->
<div class="modal fade" id="m_acomunicado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="f_acomunicado" action="" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Activar Comunicado</h4>
      </div>
      <div class="modal-body" id="d_acomunicado">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger" id="b_siacomunicado">Si</button>
        <button type="button" class="btn btn-default" id="b_noacomunicado" data-dismiss="modal">No</button>
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
<!--Modal editar boletín-->
<div class="modal fade" id="m_eboletin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="f_eboletin" action="" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nuevo Boletín</h4>
      </div>
      <div class="modal-body" id="d_eboletin">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_geboletin">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--Fin Modal editar boletín-->

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