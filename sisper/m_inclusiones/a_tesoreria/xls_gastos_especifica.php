<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],16)){
  $anob=iseguro($cone,$_GET['anob']);
  $esp=iseguro($cone,$_GET['esp']);     

  if (isset($anob) && !empty($anob) && isset($esp) && !empty($esp)){
       
      $fecha = @date("d-m-Y");

      //Inicio de la instancia para la exportación en Excel
      //header('Content-type: application/vnd.ms-excel');
      header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
      header("Content-Disposition: attachment; filename=gastosxespecifica$fecha.xls");
      header("Pragma: no-cache");
      header("Expires: 0");

      // Obtener  idEmpleadoCargo, fechas para cálculo de vacaciones
  		$cesp=mysqli_query($cone,"SELECT * FROM teespecifica where idteespecifica=$esp;");

  		$resp=mysqli_fetch_assoc($cesp);      

      $q="(SELECT r.codigo, tc.abreviatura, g.numerocom, r.mes, f.nombre, g.cantidadcom, um.umedida, g.glosacom, g.totalcom, g.idDependencia, g.fechacom FROM tegasto g INNER JOIN terendicion r on g.idterendicion= r.idterendicion INNER JOIN tetipocom tc ON g.idtetipocom=tc.idtetipocom INNER JOIN temeta m ON m.idtemeta= r.idtemeta INNER JOIN tefondo f ON m.idtefondo=f.idtefondo LEFT JOIN teumedida um ON g.idteumedida=um.idteumedida WHERE idteespecifica=$esp AND date_format(fechacom, '%Y')='$anob' order by r.codigo asc)
        union
        (SELECT r.codigo,  tc.abreviatura, g.numerocom, r.mes, f.nombre, g.cantidadcom, um.umedida, g.glosacom, g.totalcom, g.idDependencia, g.fechacom FROM tegasto g INNER JOIN comservicios cs ON g.idComServicios=cs.idComServicios INNER JOIN terendicion r ON cs.idterendicion=r.idterendicion INNER JOIN teespecifica e ON g.idteespecifica=e.idteespecifica INNER JOIN temeta m ON r.idtemeta=m.idtemeta INNER JOIN tefondo f ON m.idtefondo=f.idtefondo INNER JOIN tetipocom tc ON g.idtetipocom=tc.idtetipocom LEFT JOIN teumedida um ON g.idteumedida=um.idteumedida WHERE g.idteespecifica=$esp AND date_format(fechacom, '%Y')='$anob' order by r.codigo asc);";
        //echo $q;
  		$cgas=mysqli_query($cone,$q);
      
?>
        <table>
          <tr>
            <th colspan="10"><font face="arial" color="#FF8000" size="3">Gastos por Espec&iacute;fica</font></th>                  
          </tr>
         
        </table>
        <table border=1 bordercolor="#BFBFBF">
<?php
          if (mysqli_num_rows($cgas)>0) {
?>            
            <tr style="vertical-align: middle;">
              <td rowspan="2" bgcolor= "#AFAFAF" style="text-align: center;"><b><font color="#ffffff" size="2">REND</font></b></td>
              <td rowspan="2" bgcolor= "#AFAFAF" style="text-align: center;"><b><font color="#ffffff" size="2">COMP</font></b></td>
              <td rowspan="2" bgcolor= "#AFAFAF" style="text-align: center;"><b><font color="#ffffff" size="2">NUM</font></b></td>
              <td rowspan="2" bgcolor= "#AFAFAF" style="text-align: center;"><b><font color="#ffffff" size="2">FECHA</font></b></td>
              <td rowspan="2" bgcolor= "#AFAFAF" style="text-align: center;"><b><font color="#ffffff" size="2">MES</font></b></td>
              <td rowspan="2" bgcolor= "#AFAFAF" style="text-align: center;"><b><font color="#ffffff" size="2">META</font></b></td>
              <td rowspan="2" bgcolor= "#AFAFAF" style="text-align: center;"><b><font color="#ffffff" size="2">CANT</font></b></td>
              <td rowspan="2" bgcolor= "#AFAFAF" style="text-align: center;"><b><font color="#ffffff" size="2">UNID.MED.</font></b></td>
              <td colspan="3" bgcolor= "#AFAFAF" style="text-align: center;"><b><font color="#ffffff" size="2"> <?php echo $resp['codigo'] . " - " . $resp['nombre']; ?></font></b></td>        
            </tr>

            <tr>
              
              <td bgcolor= "#AFAFAF" style="text-align: center;"><b><font color="#ffffff" size="2">DETALLE</font></b></td>
              <td bgcolor= "#AFAFAF" style="text-align: center;"><b><font color="#ffffff" size="2">MONTO S/</font></b></td>
              <td bgcolor= "#AFAFAF" style="text-align: center;"><b><font color="#ffffff" size="2">DEPENDENCIA</font></b></td>
            </tr>
<?php
            $tgas=0;
              while($rgas=mysqli_fetch_assoc($cgas)){
              $tgas=$tgas+$rgas['totalcom'];                               
?>
                <tr>
                  <td><font color="#555555"><?php echo $rgas['codigo']; ?></font></td>
                  <td><font color="#555555"><?php echo $rgas['abreviatura']; ?></font></td>
                  <td><font color="#555555">'<?php echo $rgas['numerocom']; ?></font></td>
                  <td><font color="#555555"><?php echo $rgas['fechacom']; ?></font></td>
                  <td><font color="#555555"><?php echo nombremes($rgas['mes']); ?></font></td>
                  <td><font color="#555555"><?php echo $rgas['nombre']; ?></font></td>
                  <td><font color="#555555"><?php echo $rgas['cantidadcom']; ?></font></td>
                  <td><font color="#555555"><?php echo $rgas['umedida']; ?></font></td>
                  <td><font color="#555555"><?php echo $rgas['glosacom']; ?></font></td>
                  <td style="mso-number-format:'0.00'; text-align: right;"><font color="#555555"><?php echo $rgas['totalcom']; ?></font></td>                  
                  <td><font color="#555555"><?php echo nomdependencia($cone,$rgas['idDependencia']); ?></font></td>
                </tr>
<?php
              }
?>
        </table>
        <table border=1 bordercolor="#BFBFBF">
          <tr>
            <td colspan="9" bgcolor= "#AFAFAF"><b><font color="#ffffff" size="2">TOTAL </font></b></td>            
            <td bgcolor= "#AFAFAF" style="mso-number-format:'0.00'; text-align: right;"><b><font color="#ffffff" size="2"><?php echo $tgas; ?></font></b></td>              
          </tr>          
        </table>
<?php              
          }else{
?>
            <tr>
                  <td colspan="11">No se encontraron gastos para la espec&iacute;fica <?php echo $resp['codigo'] . " - " . $resp['nombre'];  ?></td>
            </tr>
<?php
          }
      mysqli_free_result($cgas);

    }else{
      echo "No envio los datos completos.";
    }
    mysqli_close($cone);
}else{
      echo accrestringidoa();
}
?>
