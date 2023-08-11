<?php
set_time_limit(2800);

//$datosiosper = $this->model->IOSPERDatos();
//----sona horario y formato de fechas--------
date_default_timezone_set("America/Buenos_Aires");
//setlocale(LC_ALL,"es_ES");
setlocale(LC_ALL, 'es_RA.UTF8');
//setlocale(LC_TIME, "es_RA.UTF-8");
setlocale(LC_TIME, 'es_RA.utf-8','spanish');
//setlocale('es_ES.UTF-8'); // I'm french !
$periodo=$this->model->CJMDGPeriodoObtener();
$jub_datos_segu = $this->model->JubiladoSeguObtener($periodo->periodo_id);

$mes=substr($periodo->periodo_nombre,4,2);
//$mes = date('m') ;
//$anio=date("Y");
$anio=substr($periodo->periodo_nombre,2,2);
$anio1=substr($periodo->periodo_nombre,0,4);
//$mesAnterior = date('m', strtotime('-1 month')) ;
//$anio=date("y");

//$fecha_actual = $fecha_dos->format('Y-m-d');
$file = fopen('SEGU-'.$mes.$anio.'.csv', 'w');

foreach ($jub_datos_segu as $value) {

      //if($jub_sueldo==""){$a=$a."0.00|";}else{$a=$a.$jub_sueldo->cjmdg_detsueldo_importe."|";}
      //$fec=new DateTime($value->cjmdg_personal_fecnac);
      //$fec1=$fec->format('d/m/Y');
      $le=1;
      $jub_datos_haber = $this->model->JubiladoSeguroObtener($value->cjmdg_personal_nroleg2,$le);
      //if(strlen($value->cjmdg_personal_nrodoc)<8){$doc="0".$value->cjmdg_personal_nrodoc;}else{$doc=$value->cjmdg_personal_nrodoc;}
      //$cad=str_pad($value->cjmdg_personal_apellido." ".$value->cjmdg_personal_nombre,30," ", STR_PAD_RIGHT)."|".$doc."|".$fec1."|".$value->cjmdg_detsueldo_importe;
      //$cad=str_pad($value->cjmdg_personal_apellido." ".$value->cjmdg_personal_nombre,30," ", STR_PAD_RIGHT),.$doc.",".$fec1.",".$value->cjmdg_detsueldo_importe;

      $lineData = array(55,$value->legajo_nrodocto,$value->cjmdg_personal_nroleg,$anio1.$mes,1,number_format($value->cjmdg_detsueldo_importe,2,'.',''),10,$jub_datos_haber[0]->cjmdg_detsueldo_importe,0,0,trim($value->legajo_apellido)." ".trim($value->legajo_nombres));
      fputcsv($file, $lineData, ";");
}
//exit();
// Close file
fclose($file);

// Send file to browser for download
//$dest_file = 'file.csv';
$dest_file = 'SEGU-'.$mes.$anio.'.csv';
$file_name = 'SEGU-'.$mes.$anio.'.csv';
$file_size = filesize($dest_file);

header("Content-Type: text/csv; charset=utf-8");
header("Content-disposition: attachment; filename=\"$file_name\"");
header("Content-Length: " . $file_size);
readfile($dest_file);
//borra el archivo
unlink($dest_file);
?>
