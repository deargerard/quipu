<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){
  if(isset($_POST["idp"]) && !empty($_POST["idp"]) && isset($_POST["acc"]) && !empty($_POST["acc"])){
    $idp=iseguro($cone,$_POST["idp"]);
    $acc=iseguro($cone,$_POST["acc"]);

   if($acc=='agrdis'){
    $re='n';
    $cca=mysqli_query($cone,"SELECT * FROM discapacidad WHERE idEmpleado=$idp");
    if($rca=mysqli_fetch_assoc($cca)){
      $re='e';
    }

  ?>

      <div class="form-group">        
        <div class="col-sm-6">
          <label for="tdis" class="control-label">Tipo de discapacidad <small class="text-red">*</small></label>
          <input type="hidden" name="acc" value="<?php echo $acc; ?>">
          <input type="hidden" name="idp" value="<?php echo $idp; ?>">
          <input type="hidden" name="re" value="<?php echo $re; ?>"> 
          <select class="form-control" name="tdis" id="tdis" style="width: 100%;">       
<?php
            $c1=mysqli_query($cone, "SELECT * FROM tipdiscapacidad WHERE estado=1;");
              if(mysqli_num_rows($c1)>0){
                while($r1=mysqli_fetch_assoc($c1)){
?>
                <option value="<?php echo $r1['idtipdiscapacidad']; ?>" <?php echo $r1['idtipdiscapacidad']==$rca['idtipdiscapacidad'] ? "selected" : ""; ?>><?php echo $r1['tipod'];?></option>
<?php
                }
              }
              mysqli_free_result($c1);
?>        
          </select>
        </div>
        
        <div class="col-sm-6">
          <label for="dmed" class="control-label ocu">Diagnóstico Médico</label>   
          <input type="text" name="dmed" id="dmed" class="form-control" placeholder="Diagnóstico Médico" value="<?php echo $rca['diamedico']; ?>">                 
        </div>

        <div class="col-sm-6">
          <label for="tayu" class="control-label">Tipo de ayuda biomecánica <small class="text-red">*</small></label>      
          <select class="form-control select2doc" name="tayu" id="tayu" style="width: 100%;" onchange="otro(this.value);">       
<?php
            $c2=mysqli_query($cone, "SELECT * FROM tipayubio WHERE estado=1;");
              if(mysqli_num_rows($c2)>0){
                while($r2=mysqli_fetch_assoc($c2)){
?>
                <option value="<?php echo $r2['idtipayubio']; ?>" <?php echo $r2['idtipayubio']==$rca['idtipayubio'] ? "selected" : ""; ?>><?php echo $r2['tipoa'];?></option>
<?php
                }
              }
              mysqli_free_result($c2);
?>        
          </select>
        </div>
        <div class="col-sm-6" id="ot">
          <label for="otr" class="control-label">Otro</label>
          <input type="text" name="otr" id="otr" class="form-control" placeholder="Otro" value="<?php echo $rca['otipayubio']; ?>">
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-6">
          <label for="tseg" class="control-label">Tipo de seguro <small class="text-red">*</small></label>      
          <select class="form-control" name="tseg" id="tseg" style="width: 100%;">       
<?php
            $c3=mysqli_query($cone, "SELECT * FROM tipseg WHERE estado=1 ORDER BY tipos ASC;");
              if(mysqli_num_rows($c3)>0){
                while($r3=mysqli_fetch_assoc($c3)){
?>
                <option value="<?php echo $r3['idtipseg']; ?>" <?php echo $r3['idtipseg']==$rca['idtipseg'] ? "selected" : ""; ?>><?php echo $r3['tipos'];?></option>
<?php
                }
              }
              mysqli_free_result($c3);
?>        
          </select>
        </div>

        <div class="col-sm-6">
          <label for="tlim" class="control-label">Limitaciones permanentes para <small class="text-red">*</small></label>      
          <select class="form-control" name="tlim" id="tlim" style="width: 100%;">       
<?php
            $c4=mysqli_query($cone, "SELECT * FROM tiplimper WHERE estado=1 ORDER BY tipol ASC;");
              if(mysqli_num_rows($c4)>0){
                while($r4=mysqli_fetch_assoc($c4)){
?>
                <option value="<?php echo $r4['idtiplimper']; ?>" <?php echo $r4['idtiplimper']==$rca['idtiplimper'] ? "selected" : ""; ?>><?php echo $r4['tipol'];?></option>
<?php
                }
              }
              mysqli_free_result($c4);
?>        
          </select>
        </div>
        <div class="col-sm-6">
          <label for="glim" class="control-label">Grado de la limitación <small class="text-red">*</small></label>      
          <select class="form-control" name="glim" id="glim" style="width: 100%;">       
<?php
            $c5=mysqli_query($cone, "SELECT * FROM gralim WHERE estado=1;");
              if(mysqli_num_rows($c5)>0){
                while($r5=mysqli_fetch_assoc($c5)){
?>
                <option value="<?php echo $r5['idgralim']; ?>" <?php echo $r5['idgralim']==$rca['idgralim'] ? "selected" : ""; ?>><?php echo $r5['gradol'];?></option>
<?php
                }
              }
              mysqli_free_result($c5);
?>        
          </select>
        </div>
        <div class="col-sm-6">
          <label for="olim" class="control-label">Origen de la limitación <small class="text-red">*</small></label>      
          <select class="form-control" name="olim" id="olim" style="width: 100%;">       
<?php
            $c6=mysqli_query($cone, "SELECT * FROM orilim WHERE estado=1 ORDER BY origenl ASC;");
              if(mysqli_num_rows($c6)>0){
                while($r6=mysqli_fetch_assoc($c6)){
?>
                <option value="<?php echo $r6['idorilim']; ?>" <?php echo $r6['idorilim']==$rca['idorilim'] ? "selected" : ""; ?>><?php echo $r6['origenl'];?></option>
<?php
                }
              }
              mysqli_free_result($c6);
?>        
          </select>
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-6">
          <label for="cdis" class="control-label">Certificado de discapacidad <small class="text-red">*</small></label>      
          <select class="form-control" name="cdis" id="cdis" onchange="fcdis(this.value);" style="width: 100%;">       
            <option value="1" <?php echo $rca['cerdis']==1 ? "selected" : ""; ?>>Si</option>
            <option value="2" <?php echo $rca['cerdis']==2 ? "selected" : ""; ?>>No</option>
            <option value="3" <?php echo $rca['cerdis']==3 ? "selected" : ""; ?>>En trámite</option>    
          </select>
        </div>
        <div class="col-sm-6" id="ocd">
            <label for="fcer">Fecha cert. discapacidad</label>
            <div class="has-feedback">
              <input type="text" class="form-control" id="fcer" name="fcer" placeholder="dd/mm/aaaa" value="<?php echo fnormal($rca['feccerdis']); ?>">
              <span class="fa fa-calendar form-control-feedback"></span>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-6">
          <label for="icon" class="control-label">Inscripción CONADIS <small class="text-red">*</small></label>      
          <select class="form-control" name="icon" id="icon" onchange="ficon(this.value);" style="width: 100%;">       
            <option value="1" <?php echo $rca['conadis']==1 ? "selected" : ""; ?>>Si</option>
            <option value="2" <?php echo $rca['conadis']==2 ? "selected" : ""; ?>>No</option>
            <option value="3" <?php echo $rca['conadis']==3 ? "selected" : ""; ?>>En trámite</option>    
          </select>
        </div>
        <div class="col-sm-6" id="oic">
            <label for="fins">Fecha insc. CONADIS</label>
            <div class="has-feedback">
              <input type="text" class="form-control" id="fins" name="fins" placeholder="dd/mm/aaaa" value="<?php echo fnormal($rca['fecconadis']); ?>">
              <span class="fa fa-calendar form-control-feedback"></span>
            </div>
        </div>
      </div>
      <div class="form-group" id="d_frespuesta">
          
      </div>


<script>
  $('#fcer, #fins').datepicker({
    format: "dd/mm/yyyy",
    language: "es",
    autoclose: true,
    todayHighlight: true,
    maxViewMode: 2,
  });
<?php if($rca['idtipayubio']!=6){ ?>
  $('#ot').hide();
<?php } ?>
  function otro(o){
    if(o==6){
      $('#ot').show();
    }else{
      $('#ot').hide();
      $('#otr').val("");
    }
  };

  function ficon(o){
    if(o==1){
      $('#oic').show();
    }else{
      $('#oic').hide();
      $('#fins').val("");
    }
  };

  function fcdis(o){
    if(o==1){
      $('#ocd').show();
    }else{
      $('#ocd').hide();
      $('#fcer').val("");
    }
  };


</script>
  <?php
    mysqli_free_result($cca);
   }elseif($acc=='elidis'){
?>
      <div class="form-group">
          <input type="hidden" name="acc" value="<?php echo $acc; ?>">
          <input type="hidden" name="idp" value="<?php echo $idp; ?>">
          <h4 class="text-center"><i class="fa fa-info-circle text-orange"></i> ¿Seguro que desea eliminar la discapacidad?</h4>
      </div>
      <div class="form-group" id="d_frespuesta">
          
      </div>
<?php
   }
  }else{
    echo "<h4 class='text-maroon'>Error: No se envio datos</h4>";
  }
}else{
  echo accrestringidoa();
}
mysqli_close($cone);
?>