<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],2)){
  if(isset($_POST['mes']) && !empty($_POST['mes']) && isset($_POST['ano']) && !empty($_POST['ano']) && isset($_POST['emp']) && !empty($_POST['emp'])){
    $mes=iseguro($cone,$_POST['mes']);
    $ano=iseguro($cone,$_POST['ano']);
    $emp=iseguro($cone,$_POST['emp']);
    $ndias = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
    $enc=encriptar(docidentidad($cone,$emp));
    $des=desencriptar($enc);
?>
<h5><?php echo 'Encriptado: '.$enc.', '.'desencriptado: '.$des; ?></h5>
<h4 class="text-center text-maroon"><?php echo nomempleado($cone,$emp); ?></h4>
<h5 class="text-center text-info"><?php echo strtoupper(nombremes($mes)).' - '.$ano; ?></h5>
<table class="table table-bordered">
  <thead>
    <tr>
      <th>FECHA</th>
      <th>DÍA</th>
      <th>ING. TURNO</th>
      <th>SAL. REFRIGERIO</th>
      <th>ING. REFRIGERIO</th>
      <th>SAL. TURNO</th>
      <th>Incidencias</th>
    </tr>
  </thead>
  <tbody>
<?php
    for ($i = 1; $i <= $ndias; $i++) {
      $fec=$ano.'-'.$mes.'-'.$i;
      $dia=nombredia($fec);
      $ct1=mysqli_query($cone,"SELECT * FROM marcacion WHERE idTipMarcacion=1 AND Fecha='$fec' AND idEmpleado=$emp");
      if($rt1=mysqli_fetch_assoc($ct1)){
        $h1=$rt1['Hora'];
      }else{
        $h1="";
      }
      $ct2=mysqli_query($cone,"SELECT * FROM marcacion WHERE idTipMarcacion=3 AND Fecha='$fec' AND idEmpleado=$emp");
      if($rt2=mysqli_fetch_assoc($ct2)){
        $h2=$rt2['Hora'];
      }else{
        $h2="";
      }
      $ct3=mysqli_query($cone,"SELECT * FROM marcacion WHERE idTipMarcacion=4 AND Fecha='$fec' AND idEmpleado=$emp");
      if($rt3=mysqli_fetch_assoc($ct3)){
        $h3=$rt3['Hora'];
      }else{
        $h3="";
      }
      $ct4=mysqli_query($cone,"SELECT * FROM marcacion WHERE idTipMarcacion=2 AND Fecha='$fec' AND idEmpleado=$emp");
      if($rt4=mysqli_fetch_assoc($ct4)){
        $h4=$rt4['Hora'];
      }else{
        $h4="";
      } 
?>
<tr>
  <td><?php echo $i; ?></td>
  <td><?php echo $dia; ?></td>
  <td><?php echo $h1; ?></td>
  <td><?php echo $h2; ?></td>
  <td><?php echo $h3; ?></td>
  <td><?php echo $h4; ?></td>
  <td></td>
</tr>
<?PHP
    }
?>
  </tbody>
</table>
<?php
  }else{
    echo mensajeda("Error: No se enviaron los datos.");
  }
}else{
  echo accrestringidoa();
}
                  ?>