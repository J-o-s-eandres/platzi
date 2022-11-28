<?php

require_once '../vendor/autoload.php';


//Namespace 
use Spipu\Html2Pdf\Html2Pdf;//Core
use Spipu\Html2Pdf\Exception\Html2PdfException;//Manejo de errores
use Spipu\Html2Pdf\Exception\ExceptionFormatter;// Detallar el error

try{

  //Variables globales de prueba
  ob_start();
    //estilos
  include('estilos.html');
  //contiene todo lo que será renderizado PDF
 
  $data = "";

  $data .= "<h1 class='center'> Bienvenido A mi Reporte</h1>";
  $data .= "<p class='end mt-2 underline'>Joseandres Montesino</p>";
  $data .= "<p class='txl italic bold'>Ingeniería de Software con IA</p>";
  
  $data .= "<hr />";
  $data .="
  <p class='justify'>
   Lorem ipsum dolor sit amet consectetur, adipisicing elit. Excepturi voluptatem
   molestiae numquam obcaecati officia ex repellendus corporis, vitae consequuntur tempore perspiciatis
   harum aliquam beatae cumque possimus expedita earum laboriosam atque?
   Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit ratione quas reiciendis eaque 
   dignissimos, dolores cumque tempora tempore, mollitia, aperiam commodi maxime sed incidunt iusto perferendis
   eum consequatur rem sint?
    </p>";
  //Páginas externas(opcional):
  // include '';

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