<?php
session_start();
include ("../m_inclusiones/php/conexion_sp.php");
include ("../m_inclusiones/php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],1)){
      $fecha = @date("dmY_His");


      //Inicio de la instancia para la exportación en Excel
      //header('Content-type: application/vnd.ms-excel');
      header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
      //header('Content-type: application/vnd.sun.xml.calc; charset=utf-8');
      header("Content-Disposition: attachment; filename=ListaHijos_$fecha.xls");
      header("Pragma: no-cache");
      header("Expires: 0");

?>
          <table border=1>
            <tr>
              <th colspan="12"><font face="arial" color="#FF5820" size="+2">LISTADO DE PERSONAL CON HIJOS</font></th>
            </tr>
            <?php
            $cph=mysqli_query($cone,"SELECT em.idEmpleado, CONCAT(em.ApellidoPat,' ',em.ApellidoMat,', ',em.Nombres) as NombreCom, em.NumeroDoc, em.Sexo as sexop, pa.ApellidoPat, pa.ApellidoMat, pa.Nombres, pa.Sexo, pa.NumeroDoc as doc, pa.FechaNac FROM empleado AS em INNER JOIN pariente AS pa ON em.idEmpleado=pa.idEmpleado INNER JOIN empleadocargo as ec ON em.idEmpleado=ec.idEmpleado WHERE ec.idEstadoCar=1 AND pa.idTipoPariente=3 ORDER BY em.ApellidoPat,em.ApellidoMat ASC");
            ?>

            <tr>
              <th><font color="#333333">#</font></th>
              <th><font color="#FF2626">APELLIDOS Y NOMBRES DEL SERVIDOR</font></th>
              <th><font color="#FF2626">SEXO</font></th>
              <th><font color="#FF2626">CARGO</font></th>
              <th><font color="#FF2626">DEPENDENCIA</font></th>
              <th><font color="#FF2626">DNI</font></th>
              <th><font color="#FF2626">C&Oacute;NYUGE</font></th>
              <th><font color="#FF7373">APELLIDOS Y NOMBRES DEL HIJO</font></th>
              <th><font color="#FF7373">SEXO</font></th>
              <th><font color="#FF7373">DNI</font></th>
              <th><font color="#FF7373">FECHA NAC.</font></th>
              <th><font color="#FF7373">EDAD</font></th>
            </tr>

            <?php
            $n=0;
            $ip="";
            while ($rph=mysqli_fetch_assoc($cph)) {
              $idem=$rph['idEmpleado'];
              if(cargoe($cone, $idem)!="--"){

                if($ip==$idem){
                  $cony="";
                }else{
                  $cc=mysqli_query($cone,"SELECT ApellidoPat, ApellidoMat, Nombres FROM pariente WHERE idEmpleado=$idem AND idTipoPariente=4");
                  if($rc=mysqli_fetch_assoc($cc)){
                    $cony=$rc['ApellidoPat']." ".$rc['ApellidoMat'].", ".$rc['Nombres'];
                  }else{
                    $cony="";
                  }
                }
                $n++;

                $f1=@date("y-m-d");
                $f2=$rph['FechaNac'];
                $f1=@date_create($f1);
                $f2=@date_create($f2);
                $tie=date_diff($f1, $f2);

                $ip=$idem;
            ?>
            <tr>
              <td><font color="#555555" size="-1"><?php echo $n; ?></font></td>
              <td><font color="#555555" size="-1"><?php echo $rph['NombreCom']; ?></font></td>
              <td><font color="#555555" size="-1"><?php echo $rph['sexop']; ?></font></td>
              <td><font color="#555555" size="-1"><?php echo cargoe($cone, $idem); ?></font></td>
              <td><font color="#555555" size="-1"><?php echo dependenciae($cone, $idem); ?></font></td>
              <td><font color="#555555" size="-1"><?php echo $rph['NumeroDoc']; ?></font></td>
              <td><font color="#555555" size="-1"><?php echo $cony; ?></font></td>
              <td><font color="#555555" size="-1"><?php echo $rph['ApellidoPat']." ".$rph['ApellidoMat'].", ".$rph['Nombres']; ?></font></td>
              <td><font color="#555555" size="-1"><?php echo $rph['Sexo']; ?></font></td>
              <td><font color="#555555" size="-1"><?php echo $rph['doc']; ?></font></td>
              <td><font color="#555555" size="-1"><?php echo fnormal($rph['FechaNac']); ?></font></td>
              <td><font color="#555555" size="-1"><?php echo $tie->format('%y a&ntilde;o(s), %m mes(es)'); ?></font></td>
            </tr>
            <?php
              }
            }
            ?>
          </table>
<?php
}else{
      echo accrestringidoa();
}
?>