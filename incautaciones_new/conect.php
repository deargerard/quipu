<?php
function conect() 
{
$mysqli = new mysqli("sisweb","Ministeri0#23", "new_custodia_bd");
if ($mysqli->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	exit(); 
}
		return $mysqli; 
echo $mysqli->host_info . "\n";
}
?>