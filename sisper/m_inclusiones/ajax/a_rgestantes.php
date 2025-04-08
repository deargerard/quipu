<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],1)){
  if(isset($_POST['vig']) && !empty($_POST['vig'])){
    $vig=fmysql(iseguro($cone, $_POST['vig']));
    $tvig=explode('-', $vig);
    if(checkdate($tvig[1], $tvig[2], $tvig[0])){
?>
<br>
<?php
$c=mysqli_query($cone, "SELECT * FROM gestante WHERE ('$vig' BETWEEN fur AND fpp) AND b_ac!='eli' ORDER BY fpp ASC;");
?>
  
<?php
if(mysqli_num_rows($c)>0){
?>
<!-- <button class="btn bg-orange btn-xs pull-right" id="b_expges" title="Exportar a Excel"><i class="fa fa-file-excel-o"></i></button> -->
  <table class="table table-bordered table-hover" id="tablage">
    <thead>
      <tr class="text-maroon">
        <th colspan="8"><i class="fa fa-user-md"></i> GESTANTES AL <?php echo fnormal($vig); ?></th>
      </tr>
      <tr>
        <th>#</th>
        <th class="text-green">GESTANTE</th>
        <th>FUR</th>
        <th class="text-maroon">FPP</th>
        <th>ESTB. SALUD</th>
        <th class="text-blue">PERSONAL RESP.</th>
        <th>CARGO</th>
      </tr>
    </thead>
    <tbody>
<?php
  $n=0;
  while ($r=mysqli_fetch_assoc($c)) {
    $n++;
?>
      <tr>
        <td><?php echo $n; ?></td>
        <td class="text-green"><?php echo is_null($r['idPariente']) ? nomempleado($cone, $r['idEmpleado']) : nompariente($cone, $r['idPariente']); ?></td>
        <td><?php echo fnormal($r['fur']); ?></td>
        <td class="text-maroon"><?php echo fnormal($r['fpp']); ?></td>
        <td><?php echo $r['estsalud']; ?></td>
        <td class="text-blue"><?php echo nomempleado($cone, $r['idEmpleado']); ?></td>
        <td><?php echo cargoxiexfecha($cone, $r['idEmpleado'], date('Y-m-d')); ?></td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
  <script>
        var wbtg = XLSX.utils.table_to_book(document.getElementById('tablage'), {sheet:"Quipu"});
        var wbouttg = XLSX.write(wbtg, {bookType:'xlsx', bookSST:true, type: 'binary'});
        function s2ab(s) {
                        var buf = new ArrayBuffer(s.length);
                        var view = new Uint8Array(buf);
                        for (var i=0; i<s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
                        return buf;
        }
        $("#b_expges").click(function(){
          saveAs(new Blob([s2ab(wbouttg)],{type:"application/octet-stream"}), 'gestantes.xlsx');
        });
</script>
<?php
}else{
  echo mensajewa("No se halló gestantes en la fecha ingresada.");
}
mysqli_free_result($c);
?>


<?php
    }else{
      echo mensajewa("Error, la fecha ingresada no es válida.");
    }
  }else{
    echo mensajewa("Error, elija un fecha.");
  }
}else{
  echo accrestringidoa();
}
?>