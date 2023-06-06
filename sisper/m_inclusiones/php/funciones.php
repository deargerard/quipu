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
		return $ru['NombreDis'].' / '.$ru['NombrePro'].' / '.$ru['NombreDep'];
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
	}elseif($fecha==""){
		return "";
	}elseif($fecha=="1969-12-31"){
		return "";
	}elseif($fecha=="1970-01-01"){
		return "";
	}elseif($fecha=="0000-00-00"){
		return "";
	}else{
		$fec=@date("d/m/Y",strtotime($fecha));
		return $fec;
	}
}
function fnormalsin($fecha){
	if(is_null($fecha)){
		return "";
	}elseif($fecha==""){
		return "";
	}elseif($fecha=="1969-12-31"){
		return "";
	}elseif($fecha=="1970-01-01"){
		return "";
	}elseif($fecha=="0000-00-00"){
		return "";
	}else{
		$fec=@date("d/m/Y",strtotime($fecha));
		return $fec;
	}
}
function fmysql($fecha){
	if(is_null($fecha)){
		return "";
	}elseif($fecha==""){
		return "";
	}else{
		$fec=@date("Y-m-d",strtotime(str_replace('/', '-',$fecha)));
		return $fec;
	}
}
function ftnormal($fecha){
	if(is_null($fecha)){
		return "";
	}elseif($fecha==""){
		return "";
	}elseif($fecha=="1969-12-31 00:00:00"){
		return "";
	}elseif($fecha=="1970-01-01 00:00:00"){
		return "";
	}elseif($fecha=="0000-00-00 00:00:00"){
		return "";
	}else{
		$fec=@date("d/m/Y H:i:s",strtotime($fecha));
		return $fec;
	}
}
function ftmysql($fecha){
	if(is_null($fecha)){
		return "";
	}if($fecha==""){
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
	$cca=mysqli_query($con,"SELECT Denominacion, CondicionCar FROM empleadocargo ec INNER JOIN cargo c ON ec.idCargo=c.idCargo INNER JOIN condicioncar cc ON ec.idCondicionCar=cc.idCondicionCar WHERE ec.idEmpleadoCargo=$idec;");
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
	if($idemp!=""){
		$cdep=mysqli_query($con,"SELECT d.idDependencia FROM empleado AS e INNER JOIN empleadocargo AS ec ON e.idEmpleado=ec.idEmpleado INNER JOIN cardependencia AS cd ON ec.idEmpleadoCargo=cd.idEmpleadoCargo INNER JOIN dependencia AS d ON cd.idDependencia=d.idDependencia WHERE e.idEmpleado=$idemp AND ec.idEstadoCar=1 AND cd.Estado=1");
		if($rdep=mysqli_fetch_assoc($cdep)){
			return $rdep["idDependencia"];
		}else{
			return 0;
		}
		mysqli_free_result($cdep);
	}else{
		return 0;
	}
}
function nomdependencia($con,$iddep){
	$iddep=iseguro($con, $iddep);
	if($iddep!=""){
		$cdep=mysqli_query($con, "SELECT Denominacion FROM dependencia WHERE idDependencia=$iddep");
		if($rdep=mysqli_fetch_assoc($cdep)){
			return $rdep["Denominacion"];
		}else{
			return "ERROR";
		}
		mysqli_free_result($cdep);
	}else{
		return "ERROR";
	}
}
function abrdependencia($con,$iddep){
	$iddep=iseguro($con,$iddep);
	$cdep=mysqli_query($con,"SELECT Siglas FROM dependencia WHERE idDependencia=$iddep");
	if($rdep=mysqli_fetch_assoc($cdep)){
		return $rdep["Siglas"];
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
function aliaslocal($cone,$iddep){
	$cdis=mysqli_query($cone,"SELECT l.Alias FROM dependencialocal dl INNER JOIN local l ON dl.idLocal=l.idLocal WHERE dl.idDependencia=$iddep;");
	if($rdis=mysqli_fetch_assoc($cdis)){
		return $rdis['Alias'];
	}else{
		return "-";
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
function ifoto($doc){
	if(file_exists("sisper/m_fotos/".$doc.".jpg")){
		return "sisper/m_fotos/$doc.jpg";
	}else{
		return "sisper/m_fotos/sinfoto.jpg";
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
		mysqli_free_result($ce);
	}
}
function nomempleado($con,$idemp){
	$idemp=iseguro($con,$idemp);
	$ce=mysqli_query($con,"SELECT ApellidoPat, ApellidoMat, Nombres FROM empleado WHERE idEmpleado=$idemp");
	if($re=mysqli_fetch_assoc($ce)){
		return trim($re['ApellidoPat'])." ".trim($re['ApellidoMat'])." ".trim($re['Nombres']);
	}else{
		return "--";
	}
	mysqli_free_result($ce);
}
function nomempleado_na($con,$idemp){
	$idemp=iseguro($con,$idemp);
	$ce=mysqli_query($con,"SELECT ApellidoPat, ApellidoMat, Nombres FROM empleado WHERE idEmpleado=$idemp");
	if($re=mysqli_fetch_assoc($ce)){
		return trim($re['Nombres'])." ".trim($re['ApellidoPat'])." ".trim($re['ApellidoMat']);
	}else{
		return "--";
	}
	mysqli_free_result($ce);
}
function nompariente($con,$idpar){
	$idpar=iseguro($con,$idpar);
	$ce=mysqli_query($con,"SELECT ApellidoPat, ApellidoMat, Nombres FROM pariente WHERE idPariente=$idpar");
	if($re=mysqli_fetch_assoc($ce)){
		return trim($re['ApellidoPat'])." ".trim($re['ApellidoMat'])." ".trim($re['Nombres']);
	}else{
		return "--";
	}
	mysqli_free_result($ce);
}
function nomvigilante($con,$idv){
	$idv=iseguro($con,$idv);
	$ce=mysqli_query($con,"SELECT Apellidos, Nombres FROM vigilante WHERE idVigilante=$idv");
	if($re=mysqli_fetch_assoc($ce)){
		return $re['Apellidos'].", ".$re['Nombres'];
	}else{
		return "El identificador no existe.";
	}
	mysqli_free_result($ce);
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
	if($m>=6){
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
	return "<h4 class='text-muted text-center'><i class='fa fa-check-circle text-green'></i> $text</h4>";
}
function mensajeda($text){
	return "<h4 class='text-muted text-center'><i class='fa fa-times-circle text-red'></i> $text</h4>";
}
function mensajewa($text){
	return "<h4 class='text-muted text-center'><i class='fa fa-warning text-yellow'></i> $text</h4>";
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
	$ctp=mysqli_query($con,"SELECT te.Numero, tt.TipoTelefono FROM telefonoemp AS te INNER JOIN tipotelefono AS tt ON  te.idTipoTelefono=tt.idTipoTelefono WHERE te.idEmpleado=$ide AND te.idTipoTelefono!=17 AND te.idTipoTelefono!=21 AND te.idTipoTelefono!=18 AND te.idTipoTelefono!=22 AND te.Estado=1");
	if(mysqli_num_rows($ctp)>0){
		$tp="";
		while($rtp=mysqli_fetch_assoc($ctp)){
			$tp.=$rtp['Numero'].' ';
		}
		return $tp;
	}else{
		return "";
	}
	mysqli_free_result($ctp);
}
function anexopers($con,$ide, $idd){
	$tp="";
	$ctp=mysqli_query($con,"SELECT te.Numero, tt.TipoTelefono FROM telefonoemp AS te INNER JOIN tipotelefono AS tt ON  te.idTipoTelefono=tt.idTipoTelefono WHERE te.idEmpleado=$ide AND te.Estado=1 AND (te.idTipoTelefono=18 OR te.idTipoTelefono=22);");
	if(mysqli_num_rows($ctp)>0){
		while($rtp=mysqli_fetch_assoc($ctp)){
			$tp.=$rtp['TipoTelefono'].': '.$rtp['Numero'].' ';
		}
	}
	mysqli_free_result($ctp);
	$t="";
	$ct=mysqli_query($con, "SELECT l.Telefono FROM dependencialocal dl INNER JOIN local l ON dl.idLocal=l.idLocal WHERE dl.idDependencia=$idd;");
	if($rt=mysqli_fetch_assoc($ct)){
		$t=$rt['Telefono'].' ';
	}
	mysqli_free_result($ct);
	return $t.$tp;
}
function estadocar($est){
	switch ($est){
	    case "ACTIVO": return "<span class='label label-success'>ACTIVO</span>"; break;
	    case "RESERVADO": return "<span class='label label-warning'>RESERVADO</span>"; break;
	    case "CESADO": return "<span class='label label-danger'>CESADO</span>"; break;
	    case "SUSPENDIDO": return "<span class='label label-default'>SUSPENDIDO</span>"; break;
	}
}
function estadocarnum($est){
	switch ($est){
	    case 1: return "<span class='label label-success'>ACTIVO</span>"; break;
	    case 2: return "<span class='label label-warning'>RESERVADO</span>"; break;
	    case 3: return "<span class='label label-danger'>CESADO</span>"; break;
	    case 4: return "<span class='label label-default'>SUSPENDIDO</span>"; break;
	}
}
function estadolic($est){
	switch ($est){
	    case "ACTIVO": return "<span class='label label-success'>ACTIVO</span>"; break;
	    case "RESERVADO": return "<span class='label label-warning'>RESERVADO</span>"; break;
	    case "CESADO": return "<span class='label label-danger'>CESADO</span>"; break;
	    case "SUSPENDIDO": return "<span class='label label-default'>SUSPENDIDO</span>"; break;
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
//funcion cargo por idEmpleadoCargo
function cargoiec($con, $idec){
	$idec=iseguro($con, $idec);
	$c=mysqli_query($con, "SELECT c.Denominacion, cc.CondicionCar FROM empleadocargo ec INNER JOIN cargo c ON ec.idCargo=c.idCargo INNER JOIN condicioncar cc ON ec.idCondicionCar=cc.idCondicionCar WHERE ec.idEmpleadoCargo=$idec");
	if($r=mysqli_fetch_assoc($c)){
		return $r['CondicionCar']=="NINGUNO" ? $r['Denominacion'] : $r['Denominacion']." (".substr($r['CondicionCar'],0,1).")";
	}else{
		return "Sin Cargo";
	}
	mysqli_free_result($c);
}
//funcion cargo por idEmpleadoCargo
//funcion coordinador
function escoordinador($con, $ide){
	$ide=iseguro($con,$ide);
  	$cc=mysqli_query($con,"SELECT idCoordinacion FROM coordinador WHERE idEmpleado=$ide AND Condicion!=0;");
  	if($rc=mysqli_fetch_assoc($cc)){
  		return true;
  	}else{
  		return false;
  	}
  	mysqli_free_result($cc);
}

function esResDespacho($cone, $ide){
	$ide=iseguro($cone, $ide);
	$cc=mysqli_query($cone, "SELECT idorintegrante FROM orequipo e INNER JOIN orintegrante i ON e.idorequipo=i.idorequipo INNER JOIN empleadocargo ec ON i.idEmpleadoCargo=ec.idEmpleadoCargo WHERE  ec.idEmpleado=$ide AND ec.idEstadoCar=1 AND i.responsable=1 AND i.estado=1 AND e.estado=1;");
	if(mysqli_num_rows($cc)>0){
		return true;
	}else{
		return false;
	}
	mysqli_free_result($cc);
}

function enviopv($con, $ideq){
	$ideq=iseguro($con,$ideq);
	$c7=mysqli_query($con,"SELECT pv.idProVacaciones FROM empleadocargo ec INNER JOIN provacaciones pv ON ec.idEmpleadoCargo=pv.idEmpleadoCargo INNER JOIN orintegrante i ON ec.idEmpleadocargo=i.idEmpleadocargo WHERE i.idorequipo=$ideq AND i.estado=1 AND ec.idEstadoCar=1 AND pv.Estado=7;");
	if(mysqli_num_rows($c7)>0){
		return true;
	}else{
		return false;
	}
	mysqli_free_result($c7);
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
	if(!empty($con) && !empty($id)){
		$id=iseguro($con,$id);
		$c=mysqli_query($con,"SELECT idSolucionador FROM masolucionador WHERE idEmpleado=$id;");
		if(mysqli_num_rows($c)>0){
			return true;
		}else{
			return false;
		}
		mysqli_free_result($c);
	}else{
		return false;
	}
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
			return "Tel&eacute;fono";
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
        $str .= ($df->y > 1) ? $df->y . ' A&ntilde;os ' : $df->y . ' A&ntilde;o ';
    } if ($df->m > 0) {
        // month
        $str .= ($df->m > 1) ? $df->m . ' Meses ' : $df->m . ' Mes ';
    } if ($df->d > 0) {
        // days
        $str .= ($df->d > 1) ? $df->d . ' D&iacute;as ' : $df->d . ' D&iacute;a ';
    } if ($df->h > 0) {
        // hours
        $str .= ($df->h > 1) ? $df->h . ' Horas ' : $df->h . ' Hora ';
    } if ($df->i > 0) {
        // minutes
        $str .= ($df->i > 1) ? $df->i . ' Min. ' : $df->i . ' Min. ';
    } if ($df->s > 0) {
        // seconds
        $str .= ($df->s > 1) ? $df->s . ' Seg. ' : $df->s . ' Seg. ';
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

function estadoVac($est){
	if(!is_null($est) && $est!=""){
		switch ($est) {
			case 0:
				return "<span class='label label-info'>Pendiente</span>";
				break;
			case 1:
				return "<span class='label label-success'>Ejecutadas</span>";
				break;
			case 2:
				return "<span class='label label-danger'>Canceladas</span>";
				break;
			case 3:
				return "<span class='label label-primary'>Ejecutandose</span>";
				break;
			case 4:
				return "<span class='label label-warning'>Planificadas</span>";
				break;
			case 5:
				return "<span class='label label-default'>Suspendidas</span>";
				break;
			case 6:
				return "<span class='label label-default'>Solicitadas</span>";
				break;
			case 7:
				return "<span class='label label-purple'>Aceptadas</span>";
				break;
			case 8:
				return "<span class='label label-danger'>Denegadas</span>";
				break;
			case 9:
				return "<span class='label label-success'>Compensadas</span>";
				break;
		}
	}else{
		return "SE";
	}
}

function condicionVac($cond){
	switch ($cond) {
		case 0:
			return "Reprogramado";
			break;
		
		case 1:
			return "Programado";
			break;
	}
}

function nomhorario($con, $idh){
	$idh=iseguro($con,$idh);
	$ch=mysqli_query($con,"SELECT Descripcion FROM horario WHERE idHorario=$idh;");
	if($rh=mysqli_fetch_assoc($ch)){
		return $rh['Descripcion'];
	}else{
		return "Sin horario";
	}
}

function dirlocal($con, $idl){
	$idl=iseguro($con, $idl);
	$r="-";
	if(!is_null($idl)){
		$cl=mysqli_query($con,"SELECT l.Direccion, d.NombreDis FROM local l INNER JOIN distrito d ON l.idDistrito=d.idDistrito WHERE idLocal=$idl;");
		if($rl=mysqli_fetch_assoc($cl)){
			$r=$rl['NombreDis']." - ".$rl['Direccion'];
		}
	}
	return $r;
}
function vacio($data){
	if($data != ''){
		return "'$data'";
	} else {
		return "NULL";
	}
}
function idecxidexfecha($cone, $ide, $fec){
	$ide=iseguro($cone,$ide);
	$fec=iseguro($cone,$fec);
	$cd=array();
	$c1=mysqli_query($cone, "SELECT emc.idEmpleadoCargo FROM empleadocargo emc INNER JOIN estadocargo esc ON emc.idEmpleadoCargo=esc.idEmpleadoCargo WHERE emc.idEmpleado=$ide AND esc.idEstadoCar=1 AND esc.FechaIni<='$fec' ORDER BY FechaIni DESC LIMIT 1;");
	if($r1=mysqli_fetch_assoc($c1)){
		$idec=$r1['idEmpleadoCargo'];
		$c2=mysqli_query($cone, "SELECT FechaIni FROM estadocargo WHERE idEmpleadoCargo=$idec AND idEstadoCar=3;");
		if($r2=mysqli_fetch_assoc($c2)){
			if($r2['FechaIni']>=$fec){
				return $idec;
			}else{
				return NULL;
			}
		}else{
			return $idec;
		}
	}else{
		return NULL;
	}
	mysqli_free_result($cc);
}
function dependenciaxiecxfecha($con, $idec, $fec){
	if(!is_null($idec)){
		$idec=iseguro($con, $idec);
		$fec=iseguro($con, $fec);
		$c=mysqli_query($con, "SELECT cd.FecFin, d.Denominacion FROM cardependencia cd INNER JOIN dependencia d ON cd.idDependencia=d.idDependencia WHERE cd.idEmpleadoCargo=$idec AND cd.FecInicio<='$fec' ORDER BY FecInicio DESC LIMIT 1;");
		if($r=mysqli_fetch_assoc($c)){
			if(!is_null($r['FecFin'])){
				if($r['FecFin']>='$fec'){
					return $r['Denominacion'];
				}else{
					return "Sin Dependencia";
				}
			}else{
				return $r['Denominacion'];
			}
		}else{
			return "Sin Dependencia";
		}
		mysqli_free_result($c);
	}else{
		return "Sin Dependencia";
	}
}
function condicionlabxiec($con, $idec){
	$idec=iseguro($con, $idec);
	$c=mysqli_query($con, "SELECT cl.tipo FROM empleadocargo ec INNER JOIN condicionlab cl ON ec.idCondicionLab=cl.idCondicionLab WHERE ec.idEmpleadoCargo=$idec;");
	if($r=mysqli_fetch_assoc($c)){
		return $r['tipo'];
	}else{
		return "Error";
	}
	mysqli_free_result($c);
}
function cargoxiexfecha($con, $ide, $fec){
	if(!empty($ide) && !empty($fec)){
		$ide=iseguro($con, $ide);
		$fec=iseguro($con, $fec);
		$q="SELECT c.Denominacion, ec.idCondicionCar FROM empleadocargo ec INNER JOIN cargo c ON ec.idCargo=c.idCargo INNER JOIN estadocargo es ON ec.idEmpleadocargo=es.idEmpleadoCargo WHERE ec.idEmpleado=$ide AND (es.idEstadoCar=1 OR es.idEstadoCar=2) AND es.FechaIni<='$fec' AND (es.FechaFin>='$fec' OR es.FechaFin IS NULL);";
		$c=mysqli_query($con, $q);
		if($r=mysqli_fetch_assoc($c)){
			switch ($r['idCondicionCar']) {
				case 1:
					$co="";
					break;
				case 2:
					$co=" (T)";
					break;
				case 3:
					$co=" (P)";
					break;
			}
			return $r['Denominacion'].$co;
		}else{
			return "Sin Cargo ";
		}
		mysqli_free_result($c);
	}else{
		return "No envió datos";
	}
}
function erviaticos($est){
	switch ($est) {
	  case 0:
	    return "<span class='label label-danger'><i class='fa fa-thumbs-down'></i> Pendiente</span>";
	    break;
	  case 1:
	    return "<span class='label label-primary'><i class='fa fa-hand-peace-o'></i> Enviada</span>";
	    break;
	  case 2:
	    return "<span class='label label-warning'><i class='fa fa-hand-o-left'></i> Observada</span>";
	    break;
	  case 3:
	    return "<span class='label label-info'><i class='fa fa-thumbs-up'></i> Aceptada</span>";
	    break;
	  case 4:
	    return "<span class='label label-success'><i class='fa fa-thumbs-up'></i> Rendida</span>";
	    break;
	  case 5:
		return "<span class='label label-warning'>Sin viáticos</span>";
		break;
	}
}
function n_2decimales($num){
	return number_format((float)$num, 2, '.', '');
}

function basico($numero) {
$valor = array ('uno','dos','tres','cuatro','cinco','seis','siete','ocho','nueve','diez', 'once', 'doce', 'trece', 'catorce', 'quince', 'dieciséis', 'diecisiete', 'dieciocho', 'diecinueve', 'veinte', 'veintiuno', 'veintidós', 'veintitrés','veinticuatro','veinticinco',
'veintiséis','veintisiete','veintiocho','veintinueve');
return $valor[$numero - 1];
}
 
function decenas($n) {
$decenas = array (30=>'treinta',40=>'cuarenta',50=>'cincuenta',60=>'sesenta',
70=>'setenta',80=>'ochenta',90=>'noventa');
if( $n <= 29) return basico($n);
$x = $n % 10;
if ( $x == 0 ) {
return $decenas[$n];
} else return $decenas[$n - $x].' y '. basico($x);
}
 
function centenas($n) {
$cientos = array (100 =>'cien',200 =>'doscientos',300=>'trecientos',
400=>'cuatrocientos', 500=>'quinientos',600=>'seiscientos',
700=>'setecientos',800=>'ochocientos', 900 =>'novecientos');
if( $n >= 100) {
if ( $n % 100 == 0 ) {
return $cientos[$n];
} else {
$u = (int) substr($n,0,1);
$d = (int) substr($n,1,2);
return (($u == 1)?'ciento':$cientos[$u*100]).' '.decenas($d);
}
} else return decenas($n);
}
 
function miles($n) {
if($n > 999) {
if( $n == 1000) {return 'mil';}
else {
$l = strlen($n);
$c = (int)substr($n,0,$l-3);
$x = (int)substr($n,-3);
if($c == 1) {$cadena = 'mil '.centenas($x);}
else if($x != 0) {$cadena = centenas($c).' mil '.centenas($x);}
else $cadena = centenas($c). ' mil';
return $cadena;
}
} else return centenas($n);
}
 
function millones($n) {
if($n == 1000000) {return 'un millón';}
else {
$l = strlen($n);
$c = (int)substr($n,0,$l-6);
$x = (int)substr($n,-6);
if($c == 1) {
$cadena = ' millón ';
} else {
$cadena = ' millones ';
}
return miles($c).$cadena.(($x > 0)?miles($x):'');
}
}
function convertir($n) {
	switch (true) {
	case ( $n >= 1 && $n <= 29) : return basico($n); break;
	case ( $n >= 30 && $n < 100) : return decenas($n); break;
	case ( $n >= 100 && $n < 1000) : return centenas($n); break;
	case ($n >= 1000 && $n <= 999999): return miles($n); break;
	case ($n >= 1000000): return millones($n);
	}
}

function tipdocent($tde){
	switch ($tde) {
	  case 1:
	    return "VALE";
	    break;
	  case 2:
	    return "RECIBO";
	    break;
	  case 3:
	    return "GIRO";
	    break;
	  case 4:
	    return "DEPOSITO";
	    break;
	}
}

function sumdias($fec, $nd){
	$nuevafecha = strtotime ( '+'.$nd.' day' , strtotime ( $fec ) ) ;
	return date('Y-m-d', $nuevafecha);
}

function estadoDoc($est){
	switch ($est) {
		case 1:
			return "<span class='label label-info'>Registrado</span>";
			break;
		case 2:
			return "<span class='label label-info'>Recibido</span>";
			break;
		case 3:
			return "<span class='label label-warning'>Derivado</span>";
			break;
		case 4:
			return "<span class='label label-success'>Atendido</span>";
			break;
		case 5:
			return "<span class='label label-success'>Reportado</span>";
			break;
	}
}

function dirdisprolocal($con, $idl){
	$idl=iseguro($con, $idl);
	$cl=mysqli_query($con, "SELECT l.Direccion, d.NombreDis, p.NombrePro FROM local l INNER JOIN distrito d ON l.idDistrito=d.idDistrito INNER JOIN provincia p ON d.idProvincia=p.idProvincia WHERE l.idLocal=$idl");
	if($rl=mysqli_fetch_assoc($cl)){
		return $rl['Direccion']." [".$rl['NombreDis']." / ".$rl['NombrePro']."]";
	}else{
		return "Error";
	}
}

function nommpartes($con, $idmp){
	$idmp=iseguro($con, $idmp);
	if($idmp!=""){
		$cm=mysqli_query($con, "SELECT denominacion FROM tdmesapartes WHERE idtdmesapartes=$idmp;");
		if($rm=mysqli_fetch_assoc($cm)){
			return $rm['denominacion'];
		}else{
			return "ERROR";
		}
		mysqli_free_result($cm);
	}else{
		return "ERROR";
	}
}

function idlocempleado($cone, $ide){
	$ide=iseguro($cone, $ide);
	if($ide!=""){
		$c=mysqli_query($cone, "SELECT dl.idLocal FROM empleadocargo ec INNER JOIN cardependencia cd ON ec.idEmpleadoCargo=cd.idEmpleadoCargo INNER JOIN dependencia d ON cd.idDependencia=d.idDependencia INNER JOIN dependencialocal dl ON d.idDependencia=dl.idDependencia WHERE ec.idEmpleado=$ide AND ec.idEstadoCar=1 AND cd.Estado=1 AND dl.Estado=1 LIMIT 1;");
		if($r=mysqli_fetch_assoc($c)){
			return $r['idLocal'];
		}else{
			return "ERROR";
		}
		mysqli_fetch_assoc($c);
	}else{
		return "ERROR";
	}
}

function caldiant($cone, $idec){
	$idec=iseguro($cone, $idec);
	if($idec!=""){
		//calcular dias licencia sin goce
		$dl=0;
		$cl=mysqli_query($cone, "SELECT l.FechaIni, l.FechaFin FROM licencia l INNER JOIN tipolic tl ON l.idTipoLic=tl.idTipoLic WHERE l.idEmpleadoCargo=$idec AND l.Estado=1 AND tl.TipoLic='Sin goce';");
		if(mysqli_num_rows($cl)>0){
			while ($rl=mysqli_fetch_assoc($cl)){
				$nd=intervalo($rl['FechaFin'], $rl['FechaIni']);
				$dl=$dl+$nd;
			}
		}
		mysqli_free_result($cl);
		//calcular días de reservas y suspendidos
		$drs=0;
		$crs=mysqli_query($cone, "SELECT FechaIni, FechaFin FROM estadocargo WHERE idEmpleadoCargo=$idec AND (idEstadoCar=2 OR idEstadoCar=4);");
		if(mysqli_num_rows($crs)>0){
			while($rrs=mysqli_fetch_assoc($crs)){
				if(is_null($rrs['FechaFin'])){
					$ff=date('Y-m-d');
				}else{
					$ff=$rrs['FechaFin'];
				}
				$nrs=intervalo($ff, $rrs['FechaIni']);
				$drs=$drs+$nrs;
			}
		}
		return $dl+$drs;
	}else{
		return 0;
	}
}
function nomdespacho($con,$idec){
	if($idec!=""){
		$idec=iseguro($con,$idec);
		$ce=mysqli_query($con,"SELECT e.nombre FROM orequipo e INNER JOIN orintegrante i ON e.idorequipo=i.idorequipo INNER JOIN empleadocargo ec ON i.idEmpleadoCargo=ec.idEmpleadoCargo WHERE ec.idEmpleadoCargo=$idec AND i.estado=1 AND e.estado=1;");
		if($re=mysqli_fetch_assoc($ce)){
			return trim($re['nombre']);
		}else{
			return "-";
		}
		mysqli_free_result($ce);
	}else{
		return "-";
	}
}
function direccionEmpleado($con, $ide){
	if($ide!=""){
		$ide=iseguro($con,$ide);
		$cd=mysqli_query($con, "SELECT Direccion, idDistrito FROM domicilio WHERE idEmpleado=$ide;");
		if($rd=mysqli_fetch_assoc($cd)){
			return $rd['Direccion'].' - '.nomdistrito($con,$rd['idDistrito']);
		}else{
			return "-";
		}
	}else{
		return "-";
	}
}

function idpersonalmp($con, $ide){
	if($ide!=""){
		$ide=iseguro($con,$ide);
		$cd=mysqli_query($con, "SELECT idtdmesapartes FROM tdpersonalmp WHERE idEmpleado=$ide AND estado=1;");
		if($rd=mysqli_fetch_assoc($cd)){
			return $rd['idtdmesapartes'];
		}else{
			return 0;
		}
	}else{
		return 0;
	}
}
?>