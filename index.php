<?php
    include ("sisper/m_inclusiones/php/conexion_sp.php");
    include ("sisper/m_inclusiones/php/funciones.php");
?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta http-equiv="refresh" content="600">

    <title>Distrito Fiscal de Cajamarca - Intranet</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/modern-business.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link href="plugins/select2/select2.css" rel="stylesheet">

    <link rel="stylesheet" href="sisper/dist/css/AdminLTE.css">

    <link href="plugins/pace/pace.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
    <!--megamenu-->
<header>
    <div class="hlogo">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <a href="index.php"><img src="images/logo.png" alt="Intranet Distrito Fiscal de Cajamarca"></a>
                </div>
                <div class="col-md-6">
                    
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-inverse">
      <div class="container">
        <div class="navbar-header">
          <button type="button"class="navbar-toggle collapsed" data-toggle="collapse" data-target=".bs-navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a href="./" class="navbar-brand">CAJAMARCA</a>
        </div>
        <nav class="collapse navbar-collapse bs-navbar-collapse navbar-right">
          <ul class="nav navbar-nav">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">ENLACES PJ <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="https://casillas.pj.gob.pe/sinoe/login.xhtml" target="_blank">Casillas Electrónicas</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">ENLACES MP <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="/sisper" target="_blank">SisPer</a></li>
                  <li><a href="/asistencia" target="_blank">Asistencia</a></li>
                  <li role="separator" class="divider"></li>
                  <li><a href="http://sistemas2.mpfn.gob.pe/" target="_blank">Sistemas2</a></li>
                  <li><a href="http://djmail.mpfn.gob.pe/" target="_blank">Correo</a></li>
                </ul>
            </li>
          </ul>
        </nav>
      </div>
    </nav>
    <!-- Navigation -->
