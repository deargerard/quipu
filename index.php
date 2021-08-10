<?php
    include ("sisper/m_inclusiones/php/conexion_sp.php");
    include ("ajax/a_coneenc.php");
    include ("sisper/m_inclusiones/php/funciones.php");
?>
<!DOCTYPE html>
<html lang="es">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="Gerardo Intor">
  <meta http-equiv="refresh" content="900">
  <link rel="shortcut icon" href="favicon.ico">

  <title>Intranet - Ministerio Público - Distrito Fiscal de Cajamarca</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  
  <!-- select2 -->
  <link href="vendor/select2/css/select2.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/select2/css/select2-bootstrap4.min.css" rel="stylesheet" type="text/css">

  <link rel="stylesheet" type="text/css" href="vendor/DataTables/datatables.min.css"/>

  <!-- Custom styles for this template -->
  <link href="css/agency.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
    <div class="container-fluid">
       
      <a class="navbar-brand js-scroll-trigger" href="#page-top"><img src="img/logos/logo_p.png" class="img-fluid"></a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav text-uppercase ml-auto">
          <li class="nav-item" style="border-left: 1px dotted #337299;">
            <a class="nav-link js-scroll-trigger" href="#anuncios"><i class="fa fa-bullhorn"></i> Anuncios</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#noticias"><i class="fa fa-newspaper"></i> Noticias</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#directorio"><i class="fa fa-address-book"></i> Directorio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#enlaces"><i class="fa fa-link"></i> Enlaces</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#documentos"><i class="fa fa-file-pdf"></i> Documentos/Boletines</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#cumpleanos"><i class="fa fa-birthday-cake"></i> Cumpleaños</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- comunicados -->
  <section id="anuncios">
    <div class="container-fluid">
      <div class="row">

        <div class="col-lg-9">
        
        <?php
        $cs=mysqli_query($cone, "SELECT * FROM slider WHERE Estado=1 ORDER BY idSlider DESC;");
        if(mysqli_num_rows($cs)>0){
        ?>  

          <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators top-indicator">
            <?php
            for ($i=0; $i < mysqli_num_rows($cs); $i++) { 
            ?>
              <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $i; ?>" <?php echo $i==0 ? 'class="active"' : ''; ?>></li>
            <?php
            }
            ?>
            </ol>
            <div class="carousel-inner">
            <?php
            $n=0;
            while($rs=mysqli_fetch_assoc($cs)){
            ?>
              <div class="carousel-item <?php echo $n==0 ? 'active' : ''; ?> imagen">
                <img src="sisper/files_intranet/<?php echo $rs['Imagen']; ?>" class="d-block w-100">
              </div>              
            <?php
              $n++;
            }
            ?>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>
        <?php
        }
        mysqli_free_result($cs);
        ?>
        </div>

        <div class="col-lg-3" style="border-left: 1px dotted #dee2e6">
          <p class="text-center" style="font-size: 14px; font-style: italic;"><i class="fa fa-street-view text-info"></i> Cajamarca, <?php echo date('d'); ?> de <?php echo nombremes(date('m')); ?> de <?php echo date('Y'); ?></p>
          <hr>
          <h5 class="section-heading text-center" style="font-style: italic;"><i class="fa fa-bullhorn text-primary"></i> Anuncios</h5><br>
          <div class="row">
          <?php
          $cc=mysqli_query($cone, "SELECT idComunicado, Fecha, Descripcion FROM comunicado WHERE Estado=1 ORDER BY Fecha DESC LIMIT 7;");
          if(mysqli_num_rows($cc)>0){
            while($rc=mysqli_fetch_assoc($cc)){
          ?>
              <div class="col-sm-12">

                <span class="text-info" style="font-size: 11px;"><i class="fas fa-calendar-alt text-primary" style="font-size: 16px;"></i> <?php echo fnormal($rc['Fecha']); ?></span> | <a href="#" onclick="anuncio(<?php echo $rc['idComunicado']; ?>);" data-toggle="modal" data-target="#imodal"><?php echo $rc['Descripcion']; ?></a>
                <hr>
              </div>
          <?php
            }
          }
          mysqli_free_result($cc);
          ?>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- Noticias -->
  <section class="bg-light" id="noticias">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading"><i class="fa fa-newspaper text-primary"></i> Noticias</h2>
        </div>
      </div>
      <div class="row">
          <!--Start include wrapper-->
          <div class="include-wrapper pb-5 col-12">
              <!--SECTION START-->
              <section class="row">
                  <!--Start slider news-->
                  <div class="col-12 col-md-6 pb-0 pb-md-3 pt-2 pr-md-1">
                  <?php
                  $cns=mysqli_query($cone, "SELECT * FROM noticia WHERE Estado=1 ORDER BY idNoticia DESC LIMIT 4;");
                  if(mysqli_num_rows($cns)>0){
                  ?>
                      <div id="featured" class="carousel slide" data-ride="carousel">
                          <!--slider navigate-->
                          <ol class="carousel-indicators top-indicator">
                          <?php
                          for ($i=0; $i < mysqli_num_rows($cns); $i++) { 
                          ?>
                              <li data-target="#featured" data-slide-to="<?php echo $i; ?>" <?php echo $i==0 ? 'class="active"' : ''; ?>></li>
                          <?php
                          }
                          ?>
                          </ol>
                          
                          <!--carousel inner-->
                          <div class="carousel-inner">
                          <?php
                          $n=0;
                          while($rns=mysqli_fetch_assoc($cns)){
                          ?>
                              <!--Item slider-->
                              <div class="carousel-item <?php echo $n==0 ? 'active' : ''; ?> ">
                                  <div class="card border-0 rounded-0 text-light overflow zoom">
                                      <!--thumbnail-->
                                      <div class="position-relative">
                                          <!--thumbnail img-->
                                          <div class="ratio_left-cover-1 image-wrapper">
                                              <a href="#" onclick="noticia(<?php echo $rns['idNoticia']; ?>);" data-toggle="modal" data-target="#imodal">
                                                  <img class="img-fluid w-100"
                                                       src="sisper/files_intranet/<?php echo $rns['Imagen']; ?>">
                                              </a>
                                          </div>
                                          
                                          <!--title-->
                                          <div class="position-absolute p-2 p-lg-3 b-0 w-100 bg-shadow">
                                              <!-- meta title -->
                                              <div class="news-meta">
                                                  <span class="news-date text-primary" style="font-weight: 800;"><i class="fas fa-calendar-alt"></i> <?php echo fnormal($rns['Fecha']); ?></span>
                                              </div>
                                              <!--title and description-->
                                              <a href="#" onclick="noticia(<?php echo $rns['idNoticia']; ?>);" data-toggle="modal" data-target="#imodal">
                                                  <h3 class="h3 post-title text-white my-1"><?php echo $rns['Titular']; ?></h3>
                                              </a>

                                              
                                          </div>
                                          <!--end title-->
                                      </div>
                                      <!--end thumbnail-->
                                  </div>
                              </div>
                          <?php
                            $n++;
                          }
                          ?>

                              <!--end item slider-->
                          </div>
                          <!--end carousel inner-->
                      </div>
                      <!--navigation-->
                      <a class="carousel-control-prev" href="#featured" role="button" data-slide="prev">
                          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                          <span class="sr-only">Previous</span>
                      </a>
                      <a class="carousel-control-next" href="#featured" role="button" data-slide="next">
                          <span class="carousel-control-next-icon" aria-hidden="true"></span>
                          <span class="sr-only">Next</span>
                      </a>
                  <?php
                  }
                  mysqli_free_result($cns);
                  ?>
                  </div>
                  <!--End slider news-->
                  
                  <!--Start box news-->
                  <div class="col-12 col-md-6 pt-2 pl-md-1 mb-3 mb-lg-4">
                      <div class="row">
                      <?php
                      $cn=mysqli_query($cone, "SELECT * FROM noticia WHERE Estado=1 ORDER BY idNoticia DESC LIMIT 5,4");
                      if(mysqli_num_rows($cn)>0){
                        while($rn=mysqli_fetch_assoc($cn)){
                      ?>
                          <!--news box-->
                          <div class="col-6 pb-1 pt-0 pr-1">
                              <div class="card border-0 rounded-0 text-white overflow zoom">
                                  <!--thumbnail-->
                                  <div class="position-relative">
                                      <!--thumbnail img-->
                                      <div class="ratio_right-cover-2 image-wrapper">
                                          <a href="#" onclick="noticia(<?php echo $rn['idNoticia']; ?>);" data-toggle="modal" data-target="#imodal">
                                              <img class="img-fluid"
                                                   src="sisper/files_intranet/<?php echo $rn['Imagen']; ?>">
                                          </a>
                                      </div>
                                      
                                      <!--title-->
                                      <div class="position-absolute p-2 p-lg-3 b-0 w-100 bg-shadow">
                                          <!-- category -->
                                          <span class="date_n_p text-primary"><i class="fas fa-calendar-alt" style="font-size: 12px;"></i> <?php echo fnormal($rn['Fecha']); ?></span>
                                          <!--title and description-->
                                          <a href="#" onclick="noticia(<?php echo $rn['idNoticia']; ?>);" data-toggle="modal" data-target="#imodal">
                                              <h4 class="h5 text-white my-1"><?php echo $rn['Titular']; ?></h4>
                                          </a>
                                      </div>
                                      <!--end title-->
                                  </div>
                                  <!--end thumbnail-->
                              </div>
                          </div>
                      <?php
                        }
                      }
                      mysqli_free_result($cn);
                      ?>

                          <!--end news box-->
                      </div>
                  </div>
                  <!--End box news-->
              </section>
              <!--END SECTION-->
          </div>
      </div>
    </div>
  </section>

  <!-- Services -->
  <section id="directorio">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading"><i class="fa fa-address-book text-primary"></i> Directorio</h2>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="per"><i class="fa fa-male text-info"></i> Persona</label>
            <select class="form-control select2peract" id="per">

            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="dep"><i class="fa fa-building text-info"></i> Dependencia</label>
            <select class="form-control select2depact" id="dep">

            </select>
          </div>
        </div>
      </div>
      <div class="row text-center">
        <div class="col-md-12" id="r_directorio">
          <h1><i class="fa fa-address-card text-muted"></i></h1>
        </div>
      </div>
    </div>
  </section>

  <!-- enlaces -->
  <section class="bg-light" id="enlaces">
    <div class="container text-center">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading"><i class="fa fa-link text-primary"></i> Enlaces</h2>
        </div>
      </div>
      <div class="row">
        <div class="col-md-2">
          <table class="table table-hover table-bordered">
            <tr>
              <td>
                <i class="far fa-user-circle text-info"></i> <a href="sisper/" target="_blank"> Quipu</a>
              </td>
            </tr>
          </table>
        </div>
        <div class="col-md-2">
          <table class="table table-hover table-bordered">
            <tr>
              <td>
                <i class="fas fa-fingerprint text-info"></i> <a href="asistencia/" target="_blank"> Asistencia</a>
              </td>
            </tr>
          </table>
        </div>
        <div class="col-md-2">
          <table class="table table-hover table-bordered">
            <tr>
              <td>
                <i class="fas fa-archive text-info"></i> <a href="incautaciones_new/" target="_blank"> Incautaciones</a>
              </td>
            </tr>
          </table>
        </div>
        <div class="col-md-2">
          <table class="table table-hover table-bordered">
            <tr>
              <td>
                <i class="fas fa-clipboard text-info"></i> <a href="notificaciones/" target="_blank"> Notificaciones</a>
              </td>
            </tr>
          </table>
        </div>
        <div class="col-md-2">
          <table class="table table-hover table-bordered">
            <tr>
              <td>
                <i class="fab fa-chrome text-info"></i> <a href="http://intranet.mpfn.gob.pe/" target="_blank"> Intranet MP</a>
              </td>
            </tr>
          </table>
        </div>
        <div class="col-md-2">
          <table class="table table-hover table-bordered">
            <tr>
              <td>
                <i class="fab fa-draft2digital text-info"></i> <a href="https://sistemas2.mpfn.gob.pe/" target="_blank"> Sistemas2</a>
              </td>
            </tr>
          </table>
        </div>
        <div class="col-md-2">
          <table class="table table-hover table-bordered">
            <tr>
              <td>
                <i class="fab fa-draft2digital text-info"></i> <a href="https://sistemas.mpfn.gob.pe/" target="_blank"> Sistemas</a>
              </td>
            </tr>
          </table>
        </div>
        <div class="col-md-2">
          <table class="table table-hover table-bordered">
            <tr>
              <td>
                <i class="fas fa-file-signature text-info"></i> <a href="https://cea.mpfn.gob.pe/siscea/login.do" target="_blank"> CEA</a>
              </td>
            </tr>
          </table>
        </div>
        <div class="col-md-2">
          <table class="table table-hover table-bordered">
            <tr>
              <td>
                <i class="fas fa-envelope text-info"></i> <a href="https://mail.google.com" target="_blank"> Correo</a>
              </td>
            </tr>
          </table>
        </div>
        <div class="col-md-2">
          <table class="table table-hover table-bordered">
            <tr>
              <td>
                <i class="fas fa-university text-info"></i> <a href="http://aulavirtual.mpfn.gob.pe/login/index.php" target="_blank"> Aula Virtual</a>
              </td>
            </tr>
          </table>
        </div>
        <div class="col-md-2">
          <table class="table table-hover table-bordered">
            <tr>
              <td>
                <i class="fas fa-balance-scale text-info"></i> <a href="https://casillas.pj.gob.pe/msiap/faces/login.jsp" target="_blank"> MSIAP PJ</a>
              </td>
            </tr>
          </table>
        </div>
        <div class="col-md-2">
          <table class="table table-hover table-bordered">
            <tr>
              <td>
                <i class="fas fa-mail-bulk text-info"></i> <a href="https://casillas.pj.gob.pe/sinoe/" target="_blank"> SINOE PJ</a>
              </td>
            </tr>
          </table>
        </div>
        <div class="col-md-2">
          <table class="table table-hover table-bordered">
            <tr>
              <td>
                <i class="fab fa-firefox text-info"></i> <a href="http://antecedentes.inpe.gob.pe/sip_uk/index.php/login/user/2446652" target="_blank"> INPE A. J.</a>
              </td>
            </tr>
          </table>
        </div>
        <div class="col-md-2">
          <table class="table table-hover table-bordered">
            <tr>
              <td>
                <i class="fas fa-user-secret text-info"></i> <a href="https://portal.mpfn.gob.pe/consultarena" target="_blank"> RENADESPPLE</a>
              </td>
            </tr>
          </table>
        </div>
        <div class="col-md-2">
          <table class="table table-hover table-bordered">
            <tr>
              <td>
                <i class="far fa-newspaper text-info"></i> <a href="https://elperuano.pe/" target="_blank"> El Peruano</a>
              </td>
            </tr>
          </table>
        </div>
        
      </div>
    </div>
  </section>

  <!-- Documentos/Boletines -->
  <section id="documentos">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading"><i class="fa fa-file-pdf text-primary"></i> Documentos/Boletines</h2>
        </div>
      </div>
      <div class="row">
      <?php
      $ccd=mysqli_query($cone, "SELECT * FROM catdocumento WHERE Estado=1 ORDER BY CatDocumento ASC;");
      if(mysqli_num_rows($ccd)>0){
        while($rcd=mysqli_fetch_assoc($ccd)){
      ?>
        <div class="col-md-3">
            <table class="table">
              <tr>
                
                <button class="btn btn-info btn-block" style="font-weight: 400;" data-toggle="modal" data-target="#imodal" onclick="documentos(<?php echo $rcd['idCatDocumento']; ?>);"><i class="fas fa-folder text-info"></i> <?php echo $rcd['CatDocumento']; ?></button>
              </tr>
            </table>
        </div>
      <?php
        }
      }
      mysqli_free_result($ccd);
      ?>
        <div class="col-md-12">
          <hr>
        </div>
      <?php
      $cb=mysqli_query($cone, "SELECT * FROM boletin WHERE Estado=1 ORDER BY Fecha DESC LIMIT 15;");
      if(mysqli_num_rows($cb)>0){
        while($rb=mysqli_fetch_assoc($cb)){
      ?>
        <div class="col-md-4">
            <table class="table">
              <tr>
                
                <a href="sisper/files_intranet/<?php echo $rb['Adjunto']; ?>" class="btn btn-info btn-block" style="font-weight: 400; color: #ffffff;" target="_blank"><i class="fas fa-file-invoice text-info"></i> <?php echo $rb['Descripcion']; ?></a>
              </tr>
            </table>
        </div>
      <?php
        }
      }
      mysqli_free_result($cb);
      ?>
      </div>
    </div>
  </section>

  <!-- Team -->
  <section class="bg-light" id="cumpleanos">
    <div class="container">
      <div class="row text-center">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading"><i class="fa fa-birthday-cake text-primary"></i> Cumpleaños</h2>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 text-center">
          <p class="large text-muted text-center" style="font-style: italic;">¡Felicidades!</p>
          <div class="table-responsive">
            <table class="table table-hover">
            <?php
            $ccu=mysqli_query($cone, "SELECT e.idEmpleado, e.ApellidoPat, e.ApellidoMat, e.Nombres, e.FechaNac, e.NumeroDoc FROM empleado e INNER JOIN empleadocargo ec ON e.idEmpleado=ec.idEmpleado WHERE DATE_FORMAT(e.FechaNac, '%m-%d')=DATE_FORMAT(NOW(), '%m-%d') AND ec.idEstadoCar=1;");
            if(mysqli_num_rows($ccu)>0){
              while($rcu=mysqli_fetch_assoc($ccu)){
            ?>
              <tr>
                <td style="vertical-align: middle; width: 80px;"><img class="img-thumbnail img-fluid" src="<?php echo ifoto($rcu['NumeroDoc']); ?>"></td>
                <td style="vertical-align: middle;"><b class="text-info"><?php echo $rcu['ApellidoPat']." ".$rcu['ApellidoMat']." ".$rcu['Nombres']; ?></b></td>
                <td style="vertical-align: middle;"><span class="text-muted"><?php echo cargoe($cone, $rcu['idEmpleado']); ?></span><br></td>
                <td style="vertical-align: middle;"><small class="text-muted"><?php echo dependenciae($cone, $rcu['idEmpleado']); ?></small></td>
              </tr>
            <?php
              }
            }else{
            ?>
              <tr>
                <td><span class="text-muted">Hoy nadie cumple años</span></td>
              </tr>
            <?php
            }
            ?>
            </table>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-8 mx-auto text-center">
          
          <button class="btn btn-info" data-toggle="modal" data-target="#imodal" onclick="cumpleanos(<?php echo date('m'); ?>);"><i class="fa fa-calendar"></i> Cumpleñeros del mes</button>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center">
          <b><i class="fa fa-university text-primary"></i> Ministerio Público - Fiscalía de la Nación - Distrito Fiscal de Cajamarca</b><br>
          <span><i class="fas fa-map-marked-alt text-primary"></i> Jr. Sor Manuela Gil S/N - Cajamarca</span><br>
          <span><i class="fas fa-tty text-primary"></i> (076) 365577 / 362778</span><br>
          <span><i class="far fa-copyright text-primary"></i> Área de Informática <?php date('Y') ?></span><br>
        </div>
      </div>
    </div>
  </footer>

  <!-- Portfolio Modals -->

  <!-- Modal 1 -->
  <div class="portfolio-modal modal fade" id="emodal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="close-modal" data-dismiss="modal">
          <div class="lr">
            <div class="rl"></div>
          </div>
        </div>
        <div class="container">
          <div class="row">
            <div class="col-lg-8 mx-auto">
              <div class="modal-body text-center" id="eresultado">
    
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="imodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-body text-center">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <br><br>
          <div id="resultado">
            
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Plugin JavaScript -->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Plugin Select2 -->
  <script src="vendor/select2/js/select2.min.js"></script>

  <script type="text/javascript" src="vendor/DataTables/datatables.js"></script>
  <script type="text/javascript" src="vendor/push/push.min.js"></script>

  <!-- main JavaScript -->
  <script src="js/main.js"></script>

  <!-- Custom scripts for this template -->
  <script src="js/agency.js"></script>

  <script>
    <?php
    $cu=mysqli_query($cone, "SELECT * FROM comunicado WHERE Estado=1 ORDER BY Fecha DESC LIMIT 1;");
    if($ru=mysqli_fetch_assoc($cu)){
    ?>
      Notification.requestPermission();
      Push.create("¡Anuncio!", {
          body: "<?php echo html_entity_decode($ru['Descripcion']); ?>",
          icon: 'comuni.png',
          timeout: 10000,

          onClick: function () {
              window.focus();
              this.close();
          }
      });


    <?php
    }
    mysqli_free_result($cu);
    ?>
  </script>

</body>

</html>
