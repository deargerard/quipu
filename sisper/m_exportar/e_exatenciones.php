<?php
session_start();
include ("../m_inclusiones/php/conexion_sp.php");
include ("../m_inclusiones/php/funciones.php");
if(solucionador($cone,$_SESSION['identi'])){
  if (isset($_GET['soluc']) && !empty($_GET['soluc']) && isset($_GET['mesini']) && !empty($_GET['mesini']) && isset($_GET['mesfin']) && !empty($_GET['mesfin'])) {
    $soluc=iseguro($cone,$_GET['soluc']);
    $mesini=fmysql(iseguro($cone,$_GET['mesini']));
    $mesfin=fmysql(iseguro($cone,$_GET['mesfin']));


      $fecha = @date("dmYHi");
      if ($soluc==t) {
  			$wsol="";
  		}else {
  			$wsol="AND ms.idSolucionador=$soluc";
  		}


      //Inicio de la instancia para la exportación en Excel
      //header('Content-type: application/vnd.ms-excel');
      header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
      header("Content-Disposition: attachment; filename=Atenciones_$fecha.xls");
      header("Pragma: no-cache");
      header("Expires: 0");

?>
          <table border=1>
              <tr>
                    <th colspan="14"><font face="arial" color="#3c8dbc" size="3">ATENCIONES DE MESA DE AYUDA</font></th>
              </tr>

<?php
              $cper=mysqli_query($cone,"SELECT ma.idAtencion, ma.Fecha, ma.idEmpleado, ma.FecSolucion, ma.Estado, ma.Descripcion, ma.Solucion, ma.Medio, mp.Producto, ma.Registrador, mt.Tipo, mt.Oficial, msc.SubCategoria, mc.Categoria, ms.idSolucionador, ms.idEmpleado as Solucionador FROM maatencion ma INNER JOIN maproducto mp ON ma.idProducto=mp.idProducto INNER JOIN matipo mt ON mp.idTipo=mt.idTipo INNER JOIN masubcategoria msc ON mt.idSubCategoria=msc.idSubCategoria INNER JOIN macategoria mc ON msc.idCategoria=mc.idCategoria INNER JOIN masolucionador ms ON ma.idSolucionador=ms.idSolucionador WHERE (DATE_FORMAT(ma.Fecha, '%Y-%m-%d') BETWEEN '$mesini' AND '$mesfin') $wsol ORDER BY ma.Fecha DESC;");

              if(mysqli_num_rows($cper)>0){
?>
                <tr style="font-size: 14px; font-weight: 600;">
                  <td bgcolor= "#3c8dbc"><font color="#ffffff" size="2">N&deg;</font></td>
                  <td bgcolor= "#3c8dbc"><font color="#ffffff" size="2">FEC. REPORTE</font></td>
                  <td bgcolor= "#3c8dbc"><font color="#ffffff" size="2">USUARIO</font></td>
                  <td bgcolor= "#3c8dbc"><font color="#ffffff" size="2">CARGO</font></td>
                  <td bgcolor= "#3c8dbc"><font color="#ffffff" size="2">DEPENDENCIA</font></td>
                  <td bgcolor= "#3c8dbc"><font color="#ffffff" size="2">CATEGORIA</font></td>
                  <td bgcolor= "#3c8dbc"><font color="#ffffff" size="2">REPORTABLE</font></td>
                  <td bgcolor= "#3c8dbc"><font color="#ffffff" size="2">DESCRIPCI&Oacute;N</font></td>
                  <td bgcolor= "#3c8dbc"><font color="#ffffff" size="2">ESTADO</font></td>
                  <td bgcolor= "#3c8dbc"><font color="#ffffff" size="2">FEC. SOLUCI&Oacute;N</font></td>
                  <td bgcolor= "#3c8dbc"><font color="#ffffff" size="2">TIEMPO</font></td>
                  <td bgcolor= "#3c8dbc"><font color="#ffffff" size="2">SOLUCI&Oacute;N</font></td>
                  <td bgcolor= "#3c8dbc"><font color="#ffffff" size="2">MEDIO</font></td>
                  <td bgcolor= "#3c8dbc"><font color="#ffffff" size="2">RESPONSABLE</font></td>


                </tr>
<?php
                $a=0;
                while($rper=mysqli_fetch_assoc($cper)){
                  $a++;
                  $ide=$rper['idEmpleado'];

                  if ($rper['Estado']==2) {
        						$ffin=date('Y-m-d H:i');
        					}else {
        						$ffin=$rper['FecSolucion'];
        					}
?>
                <tr>
                  <td><font color="#000000"><?php echo $a; ?></font></td>
                  <td><font color="#000000"><?php echo ftnormal($rper['Fecha']); ?></font></td>
                  <td><font color="#000000"><?php echo nomempleado($cone,$ide); ?></font></td>
                  <td><font color="#000000"><?php echo cargoe($cone,$ide); ?></font></td>
                  <td><font color="#000000"><?php echo dependenciae($cone,$ide); ?></font></td>
                  <td><font color="#000000"><?php echo $rper['Categoria']." - ".$rper['SubCategoria']." - ".$rper['Tipo']." - ".$rper['Producto']  ?></font></td>
                  <td><font color="#000000"><?php echo $rper['Oficial']== 1 ? "S&Iacute;" : "NO"; ?></font></td>
                  <td><font color="#000000"><?php echo $rper['Descripcion']; ?></font></td>
                  <td><font color="#000000"><?php echo ateestado($rper['Estado']); ?></font></td>
                  <td><font color="#000000"><?php echo ftnormal($rper['FecSolucion']); ?></font></td>
                  <td><font color="#000000"><?php echo diftiempo($rper['Fecha'], $ffin); ?></font></td>
                  <td><font color="#000000"><?php echo $rper['Solucion']; ?></font></td>
                  <td><font color="#000000"><?php echo atemedio($rper['Medio']); ?></font></td>
                  <td><font color="#000000"><?php echo nomempleado($cone,$rper['Solucionador']); ?></font></td>
                </tr>
<?php
                }
              }else{
?>
              <tr>
                    <td colspan="10">No existen Atenciones para las fechas seleccionadas.</td>
              </tr>
<?php
              }
              mysqli_free_result($cper);
?>

          </table>
<?php
    mysqli_close($cone);
  }else{
    echo "No envío datos";
  }
}else{
      echo accrestringidoa();
}
?>