</header>
    <!-- Header Carousel -->
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <div class="row">
                <div class="col-md-12">
                <?php
                $csli=mysqli_query($cone,"SELECT * FROM slider WHERE Estado=1 ORDER BY idSlider DESC");
                $nr=mysqli_num_rows($csli);
                if($nr>0){
                ?>
                    <div id="myCarousel" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                          <?php
                          for($i=0;$i<$nr;$i++){
                            if($i==0){
                          ?>
                            <li data-target="#myCarousel" data-slide-to="<?php echo $i; ?>" class="active"></li>
                          <?php
                            }else{
                          ?>
                            <li data-target="#myCarousel" data-slide-to="<?php echo $i; ?>"></li>
                          <?php
                            }
                          }
                          ?>
                        </ol>

                        <!-- Wrapper for slides -->
                        <div class="carousel-inner">
                          <?php
                          $j=0;
                          while($rsli=mysqli_fetch_assoc($csli)){
                            if($j==0){
                          ?>
                            <div class="item active">
                                <img src="sisper/files_intranet/<?php echo $rsli['Imagen']; ?>">
                            </div>
                          <?php
                            }else{
                          ?>
                            <div class="item">
                                <img src="sisper/files_intranet/<?php echo $rsli['Imagen']; ?>">
                            </div>
                          <?php
                            }
                            $j++;
                          }
                          ?>
                        </div>

                        <!-- Controls -->
                        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                        </a>
                        <a class="right carousel-control" href="#myCarousel" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                        </a>
                    </div>
                  <?php
                  }
                  ?>
                </div>
            </div>
            <div class="row">
            
            <?php
                $ccat=mysqli_query($cone,"SELECT idCatDocumento, CatDocumento FROM catdocumento WHERE Estado=1");
                if(mysqli_num_rows($ccat)>0){
                    while($rcat=mysqli_fetch_assoc($ccat)){
                        $idcd=$rcat['idCatDocumento'];
            ?>
                <div class="col-md-6 col-sm-6">
                  <div class="box box-info collapsed-box">
                    <div class="box-header with-border">
                      <h3 class="box-title"><?php echo $rcat['CatDocumento'] ?></h3>

                      <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                      </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <div class="table-responsive pscroll">
                        <table class="table no-margin">
                          <tbody>
                          <?php
                            $cdoc=mysqli_query($cone,"SELECT idDocumento, Descripcion, Adjunto FROM documento WHERE idCatDocumento=$idcd AND Estado=1 ORDER BY Descripcion ASC");
                            if(mysqli_num_rows($cdoc)>0){
                                while ($rdoc=mysqli_fetch_assoc($cdoc)) {                             
                          ?>
                          <tr>
                            <td><i class="fa fa-file-text-o cinfo"></i></td>
                            <td><a href="sisper/files_intranet/<?php echo $rdoc['Adjunto']; ?>" target="_blank"><?php echo $rdoc['Descripcion'] ?></a></td>
                          </tr>
                          <?php
                                }
                            }else{
                          ?>
                          <tr>
                            <td><i class="fa fa-file-text-o cinfo"></i></td>
                            <td>No hay documentos</td>
                          </tr>
                          <?php
                            }
                            mysqli_free_result($cdoc);
                          ?>
                          </tbody>
                        </table>
                      </div>
                      <!-- /.table-responsive -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">

                    </div>
                    <!-- /.box-footer -->
                  </div>
                </div>
            <?php
                    }
                }
                mysqli_free_result($ccat);
            ?>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                  <div class="box box-info collapsed-box">
                    <div class="box-header with-border">
                      <h3 class="box-title">Directorio Institucional</h3>

                      <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                      </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <div class="form-group">
                          <label for="per">Personal</label>
                          <select id="per" name="per" class="form-control select2" style="width: 100%;">
                            <?php
                              $c1=mysqli_query($cone, "SELECT e.idEmpleado, NombreCom FROM enombre e INNER JOIN empleadocargo ec ON e.idEmpleado=ec.idEmpleado WHERE ec.idEstadoCar=1;");
                              if(mysqli_num_rows($c1)>0){
                                while ($r1=mysqli_fetch_assoc($c1)) {
                            ?>
                            <option value="<?php echo $r1['idEmpleado']; ?>"><?php echo $r1['NombreCom']; ?></option>
                            <?php
                                }
                              }
                              mysqli_free_result($c1);
                            ?>
                          </select>
                        </div>

                        <button class="btn btn-default pull-right" id="dirper" data-toggle="modal" data-target="#mdirectorio"><i class="fa fa-search"></i></button>

                      <div class="clearfix"></div>

                        <div class="form-group">
                          <label for="dep">Dependencia</label>
                          <select id="dep" name="dep" class="form-control select2" style="width: 100%;">
                            <?php
                              $c2=mysqli_query($cone, "SELECT idDependencia, Denominacion FROM dependencia WHERE Estado=1;");
                              if(mysqli_num_rows($c2)>0){
                                while ($r2=mysqli_fetch_assoc($c2)) {
                            ?>
                            <option value="<?php echo $r2['idDependencia']; ?>"><?php echo $r2['Denominacion']; ?></option>
                            <?php
                                }
                              }
                              mysqli_free_result($c2);
                            ?>
                          </select>
                        </div>

                        <button class="btn btn-default pull-right" id="dirdep" data-toggle="modal" data-target="#mdirectorio"><i class="fa fa-search"></i></button>


                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">

                    </div>
                    <!-- /.box-footer -->
                  </div>
                </div>
                <div class="col-md-12 col-sm-12">
                  <div class="box box-warning">
                    <div class="box-header with-border">
                      <h3 class="box-title">Comunicados</h3>

                      <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                      </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <div class="table-responsive">
                        <table class="table no-margin">
                          <tbody>
                            <?php
                            $fecha=@date('Y-m-d');
                            $cco=mysqli_query($cone,"SELECT idComunicado, Descripcion FROM comunicado WHERE Estado=1 AND Fecha<='$fecha' ORDER BY Fecha DESC, idComunicado DESC LIMIT 10");
                            if(mysqli_num_rows($cco)>0){
                                while($rco=mysqli_fetch_assoc($cco)){
                            ?>
                            <tr>
                                <td><i class="fa fa-bullhorn cwarning"></i></td>
                                <td><a href="#" data-toggle="modal" data-target="#mcomunicado" onclick="vcomunicado(<?php echo $rco["idComunicado"] ?>)"><?php echo $rco['Descripcion'] ?></a></td>
                            </tr>
                            <?php
                                }
                            }else{
                            ?>
                            <tr>
                                <td><i class="fa fa-bell-o cwarning"></i></td>
                                <td>No hay comunicados</td>
                            </tr>
                            <?php
                            }
                            mysqli_free_result($cco);
                            ?>
                          </tbody>
                        </table>
                      </div>
                      <!-- /.table-responsive -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">

                    </div>
                    <!-- /.box-footer -->
                  </div>
                </div>
                <div class="col-md-12 col-sm-12">
                  <div class="box box-danger">
                    <div class="box-header with-border">
                      <h3 class="box-title">¡Felicidades!</h3>

                      <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                      </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <div class="table-responsive">
                        <table class="table no-margin">
                          <tbody>
                            <?php
                            $ccum=mysqli_query($cone,"SELECT ApellidoPat, ApellidoMat, Nombres FROM empleado AS e INNER JOIN empleadocargo AS ec ON e.idEmpleado=ec.idEmpleado WHERE idEstadoCar=1 AND date_format(FechaNac, '%m') = date_format(now(), '%m') AND date_format(FechaNac, '%d') = date_format(now(), '%d') ORDER BY ApellidoPat, ApellidoMat ASC");
                            if(mysqli_num_rows($ccum)>0){
                                while($rcum=mysqli_fetch_assoc($ccum)){
                            ?>
                            <tr>
                                <td><i class="fa fa-birthday-cake cdanger"></i></td>
                                <td><?php echo $rcum['ApellidoPat']." ".$rcum['ApellidoMat'].", ".$rcum['Nombres'] ?></td>
                            </tr>
                            <?php
                                }
                            }else{
                            ?>
                            <tr>
                                <td><i class="fa fa-meh-o cdanger"></i></td>
                                <td>Hoy nadie cumple años</td>
                            </tr>
                            <?php
                            }
                            mysqli_free_result($ccum);
                            ?>
                          </tbody>
                        </table>
                      </div>
                      <!-- /.table-responsive -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">

                    </div>
                    <!-- /.box-footer -->
                  </div>
                </div>
                <div class="col-md-12 col-sm-12">
                  <div class="box box-success collapsed-box">
                    <div class="box-header with-border">
                      <h3 class="box-title">Boletines</h3>

                      <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                      </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <div class="table-responsive">
                        <table class="table no-margin">
                          <tbody>
                          <?php
                            $cbol=mysqli_query($cone,"SELECT Descripcion, Adjunto FROM boletin WHERE Estado=1 AND Fecha<='$fecha' ORDER BY Fecha DESC LIMIT 12");
                            if(mysqli_num_rows($cbol)){
                                while($rbol=mysqli_fetch_assoc($cbol)){
                          ?>
                            <tr>
                                <td><i class="fa fa-newspaper-o csuccess"></i></td>
                                <td><a href="sisper/files_intranet/<?php echo $rbol['Adjunto'] ?>" target="_blank"><?php echo $rbol['Descripcion']; ?></a></td>
                            </tr>
                          <?php
                                }
                            }else{
                          ?>
                            <tr>
                                <td><i class="fa fa-newspaper-o csuccess"></i></td>
                                <td>No hay boletines</td>
                            </tr>
                          <?php
                            }
                            mysqli_free_result($cbol);
                          ?>
                          </tbody>
                        </table>
                      </div>
                      <!-- /.table-responsive -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">

                    </div>
                    <!-- /.box-footer -->
                  </div>
                </div>
            </div>
        </div>
    </div>
    <div class="well enlaces">
        <div id="misEnlaces" class="carousel slide" data-ride="carousel">
              <!-- Indicators -->
              <ol class="carousel-indicators">
                <li data-target="#misEnlaces" data-slide-to="0" class="active"></li>
                <li data-target="#misEnlaces" data-slide-to="1"></li>
                <li data-target="#misEnlaces" data-slide-to="2"></li>
              </ol>

            <!-- Carousel items -->
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <div class="row">
                        <div class="col-sm-2"><a href="http://www.bn.com.pe/" class="thumbnail" target="_blank"><img src="images/links/bn.png" alt="Image" class="img-responsive"></a>
                        </div>
                        <div class="col-sm-2"><a href="https://www.cnm.gob.pe/" class="thumbnail" target="_blank"><img src="images/links/cnm.png" alt="Image" class="img-responsive"></a>
                        </div>
                        <div class="col-sm-2"><a href="http://www.inpe.gob.pe/" class="thumbnail" target="_blank"><img src="images/links/inpe.png" alt="Image" class="img-responsive"></a>
                        </div>
                        <div class="col-sm-2"><a href="http://www.essalud.gob.pe/" class="thumbnail" target="_blank"><img src="images/links/essalud.png" alt="Image" class="img-responsive"></a>
                        </div>
                        <div class="col-sm-2"><a href="https://www.pj.gob.pe/" class="thumbnail" target="_blank"><img src="images/links/pj.png" alt="Image" class="img-responsive"></a>
                        </div>
                        <div class="col-sm-2"><a href="http://www.sunat.gob.pe/" class="thumbnail" target="_blank"><img src="images/links/sunat.png" alt="Image" class="img-responsive"></a>
                        </div>
                    </div>
                    <!--/row-->
                </div>
                <!--/item-->
                <div class="item">
                    <div class="row">
                        <div class="col-sm-2"><a href="http://www.mimp.gob.pe/" class="thumbnail" target="_blank"><img src="images/links/mimp.png" alt="Image" class="img-responsive"></a>
                        </div>
                        <div class="col-sm-2"><a href="https://www.mininter.gob.pe/" class="thumbnail" target="_blank"><img src="images/links/mininter.png" alt="Image" class="img-responsive"></a>
                        </div>
                        <div class="col-sm-2"><a href="http://www.minsa.gob.pe/" class="thumbnail" target="_blank"><img src="images/links/minsa.png" alt="Image" class="img-responsive"></a>
                        </div>
                        <div class="col-sm-2"><a href="https://www.oefa.gob.pe/" class="thumbnail" target="_blank"><img src="images/links/oefa.png" alt="Image" class="img-responsive"></a>
                        </div>
                        <div class="col-sm-2"><a href="https://www.onp.gob.pe/" class="thumbnail" target="_blank"><img src="images/links/onp.png" alt="Image" class="img-responsive"></a>
                        </div>
                        <div class="col-sm-2"><a href="http://portal.osce.gob.pe/osce/" class="thumbnail" target="_blank"><img src="images/links/osce.png" alt="Image" class="img-responsive"></a>
                        </div>
                    </div>
                    <!--/row-->
                </div>
                <!--/item-->
                <div class="item">
                    <div class="row">
                        <div class="col-sm-2"><a href="https://www.osiptel.gob.pe/" class="thumbnail" target="_blank"><img src="images/links/osiptel.png" alt="Image" class="img-responsive"></a>
                        </div>
                        <div class="col-sm-2"><a href="https://www.indecopi.gob.pe/inicio" class="thumbnail" target="_blank"><img src="images/links/indecopi.png" alt="Image" class="img-responsive"></a>
                        </div>
                        <div class="col-sm-2"><a href="http://www.defensoria.gob.pe/" class="thumbnail" target="_blank"><img src="images/links/defensoria.png" alt="Image" class="img-responsive"></a>
                        </div>
                        <div class="col-sm-2"><a href="http://www.promperu.gob.pe/" class="thumbnail" target="_blank"><img src="images/links/promperu.png" alt="Image" class="img-responsive"></a>
                        </div>
                        <div class="col-sm-2"><a href="http://www.vivienda.gob.pe/" class="thumbnail" target="_blank"><img src="images/links/vivienda.png" alt="Image" class="img-responsive"></a>
                        </div>
                        <div class="col-sm-2"><a href="http://www.contraloria.gob.pe/wps/portal/portalcgrnew/siteweb/inicio/" class="thumbnail" target="_blank"><img src="images/links/contraloria.png" alt="Image" class="img-responsive"></a>
                        </div>
                    </div>
                    <!--/row-->
                </div>
                <!--/item-->
            </div>
            <!-- Left and right controls -->
            <a class="left carousel-control" href="#misEnlaces" role="button" data-slide="prev">
              <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#misEnlaces" role="button" data-slide="next">
              <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
        </div>
        <!--/myCarousel-->
    </div>
    <!--/well-->

</div>

    <!-- Page Content -->

<!-- Modal Comunicado-->
<div class="modal fade" id="mcomunicado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-bullhorn text-orange"></i> Comunicado</h4>
      </div>
      <div class="modal-body d_rcomunicado">
        
      </div>
    </div>
  </div>
</div>

<!-- Modal Directorio Personal-->
<div class="modal fade" id="mdirectorio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-book text-orange"></i> Directorio</h4>
      </div>
      <div class="modal-body d_rdirectorio">
        
      </div>
    </div>
  </div>
</div> 


<hr>

<!-- Footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <p>Oficina de informática y Sistemas</p>
                <p>Teléfono: (076) 365577 Anexo 1015, Correo: informatica.cajamarca@djmail.mpfn.gob.pe</p>
            </div>
        </div>
    </div>
</footer>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="plugins/pace/pace.js"></script>
    <script src="plugins/select2/select2.min.js"></script>
    <!-- AdminLTE App -->
    <script src="sisper/dist/js/app.min.js"></script>

    <script src="js/main.js"></script>

</body>

</html>
