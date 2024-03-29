<?php include ("seguridad.php");?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Ingreso</title>

  <!-- Bootstrap core CSS -->

  <link href="css/bootstrap.min.css" rel="stylesheet">

  <link href="fonts/css/font-awesome.min.css" rel="stylesheet">
  <link href="css/animate.min.css" rel="stylesheet">

  <!-- Custom styling plus plugins -->
  <link href="css/custom.css" rel="stylesheet">
  <link href="css/icheck/flat/green.css" rel="stylesheet">
  <!-- editor -->
  <link href="http://netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">
  <link href="css/editor/external/google-code-prettify/prettify.css" rel="stylesheet">
  <link href="css/editor/index.css" rel="stylesheet">
  <!-- select2 -->
  <link href="css/select/select2.min.css" rel="stylesheet">
  <!-- switchery -->
  <link rel="stylesheet" href="css/switchery/switchery.min.css" />

  <script src="js/jquery.min.js"></script>

  <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

</head>


<body class="nav-md">

  <div class="container body">


    <div class="main_container">

      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">

          <div class="navbar nav_title" style="border: 0;">
            <a href="index.html" class="site_title"><span>MP - FISCALIA</span></a>
          </div>
          <div class="clearfix"></div>

          <br />
          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

            <div class="menu_section">
              <ul class="nav side-menu">
                <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
                <li><a href="ingreso.php"><i class="fa fa-edit"></i>Ingreso</a></li>
				<li><a href="inventario.php"><i class="fa fa-table"></i>Salida</a></li>
                <li><a href="consulta.php"><i class="fa fa-search"></i>Consulta</a></li>
				<li><a href="consulta_ingresos.php"><i class="fa fa-search"></i>Boletas de Ingreso</a></li>
				<li><a href="consulta_salidas.php"><i class="fa fa-search"></i>Boletas de Salida</a></li>
				<li><a href="evidencias.php"><i class="fa fa-archive"></i>Evidencias</a></li>
              </ul>
            </div>

          </div>
          <!-- /sidebar menu -->

          <!-- /menu footer buttons -->
          <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Settings">
              <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
              <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock">
              <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a href="end.php" data-toggle="tooltip" data-placement="top" title="Logout">
              <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
          </div>
          <!-- /menu footer buttons -->
        </div>
      </div>

      <!-- top navigation -->
      <div class="top_nav">

        <div class="nav_menu">
          <nav class="" role="navigation">
            <div class="nav toggle">
              <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>
			</nav>
        </div>

      </div>
      <!-- /top navigation -->

      <!-- page content -->
      <div class="right_col" role="main">
        <div class="">

          <script type="text/javascript">
            $(document).ready(function() {
              $('#birthday').daterangepicker({
                singleDatePicker: true,
                calender_style: "picker_4"
              }, function(start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
              });
            });
          </script>


          <div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                  <h2>Internamiento<small>Bienes / Elementos</small></h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
              <div class="x_content">
