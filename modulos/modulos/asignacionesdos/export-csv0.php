<?php
set_time_limit(2800);
require_once '../../database/Conexion.php';
require_once 'model/asignacion.php';

$exportob = new Asignacion();
$periodoactual = $exportob->ObtenerPeriodoActual();
$periodoid = $periodoactual->periodo_id;
$datosexportob = $exportob->ExportarOB($periodoid);



$headers = array('Periodo', 'FECHA', 'N.ASTO', 'CC', 'N.COMPR.', 'NRO DE CTA', 'C.CTO.', 'A.NEGOC.', 'D/H', 'IMPORTE', 'IMPORTE EXT'
);

$rows = array(


    array('Schlüter', 'Rudy'),
    //array('Alvarez', 'Niño')


);

// Create file and make it writable

$file = fopen('file.csv', 'w');

// Add BOM to fix UTF-8 in Excel

fputs($file, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));

// Headers
// Set ";" as delimiter

fputcsv($file, $headers, ";");

// Rows
// Set ";" as delimiter
/*
foreach ($rows as $row) {

    fputcsv($file, $row, ";");
}
*/
// Close file

fclose($file);

// Send file to browser for download

$dest_file = 'file.csv';
$file_size = filesize($dest_file);

header("Content-Type: text/csv; charset=utf-8");
header("Content-disposition: attachment; filename=\"file.csv\"");
header("Content-Length: " . $file_size);
readfile($dest_file);
?>
