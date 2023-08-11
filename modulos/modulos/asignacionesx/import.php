<?php
//include_once("db_connect.php");
set_time_limit(2800);
require_once '../../database/Conexion.php';
require_once 'model/asignacion.php';

$haberremuneracion = new Asignacion();

if(isset($_POST['btnhremunerativosimportar'])){
    // validate to check uploaded file is a valid csv file
    $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
    if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$file_mimes)){
        if(is_uploaded_file($_FILES['file']['tmp_name'])){
            $csv_file = fopen($_FILES['file']['tmp_name'], 'r');
            //fgetcsv($csv_file);
            // get data records from csv file
            while(($datos = fgetcsv($csv_file, 1000, ";")) !== FALSE){
                // Check if employee already exists with same email
                //$concepto = $datos[8];
                $periodoactual = $haberremuneracion->PeriodoActualObtener();
                $periodoid = $periodoactual->periodo_id;
                $haberesexistentes = $haberremuneracion->ObtenerHaberesExistentes($periodoid);
                $haberesexistentesc = count($haberesexistentes);
                /*
                $sql_query = "SELECT * FROM carga2 WHERE carga_concepto = '".$datos[6]."'";
                $resultset = mysqli_query($conn, $sql_query) or die("database error:". mysqli_error($conn));
                */
				        // if employee already exist then update details otherwise insert new record
                if($haberesexistentesc > 15555) {
                   //---- ya existe
                   /*
					         $sql_update = "UPDATE carga2 set carga_contraparte='".$datos[5]."', carga_estado='".$datos[7]."', carga_importe='".$datos[8]."' WHERE carga_concepto = '".$datos[6]."'";
                   mysqli_query($conn, $sql_update) or die("database error:". mysqli_error($conn));
                   */
                }else{
                  //
                  /*
                  $fechahora = $datos[0];
                  list($fecha2, $hora) = explode(" ", $fechahora);
                  list($dia, $mes, $año) = explode("/", $fecha2);
                  $fechabien = $año."-".$mes."-".$dia;
                  list($hora2, $minutos) = explode(":", $hora);

                  if(strlen($hora2) == 1){
                    //la hora tiene un solo digito
                    $horabien = "0".$hora2.":".$minutos;
                    $fecha = $fechabien." ".$horabien;
                  }else{
                    //la hora esta bien
                    $fecha = $fechabien." ".$hora2.":".$minutos;
                  }
                  */

                  $empleadonro = $datos[0];
                  $centrocostos = $datos[3];
                  $sac = (string)$datos[4];
                  $sac2 = (string)$sac;
                  $sacdecimal = str_replace(',', '.', $sac2);
                  $importe = (string)$datos[5];
                  $importe2 = (string)$importe;
                  $importedecimal = str_replace(',', '.', $importe2);
                  $impdecdifinitivo = $importedecimal - $sacdecimal;
                  $empleadonrodocto = $datos[2];
                  $estado = 1;
                  /*
                  $montoorginal = intval(preg_replace('/[^0-9]+/', '', $montoorginals), 10);

                  $montonetos = $datos[12];
                  $montoneto = intval(preg_replace('/[^0-9]+/', '', $montonetos), 10);


                  */
                  //
                  /*
					        $mysql_insert = "INSERT INTO carga2 (carga_concepto, carga_contraparte, carga_estado, carga_importe )VALUES('".$datos[6]."', '".$datos[5]."', '".$datos[7]."', '".$datos[8]."')";
					        mysqli_query($conn, $mysql_insert) or die("database error:". mysqli_error($conn));
                  */
                  if(is_numeric($empleadonro)){
                    //es numerico se inserta
                    $haberremuneracion->RegistrarHaberRemun($empleadonro,$empleadonrodocto,$centrocostos,$impdecdifinitivo,$periodoid,$estado);
                  }else{
                    //no es numerico se descarta

                  }
                }
            }
            fclose($csv_file);
            $import_status = '?import_status=success';
        } else {
            $import_status = '?import_status=error';
        }
    } else {
        $import_status = '?import_status=invalid_file';
    }
}
//echo "$emp_record";
//header("Location: ../asignaciones/?c=asignacion&a=ImportarHaberesRemunerativos".$import_status);
header("Location: ../asignaciones/?c=asignacion&a=ImportarHaberesRemunerativos");
?>
