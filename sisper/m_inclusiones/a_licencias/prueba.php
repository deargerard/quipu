<?php

include("../php/conexion_sp.php");
include("../php/funciones.php");

$c=mysqli_query($cone, "SELECT * FROM empleadocargo emca INNER JOIN estadocargo esca ON emca.idEmpleadoCargo=esca.idEmpleadoCargo WHERE idEmpleado=386 AND esca.idEstadoCar=2 ORDER BY esca.FechaIni DESC LIMIT 1;");

$r=mysqli_fetch_assoc($c);

$fvac=$r['FechaVac'];
$fres=$r['FechaIni'];

echo $fvac." - ".$fres."<br>";

$datetime1 = date_create($fvac);
$datetime2 = date_create($fres);
$interval = date_diff($datetime1, $datetime2);
$dias = $interval->format('%a');
$res = $dias % 365;
$fal = 365-$res;

$nfec= date('2016-01-18');
$nfec= date('Y-m-d', strtotime($nfec."+$fal days"));



echo "Días: ".$dias."<br>";
echo "Resto: ".$res."<br>";
echo "Faltan: ".$fal."<br>";
echo "Nueva Fecha: ".$nfec."<br>";



?>