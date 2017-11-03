<?php
session_start();
include ("../m_inclusiones/php/conexion_sp.php");
include ("../m_inclusiones/php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],3)){
      $fecha = @date("d-m-Y");


      //Inicio de la instancia para la exportación en Excel
      //header('Content-type: application/vnd.ms-excel');
      header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
      header("Content-Disposition: attachment; filename=Coordinaciones_$fecha.xls");
      header("Pragma: no-cache");
      header("Expires: 0");

?>
          <table border=1>
              <tr>
                    <th colspan="2"><font face="arial" color="#FF5C26" size="3">Coordinaciones</font></th>
              </tr>
              <tr>
                    <td colspan="2"></td>
              </tr>
<?php
              $ccor=mysqli_query($cone,"SELECT c.idCoordinacion, c.Denominacion, co.idEmpleado FROM coordinacion c INNER JOIN coordinador co ON c.idCoordinacion=co.idCoordinacion WHERE c.Estado=1 AND co.condicion=1 ORDER BY c.Denominacion ASC;");
              if(mysqli_num_rows($ccor)>0){
?>

<?php
                while($rcor=mysqli_fetch_assoc($ccor)){
?>
                <tr>
                  <td bgcolor="#F2F3F4"><font color="#555555" size="2"><strong>Coordinación</strong></font></td>
                  <td bgcolor="#F2F3F4"><font color="#555555" size="2"><strong>Coordinador</strong></font></td>
                </tr>
                <tr>
                  <td><font color="#FF4500" size="2"><strong><?php echo $rcor['Denominacion']; ?></strong></font></td>
                  <td><font color="#FF6347"><?php echo nomempleado($cone,$rcor['idEmpleado']); ?></font></td>
                </tr>
<?php
                  $idco=$rcor['idCoordinacion'];
                  $cdep=mysqli_query($cone, "SELECT Denominacion FROM dependencia WHERE idCoordinacion=$idco AND Estado=1 ORDER BY Denominacion ASC;");
?>
                <tr>
                  <td colspan="2" bgcolor="#F2F3F4"><font color="#555555" size="2"><strong>Dependencias</strong></font></td>
                </tr>
<?php
                  if(mysqli_num_rows($cdep)>0){
                    while($rdep=mysqli_fetch_assoc($cdep)){
?>
                <tr>
                  <td colspan="2"><font color="#696969"><?php echo $rdep['Denominacion']; ?></font></td>
                </tr>
<?php
                    }
                  }else{
?>
                <tr>
                  <td colspan="2"><font color="#555555">Sin dependencias</font></td>
                </tr>
<?php
                  }
                  mysqli_free_result($cdep);

                }
              }else{
?>
              <tr>
                    <td colspan="2">NO EXISTEN VACACIONES SOLICITADAS NI ACEPTADAS</td>
              </tr>
<?php
              }
              mysqli_free_result($ccor);
?>
         
          </table>
<?php
}else{
      echo accrestringidoa();
}
?>