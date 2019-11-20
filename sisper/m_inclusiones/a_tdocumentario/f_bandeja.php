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
            $idem=$_SESSION['identi'];
            $idl=idlocempleado($cone, $idem);
            
?>
        
        <div class="row">
            <input type="hidden" name="acc" value="<?php echo $acc; ?>">
            <div class="col-sm-2">
                <label for="trem">Tipo Remitente<small class="text-red">*</small></label>
                <select name="trem" id="trem" class="form-control" onchange="orem(this.value);">
                    <option value="i">Interno</option>
                    <option value="e">Externo</option>
                </select>
            </div>
            <div class="col-sm-4 rint">
                <label for="pirem">Remitente<small class="text-red">*</small></label>
                <select class="form-control" id="pirem" name="pirem" style="width: 100%;">
                    <option value="<?php echo $idem; ?>"><?php echo nomempleado($cone, $idem); ?></option>
                </select>
            </div>
            <div class="col-sm-6 rint">
                <label for="direm">Dependencia/institución origen<small class="text-red">*</small></label>
                <select class="form-control" id="direm" name="direm">
                    <option value="<?php echo iddependenciae($cone, $idem); ?>"><?php echo nomdependencia($cone, iddependenciae($cone, $idem)); ?></option>
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
                <label for="tdes">Tipo Destino<small class="text-red">*</small></label>
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
            <!-- <div class="col-sm-1">
                <label>&nbsp;&nbsp;&nbsp;</label>
                <button class="btn btn-default"><i class="fa fa-plus"></i></button>
            </div> -->
            <div class="col-sm-12">
                <label for="asu">Asunto<small class="text-red">*</small></label>
                <input type="text" class="form-control" id="asu" name="asu" placeholder="Asunto">
            </div>
            <div class="col-sm-2">
                <label for="num">Número</label>
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
                <label for="sig">Siglas</label>
                <input type="text" class="form-control" id="sig" name="sig" placeholder="MPFN-DFC-INF" value="<?php echo abrdependencia($cone, iddependenciae($cone, $idem)); ?>">
            </div>
            <div class="col-sm-3">
                <label for="tipdoc">Tip. Documento<small class="text-red">*</small></label>
                <select class="form-control" id="tipdoc" name="tipdoc" style="width: 100%">
                <?php
                $ctd=mysqli_query($cone, "SELECT * FROM tipodoc WHERE Estado=1 ORDER BY TipoDoc ASC;");
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
            <div class="col-sm-2">
                <label for="fol">Folios<small class="text-red">*</small></label>
                <input type="number" class="form-control" id="fol" name="fol" placeholder="1" value="1">
            </div>
            <div class="col-sm-3">
                <label for="fecdoc">Fec. Documento<small class="text-red">*</small></label>
                <div class="input-group date" id="d_fecdoc">
                    <input type="text" class="form-control" id="fecdoc" name="fecdoc" placeholder="dd/mm/aaaa" value="<?php echo date('d/m/Y'); ?>">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
            </div>           
            <div class="col-sm-3">
                <div class="checkbox">
                    <label>
                        <br>
                        <input type="checkbox" name="car" value="1">
                        Es cargo
                    </label>
                </div>
            </div>
            <div class="col-sm-6">
                <label for="mpd">Derivar a<small class="text-red">*</small></label>
                <select class="form-control" id="mpd" name="mpd" style="width: 100%;">
<?php
                $cmp=mysqli_query($cone, "SELECT idtdmesapartes, denominacion FROM tdmesapartes WHERE idLocal=$idl AND estado=1 ORDER BY tipo ASC LIMIT 1;");
                if($rmp=mysqli_fetch_assoc($cmp)){
?>
                    <option value="<?php echo $rmp['idtdmesapartes'] ?>"><?php echo $rmp['denominacion']; ?></option>
<?php
                }
