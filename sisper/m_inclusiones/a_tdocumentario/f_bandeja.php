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
            <!-- <div class="col-sm-3">
                <div class="checkbox">
                    <label>
                        <br>
                        <input type="checkbox" name="car" value="1">
                        Es cargo
                    </label>
                </div>
            </div> -->
            <div class="col-sm-9">
                <label for="mpd" class="text-teal">Derivar a <small class="text-red">*</small><small class="text-gray"> (Donde realizaran el envío a su destino)</small></label>
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
            //$("#tipdoc").select2();

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
		}elseif($acc=="agrdoa"){
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

            </div>
            <div class="col-sm-6">
                <label for="ped" class="text-green">Asignar para notificar a<small class="text-red">*</small></label>
                <select class="form-control" id="ped" name="ped" style="width: 100%;">

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
            //$("#tipdoc").select2();

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

            $("#ped").select2({
              placeholder: 'Selecione un Personal',
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
              minimumInputLength: 3
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
            <input type="hidden" name="aan" value="<?php echo $rd['Ano']; ?>">
            <input type="hidden" name="nd" value="<?php echo $rd['numdoc']; ?>">
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
                        <label for="obs">Observaciónes de la atención<small class="text-red">*</small></label>
                        <textarea class="form-control" id="obs" name="obs" autofocus="autofocus"></textarea>
                    </div>
                </div>
                <div class="form-group" id="d_frespuesta">
                </div>
                <script>
                    //$("#obs").focus();
                    //alert("Hola");
                </script>    
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
                            <select class="form-control" id="not" name="not" autofocus="autofocus">
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
                        <td class="text-aqua"><b><?php echo $rd['numdoc'].'-'.$rd['Ano']; ?></b></td>
                        <td class="text-primary"><?php echo $rd['TipoDoc'].'<small class="text-yellow"> ('.($rd['cargo']==1 ? "Cargo" : "Original").')</small>'; ?></td>
                        <td class="text-orange"><b><?php echo (!is_null($rd['Numero']) ? $rd['Numero']."-" : "").$rd['Ano']."-".$rd['Siglas']; ?></b></td>
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
                    <?php
                    $cca=mysqli_query($cone, "SELECT Ano, numdoc FROM doc WHERE idDocRel=$v1;");
                    if(mysqli_num_rows($cca)>0){
                        $ca="";
                        while($rca=mysqli_fetch_assoc($cca)){
                            $ca.=$rca['numdoc']."-".$rca['Ano']." ";
                        }
                    ?>
                    <tr>
                        <th><i class="fa fa-folder-open text-aqua"></i> CARGOS</th>
                        <td colspan="3" class="text-purple"><?php echo $ca; ?></td>
                    </tr>
                    <?php
                    }
                    mysqli_free_result($cca);
                    ?>
                    <?php
                    if(!is_null($rd['idDocRel'])){
                        $dr=$rd['idDocRel'];
                        $co=mysqli_query($cone, "SELECT Ano, numdoc FROM doc WHERE idDoc=$dr;");
                        if($ro=mysqli_fetch_assoc($co)){
                        ?>
                        <tr>
                            <th><i class="fa fa-folder-open text-aqua"></i> ORIGINAL</th>
                            <td colspan="3" class="text-purple"><?php echo $ro['numdoc']."-".$ro['Ano']; ?></td>
                        </tr>
                        <?php
                        }
                        mysqli_free_result($co);
                    }
                    ?>
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
                                <?php
                                    if(!is_null($re['idtdguia'])){
                                        $ig=$re['idtdguia'];
                                        $cg=mysqli_query($cone, "SELECT numero, anio FROM tdguia WHERE idtdguia=$ig;");
                                        if($rg=mysqli_fetch_assoc($cg)){
                                            echo '<br><span class="text-purple">G: '.$rg['numero'].'-'.$rg['anio'].'</span>';
                                        }
                                        mysqli_free_result($cg);
                                    }
                                ?>
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
?>
                    <div class="row">
                        <input type="hidden" name="acc" value="<?php echo $acc; ?>">
                        <input type="hidden" name="v1" value="<?php echo $v1; ?>">
                        <input type="hidden" name="v2" value="<?php echo $v2; ?>">
                        
                        <div class="col-sm-12">
                            <label for="des">Destino<small class="text-red">*</small></label>
                            <select class="form-control" id="des" name="des" onchange="ocu(this.value);">
                                <option value="1">A CENTRAL DE NOTIFICACIONES</option>
                                <option value="2">A PERSONAL</option>
                            </select>
                        </div> 
                        <div class="col-sm-12 mp">
                            <label for="mpa">Central de Notificaciones<small class="text-red">*</small></label>
                            <select class="form-control" name="mpa" id="mpa" style="width: 100%;"> 
                            </select>
                        </div>
                        <div class="col-sm-12 pe">
                            <label for="per">Personal<small class="text-red">*</small></label>
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
                        $("#mpa").select2({
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
                        function ocu(v){
                            switch (v) {
                                case "1":
                                    $(".pe").hide();
                                    $(".mp").show();
                                    break;
                                case "2":
                                    $(".pe").show();
                                    $(".mp").hide();
                                    break;
                            }
                        };
                        ocu("1");
                    </script>            
<?php
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
                $cd=mysqli_query($cone, "SELECT d.idDoc, d.Numero, d.Ano, d.Siglas, d.FechaDoc, d.remitenteext, d.remitenteint, d.destinatarioext, d.destinatarioint, d.deporigenext, d.deporigenint, d.depdestinoext, d.depdestinoint, d.numdoc, d.asunto, d.idTipoDoc, td.TipoDoc, d.idDocRel, d.cargo FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc WHERE numdoc=$v1 AND Ano=$v2;");
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
                    <?php
                    if($rd['cargo']!=1){ 
                        if($rd['idTipoDoc']!=14 && $rd['idTipoDoc']!=15){
                    ?>
                    <tr>
                        <td colspan="4" align="center">
                            <button type="button" class="btn bg-maroon" id="b_crecar" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Creando..." onclick="g_crecar(<?php echo $idd; ?>);"><i class="fa fa-files-o"></i> Crear Cargo</button>
                        </td>
                    </tr>
                    <?php
                        }elseif(idpersonalmp($cone, $_SESSION['identi'])==1 || idpersonalmp($cone, $_SESSION['identi'])==2){
                    ?>
                    <tr>
                        <td colspan="4" align="center">
                            <button type="button" class="btn bg-maroon" id="b_crecar" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Creando..." onclick="g_crecar(<?php echo $idd; ?>);"><i class="fa fa-files-o"></i> Crear Cargo</button>
                        </td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
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

        }elseif($acc=="dercar"){
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
                <button type="button" class="btn btn-info btn-block" id="b_bdocder"><i class="fa fa-search"></i> Buscar</button>
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
            $('#b_bdocder').on('click', function(){
              var num=$('#num').val();
              var ano=$('#ano').val();
              $.ajax({
                type: "post",
                url: "m_inclusiones/a_tdocumentario/f_bandeja.php",
                data: {v1: num, v2: ano, acc: 'busdocder'},
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

        }elseif($acc=="busdocder"){
            if(isset($v1) && !empty($v1) && isset($v2) && !empty($v2)){
                $cd=mysqli_query($cone, "SELECT d.idDoc, d.Numero, d.Ano, d.Siglas, d.FechaDoc, d.remitenteext, d.remitenteint, d.destinatarioext, d.destinatarioint, d.deporigenext, d.deporigenint, d.depdestinoext, d.depdestinoint, d.numdoc, d.asunto, d.idTipoDoc, td.TipoDoc, d.idDocRel, d.cargo FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc WHERE numdoc=$v1 AND Ano=$v2;");
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
                    <tr>
                        <th colspan="7" class="bg-danger">ÚLTIMO ESTADO</th>
                    </tr>
                    <tr>
                        <?php
                        $ces=mysqli_query($cone, "SELECT * FROM tdestadodoc WHERE idDoc=$idd AND estado=1");
                        if($res=mysqli_fetch_assoc($ces)){
                            $est=$res['idtdestado'];
                            $iest=$res['idtdestadodoc'];
                        }else{
                            $est=false;
                        }
                        ?>
                        <td>
                            <?php echo estadoDoc($res['idtdestado']); ?>
                            <?php
                                if(!is_null($res['idtdguia'])){
                                    $ig=$res['idtdguia'];
                                    $cg=mysqli_query($cone, "SELECT numero, anio FROM tdguia WHERE idtdguia=$ig;");
                                    if($rg=mysqli_fetch_assoc($cg)){
                                        echo '<br><span class="text-purple">G: '.$rg['numero'].'-'.$rg['anio'].'</span>';
                                    }
                                    mysqli_free_result($cg);
                                }
                            ?>
                        </td>
                        <td><?php echo date('d/m/Y h:i:s A', strtotime($res['fecha'])); ?></td>
                        <td colspan="5">
                            <b>
                            <?php
                            if(!is_null($res['idtdmesapartes'])){
                                if(!is_null($res['idEmpleado'])){
                                    echo nomempleado($cone, $res['idEmpleado']).' <small class="text-aqua">'.nommpartes($cone, $res['idtdmesapartes']).'</small>';
                                }else{
                                    echo nommpartes($cone, $res['idtdmesapartes']);
                                }
                            }else{
                                echo nomempleado($cone, $res['idEmpleado']).' <small class="text-aqua">'.nomdependencia($cone, $res['idDependencia']).'</small>';
                            }
                            ?>
                            </b>
                            <br>
                            <?php
                            if($res['idtdestado']!=4 && $res['idtdestado']!=2){
                                echo nomempleado($cone, $res['asignador'])." <small class='text-aqua'>".(!is_null($res['mpasignador']) ? nommpartes($cone, $res['mpasignador']) : nomdependencia($cone, $res['depasignador']))."</small>";
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                    mysqli_free_result($ces);
                    if($rd['cargo']!=1 && $est==3){
                    ?>
                    <tr>
                        <td colspan="3">
                            
                            <select name="dmp" id="dmp" class="form-control">
                            </select>
                            <input type="hidden" name="uest" id="uest" value="<?php echo $iest ?>">
                        </td>
                        <td colspan="4" align="center">
                            <button type="button" class="btn bg-maroon" id="b_dercar" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Creando..." onclick="g_dercar(<?php echo $idd; ?>);"><i class="fa fa-level-up"></i> Derivar Cargo</button>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </table>
            </div>
            <div class="col-sm-12" id="d_rcc"></div>
        </div>
        <script>            
            $("#dmp").select2({
                placeholder: 'Selecciones una mesa de partes',
                ajax: {
                    url: 'm_inclusiones/a_general/a_selmpartes.php',
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data){
                        return{
                            results:data
                        };
                    },
                    cache: true
                },
                minimumInputLength: 3
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

        }elseif($acc=="carori"){
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
                <button type="button" class="btn btn-info btn-block" id="b_bcarori"><i class="fa fa-search"></i> Buscar</button>
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
            $('#b_bcarori').on('click', function(){
              var num=$('#num').val();
              var ano=$('#ano').val();
              $.ajax({
                type: "post",
                url: "m_inclusiones/a_tdocumentario/f_bandeja.php",
                data: {v1: num, v2: ano, acc: 'buscarori'},
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
        }elseif($acc=="buscarori"){
            if(isset($v1) && !empty($v1) && isset($v2) && !empty($v2)){
                $cd=mysqli_query($cone, "SELECT d.idDoc, d.Numero, d.Ano, d.Siglas, d.FechaDoc, d.remitenteext, d.remitenteint, d.destinatarioext, d.destinatarioint, d.deporigenext, d.deporigenint, d.depdestinoext, d.depdestinoint, d.numdoc, d.asunto, d.idTipoDoc, td.TipoDoc, d.idDocRel, d.cargo FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc WHERE numdoc=$v1 AND Ano=$v2;");
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
                    <tr>
                        <td colspan="4" align="center">
                            <button type="button" class="btn bg-maroon" id="b_carori" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Convirtiendo..." onclick="g_carori(<?php echo $idd.', '.$rd['cargo']; ?>);"><i class="fa fa-toggle-on"></i> Convertir a <?php echo $rd['cargo']==1 ? 'original' : 'cargo' ?></button>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-12" id="d_rcc"></div>
        </div>
<?php
                }else{
                    echo mensajewa("No se halló el documento.");
                }
                mysqli_free_result($cd);
            }else{
                echo mensajewa("Ingrese número y año del documento.");
            }

        }elseif($acc=="edidocu"){
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
                <button type="button" class="btn btn-info btn-block" id="b_bedidocu"><i class="fa fa-search"></i> Buscar</button>
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
            $('#b_bedidocu').on('click', function(){
              var num=$('#num').val();
              var ano=$('#ano').val();
              $.ajax({
                type: "post",
                url: "m_inclusiones/a_tdocumentario/f_bandeja.php",
                data: {v1: num, v2: ano, acc: 'busedidocu'},
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
        }elseif($acc=="busedidocu"){
            if(isset($v1) && !empty($v1) && isset($v2) && !empty($v2)){
                $cd=mysqli_query($cone, "SELECT d.idDoc, d.Numero, d.Ano, d.Siglas, d.FechaDoc, d.remitenteext, d.remitenteint, d.destinatarioext, d.destinatarioint, d.deporigenext, d.deporigenint, d.depdestinoext, d.depdestinoint, d.numdoc, d.asunto, d.idTipoDoc, td.TipoDoc, d.idDocRel, d.cargo FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc WHERE numdoc=$v1 AND Ano=$v2;");
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
                    <tr>
                        <td colspan="4" align="center">
                            <button type="button" class="btn bg-maroon" id="b_dercar" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Cargando..." onclick="f_bandeja('edidoc', <?php echo $idd ?>, 0);"><i class="fa fa-edit"></i> Editar</button>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-12" id="d_rcc"></div>
        </div>
<?php
                }else{
                    echo mensajewa("No se halló el documento.");
                }
                mysqli_free_result($cd);
            }else{
                echo mensajewa("Ingrese número y año del documento.");
            }

        }elseif($acc=="movdia"){

                $idem=$_SESSION['identi'];
                

                    $cdg=mysqli_query($cone, "SELECT d.numdoc, d.Numero, d.Ano, d.Siglas, ed.idtdestado, ed.fecha FROM tdestadodoc ed INNER JOIN doc d ON ed.idDoc=d.idDoc WHERE ed.asignador=$idem AND DATE_FORMAT(ed.fecha, '%Y-%m-%d')=CURDATE() ORDER BY ed.fecha DESC;");
                    if(mysqli_num_rows($cdg)>0){
?>
                        <table class="table table-hover table-bordered" id="dt_mov">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NUM.</th>
                                    <th>DOCUMENTO</th>
                                    <th>MOVIMIENTO</th>
                                    <th>FECHA MOV.</th>
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
                                    <td><?php echo estadoDoc($rdg['idtdestado']); ?></td>
                                    <td><?php echo ftnormal($rdg['fecha']); ?></td>
                                </tr>
<?php
                            }
?>
                            </tbody>
                        </table>
                        <script>
                            $('#dt_mov').dataTable();
                        </script>
<?php
                    }else{
                        echo mensajewa("Hoy aún no ha realizado movimientos.");
                    }
                    mysqli_free_result($cdg);
                
        }elseif($acc=="regrem"){
            $idem=$_SESSION['identi'];
            $idl=idlocempleado($cone, $idem);  
?>
        <div class="row">
            <input type="hidden" name="acc" value="<?php echo $acc; ?>">
            <input type="hidden" name="imp" value="<?php echo $v1; ?>">
            <div class="col-sm-12">
                <label for="remdes">Destino<small class="text-red">*</small></label>
                <select class="form-control" id="remdes" name="remdes" style="width: 100%;">

                </select>
            </div>
            <div class="col-sm-4">
                <label for="remnum">Número<small class="text-red">*</small></label>
                <input type="text" name="remnum" id="remnum" class="form-control">
            </div>
            <div class="col-sm-4">
                <label for="rempes">Peso<small class="text-red">*</small></label>
                <input type="number" name="rempes" id="rempes" class="form-control" step="0.01">
            </div>
            <div class="col-sm-4 acta">
                <label for="remacta">Número de acta<small class="text-red">*</small></label>
                <input type="text" name="remacta" id="remacta" class="form-control">
            </div>
        </div>
        <div class="form-group" id="d_frespuesta">
        </div>
        <script>
            //mostrar numero de acta solo si el peso es mayor o igual a 30
            $('.acta').hide();
            $('#rempes').on('input', function(){
                var peso=parseFloat($(this).val());
                if(peso>=30){
                    $('.acta').show();
                }else{
                    $('.acta').hide();
                }
            });
            $("#remdes").select2({
              placeholder: 'Selecione el destino',
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
              minimumInputLength: 4
            });
        </script>  
<?php

        }elseif($acc=="edirem"){
            if(isset($v1) && !empty($v1)){
                $cr=mysqli_query($cone, "SELECT * FROM tdremito WHERE idtdremito=$v1;");
                if($rr=mysqli_fetch_assoc($cr)){

                    $idem=$_SESSION['identi'];
?>
        <div class="row">
            <input type="hidden" name="acc" value="<?php echo $acc; ?>">
            <input type="hidden" name="idrem" value="<?php echo $v1; ?>">
            <div class="col-sm-12">
                <label for="remdes">Destino<small class="text-red">*</small></label>
                <select class="form-control" id="remdes" name="remdes" style="width: 100%;">
                <?php
                $cmp=mysqli_query($cone, "SELECT denominacion FROM tdmesapartes WHERE idtdmesapartes=$rr[mp_destino];");
                if($rmp=mysqli_fetch_assoc($cmp)){
                    echo '<option value="'.$rr['mp_destino'].'" selected>'.$rmp['denominacion'].'</option>';
                }
                mysqli_free_result($cmp);
                ?>
                </select>
            </div>
            <div class="col-sm-4">
                <label for="remnum">Número<small class="text-red">*</small></label>
                <input type="text" name="remnum" id="remnum" class="form-control" value="<?php echo $rr['num_remito'] ?>">
            </div>
            <div class="col-sm-4">
                <label for="rempes">Peso<small class="text-red">*</small></label>
                <input type="number" name="rempes" id="rempes" class="form-control" step="0.01" value="<?php echo $rr['peso'] ?>">
            </div>
            <div class="col-sm-4 acta">
                <label for="remacta">Número de acta<small class="text-red">*</small></label>
                <input type="text" name="remacta" id="remacta" class="form-control" value="<?php echo $rr['num_acta'] ?>">
            </div>
        </div>
        <div class="form-group" id="d_frespuesta">
        </div>
        <script>
            //mostrar numero de acta solo si el peso es mayor o igual a 30
            <?php if($rr['peso']<30){ ?>
            $('.acta').hide();
            <?php } ?>
            $('#rempes').on('input', function(){
                var peso=parseFloat($(this).val());
                if(peso>=30){
                    $('.acta').show();
                }else{
                    $('.acta').hide();
                }
            });
            $("#remdes").select2({
              placeholder: 'Selecione el destino',
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
              minimumInputLength: 4
            });
        </script>  
<?php
                }else{
                    echo mensajewa("No se halló el remito.");
                }
                mysqli_free_result($cr);
            }else{
                echo mensajewa("Error: Faltan datos.");
            }
        }elseif($acc=="fecrem"){
            if(isset($v1) && !empty($v1)){
                $cr=mysqli_query($cone, "SELECT fecha_remite FROM tdremito WHERE idtdremito=$v1;");
                if($rr=mysqli_fetch_assoc($cr)){
                    $idem=$_SESSION['identi'];
                    $idl=idlocempleado($cone, $idem);  
?>
        <div class="row">
            <input type="hidden" name="acc" value="<?php echo $acc; ?>">
            <input type="hidden" name="idrem" value="<?php echo $v1; ?>">
            <div class="col-sm-12">
                <label for="fec">Fecha Remite<small class="text-red">*</small></label>
                <input type="text" name="fec" id="fec" class="form-control" value="<?php echo date('d/m/Y', strtotime($rr['fecha_remite'])); ?>">
            </div>
        </div>
        <div class="form-group" id="d_frespuesta">
        </div>
        <script>
            $("#fec").datepicker({
                format: "dd/mm/yyyy",
                autoclose: true,
                language: "es",
                todayHighlight: true,
                minViewMode: 0,
                maxViewMode: 2
            });
        </script>  
<?php
                }else{
                    echo mensajewa("No se halló el remito.");
                }
                mysqli_free_result($cr);
            }else{
                echo mensajewa("Error: Faltan datos.");
            }
        }elseif($acc=="feccar"){
            if(isset($v1) && !empty($v1)){
                $cr=mysqli_query($cone, "SELECT fecha_cargo FROM tdremito WHERE idtdremito=$v1;");
                if($rr=mysqli_fetch_assoc($cr)){
                    $idem=$_SESSION['identi'];
                    $idl=idlocempleado($cone, $idem);  
?>
        <div class="row">
            <input type="hidden" name="acc" value="<?php echo $acc; ?>">
            <input type="hidden" name="idrem" value="<?php echo $v1; ?>">
            <div class="col-sm-12">
                <label for="fec">Fecha Cargo<small class="text-red">*</small></label>
                <input type="text" name="fec" id="fec" class="form-control" value="<?php echo $rr['fecha_cargo'] ? date('d/m/Y', strtotime($rr['fecha_cargo'])) : date('d/m/Y'); ?>">
            </div>
        </div>
        <div class="form-group" id="d_frespuesta">
        </div>
        <script>
            $("#fec").datepicker({
                format: "dd/mm/yyyy",
                autoclose: true,
                language: "es",
                todayHighlight: true,
                minViewMode: 0,
                maxViewMode: 2
            });
        </script>  
<?php
                }else{
                    echo mensajewa("No se halló el remito.");
                }
                mysqli_free_result($cr);
            }else{
                echo mensajewa("Error: Faltan datos.");
            }
        }elseif($acc=="fecrec"){
            if(isset($v1) && !empty($v1)){
                $cr=mysqli_query($cone, "SELECT fecha_recepcion FROM tdremito WHERE idtdremito=$v1;");
                if($rr=mysqli_fetch_assoc($cr)){
                    $idem=$_SESSION['identi'];
                    $idl=idlocempleado($cone, $idem);  
?>
        <div class="row">
            <input type="hidden" name="acc" value="<?php echo $acc; ?>">
            <input type="hidden" name="idrem" value="<?php echo $v1; ?>">
            <input type="hidden" name="origen" value="<?php echo $v2; ?>">
            <div class="col-sm-12">
                <label for="fec">Fecha Recepción<small class="text-red">*</small></label>
                <input type="text" name="fec" id="fec" class="form-control" value="<?php echo $rr['fecha_recepcion'] ? date('d/m/Y', strtotime($rr['fecha_recepcion'])) : date('d/m/Y'); ?>">
            </div>
        </div>
        <div class="form-group" id="d_frespuesta">
        </div>
        <script>
            $("#fec").datepicker({
                format: "dd/mm/yyyy",
                autoclose: true,
                language: "es",
                todayHighlight: true,
                minViewMode: 0,
                maxViewMode: 2
            });
        </script>  
<?php
                }else{
                    echo mensajewa("No se halló el remito.");
                }
                mysqli_free_result($cr);
            }else{
                echo mensajewa("Error: Faltan datos.");
            }
        }elseif($acc=="elirem"){
            if(isset($v1) && !empty($v1)){
                $cr=mysqli_query($cone, "SELECT num_remito FROM tdremito WHERE idtdremito=$v1;");
                if($rr=mysqli_fetch_assoc($cr)){
                    $crg=mysqli_query($cone, "SELECT idtdguia_remito FROM tdguia_remito WHERE idtdremito=$v1;");
                    if(mysqli_num_rows($crg)>0){
?>
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <h4 class="text-warning">El remito <?php echo $rr['num_remito']; ?> no se puede eliminar porque tiene guías asociadas.</h4>
                                <small>Si desea eliminarlo, primero elimine las guías asociadas.</small>
                            </div>
                        </div>
<?php
                    }else{
                        
                    
?>
                    <div class="row">
                        <input type="hidden" name="acc" value="<?php echo $acc; ?>">
                        <input type="hidden" name="idrem" value="<?php echo $v1; ?>">
                        <div class="col-sm-12 text-center">
                            <h4 class="text-red">¿Está seguro de eliminar el remito <?php echo $rr['num_remito']; ?>?</h4>
                            <small>Esta acción no se puede deshacer.</small>
                        </div>
                    </div>
                    <div class="form-group" id="d_frespuesta">
                    </div> 
<?php
                    }
                    mysqli_free_result($crg);
                }else{
                    echo mensajewa("No se halló el remito.");
                }
                mysqli_free_result($cr);
            }else{
                echo mensajewa("Error: Faltan datos.");
            }
        }elseif($acc=="detrem"){
            if(isset($v1) && !empty($v1) && isset($v2) && !empty($v2)){
                $cr=mysqli_query($cone, "SELECT * FROM tdremito WHERE idtdremito=$v1;");
                if($rr=mysqli_fetch_assoc($cr)){
?>
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered table-hover" style="font-size: 12px;">
                                <tr>
                                    <td>
                                        <small class="text-muted">REMITO</small><br>
                                        <span class="text-red" style="font-size: 14px;"><?php echo $rr['num_remito']; ?></span>
                                    </td>
                                    <td>
                                        <small class="text-muted">PESO</small><br>
                                        <?php echo $rr['peso']; ?> kg
                                        <?php if($rr['num_acta']){ ?><br><small class="text-muted">ACTA</small><br><?php echo $rr['num_acta']; } ?>
                                    </td>
                                    <td>
                                        <small class="text-muted">FECHA REMITE</small><br>
                                        <?php echo date('d/m/Y', strtotime($rr['fecha_remite'])); ?>
                                        <br><small class="text-gray"><?php echo $rr['r_remite'] ? nomempleado($cone, $rr['r_remite']) : ""; ?></small>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <small class="text-muted">REMITE</small><br>
                                        <?php echo nommpartes($cone, $rr['mp_remite']); ?>
                                    </td>
                                    <td>
                                        <small class="text-muted">FECHA RECEPCIÓN</small><br>
                                        <?php echo $rr['fecha_recepcion'] ? date('d/m/Y', strtotime($rr['fecha_recepcion'])) : ""; ?>
                                        <br><small class="text-gray"><?php echo $rr['r_recepcion'] ? nomempleado($cone, $rr['r_recepcion']) : ""; ?></small>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <small class="text-muted">DESTINO</small><br>
                                        <?php echo nommpartes($cone, $rr['mp_destino']); ?>
                                    </td>
                                    <td>
                                        <small class="text-muted">FECHA CARGO</small><br>
                                        <?php echo $rr['fecha_cargo'] ? date('d/m/Y', strtotime($rr['fecha_cargo'])) : ""; ?>
                                        <br><small class="text-gray"><?php echo $rr['r_cargo'] ? nomempleado($cone, $rr['r_cargo']) : ""; ?></small>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-sm-12">
                            
                            <?php
                            $crg=mysqli_query($cone, "SELECT g.idtdguia, g.numero, g.anio FROM tdguia_remito as gr INNER JOIN tdguia g ON gr.idtdguia=g.idtdguia WHERE gr.idtdremito=$v1;");
                            if(mysqli_num_rows($crg)>0){
?>
                                <h4 class="text-center text-muted">GUÍAS ASOCIADAS</h4>
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th class="text-center"># GUÍAS</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="text-center">
                                            <?php
                                            while($rrg=mysqli_fetch_assoc($crg)){       
                                                echo $rrg['numero']."-".$rrg['anio']." ";
                                                //boton para eliminar la guía del remito
                                                if($v2==$rr['mp_remite'] && is_null($rr['fecha_recepcion']) && is_null($rr['fecha_cargo'])){
                                                    echo '<button type="button" class="btn btn-danger btn-xs" title="Eliminar del remito" onclick="g_elguirem('.$rrg['idtdguia'].', '.$v1.','.$rr['mp_remite'].');"><i class="fa fa-times"></i></button> &emsp;';
                                                }else{
                                                    echo '&emsp;';
                                                }
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
<?php
                            }else{
                                echo mensajewa("No hay guías asociadas a este remito.");
                            }
                            mysqli_free_result($crg);                    
                }else{
                    echo mensajewa("No se halló el remito.");
                }
                mysqli_free_result($cr);
            }else{
                echo mensajewa("Error: Faltan datos.");
            }
        }elseif($acc=="guirem"){
            if(isset($v1) && !empty($v1)){
                //Verificar que la guía no esté incluida en un remito
                $crg=mysqli_query($cone, "SELECT idtdremito FROM tdguia_remito WHERE idtdguia=$v1;");
                if(mysqli_num_rows($crg)>0){
                    echo mensajewa("La guía ya está incluida en un remito, no se puede incluir en otro.");
                    mysqli_free_result($crg);
                    exit;
                }
                mysqli_free_result($crg);

                $cg=mysqli_query($cone, "SELECT numero, anio, fecenvio, idLocal FROM tdguia g INNER JOIN tdmesapartes mp ON g.idtdmesapartesd = mp.idtdmesapartes WHERE idtdguia=$v1;");
                if($rg=mysqli_fetch_assoc($cg)){
                    //obtener los ids de las mesas de partes en el local de la guía
                    $mpd=mysqli_query($cone, "SELECT idtdmesapartes FROM tdmesapartes WHERE idLocal=$rg[idLocal];");
                    $mpd=mysqli_fetch_all($mpd, MYSQLI_ASSOC);
                    //obtener la mesa de partes el usuario
                    $idem=$_SESSION['identi'];
                    $cmpu=mysqli_query($cone, "SELECT idtdmesapartes FROM tdpersonalmp WHERE idEmpleado=$idem AND estado=1;");
                    //Validar que exista algún registro
                    if(mysqli_num_rows($cmpu)>0){
                        $rmpu=mysqli_fetch_assoc($cmpu);
                        //obtener el id de la mesa de partes del usuario
                        $mpu_id = $rmpu['idtdmesapartes'];
                    }else{
                        echo mensajewa("No se encontró una mesa de partes asociada al usuario.");
                        mysqli_free_result($cmpu);
                        exit;
                    }
                    mysqli_free_result($cmpu);

?>
                    <div class="row">
                        <input type="hidden" name="acc" value="<?php echo $acc; ?>">
                        <input type="hidden" name="idguia" value="<?php echo $v1; ?>">
                        <div class="col-sm-12 text-center">
                            <h4 class="text-maroon">Guía <?php echo $rg['numero'].'-'.$rg['anio']; ?> <small>[<?php echo fnormal($rg['fecenvio']); ?>]</small></h4>
                        <div class="col-sm-12">
<?php
                        //consultar los remitos con la mp_destino igual a la mp_destino de la guía y sin fecha de recepción ni de cargo y de una antiguedad de 2 meses de la fecha de remite
                        $mpd_ids = array_column($mpd, 'idtdmesapartes');
                        $mpd_ids_str = implode(',', $mpd_ids);
                        $cr=mysqli_query($cone, "SELECT idtdremito, num_remito, fecha_remite, mp_destino FROM tdremito WHERE mp_remite = $mpu_id AND mp_destino IN ($mpd_ids_str) AND fecha_recepcion IS NULL AND fecha_cargo IS NULL AND fecha_remite >= DATE_SUB(NOW(), INTERVAL 2 MONTH) ORDER BY fecha_remite DESC;");
                        if(mysqli_num_rows($cr)>0){
?>
                            <table class="table table-bordered table-hover" style="font-size: 12px;">
                                <tr>
                                    <th>#</th>
                                    <th>REMITO</th>
                                    <th>DESTINO</th>
                                    <th>FECHA REMITE</th>
                                    <th>ACCIONES</th>
                                </tr>
<?php
                                $n=0;
                                while($rr=mysqli_fetch_assoc($cr)){
                                    $n++;
?>
                                <tr>
                                    <td><?php echo $n; ?></td>
                                    <td><?php echo $rr['num_remito']; ?></td>
                                    <td><?php echo nommpartes($cone,$rr['mp_destino']); ?></td>
                                    <td><?php echo fnormal($rr['fecha_remite']); ?></td>
                                    <td>
                                        <button type="button" class="btn bg-orange btn-xs" id="btn-guiaremito" title="Incluir en Remito" onclick="g_guirem(<?php echo $v1.','.$rr['idtdremito']; ?>)"><i class="fa fa-check"></i></button>
                                    </td>
                                </tr>
<?php
                                }
                                mysqli_free_result($cr);
                        }else{
                            echo mensajewa("No hay remitos disponibles con el mismo destino donde incluir la guía.");
                        }
?>
                        </div>
                    </div>
                    <div class="form-group" id="d_frespuesta">
                    </div>

<?php
                }else{
                    echo mensajewa("No se halló el remito.");
                }
                mysqli_free_result($cg);
            }else{
                echo mensajewa("Error: Faltan datos.");
            }
        }elseif($acc=="retgen"){
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
                <button type="button" class="btn btn-info btn-block" id="b_bretgen"><i class="fa fa-search"></i> Buscar</button>
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
            $('#b_bretgen').on('click', function(){
              var num=$('#num').val();
              var ano=$('#ano').val();
              $.ajax({
                type: "post",
                url: "m_inclusiones/a_tdocumentario/f_bandeja.php",
                data: {v1: num, v2: ano, acc: 'busretgen'},
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
        }elseif($acc=="busretgen"){
            if(isset($v1) && !empty($v1) && isset($v2) && !empty($v2)){
                $cd=mysqli_query($cone, "SELECT d.idDoc, d.Numero, d.Ano, d.Siglas, d.FechaDoc, d.remitenteext, d.remitenteint, d.destinatarioext, d.destinatarioint, d.deporigenext, d.deporigenint, d.depdestinoext, d.depdestinoint, d.numdoc, d.asunto, d.idTipoDoc, td.TipoDoc, d.cargo FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc WHERE numdoc=$v1 AND Ano=$v2;");
                if($rd=mysqli_fetch_assoc($cd)){
                    $idd=$rd['idDoc'];

                    $idem=$_SESSION['identi'];

                    //consultamos la mesa de partes del empleado
                    $cmpe=mysqli_query($cone, "SELECT idtdmesapartes FROM tdpersonalmp WHERE idEmpleado=$idem AND estado=1;");
                    if($rmpe=mysqli_fetch_assoc($cmpe)){
                        $idmp=$rmpe['idtdmesapartes'];
                    }else{
                        echo mensajewa("El personal no tiene asignada una mesa de partes.");
                        exit;
                    }
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
                        <td colspan="4" align="center">
                            <?php
                            //consultadomos su estado actual
                            $cest=mysqli_query($cone, "SELECT idtdestadodoc FROM tdestadodoc WHERE idDoc=$idd AND idtdmesapartes=$idmp AND estado=1 AND idtdestado=6;");
                            if(mysqli_num_rows($cest)>0){
                                $rest=mysqli_fetch_assoc($cest);
                            ?>
                            <button type="button" class="btn btn-primary" id="b_retgen" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Retornando..." onclick="g_retgen(<?php echo $rest['idtdestadodoc']; ?>);"><i class="fa fa-reply"></i> Retornar de generador</button>
                            <?php
                            }else{
                                echo mensajewa("El documento no ha sido enviado al generador o no corresponde a su mesa de partes.");
                            }
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-12" id="d_rcc"></div>
        </div>
<?php
                }else{
                    echo mensajewa("No se halló el documento.");
                }
                mysqli_free_result($cd);
            }else{
                echo mensajewa("Ingrese número y año del documento.");
            }

        }elseif($acc=="aguidoc"){
            if(isset($v1) && !empty($v1)){
                //obtenemos el idtdmesapartesd de la guía
                $cg=mysqli_query($cone, "SELECT numero, anio, idtdmesapartesg, idtdmesapartesd, generador FROM tdguia WHERE idtdguia=$v1 AND estado=1;");
                if($rg=mysqli_fetch_assoc($cg)){
                    if($_SESSION['identi']==$rg['generador']){
                        $idmpg=$rg['idtdmesapartesg'];
                        $idmpd=$rg['idtdmesapartesd'];
                        //Consultamos los doc que tienes su tdestadodoc con idtdestado=3, idtdmesapartes igual al $idmpd, mpasignador igual al idmpg, el idtdguia sea null y el estado igual a 1. obtener los registros cuya fecha en el tdestadodoc sea como minimo del último año
                        $q="SELECT d.Numero, d.Ano, d.Siglas, d.numdoc, ed.idtdestadodoc, ed.fecha FROM doc d INNER JOIN tdestadodoc ed ON d.idDoc=ed.idDoc WHERE ed.idtdestado=3 AND ed.estado=1 AND ed.idtdmesapartes=$idmpd AND ed.mpasignador=$idmpg AND ed.idtdguia IS NULL  AND ed.idEmpleado IS NULL ORDER BY ed.fecha DESC;";
                        $cd=mysqli_query($cone, $q);
                        if(mysqli_num_rows($cd)>0){
?>
                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="text-center">GUÍA: <?php echo $rg['numero'].'-'.$rg['anio']; ?></h3>
                                <h5 class="text-center text-orange">DESTINO: <?php echo nommpartes($cone, $idmpd); ?></h5>
                                <small class="text-warning text-center">Nota: Solo agregar documentos adicionales antes de imprimir la guía y enviarlos.</small>
                                <hr>
                                <table class="table table-bordered table-hover" id="dt_documentos" style="font-size: 12px;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th class="hidden">id</th>
                                            <th>SEGUIMIENTO</th>
                                            <th>DOCUMENTO</th>
                                            <th>FECHA DERIVACIÓN</th>
                                            <th>ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
                            $n=0;
                            while($rd=mysqli_fetch_assoc($cd)){
                            $n++;
?>
                                    <tr>
                                        <td><?php echo $n; ?></td>
                                        <th class="hidden"><?php echo $rd['idtdestadodoc'].' '.$v1; ?></th>
                                        <td><?php echo $rd['numdoc'].'-'.$rd['Ano']; ?></td>
                                        <td><?php echo $rd['Numero'].'-'.$rd['Ano'].'-'.$rd['Siglas']; ?></td>
                                        <td><?php echo fnormal($rd['fecha']); ?></td>
                                        <td>
                                            <div class="btn-group btn-group-xs">
                                                <button type="button" class="btn bg-purple btn-xs" title="Agregar a guía" id="btn-aguidoc"><i class="fa fa-check"></i></button>
                                            </div>
                                        </td>
                                    </tr>
<?php
                    }
?>
                                </tbody>
                            </table>
                            <script>

                                var table = $("#dt_documentos").DataTable();

                                $('#dt_documentos tbody').on('click', 'button#btn-aguidoc', function() {
                                    var d = table.row($(this).parents('tr')).data()[1];
                                    var da = d.split(' ');
                                    var ta = table.row($(this).parents('tr'));

                                    $.ajax({
                                        type: "post",
                                        url: "m_inclusiones/a_tdocumentario/g_bandeja.php",
                                        data: { acc: 'aguidoc', estado: da[0], guia: da[1] },
                                        dataType: "json",
                                        success: function (a) {
                                            if (a.e) {
                                                alertify.success(a.m);
                                                ta.remove().draw();
                                            } else {
                                                alertify.error(a.m);
                                            }
                                        }
                                    });
                                });
                            </script>
                        </div>
                    </div>
                    
<?php
                        }else{
                            echo mensajewa("No se encontraron documentos derivados al destino de la guía. ");
                        }
                        mysqli_free_result($cd);
                    }else{
                        echo mensajewa(nomempleado($cone, $rg['generador']).".<br />Es el único que puede agregar documentos adicionales a la guía, porque es quien la generó.<br /><small class='text-warning'>* Si desea agregar documentos, por favor solicite al generador que lo haga.</small>");
                    }
                }else{
                    echo mensajewa("No se halló la guía.");
                }
                mysqli_free_result($cg);
            }else{
                echo mensajewa("Error: Faltan datos.");
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