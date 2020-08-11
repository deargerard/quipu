<?php
session_start();
include ("../m_inclusiones/php/conexion_sp.php");
include ("../m_inclusiones/php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],3)){
  $per=iseguro($cone,$_GET['per']);
  $car=iseguro($cone,$_GET['car']);
  $convac=explode(",",$_GET['convac']);
  $estvac=explode(",",$_GET['estvac']);

  if (isset($per) && !empty($per) && isset($car) && !empty($car) && isset($convac) && !empty($convac) && isset($estvac) && !empty($estvac)) {

      $fecha = @date("d-m-Y");

      //Inicio de la instancia para la exportación en Excel
      //header('Content-type: application/vnd.ms-excel');
      header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
      header("Content-Disposition: attachment; filename=RecordVacacional_$fecha.xls");
      header("Pragma: no-cache");
      header("Expires: 0");

      // Obtener  idEmpleadoCargo, fechas para cálculo de vacaciones
  		$cin=mysqli_query($cone,"SELECT ec.idEstadoCar as est, ec.idEmpleadoCargo, ec.FechaVac, ec.FechaAsu, cl.Tipo, ma.ModAcceso, eca.EstadoCar, c.Denominacion AS cargo, d.Denominacion FROM empleadocargo ec INNER JOIN condicionlab cl ON ec.idCondicionLab=cl.idCondicionLab INNER JOIN modacceso ma ON ec.idModAcceso=ma.idModAcceso INNER JOIN estadocar eca ON ec.idEstadoCar=eca.idEstadoCar INNER JOIN cargo c ON ec.idCargo=c.idCargo INNER JOIN cardependencia cd ON ec.idEmpleadoCargo=cd.idEmpleadoCargo INNER JOIN dependencia d ON cd.idDependencia=d.idDependencia WHERE ec.idEmpleadoCargo=$car and cd.oficial=1");

  		$rin=mysqli_fetch_assoc($cin);
  		$west="(";
  		$wcon="(";
  		for ($i=0; $i < count($estvac); $i++) {
  			$west.= $i==(count($estvac)-1) ? " v.Estado=$estvac[$i])" : "v.Estado=$estvac[$i] OR ";
  			}

  		for ($j=0; $j < count($convac); $j++) {
  			$wcon.=$j==(count($convac)-1) ? " v.Condicion=$convac[$j])" : "v.Condicion=$convac[$j] OR ";
  		}

  		$q="SELECT v.idProVacaciones, pv.PeriodoVacacional, concat(d.Numero,'-',d.Ano,'-',d.Siglas) AS Resolucion, d.FechaDoc, v.FechaIni, v.FechaFin, v.Estado, v.Condicion, av.idAprVacaciones FROM provacaciones as v INNER JOIN periodovacacional AS pv ON v.idPeriodoVacacional = pv.idPeriodoVacacional INNER JOIN aprvacaciones as av ON v.idProVacaciones= av.idProVacaciones INNER JOIN doc AS d ON av.idDoc=d.idDoc INNER JOIN empleadocargo AS ec ON v.idEmpleadoCargo=ec.idEmpleadoCargo WHERE idEmpleado = $per AND ec.idEmpleadoCargo=$car AND $west AND $wcon";
  		//echo $q;
  		$cvac=mysqli_query($cone,$q);
?>
          <table border=1 bordercolor="#BFBFBF">
<?php
      if (mysqli_num_rows($cvac)>0) {
?>
              <tr>
                    <th colspan="12"><font face="arial" color="#FF8000" size="3">RECORD DE VACACIONES</font></th>
              </tr>

              <tr>
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
                <td bgcolor= "#AFAFAF"><b><font color="#ffffff" size="2">ESTADO</font></b></td>
              </tr>
<?php
                $a=0;
                while($rvac=mysqli_fetch_assoc($cvac)){
                  $a++;
                  //$per=$rvac['idEmpleado'];
                  if ($rvac['Estado']=='0') {
                    $cap="Pendiente";
                  }elseif($rvac['Estado']=='1') {
                    $cap="Ejecutada";
                  }elseif ($rvac['Estado']=='2') {
                    $cap="Cancelada";
                  }elseif($rvac['Estado']=='3'){
                    $cap="Ejecutandose";
                  }elseif($rvac['Estado']=='5'){
                    $cap="Suspendida";
                  }else {
                    $cap="Planificada";
                  }
?>
              <tr>
                <td><font color="#555555"><?php echo docidentidad($cone,$per); ?></font></td>
                <td><font color="#000000"><?php echo nomempleado($cone,$per); ?></font></td>
                <td><font color="#555555"><?php echo cargoe($cone,$per); ?></font></td>
                <td><font color="#555555"><?php echo dependenciae($cone,$per); ?></font></td>
                <td><font color="#555555"><?php echo fnormal($rin['FechaAsu']); ?></font></td>
                <td><font color="#555555"><?php echo $rvac['PeriodoVacacional']; ?></font></td>
                <td><font color="#555555"><?php echo fnormal($rvac['FechaIni']); ?></font></td>
                <td><font color="#555555"><?php echo fnormal($rvac['FechaFin']); ?></font></td>
                <td><font color="#555555"><?php echo condicionlabe($cone,$per); ?></font></td>
                <td><font color="#555555"><?php echo "CAJAMARCA"; ?></font></td>
                <td><font color="#555555"><?php echo $rvac['Resolucion']?></font></td>
                <td><font color="#555555"><?php echo intervalo($rvac['FechaFin'],$rvac['FechaIni']); ?></font></td>
                <td><font color="#555555"><?php echo $cap ?></font></td>
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
