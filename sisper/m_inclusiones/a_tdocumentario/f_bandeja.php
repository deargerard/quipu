<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],17)){
	if(isset($_POST['acc']) && !empty($_POST['acc'])){
		$acc=iseguro($cone,$_POST['acc']);		
		$v1=iseguro($cone,$_POST['v1']);
		$v2=iseguro($cone,$_POST['v2']);
		if($acc=="agrdoc"){
?>
        <div class="row">
            <input type="hidden" name="acc" value="<?php echo $acc; ?>">
            <div class="col-sm-2">
                <label for="num">Número<small class="text-red">*</small></label>
                <input type="text" class="form-control" id="num" name="num" placeholder="001">
            </div>
            <div class="col-sm-2">
                <label for="ano">Año<small class="text-red">*</small></label>
                <div class="input-group date" id="d_ano">
                    <input type="text" class="form-control" id="ano" name="ano" placeholder="2019" value="<?php echo date('Y'); ?>">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
            </div>
            <div class="col-sm-3">
                <label for="sig">Siglas<small class="text-red">*</small></label>
                <input type="text" class="form-control" id="sig" name="sig" placeholder="MPFN-DFC-INF">
            </div>
            <div class="col-sm-5">
                <label for="ref">Referencia</label>
                <select class="form-control" id="ref" name="ref" style="width: 100%;">
                    
                </select>
            </div>
            <div class="col-sm-3">
                <label for="tipdoc">Tip. Documento<small class="text-red">*</small></label>
                <select class="form-control" id="tipdoc" name="tipdoc" style="width: 100%">
                <?php
                $ctd=mysqli_query($cone, "SELECT * FROM tipodoc WHERE Estado=1;");
                if(mysqli_num_rows($ctd)>0){
                    while($rtd=mysqli_fetch_assoc($ctd)){
                ?>
                    <option value="<?php echo $rtd['idTipoDoc']; ?>"><?php echo $rtd['TipoDoc']; ?></option>
                <?php
                    }
                }
                mysqli_free_result($ctd);
                ?>    
                </select>
            </div>
            <div class="col-sm-3">
                <label for="fecdoc">Fec. Documento<small class="text-red">*</small></label>
                <div class="input-group date" id="d_fecdoc">
                    <input type="text" class="form-control" id="fecdoc" name="fecdoc" placeholder="dd/mm/aaaa" value="<?php echo date('d/m/Y'); ?>">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
            </div>
            <div class="col-sm-3">
                <label for="leg">Legajo</label>
                <input type="text" class="form-control" id="leg" name="leg" placeholder="Archivador 1">
            </div>
            <div class="col-sm-3">
                <label for="fol">Folios<small class="text-red">*</small></label>
                <input type="number" class="form-control" id="fol" name="fol" placeholder="1" value="1">
            </div>
            <div class="col-sm-12">
                <label for="des">Descripción</label>
                <input type="text" class="form-control" id="des" name="des" placeholder="Descripción">
            </div>
            <div class="col-sm-2">
                <label for="trem">Remitente<small class="text-red">*</small></label>
                <select name="trem" id="trem" class="form-control" onchange="orem(this.value);">
                    <option value="i">Interno</option>
                    <option value="e">Externo</option>
                </select>
            </div>
            <div class="col-sm-4 rint">
                <label for="pirem">Remitente<small class="text-red">*</small></label>
                <select class="form-control" id="pirem" name="pirem" style="width: 100%;">
                    
                </select>
            </div>
            <div class="col-sm-6 rint">
                <label for="direm">Dependencia/institución origen<small class="text-red">*</small></label>
                <select class="form-control" id="direm" name="direm">

                </select>
            </div>
            <div class="col-sm-4 rext">
                <label for="perem">Remitente<small class="text-red">*</small></label>
                <input type="text" class="form-control" id="perem" name="perem" placeholder="Remitente">
            </div>
            <div class="col-sm-6 rext">
                <label for="derem">Dependencia/institución origen<small class="text-red">*</small></label>
                <input type="text" class="form-control" id="derem" name="derem" placeholder="Dependencia/institución origen">
            </div>
            <div class="col-sm-2">
                <label for="tdes">Destino<small class="text-red">*</small></label>
                <select name="tdes" id="tdes" class="form-control" onchange="odes(this.value);">
                    <option value="i">Interno</option>
                    <option value="e">Externo</option>
                </select>
            </div>
            <div class="col-sm-4 dint">
                <label for="pides">Destinatario<small class="text-red">*</small></label>
                <select class="form-control" id="pides" name="pides" style="width: 100%;">
                    
                </select>
            </div>
            <div class="col-sm-6 dint">
                <label for="dides">Dependencia/institución destino<small class="text-red">*</small></label>
                <select class="form-control" id="dides" name="dides">

                </select>
            </div>
            <div class="col-sm-4 dext">
                <label for="pedes">Destinatario<small class="text-red">*</small></label>
                <input type="text" class="form-control" id="pedes" name="pedes" placeholder="Destinatario">
            </div>
            <div class="col-sm-6 dext">
                <label for="dedes">Dependencia/institución destino<small class="text-red">*</small></label>
                <input type="text" class="form-control" id="dedes" name="dedes" placeholder="Dependencia/institución destino">
            </div>
        </div>
	    <div class="form-group" id="d_frespuesta">
	    </div>
        <script>
            function orem(v){
                switch (v) {
                    case "i":
                        $(".rext").hide();
                        $(".rint").show();
                        $("#perem").val("");
                        $("#derem").val("");
                        break;
                    case "e":
                        $(".rext").show();
                        $(".rint").hide();
                        $("#pirem").select2("val", "");
                        $("#direm").val("");
                        break;
                }
            };
            function odes(v){
                switch (v) {
                    case "i":
                        $(".dext").hide();
                        $(".dint").show();
                        $("#pedes").val("");
                        $("#dedes").val("");
                        break;
                    case "e":
                        $(".dext").show();
                        $(".dint").hide();
                        $("#pides").select2("val", "");
                        $("#dides").val("");
                        break;
                }
            };

            $('#d_ano').datepicker({
                format: 'yyyy',
                language: 'es',
                autoclose: true,
                minViewMode: 2,
                maxViewMode: 2,
                todayHighlight: true
            });
            $('#d_fecdoc').datepicker({
                format: 'dd/mm/yyyy',
                language: 'es',
                autoclose: true,
                minViewMode: 0,
                maxViewMode: 2,
                todayHighlight: true
            });
            $("#tipdoc").select2();

            $("#pirem").select2({
              placeholder: 'Selecione un personal',
              ajax: {
                url: 'm_inclusiones/a_general/a_selpersonal.php',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                  return {
                    results: data
                  };
                },
                cache: true
              },
              minimumInputLength: 4
            }).on("change", function(e){
              var per = $(this).val();
              $.ajax({
                type: "post",
                url: "m_inclusiones/a_tdocumentario/b_pdependencia.php",
                data: { per: per},
                dataType: "html",
                beforeSend: function () {
                  $("#direm").html("<option value=''><i class='fa fa-spinner fa-spin'></i> Cargando...</option>");
                },
                success:function(a){
                  $("#direm").html(a);
                }
              });
            });

            $("#pides").select2({
              placeholder: 'Selecione un personal',
              ajax: {
                url: 'm_inclusiones/a_general/a_selpersonal.php',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                  return {
                    results: data
                  };
                },
                cache: true
              },
              minimumInputLength: 4
            }).on("change", function(e){
              var per = $(this).val();
              $.ajax({
                type: "post",
                url: "m_inclusiones/a_tdocumentario/b_pdependencia.php",
                data: { per: per},
                dataType: "html",
                beforeSend: function () {
                  $("#dides").html("<option value=''><i class='fa fa-spinner fa-spin'></i> Cargando...</option>");
                },
                success:function(a){
                  $("#dides").html(a);
                }
              });
            });

            $("#ref").select2({
              placeholder: 'Selecione un documento',
              ajax: {
                url: 'm_inclusiones/a_general/a_seldoc.php',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                  return {
                    results: data
                  };
                },
                cache: true
              },
              minimumInputLength: 2
            })

            orem("i");
            odes("i");
        </script>  