<?php
include("conect.php");
$sql=conect();
$codigo=$_GET['id'];
$lib = mysqli_query($sql,"select * from inventario where id=$codigo");
$rs_lib = mysqli_fetch_assoc($lib);
$boleta= $rs_lib['b_salida'];
?>
				   	<table id="datatable-buttons" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>B-Ingreso</th>
                        <th>F-Ingreso</th>
						<th>Ubicacion</th>
                        <th>Caso</th>
                        <th>Descripcion</th>
                        <th>Marca</th>
                        <th>Estado</th>
						<th>Delito</th>
						<th>Fiscal</th>
                        <th>Fiscalia</th>				
                      </tr>
                    </thead>
					<tbody>
                     <tr>
                        <td><?php echo $rs_lib["b_ingreso"];?></td>
                        <td><?php echo $rs_lib["f_ingreso"];?></td>
						<td><?php echo $rs_lib["ubicaccion"];?></td>
                        <td><?php echo $rs_lib["caso"];?></td>
                        <td><?php echo $rs_lib["descripcion"];?></td>
						<td><?php echo $rs_lib["marca"];?></td>
						<td><?php echo $rs_lib["estado"];?></td>
                        <td><?php echo $rs_lib["delito"];?></td>
                        <td><?php echo $rs_lib["fiscal"];?></td>
                        <td><?php echo $rs_lib["fiscalia"];?></td>
						</tbody>
                  </table>
				  
                  <br />
                  <form class="form-horizontal form-label-left" action="modif_ag.php" method="POST">
		  			<input type="hidden" name="id" value="<?php echo $rs_lib["id"];?>">
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Boleta de Salida</label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                      <input type="text" name="boletas" class="form-control" placeholder="Numero de Boleta de Salida" value="<?php echo $boleta ?>" required>
                      </div>
                    </div>
					  <?php
					date_default_timezone_set("America/Lima");
					$fecha= date('Y-m-d');
					?>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Fecha de Salida</label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" name="fechas" class="form-control" placeholder="Fecha de Internamiento" value="<?php echo $fecha; ?>" required>
                      </div>
                    </div>
					<div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Proceso<span class="required">*</span></label></label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
					<input type="text" name="proceso" class="form-control" placeholder="Fecha de Internamiento" value="P" required>
                      </div>
                    </div>
					
					  <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Resol. Salida</label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" class="form-control" placeholder="Numero de Caso" name="resol" required>
                      </div>
                    </div>
                   
					<div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Observacion 1</label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <textarea class="form-control" rows="3" placeholder="De existir alguna observacion ingresarlo aqui" name="obs1"><?php echo $rs_lib["obs1"];?></textarea>
                      </div>
                    </div>
					<div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Observacion 2</label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <textarea class="form-control" rows="3" placeholder='De existir alguna observacion adicioal ingresarlo aqui' name="obs2"><?php echo $rs_lib["obs2"];?></textarea>
                      </div>
                    </div>
					 <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Condicion<span class="required">*</span></label></label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <select class="form-control" name="condicion" required="required" >
                          <option><?php echo $rs_lib["condicion"];?></option>
                          <option value="custodia">Custodia</option>
                          <option value="destruccion">Destruccion</option>
                          <option value="devolucion">Devolucion</option>
                          <option value="incineracion">Incineracion</option>
                        </select>
                      </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
						<input type="reset" name="Borrar" value="Borrar" class="btn btn-primary">
						<input type="submit" name="Registrar" value="Registrar" class="btn btn-success">
                      </div>
                    </div>

                  </form>
              </div>
            </div>
            </div>
</div>


