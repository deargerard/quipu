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
            if(isset($_POST['num']) && !empty($_POST['num']) && isset($_POST['ano']) && !empty($_POST['ano']) && isset($_POST['sig']) && !empty($_POST['sig']) && isset($_POST['tipdoc']) && !empty($_POST['tipdoc']) && isset($_POST['fecdoc']) && !empty($_POST['fecdoc']) && isset($_POST['fol']) && !empty($_POST['fol']) && isset($_POST['trem']) && !empty($_POST['trem']) && isset($_POST['tdes']) && !empty($_POST['tdes'])){

                $trem=iseguro($cone, $_POST['trem']);
                $tdes=iseguro($cone, $_POST['tdes']);

                $exr=false;
                if($trem=='i'){
                    if(isset($_POST['pirem']) && !empty($_POST['pirem']) && isset($_POST['direm']) && !empty($_POST['direm'])){
                        $exr=true;
                    }else{
                        $r['m']=mensajewa("No ingreso remitente ni dependencia/institución origen interno.");
                    }
                }elseif($trem=='e'){
                    if(isset($_POST['perem']) && !empty($_POST['perem']) && isset($_POST['derem']) && !empty($_POST['derem'])){
                        $exr=true;
                    }else{
                        $r['m']=mensajewa("No ingreso remitente ni dependencia/institución origen externo.");
                    }
                }
                $exd=false;
                if($tdes=='i'){
                    if(isset($_POST['pides']) && !empty($_POST['pides']) && isset($_POST['dides']) && !empty($_POST['dides'])){
                        $exd=true;
                    }else{
                        $r['m']=mensajewa("No ingreso destinatario ni dependencia/institución destino interno.");
                    }
                }elseif($tdes=='e'){
                    if(isset($_POST['pedes']) && !empty($_POST['pedes']) && isset($_POST['dedes']) && !empty($_POST['dedes'])){
                        $exd=true;
                    }else{
                        $r['m']=mensajewa("No ingreso destinatario ni dependencia/institución destino externo.");
                    }
                }

                if($exr && $exd){
                    $num=iseguro($cone, $_POST['num']);
                    $ano=iseguro($cone, $_POST['ano']);
                    $sig=imseguro($cone, $_POST['sig']);
                    $tipdoc=iseguro($cone, $_POST['tipdoc']);
                    $fecdoc=fmysql(iseguro($cone, $_POST['fecdoc']));
                    $leg=vacio(iseguro($cone, $_POST['leg']));
                    $fol=iseguro($cone, $_POST['fol']);
                    $des=vacio(iseguro($cone, $_POST['des']));
                    $pirem=$_POST['pirem']=="" ? vacio("") :  vacio(iseguro($cone, $_POST['pirem']));
                    $direm=$_POST['direm']=="" ? vacio("") :  vacio(iseguro($cone, $_POST['direm']));
                    $perem=$_POST['perem']=="" ? vacio("") :  vacio(imseguro($cone, $_POST['perem']));
                    $derem=$_POST['derem']=="" ? vacio("") :  vacio(imseguro($cone, $_POST['derem']));
                    $pides=$_POST['pides']=="" ? vacio("") :  vacio(iseguro($cone, $_POST['pides']));
                    $dides=$_POST['dides']=="" ? vacio("") :  vacio(iseguro($cone, $_POST['dides']));
                    $pedes=$_POST['pedes']=="" ? vacio("") :  vacio(imseguro($cone, $_POST['pedes']));
                    $dedes=$_POST['dedes']=="" ? vacio("") :  vacio(imseguro($cone, $_POST['dedes']));
                    $ref=$_POST['ref']=="" ? vacio("") :  vacio(imseguro($cone, $_POST['ref']));

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

                    $q="INSERT INTO doc (Numero, Ano, Siglas, FechaDoc, idTipoDoc, Descripcion, Legajo, folios, remitenteext, destinatarioext, deporigenext, depdestinoext, remitenteint, destinatarioint, deporigenint, depdestinoint, referencia, numdoc, cargo) VALUES ('$num', '$ano', '$sig', '$fecdoc', $tipdoc, $des, $leg, $fol, $perem, $pedes, $derem, $dedes, $pirem, $pides, $direm, $dides, $ref, $nu, 0);";
                    if(mysqli_query($cone, $q)){
                        $iddo=mysqli_insert_id($cone);
                        $idem=$_SESSION['identi'];
                        $idde=iddependenciae($cone,$idem);
                        if(mysqli_query($cone, "INSERT INTO tdestadodoc (idtdestado, fecha, idDependencia, idEmpleado, idDoc, estado) VALUES (1, NOW(), $idde, $idem, $iddo, 1);")){
                            $r['m']=mensajesu("Listo, documento registrado.");
                            $r['e']=true;
                        }else{
                            if(mysqli_query($cone, "DELETE FROM doc WHERE idDoc=$iddo;")){
                                $r['m']=mensajewa("Error al registrar estado, vuelva a intentarlo.");
                            }else{
                                $r['m']=mensajewa("Solo se registro el documento, contacte a informática para generarle un estado.");
                            }
                        }
                    }else{
                        $r['m']=mensajewa("Error al registrar, vuelva a intentarlo.<br> $q");
                    }
                }

            }else{
                $r['m']=mensajewa("Los campos marcado con <span class='text-red'>*</span> son obligatorios.");
            }
        }elseif($acc=="edidoc"){
            if(isset($_POST['v1']) && !empty($_POST['v1']) && isset($_POST['num']) && !empty($_POST['num']) && isset($_POST['ano']) && !empty($_POST['ano']) && isset($_POST['sig']) && !empty($_POST['sig']) && isset($_POST['tipdoc']) && !empty($_POST['tipdoc']) && isset($_POST['fecdoc']) && !empty($_POST['fecdoc']) && isset($_POST['fol']) && !empty($_POST['fol']) && isset($_POST['trem']) && !empty($_POST['trem']) && isset($_POST['tdes']) && !empty($_POST['tdes'])){

                $trem=iseguro($cone, $_POST['trem']);
                $tdes=iseguro($cone, $_POST['tdes']);

                $exr=false;
                if($trem=='i'){
                    if(isset($_POST['pirem']) && !empty($_POST['pirem']) && isset($_POST['direm']) && !empty($_POST['direm'])){
                        $exr=true;
                    }else{
                        $r['m']=mensajewa("No ingreso remitente ni dependencia/institución origen interno.");
                    }
                }elseif($trem=='e'){
                    if(isset($_POST['perem']) && !empty($_POST['perem']) && isset($_POST['derem']) && !empty($_POST['derem'])){
                        $exr=true;
                    }else{
                        $r['m']=mensajewa("No ingreso remitente ni dependencia/institución origen externo.");
                    }
                }
                $exd=false;
                if($tdes=='i'){
                    if(isset($_POST['pides']) && !empty($_POST['pides']) && isset($_POST['dides']) && !empty($_POST['dides'])){
                        $exd=true;
                    }else{
                        $r['m']=mensajewa("No ingreso destinatario ni dependencia/institución destino interno.");
                    }
                }elseif($tdes=='e'){
                    if(isset($_POST['pedes']) && !empty($_POST['pedes']) && isset($_POST['dedes']) && !empty($_POST['dedes'])){
                        $exd=true;
                    }else{
                        $r['m']=mensajewa("No ingreso destinatario ni dependencia/institución destino externo.");
                    }
                }

                if($exr && $exd){
                    $v1=iseguro($cone, $_POST['v1']);
                    $num=iseguro($cone, $_POST['num']);
                    $ano=iseguro($cone, $_POST['ano']);
                    $sig=imseguro($cone, $_POST['sig']);
                    $tipdoc=iseguro($cone, $_POST['tipdoc']);
                    $fecdoc=fmysql(iseguro($cone, $_POST['fecdoc']));
                    $leg=vacio(iseguro($cone, $_POST['leg']));
                    $fol=iseguro($cone, $_POST['fol']);
                    $des=vacio(iseguro($cone, $_POST['des']));
                    $pirem=$_POST['pirem']=="" ? vacio("") :  vacio(iseguro($cone, $_POST['pirem']));
                    $direm=$_POST['direm']=="" ? vacio("") :  vacio(iseguro($cone, $_POST['direm']));
                    $perem=$_POST['perem']=="" ? vacio("") :  vacio(imseguro($cone, $_POST['perem']));
                    $derem=$_POST['derem']=="" ? vacio("") :  vacio(imseguro($cone, $_POST['derem']));
                    $pides=$_POST['pides']=="" ? vacio("") :  vacio(iseguro($cone, $_POST['pides']));
                    $dides=$_POST['dides']=="" ? vacio("") :  vacio(iseguro($cone, $_POST['dides']));
                    $pedes=$_POST['pedes']=="" ? vacio("") :  vacio(imseguro($cone, $_POST['pedes']));
                    $dedes=$_POST['dedes']=="" ? vacio("") :  vacio(imseguro($cone, $_POST['dedes']));
                    $ref=$_POST['ref']=="" ? vacio("") :  vacio(imseguro($cone, $_POST['ref']));
                    if(mysqli_query($cone, "UPDATE doc SET Numero='$num', Ano='$ano', Siglas='$sig', FechaDoc='$fecdoc', idTipoDoc=$tipdoc, Descripcion=$des, Legajo=$leg, folios=$fol, remitenteext=$perem, destinatarioext=$pedes, deporigenext=$derem, depdestinoext=$dedes, remitenteint=$pirem, destinatarioint=$pides, deporigenint=$direm, depdestinoint=$dides, referencia=$ref WHERE idDoc=$v1;")){
                        $r['m']=mensajesu("Listo, documento editado.");
                        $r['e']=true;
                    }else{
                        $r['m']=mensajewa("Error al registrar, vuelva a intentarlo.");
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
        }elseif($acc=="derdoc"){
            if(isset($_POST['v1']) && !empty($_POST['v1']) && isset($_POST['v2']) && !empty($_POST['v2']) && isset($_POST['v3']) && !empty($_POST['v3'])){
                $v1=iseguro($cone, $_POST['v1']);
                $v2=iseguro($cone, $_POST['v2']);
                $v3=iseguro($cone, $_POST['v3']);
                $idmp=!is_null($_POST['idmp']) ? iseguro($cone, $_POST['idmp']) : vacio('');
                $idem=$_SESSION['identi'];

                $ce=mysqli_query($cone, "SELECT idtdestadodoc FROM tdestadodoc WHERE idDoc=$v1 AND estado=1;");
                if($re=mysqli_fetch_assoc($ce)){
                    if($re['idtdestadodoc']==$v2){
                        $idue=$re['idtdestadodoc'];
                        if(mysqli_query($cone, "INSERT INTO tdestadodoc (idtdestado, fecha, idDoc, estado, idtdmesapartes, mpderiva) VALUES (3, DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i:%s'), $v1, 1, $v3, $idmp);")){
                            $idne=mysqli_insert_id($cone);
                            if(mysqli_query($cone, "UPDATE tdestadodoc SET estado=0 WHERE idDoc=$v1 AND idtdestadodoc=$idue;")){
                                $r['m']="¡Listo! Documento derivado.";
                                $r['e']=true;
                            }else{
                                if(mysqli_query($cone, "DELETE FROM tdestadodoc WHERE idtdestadodoc=$idne;")){
                                    $r['m']="Error al derivar, vuelva a intentarlo.";
                                }else{
                                    $r['m']="Error al derivar, contacte al administrador del sistema.";
                                }
                            }
                        }else{
                            $r['m']="Error al derivar, vuelva a intentarlo.";
                        }
                    }else{
                        $r['m']='El documento ya tiene otro estado.';
                        $r['e']=true;
                    }
                }else{
                    $r['m']='Error, realice el reporte';
                }
    

            }else{
                $r['m']="Faltan datos.";
            }
        }elseif($acc=="recdoc"){
            if(isset($_POST['v1']) && !empty($_POST['v1']) && isset($_POST['v2']) && !empty($_POST['v2'])){
                $v1=iseguro($cone, $_POST['v1']);
                $v2=iseguro($cone, $_POST['v2']);
                $idem=$_SESSION['identi'];
                $dep=iddependenciae($cone, $_SESSION['identi']);

                $ce=mysqli_query($cone, "SELECT idtdestadodoc FROM tdestadodoc WHERE idDoc=$v1 AND estado=1;");
                if($re=mysqli_fetch_assoc($ce)){
                    if($re['idtdestadodoc']==$v2){
                        $idue=$re['idtdestadodoc'];
                        if(mysqli_query($cone, "INSERT INTO tdestadodoc (idtdestado, fecha, idDependencia, idEmpleado, idDoc, estado) VALUES (2, DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i:%s'), $dep, $idem, $v1, 1);")){
                            $idne=mysqli_insert_id($cone);
                            if(mysqli_query($cone, "UPDATE tdestadodoc SET estado=0, responsablemp=$idem WHERE idDoc=$v1 AND idtdestadodoc=$idue;")){
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
                    $r['m']='Error, reporte al administrador del sistema.';
                }

            }else{
                $r['m']="Faltan datos.";
            }
        }elseif($acc=="asidoc"){
            if(isset($_POST['v1']) && !empty($_POST['v1']) && isset($_POST['v2']) && !empty($_POST['v2']) && isset($_POST['v2']) && !empty($_POST['v2'])){
                $v1=iseguro($cone, $_POST['v1']);
                $v2=iseguro($cone, $_POST['v2']);
                $v3=iseguro($cone, $_POST['v3']);
                $dep=iddependenciae($cone, $v3);

                $ce=mysqli_query($cone, "SELECT idtdestadodoc FROM tdestadodoc WHERE idDoc=$v1 AND estado=1;");
                if($re=mysqli_fetch_assoc($ce)){
                    if($re['idtdestadodoc']==$v2){
                        $idue=$re['idtdestadodoc'];
                        if(mysqli_query($cone, "INSERT INTO tdestadodoc (idtdestado, fecha, idDependencia, idEmpleado, idDoc, estado) VALUES (4, DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i:%s'), $dep, $v3, $v1, 1);")){
                            $idne=mysqli_insert_id($cone);
                            if(mysqli_query($cone, "UPDATE tdestadodoc SET estado=0 WHERE idDoc=$v1 AND idtdestadodoc=$idue;")){
                                $r['m']="¡Listo! Documento asignado.";
                                $r['e']=true;
                            }else{
                                if(mysqli_query($cone, "DELETE FROM tdestadodoc WHERE idtdestadodoc=$idne;")){
                                    $r['m']="Error al asignar, vuelva a intentarlo.";
                                }else{
                                    $r['m']="Error al asignar, reporte al administrador del sistema.";
                                }
                            }
                        }else{
                            $r['m']="Error al asignar, vuelva a intentarlo.";
                        }
                    }else{
                        $r['m']='El documento ya tiene otro estado.';
                        $r['e']=true;
                    }
                }else{
                    $r['m']='Error $v1, reporte al administrador del sistema.';
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

                        if(mysqli_query($cone, "INSERT INTO tdestadodoc (idtdestado, fecha, observacion, idtdmodnotificacion, idDependencia, idEmpleado, idDoc, estado, notificado, fecnotificado) VALUES (5, DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i:%s'), $obs, $mnot, $dep, $idem, $v1, 1, $not, '$fnot');")){
                            $idne=mysqli_insert_id($cone);
                            if(mysqli_query($cone, "UPDATE tdestadodoc SET estado=0 WHERE idDoc=$v1 AND idtdestadodoc=$idue;")){
                                $r['m']=mensajesu("¡Listo! Notificación reportada.");
                                $r['e']=true;
                                if(mysqli_query($cone, "UPDATE doc SET cargo=1 WHERE idDoc=$v1")){
                                    $r['m'].=mensajesu("Envié el cargo.");
                                }
                            }else{
                                if(mysqli_query($cone, "DELETE FROM tdestadodoc WHERE idtdestadodoc=$idne;")){
                                    $r['m']=mensajewa("Error al reportar1, vuelva a intentarlo.");
                                }else{
                                    $r['m']=mensajewa("Error $v1 al reportar, reporte al administrador del sistema.");
                                }
                            }
                        }else{
                            $r['m']=mensajewa("Error al reportar2, vuelva a intentarlo.");
                        }

                    }else{
                        $r['m']=mensajesu('El documento ya tiene otro estado.');
                        $r['e']=true;
                    }
                }else{
                    $r['m']=mensajewa('Error $v1, reporte al administrador del sistema.');
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
                        if(mysqli_query($cone, "INSERT INTO tdestadodoc (idtdestado, fecha, observacion, idDependencia, idEmpleado, idDoc, estado) VALUES (6, DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i:%s'), '$obs',$dep, $idem, $v1, 1);")){
                            $idne=mysqli_insert_id($cone);
                            if(mysqli_query($cone, "UPDATE tdestadodoc SET estado=0 WHERE idDoc=$v1 AND idtdestadodoc=$idue;")){
                                $r['m']=mensajesu("¡Listo! Documento atendido.");
                                $r['e']=true;

                            }else{
                                if(mysqli_query($cone, "DELETE FROM tdestadodoc WHERE idtdestadodoc=$idne;")){
                                    $r['m']=mensajewa("Error al atender, vuelva a intentarlo.");
                                }else{
                                    $r['m']=mensajewa("Error $v1 al atender, reporte al administrador del sistema.");
                                }
                            }
                        }else{
                            $r['m']=mensajewa("Error al atender, vuelva a intentarlo.");
                        }
                    }else{
                        $r['m']=mensajesu('El documento ya tiene otro estado.');
                        $r['e']=true;
                    }
                }else{
                    $r['m']=mensajewa('Error $v1, reporte al administrador del sistema.');
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

                $cd=mysqli_query($cone, "SELECT idtdestadodoc FROM tdestadodoc WHERE ISNULL(idtdguia) AND idtdmesapartes=$mpdes AND idtdestado=3 AND estado=1 AND mpderiva=$v1;");
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
                        if(mysqli_query($cone, "UPDATE tdestadodoc SET idtdguia=$idg WHERE ISNULL(idtdguia) AND idtdmesapartes=$mpdes AND idtdestado=3 AND estado=1 AND mpderiva=$v1;")){
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