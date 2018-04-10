<?php
function iseguro($conex,$val)
{
    $input = htmlentities($val);
    $seguro = trim(mysqli_real_escape_string ($conex,$input));
    return $seguro;
}
function imseguro($conex,$val)
{
    $val=mb_strtoupper($val,'UTF-8');
    $input = htmlentities($val);
    $seguro = trim(mysqli_real_escape_string ($conex,$input));
    return $seguro;
}
function inseguro($conex,$val)
{
    $val=mb_strtolower($val,'UTF-8');
    $input = htmlentities($val);
    $seguro = trim(mysqli_real_escape_string ($conex,$input));
    return $seguro;
}
function redireccionar(){
    header ("Location: index.html");
}
function restringido(){
    return "<span class='text text-warning text-center'><i class='fa fa-exclamation-triangle'></i> Acceso restringido</span>";
}
function nomusuario($con, $id){
    $id=iseguro($con, $id);
    $c=mysqli_query($con, "SELECT Nombres, Apellidos FROM usuario WHERE idUsuario=$id;");
    if($r=mysqli_fetch_assoc($c)){
        return $r['Apellidos'].", ".$r['Nombres'];
    }else{
        return "Error";
    }
    mysqli_free_result($c);
}
function mensajesu($men){
    return "<div class='alert alert-success' role='alert'><i class='fa fa-check-circle'></i> $men</div>";
}
function mensajewa($men){
    return "<div class='alert alert-warning' role='alert'><i class='fa fa-exclamation-triangle'></i> $men</div>";
}
function url($cadena) {
$separador = '-';//ejemplo utilizado con guión medio
$originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ~_ ';
$modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr---';

//Quitamos todos los posibles acentos
$url = strtr(utf8_decode($cadena), utf8_decode($originales), $modificadas);

//Convertimos la cadena a minusculas
$url = utf8_encode(strtolower($url));

return $url;
}
function fnormal($fecha){
    if(is_null($fecha)){
        return "";
    }elseif($fecha=='1969-12-31'){
        return "";
    }elseif($fecha=='1970-01-01'){
        return "";
    }elseif($fecha=='0000-00-00'){
        return "";
    }else{
        $fec=@date("d/m/Y",strtotime($fecha));
        return $fec;
    }
}
function fnormalsin($fecha){
    if(is_null($fecha)){
        return "";
    }elseif($fecha=='1970-01-01'){
        return "";
    }elseif($fecha=='0000-00-00'){
        return "";
    }else{
        $fec=@date("d/m/Y",strtotime($fecha));
        return $fec;
    }
}
function fmysql($fecha){
    if(is_null($fecha)){
        return "";
    }if($fecha=="1969-12-31"){
        return "";
    }else{
        $fec=@date("Y-m-d",strtotime(str_replace('/', '-',$fecha)));
        return $fec;
    }
}
function generaPass(){
    //Se define una cadena de caractares.
    //Os recomiendo desordenar las minúsculas, mayúsculas y números para mejorar la probabilidad.
    $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
    //Obtenemos la longitud de la cadena de caracteres
    $longitudCadena=strlen($cadena);
 
    //Definimos la variable que va a contener la contraseña
    $pass = "";
    //Se define la longitud de la contraseña, puedes poner la longitud que necesites
    //Se debe tener en cuenta que cuanto más larga sea más segura será.
    $longitudPass=6;
 
    //Creamos la contraseña recorriendo la cadena tantas veces como hayamos indicado
    for($i=1 ; $i<=$longitudPass ; $i++){
        //Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
        $pos=rand(0,$longitudCadena-1);
 
        //Vamos formando la contraseña con cada carácter aleatorio.
        $pass .= substr($cadena,$pos,1);
    }
    return $pass;
}
function fvalida($fec){
	 $valores = explode('/', $fec);
	 if(count($valores) == 3 && checkdate($valores[1], $valores[0], $valores[2])){
	 return true;
	 }
	 return false;
}
//funcion intervalo de fechas
function intervalo($f1, $f2) {
  $dias	= (strtotime($f1)-strtotime($f2))/86400;
	//$dias 	= abs($dias);
  $dias = floor($dias);
  $dias=$dias+1;
	return $dias;
}
//Fin Funcion intervalo de fechas
function estadodoc($est){
    switch ($est) {
    case 1:
        echo "<span class='badge badge-warning'>Pendiente</span>";
        break;
    case 2:
        echo "<span class='badge badge-success'>Notificado</span>";
        break;
    case 3:
        echo "<span class='badge badge-info'>Devuelto</span>";
        break;
    case 4:
        echo "<span class='badge badge-dark'>Reabierto</span>";
        break;
    case 5:
        echo "<span class='badge badge-danger'>Eliminado</span>";
        break;
}
}
function estadoc($est){
    switch ($est) {
    case 'Pendiente':
        return "#d9534f";
        break;
    case 'Devuelta':
        return "#f0ad4e";
        break;
    case 'Notificada':
        return "#5cb85c";
        break;
    }
}
function nombremes($mes){
    $nmes=array();
    $nmes=Array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre', 'diciembre');
    return $nmes[$mes-1];
}
function acceso($con, $idu, $mod){
    $r=false;
    $ca=mysqli_query($con, "SELECT * FROM modusu WHERE idUsuario=$idu AND idModulo=$mod AND Estado=1;");
    if($ra=mysqli_fetch_assoc($ca)){
        $r=true;
    }
    return $r;
}
function modnotificacion($mnot){
    switch ($mnot) {
        case 1:
            return "Personal";
            break;
        case 2:
            return "Bajo Puerta";
            break;
        case 3:
            return "No se ubicó dirección";
            break;
        case 4:
            return "Se nego firmar";
            break;
        default:
            return "Sin modo";
            break;
    }
}
?>