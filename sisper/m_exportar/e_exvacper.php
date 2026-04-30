<?php
session_start();
include ("../m_inclusiones/php/conexion_sp.php");
include ("../m_inclusiones/php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],3)){
  $per=iseguro($cone,$_GET['per']);
  $convac=explode(",",$_GET['convac']);
  $estvac=explode(",",$_GET['estvac']);

  if (isset($per) && !empty($per) && isset($convac) && !empty($convac) && isset($estvac) && !empty($estvac)) {

      $fecha = @date("d-m-Y");

      //Inicio de la instancia para la exportación en Excel
      //header('Content-type: application/vnd.ms-excel');
      header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
      header("Content-Disposition: attachment; filename=RecordVacacional_$fecha.xls");
      header("Pragma: no-cache");
      header("Expires: 0");

  		$west="(";
  		$wcon="(";
  		for ($i=0; $i < count($estvac); $i++) {
  			$west.= $i==(count($estvac)-1) ? " v.Estado=$estvac[$i])" : "v.Estado=$estvac[$i] OR ";
  			}

  		for ($j=0; $j < count($convac); $j++) {
  			$wcon.=$j==(count($convac)-1) ? " v.Condicion=$convac[$j])" : "v.Condicion=$convac[$j] OR ";
  		}

  		$q="SELECT v.idProVacaciones, pv.PeriodoVacacional, concat(d.Numero,'-',d.Ano,'-',d.Siglas) AS Resolucion, d.FechaDoc, v.FechaIni, v.FechaFin, v.Estado, v.Condicion, v.Observaciones, av.idAprVacaciones, c.Denominacion as cargo, cc.CondicionCar, ec.FechaAsu, cl.Tipo as condicionlab FROM provacaciones as v INNER JOIN periodovacacional AS pv ON v.idPeriodoVacacional = pv.idPeriodoVacacional INNER JOIN aprvacaciones as av ON v.idProVacaciones= av.idProVacaciones INNER JOIN doc AS d ON av.idDoc=d.idDoc INNER JOIN empleadocargo AS ec ON v.idEmpleadoCargo=ec.idEmpleadoCargo INNER JOIN cargo c ON ec.idCargo=c.idCargo INNER JOIN condicioncar cc ON ec.idCondicionCar=cc.idCondicionCar INNER JOIN condicionlab cl ON ec.idCondicionLab=cl.idCondicionLab WHERE idEmpleado = $per AND ec.idEmpleado=$per AND $west AND $wcon ORDER BY pv.PeriodoVacacional DESC, v.FechaIni DESC";
  		//echo $q;
  		$cvac=mysqli_query($cone,$q);
?>
          <table border=1 bordercolor="#BFBFBF">
<?php
      if (mysqli_num_rows($cvac)>0) {
        $dni=docidentidad($cone,$per);
        $nom=nomempleado($cone,$per);
?>
              <tr>
                <th colspan="10"><font face="arial" color="#FF8000" size="3">RECORD DE VACACIONES DE <?php echo $nom; ?> <small>(<?php echo $dni; ?>)</small></font></th>
              </tr>
              <tr>
                <td bgcolor= "#AFAFAF"><b><font color="#ffffff" size="2">CARGO</font></b></td>
                <td bgcolor= "#AFAFAF"><b><font color="#ffffff" size="2">F. INGRESO</font></b></td>
                <td bgcolor= "#AFAFAF"><b><font color="#ffffff" size="2">PERIODO</font></b></td>
                <td bgcolor= "#AFAFAF"><b><font color="#ffffff" size="2">REG. LAB.</font></b></td>
                <td bgcolor= "#AFAFAF"><b><font color="#ffffff" size="2">DISTRITO FISCAL</font></b></td>
                <td bgcolor= "#AFAFAF"><b><font color="#ffffff" size="2">F. INICIO</font></b></td>
                <td bgcolor= "#AFAFAF"><b><font color="#ffffff" size="2">F. FIN</font></b></td>
                <td bgcolor= "#AFAFAF"><b><font color="#ffffff" size="2">D&Iacute;AS</font></b></td>
                <td bgcolor= "#AFAFAF"><b><font color="#ffffff" size="2">DOCUMENTO</font></b></td>
                <td bgcolor= "#AFAFAF"><b><font color="#ffffff" size="2">ESTADO</font></b></td>
              </tr>
<?php
                $a=0;
                while($rvac=mysqli_fetch_assoc($cvac)){
                  $a++;
?>
              <tr>
                <td><font color="#555555"><?php echo $rvac['cargo'].($rvac['CondicionCar']=="NINGUNO" ? "" : " (".substr($rvac['CondicionCar'], 0, 1).")"); ?></font></td>
                <td><font color="#555555"><?php echo fnormal($rvac['FechaAsu']); ?></font></td>
                <td><font color="#555555"><?php echo $rvac['PeriodoVacacional']; ?></font></td>
                <td><font color="#555555"><?php echo $rvac['condicionlab']; ?></font></td>
                <td><font color="#555555"><?php echo "CAJAMARCA"; ?></font></td>
                <td><font color="#555555"><?php echo fnormal($rvac['FechaIni']); ?></font></td>
                <td><font color="#555555"><?php echo fnormal($rvac['FechaFin']); ?></font></td>
                <td><font color="#555555"><?php echo intervalo($rvac['FechaFin'],$rvac['FechaIni']); ?></font></td>
                <td><font color="#555555"><?php echo $rvac['Resolucion']?></font></td>
                <td><font color="#555555"><?php echo estadoVac($rvac['Estado']) ?></font></td>
              </tr>
<?php
                }
      }else{
?>
              <tr>
                    <td>No se encontraron resultados.</td>
              </tr>
<?php
      }
      mysqli_free_result($cvac);
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
