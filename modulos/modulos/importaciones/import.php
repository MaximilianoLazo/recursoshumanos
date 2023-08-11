<?php
//include_once("db_connect.php");
set_time_limit(1800);
require_once '../../database/Conexion.php';
require_once 'model/importacion.php';

$importacion = new Importacion();

if(isset($_POST['import_data'])){
    // validate to check uploaded file is a valid csv file
    $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
    if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$file_mimes)){
        if(is_uploaded_file($_FILES['file']['tmp_name'])){
            $csv_file = fopen($_FILES['file']['tmp_name'], 'r');
            //fgetcsv($csv_file);
            // get data records from csv file
            while(($datos = fgetcsv($csv_file, 1000, ";")) !== FALSE){
                // Check if employee already exists with same email
                $nrodocumento = $datos[3];
                $nrolegajo = $datos[0];
                $nombre = $datos[1];
                $importedos = $datos[7];
                list($entero, $decimal) = explode(",", $importedos);
                $importe = $entero.".".$decimal;
                $aumento = 0;
                $importeb = $entero.".".$decimal;
                //$importeu = $importe * 2.2 / 100;
                $importeu = $importe;

                $datosexistentes = $importacion->ObtenerDatosExitentes($nrodocumento);
                $datosexistentesc = count($datosexistentes);
                /*
                $sql_query = "SELECT * FROM carga2 WHERE carga_concepto = '".$datos[6]."'";
                $resultset = mysqli_query($conn, $sql_query) or die("database error:". mysqli_error($conn));
                */
				        // if employee already exist then update details otherwise insert new record
                if($datosexistentesc > 0) {
                   //---- ya existe
                   //$datosexistentesdos = $importacion->ObtenerDatosExitentesDos($nrodocumento);
                   //$aumento2 = 0;
                   //$aumento2 = $datosexistentesdos->legajo_importe;
                   //$impaum = $importe + $aumento2;
                   $importacion->RegistarAum($nrolegajo,$nrodocumento,$importeu);
                }else{
                  /*
                  if(is_numeric($nrodocumento)){
                    //es numerico se inserta
                    $importacion->RegistrarImp($nrolegajo,$nrodocumento,$importe,$nombre);
                  }else{
                    //no es numerico se descarta
                  }
                  */
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
header("Location: index.php".$import_status);
?>
