<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],2)){
  if(isset($_POST['idm']) && !empty($_POST['idm']) && isset($_POST['mes']) && !empty($_POST['mes']) && isset($_POST['ano']) && !empty($_POST['ano'])){
    $idm=iseguro($cone,$_POST['idm']);
    $mes=iseguro($cone,$_POST['mes']);
    $ano=iseguro($cone,$_POST['ano']);
    $dni=$_SESSION['docide'];
    $cv=mysqli_query($cone, "SELECT idVigilante FROM vigilante WHERE DNI='$dni';");
    if($rv=mysqli_fetch_assoc($cv)){
      $idv=$rv['idVigilante'];
      $ndias=cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
      $pd=$ano."-".$mes."-01";
      $ud=$ano."-".$mes."-".$ndias;
      $cm=mysqli_query($cone, "SELECT * FROM marcacion WHERE idMarcacion=$idm;");
      if($rm=mysqli_fetch_assoc($cm)){

?>
        <div class="form-group valida">
          <label for="marce" class="col-sm-3 control-label">Fecha y hora</label>
          <input type="hidden" name="idm" value="<?php echo $idm; ?>">
          <input type="hidden" name="vig" value="<?php echo $idv; ?>">
          <div class="col-sm-9 has-feedback">
            <span class="fa fa-calendar form-control-feedback"></span>
            <input type="text" name="marce" id="marce" class="form-control" placeholder="Fecha y hora" value="<?php echo ftnormal($rm['Marcacion']); ?>">
          </div>
        </div>
        <div id="d_emarcacion"></div>
        <script>
          var min=new Date(<?php echo "'".$pd." 00:00:00'"; ?>);
          var max=new Date(<?php echo "'".$ud." 23:59:59'"; ?>);
          $('#marce').datetimepicker({
              locale: 'es',
              format: 'DD/MM/YYYY HH:mm:ss',
              useCurrent: false,
              minDate: min,
              maxDate: max
          });
        </script>

<?php
      }else{
        echo mensajewa("Los datos enviados, no son válidos.");
      }
    }else{
      echo mensajewa("No cuenta con permisos para editar las marcaciones.");
    }
    mysqli_free_result($cv);
  }else{
    echo mensajewa("No envió datos.");
  }
}else{
  echo accrestringidoa();
}
?>