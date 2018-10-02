<?php
session_start();
include 'cone.php';
include 'func.php';
include '../const.php';
$idusu=$_SESSION['idusu'];
if(isset($_SESSION['nusu']) && !empty($_SESSION['nusu']) && isset($_SESSION['idusu']) && !empty($_SESSION['idusu'])){
  if(isset($_POST['nguia']) && !empty($_POST['nguia'])){
		$nguia=iseguro($cone,trim($_POST['nguia']));
    $guia=explode("-", $nguia);
    $num=trim($guia[0]);
    $ano=trim($guia[1]);
    $q="SELECT d.Destino, g.Numero, g.Fecha, g.idGuia FROM guia g INNER JOIN destino d ON g.idDestino=d.idDestino WHERE Numero=$num AND DATE_FORMAT(Fecha,'%Y')='$ano';";
    //echo $q;
    $cd=mysqli_query($cone, $q);
    if(mysqli_num_rows($cd)>0){
?>
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th>Guía</th>
          <th>Destino</th>
          <th>Fecha</th>
          <th>Acción</th>
        </tr>
      </thead>
      <tbody>
<?php while($rd=mysqli_fetch_assoc($cd)){ ?>
        <tr>
          <td><?php echo $rd['Numero']."-".date("Y",strtotime($rd['Fecha'])); ?></td>
          <td><?php echo $rd['Destino']; ?></td>
          <td><?php echo fnormal($rd['Fecha']); ?></td>
          <td><a href="php/e_guiapdf.php?guia=<?php echo $rd['idGuia']; ?>" title="Exportar PDF" target="_blank"><i class="fa fa-file-pdf-o"></i></a></td>
        </tr>
<?php } ?>
      </tbody>
      
    </table>
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