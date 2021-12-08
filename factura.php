<?php
require __DIR__.'/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;

require 'includes/funciones.php';

ob_start();
incluirTemplate('imprimir_factura');
$html = ob_get_clean();

$html2pdf = new Html2Pdf();
$html2pdf->writeHTML($html);
$html2pdf->output('pdf_generated.pdf');

?>