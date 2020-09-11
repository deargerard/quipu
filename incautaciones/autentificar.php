<?php session_start();//incluimos el conect.php que contiene los datos de la conexión a la db
include("conect.php");
$link=conect();
$sqlate=Conect(); 
$linkesp=Conect(); //echo $_POST['nick']."/".$_POST['pass'];
if( ($_POST['nick'] =='') or ($_POST['pass'] =='') )//comprobamos que las variables enviadas por el form de indexx.php tienen contenido
{
	header("Location: index.php? errorusuario=no"); //estan vacías, volvemos al index
}
else
{
	$usua=$_POST['nick']; $contra=$_POST['pass'];
	//comprobamos en la db si existe ese nick con esa pass
	$userexiste="select * from user where user='$usua' and passw='$contra'";
	$usu=mysqli_query($link,$userexiste);
	if(mysqli_num_rows($usu)!=0) //si existe comenzamos con la sesion, si no, al index
	{
	//damos valores a las variables de la sesión
		while($row = mysqli_fetch_array($usu)) 
		{ 
	//recolectar lso datos
		$_SESSION['usuario'] = $row["user"]; //damos el nick a la variable 
		$_SESSION['passw'] = $row["passw"]; //damos la id del user a la 
		$_SESSION['tipo'] = $row["tipo"]; //damos el nick a la variable 
		$_SESSION['id'] = $row["id"]; //damos la id del user a la variable 
		}
		//////////////////////////////////// datos de sesion ////////////////////////////////
		date_default_timezone_set("America/Lima");
		$Fecha=date('Y-m-d');
		$Hora=date('H:i:s');
		$Ip=$_SERVER['REMOTE_ADDR'];
		$user=$_SESSION['usuario']; //damos el nick a la variable 
		$tipo=$_SESSION['tipo']; //damos el nick a la variable 
		$sesion=session_id();
		/////////////////////////////////////////////////////////////////////////////////////
		header("Location: home.php?"); 
	}
	else
	{
		//echo $usua."<br>".$contra;
	header("Location: index.php? errorusuario=si");  //estan vacías, volvemos al index

	}
} 
?>