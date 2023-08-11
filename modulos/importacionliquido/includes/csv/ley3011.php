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
$jub_datos = $this->model->JubiladoLey3011Obtener($periodo->periodo_id);
//AGREGAR PERIODO EN EL MODELO
//$numero = date('m', strtotime('-1 month')) ;

$numero=substr($periodo->periodo_nombre,4,2);
$fecha = DateTime::createFromFormat('!m', $numero);
$mes = mb_strtoupper(strftime("%B", $fecha->getTimestamp()));

$anio=substr($periodo->periodo_nombre,0,4);
//$anio=date("Y");
//$fecha_actual = $fecha_dos->format('Y-m-d');
$file = fopen('ley3011.csv', 'w');
$headers = array('CAJA DE JUBILACIONES Y PENSIONES DE LA MUNICIPALIDAD DE GUALEGUAY -'.$mes.' '.$anio);
$headers1 = array('APELLIDO Y NOMBRES','DOCUMENTO','NACIMIENTO','BASE');
//$fecha_dos = strtotime("$fecha_uno");
//$dia = strftime("%B", strtotime(date("Y-m-d", $fecha_dos)));
fputcsv($file, $headers, ";");
fputcsv($file, $headers1, ";");
foreach ($jub_datos as $value) {

      //if($jub_sueldo==""){$a=$a."0.00|";}else{$a=$a.$jub_sueldo->cjmdg_detsueldo_importe."|";}
      $fec=new DateTime($value->legajo_fecnacto);
      $fec1=$fec->format('d/m/Y');
      $imp=$value->cjmdg_3011_base*3/1000;

      //if(strlen($value->cjmdg_personal_nrodoc)<8){$doc="0".$value->cjmdg_personal_nrodoc;}else{$doc=$value->cjmdg_personal_nrodoc;}
      //$cad=str_pad($value->cjmdg_personal_apellido." ".$value->cjmdg_personal_nombre,30," ", STR_PAD_RIGHT)."|".$doc."|".$fec1."|".$value->cjmdg_detsueldo_importe;
      //$cad=str_pad($value->cjmdg_personal_apellido." ".$value->cjmdg_personal_nombre,30," ", STR_PAD_RIGHT),.$doc.",".$fec1.",".$value->cjmdg_detsueldo_importe;

      $lineData = array(trim($value->legajo_apellido)." ".trim($value->legajo_nombres),$value->legajo_nrodocto,$fec1,number_format($imp,2,'.',''));
      fputcsv($file, $lineData, ";");
}
//exit();
// Close file
fclose($file);

// Send file to browser for download
//$dest_file = 'file.csv';
$dest_file = 'ley3011.csv';
$file_name = 'ley3011.csv';
$file_size = filesize($dest_file);

header("Content-Type: text/csv; charset=utf-8");
header("Content-disposition: attachment; filename=\"$file_name\"");
header("Content-Length: " . $file_size);
readfile($dest_file);
//borra el archivo
unlink($dest_file);
?>
