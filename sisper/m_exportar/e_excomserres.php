<?php
session_start();
include ("../m_inclusiones/php/conexion_sp.php");
include ("../m_inclusiones/php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],15)){
  if (isset($_GET['doc']) && !empty($_GET['doc'])) {
    $doc=iseguro($cone,$_GET['doc']);

      $fecha = @date("d-m-Y");


      //Inicio de la instancia para la exportación en Excel
      //header('Content-type: application/vnd.ms-excel');
      header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
      header("Content-Disposition: attachment; filename=ComisionesdeServicio_$fecha.xls");
      header("Pragma: no-cache");
      header("Expires: 0");

?>
          <table border=1>
              <tr>
                    <th colspan="11"><font face="arial" color="#FF5C26" size="3">COMISIONES DE SERVICIO</font></th>
              </tr>

<?php
              $ccs=mysqli_query($cone,"SELECT e.idEmpleado, e.NumeroDoc, cs.FechaIni, cs.FechaFin, cs.Descripcion, cs.Estado, cs.Vehiculo from comservicios cs INNER JOIN empleado e ON e.idEmpleado=cs.idEmpleado INNER JOIN empleadocargo ec ON e.idEmpleado=ec.idEmpleadoCargo  INNER JOIN cardependencia cd ON ec.idEmpleadoCargo=cd.idEmpleadoCargo INNER JOIN doc d ON cs.idDoc=d.idDoc where cs.idDoc=$doc;");
              if(mysqli_num_rows($ccs)>0){
                $cr=mysqli_query($cone, "SELECT Numero, Ano, Siglas FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc WHERE d.idDoc=$doc;");
                if($rr=mysqli_fetch_assoc($cr)){
?>
                <tr>
                      <th colspan="11"><font face="arial" color="#000000" size="1">Resolución</font></th>
                </tr>
                <tr>
                  <th colspan="11"><font face="arial" color="#000000" size="2"><?php echo $rr['Numero']."-".$rr['Ano']."-".$rr['Siglas']; ?></font></th>
                </tr>
<?php
                }

?>

                <tr>
                  <td bgcolor= "#585858"><b><font color="#ffffff" size="2">N°</font></b></td>
                  <td bgcolor= "#585858"><b><font color="#ffffff" size="2">DNI</font></b></td>
                  <td bgcolor= "#585858"><b><font color="#ffffff" size="2">NOMBRE</font></b></td>
                  <td bgcolor= "#585858"><b><font color="#ffffff" size="2">CARGO</font></b></td>
                  <td bgcolor= "#585858"><b><font color="#ffffff" size="2">DEPENDENCIA</font></b></td>
                  <td bgcolor= "#585858"><b><font color="#ffffff" size="2">COND. LABORAL</font></b></td>
                  <td bgcolor= "#585858"><b><font color="#ffffff" size="2">DESCRIPCIÓN DE LA COMISIÓN</font></b></td>
                  <td bgcolor= "#585858"><b><font color="#ffffff" size="2">F. INICIO</font></b></td>
                  <td bgcolor= "#585858"><b><font color="#ffffff" size="2">F. FIN</font></b></td>
                  <td bgcolor= "#585858"><b><font color="#ffffff" size="2">VEHÍCULO</font></b></td>
                  <td bgcolor= "#585858"><b><font color="#ffffff" size="2">ESTADO</font></b></td>
                </tr>
<?php
                $a=0;
                while($rcs=mysqli_fetch_assoc($ccs)){
                  $a++;
                  $ide=$rcs['idEmpleado'];
?>
                <tr>
                  <td><font color="#000000"><?php echo $a; ?></font></td>
                  <td><font color="#000000"><?php echo docidentidad($cone,$ide); ?></font></td>
                  <td><font color="#000000"><?php echo nomempleado($cone,$ide); ?></font></td>
                  <td><font color="#000000"><?php echo cargoe($cone,$ide); ?></font></td>
                  <td><font color="#000000"><?php echo dependenciae($cone,$ide); ?></font></td>
                  <td><font color="#000000"><?php echo condicionlabe($cone,$ide); ?></font></td>
                  <td><font color="#000000"><?php echo $rcs['Descripcion']; ?></font></td>
                  <td><font color="#000000"><?php echo date('d/m/Y H:i', strtotime($rcs['FechaIni'])); ?></font></td>
                  <td><font color="#000000"><?php echo date('d/m/Y H:i', strtotime($rcs['FechaFin'])); ?></font></td>
                  <td><font color="#000000"><?php echo $rcs['vehiculo']==1 ? "SÍ" : "NO";?></font></td>
                  <td><font color="#000000"><?php echo $rcs['Estado']==1 ? "ACTIVA" : "CANCELADA";?></font></td>
                </tr>
<?php
                }
              }else{
?>
              <tr>
                    <td colspan="11">No existen comsiones de servicio para la resolución seleccionada.</td>
              </tr>
<?php
              }
              mysqli_free_result($ccs);
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
