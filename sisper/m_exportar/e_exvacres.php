<?php
session_start();
include ("../m_inclusiones/php/conexion_sp.php");
include ("../m_inclusiones/php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],3)){
  if (isset($_GET['doc']) && !empty($_GET['doc'])) {
    $doc=iseguro($cone,$_GET['doc']);

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
                    <th colspan="10"><font face="arial" color="#FF5C26" size="3">PROGRAMACIÓN DE VACACIONES</font></th>
              </tr>

<?php
              $cper=mysqli_query($cone,"SELECT e.idEmpleado, ec.FechaVac, pv.FechaIni, pv.FechaFin  FROM  provacaciones pv INNER JOIN aprvacaciones apv ON pv.idProVacaciones=apv.idProVacaciones INNER JOIN empleadocargo ec ON ec.idEmpleadoCargo=pv.idEmpleadoCargo INNER JOIN empleado e ON ec.idEmpleado=e.idEmpleado WHERE apv.idDoc=$doc ORDER BY e.ApellidoPat, e.ApellidoMat, e.Nombres, pv.FechaIni ASC;");
              if(mysqli_num_rows($cper)>0){
                $cr=mysqli_query($cone, "SELECT Numero, Ano, Siglas FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc WHERE d.idDoc=$doc;");
                if($rr=mysqli_fetch_assoc($cr)){
?>
                <tr>
                      <th colspan="10"><font face="arial" color="#777777" size="1">Resolución</font></th>
                </tr>
                <tr>
                  <th colspan="10"><font face="arial" color="#C8A2C8" size="2"><?php echo $rr['Numero']."-".$rr['Ano']."-".$rr['Siglas']; ?></font></th>
                </tr>
<?php
                }

?>

                <tr>
                  <td bgcolor= "#C8A2C8"><font color="#ffffff" size="2">N°</font></td>
                  <td bgcolor= "#C8A2C8"><font color="#ffffff" size="2">N° DNI</font></td>
                  <td bgcolor= "#C8A2C8"><font color="#ffffff" size="2">NOMBRE</font></td>
                  <td bgcolor= "#C8A2C8"><font color="#ffffff" size="2">CARGO</font></td>
                  <td bgcolor= "#C8A2C8"><font color="#ffffff" size="2">DEPENDENCIA</font></td>
                  <td bgcolor= "#C8A2C8"><font color="#ffffff" size="2">COND. LABORAL</font></td>
                  <td bgcolor= "#C8A2C8"><font color="#ffffff" size="2">F. VACACIONES</font></td>
                  <td bgcolor= "#C8A2C8"><font color="#ffffff" size="2">F. INICIO</font></td>
                  <td bgcolor= "#C8A2C8"><font color="#ffffff" size="2">F. FIN</font></td>
                  <td bgcolor= "#C8A2C8"><font color="#ffffff" size="2">DÍAS</font></td>
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
                </tr>
<?php
                }
              }else{
?>
              <tr>
                    <td colspan="10">No existen vacaciones para la resolución seleccionada.</td>
              </tr>
<?php
              }
              mysqli_free_result($cper);
?>

          </table>
<?php
    mysqli_close($cone);
  }else{
    echo "No eligió una resolución";
  }
}else{
      echo accrestringidoa();
}
?>
