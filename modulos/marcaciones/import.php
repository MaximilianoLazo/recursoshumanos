<?php
//include_once("db_connect.php");
set_time_limit(2800);
require_once '../../database/Conexion.php';
require_once 'model/marcacion.php';

$marcacionmanual = new Marcacion();

if(isset($_POST['import_data'])){
    // validate to check uploaded file is a valid csv file

        //if(is_uploaded_file($_FILES['file']['tmp_name'])){
          $archivotmp = $_FILES['file']['tmp_name'];
          $lineas2 = file($archivotmp);
          $lineas = file($archivotmp);

          $periodo = $marcacionmanual->PeriodoActual();
          foreach($lineas2 as $numero2 => $linea2){

          }
          list($accessid, $fecdma, $horahm, $direccion, $espacio1, $espacio2, $nodo) = explode(" ", $linea2);
          list($dia, $mes, $año) = explode("/", $fecdma);
          //$nodo = 4;
          //-----Datos a insertar ------

          //if($periodo->periodo_cerrado == 0){
          $datosreloj = $marcacionmanual->ObtenerRelojNodo($nodo);
          $ip = $datosreloj->reloj_ip;
          if($direccion == "E"){
            $codigoe = 200;
          }elseif($direccion == "S"){
            $codigoe = 201;
          }else{
            $codigoe = 0;
          }
          $accion = "MIGRATION";
          $usuario = "root@localhost";

          $ultimoid = $marcacionmanual->RelojesSeg($ip, $nodo, $codigoe, $accion, $usuario);

          foreach($lineas as $numero => $linea){
            list($accessid, $fecdma, $horahm, $direccion, $espacio1, $espacio2, $nodo) = explode(" ", $linea);
            list($dia, $mes, $año) = explode("/", $fecdma);

            //----inicio extraer dni-----
            if($datosreloj->relojtipo_id == 1){
              $nrodocto = $accessid;
            }else{

              $dlegreloj = $marcacionmanual->ObtenerLegajoReloj($accessid);
              // Se evalúa a true ya que $var está vacia
              if(empty($dlegreloj->legempleado_nrodocto)){
                $nrodocto = 0;
              }else{
                $nrodocto = $dlegreloj->legempleado_nrodocto;
              }

            }
            //----fin extraer dni-----

            //-----Datos a insertar ------

            //if($periodo->periodo_cerrado == 0){
            //$datosreloj = $marcacionmanual->ObtenerRelojNodo($nodo);
            $ip = $datosreloj->reloj_ip;
            if($direccion == "E"){
              $codigoe = 200;
            }elseif($direccion == "S"){
              $codigoe = 201;
            }else{
              $codigoe = 0;
            }
            $accion = "MIGRATION";
            $usuario = "root@localhost";

            //$ultimoid = $marcacionmanual->RelojesSeg($ip, $nodo, $codigoe, $accion, $usuario);

            //-------------------------
            $accessidas = $accessid;
            $datetime = "20".$año."-".$mes."-".$dia." ".$horahm.":00";
            $direccionas = $codigoe;
            $sourceas = 99;
            $relojid = $datosreloj->reloj_id;
            //----- Instanciamos la clase ------
            $mark = new Marcacion();
            //------- Datos de Marcaciones ----
            $mark->Accessid = $accessidas;
            $mark->Nrodocto = $nrodocto;
            $mark->Datetime = $datetime;
            $mark->Direccion = $direccionas;
            $mark->Fuente = $sourceas;
            $mark->Relojid = $relojid;
            $mark->Ultimoid = $ultimoid;
            $mark->Estado = 1;
            $mark->Linea = $linea;
            //------ Insert de Marcaciones -----
            $marcacionmanual->MarcAutomatica($mark);


          }
          //-------- Recorrer marcaciones Insertadas y Procesar ------
          /*
          foreach($marcacionmanual->ObtenerMarcaciones($ultimoid) as $row){
            $marcacionid = $row->marcacion_id;
            $marcacionaccessid = $row->marcacion_accessid;
            $marcaciondatetime = $row->marcacion_datetime;
            //--

            $fecha_i = date("Y-m-d",strtotime($marcaciondatetime."-1 hours"));
            $fecha_f = date("Y-m-d",strtotime($marcaciondatetime."+1 hours"));

            //--
            $relojid = $row->reloj_id;
            $relojsegid = $row->relojseg_id;
            //$periodoinicio = $periodo->periodo_hsext_jor_i;
            //$periodofin = $periodo->periodo_hsext_jor_f;
            //$periodoid = $periodo->periodo_id;
            $marcacionmanual->ProcesarMarcaciones($marcacionid, $marcacionaccessid, $marcaciondatetime, $relojid, $relojsegid, $fecha_i, $fecha_f);
          }*/
            $import_status = '?import_status=success';
        /*} else {
            $import_status = '?import_status=error';
        }*/

}
//echo "$emp_record";
//header("Location: ../asignaciones/?c=asignacion&a=ImportarHaberesRemunerativos".$import_status);
header("Location: ../marcaciones/?c=marcacion&a=ImportarMarcacionesManual&id=$ultimoid");

?>
