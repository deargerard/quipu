<?php
session_start();
include ("../m_inclusiones/php/conexion_sp.php");
include ("../m_inclusiones/php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],15)){
  $mesini1=iseguro($cone,$_GET['mesini']);
  $mesfin1=iseguro($cone,$_GET['mesfin']);
  $estcs=explode(",",$_GET['estcs']);

  if (isset($mesini1) && !empty($mesini1) && isset($mesfin1) && !empty($mesfin1) && isset($estcs) && !empty($estcs)) {

    $mesini=fmysql("01/".$mesini1);
    $mesfin=fmysql("01/".$mesfin1);
    $mesfin=strtotime('+ 1 month',strtotime ($mesfin) );
    $mesfin=date('Y-m-j', $mesfin);
    $mesfin=strtotime('- 1 day',strtotime ($mesfin) );
    $mesfin=date('Y-m-j', $mesfin);

      $fecha = @date("d-m-Y");


      //Inicio de la instancia para la exportación en Excel
      //header('Content-type: application/vnd.ms-excel');
      header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
      header("Content-Disposition: attachment; filename=ComisionesdeServicios_$fecha.xls");
      header("Pragma: no-cache");
      header("Expires: 0");



    $wecs="(";

    for ($k=0; $k < count($estcs); $k++) {
      $wecs.= $k==(count($estcs)-1) ? " cs.Estado=".iseguro($cone,$estcs[$k]).")" : "cs.Estado=".iseguro($cone,$estcs[$k])." OR ";
    }

      $c="SELECT e.idEmpleado, e.NumeroDoc, cs.FechaIni, cs.FechaFin, concat(d.Numero,'-',d.Ano,'-',d.Siglas) AS Resolucion, cs.Descripcion, cs.Estado, cs.vehiculo, d.FechaDoc from comservicios cs INNER JOIN empleado e ON e.idEmpleado=cs.idEmpleado INNER JOIN empleadocargo ec ON e.idEmpleado=ec.idEmpleadoCargo  INNER JOIN cardependencia cd ON ec.idEmpleadoCargo=cd.idEmpleadoCargo INNER JOIN doc d ON cs.idDoc=d.idDoc where (FechaIni BETWEEN '$mesini' AND '$mesfin') AND $wecs;";

      $ccs=mysqli_query($cone,$c);
?>
          <table border=1 bordercolor="#BFBFBF">
<?php
      if(mysqli_num_rows($ccs)>0){

?>
              <tr>
                    <th colspan="13"><font face="arial" color="#FF8000" size="3">REPORTE DE COMISIONES DE SERVICIO DEL <?php echo $mesini1; ?> AL <?php echo $mesfin1; ?></font></th>
              </tr>

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
                <td bgcolor= "#585858"><b><font color="#ffffff" size="2">RESOLUCIÓN</font></b></td>
                <td bgcolor= "#585858"><b><font color="#ffffff" size="2">FECHA RES.</font></b></td>
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
                <td><font color="#000000"><?php echo $rcs['Resolucion']?></font></td>
                <td><font color="#000000"><?php echo fnormal($rcs['FechaDoc']); ?></font></td>
                <td><font color="#000000"><?php echo $rcs['vehiculo']==1 ? "SÍ" : "NO";?></font></td>
                <td><font color="#000000"><?php echo $rcs['Estado']==1 ? "ACTIVA" : "CANCELADA";?></font></td>
              </tr>
<?php
                }
      }else{
?>
              <tr>
                    <td>No se encontraron resultados. <?php echo $c; ?></td>
              </tr>
<?php
      }
      mysqli_free_result($ccs);
?>

          </table>
<?php
    }else{
      echo "No envio los datos completos.";
    }
    mysqli_close($cone);
}else{
      echo accrestringidoa();
}
?>
