<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
$r=array();
$r['e']=false;
if(accesocon($cone,$_SESSION['identi'],17)){
	if(isset($_POST['acc']) && !empty($_POST['acc'])){
		$acc=iseguro($cone,$_POST['acc']);		
		if($acc=="agrdoc"){
            if(isset($_POST['ano']) && !empty($_POST['ano']) && isset($_POST['tipdoc']) && !empty($_POST['tipdoc']) && isset($_POST['fecdoc']) && !empty($_POST['fecdoc']) && isset($_POST['fol']) && !empty($_POST['fol']) && isset($_POST['trem']) && !empty($_POST['trem']) && isset($_POST['tdes']) && !empty($_POST['tdes']) && isset($_POST['asu']) && !empty($_POST['asu']) && isset($_POST['mpd']) && !empty($_POST['mpd'])){

                $trem=iseguro($cone, $_POST['trem']);
                $tdes=iseguro($cone, $_POST['tdes']);
                $idem=$_SESSION['identi'];

                $exr=false;
                if($trem=='i'){
                    if(isset($_POST['pirem']) && !empty($_POST['pirem']) && isset($_POST['direm']) && !empty($_POST['direm'])){
                        $exr=true;
                        $_POST['perem']="";
                        $_POST['derem']="";
                    }else{
                        $r['m']=mensajewa("No ingreso remitente ni dependencia/institución origen interno.");
                    }
                }elseif($trem=='e'){
                    if(isset($_POST['perem']) && !empty($_POST['perem']) && isset($_POST['derem']) && !empty($_POST['derem'])){
                        $exr=true;
                        $_POST['pirem']="";
                        $_POST['direm']="";
                    }else{
                        $r['m']=mensajewa("No ingreso remitente ni dependencia/institución origen externo.");
                    }
                }
                $exd=false;
                if($tdes=='i'){
                    if(isset($_POST['pides']) && !empty($_POST['pides']) && isset($_POST['dides']) && !empty($_POST['dides'])){
                        $exd=true;
                        $_POST['pedes']="";
                        $_POST['dedes']="";
                    }else{
                        $r['m']=mensajewa("No ingreso destinatario ni dependencia/institución destino interno.");
                    }
                }elseif($tdes=='e'){
                    if(isset($_POST['pedes']) && !empty($_POST['pedes']) && isset($_POST['dedes']) && !empty($_POST['dedes'])){
                        $exd=true;
                        $_POST['pides']="";
                        $_POST['dides']="";
                    }else{
                        $r['m']=mensajewa("No ingreso destinatario ni dependencia/institución destino externo.");
                    }
                }

                if($exr && $exd){
                        $num=vacio(iseguro($cone, $_POST['num']));
                        $ano=iseguro($cone, $_POST['ano']);
                        $sig=vacio(imseguro($cone, $_POST['sig']));
                        $tipdoc=iseguro($cone, $_POST['tipdoc']);
                        $fecdoc=fmysql(iseguro($cone, $_POST['fecdoc']));
                        $fol=iseguro($cone, $_POST['fol']);
                        $asu=vacio(iseguro($cone, $_POST['asu']));
                        $pirem=$_POST['pirem']=="" ? vacio("") :  vacio(iseguro($cone, $_POST['pirem']));
                        $direm=$_POST['direm']=="" ? vacio("") :  vacio(iseguro($cone, $_POST['direm']));
                        $perem=$_POST['perem']=="" ? vacio("") :  vacio(imseguro($cone, $_POST['perem']));
                        $derem=$_POST['derem']=="" ? vacio("") :  vacio(imseguro($cone, $_POST['derem']));
                        $pides=$_POST['pides']=="" ? vacio("") :  vacio(iseguro($cone, $_POST['pides']));
                        $dides=$_POST['dides']=="" ? vacio("") :  vacio(iseguro($cone, $_POST['dides']));
                        $pedes=$_POST['pedes']=="" ? vacio("") :  vacio(imseguro($cone, $_POST['pedes']));
                        $dedes=$_POST['dedes']=="" ? vacio("") :  vacio(imseguro($cone, $_POST['dedes']));
                        $car=$_POST['car']==1 ? 1 : 0;
                        $mpd=iseguro($cone, $_POST['mpd']);

                        mysqli_begin_transaction($cone);

                        try{
                            //consultamos último número doc
                            $cn=mysqli_query($cone, "SELECT MAX(numdoc) num FROM doc WHERE Ano='$ano' FOR UPDATE;");
                            if($rn=mysqli_fetch_assoc($cn)){
                                if(!is_null($rn['num'])){
                                    $nu=$rn['num']+1;
                                }else{
                                    $nu=1;
                                }
                            }
                            mysqli_free_result($cn);

                                $q="INSERT INTO doc (Numero, Ano, Siglas, FechaDoc, idTipoDoc, asunto, folios, remitenteext, destinatarioext, deporigenext, depdestinoext, remitenteint, destinatarioint, deporigenint, depdestinoint, numdoc, fecregistro, regpor, cargo) VALUES ($num, '$ano', $sig, '$fecdoc', $tipdoc, $asu, $fol, $perem, $pedes, $derem, $dedes, $pirem, $pides, $direm, $dides, $nu, NOW(), $idem, $car);";
                                if(mysqli_query($cone, $q)){
                                    $iddo=mysqli_insert_id($cone);

                                    $pmp=mysqli_query($cone, "SELECT pm.idtdpersonalmp FROM tdpersonalmp pm INNER JOIN tdmesapartes mp ON pm.idtdmesapartes=mp.idtdmesapartes WHERE pm.idEmpleado=$idem AND pm.idtdmesapartes=$mpd AND pm.estado=1 AND mp.estado=1;");
                                    if(mysqli_num_rows($pmp)>0){
                                        $q="INSERT INTO tdestadodoc (idDoc, idtdestado, fecha, idEmpleado, idtdmesapartes, asignador, mpasignador, estado) VALUES ($iddo, 2, NOW(), $idem, $mpd, $idem, $mpd, 1);";
                                        if(mysqli_query($cone, $q)){
                                            mysqli_commit($cone);
                                            $r['m']=mensajesu("Listo, documento registrado y recibido.<br> N° Seguimiento:<b> $nu-$ano</b>");
                                            $r['e']=true;
                                        }else{
                                            // if(mysqli_query($cone, "DELETE FROM doc WHERE idDoc=$iddo;")){
                                            //     $r['m']=mensajewa("Error al registrar estado, vuelva a intentarlo. ".$q);
                                            // }else{
                                            //     $r['m']=mensajewa("Solo se registro el documento, contacte a informática para generarle un estado.");
                                            // }
                                            mysqli_rollback($cone);
                                            $r['m']=mensajewa("Error al registrar estado, vuelva a intentarlo. ".$q);
                                        }

                                    }else{

                                        //validamos si deriva de una mesa de partes
                                        $cmmp=mysqli_query($cone, "SELECT mp.idtdmesapartes FROM tdpersonalmp pm INNER JOIN tdmesapartes mp ON pm.idtdmesapartes=mp.idtdmesapartes WHERE pm.idEmpleado=$idem AND pm.estado=1 AND mp.estado=1;");
                                        if($rmmp=mysqli_fetch_assoc($cmmp)){
                                            $mmp=vacio($rmmp['idtdmesapartes']);
                                            $dep=vacio("");
                                        }else{
                                            $mmp=vacio("");
                                            $dep=vacio(iddependenciae($cone, $_SESSION['identi']));
                                        }
                                        mysqli_free_result($cmmp);
                                        $q="INSERT INTO tdestadodoc (idDoc, idtdestado, fecha, idtdmesapartes, asignador, depasignador, mpasignador, estado) VALUES ($iddo, 3, NOW(), $mpd, $idem, $dep, $mmp, 1);";
                                        if(mysqli_query($cone, $q)){
                                            mysqli_commit($cone);
                                            $r['m']=mensajesu("Listo, documento registrado y derivado.<br> N° Seguimiento:<b> $nu-$ano</b>");
                                            $r['e']=true;
                                        }else{
                                            // if(mysqli_query($cone, "DELETE FROM doc WHERE idDoc=$iddo;")){
                                            //     $r['m']=mensajewa("Error al registrar estado, vuelva a intentarlo. ".$q);
                                            // }else{
                                            //     $r['m']=mensajewa("Solo se registro el documento, contacte a informática para generarle un estado.");
                                            // }
                                            mysqli_rollback($cone);
                                            $r['m']=mensajewa("Error al registrar estado, vuelva a intentarlo. ".$q);
                                        }

                                    }

                                }else{
                                    mysqli_rollback($cone);
                                    $r['m']=mensajewa("Error al registrar, vuelva a intentarlo.<br> $q");
                                }

            
                        } catch (Exception $e) {
                            //Si ocurre algún error, hacemos rollback
                            mysqli_rollback($cone);
                            echo "Error: ".$e->getMessage();
                        }
                }

            }else{
                $r['m']=mensajewa("Los campos marcado con <span class='text-red'>*</span> son obligatorios.");
            }
        }elseif($acc=="agrdoa"){
            if(isset($_POST['ano']) && !empty($_POST['ano']) && isset($_POST['tipdoc']) && !empty($_POST['tipdoc']) && isset($_POST['fecdoc']) && !empty($_POST['fecdoc']) && isset($_POST['fol']) && !empty($_POST['fol']) && isset($_POST['trem']) && !empty($_POST['trem']) && isset($_POST['tdes']) && !empty($_POST['tdes']) && isset($_POST['asu']) && !empty($_POST['asu']) && isset($_POST['ped']) && !empty($_POST['ped'])){

                $trem=iseguro($cone, $_POST['trem']);
                $tdes=iseguro($cone, $_POST['tdes']);
                $idem=$_SESSION['identi'];

                $exr=false;
                if($trem=='i'){
                    if(isset($_POST['pirem']) && !empty($_POST['pirem']) && isset($_POST['direm']) && !empty($_POST['direm'])){
                        $exr=true;
                        $_POST['perem']="";
                        $_POST['derem']="";
                    }else{
                        $r['m']=mensajewa("No ingreso remitente ni dependencia/institución origen interno.");
                    }
                }elseif($trem=='e'){
                    if(isset($_POST['perem']) && !empty($_POST['perem']) && isset($_POST['derem']) && !empty($_POST['derem'])){
                        $exr=true;
                        $_POST['pirem']="";
                        $_POST['direm']="";
                    }else{
                        $r['m']=mensajewa("No ingreso remitente ni dependencia/institución origen externo.");
                    }
                }
                $exd=false;
                if($tdes=='i'){
                    if(isset($_POST['pides']) && !empty($_POST['pides']) && isset($_POST['dides']) && !empty($_POST['dides'])){
                        $exd=true;
                        $_POST['pedes']="";
                        $_POST['dedes']="";
                    }else{
                        $r['m']=mensajewa("No ingreso destinatario ni dependencia/institución destino interno.");
                    }
                }elseif($tdes=='e'){
                    if(isset($_POST['pedes']) && !empty($_POST['pedes']) && isset($_POST['dedes']) && !empty($_POST['dedes'])){
                        $exd=true;
                        $_POST['pides']="";
                        $_POST['dides']="";
                    }else{
                        $r['m']=mensajewa("No ingreso destinatario ni dependencia/institución destino externo.");
                    }
                }

                if($exr && $exd){
                        $num=vacio(iseguro($cone, $_POST['num']));
                        $ano=iseguro($cone, $_POST['ano']);
                        $sig=vacio(imseguro($cone, $_POST['sig']));
                        $tipdoc=iseguro($cone, $_POST['tipdoc']);
                        $fecdoc=fmysql(iseguro($cone, $_POST['fecdoc']));
                        $fol=iseguro($cone, $_POST['fol']);
                        $asu=vacio(iseguro($cone, $_POST['asu']));
                        $pirem=$_POST['pirem']=="" ? vacio("") :  vacio(iseguro($cone, $_POST['pirem']));
                        $direm=$_POST['direm']=="" ? vacio("") :  vacio(iseguro($cone, $_POST['direm']));
                        $perem=$_POST['perem']=="" ? vacio("") :  vacio(imseguro($cone, $_POST['perem']));
                        $derem=$_POST['derem']=="" ? vacio("") :  vacio(imseguro($cone, $_POST['derem']));
                        $pides=$_POST['pides']=="" ? vacio("") :  vacio(iseguro($cone, $_POST['pides']));
                        $dides=$_POST['dides']=="" ? vacio("") :  vacio(iseguro($cone, $_POST['dides']));
                        $pedes=$_POST['pedes']=="" ? vacio("") :  vacio(imseguro($cone, $_POST['pedes']));
                        $dedes=$_POST['dedes']=="" ? vacio("") :  vacio(imseguro($cone, $_POST['dedes']));
                        $car=$_POST['car']==1 ? 1 : 0;
                        $ped=iseguro($cone, $_POST['ped']);

                        //consultamos último número doc
                        $cn=mysqli_query($cone, "SELECT MAX(numdoc) num FROM doc WHERE Ano='$ano';");
                        if($rn=mysqli_fetch_assoc($cn)){
                            if(!is_null($rn['num'])){
                                $nu=$rn['num']+1;
                            }else{
                                $nu=1;
                            }
                        }
                        mysqli_free_result($cn);

                        $cnu=mysqli_query($cone, "SELECT idDoc FROM doc WHERE numdoc=$nu AND Ano='$ano';");
                        if(mysqli_num_rows($cnu)>0){
                            $r['m']=mensajewa("Error, # de seguimiento ya registrado. Vuelva a intentarlo para generar un uno nuevo.");
                        }else{

                            $q="INSERT INTO doc (Numero, Ano, Siglas, FechaDoc, idTipoDoc, asunto, folios, remitenteext, destinatarioext, deporigenext, depdestinoext, remitenteint, destinatarioint, deporigenint, depdestinoint, numdoc, fecregistro, regpor, cargo) VALUES ($num, '$ano', $sig, '$fecdoc', $tipdoc, $asu, $fol, $perem, $pedes, $derem, $dedes, $pirem, $pides, $direm, $dides, $nu, NOW(), $idem, $car);";
                            if(mysqli_query($cone, $q)){
                                $iddo=mysqli_insert_id($cone);

                                $cmp=mysqli_query($cone, "SELECT pm.idtdmesapartes FROM tdpersonalmp pm INNER JOIN tdmesapartes mp ON pm.idtdmesapartes=mp.idtdmesapartes WHERE pm.idEmpleado=$idem AND pm.estado=1 AND mp.estado=1;");
                                if($rmp=mysqli_fetch_assoc($cmp)){
                                    $mp=$rmp['idtdmesapartes'];
                                    $dep=iddependenciae($cone, $ped);

                                    $q="INSERT INTO tdestadodoc (idDoc, idtdestado, fecha, idEmpleado, idDependencia, asignador, mpasignador, pnotificar, estado) VALUES ($iddo, 3, NOW(), $ped, $dep, $idem, $mp, 1, 1);";

                                    if(mysqli_query($cone, $q)){
                                        $r['m']=mensajesu("Listo, documento registrado y asignado.<br> N° Seguimiento:<b> $nu-$ano</b>");
                                        $r['e']=true;
                                    }else{
                                        if(mysqli_query($cone, "DELETE FROM doc WHERE idDoc=$iddo;")){
                                            $r['m']=mensajewa("Error al registrar estado, vuelva a intentarlo. ".$q);
                                        }else{
                                            $r['m']=mensajewa("Solo se registro el documento, contacte a informática para generarle un estado.");
                                        }
                                    }

                                }else{
                                    if(mysqli_query($cone, "DELETE FROM doc WHERE idDoc=$iddo;")){
                                        $r['m']=mensajewa("No pertenece a ninguna mesa de partes.");
                                    }else{
                                        $r['m']=mensajewa("Solo se registro el documento, contacte a informática para generarle un estado.");
                                    }
                                }

                            }else{
                                $r['m']=mensajewa("Error al registrar, vuelva a intentarlo.<br> $q");
                            }
                        }
                }

            }else{
                $r['m']=mensajewa("Los campos marcado con <span class='text-red'>*</span> son obligatorios.");
            }
        }elseif($acc=="edidoc"){
            if(isset($_POST['v1']) && !empty($_POST['v1']) && isset($_POST['ano']) && !empty($_POST['ano']) && isset($_POST['tipdoc']) && !empty($_POST['tipdoc']) && isset($_POST['fecdoc']) && !empty($_POST['fecdoc']) && isset($_POST['fol']) && !empty($_POST['fol']) && isset($_POST['trem']) && !empty($_POST['trem']) && isset($_POST['tdes']) && !empty($_POST['tdes']) && isset($_POST['asu']) && !empty($_POST['asu'])){

                $trem=iseguro($cone, $_POST['trem']);
                $tdes=iseguro($cone, $_POST['tdes']);

                $exr=false;
                if($trem=='i'){
                    if(isset($_POST['pirem']) && !empty($_POST['pirem']) && isset($_POST['direm']) && !empty($_POST['direm'])){
                        $exr=true;
                        $_POST['perem']="";
                        $_POST['derem']="";
                    }else{
                        $r['m']=mensajewa("No ingreso remitente ni dependencia/institución origen interno.");
                    }
                }elseif($trem=='e'){
                    if(isset($_POST['perem']) && !empty($_POST['perem']) && isset($_POST['derem']) && !empty($_POST['derem'])){
                        $exr=true;
                        $_POST['pirem']="";
                        $_POST['direm']="";
                    }else{
                        $r['m']=mensajewa("No ingreso remitente ni dependencia/institución origen externo.");
                    }
                }
                $exd=false;
                if($tdes=='i'){
                    if(isset($_POST['pides']) && !empty($_POST['pides']) && isset($_POST['dides']) && !empty($_POST['dides'])){
                        $exd=true;
                        $_POST['pedes']="";
                        $_POST['dedes']="";
                    }else{
                        $r['m']=mensajewa("No ingreso destinatario ni dependencia/institución destino interno.");
                    }
                }elseif($tdes=='e'){
                    if(isset($_POST['pedes']) && !empty($_POST['pedes']) && isset($_POST['dedes']) && !empty($_POST['dedes'])){
                        $exd=true;
                        $_POST['pides']="";
                        $_POST['dides']="";
                    }else{
                        $r['m']=mensajewa("No ingreso destinatario ni dependencia/institución destino externo.");
                    }
                }

                if($exr && $exd){
                    $v1=iseguro($cone, $_POST['v1']);
                    $num=vacio(iseguro($cone, $_POST['num']));
                    $ano=iseguro($cone, $_POST['ano']);
                    $sig=vacio(imseguro($cone, $_POST['sig']));
                    $tipdoc=iseguro($cone, $_POST['tipdoc']);
                    $fecdoc=fmysql(iseguro($cone, $_POST['fecdoc']));
                    $fol=iseguro($cone, $_POST['fol']);
                    $asu=vacio(iseguro($cone, $_POST['asu']));
                    $pirem=$_POST['pirem']=="" ? vacio("") :  vacio(iseguro($cone, $_POST['pirem']));
                    $direm=$_POST['direm']=="" ? vacio("") :  vacio(iseguro($cone, $_POST['direm']));
                    $perem=$_POST['perem']=="" ? vacio("") :  vacio(imseguro($cone, $_POST['perem']));
                    $derem=$_POST['derem']=="" ? vacio("") :  vacio(imseguro($cone, $_POST['derem']));
                    $pides=$_POST['pides']=="" ? vacio("") :  vacio(iseguro($cone, $_POST['pides']));
                    $dides=$_POST['dides']=="" ? vacio("") :  vacio(iseguro($cone, $_POST['dides']));
                    $pedes=$_POST['pedes']=="" ? vacio("") :  vacio(imseguro($cone, $_POST['pedes']));
                    $dedes=$_POST['dedes']=="" ? vacio("") :  vacio(imseguro($cone, $_POST['dedes']));
                    //$car=0;
                    $aan=iseguro($cone, $_POST['aan']);
                    $nd=iseguro($cone, $_POST['nd']);
                    
                    $nn=$nd;
                    if($ano!=$aan){
                        $cn=mysqli_query($cone, "SELECT MAX(numdoc) nd FROM doc WHERE Ano=$ano;");
                        if($rn=mysqli_fetch_assoc($cn)){
                            $nn=$rn['nd']+1;
                        }else{
                            $nn=0;
                        }
                        mysqli_free_result($cn);
                        $tn=", numdoc='$nn'";
                    }else{
                        $tn="";
                    }

                    if(mysqli_query($cone, "UPDATE doc SET Numero=$num, Ano='$ano', Siglas=$sig, FechaDoc='$fecdoc', idTipoDoc=$tipdoc, asunto=$asu, folios=$fol, remitenteext=$perem, destinatarioext=$pedes, deporigenext=$derem, depdestinoext=$dedes, remitenteint=$pirem, destinatarioint=$pides, deporigenint=$direm, depdestinoint=$dides $tn WHERE idDoc=$v1;")){
                        $r['m']=mensajesu("Listo, documento editado.<br># de Seguimiento: $nn");
                        $r['e']=true;
                    }else{
                        $r['m']=mensajewa("Error al editar, vuelva a intentarlo.");
                    }
                }

            }else{
                $r['m']=mensajewa("Los campos marcado con <span class='text-red'>*</span> son obligatorios.");
            }
        }elseif($acc=="elidoc"){
            if(isset($_POST['v1']) && !empty($_POST['v1'])){
                $v1=iseguro($cone, $_POST['v1']);
                if(mysqli_query($cone, "DELETE FROM tdestadodoc WHERE idDoc=$v1;")){
                    if(mysqli_query($cone, "DELETE FROM doc WHERE idDoc=$v1;")){
                        $r['e']=true;
                        $r['m']=mensajesu("Documento eliminado.");
                    }else{
                        $r['m']=mensajewa("Error, no se pudo eliminar el documento.");
                    }
                }else{
                    $r['m']=mensajewa("Error, no se pudo eliminar su estado.");
                }
            }else{
                $r['m']=mensajewa("Los campos marcado con <span class='text-red'>*</span> son obligatorios.");
            }
        }elseif($acc=="revdoc"){
            if(isset($_POST['v1']) && !empty($_POST['v1']) && isset($_POST['v2']) && !empty($_POST['v2']) && isset($_POST['obs']) && !empty($_POST['obs'])){
                $v1=iseguro($cone, $_POST['v1']);
                $v2=iseguro($cone, $_POST['v2']);
                $obs=iseguro($cone, $_POST['obs']);
                $idem1=$_SESSION['identi'];

                $ce=mysqli_query($cone, "SELECT idtdestadodoc FROM tdestadodoc WHERE idDoc=$v1 AND estado=1;");
                if($re=mysqli_fetch_assoc($ce)){
                    if($re['idtdestadodoc']==$v2){
                        $idue=$re['idtdestadodoc'];
                        $co=mysqli_query($cone, "SELECT idEmpleado, idDependencia FROM tdestadodoc WHERE idDoc=$v1 AND idtdestadodoc<$idue ORDER BY idtdestadodoc DESC LIMIT 1;");
                        if($ro=mysqli_fetch_assoc($co)){
                            $idem=$ro['idEmpleado'];
                            $dep=$ro['idDependencia'];

                            if(mysqli_query($cone, "INSERT INTO tdestadodoc (idtdestado, fecha, observacion, idDependencia, idEmpleado, idDoc, estado) VALUES (8, DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i:%s'), '$obs',$dep, $idem, $v1, 1);")){
                                $idne=mysqli_insert_id($cone);
                                if(mysqli_query($cone, "UPDATE tdestadodoc SET estado=0, responsablemp=$idem1 WHERE idDoc=$v1 AND idtdestadodoc=$idue;")){
                                    $r['m']=mensajesu("¡Listo! Documento revertido.");
                                    $r['e']=true;

                                }else{
                                    if(mysqli_query($cone, "DELETE FROM tdestadodoc WHERE idtdestadodoc=$idne;")){
                                        $r['m']=mensajewa("Error al revertir, vuelva a intentarlo.");
                                    }else{
                                        $r['m']=mensajewa("Error $v1 al revertir, reporte al administrador del sistema.");
                                    }
                                }
                            }else{
                                $r['m']=mensajewa("Error al revertir, vuelva a intentarlo.");
                            }
                        }else{
                            $r['m']=mensajewa('Error $v1, reporte al administrador del sistema.');
                        }
                    }else{
                        $r['m']=mensajesu('El documento ya tiene otro estado.');
                        $r['e']=true;
                    }
                }else{
                    $r['m']=mensajewa('Error $v1, reporte al administrador del sistema.');
                }

            }else{
                $r['m']=mensajewa("Ingrese en observación el motivo por el cual revierte.");
            }
        }elseif($acc=="dermpa"){
            if(isset($_POST['v1']) && !empty($_POST['v1']) && isset($_POST['v2']) && !empty($_POST['v2']) && isset($_POST['v3']) && !empty($_POST['v3'])){
                $v1=iseguro($cone, $_POST['v1']);
                $v2=iseguro($cone, $_POST['v2']);
                $v3=iseguro($cone, $_POST['v3']);
                $idem=$_SESSION['identi'];

                $ce=mysqli_query($cone, "SELECT idtdestadodoc FROM tdestadodoc WHERE idDoc=$v1 AND estado=1;");
                if($re=mysqli_fetch_assoc($ce)){
                    if($re['idtdestadodoc']==$v2){
                        $idue=$re['idtdestadodoc'];

                        //obtenemos la mp
                        $cmp=mysqli_query($cone, "SELECT mp.idtdmesapartes FROM tdpersonalmp p INNER JOIN tdmesapartes mp ON p.idtdmesapartes=mp.idtdmesapartes WHERE p.idEmpleado=$idem AND p.estado=1 AND mp.estado=1;");
                        if($rmp=mysqli_fetch_assoc($cmp)){
                            $mp=$rmp['idtdmesapartes'];
                            $dep=vacio("");
                        }else{
                            $mp=vacio("");
                            $dep=iddependenciae($cone, $idem);
                        }

                        $q="INSERT INTO tdestadodoc (idDoc, idtdestado, fecha, idtdmesapartes, asignador, mpasignador, depasignador, estado) VALUES ($v1, 3, NOW(), $v3, $idem, $mp, $dep, 1);";
                        if(mysqli_query($cone, $q)){
                            $idne=mysqli_insert_id($cone);
                            if(mysqli_query($cone, "UPDATE tdestadodoc SET estado=0 WHERE idDoc=$v1 AND idtdestadodoc=$idue;")){
                                $r['m']="¡Listo! Documento derivado a Mesa de Partes.";
                                $r['e']=true;
                            }else{
                                if(mysqli_query($cone, "DELETE FROM tdestadodoc WHERE idtdestadodoc=$idne;")){
                                    $r['m']="Error al derivar, vuelva a intentarlo. 1";
                                }else{
                                    $r['m']="Error al derivar, contacte al administrador del sistema.";
                                }
                            }
                        }else{
                            $r['m']="Error al derivar, vuelva a intentarlo. 2 $q";
                        }
                    }else{
                        $r['m']='El documento ya tiene otro estado. ¡Actualice!';
                        $r['e']=true;
                    }
                }else{
                    $r['m']='Error, datos erroneos del documento.';
                }
            }else{
                $r['m']="Faltan datos.";
            }
        }elseif($acc=="recdoc"){
            if(isset($_POST['v1']) && !empty($_POST['v1']) && isset($_POST['v2']) && !empty($_POST['v2'])){
                $v1=iseguro($cone, $_POST['v1']);
                $v2=iseguro($cone, $_POST['v2']);
                $mp=iseguro($cone, $_POST['mp']);
                $idem=$_SESSION['identi'];
                

                $ce=mysqli_query($cone, "SELECT idtdestadodoc, pnotificar FROM tdestadodoc WHERE idDoc=$v1 AND estado=1;");
                if($re=mysqli_fetch_assoc($ce)){
                    if($re['idtdestadodoc']==$v2){
                        $idue=$re['idtdestadodoc'];

                        if($mp!=0){
                            $dep=vacio("");
                        }else{
                            $mp=vacio("");
                            $dep=iddependenciae($cone, $_SESSION['identi']);
                        }
                        if($re['pnotificar']==1){
                            $pn=1;
                        }else{
                            $pn=vacio("");
                        }


                        if(mysqli_query($cone, "INSERT INTO tdestadodoc (idDoc, idtdestado, fecha, idEmpleado, idDependencia, idtdmesapartes, asignador, mpasignador, depasignador, estado, pnotificar) VALUES ($v1, 2, NOW(), $idem, $dep, $mp, $idem, $mp, $dep, 1, $pn);")){
                            $idne=mysqli_insert_id($cone);
                            if(mysqli_query($cone, "UPDATE tdestadodoc SET estado=0 WHERE idDoc=$v1 AND idtdestadodoc=$idue;")){
                                $r['m']="¡Listo! Documento recibido.";
                                $r['e']=true;
                            }else{
                                if(mysqli_query($cone, "DELETE FROM tdestadodoc WHERE idtdestadodoc=$idne;")){
                                    $r['m']="Error al recibir, vuelva a intentarlo.";
                                }else{
                                    $r['m']="Error al recibir, reporte al administrador del sistema.";
                                }
                            }
                        }else{
                            $r['m']="Error al recibir, vuelva a intentarlo.";
                        }
                    }else{
                        $r['m']='El documento ya tiene otro estado.';
                        $r['e']=true;
                    }
                }else{
                    $r['m']='Error, datos erroneos del documento.';
                }

            }else{
                $r['m']="Faltan datos.";
            }
        }elseif($acc=="envgn"){
            if(isset($_POST['v1']) && !empty($_POST['v1']) && isset($_POST['v2']) && !empty($_POST['v2'])){
                $v1=iseguro($cone, $_POST['v1']); //idDoc
                $v2=iseguro($cone, $_POST['v2']); //idtdestadodoc
                $mp=iseguro($cone, $_POST['mp']);
                $idem=$_SESSION['identi'];
                

                $ce=mysqli_query($cone, "SELECT idtdestadodoc FROM tdestadodoc WHERE idDoc=$v1 AND estado=1;");
                if($re=mysqli_fetch_assoc($ce)){
                    if($re['idtdestadodoc']==$v2){
                        $idue=$re['idtdestadodoc'];

                        if($mp!=0){
                            $dep=vacio("");
                        }else{
                            $mp=vacio("");
                            $dep=iddependenciae($cone, $_SESSION['identi']);
                        }

                        if(mysqli_query($cone, "INSERT INTO tdestadodoc (idDoc, idtdestado, fecha, idEmpleado, idDependencia, idtdmesapartes, asignador, mpasignador, depasignador, estado) VALUES ($v1, 6, NOW(), $idem, $dep, $mp, $idem, $mp, $dep, 1);")){
                            $idne=mysqli_insert_id($cone);
                            if(mysqli_query($cone, "UPDATE tdestadodoc SET estado=0 WHERE idDoc=$v1 AND idtdestadodoc=$idue;")){
                                $r['m']="¡Listo! Documento enviado al Generador de Notificaciones.";
                                $r['e']=true;
                            }else{
                                if(mysqli_query($cone, "DELETE FROM tdestadodoc WHERE idtdestadodoc=$idne;")){
                                    $r['m']="Error al enviar, vuelva a intentarlo.";
                                }else{
                                    $r['m']="Error al enviar, reporte al administrador del sistema.";
                                }
                            }
                        }else{
                            $r['m']="Error al enviar, vuelva a intentarlo.";
                        }
                    }else{
                        $r['m']='El documento ya tiene otro estado.';
                        $r['e']=true;
                    }
                }else{
                    $r['m']='Error, datos erroneos del documento.';
                }

            }else{
                $r['m']="Faltan datos.";
            }
        }elseif($acc=="dernot"){
            if(isset($_POST['v1']) && !empty($_POST['v1']) && isset($_POST['v2']) && !empty($_POST['v2']) && isset($_POST['v3']) && !empty($_POST['v3'])){
                $v1=iseguro($cone, $_POST['v1']);
                $v2=iseguro($cone, $_POST['v2']);
                $v3=iseguro($cone, $_POST['v3']);
                $dep=iddependenciae($cone, $v3);
                $idem=$_SESSION['identi'];

                $ce=mysqli_query($cone, "SELECT idtdestadodoc FROM tdestadodoc WHERE idDoc=$v1 AND estado=1;");
                if($re=mysqli_fetch_assoc($ce)){
                    if($re['idtdestadodoc']==$v2){
                        $idue=$re['idtdestadodoc'];

                        //obtenemos la mp
                        $cmp=mysqli_query($cone, "SELECT mp.idtdmesapartes FROM tdpersonalmp p INNER JOIN tdmesapartes mp ON p.idtdmesapartes=mp.idtdmesapartes WHERE p.idEmpleado=$idem AND p.estado=1 AND mp.estado=1;");
                        if($rmp=mysqli_fetch_assoc($cmp)){
                            $mp=$rmp['idtdmesapartes'];
                        }

                        if(mysqli_query($cone, "INSERT INTO tdestadodoc (idDoc, idtdestado, fecha, idEmpleado, idDependencia, asignador, mpasignador, pnotificar, estado) VALUES ($v1, 3, NOW(), $v3, $dep, $idem, $mp, 1, 1);")){
                            $idne=mysqli_insert_id($cone);
                            if(mysqli_query($cone, "UPDATE tdestadodoc SET estado=0 WHERE idDoc=$v1 AND idtdestadodoc=$idue;")){
                                $r['m']="¡Listo! Documento derivado para notificar.";
                                $r['e']=true;
                            }else{
                                if(mysqli_query($cone, "DELETE FROM tdestadodoc WHERE idtdestadodoc=$idne;")){
                                    $r['m']="Error al derivar, vuelva a intentarlo.";
                                }else{
                                    $r['m']="Error al derivar, reporte al administrador del sistema.";
                                }
                            }
                        }else{
                            $r['m']="Error al derivar, vuelva a intentarlo.";
                        }
                    }else{
                        $r['m']='El documento ya tiene otro estado. ¡Actualice!';
                        $r['e']=true;
                    }
                }else{
                    $r['m']='Error, datos erroneos del documento.';
                }

            }else{
                $r['m']="Faltan datos.";
            }
        }elseif($acc=="repdoc"){
            if(isset($_POST['v1']) && !empty($_POST['v1']) && isset($_POST['v2']) && !empty($_POST['v2']) && isset($_POST['not']) && !empty($_POST['not']) && isset($_POST['mnot']) && !empty($_POST['mnot']) && isset($_POST['fnot']) && !empty($_POST['fnot'])){
                $v1=iseguro($cone, $_POST['v1']);
                $v2=iseguro($cone, $_POST['v2']);
                $not=iseguro($cone, $_POST['not']);
                $mnot=iseguro($cone, $_POST['mnot']);
                $fnot=fmysql(iseguro($cone, $_POST['fnot']));
                $obs=vacio(iseguro($cone, $_POST['obs']));
                $idem=$_SESSION['identi'];
                $dep=iddependenciae($cone, $idem);

                $ce=mysqli_query($cone, "SELECT idtdestadodoc FROM tdestadodoc WHERE idDoc=$v1 AND estado=1;");
                if($re=mysqli_fetch_assoc($ce)){
                    if($re['idtdestadodoc']==$v2){
                        $idue=$re['idtdestadodoc'];
                        if(mysqli_query($cone, "INSERT INTO tdestadodoc (idDoc, idtdestado, fecha, idEmpleado, idDependencia, asignador, depasignador, idtdmodnotificacion, estnotificacion, fecnotificacion, observacion, estado) VALUES ($v1, 5, NOW(), $idem, $dep, $idem, $dep, $mnot, $not, '$fnot', $obs, 1);")){
                            $idne=mysqli_insert_id($cone);
                            if(mysqli_query($cone, "UPDATE tdestadodoc SET estado=0 WHERE idDoc=$v1 AND idtdestadodoc=$idue;")){
                                $r['m']=mensajesu("¡Listo! Se reportó notificación.");
                                $r['e']=true;
                                $r['do']=$v1;
                                $r['es']=$idne;
                                if(mysqli_query($cone, "UPDATE doc SET cargo=1 WHERE idDoc=$v1")){
                                    $r['m'].=mensajesu("Regrese el cargo.");
                                }
                            }else{
                                if(mysqli_query($cone, "DELETE FROM tdestadodoc WHERE idtdestadodoc=$idne;")){
                                    $r['m']=mensajewa("Error al reportar, vuelva a intentarlo.");
                                }else{
                                    $r['m']=mensajewa("Error $v1 al reportar, reporte al administrador del sistema.");
                                }
                            }
                        }else{
                            $r['m']=mensajewa("Error al reportar, vuelva a intentarlo.");
                        }
                    }else{
                        $r['m']=mensajesu('El documento ya tiene otro estado. ¡Actualice!');
                        $r['e']=true;
                    }
                }else{
                    $r['m']=mensajewa('Error, datos erroneos del documento.');
                }

            }else{
                $r['m']=mensajewa("Los campos marcados con <span class='text-red'>*</span> son obligatorios.");
            }
        }elseif($acc=="atedoc"){
            if(isset($_POST['v1']) && !empty($_POST['v1']) && isset($_POST['v2']) && !empty($_POST['v2']) && isset($_POST['obs']) && !empty($_POST['obs'])){
                $v1=iseguro($cone, $_POST['v1']);
                $v2=iseguro($cone, $_POST['v2']);
                $obs=iseguro($cone, $_POST['obs']);
                $idem=$_SESSION['identi'];
                $dep=iddependenciae($cone, $idem);

                $ce=mysqli_query($cone, "SELECT idtdestadodoc FROM tdestadodoc WHERE idDoc=$v1 AND estado=1;");
                if($re=mysqli_fetch_assoc($ce)){
                    if($re['idtdestadodoc']==$v2){
                        $idue=$re['idtdestadodoc'];
                        if(mysqli_query($cone, "INSERT INTO tdestadodoc (idDoc, idtdestado, fecha, idEmpleado, idDependencia, asignador, depasignador, observacion, estado) VALUES ($v1, 4, NOW(), $idem, $dep, $idem, $dep, '$obs', 1);")){
                            $idne=mysqli_insert_id($cone);
                            if(mysqli_query($cone, "UPDATE tdestadodoc SET estado=0 WHERE idDoc=$v1 AND idtdestadodoc=$idue;")){
                                $r['m']=mensajesu("¡Listo! Documento atendido.");
                                $r['e']=true;
                            }else{
                                if(mysqli_query($cone, "DELETE FROM tdestadodoc WHERE idtdestadodoc=$idne;")){
                                    $r['m']=mensajewa("Error al registrar atención, vuelva a intentarlo.");
                                }else{
                                    $r['m']=mensajewa("Error $v1 al registrar atención, reporte al administrador del sistema.");
                                }
                            }
                        }else{
                            $r['m']=mensajewa("Error al atender, vuelva a intentarlo.");
                        }
                    }else{
                        $r['m']=mensajesu('El documento ya tiene otro estado. !Actualice!');
                        $r['e']=true;
                    }
                }else{
                    $r['m']=mensajewa('Error, datos erroneos del documento.');
                }

            }else{
                $r['m']=mensajewa("Ingrese en observación algún detalle relevante de la atención.");
            }
        }elseif($acc=="arcdoc"){
            if(isset($_POST['v1']) && !empty($_POST['v1']) && isset($_POST['v2']) && !empty($_POST['v2']) && isset($_POST['obs']) && !empty($_POST['obs'])){
                $v1=iseguro($cone, $_POST['v1']);
                $v2=iseguro($cone, $_POST['v2']);
                $obs=iseguro($cone, $_POST['obs']);
                $idem=$_SESSION['identi'];
                $dep=iddependenciae($cone, $idem);

                $ce=mysqli_query($cone, "SELECT idtdestadodoc FROM tdestadodoc WHERE idDoc=$v1 AND estado=1;");
                if($re=mysqli_fetch_assoc($ce)){
                    if($re['idtdestadodoc']==$v2){
                        $idue=$re['idtdestadodoc'];
                        if(mysqli_query($cone, "INSERT INTO tdestadodoc (idtdestado, fecha, observacion, idDependencia, idEmpleado, idDoc, estado) VALUES (7, DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i:%s'), '$obs',$dep, $idem, $v1, 1);")){
                            $idne=mysqli_insert_id($cone);
                            if(mysqli_query($cone, "UPDATE tdestadodoc SET estado=0 WHERE idDoc=$v1 AND idtdestadodoc=$idue;")){
                                $r['m']=mensajesu("¡Listo! Documento archivado.");
                                $r['e']=true;

                            }else{
                                if(mysqli_query($cone, "DELETE FROM tdestadodoc WHERE idtdestadodoc=$idne;")){
                                    $r['m']=mensajewa("Error al archivar, vuelva a intentarlo.");
                                }else{
                                    $r['m']=mensajewa("Error $v1 al archivar, reporte al administrador del sistema.");
                                }
                            }
                        }else{
                            $r['m']=mensajewa("Error al archivar, vuelva a intentarlo.");
                        }
                    }else{
                        $r['m']=mensajesu('El documento ya tiene otro estado.');
                        $r['e']=true;
                    }
                }else{
                    $r['m']=mensajewa('Error $v1, reporte al administrador del sistema.');
                }

            }else{
                $r['m']=mensajewa("Ingrese en observación el motivo para archivar.");
            }
        }elseif($acc=="gengui"){
            if(isset($_POST['v1']) && !empty($_POST['v1']) && isset($_POST['mpdes']) && !empty($_POST['mpdes'])){
                $v1=iseguro($cone, $_POST['v1']);
                $mpdes=iseguro($cone, $_POST['mpdes']);
                $idem=$_SESSION['identi'];
                $dep=iddependenciae($cone, $idem);

                $cd=mysqli_query($cone, "SELECT idtdestadodoc FROM tdestadodoc WHERE ISNULL(idtdguia) AND idtdmesapartes=$mpdes AND idtdestado=3 AND estado=1 AND mpasignador=$v1;");
                if(mysqli_num_rows($cd)>0){
                    $cng=mysqli_query($cone, "SELECT MAX(numero) num FROM tdguia WHERE idtdmesapartesg=$v1 AND anio=YEAR(CURDATE())");
                    if($rng=mysqli_fetch_assoc($cng)){
                        $ng=$rng['num']+1;
                    }else{
                        $ng=1;
                    }
                    mysqli_free_result($cng);
                    //generamos la guía
                    if(mysqli_query($cone, "INSERT INTO tdguia (numero, anio, fecenvio, estado, idtdmesapartesg, idtdmesapartesd, generador) VALUES ($ng, YEAR(CURDATE()), CURDATE(), 1, $v1, $mpdes, $idem);")){
                        $idg=mysqli_insert_id($cone);
                        if(mysqli_query($cone, "UPDATE tdestadodoc SET idtdguia=$idg WHERE ISNULL(idtdguia) AND idtdmesapartes=$mpdes AND idtdestado=3 AND estado=1 AND mpasignador=$v1;")){
                            $r['m']=mensajesu("Guía generada.");
                            $r['e']=true;
                        }else{
                            $r['m']=mensajewa("Guía creada sin documentos.");
                        }
                    }else{
                        $r['m']=mensajewa("No se pudo crear la guía.");
                    }
                }else{
                    $r['m']=mensajewa("Los documentos ya fueron incluidos en otra guía.");
                }
                mysqli_free_result($cd);
            }else{
                $r['m']=mensajewa("Elija un destino.");
            }
        }elseif($acc=="dermpp"){
            if(isset($_POST['v1']) && !empty($_POST['v1']) && isset($_POST['v2']) && !empty($_POST['v2']) && isset($_POST['per']) && !empty($_POST['per']) && isset($_POST['pro']) && !empty($_POST['pro']) && isset($_POST['imp']) && !empty($_POST['imp'])){
                $v1=iseguro($cone, $_POST['v1']);
                $v2=iseguro($cone, $_POST['v2']);
                $per=iseguro($cone, $_POST['per']);
                $pro=iseguro($cone, $_POST['pro']);
                $obs=vacio(iseguro($cone, $_POST['obs']));
                $imp=iseguro($cone, $_POST['imp']);

                $idem=$_SESSION['identi'];
                $dep=iddependenciae($cone, $idem);

                


                $ce=mysqli_query($cone, "SELECT idtdestadodoc FROM tdestadodoc WHERE idDoc=$v1 AND estado=1;");
                if($re=mysqli_fetch_assoc($ce)){
                    if($re['idtdestadodoc']==$v2){
                        $idue=$re['idtdestadodoc'];
                        if(mysqli_query($cone, "INSERT INTO tdestadodoc (idDoc, idtdestado, fecha, idtdmesapartes, asignador, depasignador, idtdproveido, observacion, estado, cppara) VALUES ($v1, 3, NOW(), $imp, $idem, $dep, $pro, $obs, 1, $per);")){
                            $idne=mysqli_insert_id($cone);
                            if(mysqli_query($cone, "UPDATE tdestadodoc SET estado=0 WHERE idDoc=$v1 AND idtdestadodoc=$idue;")){
                                $r['m']=mensajesu("¡Listo! Documento derivado a mesa de partes.");
                                $r['e']=true;

                            }else{
                                if(mysqli_query($cone, "DELETE FROM tdestadodoc WHERE idtdestadodoc=$idne;")){
                                    $r['m']=mensajewa("Error al derivar, vuelva a intentarlo.");
                                }else{
                                    $r['m']=mensajewa("Error $v1 al derivar, reporte al administrador del sistema.");
                                }
                            }
                        }else{
                            $r['m']=mensajewa("Error al derivar, vuelva a intentarlo.");
                        }
                    }else{
                        $r['m']=mensajesu('El documento ya tiene otro estado. ¡Actualice!');
                        $r['e']=true;
                    }
                }else{
                    $r['m']=mensajewa('Error $v1, reporte al administrador del sistema.');
                }

            }else{
                $r['m']=mensajewa("Los campos marcados con <span class='text-red'>*</span> son obligatorios.");
            }
        }elseif($acc=="derper1"){
            if(isset($_POST['v1']) && !empty($_POST['v1']) && isset($_POST['v2']) && !empty($_POST['v2']) && isset($_POST['v3']) && !empty($_POST['v3'])){
                $v1=iseguro($cone, $_POST['v1']);
                $v2=iseguro($cone, $_POST['v2']);
                $v3=iseguro($cone, $_POST['v3']);
                $dep=iddependenciae($cone, $v3);
                $idem=$_SESSION['identi'];

                $ce=mysqli_query($cone, "SELECT idtdestadodoc FROM tdestadodoc WHERE idDoc=$v1 AND estado=1;");
                if($re=mysqli_fetch_assoc($ce)){
                    if($re['idtdestadodoc']==$v2){
                        $idue=$re['idtdestadodoc'];

                        //obtenemos la mp
                        $cmp=mysqli_query($cone, "SELECT mp.idtdmesapartes FROM tdpersonalmp p INNER JOIN tdmesapartes mp ON p.idtdmesapartes=mp.idtdmesapartes WHERE p.idEmpleado=$idem AND p.estado=1 AND mp.estado=1;");
                        if($rmp=mysqli_fetch_assoc($cmp)){
                            $mp=$rmp['idtdmesapartes'];
                            $depa=vacio(null);
                        }else{
                            $mp=vacio(null);
                            $depa=iddependenciae($cone, $idem);
                        }

                        if(mysqli_query($cone, "INSERT INTO tdestadodoc (idDoc, idtdestado, fecha, idEmpleado, idDependencia, asignador, mpasignador, depasignador, estado) VALUES ($v1, 3, NOW(), $v3, $dep, $idem, $mp, $depa, 1);")){
                            $idne=mysqli_insert_id($cone);
                            if(mysqli_query($cone, "UPDATE tdestadodoc SET estado=0 WHERE idDoc=$v1 AND idtdestadodoc=$idue;")){
                                $r['m']="¡Listo! Documento derivado.";
                                $r['e']=true;
                            }else{
                                if(mysqli_query($cone, "DELETE FROM tdestadodoc WHERE idtdestadodoc=$idne;")){
                                    $r['m']="Error al derivar, vuelva a intentarlo.";
                                }else{
                                    $r['m']="Error al derivar, reporte al administrador del sistema.";
                                }
                            }
                        }else{
                            $r['m']="Error al derivar, vuelva a intentarlo.";
                        }
                    }else{
                        $r['m']='El documento ya tiene otro estado. ¡Actualice!';
                        $r['e']=true;
                    }
                }else{
                    $r['m']='Error, datos erroneos del documento.';
                }

            }else{
                $r['m']="Faltan datos.";
            }
        }elseif($acc=="derrep"){
            if(isset($_POST['v1']) && !empty($_POST['v1']) && isset($_POST['v2']) && !empty($_POST['v2']) && isset($_POST['des']) && !empty($_POST['des'])){
                $v1=iseguro($cone, $_POST['v1']);
                $v2=iseguro($cone, $_POST['v2']);
                $des=iseguro($cone, $_POST['des']);
                $idem=$_SESSION['identi'];

                if($des==1){
                    if(isset($_POST['mpa']) && !empty($_POST['mpa'])){
                        $mpa=iseguro($cone, $_POST['mpa']);

                        $ce=mysqli_query($cone, "SELECT idtdestadodoc FROM tdestadodoc WHERE idDoc=$v1 AND estado=1;");
                        if($re=mysqli_fetch_assoc($ce)){
                            if($re['idtdestadodoc']==$v2){
                                $idue=$re['idtdestadodoc'];

                                $cmp=mysqli_query($cone, "SELECT idtdmesapartes FROM tdpersonalmp WHERE idEmpleado=$idem AND estado=1;");
                                if($rmp=mysqli_fetch_assoc($cmp)){
                                    $dep=vacio('');
                                    $mpas=$rmp['idtdmesapartes'];
                                }else{
                                    $dep=iddependenciae($cone, $idem);
                                    $mpas=vacio('');
                                }
                                mysqli_free_result($cmp);

                                if(mysqli_query($cone, "INSERT INTO tdestadodoc (idDoc, idtdestado, fecha, idtdmesapartes, asignador, mpasignador, depasignador, estado) VALUES ($v1, 3, NOW(), $mpa, $idem, $mpas, $dep, 1);")){
                                    $idne=mysqli_insert_id($cone);
                                    if(mysqli_query($cone, "UPDATE tdestadodoc SET estado=0 WHERE idDoc=$v1 AND idtdestadodoc=$idue;")){
                                        $r['m']=mensajesu("¡Listo! Documento derivado.");
                                        $r['e']=true;
                                    }else{
                                        if(mysqli_query($cone, "DELETE FROM tdestadodoc WHERE idtdestadodoc=$idne;")){
                                            $r['m']=mensajewa("Error al derivar, vuelva a intentarlo.");
                                        }else{
                                            $r['m']=mensajewa("Error al derivar, reporte al administrador del sistema.");
                                        }
                                    }
                                }else{
                                    $r['m']=mensajewa("Error al derivar, vuelva a intentarlo.");
                                }
                            }else{
                                $r['m']=mensajewa('El documento ya tiene otro estado. ¡Actualice!');
                                $r['e']=true;
                            }
                        }else{
                            $r['m']=mensajewa('Error, datos erroneos del documento.');
                        }
                    }else{
                        $r['m']=mensajewa("Los campos marcados con <span class='text-red'>*</span> son obligatorios.");
                    }

                }elseif($des==2){

                    if(isset($_POST['per']) && !empty($_POST['per'])){
                        $per=iseguro($cone, $_POST['per']);
                        $dep=iddependenciae($cone, $per);
                        $depa=iddependenciae($cone, $idem);
                        $ce=mysqli_query($cone, "SELECT idtdestadodoc FROM tdestadodoc WHERE idDoc=$v1 AND estado=1;");
                        if($re=mysqli_fetch_assoc($ce)){
                            if($re['idtdestadodoc']==$v2){
                                $idue=$re['idtdestadodoc'];

                                if(mysqli_query($cone, "INSERT INTO tdestadodoc (idDoc, idtdestado, fecha, idEmpleado, idDependencia, asignador, depasignador, estado) VALUES ($v1, 3, NOW(), $per, $dep, $idem, $depa, 1);")){
                                    $idne=mysqli_insert_id($cone);
                                    if(mysqli_query($cone, "UPDATE tdestadodoc SET estado=0 WHERE idDoc=$v1 AND idtdestadodoc=$idue;")){
                                        $r['m']=mensajesu("¡Listo! Documento derivado.");
                                        $r['e']=true;
                                    }else{
                                        if(mysqli_query($cone, "DELETE FROM tdestadodoc WHERE idtdestadodoc=$idne;")){
                                            $r['m']=mensajewa("Error al derivar, vuelva a intentarlo.");
                                        }else{
                                            $r['m']=mensajewa("Error al derivar, reporte al administrador del sistema.");
                                        }
                                    }
                                }else{
                                    $r['m']=mensajewa("Error al derivar, vuelva a intentarlo.");
                                }
                            }else{
                                $r['m']=mensajewa('El documento ya tiene otro estado. ¡Actualice!');
                                $r['e']=true;
                            }
                        }else{
                            $r['m']=mensajewa('Error, datos erroneos del documento.');
                        }
                    }else{
                        $r['m']=mensajewa("Los campos marcados con <span class='text-red'>*</span> son obligatorios.");
                    }

                }

            }else{
                $r['m']=mensajewa("Los campos marcados con <span class='text-red'>*</span> son obligatorios.");
            }
        }elseif($acc=="cammp"){
            if(isset($_POST['v1']) && !empty($_POST['v1']) && isset($_POST['v2']) && !empty($_POST['v2']) && isset($_POST['mpd']) && !empty($_POST['mpd'])){
                $v1=iseguro($cone, $_POST['v1']);
                $v2=iseguro($cone, $_POST['v2']);
                $mpd=iseguro($cone, $_POST['mpd']);
                $idem=$_SESSION['identi'];
                $dep=iddependenciae($cone, $idem);

                $ce=mysqli_query($cone, "SELECT idtdestadodoc FROM tdestadodoc WHERE idDoc=$v1 AND estado=1;");
                if($re=mysqli_fetch_assoc($ce)){
                    if($re['idtdestadodoc']==$v2){
                        if(mysqli_query($cone, "UPDATE tdestadodoc SET idtdmesapartes=$mpd WHERE idtdestadodoc=$v2;")){
                            $r['m']=mensajesu("¡Listo! se cambió la mesa de partes.");
                            $r['e']=true;
                        }else{
                            $r['m']=mensajewa("Error al cambiar de mesa de partes, vuelva a intentarlo.");
                        }
                    }else{
                        $r['m']=mensajesu('El documento ya tiene otro estado. !Actualice!');
                        $r['e']=true;
                    }
                }else{
                    $r['m']=mensajewa('Error, datos erroneos del documento.');
                }

            }else{
                $r['m']=mensajewa("Ingrese la mesa de partes.");
            }
        }elseif($acc=="crecar"){
            if(isset($_POST['v1']) && !empty($_POST['v1'])){
                $idd=iseguro($cone, $_POST['v1']);
                $idem=$_SESSION['identi'];
                $dep=iddependenciae($cone, $idem);

                $cd=mysqli_query($cone, "SELECT Numero, Ano, Siglas, FechaDoc, idTipoDoc, remitenteext, destinatarioext, deporigenext, depdestinoext, remitenteint, destinatarioint, deporigenint, depdestinoint, asunto FROM doc WHERE idDoc=$idd;");
                if($rd=mysqli_fetch_assoc($cd)){
                    $numero=vacio($rd['Numero']);
                    $ano=$rd['Ano'];
                    $siglas=vacio($rd['Siglas']);
                    $fechadoc=$rd['FechaDoc'];
                    $idtipodoc=$rd['idTipoDoc'];
                    $remitenteext=vacio($rd['remitenteext']);
                    $destinatarioext=vacio($rd['destinatarioext']);
                    $deporigenext=vacio($rd['deporigenext']);
                    $depdestinoext=vacio($rd['depdestinoext']);
                    $remitenteint=vacio($rd['remitenteint']);
                    $destinatarioint=vacio($rd['destinatarioint']);
                    $deporigenint=vacio($rd['deporigenint']);
                    $depdestinoint=vacio($rd['depdestinoint']);
                    $asunto=$rd['asunto'];

                    //consultamos último número doc
                    $cn=mysqli_query($cone, "SELECT MAX(numdoc) num FROM doc WHERE Ano='$ano';");
                    if($rn=mysqli_fetch_assoc($cn)){
                        if(!is_null($rn['num'])){
                            $nu=$rn['num']+1;
                        }else{
                            $nu=1;
                        }
                    }
                    mysqli_free_result($cn);

                    $cnu=mysqli_query($cone, "SELECT idDoc FROM doc WHERE numdoc=$nu AND Ano='$ano';");
                    if(mysqli_num_rows($cnu)>0){
                        $r['m']=mensajewa("Error, # de seguimiento ya registrado. Vuelva a intentarlo para generar un uno nuevo.");
                    }else{
                        //ingresamos doc
                        if(mysqli_query($cone, "INSERT INTO doc (Numero, Ano, Siglas, FechaDoc, idTipoDoc, folios, remitenteext, destinatarioext, deporigenext, depdestinoext, cargo, remitenteint, destinatarioint, deporigenint, depdestinoint, numdoc, asunto, fecregistro, regpor, idDocRel) VALUES ($numero, '$ano', $siglas, '$fechadoc', $idtipodoc, 1, $remitenteext, $destinatarioext, $deporigenext, $depdestinoext, 1, $remitenteint, $destinatarioint, $deporigenint, $depdestinoint, $nu, '$asunto', NOW(), $idem, $idd);")){
                            $iddn=mysqli_insert_id($cone);

                            //obtrenemos la mesa de partes
                            $cmmp=mysqli_query($cone, "SELECT mp.idtdmesapartes FROM tdpersonalmp pm INNER JOIN tdmesapartes mp ON pm.idtdmesapartes=mp.idtdmesapartes WHERE pm.idEmpleado=$idem AND pm.estado=1 AND mp.estado=1;");
                            if($rmmp=mysqli_fetch_assoc($cmmp)){
                                $mmp=vacio($rmmp['idtdmesapartes']);
                                $dep=vacio("");
                            }else{
                                $mmp=vacio("");
                                $dep=vacio(iddependenciae($cone, $_SESSION['identi']));
                            }
                            mysqli_free_result($cmmp);

                            $q="INSERT INTO tdestadodoc (idDoc, idtdestado, fecha, idEmpleado, idtdmesapartes, idDependencia, asignador, mpasignador, depasignador, estado) VALUES ($iddn, 2, NOW(), $idem, $mmp, $dep, $idem, $mmp, $dep, 1);";
                            if(mysqli_query($cone, $q)){
                                $r['m']=mensajesu("Listo, cargo generado y registrado como recibido.<br> N° Seguimiento:<b> $nu-$ano</b>");
                                $r['e']=true;
                            }else{
                                if(mysqli_query($cone, "DELETE FROM doc WHERE idDoc=$iddn;")){
                                    $r['m']=mensajewa("Error al registrar estado, vuelva a intentarlo. ".$q);
                                }else{
                                    $r['m']=mensajewa("Solo se registro el documento, contacte a informática para generarle un estado.");
                                }
                            }

                        }else{
                            $r['m']=mensajewa("Error al registrar cargo.");
                            mysqli_query($cone, "DELETE FROM doc WHERE idDoc=$iddn;");
                        }           
                    }

                }else{
                    $r['m']=mensajewa('Error, datos erroneos del documento.');
                }

            }else{
                $r['m']=mensajewa("No envío datos.");
            }
        }elseif($acc=="dercar"){
            if(isset($_POST['v1']) && !empty($_POST['v1']) && isset($_POST['v2']) && !empty($_POST['v2']) && isset($_POST['v3']) && !empty($_POST['v3'])){
                $v1=iseguro($cone, $_POST['v1']);
                $v2=iseguro($cone, $_POST['v2']);
                $v3=iseguro($cone, $_POST['v3']);
                $idem=$_SESSION['identi'];

                $ce=mysqli_query($cone, "SELECT idtdestadodoc FROM tdestadodoc WHERE idDoc=$v1 AND estado=1;");
                if($re=mysqli_fetch_assoc($ce)){
                    if($re['idtdestadodoc']==$v2){
                        $idue=$re['idtdestadodoc'];

                        //obtenemos la mp
                        $cmp=mysqli_query($cone, "SELECT mp.idtdmesapartes FROM tdpersonalmp p INNER JOIN tdmesapartes mp ON p.idtdmesapartes=mp.idtdmesapartes WHERE p.idEmpleado=$idem AND p.estado=1 AND mp.estado=1;");
                        if($rmp=mysqli_fetch_assoc($cmp)){
                            $mp=$rmp['idtdmesapartes'];
                            $dep=vacio("");
                        }else{
                            $mp=vacio("");
                            $dep=iddependenciae($cone, $idem);
                        }

                        $q="INSERT INTO tdestadodoc (idDoc, idtdestado, fecha, idtdmesapartes, asignador, mpasignador, depasignador, estado) VALUES ($v1, 3, NOW(), $v3, $idem, $mp, $dep, 1);";
                        if(mysqli_query($cone, $q)){
                            $idne=mysqli_insert_id($cone);
                            if(mysqli_query($cone, "UPDATE tdestadodoc SET estado=0 WHERE idDoc=$v1 AND idtdestadodoc=$idue;")){
                                mysqli_query($cone, "UPDATE doc SET cargo=1 WHERE idDoc=$v1;");
                                $r['m']=mensajesu("¡Listo! Documento derivado a Mesa de Partes.");
                                $r['e']=true;
                            }else{
                                if(mysqli_query($cone, "DELETE FROM tdestadodoc WHERE idtdestadodoc=$idne;")){
                                    $r['m']=mensajewa("Error al derivar, vuelva a intentarlo.");
                                }else{
                                    $r['m']=mensajewa("Error al derivar, contacte al administrador del sistema.");
                                }
                            }
                        }else{
                            $r['m']=mensajewa("Error al derivar, vuelva a intentarlo. $q");
                        }
                    }else{
                        $r['m']=mensajewa("El documento ya tiene otro estado. ¡Actualice! $v1 $v2 $v3");
                        $r['e']=true;
                    }
                }else{
                    $r['m']=mensajewa('Error, datos erroneos del documento.');
                }
            }else{
                $r['m']=mensajewa("Faltan datos.");
            }
        }elseif($acc=="carori"){
            if(isset($_POST['v1']) && !empty($_POST['v1'])){
                $v1=iseguro($cone, $_POST['v1']);
                $v2=iseguro($cone, $_POST['v2']);

                if($v2==1){
                    if(mysqli_query($cone, "UPDATE doc SET cargo=0 WHERE idDoc=$v1")){
                        $r['m']=mensajesu("Documento convertido a original");
                        $r['e']=true;
                    }else{
                        $r['m']=mensajewa("Error al convertir documento");
                    }
                }else{
                    if(mysqli_query($cone, "UPDATE doc SET cargo=1 WHERE idDoc=$v1")){
                        $r['m']=mensajesu("Documento convertido a cargo");
                        $r['e']=true;
                    }else{
                        $r['m']=mensajewa("Error al convertir documento");
                    }
                }  
            }else{
                $r['m']=mensajewa("Faltan datos.");
            }
        }//acafin
	}else{
		$r['m']=mensajewa("Error: Ne envio la acción.");
	}
}else{
    $r['m']=mensajewa("Acceso restringido.");
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($r);
mysqli_close($cone);
?>