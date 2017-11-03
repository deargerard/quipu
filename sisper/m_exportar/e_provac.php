<?php
session_start();
include ("../m_inclusiones/php/conexion_sp.php");
include ("../m_inclusiones/php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],3)){
      $fecha = @date("d-m-Y");


      //Inicio de la instancia para la exportación en Excel
      //header('Content-type: application/vnd.ms-excel');
      header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
      header("Content-Disposition: attachment; filename=ProgramacionVacaciones_$fecha.xls");
      header("Pragma: no-cache");
      header("Expires: 0");

?>
          <table border=1>
              <tr>
                    <th colspan="11"><font face="arial" color="#FF5C26" size="3">PROGRAMACIÓN DE VACACIONES (SOLICITADAS Y ACEPTADAS)</font></th>
              </tr>
              <tr>
                    <td colspan="11"></td>
              </tr>
<?php
              $cper=mysqli_query($cone,"SELECT ec.idEmpleado, ec.FechaVac, pv.FechaIni, pv.FechaFin, pv.Estado FROM empleadocargo ec INNER JOIN provacaciones pv ON ec.idEmpleadoCargo=pv.idEmpleadoCargo WHERE pv.Estado=7 OR pv.Estado=6;");
              if(mysqli_num_rows($cper)>0){
?>
                <tr bgcolor= "#777777">
                  <td><font color="#ffffff" size="2">N°</font></td>
                  <td><font color="#ffffff" size="2">N° DNI</font></td>
                  <td><font color="#ffffff" size="2">NOMBRE</font></td>
                  <td><font color="#ffffff" size="2">CARGO</font></td>
                  <td><font color="#ffffff" size="2">DEPENDENCIA</font></td>
                  <td><font color="#ffffff" size="2">COND. LABORAL</font></td>
                  <td><font color="#ffffff" size="2">F. VACACIONES</font></td>
                  <td><font color="#ffffff" size="2">F. INICIO</font></td>
                  <td><font color="#ffffff" size="2">F. FIN</font></td>
                  <td><font color="#ffffff" size="2">DÍAS</font></td>
                  <td><font color="#ffffff" size="2">ESTADO</font></td>
                </tr>
<?php
                $a=0;
                while($rper=mysqli_fetch_assoc($cper)){
                  $a++;
                  $ide=$rper['idEmpleado'];
?>
                <tr>
                  <td><font color="#555555"><?php echo $a; ?></font></td>
                  <td><font color="#555555"><?php echo docidentidad($cone,$ide); ?></font></td>
                  <td><font color="#000000"><?php echo nomempleado($cone,$ide); ?></font></td>
                  <td><font color="#000000"><?php echo cargoe($cone,$ide); ?></font></td>
                  <td><font color="#555555"><?php echo dependenciae($cone,$ide); ?></font></td>
                  <td><font color="#555555"><?php echo condicionlabe($cone,$ide); ?></font></td>
                  <td><font color="#555555"><?php echo fnormal($rper['FechaVac']); ?></font></td>
                  <td><font color="#555555"><?php echo fnormal($rper['FechaIni']); ?></font></td>
                  <td><font color="#555555"><?php echo fnormal($rper['FechaFin']); ?></font></td>
                  <td><font color="#555555"><?php echo intervalo($rper['FechaFin'],$rper['FechaIni']); ?></font></td>
                  <td><font color="#555555"><?php echo $rper['Estado']==6 ? "Solicitada" : "Aceptada"; ?></font></td>
                </tr>
<?php
                }
              }else{
?>
              <tr>
                    <td colspan="11">NO EXISTEN VACACIONES SOLICITADAS NI ACEPTADAS</td>
              </tr>
<?php
              }
              mysqli_free_result($cper);
?>
         
          </table>
<?php
}else{
      echo accrestringidoa();
}
?>