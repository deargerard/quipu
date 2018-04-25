<?php
session_start();
include 'cone.php';
include 'func.php';
include '../const.php';
$idusu=$_SESSION['idusu'];
$fecha=date("dmyHi");
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=Exportar_$fecha.xls");
header("Pragma: no-cache");
header("Expires: 0");
if(isset($_SESSION['nusu']) && !empty($_SESSION['nusu']) && isset($_SESSION['idusu']) && !empty($_SESSION['idusu'])){
	if(isset($_GET['guia']) && !empty($_GET['guia'])){
		$guia=iseguro($cone,$_GET['guia']);

                $cg=mysqli_query($cone,"SELECT g.*, d.Destino FROM guia g INNER JOIN destino d ON g.idDestino=d.idDestino WHERE idGuia=$guia;");
                if($rg=mysqli_fetch_assoc($cg)){                      
					  
                      
                      ?>
                      <table border="0">
                        <thead>
                          <tr>
                            <th colspan="9"><font size="4">GUIA DE REMISI&Oacute;N DE DOCUMENTOS</font></th>
                          </tr>
                          <tr>
                            <td colspan="9" align="center">OFICINA CENTRAL DE NOTIFICACIONES - DF CAJAMARCA</td>
                          </tr>
                          <tr>
                            <td colspan="2">DESTINO</td>
                            <td colspan="7">: <?php echo $rg['Destino']; ?></td>
                          </tr>
                          <tr>
                            <td colspan="2">GUIA N&deg;</td>
                            <td colspan="7">: <?php echo $rg['Numero']."-".date("Y",strtotime($rg['Fecha'])); ?></td>
                          </tr>
                        </thead>
                      </table>
                      <?php
                      $q="SELECT d.*, td.Tipo FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc WHERE d.idGuia=$guia AND d.Cargo=0;";
                      $cd=mysqli_query($cone, $q);
                      if(mysqli_num_rows($cd)>0){
                      ?>
                      <table border="1">
                        <thead>
                          <tr>
                            <th colspan="9" bgcolor="#B2BABB"><font color="#FFFFFF">PARA DELIGENCIAMIENTO</font></th>
                          </tr>
                          <tr>
                            <th>N&deg;</th>
                            <th>GUIA N&deg;</th>
                            <th>TIPO DOC</th>
                            <th>DOCUM. N&deg;</th>
                            <th>DEPENDENCIA ORIGEN</th>
                            <th>NOMBRE DEL REMITENTE</th>
                            <th>LUGAR O DEPENDENCIA DESTINO</th>
                            <th>NOMBRE DEL DESTINATARIO</th>
                            <th>F. ENVIO</th>
                          </tr>
                        </thead>
                        <tbody>

                      <?php
                        $n=0;
                        while($rd=mysqli_fetch_assoc($cd)){
                          $n++;
                      ?>
                          <tr>
                            <td align="center"><small><?php echo $n; ?></small></td>
                            <td align="center"><small><?php echo $rg['Numero']; ?></small></td>
                            <td><small><?php echo $rd['Tipo']; ?></small></td>
                            <td align="center"><small><?php echo $rd['Numero']; ?></small></td>
                            <td><small><?php echo $rd['Origen']; ?></small></td>
                            <td><small><?php echo $rd['Remitente']; ?></small></td>
                            <td><small><?php echo $rd['Destino']; ?></small></td>
                            <td><small><?php echo $rd['Destinatario']; ?></small></td>
                            <td><small><?php echo $rg['Fecha']; ?></small></td>
                          </tr>
                      <?php
                        }
                      ?>
                        </tbody>
                      <?php
                      }
                      mysqli_free_result($cd);

                      $q1="SELECT d.*, td.Tipo FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc WHERE d.idGuia=$guia AND d.Cargo=1;";
                      $cd1=mysqli_query($cone, $q1);
                      if(mysqli_num_rows($cd1)>0){
                      ?>
                        <thead>
                          <tr>
                            <th colspan="9" bgcolor="#B2BABB"><font color="#FFFFFF">PARA DEVOLVER CARGOS DELIGENCIADOS</font></th>
                          </tr>
                          <tr>
                            <th>N&deg;</th>
                            <th>GUIA N&deg;</th>
                            <th>TIPO DOC</th>
                            <th>DOCUM. N&deg;</th>
                            <th>DEPENDENCIA ORIGEN</th>
                            <th>NOMBRE DEL REMITENTE</th>
                            <th>LUGAR O DEPENDENCIA DESTINO</th>
                            <th>NOMBRE DEL DESTINATARIO</th>
                            <th>F. ENVIO</th>
                          </tr>
                        </thead>
                        <tbody>
                      <?php
                        $n1=0;
                        while($rd1=mysqli_fetch_assoc($cd1)){
                          $n1++;
                      ?>
                          <tr>
                            <td align="center"><small><?php echo $n1; ?></small></td>
                            <td align="center"><small><?php echo $rg['Numero']; ?></small></td>
                            <td><small><?php echo $rd1['Tipo']; ?></small></td>
                            <td align="center"><small><?php echo $rd1['Numero']; ?></small></td>
                            <td><small><?php echo $rd1['Origen']; ?></small></td>
                            <td><small><?php echo $rd1['Remitente']; ?></small></td>
                            <td><small><?php echo $rd1['Destino']; ?></small></td>
                            <td><small><?php echo $rd1['Destinatario']; ?></small></td>
                            <td><small><?php echo $rg['Fecha']; ?></small></td>
                          </tr>
                      <?php
                        }
                      ?>
                        </tbody>
                      <?php
                      }
                      mysqli_free_result($cd1);
                      ?>
                      </table>
                      <table>
                        <tr>
                          <td colspan="9"><font size="-2">DEVOLVER CARGO EXTERNO CON COURIER</font></td>
                        </tr>
                      </table>
                      <?php
                }else{
                  echo "No se encontró la guía.";
                }


	}else{
		echo "No se enviaron datos";
	}
}else{
	echo "Acceso restaringido";
}