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
function disprodep($co,$dis){
	$dis=iseguro($co,$dis);
	if(isset($dis) && !empty($dis)){
		$cu=mysqli_query($co,"SELECT NombreDis, NombrePro, NombreDep FROM distrito AS di INNER JOIN provincia AS pr ON di.idProvincia=pr.idProvincia INNER JOIN departamento AS de ON pr.idDepartamento=de.idDepartamento WHERE di.idDistrito=$dis");
		$ru=mysqli_fetch_assoc($cu);
		return $ru['NombreDis'].'-'.$ru['NombrePro'].'-'.$ru['NombreDep'];
		mysqli_free_result($cu);
	}else{
		return "No registra";
	}
}
function estciv($co,$ec){
	$cec=mysqli_query($co,"Select * From estadocivil Where idEstadoCivil=".$ec);
	$rec=mysqli_fetch_assoc($cec);
	echo $rec['EstadoCivil'];
	mysqli_free_result($cec);
}
function sexo($s){
	if($s=='M'){
		echo 'MASCULINO';
	}else{
		echo 'FEMENINO';
	}
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
function ftnormal($fecha){
	if(is_null($fecha)){
		return "";
	}elseif($fecha=='1969-12-31 00:00:00'){
		return "";
	}elseif($fecha=='1970-01-01 00:00:00'){
		return "";
	}elseif($fecha=='0000-00-00 00:00:00'){
		return "";
	}else{
		$fec=@date("d/m/Y H:i:s",strtotime($fecha));
		return $fec;
	}
}
function ftmysql($fecha){
	if(is_null($fecha)){
		return "";
	}if($fecha=="1969-12-31 00:00:00"){
		return "";
	}else{
		$fec=@date("Y-m-d H:i:s",strtotime(str_replace('/', '-',$fecha)));
		return $fec;
	}
}
function cargoe($con,$idemp){
	$idemp=iseguro($con,$idemp);
	$ccargo=mysqli_query($con,"SELECT Denominacion, CondicionCar FROM empleadocargo AS ec INNER JOIN cargo AS c ON ec.idCargo=c.idCargo INNER JOIN condicioncar AS cc ON ec.idCondicionCar=cc.idCondicionCar WHERE ec.idEmpleado=$idemp AND ec.idEstadoCar=1");
	if($rcargo=mysqli_fetch_assoc($ccargo)){
		switch ($rcargo["CondicionCar"]) {
			case 'NINGUNO':
				return $rcargo["Denominacion"];
				break;
			case 'PROVISIONAL':
				return $rcargo["Denominacion"].' (P)';
				break;
			case 'TITULAR':
				return $rcargo["Denominacion"].' (T)';
				break;
		}
	}else{
		return "--";
	}
	mysqli_free_result($ccargo);
}
function cargocu($con,$idec){
	$idec=iseguro($con,$idec);
	$cca=mysqli_query($con,"SELECT Denominacion, CondicionCar FROM empleadocargo ec INNER JOIN cargo c ON ec.idCargo=c.idCargo INNER JOIN condicioncar cc ON ec.idCondicionCar=cc.idCondicionCar WHERE ec.idEmpleadocargo=$idec;");
	if($rca=mysqli_fetch_assoc($cca)){
		return $rca['CondicionCar']=="NINGUNO" ? $rca['Denominacion'] : $rca['Denominacion']." (".substr($rca['CondicionCar'], 0, 1).")";
	}else{
		return "Error";
	}
}
function modacce($con,$idemp){
	$idemp=iseguro($con,$idemp);
	$cmod=mysqli_query($con,"SELECT idModAcceso FROM empleadocargo WHERE idEmpleado=$idemp AND idEstadoCar=1");
	if($rmod=mysqli_fetch_assoc($cmod)){
		switch ($rmod["idModAcceso"]) {
			case 6:
				return "SUPLENCIA";
				break;
			default:
				return "--";
				break;
		}
	}else{
		return "--";
	}
	mysqli_free_result($cmod);
}
function dependenciae($con,$idemp){
	$idemp=iseguro($con,$idemp);
	$cdep=mysqli_query($con,"SELECT Denominacion FROM empleado AS e INNER JOIN empleadocargo AS ec ON e.idEmpleado=ec.idEmpleado INNER JOIN cardependencia AS cd ON ec.idEmpleadoCargo=cd.idEmpleadoCargo INNER JOIN dependencia AS d ON cd.idDependencia=d.idDependencia WHERE e.idEmpleado=$idemp AND ec.idEstadoCar=1 AND cd.Estado=1");
	if($rdep=mysqli_fetch_assoc($cdep)){
		return $rdep["Denominacion"];
	}else{
		return "--";
	}
	mysqli_free_result($cdep);
}

function iddependenciae($con,$idemp){
	$idemp=iseguro($con,$idemp);
	$cdep=mysqli_query($con,"SELECT d.idDependencia FROM empleado AS e INNER JOIN empleadocargo AS ec ON e.idEmpleado=ec.idEmpleado INNER JOIN cardependencia AS cd ON ec.idEmpleadoCargo=cd.idEmpleadoCargo INNER JOIN dependencia AS d ON cd.idDependencia=d.idDependencia WHERE e.idEmpleado=$idemp AND ec.idEstadoCar=1 AND cd.Estado=1");
	if($rdep=mysqli_fetch_assoc($cdep)){
		return $rdep["idDependencia"];
	}else{
		return "0";
	}
	mysqli_free_result($cdep);
}
function nomdependencia($con,$iddep){
	$iddep=iseguro($con,$iddep);
	$cdep=mysqli_query($con,"SELECT Denominacion FROM dependencia WHERE idDependencia=$iddep");
	if($rdep=mysqli_fetch_assoc($cdep)){
		return $rdep["Denominacion"];
	}else{
		return "--";
	}
	mysqli_free_result($cdep);
}
function nomlocal($con,$idloc){
	$idloc=iseguro($con,$idloc);
	$cloc=mysqli_query($con,"SELECT Direccion FROM local WHERE idLocal=$idloc");
	if($rloc=mysqli_fetch_assoc($cloc)){
		return $rloc["Direccion"];
	}else{
		return "--";
	}
	mysqli_free_result($cloc);
}

function dependenciaeofi($con,$idemp){
	$idemp=iseguro($con,$idemp);
	$cdep=mysqli_query($con,"SELECT Denominacion FROM empleado AS e INNER JOIN empleadocargo AS ec ON e.idEmpleado=ec.idEmpleado INNER JOIN cardependencia AS cd ON ec.idEmpleadoCargo=cd.idEmpleadoCargo INNER JOIN dependencia AS d ON cd.idDependencia=d.idDependencia WHERE e.idEmpleado=$idemp AND ec.idEstadoCar=1 AND cd.Oficial=1");
	if($rdep=mysqli_fetch_assoc($cdep)){
		return $rdep["Denominacion"];
	}else{
		return "--";
	}
	mysqli_free_result($cdep);
}
function disprodependencia($cone,$iddep){
	$cdis=mysqli_query($cone,"SELECT d.NombreDis, p.NombrePro FROM dependencialocal dl INNER JOIN local l ON dl.idLocal=l.idLocal INNER JOIN distrito d ON l.idDistrito=d.idDistrito INNER JOIN provincia p ON d.idProvincia=p.idProvincia WHERE dl.idDependencia=$iddep;");
	if($rdis=mysqli_fetch_assoc($cdis)){
		return $rdis['NombreDis']."-".$rdis['NombrePro'];
	}else{
		return "Sin local";
	}
	mysqli_free_result($cdis);
}
function direccionlocal($cone,$iddep){
	$cdis=mysqli_query($cone,"SELECT l.Direccion FROM dependencialocal dl INNER JOIN local l ON dl.idLocal=l.idLocal WHERE dl.idDependencia=$iddep;");
	if($rdis=mysqli_fetch_assoc($cdis)){
		return $rdis['Direccion'];
	}else{
		return "Sin dirección";
	}
	mysqli_free_result($cdis);
}
function vacceso($con,$ide,$doce,$nome){
	$ide=iseguro($con,$ide);
	$doce=iseguro($con,$doce);

	if(isset($ide) && !empty($ide) && isset($doce) && !empty($doce) && isset($nome) && !empty($nome)){
		$que=mysqli_query($con,"SELECT idEmpleado FROM empleado WHERE idEmpleado=$ide AND NumeroDoc='$doce'");
		if($res=mysqli_fetch_assoc($que)){
			return true;
		}else{
			return false;
		}
		mysqli_free_result($que);
	}
}
function gradoi($con,$ide){
	$ide=iseguro($con,$ide);
	$cgra=mysqli_query($con,"SELECT GradoInstruccion FROM empleado AS e INNER JOIN gradoinstruccion AS gi ON e.idGradoInstruccion=gi.idGradoInstruccion WHERE e.idEmpleado=$ide");
	if($rgra=mysqli_fetch_assoc($cgra)){
		return $rgra["GradoInstruccion"];
	}else{
		return "No registra";
	}
	mysqli_free_result($cgra);
}
function niveli($con,$ide){
	$ide=iseguro($con,$ide);
	$cniv=mysqli_query($con,"SELECT Nivel FROM empleado AS e INNER JOIN gradoinstruccion AS gi ON e.idGradoInstruccion=gi.idGradoInstruccion WHERE e.idEmpleado=$ide");
	if($rniv=mysqli_fetch_assoc($cniv)){
		return $rniv["Nivel"];
	}else{
		return "No registra";
	}
	mysqli_free_result($cniv);
}
function pensioni($con,$ide){
	$ide=iseguro($con,$ide);
	$cins=mysqli_query($con,"SELECT Institucion FROM pensionempleado AS pe INNER JOIN sistemapension AS sp ON pe.idSistemaPension=sp.idSistemaPension WHERE pe.idEmpleado=$ide");
	if($rins=mysqli_fetch_assoc($cins)){
		return $rins["Institucion"];
	}else{
		return "No registra";
	}
	mysqli_free_result($cins);
}
function cuspp($con,$ide){
	$ide=iseguro($con,$ide);
	$ccus=mysqli_query($con,"SELECT CUSPP FROM pensionempleado WHERE idEmpleado=$ide");
	if($rcus=mysqli_fetch_assoc($ccus)){
		return $rcus["CUSPP"];
	}else{
		return "No registra";
	}
	mysqli_free_result($ccus);
}
function mfoto($doc){
	if(file_exists("../m_fotos/".$doc.".jpg")){
		return "m_fotos/$doc.jpg";
	}else{
		return "m_fotos/sinfoto.jpg";
	}
}
function mfotop($doc){
	if(file_exists("m_fotos/".$doc.".jpg")){
		return "m_fotos/$doc.jpg";
	}else{
		return "m_fotos/sinfoto.jpg";
	}
}
function mfotom($doc){
	if(file_exists("../../m_fotos/".$doc.".jpg")){
		return "m_fotos/$doc.jpg";
	}else{
		return "m_fotos/sinfoto.jpg";
	}
}

function listadep($cone){
    $q1=mysqli_query($cone,"select * from departamento");
    $op="";
    while($fila=mysqli_fetch_assoc($q1)){
        $op=$op.'<option value="'.$fila["idDepartamento"].'">'.$fila["NombreDep"].'</option>';
    }
    return $op;
    mysqli_free_result($q1);
}
function listagra($cone){
	$q1=mysqli_query($cone,"select distinct GradoInstruccion from gradoinstruccion");
	$op="";
    while($fila=mysqli_fetch_assoc($q1)){
        $op=$op.'<option value="'.$fila["GradoInstruccion"].'">'.$fila["GradoInstruccion"].'</option>';
    }
    return $op;
    mysqli_free_result($q1);
}
function listapen($cone){
	$q1=mysqli_query($cone,"select * from sistemapension where Estado=1");
	$op="";
    while($fila=mysqli_fetch_assoc($q1)){
        $op=$op.'<option value="'.$fila["idSistemaPension"].'">'.$fila["Institucion"].'</option>';
    }
    return $op;
    mysqli_free_result($q1);
}
function listattel($cone){
	$q1=mysqli_query($cone,"SELECT * FROM tipotelefono WHERE Estado=1 ORDER BY TipoTelefono ASC");
	$op="";
    while($fila=mysqli_fetch_assoc($q1)){
        $op=$op.'<option value="'.$fila["idTipoTelefono"].'">'.$fila["TipoTelefono"].'</option>';
    }
    return $op;
    mysqli_free_result($q1);
}
function listaec($cone){
	$q1=mysqli_query($cone,"SELECT * FROM estadocivil ORDER BY EstadoCivil ASC");
	$op="";
	while($fila=mysqli_fetch_assoc($q1)){
		$op=$op.'<option value="'.$fila["idEstadoCivil"].'">'.$fila["EstadoCivil"].'</option>';
	}
	return $op;
	mysqli_free_result($q1);
}
function listaslab($con){
	$q1=mysqli_query($con,"SELECT * FROM sistemalab ORDER BY SistemaLab ASC");
	$op="";
	while($fila=mysqli_fetch_assoc($q1)){
		$op=$op.'<option value="'.$fila["idSistemaLab"].'">'.$fila["SistemaLab"].'</option>';
	}
	return $op;
	mysqli_free_result($q1);
}
function listadepe($con){
	$q1=mysqli_query($con,"SELECT idDependencia, Denominacion FROM dependencia WHERE Estado=1 ORDER BY Denominacion ASC");
	$op="";
	while($fila=mysqli_fetch_assoc($q1)){
		$op=$op.'<option value="'.$fila["idDependencia"].'">'.$fila["Denominacion"].'</option>';
	}
	return $op;
	mysqli_free_result($q1);
}
function listaclab($con){
	$q1=mysqli_query($con,"SELECT * FROM condicionlab WHERE estado=1 ORDER BY Tipo ASC");
	$op="";
	while($fila=mysqli_fetch_assoc($q1)){
		$op=$op.'<option value="'.$fila["idCondicionLab"].'">'.$fila["Tipo"].'</option>';
	}
	return $op;
	mysqli_free_result($q1);
}
function listaper($con){
	$q1=mysqli_query($con,"SELECT idEmpleado, NombreCom FROM enombre ORDER BY NombreCom ASC");
	$op="";
	while($fila=mysqli_fetch_assoc($q1)){
		$op=$op.'<option value="'.$fila["idEmpleado"].'">'.$fila["NombreCom"].'</option>';
	}
	return $op;
	mysqli_free_result($q1);
}
function nomdistrito($con,$dis){
	$dis=iseguro($con,$dis);
	$q1=mysqli_query($con,"SELECT NombreDis FROM distrito WHERE idDistrito=$dis");
	$fila=mysqli_fetch_assoc($q1);
	return $fila["NombreDis"];
	mysqli_free_result($q1);
}
function nomdisfiscal($con,$idf){
	$idf=iseguro($con,$idf);
	$q1=mysqli_query($con,"SELECT Denominacion FROM distritofiscal WHERE idDistritoFiscal=$idf");
	$fila=mysqli_fetch_assoc($q1);
	return $fila['Denominacion'];
	mysqli_free_result($q1);
}
function accesocon($con,$id,$mod){
	if(isset($con) && !empty($con) && isset($id) && !empty($id) && isset($mod) && !empty($mod)){
		$id=iseguro($con,$id);
		$mod=iseguro($con,$mod);
		$cme=mysqli_query($con,"SELECT Administrar, Consultar FROM empleadomodulo WHERE idEmpleado=$id AND idModulo=$mod");
		if($rme=mysqli_fetch_assoc($cme)){
			if($rme['Administrar']==1 || $rme['Consultar']==1){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
		mysqli_free_result($cme);
	}else{
		return false;
	}
}
function accesoadm($con,$id,$mod){
	if(isset($con) && !empty($con) && isset($id) && !empty($id) && isset($mod) && !empty($mod)){
		$id=iseguro($con,$id);
		$mod=iseguro($con,$mod);
		$cme=mysqli_query($con,"SELECT Administrar FROM empleadomodulo WHERE idEmpleado=$id AND idModulo=$mod");
		if($rme=mysqli_fetch_assoc($cme)){
			if($rme['Administrar']==1){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
		mysqli_free_result($cme);
	}else{
		return false;
	}
}
function acceso($con,$id){
	if(isset($con) && !empty($con) && isset($id) && !empty($id)){
		$id=iseguro($con,$id);
		$ce=mysqli_query($con,"SELECT NumeroDoc FROM empleado WHERE idEmpleado=$id AND Estado=1");
		if($re=mysqli_fetch_assoc($ce)){
			return true;
		}else{
			return false;
		}
	}
}
function nomempleado($con,$idemp){
	$idemp=iseguro($con,$idemp);
	$ce=mysqli_query($con,"SELECT ApellidoPat, ApellidoMat, Nombres FROM empleado WHERE idEmpleado=$idemp");
	if($re=mysqli_fetch_assoc($ce)){
		return trim($re['ApellidoPat'])." ".trim($re['ApellidoMat']).", ".trim($re['Nombres']);
	}else{
		return "--";
	}
}
function nomvigilante($con,$idv){
	$idv=iseguro($con,$idv);
	$ce=mysqli_query($con,"SELECT Apellidos, Nombres FROM vigilante WHERE idVigilante=$idv");
	if($re=mysqli_fetch_assoc($ce)){
		return $re['Apellidos'].", ".$re['Nombres'];
	}else{
		return "El identificador no existe.";
	}
}
function fotoe($con, $idemp){
	$idemp=iseguro($con,$idemp);
	$ce=mysqli_query($con,"SELECT NumeroDoc FROM empleado WHERE idEmpleado=$idemp");
	if($re=mysqli_fetch_assoc($ce)){
		$doc=$re['NumeroDoc'];
		if(file_exists("m_fotos/$doc.jpg")){
			return "m_fotos/$doc.jpg";
		}else{
			return "m_fotos/sinfoto.jpg";
		}
	}else{
		return "El identificador no existe.";
	}
	mysqli_free_result($ce);
}
function DNI($con, $ide){
	$idemp=iseguro($con,$ide);
	$ce=mysqli_query($con,"SELECT NumeroDoc FROM empleado WHERE idEmpleado=$ide");
	if($re=mysqli_fetch_assoc($ce)){
		return $doc=$re['NumeroDoc'];
	}else{
		return "El identificador no existe.";
	}
	mysqli_free_result($ce);
}
function accrestringidop(){
	return "<section class='content'>
  <div class='row'>
    <div class='col-md-12'>
      <h1 class='text-maroon text-center'><i class='fa fa-warning'></i> Acceso restringido</h1>
    </div>
  </div>
</section>";
}
function accrestringidoa(){
	return "<h4 class='text-maroon'><i class='fa fa-warning'></i> Acceso restringido</h4>";
}
function RandomString($num=10){
	$caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890!#$%"; //posibles caracteres a usar
	$cadena = ""; //variable para almacenar la cadena generada
	for($i=0;$i<$num;$i++)
	{
	    $cadena .= substr($caracteres,rand(0,strlen($caracteres)),1); /*Extraemos 1 caracter de los caracteres
	entre el rango 0 a Numero de letras que tiene la cadena */
	}
	return $cadena;
}
function nombremes($mes){
	$nmes=array();
	$nmes=Array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre', 'diciembre');
	return $nmes[$mes-1];
}
function vcontrasena($con,$ide){
	$cfcc=mysqli_query($con,"SELECT FecCamContra FROM empleado WHERE idEmpleado=$ide");
	$rfcc=mysqli_fetch_assoc($cfcc);
	$fa = @date("Y-m-d");
	$fc = $rfcc['FecCamContra'];
	$f1=@date_create($fa);
	$f2=@date_create($fc);
	$tie=date_diff($f1, $f2);
	$m=$tie->format('%m');
	if($m>=3){
		return true;
	}else{
		return false;
	}
}
function color(){
	$rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
	return '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
}
function colorb($n){
	$rand = array('#f56954', '#00c0ef', '#00a65a', '#f39c12', '#3c8dbc', '#d2d6de', '#001F3F', '#39CCCC', '#605ca8', '#ff851b', '#D81B60', '#111111');
	return $rand[$n];
}
function colorc($n){
	$rand = array("#dd4b39","#f39c12","#00c0ef","#0073b7","#00a65a","#d2d6de","#001f3f","#39cccc","#3d9970","#ff851b","#f012be","#605ca8","#d81b60");
	return $rand[$n];
}
function colort($n){
	$rand = array("text-red","text-yellow","text-aqua","text-blue","text-green","text-gray","text-navy","text-teal","text-olive","text-orange","text-fuchsia","text-purple","text-maroon");
	return $rand[$n];
}
function mensajesu($text){
	return "<h4 class='text-success text-center'><i class='fa fa-check-circle'></i> $text</h4>";
}
function mensajeda($text){
	return "<h4 class='text-danger text-center'><i class='fa fa-times-circle'></i> $text</h4>";
}
function mensajewa($text){
	return "<h4 class='text-warning text-center'><i class='fa fa-warning'></i> $text</h4>";
}
function estado($est){
	if($est==1){
		return "<span class='label label-success'>Activo</span>";
	}else{
		return "<span class='label label-danger'>Inactivo</span>";
	}
}
function data_text($data, $tipus=1){if ($data != '' && $tipus == 0 || $tipus == 1){$setmana = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');$mes = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');if ($tipus == 1){ereg('([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})', $data, $data);$data = @mktime(0,0,0,$data[2],$data[1],$data[3]);}return $setmana[@date('w', $data)].', '.@date('d', $data).' '.$mes[@date('m',$data)-1].' de '.@date('Y', $data);}else{return 0;}}
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
function valaccasi($con,$idv,$dni){
	$idv=iseguro($con,$idv);
	$dni=iseguro($con,$dni);
	if(isset($idv) && !empty($idv) && isset($dni) && !empty($dni)){
		$que=mysqli_query($con,"SELECT idVigilante, DNI FROM vigilante WHERE idVigilante=$idv AND DNI='$dni'");
		if($res=mysqli_fetch_assoc($que)){
			return true;
		}else{
			return false;
		}
		mysqli_free_result($que);
	}
}
function encriptar($cadena){
    $key='fiscal';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
    $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $cadena, MCRYPT_MODE_CBC, md5(md5($key))));
    return $encrypted; //Devuelve el string encriptado

}

function desencriptar($cadena){
     $key='fiscal';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
     $decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($cadena), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
    return $decrypted;  //Devuelve el string desencriptado
}
function nombredia($fecha){
   $fechats = strtotime($fecha); //pasamos a timestamp

//el parametro w en la funcion date indica que queremos el dia de la semana
//lo devuelve en numero 0 domingo, 1 lunes,....
	switch (date('w', $fechats)){
	    case 0: return "Domingo"; break;
	    case 1: return "Lunes"; break;
	    case 2: return "Martes"; break;
	    case 3: return "Miércoles"; break;
	    case 4: return "Jueves"; break;
	    case 5: return "Viernes"; break;
	    case 6: return "Sábado"; break;
	}
}
function docidentidad($con,$ide){
	$cdoc=mysqli_query($con,"SELECT NumeroDoc FROM empleado WHERE idEmpleado=$ide");
	if($rdoc=mysqli_fetch_assoc($cdoc)){
		return $rdoc['NumeroDoc'];
	}
	mysqli_free_result($cdoc);
}
function sislaboral($con,$idc){
	$csl=mysqli_query($con,"SELECT SistemaLab FROM cargo AS c INNER JOIN sistemalab AS sl ON c.idSistemaLab=sl.idSistemaLab WHERE idCargo=$idc");
	if($rsl=mysqli_fetch_assoc($csl)){
		return $rsl['SistemaLab'];
	}else{
		return "-";
	}
	mysqli_free_result($csl);
}
function condicionlabe($con,$ide){
	$ccl=mysqli_query($con,"SELECT Tipo FROM empleadocargo AS ec INNER JOIN condicionlab AS cl ON ec.idCondicionLab=cl.idCondicionLab WHERE ec.idEmpleado=$ide AND ec.idEstadoCar=1");
	if($rcl=mysqli_fetch_assoc($ccl)){
		return $rcl['Tipo'];
	}else{
		return "-";
	}
	mysqli_free_result($ccl);
}
function telefonoinst($con,$ide){
	$cti=mysqli_query($con,"SELECT te.Numero FROM telefonoemp AS te INNER JOIN tipotelefono AS tt ON te.idTipoTelefono=tt.idTipoTelefono WHERE te.idEmpleado=$ide AND te.idTipoTelefono=17 AND te.Estado=1");
	if($rti=mysqli_fetch_assoc($cti)){
		return $rti['Numero'];
	}else{
		return "";
	}
	mysqli_free_result($cti);
}
function telefonopers($con,$ide){
	$ctp=mysqli_query($con,"SELECT te.Numero, tt.TipoTelefono FROM telefonoemp AS te INNER JOIN tipotelefono AS tt ON  te.idTipoTelefono=tt.idTipoTelefono WHERE te.idEmpleado=$ide AND te.idTipoTelefono!=17 AND te.Estado=1");
	if(mysqli_num_rows($ctp)>0){
		$tp="";
		while($rtp=mysqli_fetch_assoc($ctp)){
			$tp.=$rtp['TipoTelefono'].': '.$rtp['Numero'].' ';
		}
		return $tp;
	}else{
		return "";
	}
	mysqli_free_result($ctp);
}
function estadocar($est){
	switch ($est){
	    case "ACTIVO": return "<span class='label label-success'>ACTIVO</span>"; break;
	    case "RESERVADO": return "<span class='label label-warning'>RESERVADO</span>"; break;
	    case "CESADO": return "<span class='label label-danger'>CESADO</span>"; break;
	}
}
function estadolic($est){
	switch ($est){
	    case "ACTIVO": return "<span class='label label-success'>ACTIVO</span>"; break;
	    case "RESERVADO": return "<span class='label label-warning'>RESERVADO</span>"; break;
	    case "CESADO": return "<span class='label label-danger'>CESADO</span>"; break;
	}
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
//funcion cargo por idEmpleadocargo
function cargoiec($con, $idec){
	$c=mysqli_query($con, "SELECT c.Denominacion, cc.CondicionCar FROM empleadocargo ec INNER JOIN cargo c ON ec.idCargo=c.idCargo INNER JOIN condicioncar cc ON ec.idCondicionCar=cc.idCondicionCar WHERE ec.idEmpleadoCargo=$idec");
	if($r=mysqli_fetch_assoc($c)){
		return $r['CondicionCar']=="NINGUNO" ? $r['Denominacion'] : $r['Denominacion']." (".substr($r['CondicionCar'],0,1).")";
	}else{
		return "Error";
	}
}
//funcion cargo por idEmpleadocargo
//funcion coordinador
function escoordinador($con, $ide){
	$ide=iseguro($con,$ide);
  	$cc=mysqli_query($con,"SELECT idCoordinacion FROM coordinador WHERE idEmpleado=$ide AND Condicion!=0;");
  	if($rc=mysqli_fetch_assoc($cc)){
  		return true;
  	}else{
  		return false;
  	}
}

function enviopv($con, $idcoo){
	$idcoo=iseguro($con,$idcoo);
	$c7=mysqli_query($con,"SELECT pv.idProVacaciones FROM dependencia d INNER JOIN cardependencia cd ON d.idDependencia=cd.idDependencia INNER JOIN empleadocargo ec ON cd.idEmpleadoCargo=ec.idEmpleadoCargo INNER JOIN provacaciones pv ON ec.idEmpleadoCargo=pv.idEmpleadoCargo WHERE cd.Estado=1 AND d.idCoordinacion=$idcoo AND ec.idEstadoCar=1 AND pv.Estado=7;");
	if(mysqli_num_rows($c7)>0){
		return true;
	}else{
		return false;
	}
}

function nomcoordinacion($con, $idcoo){
	$idcoo=iseguro($con,$idcoo);
	$cc=mysqli_query($con, "SELECT Denominacion FROM coordinacion WHERE idCoordinacion=$idcoo;");
	if($rc=mysqli_fetch_assoc($cc)){
		return $rc['Denominacion'];
	}else{
		return "Error";
	}
}

function srdias($fec,$dias){
	$fec=date($fec);
	$nfec=strtotime('+'.$dias.' day',strtotime($fec));
	return date('Y-m-d',$nfec);
}

function solucionador($con, $id){
	$id=iseguro($con,$id);
	$c=mysqli_query($con,"SELECT idSolucionador FROM masolucionador WHERE idEmpleado=$id;");
	if($r=mysqli_fetch_assoc($c)){
		return true;
	}else{
		return false;
	}
	mysqli_free_result($c);
}
function ateestado($est){
	switch ($est) {
		case 1:
			return "<span class='label label-success'>Resuelta</span>";
			break;
		case 2:
			return "<span class='label label-warning'>Pendiente</span>";
			break;
		case 3:
			return "<span class='label label-danger'>Cancelada</span>";
			break;
	}
}
function atemedio($med){
	switch ($med) {
		case 1:
			return "Presencial";
			break;
		case 2:
			return "Teléfono";
			break;
		case 3:
			return "Email";
			break;
		case 4:
			return "Acceso Remoto";
			break;
		case 5:
			return "Ninguno";
			break;
	}
}
function get_format($df) {

    $str = '';
    $str .= ($df->invert == 1) ? ' - ' : '';
    if ($df->y > 0) {
        // years
        $str .= ($df->y > 1) ? $df->y . ' Años ' : $df->y . ' Año ';
    } if ($df->m > 0) {
        // month
        $str .= ($df->m > 1) ? $df->m . ' Meses ' : $df->m . ' Mes ';
    } if ($df->d > 0) {
        // days
        $str .= ($df->d > 1) ? $df->d . ' Días ' : $df->d . ' Dia ';
    } if ($df->h > 0) {
        // hours
        $str .= ($df->h > 1) ? $df->h . ' Horas ' : $df->h . ' Hora ';
    } if ($df->i > 0) {
        // minutes
        $str .= ($df->i > 1) ? $df->i . ' Mins. ' : $df->i . ' Min. ';
    } if ($df->s > 0) {
        // seconds
        $str .= ($df->s > 1) ? $df->s . ' Segs. ' : $df->s . ' Seg. ';
    }

    echo $str;
}
function diftiempo($f1,$f2){
    $date1 = new DateTime($f1);
    $date2 = new DateTime($f2);
    $diff = $date1->diff($date2);
    return get_format($diff);
}
function telefonose($con,$ide){
	$ide=iseguro($con,$ide);
	$ct=mysqli_query($con,"SELECT Numero, TipoTelefono FROM telefonoemp te INNER JOIN tipotelefono tt ON te.idTipoTelefono=tt.idTipoTelefono WHERE idEmpleado=$ide AND te.Estado=1;");
	if(mysqli_num_rows($ct)>0){
		$tel="";
		while ($rt=mysqli_fetch_assoc($ct)) {
			$tel.=$rt['TipoTelefono'].": ".$rt['Numero']." ";
		}
		return $tel;
	}else{
		return "No presente ningún número registrado";
	}
}
?>
