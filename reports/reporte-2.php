<?php

require_once '../vendor/autoload.php';


//Namespace 
use Spipu\Html2Pdf\Html2Pdf;//Core
use Spipu\Html2Pdf\Exception\Html2PdfException;//Manejo de errores
use Spipu\Html2Pdf\Exception\ExceptionFormatter;// Detallar el error

try{

  // Variables globales de prueba 
  $logo = "images/senati.jpg" ;
  $desarrollador = "Joseandres Montesino";
  $lenguajes = ["PHP","Java"];
  $encabezado = "Generación de Computadoras";
  $piePagina="Curso: Emsamble de PC";

  //Variables globales de prueba
  ob_start();

  //contiene todo lo que será renderizado PDF
  $data = "";

  // El reporte se estructura página1 + página2
  include('estilos.html');
  include('content-report-2/pagina1.php');
  include('content-report-2/pagina2.php');
 

  //Depuración del contenido 
  $data .= ob_get_clean();


  //Creando espacio
  $html2pdf = new Html2Pdf('P', 'A4', 'fr', true, 'utf-8', array(10,10,15,15));
  $html2pdf->setDefaultFont('Arial');
  $html2pdf->writeHTML($data);

  $html2pdf->output('reporte-demo.pdf');

}
catch(Html2PdfException $e){
  $html2pdf->clean();
  $formatter = new ExceptionFormatter($e);
  echo $formatter->getHtmlMessage();
}

?>