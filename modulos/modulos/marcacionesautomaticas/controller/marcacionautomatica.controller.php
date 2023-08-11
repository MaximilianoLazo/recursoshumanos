<?php
require_once 'model/marcacionautomatica.php';
class MarcacionautomaticaController{
    private $model;
    public function __CONSTRUCT(){
      $this->model = new Marcacionautomatica();
    }
    public function Index(){
      //require_once 'view/licencia.php';
    }
    public function GuardarMarcacionA(){
        //-------Preguntar si el periodo esta abierto -------
        date_default_timezone_set("America/Buenos_Aires");
        setlocale(LC_ALL, 'es_RA.UTF8');
        setlocale(LC_TIME, 'es_RA.utf-8','spanish');
        $año = date("Y");
        $mesletra = strftime("%B");
        $mesnumero = strftime("%m");
        $dianumero = strftime("%d");
        $dialetra = strftime("%A");
        $fecha = date("Y-m-d");
        $fechanumerica = date("Ymd");
        $horanumerica = date("His");

        $periodo_actual = new Marcacionautomatica();
        $periodo = $periodo_actual->PeriodoActual();
        $periodo_actual->PerioidOld = $periodo->periodo_id;
        $periodohsi = $periodo->periodo_hsext_jor_i;
        $periodohsf = $periodo->periodo_hsext_jor_f;
        $periodoprei = $periodo->periodo_presentismo_i;
        $periodopref = $periodo->periodo_presentismo_f;

        if($periodohsf >= $fecha){
          //---Periodo actual en vigencia ---

        }else{
          //---Periodo actual vencido, Crear Nuevo ----
          //---creando fecha inicio nuevo periodo
          //--- horas extras y jornal----
          $periodohsf_arr = date("Y-m-d", strtotime($periodohsf));
          $periodo_actual->PeriodohsiNew = date("Y-m-d",strtotime($periodohsf_arr."+ 1 days"));
          //--- Presentismo -----
          $periodoprei_arr = date("Y-m-d", strtotime($periodoprei));
          $periodo_actual->PeriodopreiNew = date("Y-m-d",strtotime($periodoprei_arr."+ 1 month"));
          //----Creando fecha final nuevo periodo ---
          //--- horas extras y jornal----
          $periodohsf_nuevo_año = $año;
          $periodohsf_nuevo_mes = date("m",strtotime($periodo_actual->PeriodohsiNew."+ 1 month"));
          $periodohsf_nuevo_dia = 14;
          $periodo_actual->PeriodohsfNew = $periodohsf_nuevo_año."-".$periodohsf_nuevo_mes."-".$periodohsf_nuevo_dia;
          //---- Presentismo -----
          $periodoprei_arr = new DateTime($periodo_actual->PeriodopreiNew);
          $periodoprei_arr->modify('last day of this month');
          $periodo_actual->PeriodoprefNew = $periodoprei_arr->format('Y-m-d'); // imprime por ejemplo: 31/12/2012
          //----nombre de periodo-----
          $periodo_actual->Periodonombre = $periodohsf_nuevo_año."".$periodohsf_nuevo_mes;

          //$periodo_actual->GuardarPeriodoNuevo($periodoanteriorid,$periodo_nombre,$periodohsi_nuevo,$periodohsf_nuevo,$periodoprei_nuevo,$periodopref_nuevo);
          $this->model->GuardarPeriodoNuevo($periodo_actual);

          /*$periodo = $periodo_actual->PeriodoActual();
          $periodo_actual->PerioidOld = $periodo->periodo_id;
          $periodohsi = $periodo->periodo_hsext_jor_i;
          $periodohsf = $periodo->periodo_hsext_jor_f;
          $periodoprei = $periodo->periodo_presentismo_i;
          $periodopref = $periodo->periodo_presentismo_f;*/

        }

        //-----Seguir con el proceso -----
        exec('c:\WINDOWS\system32\cmd.exe /c START /B C:\xampp\htdocs\controlhorario\itktool\automatico.bat');
        //--- Aqui empezar backup marcaciones
        //-----crear carpeta años
        $path = "C:/xampp/htdocs/controlhorario/itktool/backup/$año";
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        //----Crear Carpeta Meses
        $path = "C:/xampp/htdocs/controlhorario/itktool/backup/$año/$mesnumero.$mesletra/";
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        //----Crear Carpeta dias
        $path = "C:/xampp/htdocs/controlhorario/itktool/backup/$año/$mesnumero.$mesletra/$dianumero.$dialetra";
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        //creamos una instancia de ZipArchive
        $zip = new ZipArchive();
        /*directorio a comprimir
         * la barra inclinada al final es importante
         * la ruta debe ser relativa no absoluta
         */
        $dir = 'C:/xampp/htdocs/controlhorario/itktool/historico/';
        //ruta donde guardar los archivos zip, ya debe existir
        $rutaFinal = "C:/xampp/htdocs/controlhorario/itktool/backup/$año/$mesnumero.$mesletra/$dianumero.$dialetra";

        if(!file_exists($rutaFinal)){
          mkdir($rutaFinal);
        }

        $archivoZip = $horanumerica.".zip";

        if ($zip->open($archivoZip, ZIPARCHIVE::CREATE) === true) {
          $periodo_actual->agregar_zip($dir, $zip, $horanumerica);
          $zip->close();

          //Muevo el archivo a una ruta
          //donde no se mezcle los zip con los demas archivos
          rename($archivoZip, "$rutaFinal/$archivoZip");

          //Hasta aqui el archivo zip ya esta creado

        }
        // --- Termina aqui backup marcaciones
        $lineas = file('../../itktool/automatico-respuesta.txt');
        foreach($lineas as $numero => $linea){
          $dato = explode(" ", $linea);
          //-----Datos de estados de relojes a insertar ------
          $ippuerto = explode(":", $dato[0]);
          $ip = $ippuerto[0];
          $nodo = $dato[1];
          $codigoe = $dato[2];
          $accion = "AUTOMATICO";
          $usuario = "root@localhost";
          //---------- Insertar datos de relojes--------
          $ultimoid = $this->model->RelojesSeg($ip, $nodo, $codigoe, $accion, $usuario);
          //---------- Si la Conexion se establecio, insertar marcaciones ------
          if($codigoe == 1){
            $row = $this->model->ObtenerReloj($ip, $nodo);
            //----------Elimina los espacios de la variable------
            $nomarchivo = str_replace(' ', '', $row->reloj_nombre);
            //----------Pone todo el contenico de la variable en minuscula-----
            $nomarchivo = strtolower($nomarchivo);
            //----------Obtener archivo xml --------------
            $xml = simplexml_load_file("../../itktool/historico/historico_$nomarchivo.xml") or die("Error: Cannot create object");
            //---------- Recorrer archivo xml --------
            foreach ($xml->mark as $rowas) {
              $accessidas = $rowas->access_id;
              //----inicio extraer dni-----
              if($row->relojtipo_id == 1){
                $nrodocto = $rowas->access_id;
              }else{
                $dlegreloj = $this->model->ObtenerLegajoReloj($accessidas);
                // Se evalúa a true ya que $var está vacia
                if(empty($dlegreloj->legempleado_nrodocto)){
                  $nrodocto = 0;
                }else{
                  $nrodocto = $dlegreloj->legempleado_nrodocto;
                }
              }
              //----fin extraer dni-----

              $direccionas = $rowas->direction;
              $sourceas = $rowas->source;
              $yearas = $rowas->datetime->year;
              $monthas = $rowas->datetime->month;
              $dayas = $rowas->datetime->day;
              $houras = $rowas->datetime->hour;
              $minuteas = $rowas->datetime->minute;
              $datetime = $yearas."-".$monthas."-".$dayas." ".$houras.":".$minuteas;
              $relojid = $row->reloj_id;
              //----- Instanciamos la clase ------
              $mark = new Marcacionautomatica();
              //------- Datos de Marcaciones ----
              $mark->Accessid = $accessidas;
              $mark->Nrodocto = $nrodocto;
              $mark->Datetime = $datetime;
              $mark->Direccion = $direccionas;
              $mark->Fuente = $sourceas;
              $mark->Relojid = $relojid;
              $mark->Ultimoid = $ultimoid;
              $mark->Estado = 1;
              //------ Insert de Marcaciones -----
              $this->model->MarcAutomatica($mark);
             }
            //}
            //-------- Recorrer marcaciones Insertadas y Procesar ------
            foreach($this->model->ObtenerMarcaciones($ultimoid) as $row){
              $marcacionid = $row->marcacion_id;
              $marcacionaccessid = $row->marcacion_accessid;
              $marcaciondatetime = $row->marcacion_datetime;
              //--
              $marcacionfecha = date("Y-m-d", strtotime($marcaciondatetime));
              $fecha_i = date("Y-m-d",strtotime($marcacionfecha."- 1 days"));
              $fecha_f = date("Y-m-d",strtotime($marcacionfecha."+ 1 days"));
              //--
              $relojid = $row->reloj_id;
              $relojsegid = $row->relojseg_id;
              //$periodoinicio = $periodo->periodo_hsext_jor_i;
              //$periodofin = $periodo->periodo_hsext_jor_f;
              //$periodoid = $periodo->periodo_id;
              $this->model->ProcesarMarcaciones($marcacionid, $marcacionaccessid, $marcaciondatetime, $relojid, $relojsegid, $fecha_i, $fecha_f);
            }
          }else{
            // -------- No se pudo establecer Conexion con el reloj o la tabla esta vacia -----
          }
        }
	   }
 }
