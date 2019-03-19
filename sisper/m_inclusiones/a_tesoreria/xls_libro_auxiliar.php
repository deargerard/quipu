<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],16)){
  $fecb=iseguro($cone,$_GET['fecb']);
  $fon=iseguro($cone,$_GET['fon']);  

  if (isset($fecb) && !empty($fecb) && isset($fon) && !empty($fon)){
    
    $fecini=fmysql("01/".$fecb);
    $fecfin=strtotime('+ 1 month',strtotime ($fecini));
    $fecfin=date('Y-m-j', $fecfin);
    $fecfin=strtotime('- 1 day',strtotime ($fecfin));
    $fecfin=date('Y-m-j', $fecfin);
    $fec=explode('/',$fecb);
    $mes=$fec[0];
    $anio=$fec[1];    

      $fecha = @date("d-m-Y");

      //Inicio de la instancia para la exportación en Excel
      //header('Content-type: application/vnd.ms-excel');
      header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
      header("Content-Disposition: attachment; filename=LibroAuxiliar$fecha.xls");
      header("Pragma: no-cache");
      header("Expires: 0");

      // Obtener  idEmpleadoCargo, fechas para cálculo de vacaciones
  		$cin=mysqli_query($cone,"SELECT * FROM tefondo;");

  		$rin=mysqli_fetch_assoc($cin);
  		

  		$q="SELECT a.idteasignacion, a.fecha, a.monto, a.medio, a.nummedio FROM teasignacion a INNER JOIN temeta m ON a.idtemeta=m.idtemeta INNER JOIN tefondo f ON m.idtefondo=f.idtefondo WHERE (mes BETWEEN '$fecini' AND '$fecfin') AND f.idtefondo=$fon order by a.fecha asc;";
      if ($fon==3) {
        $q1="SELECT g.idtegasto, g.fechacom, c.abreviatura, g.numerocom, g.glosacom,g.totalcom, cs.idEmpleado FROM tegasto g INNER JOIN comservicios cs ON g.idComServicios=cs.idComServicios INNER JOIN terendicion r on cs.idterendicion=r.idterendicion INNER JOIN temeta m on r.idtemeta=m.idtemeta INNER JOIN tetipocom c ON g.idtetipocom=c.idtetipocom WHERE r.mes = $mes AND r.anio=$anio order by g.fechacom asc;";
      }else{
        $q1="SELECT g.idtegasto, g.fechacom, c.abreviatura, g.numerocom, g.glosacom,g.totalcom, g.idDependencia FROM tegasto g INNER JOIN terendicion r on g.idterendicion=r.idterendicion INNER JOIN temeta m on r.idtemeta=m.idtemeta INNER JOIN tefondo f on m.idtefondo=f.idtefondo INNER JOIN tetipocom c ON g.idtetipocom=c.idtetipocom WHERE r.mes = $mes AND r.anio=$anio AND f.idtefondo=$fon order by g.fechacom asc;";
    	}
      //echo $q1;
  		$casi=mysqli_query($cone,$q);
      $cgas=mysqli_query($cone,$q1);
?>
        <table>
          <tr>
            <th colspan="6"><font face="arial" color="#FF8000" size="3">ANEXO 20</font></th>                  
          </tr>
          <tr>                    
            <th colspan="6"><font face="arial" size="3">LIBRO CAJA <?php echo $anio;?> - <?php echo $rin['nombre']; ?>- MES DE <?php echo strtoupper(nombremes($mes)); ?></font></th>
          </tr>
        </table>
        <table border=1 bordercolor="#BFBFBF">
<?php
          if (mysqli_num_rows($casi)>0) {
?>            
            <tr>
              <td colspan="3" bgcolor= "#AFAFAF" style="text-align: center;"><b><font color="#ffffff" size="2">INGRESOS</font></b></td>
              
              <td colspan="3" bgcolor= "#AFAFAF" style="text-align: center;"><b><font color="#ffffff" size="2">EGRESOS</font></b></td>        
            </tr>

            <tr>
              <td bgcolor= "#AFAFAF" style="text-align: center;"><b><font color="#ffffff" size="2">FECHA</font></b></td>
              <td bgcolor= "#AFAFAF" style="text-align: center;"><b><font color="#ffffff" size="2">CONCEPTO</font></b></td>
              <td bgcolor= "#AFAFAF" style="text-align: center;"><b><font color="#ffffff" size="2">MONTO S/</font></b></td>
              
              <td bgcolor= "#AFAFAF" style="text-align: center;"><b><font color="#ffffff" size="2">FECHA</font></b></td>
              <td bgcolor= "#AFAFAF" style="text-align: center;"><b><font color="#ffffff" size="2">CONCEPTO</font></b></td>
              <td bgcolor= "#AFAFAF" style="text-align: center;"><b><font color="#ffffff" size="2">MONTO S/</font></b></td>
              
            </tr>
<?php
            $tasi=0;
            $med="";
            if ($medio['medio']=1) {
              $med="Cheque";
            }else if ($medio['medio']=2) {
              $med="Transferencia";
            }else if ($medio['medio']=3) {
              $med="Giro";
            }

              while($rasi=mysqli_fetch_assoc($casi)){
              $tasi=$tasi+$rasi['monto'];                               
?>
                <tr>
                  <td><font color="#555555"><?php echo fnormal($rasi['fecha']); ?></font></td>
                  <td><font color="#555555"><?php echo $med. " ".  $rasi['nummedio']; ?></font></td>
                  <td style="mso-number-format:'0.00'; text-align: right;"><font color="#000000"><?php echo $rasi['monto']; ?></font></td>                  
                  <td></td>
                  <td></td>
                  <td></td>                       
                  
                  
                </tr>
<?php
              }
          }else{
?>
            <tr>
                  <td>No se encontraron resultados para asignaciones.<?php echo " ".$c; ?></td>
            </tr>
<?php
          }
      mysqli_free_result($casi);
?>
        </table>

        <table border=1 bordercolor="#BFBFBF">
<?php
          if (mysqli_num_rows($cgas)>0) {
          $tgas=0;
          $con="";
            while($rgas=mysqli_fetch_assoc($cgas)){
            $tgas=$tgas+$rgas['totalcom'];
            if ($fon==3) {
              $con= $rgas['glosacom']." DE ".nomempleado_na($cone,$rgas['idEmpleado'])." SEG&Uacute;N ". " ". $rgas['abreviatura']." ".$rgas['numerocom'];
            }else{
              $con= $rgas['glosacom']." DE ".nomdependencia($cone,$rgas['idDependencia'])." SEG&Uacute;N ". " ". $rgas['abreviatura']." ".$rgas['numerocom'];
            }                                  
?>
              <tr>
                <td></td>
                <td></td>
                <td></td>               
                <td><font color="#555555"><?php echo fnormal($rgas['fechacom']); ?></font></td>
                <td><font color="#555555"><?php echo $con; ?></font></td>
                <td style="mso-number-format:'0.00'; text-align: right;"><font color="#000000"><?php echo $rgas['totalcom']; ?></font></td>                              
              </tr>
<?php
            }
          }else{
?>
            <tr>
              <td>No se encontraron resultados para egresos.<?php echo " ".$c; ?></td>
            </tr>
<?php
      }
      mysqli_free_result($cgas);
?>
          </table>
          <table border=1 bordercolor="#BFBFBF">
            <tr>
              <td colspan="2" bgcolor= "#AFAFAF" style="text-align: center;"><b><font color="#ffffff">TOTAL INGRESOS</font></b></td>
              <td bgcolor= "#AFAFAF" style="mso-number-format:'0.00'; text-align: right;"><b><font color="#ffffff"><?php echo $tasi; ?></font></b></td>              
              <td colspan="2" bgcolor= "#AFAFAF" style="text-align: center;"><b><font color="#ffffff">TOTAL EGRESOS</font></b></td>
              <td bgcolor= "#AFAFAF" style="mso-number-format:'0.00'; text-align: right;"><b><font color="#ffffff"><?php echo $tgas; ?></font></b></td>  
            </tr>

            
          </table>
<?php
    }else{
      echo "No envio los datos completos.".$fon;
    }
    mysqli_close($cone);
}else{
      echo accrestringidoa();
}
?>
