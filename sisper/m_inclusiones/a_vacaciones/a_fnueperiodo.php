<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],3)){
?>
          <div class="form-group valida">
            <label for="atrab" class="col-sm-6 control-label" >Año de trabajo</label>
            <div class="col-sm-6">
              <input name="atrab" id="atrab" class="col-sm-12 form-control" placeholder="aaaa">
            </div>
          </div>
<?php
}else{
  echo accrestringidoa();
}
?>
<script>
$("#atrab").datepicker({
  //autoclose: true,
  format: " yyyy",
  minViewMode: "years",
  maxViewMode: "years",
  startDate: '2010',
  endDate: new Date(),
  startView: "year" //does not work
});
</script>
