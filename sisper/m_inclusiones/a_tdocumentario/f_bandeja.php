<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],17)){
	if(isset($_POST['acc']) && !empty($_POST['acc'])){
		$acc=iseguro($cone,$_POST['acc']);		
		$v1=iseguro($cone,$_POST['v1']);
		$v2=iseguro($cone,$_POST['v2']);
		if($acc=="agrdoc"){
?>	<div class="row">
            <div class="col-sm-3">
                <label for="num">Número<small class="text-red">*</small></label>
                <input type="text" class="form-control" id="num" name="num" placeholder="001">
            </div>
            <div class="col-sm-3">
                <label for="ano">Año<small class="text-red">*</small></label>
                <input type="text" class="form-control" id="ano" name="ano" placeholder="2019">
            </div>
            <div class="col-sm-6">
                <label for="sig">Siglas<small class="text-red">*</small></label>
                <input type="text" class="form-control" id="sig" name="sig" placeholder="MPFN-DFC-INF">
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
                    <input type="text" class="form-control" id="fecdoc" name="fecdoc" placeholder="dd/mm/aaaa">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
            </div>
            <div class="col-sm-3">
                <label for="leg">Legajo</label>
                <input type="text" class="form-control" id="leg" name="leg" placeholder="Folio 1">
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
            <div class="col-sm-6 rint">
                <label for="direm">Dependencia/institución remitente<small class="text-red">*</small></label>
                <select class="form-control" id="direm" name="direm">
                    
                </select>
            </div>
            <div class="col-sm-4 rint">
                <label for="pirem">Remitente<small class="text-red">*</small></label>
                <select class="form-control" id="pirem" name="pirem">
                    
                </select>
            </div>
            <div class="col-sm-6 rext">
                <label for="derem">Dependencia/institución remitente<small class="text-red">*</small></label>
                <input type="text" class="form-control" id="derem" name="derem" placeholder="Dependencia/institución remitente">
            </div>
            <div class="col-sm-4 rext">
                <label for="perem">Remitente<small class="text-red">*</small></label>
                <input type="text" class="form-control" id="perem" name="perem" placeholder="Remitente">
            </div>
            <div class="col-sm-2">
                <label for="tdes">Destino<small class="text-red">*</small></label>
                <select name="tdes" id="tdes" class="form-control" onchange="odes(this.value);">
                    <option value="i">Interno</option>
                    <option value="e">Externo</option>
                </select>
            </div>
            <div class="col-sm-6 dint">
                <label for="dides">Dependencia/institución destino<small class="text-red">*</small></label>
                <select class="form-control" id="dides" name="dides">
                    
                </select>
            </div>
            <div class="col-sm-4 dint">
                <label for="pides">Destinatario<small class="text-red">*</small></label>
                <select class="form-control" id="pides" name="pides">
                    
                </select>
            </div>
            <div class="col-sm-6 dext">
                <label for="dedes">Dependencia/institución destino<small class="text-red">*</small></label>
                <input type="text" class="form-control" id="dedes" name="dedes" placeholder="Dependencia/institución destino">
            </div>
            <div class="col-sm-4 dext">
                <label for="pedes">Destinatario<small class="text-red">*</small></label>
                <input type="text" class="form-control" id="pedes" name="pedes" placeholder="Destinatario">
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
                        break;
                    case "e":
                        $(".rext").show();
                        $(".rint").hide();
                        break;
                }
            };
            function odes(v){
                switch (v) {
                    case "i":
                        $(".dext").hide();
                        $(".dint").show();
                        break;
                    case "e":
                        $(".dext").show();
                        $(".dint").hide();
                        break;
                }
            };
            orem("i");
            odes("i");
            $('#d_fecdoc').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true,
                minViewMode: 0,
                maxViewMode: 2,
                todayHighlight: true
            });
            $("#tipdoc").select2();
        </script>  
<?php
		}//acafin
	}else{
		echo mensajewa("Error: Faltan datos.");
	}
}else{
  echo accrestringidoa();
}
mysqli_close($cone);

?>