?>
                </select>
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
                        //$("#perem").val("");
                        //$("#derem").val("");
                        break;
                    case "e":
                        $(".rext").show();
                        $(".rint").hide();
                        //$("#sig").val("");
                        //$("#pirem").select2("val", "");
                        //$("#direm").val("");
                        break;
                }
            };
            function odes(v){
                switch (v) {
                    case "i":
                        $(".dext").hide();
                        $(".dint").show();
                        //$("#pedes").val("");
                        //$("#dedes").val("");
                        break;
                    case "e":
                        $(".dext").show();
                        $(".dint").hide();
                        //$("#pides").select2("val", "");
                        //$("#dides").val("");
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
                dataType: "json",
                beforeSend: function () {
                  $("#direm").html("<option value=''><i class='fa fa-spinner fa-spin'></i> Cargando...</option>");
                },
                success:function(a){
                  if(a.e){
                    $("#direm").html(a.o);
                    $("#sig").val(a.s);
                  }else{
                    alert(a.m);
                  }
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
                dataType: "json",
                beforeSend: function () {
                  $("#dides").html("<option value=''><i class='fa fa-spinner fa-spin'></i> Cargando...</option>");
                },
                success:function(a){
                  if(a.e){
                    $("#dides").html(a.o);
                  }else{
                    alert(a.m);
                  }
                }
              });
            });

            orem("i");
            odes("i");

            $("#mpd").select2({
              placeholder: 'Selecione una Mesa de Partes',
              ajax: {
                url: 'm_inclusiones/a_general/a_selmpartes.php',
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
                <label for="trem">Tipo Remitente<small class="text-red">*</small></label>
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
                <label for="tdes">Tipo Destino<small class="text-red">*</small></label>
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
            <div class="col-sm-12">
                <label for="asu">Asunto</label>
                <input type="text" class="form-control" id="asu" name="asu" placeholder="Asunto" value="<?php echo $rd['asunto']; ?>">
            </div>
            <div class="col-sm-2">
                <label for="num">Número</label>
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
                <label for="sig">Siglas</label>
                <input type="text" class="form-control" id="sig" name="sig" placeholder="MPFN-DFC-INF" value="<?php echo $rd['Siglas']; ?>">
            </div>
            <div class="col-sm-3">
                <label for="tipdoc">Tip. Documento<small class="text-red">*</small></label>
                <select class="form-control" id="tipdoc" name="tipdoc" style="width: 100%">
                <?php
                $ctd=mysqli_query($cone, "SELECT * FROM tipodoc WHERE Estado=1 ORDER BY TipoDoc ASC;");
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
            <div class="col-sm-2">
                <label for="fol">Folios<small class="text-red">*</small></label>
                <input type="number" class="form-control" id="fol" name="fol" placeholder="1" value="<?php echo $rd['folios']; ?>">
            </div>
            <div class="col-sm-3">
                <label for="fecdoc">Fec. Documento<small class="text-red">*</small></label>
                <div class="input-group date" id="d_fecdoc">
                    <input type="text" class="form-control" id="fecdoc" name="fecdoc" placeholder="dd/mm/aaaa" value="<?php echo fnormal($rd['FechaDoc']); ?>">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="checkbox">
                    <label>
                        <br>
                        <input type="checkbox" name="car" value="1" <?php echo $rd['cargo']==1 ? "checked" : ""; ?>>
                        Es cargo
                    </label>
                </div>
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
                        //$("#perem").val("");
                        //$("#derem").val("");
                        break;
                    case "e":
                        $(".rext").show();
                        $(".rint").hide();
                        //$("#pirem").select2("val", "");
                        //$("#direm").val("");
                        break;
                }
            };
            function odes(v){
                switch (v) {
                    case "i":
                        $(".dext").hide();
                        $(".dint").show();
                        //$("#pedes").val("");
                        //$("#dedes").val("");
                        break;
                    case "e":
                        $(".dext").show();
                        $(".dint").hide();
                        //$("#pides").select2("val", "");
                        //$("#dides").val("");
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
                dataType: "json",
                beforeSend: function () {
                  $("#direm").html("<option value=''><i class='fa fa-spinner fa-spin'></i> Cargando...</option>");
                },
                success:function(a){
                  if(a.e){
                    $("#direm").html(a.o);
                    $("#sig").val(a.s);
                  }else{
                    alert(a.m);
                  }
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
                dataType: "json",
                beforeSend: function () {
                  $("#dides").html("<option value=''><i class='fa fa-spinner fa-spin'></i> Cargando...</option>");
                },
                success:function(a){
                  if(a.e){
                    $("#dides").html(a.o);
                  }else{
                    alert(a.m);
                  }
                }
              });
            });

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
            $cd=mysqli_query($cone, "SELECT d.Numero, d.Ano, d.Siglas, d.numdoc, td.TipoDoc FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc WHERE d.idDoc=$v1;");
            if($rd=mysqli_fetch_assoc($cd)){
?>
        <div class="row text-center">
            <input type="hidden" name="acc" value="<?php echo $acc; ?>">
            <input type="hidden" name="v1" value="<?php echo $v1; ?>">
            <div class="col-sm-12">
                <p class="text-muted"><i class="fa fa-warning text-yellow"></i> ¿Está seguro que desea eliminar este documento?</p>
                <h4 class="text-orange"><i class="fa fa-file-text text-gray"></i> <?php echo $rd['TipoDoc']." ".(!is_null($rd['Numero']) ? $rd['Numero']."-" : "").$rd['Ano']."-".$rd['Siglas'].' <small class="text-muted">[<b>'.$rd['numdoc'].'-'.$rd['Ano'].'</b>]</small>'; ?></h4>
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
                            <label for="not">Estado<small class="text-red">*</small></label>
                            <select class="form-control" id="not" name="not">
                                <option value="">Estado</option>
                                <option value="1">NOTIFICADA</option>
                                <option value="2">A DEVOLVER</option>
                            </select>
                        </div>
                        <div class="col-sm-5">
                            <label for="mnot">Modo/Motivo<small class="text-red">*</small></label>
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
                            <label for="fecdoc">Fecha Not./Dev.<small class="text-red">*</small></label>
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
                        <th colspan="2"><i class="fa fa-file text-aqua"></i> DOCUMENTO</th>
                        <th><i class="fa fa-calendar text-aqua"></i> FECHA</th>
                        <th><i class="fa fa-stack-overflow text-aqua"></i> FOLIOS</th>
                    </tr>
                    <tr>
                        <td class="text-aqua"><?php echo (!is_null($rd['numdoc']) ? $rd['numdoc']."-" : "").$rd['Ano']; ?></td>
                        <td class="text-primary"><?php echo $rd['TipoDoc']; ?></td>
                        <td class="text-orange" colspan="2"><?php echo $rd['Numero']."-".$rd['Ano']."-".$rd['Siglas']; ?></td>
                        <td><?php echo fnormal($rd['FechaDoc']); ?></td>
                        <td><?php echo $rd['folios']; ?></td>
                    </tr>
                    <tr>
                        <th><i class="fa fa-info-circle text-aqua"></i> ASUNTO</th>
                        <td colspan="4"><?php echo $rd['asunto']; ?></th>
                        <th><i class="fa fa-file-o text-aqua"></i> <?php echo $rd['cargo']==1 ? "Cargo" : "Original"; ?></th>
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
                    <tr>
                        <th colspan="4"><i class="fa fa-user text-aqua"></i> REGISTRADO POR</th>
                        <th colspan="2"><i class="fa fa-calendar text-aqua"></i> FECHA REGISTRO</th>
                    </tr>
                    <tr>
                        <td colspan="4"><?php echo !is_null($rd['regpor']) ? nomempleado($cone, $rd['regpor']) : ""; ?></td>
                        <td colspan="2"><?php echo !is_null($rd['fecregistro']) ? ftnormal($rd['fecregistro']) : ""; ?></td>
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
                <table class="table table-bordered table-hover" style="font-size: 13px;">
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
                        <td class="text-primary"><?php echo $rd['TipoDoc'].'<small class="text-yellow"> ('.($rd['cargo']==1 ? "Cargo" : "Original").')</small>'; ?></td>
                        <td class="text-orange"><?php echo (!is_null($rd['Numero']) ? $rd['Numero']."-" : "").$rd['Ano']."-".$rd['Siglas']; ?></td>
                        <td><?php echo fnormal($rd['FechaDoc']); ?></td>
                    </tr>
                    <tr>
                        <th colspan="2"><i class="fa fa-street-view text-aqua"></i> REMITENTE</th>
                        <th colspan="2"><i class="fa fa-street-view text-aqua"></i> DESTINATARIO</th>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php echo !is_null($rd['remitenteext']) ? ($rd['remitenteext'].'<br><small class="text-aqua">'.$rd['deporigenext'].'</small>') : (nomempleado($cone, $rd['remitenteint']).'<br><small class="text-aqua">'.nomdependencia($cone, $rd['deporigenint']).'</small>'); ?>       
                        </td>
                        <td colspan="2">
                            <?php echo !is_null($rd['destinatarioext']) ? ($rd['destinatarioext'].'<br><small class="text-aqua">'.$rd['depdestinoext'].'</small>') : (nomempleado($cone, $rd['destinatarioint']).'<br><small class="text-aqua">'.nomdependencia($cone, $rd['depdestinoint']).'</small>'); ?>
                        </td>
                    </tr>
                </table>
<?php
            $ce=mysqli_query($cone, "SELECT ed.*, modnotificacion, tipo, motivo FROM tdestadodoc ed LEFT JOIN tdmodnotificacion mn ON ed.idtdmodnotificacion=mn.idtdmodnotificacion LEFT JOIN tdproveido p ON ed.idtdproveido=p.idtdproveido WHERE ed.idDoc=$v1 ORDER BY ed.fecha DESC;");
            if(mysqli_num_rows($ce)>0){
?>
                <span class="text-muted" style="font-size: 11px;"><i class="fa fa-refresh text-orange"></i> Actualizado al <?php echo date('d/m/Y h:i:s A'); ?></span>
                <table class="table table-bordered table-hover" style="font-size: 13px;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ESTADO</th>
                            <th>FECHA</th>
                            <th>TIEMPO</th>
                            <th>ASIGNADO A / ASIGNADO POR</th>
                        </tr>
                    </thead>
                    <tbody>
<?php
                $n=0;
                while($re=mysqli_fetch_assoc($ce)){
                    $n++;
                    $ti="";

                        $fec=$re['fecha'];
                        $cs=mysqli_query($cone, "SELECT fecha FROM tdestadodoc WHERE idDoc=$v1 AND fecha>'$fec' ORDER BY fecha ASC LIMIT 1;");
                        if($rs=mysqli_fetch_assoc($cs)){
                            $ti=$rs['fecha'];
                        }else{
                            $ti=date('Y-m-d H:i:s');
                        }
                        mysqli_free_result($cs);

?>
                        <tr>
                            <td><?php echo $n; ?></td>
                            <td>
                                <?php echo estadoDoc($re['idtdestado']); ?>
                                <?php if(!is_null($re['idtdproveido'])){ ?>
                                <br><i class="fa fa-user text-orange"></i> <?php echo nomempleado($cone, $re['cppara']); ?><br><i class="fa fa-commenting text-orange"></i> <b class="text-muted"><?php echo $re['tipo']; ?>:</b> <?php echo $re['motivo']; ?> <br>
                                <?php } ?>
                                <?php if($re['idtdestado']==5){ ?>
                                <br><i class="fa fa-motorcycle text-orange"></i> <b class="text-muted"> <?php echo $re['estnotificacion']==1 ? "Notificado" : ($re['estnotificacion']==2 ? "Devuelto" : ""); ?></b> <?php echo $re['modnotificacion']; ?><br><i class="fa fa-calendar text-gray"></i> <?php echo fnormal($re['fecnotificacion']); ?> <br>
                                <?php } ?>
                            </td>
                            <td><?php echo date('d/m/Y h:i:s A', strtotime($re['fecha'])); ?></td>
                            <td class="text-orange"><i class="fa fa-clock-o"></i> <?php echo $ti!="" ? diftiempo($fec, $ti) : ""; ?></td>
                            <td>
                                <b>
                                <?php
                                if(!is_null($re['idtdmesapartes'])){
                                    if(!is_null($re['idEmpleado'])){
                                        echo nomempleado($cone, $re['idEmpleado']).' <small class="text-aqua">'.nommpartes($cone, $re['idtdmesapartes']).'</small>';
                                    }else{
                                        echo nommpartes($cone, $re['idtdmesapartes']);
                                    }
                                }else{
                                    echo nomempleado($cone, $re['idEmpleado']).' <small class="text-aqua">'.nomdependencia($cone, $re['idDependencia']).'</small>';
                                }
                                ?>
                                </b>
                                <br>
                                <?php
                                if($re['idtdestado']!=4 && $re['idtdestado']!=2){
                                    echo nomempleado($cone, $re['asignador'])." <small class='text-aqua'>".(!is_null($re['mpasignador']) ? nommpartes($cone, $re['mpasignador']) : nomdependencia($cone, $re['depasignador']))."</small>";
                                }
                                ?>
                            </td>
                        </tr>
                        <?php if(!is_null($re['observacion'])){ ?>
                        <tr>
                            <td colspan="5">
                                <i class="fa fa-info-circle text-yellow"></i> <b class="text-muted">OBSERVACIÓN:</b> <?php echo $re['observacion']; ?>
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
                        <th colspan="2"><i class="fa fa-user text-aqua"></i> ASIGNADO A</th>
                        <th colspan="2"><i class="fa fa-user text-aqua"></i> ASIGNADO POR</th>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php
                                if(!is_null($rd['idtdmesapartes'])){
                                    if(!is_null($rd['idEmpleado'])){
                                        echo nomempleado($cone, $rd['idEmpleado']).' <br><small class="text-aqua">'.nommpartes($cone, $rd['idtdmesapartes']).'</small>';
                                    }else{
                                        echo nommpartes($cone, $rd['idtdmesapartes']);
                                    }
                                }else{
                                    echo nomempleado($cone, $rd['idEmpleado']).' <br><small class="text-aqua">'.nomdependencia($cone, $rd['idDependencia']).'</small>';
                                }
                            ?>
                        </td>
                        <td colspan="2">
                            <?php
                                echo nomempleado($cone, $rd['asignador'])." <br><small class='text-aqua'>".(!is_null($rd['mpasignador']) ? nommpartes($cone, $rd['mpasignador']) : nomdependencia($cone, $rd['depasignador']))."</small>";
                            ?>
                        </td> 
                    </tr>
                    <tr>
                        <th colspan="2"><i class="fa fa-calendar text-aqua"></i> FECHA</th>
                        <th colspan="2"><i class="fa fa-clock-o text-aqua"></i> TIEMPO</th>
                    </tr>
                    <tr>
                        <td colspan="2"><?php echo date('d/m/Y h:i:s A', strtotime($rd['fecha'])); ?></td>
                        <td colspan="2" class="text-orange"><?php echo diftiempo($rd['fecha'], date('Y-m-d H:i:s')); ?></td>
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
                            $cd=mysqli_query($cone, "SELECT DISTINCT mp.idtdmesapartes, mp.denominacion FROM tdestadodoc ed INNER JOIN tdmesapartes mp ON ed.idtdmesapartes=mp.idtdmesapartes WHERE ISNULL(ed.idtdguia) AND ed.idtdestado=3 AND ed.estado=1 AND ed.mpasignador=$v1;");
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
        }elseif($acc=="dermpp"){
            if(isset($v1) && !empty($v1) && isset($v2) && !empty($v2)){
                $idem=$_SESSION['identi'];
                $idl=idlocempleado($cone, $idem);
                $cmp=mysqli_query($cone, "SELECT idtdmesapartes FROM tdmesapartes WHERE idLocal=$idl AND estado=1 AND tipo=1;");
                if($rmp=mysqli_fetch_assoc($cmp)){
?>
                    <div class="row">
                        <input type="hidden" name="acc" value="<?php echo $acc; ?>">
                        <input type="hidden" name="v1" value="<?php echo $v1; ?>">
                        <input type="hidden" name="v2" value="<?php echo $v2; ?>">
                        <input type="hidden" name="imp" value="<?php echo $rmp['idtdmesapartes']; ?>">
                        
                        <div class="col-sm-5">
                            <label for="pro">Proveído<small class="text-red">*</small></label>
                            <select class="form-control" id="pro" name="pro" style="width: 100%;">
                            <?php
                            $ctp=mysqli_query($cone, "SELECT DISTINCT tipo FROM tdproveido WHERE estado=1;");
                            if(mysqli_num_rows($ctp)>0){
                                while($rtp=mysqli_fetch_assoc($ctp)){
                                    $tip=$rtp['tipo'];
                            ?>
                                <optgroup label="<?php echo $rtp['tipo']; ?>">
                            <?php
                                $cmp=mysqli_query($cone, "SELECT idtdproveido, motivo FROM tdproveido WHERE tipo='$tip' AND estado=1;");
                                if(mysqli_num_rows($cmp)>0){
                                    while($rmp=mysqli_fetch_assoc($cmp)){
                            ?>
                                    <option value="<?php echo $rmp['idtdproveido']; ?>"><?php echo $rmp['motivo']; ?></option>
                            <?php
                                    }
                                }
                                mysqli_free_result($cmp);
                            ?>
                                </optgroup>
                            <?php
                                }
                            }
                            mysqli_free_result($ctp);
                            ?>
                            </select>
                        </div>
                        <div class="col-sm-7">
                            <label for="per">Para<small class="text-red">*</small></label>
                            <select class="form-control" id="per" name="per" style="width: 100%;">
                                
                            </select>
                        </div>                     
                        <div class="col-sm-12">
                            <label for="num">Observación</label>
                            <textarea class="form-control" id="obs" name="obs"></textarea>
                        </div>
                    </div>
                    <div class="form-group" id="d_frespuesta">
                    </div>
                    <script>
                        $("#pro").select2();
                        $("#per").select2({
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
                        });
                    </script>            
<?php
                }else{
                    echo mensajewa("No existe Mesa de Partes en su Local. Solicite la creación de una.");
                }
            }else{
                echo mensajewa("Error, faltan datos.");
            }
        }elseif($acc=="derrep"){
            if(isset($v1) && !empty($v1) && isset($v2) && !empty($v2)){
                $idem=$_SESSION['identi'];
                $idl=idlocempleado($cone, $idem);
                $cmp=mysqli_query($cone, "SELECT idtdmesapartes FROM tdmesapartes WHERE idLocal=$idl AND estado=1 AND tipo=1;");
                if($rmp=mysqli_fetch_assoc($cmp)){
?>
                    <div class="row">
                        <input type="hidden" name="acc" value="<?php echo $acc; ?>">
                        <input type="hidden" name="v1" value="<?php echo $v1; ?>">
                        <input type="hidden" name="v2" value="<?php echo $v2; ?>">
                        <input type="hidden" name="imp" value="<?php echo $rmp['idtdmesapartes']; ?>">
                        
                        <div class="col-sm-12">
                            <label for="des">Destino<small class="text-red">*</small></label>
                            <select class="form-control" id="des" name="des" onchange="ocu(this.value);">
                                <option value="1">Mesa de Partes</option>
                                <option value="2">Directo a Personal</option>
                            </select>
                        </div> 
                        <div class="col-sm-12 ocu">
                            <label for="per">Para<small class="text-red">*</small></label>
                            <select class="form-control" id="per" name="per" style="width: 100%;">
                                
                            </select>
                        </div>                    
                    </div>
                    <div class="form-group" id="d_frespuesta">
                    </div>
                    <script>
                        $("#per").select2({
                          placeholder: 'Selecione al personal',
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
                        });
                        function ocu(v){
                            switch (v) {
                                case "1":
                                    $(".ocu").hide();
                                    break;
                                case "2":
                                    $(".ocu").show();
                                    break;
                            }
                        };
                        ocu("1");
                    </script>            
<?php
                }else{
                    echo mensajewa("No existe Mesa de Partes en su Local. Solicite la creación de una.");
                }
            }else{
                echo mensajewa("Error, faltan datos.");
            }
        }elseif($acc=="cammp"){
          if(isset($v1) && !empty($v1) && isset($v2) && !empty($v2)){
            $idem=$_SESSION['identi'];
            $idl=idlocempleado($cone, $idem);  
?>
        
        <div class="row">
            <input type="hidden" name="acc" value="<?php echo $acc; ?>">
            <input type="hidden" name="v1" value="<?php echo $v1; ?>">
            <input type="hidden" name="v2" value="<?php echo $v2; ?>">
            <div class="col-sm-12">
                <label for="mpd">Derivar a<small class="text-red">*</small></label>
                <select class="form-control" id="mpd" name="mpd" style="width: 100%;">
<?php
                $cmp=mysqli_query($cone, "SELECT idtdmesapartes, denominacion FROM tdmesapartes WHERE idLocal=$idl AND estado=1 ORDER BY tipo ASC LIMIT 1;");
                if($rmp=mysqli_fetch_assoc($cmp)){
?>
                    <option value="<?php echo $rmp['idtdmesapartes'] ?>"><?php echo $rmp['denominacion']; ?></option>
<?php
                }
?>
                </select>
            </div>
        </div>
        <div class="form-group" id="d_frespuesta">
        </div>
        <script>
            $("#mpd").select2({
              placeholder: 'Selecione una Mesa de Partes',
              ajax: {
                url: 'm_inclusiones/a_general/a_selmpartes.php',
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
        </script>  
<?php
          }else{
            echo mensajewa("Error, faltan datos.");
          }
        }elseif($acc=="gencar"){
            $idem=$_SESSION['identi'];
            $idl=idlocempleado($cone, $idem);  
?>
        
        <div class="row">
            <div class="col-sm-4">
                <label for="num">Número<small class="text-red">*</small></label>
                <input type="number" name="num" id="num" class="form-control">
            </div>
            <div class="col-sm-4">
                <label for="ano">Año<small class="text-red">*</small></label>
                <div class="input-group date" id="d_ano">
                    <input type="text" name="ano" id="ano" class="form-control" value="<?php echo date('Y'); ?>">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
                    
            </div>
            <div class="col-sm-4">
                <label>&nbsp;</label>
                <button type="button" class="btn btn-info btn-block" id="b_bdoc"><i class="fa fa-search"></i> Buscar</button>
            </div>
        </div>
        <div class="form-group" id="d_frespuesta">
        </div>
        <script>
            $('#d_ano').datepicker({
                format: 'yyyy',
                language: 'es',
                autoclose: true,
                minViewMode: 2,
                maxViewMode: 2,
                todayHighlight: true
            });
            $('#b_bdoc').on('click', function(){
              var num=$('#num').val();
              var ano=$('#ano').val();
              $.ajax({
                type: "post",
                url: "m_inclusiones/a_tdocumentario/f_bandeja.php",
                data: {v1: num, v2: ano, acc: 'busdoc'},
                dataType: "html",
                beforeSend: function(){
                  $("#d_frespuesta").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
                },
                success:function(a){                
                    $("#d_frespuesta").html(a);
                }
              });
            });
        </script>  
<?php

        }elseif($acc=="busdoc"){
            if(isset($v1) && !empty($v1) && isset($v2) && !empty($v2)){
                $cd=mysqli_query($cone, "SELECT d.idDoc, d.Numero, d.Ano, d.Siglas, d.FechaDoc, d.remitenteext, d.remitenteint, d.destinatarioext, d.destinatarioint, d.deporigenext, d.deporigenint, d.depdestinoext, d.depdestinoint, d.numdoc, d.asunto, td.TipoDoc, d.idDocRel, d.cargo FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc WHERE numdoc=$v1 AND Ano=$v2;");
                if($rd=mysqli_fetch_assoc($cd)){
                    $idd=$rd['idDoc'];
                    $iddr=$rd['idDocRel'];
?> 
        <div class="row">
            <div class="col-sm-12">
                <br>
                <table class="table table-bordered table-hover" style="font-size: 12px;">
                    <tr>
                        <th># DOC.</th>
                        <th>DOCUMENTO</th>
                        <th>REMITENTE</th>
                        <th>DESTINATARIO</th>
                    </tr>
                    <tr>
                        <td class="text-orange"><?php echo $rd['numdoc']."-".$rd['Ano']; ?></td>
                        <td class="text-blue"><?php echo ((!is_null($rd['Numero']) ? $rd['Numero']."-" : "").$rd['Ano'].(!is_null($rd['Siglas']) ? "-".$rd['Siglas'] : "")); ?><br><small class="text-purple"><?php echo $rd['TipoDoc']; ?></small> <small class="text-yellow"><?php echo $rd['cargo']==1 ? "(CARGO)" : "(ORIGINAL)"; ?></small></td>
                        <td class="text-blue"><?php echo !is_null($rd['remitenteint']) ? nomempleado($cone, $rd['remitenteint']) : $rd['remitenteext']; ?><br><small class="text-purple"><?php echo !is_null($rd['deporigenint']) ? nomdependencia($cone, $rd['deporigenint']) : $rd['deporigenext']; ?></small></td>
                        <td class="text-blue"><?php echo !is_null($rd['destinatarioint']) ? nomempleado($cone, $rd['destinatarioint']) : $rd['destinatarioext']; ?><br><small class="text-purple"><?php echo !is_null($rd['depdestinoint']) ? nomdependencia($cone, $rd['depdestinoint']) : $rd['depdestinoext']; ?></small></td>
                    </tr>
                    <tr>
                        <th>FECHA</th>
                        <th colspan="3">ASUNTO</th>
                    </tr>
                    <tr>
                        <td><?php echo fnormal($rd['FechaDoc']); ?></td>
                        <td colspan="3"><?php echo $rd['asunto']; ?></td>
                    </tr>
                    <tr>
                        <th>PERTENECE</th>

                        <td>
                        <?php
                        if(!is_null($iddr)){
                            $cp=mysqli_query($cone, "SELECT numdoc, Ano FROM doc WHERE idDoc=$iddr ORDER BY numdoc ASC;");
                            if(mysqli_num_rows($cp)>0){
                                while($rp=mysqli_fetch_assoc($cp)){
                                    echo $rp['numdoc']."-".$rp['Ano']."<br>";
                                }
                            }
                            mysqli_free_result($cp);
                        }
                        ?>
                        </td> 
                        <th>D. RELAC.</th>
                        <td>
                        <?php
                        $cr=mysqli_query($cone, "SELECT numdoc, Ano FROM doc WHERE idDocRel=$idd ORDER BY numdoc ASC;");
                        if(mysqli_num_rows($cr)>0){
                            while($rr=mysqli_fetch_assoc($cr)){
                                echo $rr['numdoc']."-".$rr['Ano']."<br>";
                            }
                        }
                        mysqli_free_result($cr);
                        ?>
                        </td>  
                    </tr>
                    <?php if($rd['cargo']!=1){ ?>
                    <tr>
                        <td colspan="4" align="center">
                            <button type="button" class="btn bg-maroon" id="b_crecar" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Creando..." onclick="g_crecar(<?php echo $idd; ?>);"><i class="fa fa-files-o"></i> Crear Cargo</button>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
            <div class="col-sm-12" id="d_rcc"></div>
        </div>
        <script>
            $('#b_bdoc').on('click', function(){
              var num=$('#num').val();
              var ano=$('#ano').val();
              $.ajax({
                type: "post",
                url: "m_inclusiones/a_tdocumentario/f_bandeja.php",
                data: {num: num, ano: ano, acc: 'busdoc'},
                dataType: "html",
                beforeSend: function(){
                  $("#d_frespuesta").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
                },
                success:function(a){                
                    $("#d_frespuestap").html(a.m);
                }
              });
            });
        </script>  
<?php
                }else{
                    echo mensajewa("No se halló el documento.");
                }
                mysqli_free_result($cd);
            }else{
                echo mensajewa("Ingrese número y año del documento.");
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