</div>
        <!-- /page content -->

      </div>

    </div>
  </div>

  <script src="js/bootstrap.min.js"></script>

  <!-- bootstrap progress js -->
  <script src="js/progressbar/bootstrap-progressbar.min.js"></script>
  <script src="js/nicescroll/jquery.nicescroll.min.js"></script>
  <!-- icheck -->
  <script src="js/icheck/icheck.min.js"></script>
  <!-- tags -->
  <script src="js/tags/jquery.tagsinput.min.js"></script>
  <!-- switchery -->
  <script src="js/switchery/switchery.min.js"></script>
  <!-- daterangepicker -->
  <script type="text/javascript" src="js/moment/moment.min.js"></script>
  <script type="text/javascript" src="js/datepicker/daterangepicker.js"></script>
  <!-- richtext editor -->
  <script src="js/editor/bootstrap-wysiwyg.js"></script>
  <script src="js/editor/external/jquery.hotkeys.js"></script>
  <script src="js/editor/external/google-code-prettify/prettify.js"></script>
  <!-- select2 -->
  <script src="js/select/select2.full.js"></script>
  <!-- form validation -->
  <script type="text/javascript" src="js/parsley/parsley.min.js"></script>
  <!-- textarea resize -->
  <script src="js/textarea/autosize.min.js"></script>
  <script>
    autosize($('.resizable_textarea'));
  </script>
  <!-- Autocomplete -->
  <script type="text/javascript" src="js/autocomplete/countries.js"></script>
  <script src="js/autocomplete/jquery.autocomplete.js"></script>
  <!-- pace -->
  <script src="js/pace/pace.min.js"></script>
  <script type="text/javascript">
    $(function() {
      'use strict';
      var countriesArray = $.map(countries, function(value, key) {
        return {
          value: value,
          data: key
        };
      });
      // Initialize autocomplete with custom appendTo:
      $('#autocomplete-custom-append').autocomplete({
        lookup: countriesArray,
        appendTo: '#autocomplete-container'
      });
    });
  </script>
  <script src="js/custom.js"></script>


  <!-- select2 -->
  <script>
    $(document).ready(function() {
      $(".select2_single").select2({
        placeholder: "Select a state",
        allowClear: true
      });
      $(".select2_group").select2({});
      $(".select2_multiple").select2({
        maximumSelectionLength: 4,
        placeholder: "With Max Selection limit 4",
        allowClear: true
      });
    });
  </script>
  <!-- /select2 -->
  <!-- input tags -->
  <script>
    function onAddTag(tag) {
      alert("Added a tag: " + tag);
    }

    function onRemoveTag(tag) {
      alert("Removed a tag: " + tag);
    }

    function onChangeTag(input, tag) {
      alert("Changed a tag: " + tag);
    }

    $(function() {
      $('#tags_1').tagsInput({
        width: 'auto'
      });
    });
  </script>
  <!-- /input tags -->
  <!-- form validation -->
  <script type="text/javascript">
    $(document).ready(function() {
      $.listen('parsley:field:validate', function() {
        validateFront();
      });
      $('#demo-form .btn').on('click', function() {
        $('#demo-form').parsley().validate();
        validateFront();
      });
      var validateFront = function() {
        if (true === $('#demo-form').parsley().isValid()) {
          $('.bs-callout-info').removeClass('hidden');
          $('.bs-callout-warning').addClass('hidden');
        } else {
          $('.bs-callout-info').addClass('hidden');
          $('.bs-callout-warning').removeClass('hidden');
        }
      };
    });

    $(document).ready(function() {
      $.listen('parsley:field:validate', function() {
        validateFront();
      });
      $('#demo-form2 .btn').on('click', function() {
        $('#demo-form2').parsley().validate();
        validateFront();
      });
      var validateFront = function() {
        if (true === $('#demo-form2').parsley().isValid()) {
          $('.bs-callout-info').removeClass('hidden');
          $('.bs-callout-warning').addClass('hidden');
        } else {
          $('.bs-callout-info').addClass('hidden');
          $('.bs-callout-warning').removeClass('hidden');
        }
      };
    });
    try {
      hljs.initHighlightingOnLoad();
    } catch (err) {}
  </script>
  <!-- /form validation -->
  <!-- editor -->
  <script>
    $(document).ready(function() {
      $('.xcxc').click(function() {
        $('#descr').val($('#editor').html());
      });
    });

    $(function() {
      function initToolbarBootstrapBindings() {
        var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier',
            'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
            'Times New Roman', 'Verdana'
          ],
          fontTarget = $('[title=Font]').siblings('.dropdown-menu');
        $.each(fonts, function(idx, fontName) {
          fontTarget.append($('<li><a data-edit="fontName ' + fontName + '" style="font-family:\'' + fontName + '\'">' + fontName + '</a></li>'));
        });
        $('a[title]').tooltip({
          container: 'body'
        });
        $('.dropdown-menu input').click(function() {
            return false;
          })
          .change(function() {
            $(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');
          })
          .keydown('esc', function() {
            this.value = '';
            $(this).change();
          });

        $('[data-role=magic-overlay]').each(function() {
          var overlay = $(this),
            target = $(overlay.data('target'));
          overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
        });
        if ("onwebkitspeechchange" in document.createElement("input")) {
          var editorOffset = $('#editor').offset();
          $('#voiceBtn').css('position', 'absolute').offset({
            top: editorOffset.top,
            left: editorOffset.left + $('#editor').innerWidth() - 35
          });
        } else {
          $('#voiceBtn').hide();
        }
      };

      function showErrorAlert(reason, detail) {
        var msg = '';
        if (reason === 'unsupported-file-type') {
          msg = "Unsupported format " + detail;
        } else {
          console.log("error uploading file", reason, detail);
        }
        $('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>' +
          '<strong>File upload error</strong> ' + msg + ' </div>').prependTo('#alerts');
      };
      initToolbarBootstrapBindings();
      $('#editor').wysiwyg({
        fileUploadError: showErrorAlert
      });
      window.prettyPrint && prettyPrint();
    });
  </script>
  <!-- /editor -->
</body>

</html>
