<?php
	require __DIR__.'/vendor/autoload.php';
	use Spipu\Html2Pdf\Html2Pdf;

if(isset($_GET['mesanoc']) && !empty($_GET['mesanoc']) && isset($_GET['per']) && !empty($_GET['per']) && isset($_GET['car']) && !empty($_GET['car'])){
	ob_start();
	require_once '../m_inclusiones/a_asistencia/pdfasistencia.php';
	$html=ob_get_clean();

	$html2pdf=new Html2Pdf('P','A4','es','true','UTF-8');
	$html2pdf->writeHTML($html);
	$html2pdf->output('asistencia.pdf');
}else{
echo mensajeda("Error: No se enviaron los datos.");
}
?>