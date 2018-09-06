<?php
session_start();
include 'cone.php';
include 'func.php';
include '../const.php';
$idusu=$_SESSION['idusu'];
if(isset($_SESSION['nusu']) && !empty($_SESSION['nusu']) && isset($_SESSION['idusu']) && !empty($_SESSION['idusu'])){
  if((isset($_POST['ndoc']) && !empty($_POST['ndoc'])) || (isset($_POST['des']) && !empty($_POST['des']))){
		$ndoc=iseguro($cone,trim($_POST['ndoc']));
    $des=imseguro($cone,trim($_POST['des']));
    $cndoc=$ndoc!="" ? "d.Numero LIKE '%$ndoc%'" : "";
    $cdes=$des!="" ? "d.Destinatario LIKE '%$des%'" : "";
    if($ndoc!="" AND $des!=""){
      $u="AND";
    }else{
      $u="";
    }
    $q="SELECT d.*, de.Destino, g.Numero AS numguia, g.Fecha, td.Tipo FROM destino de INNER JOIN guia g ON de.idDestino=g.idDestino INNER JOIN doc d ON g.idGuia=d.idGuia INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc WHERE $cndoc $u $cdes;";
    //echo $q;
    $cd=mysqli_query($cone, $q);
    if(mysqli_num_rows($cd)>0){
?>
    <table class="table table-bordered table-hover" id="bdocumen">
      <thead>
        <tr>
          <th>Número</th>
          <th>Destinatario</th>
          <th>Guía</th>
          <th>Fecha</th>
          <th>Remitente</th>
          <th>Destino</th>
          <th>Tipo</th>
          <th>Cargo</th>
        </tr>
      </thead>
      <tbody>
<?php while($rd=mysqli_fetch_assoc($cd)){ ?>
        <tr>
          <td><?php echo $rd['Numero']; ?></td>
          <td><?php echo $rd['Destinatario']; ?></td>
          <td><?php echo $rd['numguia']."-".date('Y',strtotime($rd['Fecha'])); ?></td>
          <td><?php echo fnormal($rd['Fecha']); ?></td>
          <td><?php echo $rd['Remitente']; ?></td>
          <td><?php echo $rd['Destino']; ?></td>
          <td><?php echo $rd['Tipo']; ?></td>
          <td><?php echo $rd['Cargo']==1 ? "Si" : "No"; ?></td>
        </tr>
<?php } ?>
      </tbody>
      
    </table>
    <script>
      $("#bdocumen").DataTable();
    </script>
<?php
    }else{
      echo mensajewa("No se encontraron resultados");
    }
	}else{
		echo mensajewa("Ingrese algún criterio de búsqueda");
	}
}else{
	echo mensajewa("Acceso restaringido");
}