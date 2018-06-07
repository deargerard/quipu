<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1)){
  if(isset($_POST["idec"]) && !empty($_POST["idec"]) && isset($_POST["acc"]) && !empty($_POST["acc"])){
    $idec=iseguro($cone,$_POST["idec"]);
    $acc=iseguro($cone,$_POST["acc"]);
    if($acc=="edidat"){
      $c=mysqli_query($cone,"SELECT * FROM estadocargo WHERE idEstadoCargo=$idec");
      if($r=mysqli_fetch_assoc($c)){
  ?>
                  <div class="form-group <?php echo $r['idEstadoCar']==2 ? "" : "hidden"; ?>">
                    <label for="ven" class="col-sm-3 control-label">Vence</label>
                    <div class="col-sm-6 valida">
                      <input type="hidden" name="acc" value="<?php echo $acc; ?>">
                      <input type="hidden" name="idec" value="<?php echo $idec; ?>">
                      <input type="text" id="ven" name="ven" class="form-control" placeholder="dd/mm/aaaa" value="<?php echo fnormal($r['Vence']); ?>" autocomplete="off">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="numres" class="col-sm-3 control-label">N° Documento</label>
                    <div class="col-sm-6 valida">
                      <input type="text" id="numres" name="numres" class="form-control" placeholder="N° Documento" value="<?php echo $r['NumResolucion']; ?>" <?php echo $r['Motivo']=="ESTADO INICIAL" ? "readonly" : ""; ?>>
                    </div>
                    <div class="col-sm-3">
                      <?php if ($r['Motivo']=="ESTADO INICIAL") { ?>
                      <i class="fa fa-exclamation-circle text-orange"></i> <small>Editable al editar cargo</small>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="mot" class="col-sm-3 control-label">Motivo</label>
                    <div class="col-sm-9 valida">
                      <input type="text" id="mot" name="mot" class="form-control" placeholder="Motivo" value="<?php echo $r['Motivo']; ?>" <?php echo $r['Motivo']=="ESTADO INICIAL" ? "readonly" : ""; ?>>
                    </div>
                  </div>
                  <div id="r_eecargo" class="text-center">
                    
                  </div>
                  <script>
                    $('#ven').datepicker({
                      format: "dd/mm/yyyy",
                      language: "es",
                      autoclose: true,
                      todayHighlight: true
                    });
                  </script>
  <?php
      }else{
        echo mensajewa("Error: No envio datos válidos.");
      }
      mysqli_free_result($c);
    }elseif($acc=="edifin"){
      $c=mysqli_query($cone,"SELECT * FROM estadocargo WHERE idEstadoCargo=$idec");
      if($r=mysqli_fetch_assoc($c)){
  ?>
                  <div class="form-group">
                    <label for="fini" class="col-sm-3 control-label">Fecha Inicio</label>
                    <div class="col-sm-6 valida">
                      <input type="hidden" name="acc" value="<?php echo $acc; ?>">
                      <input type="hidden" name="idec" value="<?php echo $idec; ?>">
                      <input type="hidden" name="idemca" value="<?php echo $r['idEmpleadoCargo']; ?>">
                      <input type="hidden" name="finise" value="<?php echo fnormal($r['FechaIni']); ?>">
                      <input type="text" id="fini" name="fini" class="form-control" placeholder="dd/mm/aaaa" value="<?php echo fnormal($r['FechaIni']); ?>" autocomplete="off">
                    </div>
                  </div>
                  <div id="r_eecargo" class="text-center">
                    
                  </div>
                  <script>
                    $('#fini').datepicker({
                      format: "dd/mm/yyyy",
                      language: "es",
                      autoclose: true,
                      todayHighlight: true,
                      endDate: "<?php echo fnormal($r['FechaFin']); ?>"
                    });
                  </script>
  <?php
      }else{
        echo mensajewa("Error: No envio datos válidos.");
      }
      mysqli_free_result($c);
    }elseif($acc=="ediffi"){
      $c=mysqli_query($cone,"SELECT * FROM estadocargo WHERE idEstadoCargo=$idec");
      if($r=mysqli_fetch_assoc($c)){
  ?>
                  <div class="form-group">
                    <label for="ffin" class="col-sm-3 control-label">Fecha Fin</label>
                    <div class="col-sm-6 valida">
                      <input type="hidden" name="acc" value="<?php echo $acc; ?>">
                      <input type="hidden" name="idec" value="<?php echo $idec; ?>">
                      <input type="hidden" name="idemca" value="<?php echo $r['idEmpleadoCargo']; ?>">
                      <input type="hidden" name="ffinse" value="<?php echo fnormal($r['FechaFin']); ?>">
                      <input type="text" id="ffin" name="ffin" class="form-control" placeholder="dd/mm/aaaa" value="<?php echo fnormal($r['FechaFin']); ?>" autocomplete="off">
                    </div>
                  </div>
                  <div id="r_eecargo" class="text-center">
                    
                  </div>
                  <script>
                    $('#ffin').datepicker({
                      format: "dd/mm/yyyy",
                      language: "es",
                      autoclose: true,
                      todayHighlight: true,
                      startDate: "<?php echo fnormal($r['FechaIni']); ?>"
                    });
                  </script>
  <?php
      }else{
        echo mensajewa("Error: No envio datos válidos.");
      }
      mysqli_free_result($c);
    }
  }else{
    echo mensajewa("Error: No envio datos.");
  }
}else{
  echo accrestringidoa();
}
?>