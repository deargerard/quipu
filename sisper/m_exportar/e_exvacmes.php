<?php
session_start();
include ("../m_inclusiones/php/conexion_sp.php");
include ("../m_inclusiones/php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],3)){
  $mesini1=iseguro($cone,$_GET['mesini']);
  $mesfin1=iseguro($cone,$_GET['mesfin']);
  $sislab=explode(",",$_GET['sislab']);
  $reglab=explode(",",$_GET['reglab']);
  $pervac=explode(",",$_GET['pervac']);
  $estvac=explode(",",$_GET['estvac']);


  if (isset($mesini1) && !empty($mesini1) && isset($mesfin1) && !empty($mesfin1) && isset($sislab) && !empty($sislab) && isset($reglab) && !empty($reglab) && isset($pervac) && !empty($pervac) && isset($estvac) && !empty($estvac)) {

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
      header("Content-Disposition: attachment; filename=ProgramacionVacaciones_$fecha.xls");
      header("Pragma: no-cache");
      header("Expires: 0");


    $wpv="(";
    $wrl="(";
    $wsl="(";
    $wev="(";

    for ($j=0; $j < count($pervac); $j++) {
      $wpv.=$j==(count($pervac)-1) ? " pv.idPeriodoVacacional=".iseguro($cone, $pervac[$j]).")" : "pv.idPeriodoVacacional=".iseguro($cone,$pervac[$j])." OR ";
    }

    for ($i=0; $i < count($reglab); $i++) {
      $wrl.= $i==(count($reglab)-1) ? " ec.idCondicionLab=".iseguro($cone,$reglab[$i]).")" : "ec.idCondicionLab=".iseguro($cone,$reglab[$i])." OR ";
    }

    for ($l=0; $l < count($sislab); $l++) {
      $wsl.=$l==(count($sislab)-1) ? " sl.idSistemaLab=".iseguro($cone,$sislab[$l]).")" : "sl.idSistemaLab=".iseguro($cone,$sislab[$l])." OR ";
    }

    for ($k=0; $k < count($estvac); $k++) {
      $wev.= $k==(count($estvac)-1) ? " pv.Estado=".iseguro($cone,$estvac[$k]).")" : "pv.Estado=".iseguro($cone,$estvac[$k])." OR ";
    }


      $c="SELECT ec.idEmpleado, ec.FechaVac, ec.idEmpleadoCargo, pva.idPeriodoVacacional, pva.PeriodoVacacional, pv.FechaIni, pv.FechaFin, do.Numero, do.Ano, do.Siglas FROM provacaciones pv INNER JOIN empleadocargo ec ON pv.idEmpleadoCargo=ec.idEmpleadoCargo INNER JOIN empleado e ON ec.idEmpleado=e.idEmpleado INNER JOIN condicionlab cl ON ec.idCondicionLab=cl.idCondicionLab INNER JOIN cargo c ON ec.idCargo=c.idCargo INNER JOIN cardependencia cd ON ec.idEmpleadoCargo=cd.idEmpleadoCargo INNER JOIN dependencia d ON cd.idDependencia=d.idDependencia INNER JOIN periodovacacional pva ON pv.idPeriodoVacacional=pva.idPeriodoVacacional INNER JOIN sistemalab sl ON c.idSistemaLab=sl.idSistemaLab INNER JOIN aprvacaciones ava ON pv.idProVacaciones=ava.idProVacaciones INNER JOIN doc do ON ava.idDoc=do.idDoc WHERE (FechaIni BETWEEN '$mesini' AND '$mesfin') AND ec.idEstadoCar=1 AND cd.Oficial=1 AND $wrl AND $wpv AND $wev AND $wsl ORDER BY e.ApellidoPat, e.ApellidoMat ASC;";
      //echo $c." -- ".$mesini." -- ".$mesfin;

      $cpv=mysqli_query($cone,$c);
?>
          <table border=1 bordercolor="#BFBFBF">
<?php
      if(mysqli_num_rows($cpv)>0){

?>
              <tr>
                    <th colspan="13"><font face="arial" color="#FF8000" size="3">REPORTE DEL <?php echo $mesini1; ?> al <?php echo $mesfin1; ?></font></th>
              </tr>

              <tr>
                <td bgcolor= "#AFAFAF"><b><font color="#ffffff" size="2">N°</font></b></td>
                <td bgcolor= "#AFAFAF"><b><font color="#ffffff" size="2">CÓDIGO</font></b></td>
                <td bgcolor= "#AFAFAF"><b><font color="#ffffff" size="2">APELLIDOS Y NOMBRES</font></b></td>
                <td bgcolor= "#AFAFAF"><b><font color="#ffffff" size="2">CARGO</font></b></td>
                <td bgcolor= "#AFAFAF"><b><font color="#ffffff" size="2">DEPENDENCIA</font></b></td>
                <td bgcolor= "#AFAFAF"><b><font color="#ffffff" size="2">F. INGRESO</font></b></td>
                <td bgcolor= "#AFAFAF"><b><font color="#ffffff" size="2">PERIODO</font></b></td>
                <td bgcolor= "#AFAFAF"><b><font color="#ffffff" size="2">F. INICIO</font></b></td>
                <td bgcolor= "#AFAFAF"><b><font color="#ffffff" size="2">F. FIN</font></b></td>
                <td bgcolor= "#AFAFAF"><b><font color="#ffffff" size="2">REG. LAB.</font></b></td>
                <td bgcolor= "#AFAFAF"><b><font color="#ffffff" size="2">DISTRITO FISCAL</font></b></td>
                <td bgcolor= "#AFAFAF"><b><font color="#ffffff" size="2">DOCUMENTO</font></b></td>
                <td bgcolor= "#AFAFAF"><b><font color="#ffffff" size="2">T. DÍAS</font></b></td>
              </tr>
<?php
                $a=0;
                while($rpv=mysqli_fetch_assoc($cpv)){
                  $a++;
                  $ide=$rpv['idEmpleado'];
?>
              <tr>
                <td><font color="#555555"><?php echo $a; ?></font></td>
                <td><font color="#555555"><?php echo docidentidad($cone,$ide); ?></font></td>
                <td><font color="#000000"><?php echo nomempleado($cone,$ide); ?></font></td>
                <td><font color="#555555"><?php echo cargoe($cone,$ide); ?></font></td>
                <td><font color="#555555"><?php echo dependenciae($cone,$ide); ?></font></td>
                <td><font color="#555555"><?php echo fnormal($rpv['FechaVac']); ?></font></td>
                <td><font color="#555555"><?php echo $rpv['PeriodoVacacional']; ?></font></td>
                <td><font color="#555555"><?php echo fnormal($rpv['FechaIni']); ?></font></td>
                <td><font color="#555555"><?php echo fnormal($rpv['FechaFin']); ?></font></td>
                <td><font color="#555555"><?php echo condicionlabe($cone,$ide); ?></font></td>
                <td><font color="#555555"><?php echo "CAJAMARCA"; ?></font></td>
                <td><font color="#555555"><?php echo $rpv['Numero']."-".$rpv['Ano']."-".$rpv['Siglas']; ?></font></td>
                <td><font color="#555555"><?php echo intervalo($rpv['FechaFin'],$rpv['FechaIni']); ?></font></td>
              </tr>
<?php
                }
      }else{
?>
              <tr>
                    <td>No se encontraron resultados.<?php echo " ".$c; ?></td>
              </tr>
<?php
      }
      mysqli_free_result($cpv);
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
