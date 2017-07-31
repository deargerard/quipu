<?php
session_start();
include ("../m_inclusiones/php/conexion_sp.php");
include ("../m_inclusiones/php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],1)){
      $fecha = @date("d-m-Y");


      //Inicio de la instancia para la exportación en Excel
      //header('Content-type: application/vnd.ms-excel');
      header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
      header("Content-Disposition: attachment; filename=Personal_$fecha.xls");
      header("Pragma: no-cache");
      header("Expires: 0");

?>
          <table border=1>
              <tr>
                    <th colspan="19"><font face="arial" color="#FF5C26" size="3">LISTADO DE PERSONAL ACTIVO - DISTRITO FISCAL DE CAJAMARCA</font></th>
              </tr>
              <tr>
                    <td colspan="19"></td>
              </tr>
<?php
              $cper=mysqli_query($cone,"SELECT e.idEmpleado, ApellidoPat, ApellidoMat, Nombres, Sexo, FechaNac, NumeroDoc, CorreoPer, CorreoIns, ec.idCargo, cd.Oficial, cd.idDependencia, ec.FechaAsu, ec.idModAcceso, ec.Reemplazado FROM empleado AS e INNER JOIN empleadocargo AS ec ON e.idEmpleado=ec.idEmpleado INNER JOIN cardependencia AS cd ON ec.idEmpleadoCargo=cd.idEmpleadoCargo WHERE ec.idEstadoCar=1 AND cd.Estado=1 ORDER BY ApellidoPat, ApellidoMat, Nombres ASC");
              if(mysqli_num_rows($cper)>0){
?>
                <tr bgcolor= "#777777">
                  <td><font color="#ffffff" size="2">N°</font></td>
                  <td><font color="#ffffff" size="2">N° DNI</font></td>
                  <td><font color="#ffffff" size="2">A. PATERNO</font></td>
                  <td><font color="#ffffff" size="2">A. MATERNO</font></td>
                  <td><font color="#ffffff" size="2">NOMBRES</font></td>
                  <td><font color="#ffffff" size="2">SEXO</font></td>
                  <td><font color="#ffffff" size="2">F. NACIMIENTO</font></td>
                  <td><font color="#ffffff" size="2">CARGO</font></td>
                  <td><font color="#ffffff" size="2">SIS. LABORAL</font></td>
                  <td><font color="#ffffff" size="2">DEP. ACTUAL</font></td>
                  <td><font color="#ffffff" size="2">DIST-PROV</font></td>
                  <td><font color="#ffffff" size="2">DEP. OFICIAL</font></td>
                  <td><font color="#ffffff" size="2">COND. LABORAL</font></td>
                  <td><font color="#ffffff" size="2">FEC. INGRESO</font></td>
                  <td><font color="#ffffff" size="2">SUPLENCIA DE</font></td>
                  <td><font color="#ffffff" size="2">CORREO PERS.</font></td>
                  <td><font color="#ffffff" size="2">CORREO INST.</font></td>
                  <td><font color="#ffffff" size="2">TELÉFONO INST.</font></td>
                  <td><font color="#ffffff" size="2">TELÉFONO PERS.</font></td>
                </tr>
<?php
                $a=0;
                while($rper=mysqli_fetch_assoc($cper)){
                  $a++;
                  $ide=$rper['idEmpleado'];
                  if($rper['Oficial']==0){
                    $dofi=dependenciaeofi($cone,$ide);
                  }else{
                    $dofi='-';
                  }
                  if($rper['idModAcceso']==6){
                    $rem=nomempleado($cone,$rper['Reemplazado']);
                  }else{
                    $rem="";
                  }

?>
                <tr>
                  <td><font color="#555555"><?php echo $a; ?></font></td>
                  <td><font color="#555555"><?php echo $rper['NumeroDoc']; ?></font></td>
                  <td><font color="#000000"><?php echo $rper['ApellidoPat']; ?></font></td>
                  <td><font color="#000000"><?php echo $rper['ApellidoMat']; ?></font></td>
                  <td><font color="#000000"><?php echo $rper['Nombres']; ?></td>
                  <td><font color="#000000"><?php echo $rper['Sexo']; ?></td>
                  <td><font color="#555555"><?php echo fnormal($rper['FechaNac']); ?></td>
                  <td><font color="#000000"><?php echo cargoe($cone,$ide); ?></font></td>
                  <td><font color="#555555"><?php echo sislaboral($cone,$rper['idCargo']); ?></font></td>
                  <td><font color="#555555"><?php echo dependenciae($cone,$ide); ?></font></td>
                  <td><font color="#555555"><?php echo disprodependencia($cone,$rper['idDependencia']); ?></font></td>
                  <td><font color="#555555"><?php echo $dofi; ?></font></td>
                  <td><font color="#555555"><?php echo condicionlabe($cone,$ide); ?></font></td>
                  <td><font color="#555555"><?php echo $rper['FechaAsu']; ?></font></td>
                  <td><font color="#555555"><?php echo $rem; ?></font></td>
                  <td><font color="#555555"><?php echo $rper['CorreoPer']; ?></font></td>
                  <td><font color="#555555"><?php echo $rper['CorreoIns']; ?></font></td>
                  <td><font color="#555555"><?php echo telefonoinst($cone,$ide); ?></font></td>
                  <td><font color="#555555"><?php echo telefonopers($cone,$ide); ?></font></td>
                </tr>
<?php
                }
              }else{
?>
              <tr>
                    <td colspan="15">NO EXISTE PERSONAL CON CARGO ASIGNADO</td>
              </tr>
<?php
              }
              mysqli_free_result($cper);
?>
         
          </table>
<?php
}else{
      echo accrestringidoa();
}
?>