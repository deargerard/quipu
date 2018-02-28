<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],2)){
  if(isset($_POST['per']) && !empty($_POST['per']) && isset($_POST['mes']) && !empty($_POST['mes']) && isset($_POST['ano']) && !empty($_POST['ano'])){
    $per=iseguro($cone,$_POST['per']);
    $mes=iseguro($cone,$_POST['mes']);
    $ano=iseguro($cone,$_POST['ano']);
    $dni=$_SESSION['docide'];
    $cv=mysqli_query($cone, "SELECT idVigilante FROM vigilante WHERE DNI='$dni';");
    if($rv=mysqli_fetch_assoc($cv)){
      $idv=$rv['idVigilante'];
      $ndias=cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
      $pd=$ano."-".$mes."-01";
      $ud=$ano."-".$mes."-".$ndias;

?>
        <div class="form-group valida">
          <label for="marc" class="col-sm-3 control-label">Fecha y hora</label>
          <input type="hidden" name="vig" value="<?php echo $idv; ?>">
          <input type="hidden" name="per" value="<?php echo $per; ?>">
          <div class="col-sm-9 has-feedback">
            <span class="fa fa-calendar form-control-feedback"></span>
            <input type="text" name="marc" id="marc" class="form-control" placeholder="Fecha y hora">
          </div>
        </div>
        <div id="d_amarcacion"></div>
        <script>
          var min=new Date(<?php echo "'".$pd." 00:00:00'"; ?>);
          var max=new Date(<?php echo "'".$ud." 23:59:59'"; ?>);
          $('#marc').datetimepicker({
              locale: 'es',
              format: 'DD/MM/YYYY HH:mm:ss',
              useCurrent: false,
              defaultDate: min,
              minDate: min,
              maxDate: max
          });
        </script>

<?php
    }else{
      echo mensajewa("No cuenta con permisos para agregar marcaciones.");
    }
    mysqli_free_result($cv);
  }else{
    echo mensajewa("No envió datos.");
  }
}else{
  echo accrestringidoa();
}
?>