<?php
  $periodoactual = $this->model->PeriodoActualObtener();
  $periodoid = $periodoactual->periodo_id;
  //$datosexportob = $this->model->SueldoBasicoObtener($periodoactual->periodo_id);
  $sbasico_datos = $this->model->SueldoBasicoObtener(37);
  //----sona horario y formato de fechas--------
  date_default_timezone_set("America/Buenos_Aires");
  //setlocale(LC_ALL,"es_ES");
  setlocale(LC_ALL, 'es_RA.UTF8');
  //setlocale(LC_TIME, "es_RA.UTF-8");
  setlocale(LC_TIME, 'es_RA.utf-8','spanish');
  //setlocale('es_ES.UTF-8'); // I'm french !
  //////////////////////////////////////////////////////////////////

  // Abrir el archivo, creándolo si no existe:
  //$archivo = fopen("datos.DAT","w+b");
  $archivo = fopen("archivo.txt", "w");
  if($archivo == false){
    echo "Error al crear el archivo";
  }else{
    //
   // Escribir en el archivo:
   foreach ($sbasico_datos as $value) {
     // code...
     //---obtner apellido y nombres
     $empleado_datos = $this->model->EmpleadoObtener_APYNOM($value->legempleado_nrodocto);
     $apnom = $empleado_datos->legempleado_apellido." ".$empleado_datos->legempleado_nombres;
     $apnom = iconv("UTF-8", "Windows-1252", $apnom);
     //---obtner codigo 353 - seguro de vida
     //$seguro_vida = $this->model->LiquidacionCodigoYDNIObtener($value->legempleado_nrodocto, 353, $periodoactual->periodo_id);
     $seguro_vida = $this->model->LiquidacionCodigoYDNIObtener($value->legempleado_nrodocto, 353, 37);
     if($seguro_vida->liquidacion_importe > 0){
       $control_numero = 2;
     }else{
       $control_numero = 4;
     }
     fwrite($archivo, "6 | $value->legempleado_nrodocto | $apnom | $value->liquidacion_importe | $control_numero |".PHP_EOL);

   }
   //fwrite($archivo, "021013108204749827820000567540004681\r\n");
   /*
   fwrite($file, "Esto es una nueva linea de texto" . PHP_EOL);
   */
   //Fuerza a que se escriban los datos pendientes en el buffer:
   fflush($archivo);
  }
  // Cerrar el archivo:
  fclose($archivo);

  $dest_file = 'archivo.txt';
  $file_size = filesize($dest_file);

  header("Content-Type: text/plain; charset=utf-8");
  header("Content-disposition: attachment; filename=\"archivo.txt\"");
  header("Content-Length: " . $file_size);
  readfile($dest_file);
  //borra el archivo
  unlink($dest_file);

?>
