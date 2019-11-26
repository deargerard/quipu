<?php
session_start();
include ("../../m_inclusiones/php/conexion_sp.php");
include ("../../m_inclusiones/php/funciones.php");
if(vacceso($cone,$_SESSION['identi'],$_SESSION['docide'],$_SESSION['nomusu'])){
    if(esResDespacho($cone,$_SESSION['identi'])){
      if(isset($_GET['c']) && !empty($_GET['c']) && isset($_GET['p']) && !empty($_GET['p'])){

    	$ideq=iseguro($cone, $_GET['c']);
      $idpe=iseguro($cone, $_GET['p']);

    	$v=false;
    	$cv=mysqli_query($cone,"SELECT d.Denominacion, e.nombre FROM orequipo e INNER JOIN dependencia d ON e.idDependencia=d.idDependencia WHERE e.idorequipo=$ideq AND e.estado=1;");
    	if($rv=mysqli_fetch_assoc($cv)){
    		$v=true;
        $de=$rv['Denominacion']." (".$rv['nombre'].")";
    	}
      mysqli_free_result($cv);

	require_once('../../plugins/MPDF57/mpdf.php');

		$cpro=mysqli_query($cone,"SELECT e.NumeroDoc, e.idEmpleado, ec.idEmpleadoCargo, pv.FechaIni, pv.FechaFin, ec.FechaVac, cl.Tipo FROM dependencia d INNER JOIN cardependencia cd ON d.idDependencia=cd.idDependencia INNER JOIN empleadocargo ec ON cd.idEmpleadoCargo=ec.idEmpleadoCargo INNER JOIN empleado e ON ec.idEmpleado=e.idEmpleado INNER JOIN cargo ca ON ec.idCargo=ca.idCargo INNER JOIN sistemalab sl ON ca.idSistemaLab=sl.idSistemaLab INNER JOIN orintegrante i ON ec.idEmpleadocargo=i.idEmpleadocargo INNER JOIN provacaciones pv ON ec.idEmpleadoCargo=pv.idEmpleadoCargo INNER JOIN condicionlab cl ON ec.idCondicionLab=cl.idCondicionLab WHERE i.idorequipo=$ideq AND pv.idPeriodoVacacional=$idpe AND pv.Estado=7 AND cd.Estado=1 AND ec.idEstadoCar=1 AND i.estado=1 AND (d.Observacion!='e' OR sl.SistemaLab!='FISCAL') AND (ec.idCargo!=32 AND ec.idCargo!=34 AND ec.idCargo!=37) ORDER BY e.ApellidoPat ASC, e.ApellidoMat ASC;");

	$html='
	  <header class="clearfix">
      <div id="logo">
        <img src="../images/logomp.png">
      </div>';
if($v){
    $html.=      
      '	<h1>PROGRAMACIÓN VACACIONES '.date('Y')."-".(date('Y')+1).'</h1>
      <div id="company" class="clearfix">
        <div>Fecha: '.date('d/m/Y').'</div>
      </div>
      <div id="project">
        <div><span>RESP.</span> '.nomempleado($cone,$_SESSION['identi']).'</div>
        <div><span>DESP.</span> '.$de.'</div>
      </div>
    </header>
    <main>
      <table>
        <thead>
          <tr>
            <th class="service">DNI</th>
            <th class="desc">APELLIDOS Y NOMBRES</th>
            <th class="desc">DEPENDENCIA</th>
            <th class="desc">CARGO</th>
            <th>F. ING.</th>
            <th>REG. LAB.</th>
            <th>F. INI.</th>
            <th>F. FIN</th>
            <th>DÍAS</th>
          </tr>
        </thead>
        <tbody>';
    while($rpro=mysqli_fetch_assoc($cpro)){
      $html.='<tr>
            <td class="service">'.$rpro['NumeroDoc'].'</td>
            <td class="desc">'.nomempleado($cone,$rpro['idEmpleado']).'</td>
            <td class="desc">'.dependenciae($cone,$rpro['idEmpleado']).'</td>
            <td class="desc">'.cargoe($cone,$rpro['idEmpleado']).'</td>
            <td class="qty">'.fnormal($rpro['FechaVac']).'</td>
            <td>'.$rpro['Tipo'].'</td>
            <td>'.fnormal($rpro['FechaIni']).'</td>
            <td>'.fnormal($rpro['FechaFin']).'</td>
            <td>'.intervalo($rpro['FechaFin'],$rpro['FechaIni']).'</td>
          </tr>';
    }
$html.= '</tbody>
      </table>
	  <div id="notices">
        <div>FIRMA Y SELLO</div>
        <div><small>(Del responsable)</small></div>
      </div>
    </main>';
}else{
	$html.='<h1>Error</h1>';
}
	$html.='
    <footer>
      QUIPU - Sistema de Gestión Administrativa / Módulo Vacaciones
    </footer>';
	$css = file_get_contents('../plantillas/plantilla1.css');

	$mpdf = new mPDF('c', 'A4-L');

	$mpdf->writeHTML($css, 1);
	$mpdf->writeHTML($html);
	$mpdf->setFooter("Página {PAGENO} de {nb}");
	$mpdf->Output('ProgVacaciones.pdf', 'I');

    }else{
      echo mensajewa("Error: No envio datos");
    }
	}else{
		echo mensajewa("Error: Ud. no es responsable de ningún despacho.");
	}
}else{
	echo accrestringidoa();
}

?>