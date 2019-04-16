<?php
session_start();
include ("../m_inclusiones/php/conexion_sp.php");
include ("../m_inclusiones/php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],3)){
      $fecha = @date("dmYHis");


      //Inicio de la instancia para la exportación en Excel
      //header('Content-type: application/vnd.ms-excel');
      header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
      header("Content-Disposition: attachment; filename=PerDiscapacidad_$fecha.xls");
      header("Pragma: no-cache");
      header("Expires: 0");

?>
          <table border=1 style="font-size: 12px;">
              <tr>
                    <th colspan="17"><font face="arial" color="#FF5C26" size="3">Personal con Discapacidad</font></th>
              </tr>
              <tr>
                    <td colspan="17"></td>
              </tr>
              <tr>
                <td style="background-color: #002856; color: #FFFFFF;">#</td>
                <td style="background-color: #002856; color: #FFFFFF;">NOMBRES Y APELLIDOS</td>
                <td style="background-color: #002856; color: #FFFFFF;"># DOCUMENTO</td>
                <td style="background-color: #002856; color: #FFFFFF;">CARGO</td>
                <td style="background-color: #002856; color: #FFFFFF;">DEPENDENCIA</td>
                <td style="background-color: #002856; color: #FFFFFF;">TIPO DISCAPACIDAD</td>
                <td style="background-color: #002856; color: #FFFFFF;">DIAGN&Oacute;STICO M&Eacute;DICO</td>
                <td style="background-color: #002856; color: #FFFFFF;">AYUDA BIOMEC&Aacute;NICA</td>
                <td style="background-color: #002856; color: #FFFFFF;">OTRO</td>
                <td style="background-color: #002856; color: #FFFFFF;">SEGURO</td>
                <td style="background-color: #002856; color: #FFFFFF;">LIMITACIONES PERMANENTES</td>
                <td style="background-color: #002856; color: #FFFFFF;">GRADO LIMITACI&Oacute;N</td>
                <td style="background-color: #002856; color: #FFFFFF;">ORIGEN LIMITACI&Oacute;N</td>
                <td style="background-color: #002856; color: #FFFFFF;">CERTIFICADO DISCAPACIDAD</td>
                <td style="background-color: #002856; color: #FFFFFF;">FECHA</td>
                <td style="background-color: #002856; color: #FFFFFF;">CONADIS</td>
                <td style="background-color: #002856; color: #FFFFFF;">FECHA</td>
              </tr>
<?php
              $c=mysqli_query($cone, "SELECT e.idEmpleado, e.NumeroDoc, d.diamedico, d.otipayubio, d.cerdis, d.feccerdis, d.conadis, d.fecconadis, td.tipod, tab.tipoa, ts.tipos, tlp.tipol, gl.gradol, ol.origenl FROM empleado e INNER JOIN discapacidad d ON e.idEmpleado=d.idEmpleado INNER JOIN tipdiscapacidad td ON d.idtipdiscapacidad=td.idtipdiscapacidad INNER JOIN tipayubio tab ON d.idtipayubio=tab.idtipayubio INNER JOIN tipseg ts ON d.idtipseg=ts.idtipseg INNER JOIN tiplimper tlp ON d.idtiplimper=tlp.idtiplimper INNER JOIN gralim gl ON d.idgralim=gl.idgralim INNER JOIN orilim ol ON d.idorilim=ol.idorilim ORDER BY e.ApellidoPat, e.ApellidoMat, e.Nombres ASC;");
              if(mysqli_num_rows($c)>0){
?>

<?php
                $n=0;
                while($r=mysqli_fetch_assoc($c)){
                  $n++;
                  switch ($r['cerdis']) {
                    case 1:
                      $cer="Si";
                      break;
                    case 2:
                      $cer="No";
                      break;
                    case 3:
                      $cer="En trámite";
                      break;
                  }
                  switch ($r['conadis']) {
                    case 1:
                      $con="Si";
                      break;
                    case 2:
                      $con="No";
                      break;
                    case 3:
                      $con="En trámite";
                      break;
                  }
?>
              <tr>
                <td><?php echo $n; ?></td>
                <td><?php echo nomempleado($cone,$r['idEmpleado']); ?></td>
                <td><?php echo $r['NumeroDoc'];; ?></td>
                <td><?php echo cargoe($cone,$r['idEmpleado']); ?></td>
                <td><?php echo nomdependencia($cone,iddependenciae($cone,$r['idEmpleado'])); ?></td>
                <td><?php echo $r['tipod']; ?></td>
                <td><?php echo $r['diamedico']; ?></td>
                <td><?php echo $r['tipoa']; ?></td>
                <td><?php echo $r['otipayubio']; ?></td>
                <td><?php echo $r['tipos']; ?></td>
                <td><?php echo $r['tipol']; ?></td>
                <td><?php echo $r['gradol']; ?></td>
                <td><?php echo $r['origenl']; ?></td>
                <td><?php echo $cer; ?></td>
                <td><?php echo fnormal($r['feccerdis']); ?></td>
                <td><?php echo $con; ?></td>
                <td><?php echo fnormal($r['fecconadis']); ?></td>
              </tr>
<?php

                }
              }else{
?>
              <tr>
                    <td colspan="17">No se encontró personal con discapacidad registrasdos</td>
              </tr>
<?php
              }
              mysqli_free_result($c);
?>
         
          </table>
<?php
}else{
      echo accrestringidoa();
}
?>