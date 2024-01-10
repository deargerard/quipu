<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],17)){

  if(isset($_POST['pasi']) && !empty($_POST['pasi']) && isset($_POST['fasi']) && !empty($_POST['fasi'])){

    $pasi=iseguro($cone, $_POST['pasi']);
    $fasi=iseguro($cone, $_POST['fasi']);

    $idem=$_SESSION['identi'];

    $idmp=NULL;
    $cm=mysqli_query($cone, "SELECT mp.idtdmesapartes, mp.denominacion FROM tdpersonalmp p INNER JOIN tdmesapartes mp ON p.idtdmesapartes=mp.idtdmesapartes WHERE p.idEmpleado=$idem AND p.estado=1 AND mp.estado=1;");
    if($rm=mysqli_fetch_assoc($cm)){
      $idmp=$rm['idtdmesapartes'];
    }
            $q="SELECT d.numdoc, d.Numero, d.Ano, d.Siglas, d.FechaDoc, e.fecha, td.TipoDoc FROM doc d INNER JOIN tdestadodoc e ON d.idDoc=e.idDoc INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc WHERE e.idEmpleado=$pasi AND DATE_FORMAT(e.fecha, '%d/%m/%Y')='$fasi' AND e.mpasignador=$idmp AND e.idtdestado=3 ORDER BY d.Ano, d.numdoc ASC;";
            //echo $q;
            $cd=mysqli_query($cone, $q);
            if(mysqli_num_rows($cd)>0){
?>
            <div class="col-sm-12">
                <h5 class="text-orange"><small class="text-muted">RESPONSABLE:</small> <strong><?php echo nomempleado($cone, $pasi) ?></strong> <small class="text-muted">F. ASIGNACIÓN:</small> <strong><?php echo $fasi ?></strong> <small>TOTAL DOCS:</small> <strong><?php echo mysqli_num_rows($cd) ?></strong></h5>
                <table class="table table-bordered table-hover" style="font-size: 13px;">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>NÚMERO</th>
                        <th>TIPO</th>
                        <th>DOCUMENTO</th>
                        <th>FECHA DOC</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i=0;
                    while($rd=mysqli_fetch_assoc($cd)){   
                        $i++;       
                    ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $rd['numdoc'].'-'.$rd['Ano'] ?></td>
                        <td><?php echo $rd['TipoDoc'] ?></td>
                        <td><?php echo $rd['Numero'].'-'.$rd['Ano'].'-'.$rd['Siglas'] ?></td>
                        <td><?php echo fnormal($rd['FechaDoc']) ?></td>
                    </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>

            </div>

<?php
            }else{
                echo mensajewa("Aún no tiene documentos asignados para la fecha seleccionada.");
            }
            mysqli_free_result($cd);
?>
<?php
  }else{
    echo mensajewa("Elija un personal e ingrese la fecha de asignación.");
  }
}else{
  echo accrestringidoa();
}
mysqli_close($cone);

?>