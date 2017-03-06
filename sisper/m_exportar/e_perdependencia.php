<?php
session_start();
include ("../m_inclusiones/php/conexion_sp.php");
include ("../m_inclusiones/php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],1)){
      $fecha = @date("d-m-Y");


      //Inicio de la instancia para la exportación en Excel
      //header('Content-type: application/vnd.ms-excel');
      header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
      header("Content-Disposition: attachment; filename=Listado_$fecha.xls");
      header("Pragma: no-cache");
      header("Expires: 0");

?>
          <table border=1>
              <tr>
                    <td colspan="9"></td>
              </tr>
              <tr>
                    <th colspan="9"><font face="arial" color="#FF5820">LISTADO DE PERSONAL POR DEPENDENCIA</font></th>
              </tr>
              <tr>
                    <td colspan="9"></td>
              </tr>
          <?php
          $cd=mysqli_query($cone,"SELECT * FROM dependencia WHERE Estado=1 ORDER BY Denominacion ASC");
          while($rd=mysqli_fetch_assoc($cd)){
            $idde=$rd['idDependencia'];
          ?>
              <tr>
                <th colspan="9"><font color="#FF7F00" size="2"><?php echo utf8_decode($rd['Denominacion']) ?></font></th>
              </tr>
              
            <?php
                $cp=mysqli_query($cone,"SELECT ec.idEmpleado, en.NumeroDoc, en.NombreCom, en.CorreoIns, en.CorreoPer, c.Denominacion, ec.idCondicionCar, ec.idCondicionLab, ec.idModAcceso, ec.idEstadoCar, ec.idEmpleadoCargo, ec.Reemplazado, cd.Oficial FROM empleadocargo AS ec INNER JOIN enombre AS en ON ec.idEmpleado=en.idEmpleado INNER JOIN cargo AS c ON ec.idCargo=c.idCargo INNER JOIN cardependencia AS cd ON ec.idEmpleadoCargo=cd.idEmpleadoCargo WHERE cd.idDependencia=$idde AND ec.idEstadoCar!=3 AND cd.Estado=1 ORDER BY c.Denominacion, ec.idCondicionCar, en.NombreCom ASC");
                if(mysqli_num_rows($cp)>0){
            ?>
              <tr>
                <th><font color="#555555" size="2">N° DOC.</font></th>
                <th><font color="#555555" size="2">NOMBRE</font></th>
                <th><font color="#555555" size="2">CARGO</font></th>
                <th><font color="#555555" size="2">COND. LAB.</font></th>
                <th><font color="#555555" size="2">ESTADO</font></th>
                <th><font color="#555555" size="2">CORREO</font></th>
                <th><font color="#555555" size="2">RPC INST.</font></th>
                <th><font color="#555555" size="2">TEL. PERS.</font></th>
                <th><font color="#555555" size="2">DEP. OFICIAL</font></th>
              </tr>
            <?php
                  while($rp=mysqli_fetch_assoc($cp)){
                    if($rp['Oficial']!=1){
                      $idec=$rp['idEmpleadoCargo'];
                      $cdo=mysqli_query($cone,"SELECT Denominacion FROM cardependencia AS cd INNER JOIN dependencia AS d ON cd.idDependencia=d.idDependencia WHERE cd.idEmpleadoCargo=$idec AND cd.Oficial=1");
                      $rdo=mysqli_fetch_assoc($cdo);
                      $do=$rdo['Denominacion'];
                    }else{
                      $do='--';
                    }

                    $idpe=$rp['idEmpleado'];
                    $idcl=$rp['idCondicionLab'];
                    $ccl=mysqli_query($cone,"SELECT Tipo FROM condicionlab WHERE idCondicionLab=$idcl");
                    $rcl=mysqli_fetch_assoc($ccl);

                    $ctel=mysqli_query($cone,"SELECT te.Numero, tt.TipoTelefono FROM telefonoemp AS te INNER JOIN tipotelefono AS tt ON te.idTipoTelefono=tt.idTipoTelefono WHERE te.idEmpleado=$idpe AND te.Estado=1 ORDER BY idTelefonoEmp ASC");
                    if(mysqli_num_rows($ctel)>0){
                      while($rtel=mysqli_fetch_assoc($ctel)){
                        if($rtel['TipoTelefono']=='RPC INST.'){
                          $tins=$rtel['Numero'];
                        }
                        else{
                          $tins='--';
                          $tper=$rtel['TipoTelefono'].": ".$rtel['Numero'];
                        }

                      }
                    }else{
                      $tins='--';
                      $tper='--';
                    }

                    switch ($rp['idCondicionCar']) {
                      case 2:
                        $concar=$rp["Denominacion"].' (T)';
                        break;
                      case 3:
                        $concar=$rp["Denominacion"].' (P)';
                        break;
                      default:
                        $concar=$rp["Denominacion"];
                        break;
                    }
                    switch ($rp['idEstadoCar']) {
                      case 2:
                        $estcar='RESERVADO';
                        break;
                      default:
                        $estcar='--';
                        break;
                    }
                    switch ($rp['idModAcceso']) {
                      case 6:
                        $estcar='SUPLENCIA DE: '.nomempleado($cone,$rp['Reemplazado']);
                        break;
                    }

                    mysqli_free_result($ctel);
            ?>
              <tr>
                <td style="mso-number-format:'@';"><font color="#777777" size="2"><?php echo utf8_decode($rp["NumeroDoc"]) ?></font></td>
                <td><font color="#777777" size="2"><?php echo utf8_decode($rp["NombreCom"]) ?></font></td>
                <td><font color="#777777" size="2"><?php echo utf8_decode($concar) ?></font></td>
                <td><font color="#777777" size="2"><?php echo utf8_decode($rcl["Tipo"]) ?></font></td>
                <td><font color="#777777" size="2"><?php echo utf8_decode($estcar) ?></font></td>
                <?php if(!empty($rp["CorreoIns"]) && $rp["CorreoIns"]!='NR'){ ?>
                <td><font color="#777777" size="2"><?php echo utf8_decode($rp["CorreoIns"]) ?></font></td>
                <?php }else{ ?>
                <td><font color="#777777" size="2"><?php echo utf8_decode($rp["CorreoPer"]) ?></font></td>
                <?php } ?>
                <td><font color="#777777" size="2"><?php echo utf8_decode($tins) ?></font></td>
                <td><font color="#777777" size="2"><?php echo utf8_decode($tper) ?></font></td>
                <td><font color="#777777" size="2"><?php echo utf8_decode($do) ?></font></td>
              </tr>
            <?php
                mysqli_free_result($ccl);
                  }
                }else{
            ?>
              <tr>
                <td colspan="9"><font color="#777777" size="2">SIN PERSONAL ASIGNADO.</font></td>
              </tr>
            <?php
                }
            ?>
          <?php
          }
          ?>
          </table>
<?php
}else{
      echo accrestringidoa();
}
?>