<?php
		}elseif($acc=="edidoc"){
          if(isset($v1) && !empty($v1)){
            $cd=mysqli_query($cone, "SELECT * FROM doc WHERE idDoc=$v1;");
            if($rd=mysqli_fetch_assoc($cd)){
?>
        <div class="row">
            <input type="hidden" name="acc" value="<?php echo $acc; ?>">
            <input type="hidden" name="v1" value="<?php echo $v1; ?>">
            <div class="col-sm-2">
                <label for="num">Número<small class="text-red">*</small></label>
                <input type="text" class="form-control" id="num" name="num" placeholder="001" value="<?php echo $rd['Numero']; ?>">
            </div>
            <div class="col-sm-2">
                <label for="ano">Año<small class="text-red">*</small></label>
                <div class="input-group date" id="d_ano">
                    <input type="text" class="form-control" id="ano" name="ano" placeholder="2019" value="<?php echo $rd['Ano']; ?>">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
            </div>
            <div class="col-sm-3">
                <label for="sig">Siglas<small class="text-red">*</small></label>
                <input type="text" class="form-control" id="sig" name="sig" placeholder="MPFN-DFC-INF" value="<?php echo $rd['Siglas']; ?>">
            </div>
            <div class="col-sm-5">
                <label for="ref">Referencia</label>
                <select class="form-control" id="ref" name="ref" style="width: 100%;">
                <?php
                if(!is_null($rd['referencia'])){ 
                    $ref=$rd['referencia'];
                    $cre=mysqli_query($cone, "SELECT CONCAT_WS('-', d.Numero, d.Ano, d.Siglas) doc, d.numdoc, td.TipoDoc FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc WHERE d.idDoc=$ref;");
                    if($rre=mysqli_fetch_assoc($cre)){
                    ?>
                        <option value="<?php echo $ref; ?>"><?php echo (!is_null($rre['numdoc']) ? $rre['numdoc'].' | ' : '').$rre['TipoDoc'].' | '.$rre['doc']; ?></option>
                    <?php
                    }
                    mysqli_free_result($cre);
                }
                ?>
                </select>
            </div>
            <div class="col-sm-3">
                <label for="tipdoc">Tip. Documento<small class="text-red">*</small></label>
                <select class="form-control" id="tipdoc" name="tipdoc" style="width: 100%">
                <?php
                $ctd=mysqli_query($cone, "SELECT * FROM tipodoc WHERE Estado=1;");
                if(mysqli_num_rows($ctd)>0){
                    while($rtd=mysqli_fetch_assoc($ctd)){
                ?>
                    <option value="<?php echo $rtd['idTipoDoc']; ?>" <?php echo $rtd['idTipoDoc']==$rd['idTipoDoc'] ? "selected" : ""; ?>><?php echo $rtd['TipoDoc']; ?></option>
                <?php
                    }
                }
                mysqli_free_result($ctd);
                ?>    
                </select>
            </div>
            <div class="col-sm-3">
                <label for="fecdoc">Fec. Documento<small class="text-red">*</small></label>
                <div class="input-group date" id="d_fecdoc">
                    <input type="text" class="form-control" id="fecdoc" name="fecdoc" placeholder="dd/mm/aaaa" value="<?php echo fnormal($rd['FechaDoc']); ?>">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
            </div>
            <div class="col-sm-3">
                <label for="leg">Legajo</label>
                <input type="text" class="form-control" id="leg" name="leg" placeholder="Archivador 1" value="<?php echo $rd['Legajo'] ?>">
            </div>
            <div class="col-sm-3">
                <label for="fol">Folios<small class="text-red">*</small></label>
                <input type="number" class="form-control" id="fol" name="fol" placeholder="1" value="<?php echo $rd['folios']; ?>">
            </div>
            <div class="col-sm-12">
                <label for="des">Descripción</label>
                <input type="text" class="form-control" id="des" name="des" placeholder="Descripción" value="<?php echo $rd['Descripcion']; ?>">
            </div>
            <div class="col-sm-2">
                <label for="trem">Remitente<small class="text-red">*</small></label>
                <select name="trem" id="trem" class="form-control" onchange="orem(this.value);">
                    <option value="i" <?php echo !is_null($rd['remitenteint']) ? "selected" : ""; ?>>Interno</option>
                    <option value="e" <?php echo !is_null($rd['remitenteext']) ? "selected" : ""; ?>>Externo</option>
                </select>
            </div>
            <div class="col-sm-4 rint">
                <label for="pirem">Remitente<small class="text-red">*</small></label>
                <select class="form-control" id="pirem" name="pirem" style="width: 100%;">
                    <?php if(!is_null($rd['remitenteint'])){ ?>
                    <option value="<?php echo $rd['remitenteint']; ?>"><?php echo nomempleado($cone, $rd['remitenteint']); ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-sm-6 rint">
                <label for="direm">Dependencia/institución origen<small class="text-red">*</small></label>
                <select class="form-control" id="direm" name="direm">
                    <?php if(!is_null($rd['remitenteint'])){ ?>
                    <option value="<?php echo $rd['deporigenint']; ?>"><?php echo nomdependencia($cone, $rd['deporigenint']); ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-sm-4 rext">
                <label for="perem">Remitente<small class="text-red">*</small></label>
                <input type="text" class="form-control" id="perem" name="perem" placeholder="Remitente" value="<?php echo $rd['remitenteext']; ?>">
            </div>
            <div class="col-sm-6 rext">
                <label for="derem">Dependencia/institución origen<small class="text-red">*</small></label>
                <input type="text" class="form-control" id="derem" name="derem" placeholder="Dependencia/institución origen" value="<?php echo $rd['deporigenext']; ?>">
            </div>
            <div class="col-sm-2">
                <label for="tdes">Destino<small class="text-red">*</small></label>
                <select name="tdes" id="tdes" class="form-control" onchange="odes(this.value);">
                    <option value="i" <?php echo !is_null($rd['destinatarioint']) ? "selected" : ""; ?>>Interno</option>
                    <option value="e" <?php echo !is_null($rd['destinatarioext']) ? "selected" : ""; ?>>Externo</option>
                </select>
            </div>
            <div class="col-sm-4 dint">
                <label for="pides">Destinatario<small class="text-red">*</small></label>
                <select class="form-control" id="pides" name="pides" style="width: 100%;">
                    <?php if(!is_null($rd['destinatarioint'])){ ?>
                    <option value="<?php echo $rd['destinatarioint']; ?>"><?php echo nomempleado($cone, $rd['destinatarioint']); ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-sm-6 dint">
                <label for="dides">Dependencia/institución destino<small class="text-red">*</small></label>
                <select class="form-control" id="dides" name="dides">
                    <?php if(!is_null($rd['destinatarioint'])){ ?>
                    <option value="<?php echo $rd['depdestinoint']; ?>"><?php echo nomdependencia($cone, $rd['depdestinoint']); ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-sm-4 dext">
                <label for="pedes">Destinatario<small class="text-red">*</small></label>
                <input type="text" class="form-control" id="pedes" name="pedes" placeholder="Destinatario" value="<?php echo $rd['destinatarioext']; ?>">
            </div>
            <div class="col-sm-6 dext">
                <label for="dedes">Dependencia/institución destino<small class="text-red">*</small></label>
                <input type="text" class="form-control" id="dedes" name="dedes" placeholder="Dependencia/institución destino" value="<?php echo $rd['depdestinoext']; ?>">
            </div>
        </div>
        <div class="form-group" id="d_frespuesta">
        </div>
        <script>
            function orem(v){
                switch (v) {
                    case "i":
                        $(".rext").hide();
                        $(".rint").show();
                        $("#perem").val("");
                        $("#derem").val("");
                        break;
                    case "e":
                        $(".rext").show();
                        $(".rint").hide();
                        $("#pirem").select2("val", "");
                        $("#direm").val("");
                        break;
                }
            };
            function odes(v){
                switch (v) {
                    case "i":
                        $(".dext").hide();
                        $(".dint").show();
                        $("#pedes").val("");
                        $("#dedes").val("");
                        break;
                    case "e":
                        $(".dext").show();
                        $(".dint").hide();
                        $("#pides").select2("val", "");
                        $("#dides").val("");
                        break;
                }
            };

            $('#d_ano').datepicker({
                format: 'yyyy',
                autoclose: true,
                minViewMode: 2,
                maxViewMode: 2,
                todayHighlight: true
            });
            $('#d_fecdoc').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true,
                minViewMode: 0,
                maxViewMode: 2,
                todayHighlight: true
            });
            $("#tipdoc").select2();

            $("#pirem").select2({
              placeholder: 'Selecione un personal',
              ajax: {
                url: 'm_inclusiones/a_general/a_selpersonal.php',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                  return {
                    results: data
                  };
                },
                cache: true
              },
              minimumInputLength: 4
            }).on("change", function(e){
              var per = $(this).val();
              $.ajax({
                type: "post",
                url: "m_inclusiones/a_tdocumentario/b_pdependencia.php",
                data: { per: per},
                dataType: "html",
                beforeSend: function () {
                  $("#direm").html("<option value=''><i class='fa fa-spinner fa-spin'></i> Cargando...</option>");
                },
                success:function(a){
                  $("#direm").html(a);
                }
              });
            });

            $("#pides").select2({
              placeholder: 'Selecione un personal',
              ajax: {
                url: 'm_inclusiones/a_general/a_selpersonal.php',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                  return {
                    results: data
                  };
                },
                cache: true
              },
              minimumInputLength: 4
            }).on("change", function(e){
              var per = $(this).val();
              $.ajax({
                type: "post",
                url: "m_inclusiones/a_tdocumentario/b_pdependencia.php",
                data: { per: per},
                dataType: "html",
                beforeSend: function () {
                  $("#dides").html("<option value=''><i class='fa fa-spinner fa-spin'></i> Cargando...</option>");
                },
                success:function(a){
                  $("#dides").html(a);
                }
              });
            });

            $("#ref").select2({
              placeholder: 'Selecione un documento',
              ajax: {
                url: 'm_inclusiones/a_general/a_seldoc.php',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                  return {
                    results: data
                  };
                },
                cache: true
              },
              minimumInputLength: 2
            })

            orem(<?php echo !is_null($rd['remitenteint']) ? "'i'" : "'e'"; ?>);
            odes(<?php echo !is_null($rd['destinatarioint']) ? "'i'" : "'e'"; ?>);        
        </script>  
<?php
            }else{
                echo mensajewa("Error, datos inválidos.");
            }
            mysqli_free_result($cd);
          }else{
            echo mensajewa("Error, faltan datos.");
          }
        }elseif($acc=="elidoc"){
          if(isset($v1) && !empty($v1)){
            $cd=mysqli_query($cone, "SELECT d.Numero, d.Ano, d.Siglas, d.FechaDoc, td.TipoDoc FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc WHERE d.idDoc=$v1;");
            if($rd=mysqli_fetch_assoc($cd)){
?>
        <div class="row text-center">
            <input type="hidden" name="acc" value="<?php echo $acc; ?>">
            <input type="hidden" name="v1" value="<?php echo $v1; ?>">
            <div class="col-sm-12">
                <p class="text-muted"><i class="fa fa-warning text-yellow"></i> ¿Está seguro que desea eliminar este documento?</p>
                <h4 class="text-orange"><i class="fa fa-file-text text-gray"></i> <?php echo $rd['TipoDoc']." ".$rd['Numero']."-".$rd['Ano']."-".$rd['Siglas'].' <small>['.fnormal($rd['FechaDoc']).']</small>'; ?></h4>
            </div>
        </div>
        <div class="form-group" id="d_frespuesta">
        </div>
        <script>
                 
        </script>  
<?php
            }else{
                echo mensajewa("Error, datos inválidos.");
            }
            mysqli_free_result($cd);
          }else{
            echo mensajewa("Error, faltan datos.");
          }
        }elseif($acc=="revdoc"){
            if(isset($v1) && !empty($v1) && isset($v2) && !empty($v2)){
?>
                    <div class="row">
                        <input type="hidden" name="acc" value="<?php echo $acc; ?>">
                        <input type="hidden" name="v1" value="<?php echo $v1; ?>">
                        <input type="hidden" name="v2" value="<?php echo $v2; ?>">
                        <div class="col-sm-12">
                            <label for="num">Observaciónes para revertir<small class="text-red">*</small></label>
                            <textarea class="form-control" id="obs" name="obs"></textarea>
                        </div>
                    </div>
                    <div class="form-group" id="d_frespuesta">
                    </div>              
<?php
            }else{
                echo mensajewa("Error, faltan datos.");
            }
        }elseif($acc=="atedoc"){
            if(isset($v1) && !empty($v1) && isset($v2) && !empty($v2)){
?>
                    <div class="row">
                        <input type="hidden" name="acc" value="<?php echo $acc; ?>">
                        <input type="hidden" name="v1" value="<?php echo $v1; ?>">
                        <input type="hidden" name="v2" value="<?php echo $v2; ?>">
                        <div class="col-sm-12">
                            <label for="num">Observaciónes de la atención<small class="text-red">*</small></label>
                            <textarea class="form-control" id="obs" name="obs"></textarea>
                        </div>
                    </div>
                    <div class="form-group" id="d_frespuesta">
                    </div>              
<?php
            }else{
                echo mensajewa("Error, faltan datos.");
            }
        }elseif($acc=="arcdoc"){
            if(isset($v1) && !empty($v1) && isset($v2) && !empty($v2)){
?>
                    <div class="row">
                        <input type="hidden" name="acc" value="<?php echo $acc; ?>">
                        <input type="hidden" name="v1" value="<?php echo $v1; ?>">
                        <input type="hidden" name="v2" value="<?php echo $v2; ?>">
                        <div class="col-sm-12">
                            <label for="num">Observaciónes para archivar<small class="text-red">*</small></label>
                            <textarea class="form-control" id="obs" name="obs"></textarea>
                        </div>
                    </div>
                    <div class="form-group" id="d_frespuesta">
                    </div>              
<?php
            }else{
                echo mensajewa("Error, faltan datos.");
            }
        }elseif($acc=="repdoc"){
            if(isset($v1) && !empty($v1) && isset($v2) && !empty($v2)){
?>
                    <div class="row">
                        <input type="hidden" name="acc" value="<?php echo $acc; ?>">
                        <input type="hidden" name="v1" value="<?php echo $v1; ?>">
                        <input type="hidden" name="v2" value="<?php echo $v2; ?>">
                        <div class="col-sm-3">
                            <label for="not">Notificado<small class="text-red">*</small></label>
                            <select class="form-control" id="not" name="not">
                                <option value="">Notificado</option>
                                <option value="1">Sí</option>
                                <option value="2">No</option>
                            </select>
                        </div>
                        <div class="col-sm-5">
                            <label for="mnot">Modo Notificación<small class="text-red">*</small></label>
                            <select class="form-control" id="mnot" name="mnot">
                                <option value="">Modo</option>
                            <?php
                            $cm=mysqli_query($cone, "SELECT * FROM tdmodnotificacion WHERE estado=1 ORDER BY modnotificacion ASC;");
                            if(mysqli_num_rows($cm)>0){
                                while ($rm=mysqli_fetch_assoc($cm)){
                            ?>
                                    <option value="<?php echo $rm['idtdmodnotificacion']; ?>"><?php echo $rm['modnotificacion']; ?></option>
                            <?php
                                }
                            }
                            mysqli_free_result($cm);
                            ?>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label for="fecdoc">Fec. Notificación<small class="text-red">*</small></label>
                            <div class="input-group date" id="d_fnot">
                                <input type="text" class="form-control" id="fnot" name="fnot" placeholder="dd/mm/aaaa" value="<?php echo date('d/m/Y'); ?>">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label for="num">Observación</label>
                            <textarea class="form-control" id="obs" name="obs"></textarea>
                        </div>
                    </div>
                    <div class="form-group" id="d_frespuesta">
                    </div>
                    <script>
                        $('#d_fnot').datepicker({
                            format: 'dd/mm/yyyy',
                            language: 'es',
                            autoclose: true,
                            minViewMode: 0,
                            maxViewMode: 2,
                            todayHighlight: true
                        });
                    </script>            
<?php
            }else{
                echo mensajewa("Error, faltan datos.");
            }
        }elseif($acc=="detdoc"){
          if(isset($v1) && !empty($v1)){
            $cd=mysqli_query($cone, "SELECT d.*, td.TipoDoc FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc WHERE d.idDoc=$v1;");
            if($rd=mysqli_fetch_assoc($cd)){
?>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered table-hover">
                    <tr>
                        <th><i class="fa fa-slack text-aqua"></i> NÚMERO</th>
                        <th><i class="fa fa-files-o text-aqua"></i> TIPO</th>
                        <th><i class="fa fa-file text-aqua"></i> DOCUMENTO</th>
                        <th><i class="fa fa-calendar text-aqua"></i> FECHA</th>
                        <th><i class="fa fa-file-o text-aqua"></i> REFERENCIA</th>
                        <th><i class="fa fa-stack-overflow text-aqua"></i> FOLIOS</th>
                    </tr>
                    <tr>
                        <td class="text-aqua"><?php echo $rd['numdoc'].'-'.$rd['Ano']; ?></td>
                        <td class="text-teal"><?php echo $rd['TipoDoc']; ?></td>
                        <td class="text-orange"><?php echo $rd['Numero']."-".$rd['Ano']."-".$rd['Siglas']; ?></td>
                        <td><?php echo fnormal($rd['FechaDoc']); ?></td>
                        <?php
                        $ref='';
                        if(!is_null($rd['referencia'])){ 
                            $ref=$rd['referencia'];
                            $cre=mysqli_query($cone, "SELECT CONCAT_WS('-', d.Numero, d.Ano, d.Siglas) doc, d.numdoc, td.TipoDoc FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc WHERE d.idDoc=$ref;");
                            if($rre=mysqli_fetch_assoc($cre)){
                            
                                $ref=(!is_null($rre['numdoc']) ? $rre['numdoc'].' | ' : '').$rre['doc'];
                            
                            }
                            mysqli_free_result($cre);
                        }
                        ?>
                        <td><?php echo $ref; ?></td>
                        <td><?php echo $rd['folios']; ?></td>
                    </tr>
                    <tr>
                        <th colspan="5"><i class="fa fa-align-left text-aqua"></i> DESCRIPCIÓN</th>
                        <th><i class="fa fa-folder-open text-aqua"></i> LEGAJO</th>
                    </tr>
                    <tr>
                        <td colspan="5"><?php echo $rd['Descripcion']; ?></td>
                        <td><?php echo $rd['Legajo']; ?></td>
                    </tr>
                    <tr>
                        <th colspan="3"><i class="fa fa-user text-aqua"></i> REMITENTE</th>
                        <th colspan="3"><i class="fa fa-university text-aqua"></i> DEPENDENCIA ORIGEN</th>
                    </tr>
                    <tr>
                        <td colspan="3"><?php echo !is_null($rd['remitenteext']) ? $rd['remitenteext'] : nomempleado($cone, $rd['remitenteint']); ?></td>
                        <td colspan="3"><?php echo !is_null($rd['deporigenext']) ? $rd['deporigenext'] : nomdependencia($cone, $rd['deporigenint']); ?></td>
                    </tr>
                    <tr>
                        <th colspan="3"><i class="fa fa-user text-aqua"></i> DESTINATARIO</th>
                        <th colspan="3"><i class="fa fa-university text-aqua"></i> DEPENDENCIA DESTINO</th>
                    </tr>
                    <tr>
                        <td colspan="3"><?php echo !is_null($rd['destinatarioext']) ? $rd['destinatarioext'] : nomempleado($cone, $rd['destinatarioint']); ?></td>
                        <td colspan="3"><?php echo !is_null($rd['depdestinoext']) ? $rd['depdestinoext'] : nomdependencia($cone, $rd['depdestinoint']); ?></td>
                    </tr>
                </table>
            </div>
        </div>
<?php
            }else{
                echo mensajewa("Error, datos inválidos.");
            }
            mysqli_free_result($cd);
          }else{
            echo mensajewa("Error, faltan datos.");
          }
        }elseif($acc=="rutdoc"){
          if(isset($v1) && !empty($v1)){
            $cd=mysqli_query($cone, "SELECT d.*, td.TipoDoc FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc WHERE d.idDoc=$v1;");
            if($rd=mysqli_fetch_assoc($cd)){
?>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th><i class="fa fa-slack text-aqua"></i> NÚMERO</th>
                        <th><i class="fa fa-files-o text-aqua"></i> TIPO</th>
                        <th><i class="fa fa-file text-aqua"></i> DOCUMENTO</th>
                        <th><i class="fa fa-calendar text-aqua"></i> FECHA</th>
                    </tr>
                    </thead>
                    <tr>
                        <td class="text-aqua"><?php echo $rd['numdoc'].'-'.$rd['Ano']; ?></td>
                        <td class="text-teal"><?php echo $rd['TipoDoc']; ?></td>
                        <td class="text-orange"><?php echo $rd['Numero']."-".$rd['Ano']."-".$rd['Siglas']; ?></td>
                        <td><?php echo fnormal($rd['FechaDoc']); ?></td>
                    </tr>
                </table>
<?php
            $ce=mysqli_query($cone, "SELECT ed.*, modnotificacion FROM tdestadodoc ed LEFT JOIN tdmodnotificacion mn ON ed.idtdmodnotificacion=mn.idtdmodnotificacion WHERE ed.idDoc=$v1 ORDER BY ed.fecha DESC;");
            if(mysqli_num_rows($ce)>0){
?>
                <span class="text-muted" style="font-size: 11px;"><i class="fa fa-refresh text-orange"></i> Actualizado al <?php echo date('d/m/Y h:i:s A'); ?></span>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ESTADO</th>
                            <th>FECHA</th>
                            <th>TIEMPO</th>
                            <th>RESPONSABLE</th>
                        </tr>
                    </thead>
                    <tbody>
<?php
                $n=0;
                while($re=mysqli_fetch_assoc($ce)){
                    $n++;
                    $ti="";
                    //if($re['idtdestado']!=7 || $re['idtdestado']!=8 || $re['idtdestado']!=9){
                        $fec=$re['fecha'];
                        $cs=mysqli_query($cone, "SELECT fecha FROM tdestadodoc WHERE idDoc=$v1 AND fecha>'$fec' ORDER BY fecha ASC LIMIT 1;");
                        if($rs=mysqli_fetch_assoc($cs)){
                            $ti=$rs['fecha'];
                        }else{
                            $ti=date('Y-m-d H:i:s');
                        }
                        mysqli_free_result($cs);
                    //}
?>
                        <tr>
                            <td><?php echo $n; ?></td>
                            <td><?php echo estadoDoc($re['idtdestado']); ?></td>
                            <td><?php echo date('d/m/Y h:i:s A', strtotime($re['fecha'])); ?></td>
                            <td class="text-orange"><i class="fa fa-clock-o"></i> <?php echo $ti!="" ? diftiempo($fec, $ti) : ""; ?></td>
                            <td>
                                <?php
                                if(!is_null($re['idEmpleado'])){
                                    echo nomempleado($cone, $re['idEmpleado']).'<br><small class="text-aqua">'.nomdependencia($cone, $re['idDependencia']).'</small>';
                                }else{
                                    if(!is_null($re['idtdmesapartes'])){
                                        echo nommpartes($cone, $re['idtdmesapartes']).(!is_null($re['responsablemp']) ? '<br><small class="text-aqua">'.nomempleado($cone, $re['responsablemp']).'</small>' : '');
                                    }
                                }
                                ?>
                            </td>
                        </tr>
                        <?php if(!is_null($re['observacion'])){ ?>
                        <tr>
                            <td colspan="5">
                                <?php if($re['idtdestado']==5){ ?>
                                <b class="text-muted">NOTIFICADO:</b> <?php echo $re['notificado']==1 ? '<i class="fa fa-check-circle text-green"></i> Sí' : '<i class="fa fa-times-circle text-red"></i> No'; ?> | <b class="text-muted">MODO:</b> <i class="fa fa-motorcycle text-purple"></i> <?php echo $re['modnotificacion']; ?> | <b class="text-muted">FECHA NOTIFICACIÓN:</b> <i class="fa fa-calendar text-fuchsia"></i> <?php echo fnormal($re['fecnotificado']); ?> <br>
                                <?php } ?>
                                <b class="text-muted">OBSERVACIÓN:</b> <i class="fa fa-info-circle text-yellow"></i> <?php echo $re['observacion']; ?>
                            </td>
                        </tr>
                        <?php } ?>    
<?php
                }
?>
                    </tbody>
                </table>
<?php
            }
            mysqli_free_result($ce);
?>
            </div>
        </div>
<?php
            }else{
                echo mensajewa("Error, datos inválidos.");
            }
            mysqli_free_result($cd);
          }else{
            echo mensajewa("Error, faltan datos.");
          }
        }elseif($acc=="detest"){
          if(isset($v1) && !empty($v1)){
            $cd=mysqli_query($cone, "SELECT d.idDoc, d.Numero, d.Ano, d.Siglas, d.FechaDoc, d.numdoc, td.TipoDoc, ed.*, mn.modnotificacion FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc INNER JOIN tdestadodoc ed ON d.idDoc=ed.idDoc LEFT JOIN tdmodnotificacion mn ON ed.idtdmodnotificacion=mn.idtdmodnotificacion WHERE ed.idtdestadodoc=$v1;");
            if($rd=mysqli_fetch_assoc($cd)){
                $f=$rd['fecha'];
                $idd=$rd['idDoc'];
?>
        <div class="row">
            <div class="col-sm-12">
                <span class="text-muted" style="font-size: 11px;"><i class="fa fa-refresh text-orange"></i> Actualizado al <?php echo date('d/m/Y h:i:s A'); ?></span>
                <table class="table table-bordered table-hover">
                    <tr>
                        <th><i class="fa fa-retweet text-aqua"></i> ESTADO</th>
                        <th><i class="fa fa-slack text-aqua"></i> NÚMERO</th>
                        <th><i class="fa fa-file text-aqua"></i> DOCUMENTO</th>
                        <th><i class="fa fa-calendar text-aqua"></i> FECHA DOC.</th>
                    </tr>
                    <tr>
                        <td><?php echo estadoDoc($rd['idtdestado']); ?></td>
                        <td class="text-aqua"><?php echo $rd['numdoc'].'-'.$rd['Ano']; ?></td>
                        <td><?php echo $rd['Numero']."-".$rd['Ano']."-".$rd['Siglas'].'<br><small class="text-teal">'.$rd['TipoDoc'].'</small>'; ?></td>
                        <td><?php echo fnormal($rd['FechaDoc']); ?></td>
                    </tr>
                    <tr>
                        <th colspan="4"><i class="fa fa-user text-aqua"></i> RESPONSABLE</th>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <?php
                            if(!is_null($rd['idEmpleado'])){
                                echo nomempleado($cone, $rd['idEmpleado']).' <small class="text-aqua">['.nomdependencia($cone, $rd['idDependencia']).']</small>';
                            }else{
                                if(!is_null($rd['idtdmesapartes'])){
                                    echo nommpartes($cone, $rd['idtdmesapartes']);
                                }
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th colspan="2"><i class="fa fa-user text-aqua"></i> ASIGNADOR</th>
                        <th><i class="fa fa-calendar text-aqua"></i> FECHA</th>
                        <th><i class="fa fa-clock-o text-aqua"></i> TIEMPO</th>
                    </tr>
                    <tr>
                        <?php
                        $as='';
                        $ca=mysqli_query($cone, "SELECT idEmpleado FROM tdestadodoc WHERE idDoc=$idd AND fecha<'$f' ORDER BY fecha DESC LIMIT 1;");
                        if($ra=mysqli_fetch_assoc($ca)){
                            $as=$ra['idEmpleado'];
                        }
                        mysqli_free_result($ca);
                        ?>
                        <td colspan="2"><?php echo $as!='' ? nomempleado($cone, $as) : nomempleado($cone, $rd['idEmpleado']); ?></td>
                        <td><?php echo date('d/m/Y h:i:s A', strtotime($rd['fecha'])); ?></td>
                        <td class="text-orange"><?php echo diftiempo($rd['fecha'], date('Y-m-d H:i:s')); ?></td>
                    </tr>
                    <?php if(!is_null($rd['modnotificacion'])){ ?>
                    <tr>
                        <th colspan="4"><i class="fa fa-motorcycle text-aqua"></i> MODO NOTIFICACIÓN</th>
                    </tr>
                    <tr>
                        <td colspan="4"><?php echo $rd['modnotificacion']; ?></td>
                    </tr>
                    <?php } ?>
                    <?php if(!is_null($rd['observacion'])){ ?>
                    <tr>
                        <th colspan="4"><i class="fa fa-info-circle text-aqua"></i> OBSERVACIÓN</th>
                    </tr>
                    <tr>
                        <td colspan="4"><?php echo $rd['observacion']; ?></td>
                    </tr>
                    <?php } ?>
                </table>
                
            </div>
        </div>
<?php
            }else{
                echo mensajewa("Error, datos inválidos.");
            }
            mysqli_free_result($cd);
          }else{
            echo mensajewa("Error, faltan datos.");
          }
        }elseif($acc=="gengui"){
            if(isset($v1) && !empty($v1)){
            $idem=$_SESSION['identi'];


?>
                    <div class="row">
                        <input type="hidden" name="acc" value="<?php echo $acc; ?>">
                        <input type="hidden" name="v1" value="<?php echo $v1; ?>">
                        <input type="hidden" name="v2" value="<?php echo $v2; ?>">
                        <div class="col-sm-12">
                            <label for="mpdes">Destino<small class="text-red">*</small></label>
                            <select class="form-control" id="mpdes" name="mpdes" onchange="li_gdoc(this.value, <?php echo $v1; ?>);">
                                <option value="">DESTINO GUÍA</option>
                            <?php
                            $cd=mysqli_query($cone, "SELECT DISTINCT mp.idtdmesapartes, mp.denominacion FROM tdestadodoc ed INNER JOIN tdmesapartes mp ON ed.idtdmesapartes=mp.idtdmesapartes WHERE ISNULL(ed.idtdguia) AND ed.idtdestado=3 AND ed.estado=1 AND ed.mpderiva=$v1;");
                            if(mysqli_num_rows($cd)>0){
                                while($rd=mysqli_fetch_assoc($cd)){
                            ?>
                                <option value="<?php echo $rd['idtdmesapartes']; ?>"><?php echo $rd['denominacion']; ?></option>
                            <?php
                                }
                            }else{
                            ?>
                                <option value="">NINGÚN DESTINO CON DOCUMENTOS PARA ENVIAR</option>
                            <?php
                            }
                            mysqli_free_result($cd);
                            ?>
                            </select>
                        </div>
                    </div>
                    <div class="row" id="d_docs">
                    </div>  
                    <div class="row" id="d_frespuesta">
                    </div>
                    <script>
                        function li_gdoc(idmp, v1){
                            $.ajax({
                              type: "post",
                              url: "m_inclusiones/a_tdocumentario/li_gdoc.php",
                              data: {idmp: idmp, v1: v1},
                              dataType: "html",
                              beforeSend: function () {
                                $("#d_docs").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
                              },
                              success:function(a){
                                $("#d_docs").html(a);
                              }
                            });
                        }
                    </script>            
<?php
            }else{
                echo mensajewa("Error, faltan datos.");
            }
        }elseif($acc=="lisgui"){
            if(isset($v1) && !empty($v1)){
                $idem=$_SESSION['identi'];
                $cg=mysqli_query($cone, "SELECT numero, anio, idtdmesapartesg, idtdmesapartesd FROM tdguia WHERE idtdguia=$v1;");
                if($rg=mysqli_fetch_assoc($cg)){
?>
                <div class="col-md-5 text-blue"><b><i class="fa fa-archive text-orange"></i> <?php echo nommpartes($cone, $rg['idtdmesapartesg']); ?></b></div>
                <div class="col-md-5 text-blue"><b><i class="fa fa-plane text-orange"></i> <?php echo nommpartes($cone, $rg['idtdmesapartesd']); ?></b></div>
                <div class="col-md-2 text-right text-blue"><b><i class="fa fa-slack text-orange"></i> <?php echo $rg['numero'].'-'.$rg['anio']; ?></b></div>
<?php
                    $cdg=mysqli_query($cone, "SELECT d.numdoc, d.Numero, d.Ano, d.Siglas, d.FechaDoc, d.remitenteext, d.remitenteint, d.destinatarioext, d.destinatarioint FROM tdestadodoc ed INNER JOIN doc d ON ed.idDoc=d.idDoc WHERE ed.idtdguia=$v1 ORDER BY d.numdoc DESC, d.Ano DESC;");
                    if(mysqli_num_rows($cdg)>0){
?>
                        <table class="table table-hover table-bordered" id="dt_guia">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NUM.</th>
                                    <th>DOCUMENTO</th>
                                    <th>FECHA</th>
                                    <th>REMITENTE</th>
                                    <th>DESTINATARIO</th>
                                </tr>
                            </thead>
                            <tbody>
<?php
                            $n=0;
                            while($rdg=mysqli_fetch_assoc($cdg)){
                                $n++;
?>
                                <tr>
                                    <td><?php echo $n; ?></td>
                                    <td><?php echo $rdg['numdoc'].'-'.$rdg['Ano']; ?></td>
                                    <td><?php echo $rdg['Numero'].'-'.$rdg['Ano'].'-'.$rdg['Siglas']; ?></td>
                                    <td><?php echo fnormal($rdg['FechaDoc']); ?></td>
                                    <td><?php echo !is_null($rdg['remitenteext']) ? $rdg['remitenteext'] : nomempleado($cone, $rdg['remitenteint']); ?></td>
                                    <td><?php echo !is_null($rdg['destinatarioext']) ? $rdg['destinatarioext'] : nomempleado($cone, $rdg['destinatarioint']); ?></td>
                                </tr>
<?php
                            }
?>
                            </tbody>
                        </table>
                        <script>
                            $('#dt_guia').dataTable();
                        </script>
<?php
                    }else{
                        echo mensajewa("No se encontraron documentos");
                    }
                    mysqli_free_result($cdg);
                }else{
                    echo mensajewa("No se encontró la guía.");
                }
                mysqli_free_result($cg);
            }else{
                echo mensajewa("Error, faltan datos.");
            }
        }//acafin
	}else{
		echo mensajewa("Error: Faltan datos.");
	}
}else{
  echo accrestringidoa();
}
mysqli_close($cone);

?>