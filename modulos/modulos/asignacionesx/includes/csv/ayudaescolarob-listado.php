<?php
set_time_limit(2800);
/*require_once '../../database/Conexion.php';
require_once 'model/asignacion.php';*/

//$exportob = new Asignacion();
$periodoactual = $this->model->PeriodoActualObtener();
$periodoid = $periodoactual->periodo_id;
$datosexportob = $this->model->ExportarAEOBLiquidaciones($periodoid);



$headers = array('Periodo', 'FECHA', 'N.ASTO', 'CC', 'N.COMPR.', 'NRO DE CTA', 'C.CTO.', 'A.NEGOC.', 'D/H', 'IMPORTE', 'IMPORTE EXT');



$rows = array(


    array('Schlüter', 'Rudy'),
    //array('Alvarez', 'Niño')


);

// Create file and make it writable

$file = fopen('file.csv', 'w');

// Add BOM to fix UTF-8 in Excel

//fputs($file, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));

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
foreach($datosexportob as $value){
        $empleado = $value->legempleado_nrodocto;
        $beneficiario = $value->liquidacion_nrodocto;
        $ccosto = $this->model->CCostosObtener($empleado);
        $importeob = $this->model->SueldoNetoOBAEObtener($empleado,$beneficiario,$periodoid);
		    $importeobdos = $importeob->importeob;
		    $importeobtres = number_format($importeobdos, 2, ',', '.');

        $lineData = array('abr-20', '300420', '0', '0', '0', '5000002000   ASIG.FAM', $ccosto->ccosto_codigo, '', 'D', $importeobtres, '');
        fputcsv($file, $lineData, ";");
    }

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
