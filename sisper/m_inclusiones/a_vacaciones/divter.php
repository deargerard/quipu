<?php
include ("../php/funciones.php");
include ("../php/conexion_sp.php");
$fin=iseguro($cone,$_POST['fin']);
$fini=fmysql(iseguro($cone,$_POST['ini']));
$fini=date($fini);
$fini=strtotime('+1 day',strtotime($fini));
$fini=date('j-m-Y', $fini);
?>
<label for="finvac" class="col-sm-3 control-label">Termina</label><div class="col-sm-8"><input type="text" id="finvac" name="finvac" class="form-control" placeholder="dd/mm/aaaa">
</div>

<script>
$('#finvac').datepicker({
  format: "dd/mm/yyyy",
  lianguage: "es",
  autoclose: true,
  todayHighlight: true,
  startDate: '<?php echo $fini ?>',
  endDate: "<?php echo $fin ?>"

})
.on('hide', function(e){
 var fecha1= $("#inivac").val();
 var fecha2= $("#finvac").val();
 if (fecha1!="" && fecha2!="") {
 var dia1= fecha1.substr(0,2);
 var mes1= fecha1.substr(3,2);
 var anyo1= fecha1.substr(6);

 var dia2= fecha2.substr(0,2);
 var mes2= fecha2.substr(3,2);
 var anyo2= fecha2.substr(6);

 var nuevafecha1= new Date(anyo1+","+mes1+","+dia1);
 var nuevafecha2= new Date(anyo2+","+mes2+","+dia2);

 var Dif= nuevafecha2.getTime() - nuevafecha1.getTime();
 var dias= Math.floor(Dif/(1000*24*60*60))+1;
 var df=$("#df").val();
  if (dias>df) {
    $("#msg").html("Solo tiene "+df+" días pendientes y ha escogido un período de "+dias);
    $("#finvac").val("");
  }else{
    $("#msg").html("<span class='text-success'>Usted esta programando "+dias+" días de vacaciones.</span>");
  }
}else{
  $("#msg").html("");
}
});
</script>
