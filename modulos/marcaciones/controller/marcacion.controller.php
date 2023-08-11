<?php
require_once 'model/marcacion.php';
session_start();
if(!isset($_SESSION["usuario_id"])){
  header("../legajos/login/index.php");
}

class MarcacionController{

    private $model;

    public function __CONSTRUCT(){
        $this->model = new Marcacion();
    }

    public function Index(){
      //require_once 'view/alumno.php';
    }
    public function FichadasTanda(){
      require_once 'view/fichadas-tanda.php';
    }
    public function FichadasTandaGuardar(){

        $FTE = new Marcacion();
        //------Variaables Hidden ----
        $FTE->FTEid = $_REQUEST['hddfictide'];
        //-----Variables del Formulario
        $FTE->FTEnombre = $_REQUEST['txtfichtntandae'];
        $FTE->FTEfecdesde = $_REQUEST['txtfictfecdesdee'];
        $FTE->FTEfechasta = $_REQUEST['txtfictfechastae'];
        $FTE->FTEfecproceso = $_REQUEST['txtfictfecprocesoe'];

        $FTE->FTEid > 0
            ? $this->model->FichadasTandaActualizar($FTE)
            : $this->model->FichadasTandaGuardarExe($FTE);

        header("Location: ../marcaciones/?c=marcacion&a=FichadasTanda");

    }
    public function FichadasTandaDetalles(){
      $fictandadetalles = new Marcacion();
      if(isset($_REQUEST['id'])){
        $fictandadetalles = $this->model->FichadasTandasDetallesObtener($_REQUEST['id']);
      }
      require_once 'view/fichadas-tanda-detalles.php';
    }
    public function FichadasTandaDetallesArchivo(){
      require_once 'view/fichadas-tanda-archivo.php';
    }
    public function FichadasTandaImportar(){
      $fictandaimportar = new Marcacion();
      if(isset($_POST['btnfichadaimportar'])){
        // validate to check uploaded file is a valid csv file
        $fictandaimportar->Mtandaid = $_REQUEST['hddmtandaide'];
        $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
        if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$file_mimes)){
          //
          if(is_uploaded_file($_FILES['file']['tmp_name'])){
              $csv_file = fopen($_FILES['file']['tmp_name'], 'r');
              //fgetcsv($csv_file);
              // get data records from csv file
              while(($datos = fgetcsv($csv_file, 1000, ";")) !== FALSE){
                // Check if employee already exists with same email
                $fictandaimportar->Trabajoid = 0;
                $fictandaimportar->Secretariaid = 0;
                $fictandaimportar->Relojid = 0;

                $nrodocto = intval(preg_replace('/[^0-9]+/', '', $datos[0]), 10);
                //echo $resultado; // resultado: 102030

                if(is_numeric($nrodocto) AND strlen($nrodocto) > 5){
                  //------- Si es numerico --------
                  //-------Verificar si existe DNI -----
                  $fictandadetallednidatosc = $this->model->FichadasTandasDetallesDNIFilasNum($fictandaimportar->Mtandaid, $nrodocto);
                  if($fictandadetallednidatosc->tandadetallec > 0){
                    //----EL numero de DNI ya existe en esta tanda, pasar al siguiene registro
                  }else{
                    //----El numero de DNI no existe en esta tanda
                    $fictandaimportar->Empndoc = $nrodocto;
                    $empleadodatos = $this->model->EmpleadoObtener($nrodocto);
                    if($empleadodatos->legtipo_id == 1){
                      //-----CONTRATADO
                      $contratadodatos = $this->model->ContratadoObtener($nrodocto);
                      $fictandaimportar->Trabajoid = $contratadodatos->trabajo_id;
                      $fictandaimportar->Secretariaid = $contratadodatos->secretaria_id;
                    }elseif($empleadodatos->legtipo_id == 2){
                      //-----JORNALERO
                      $jornalerodatos = $this->model->JornaleroObtener($nrodocto);
                      $fictandaimportar->Trabajoid = $jornalerodatos->trabajo_id;
                      $fictandaimportar->Secretariaid = $jornalerodatos->secretaria_id;
                    }elseif($empleadodatos->legtipo_id == 3){
                      //----PLANTA PERMANENTE
                      $ppermanentedatos = $this->model->PPermanenteObtener($nrodocto);
                      $fictandaimportar->Trabajoid = $ppermanentedatos->trabajo_id;
                      $fictandaimportar->Secretariaid = $ppermanentedatos->secretaria_id;
                    }elseif($empleadodatos->legtipo_id == 4){
                      //----PROVEEDOR
                      $proveedordatos = $this->model->ProveedorObtener($nrodocto);
                      $fictandaimportar->Trabajoid = $proveedordatos->trabajo_id;
                      $fictandaimportar->Secretariaid = $proveedordatos->secretaria_id;
                    }else{
                      //----DEFAULT, ERROR
                    }
                    $emprelojdatos = $this->model->EmpleadoXRelojObtener($nrodocto);
                    if($emprelojdatos->reloj_id > 0){
                      $fictandaimportar->Relojid = $emprelojdatos->reloj_id;
                    }else{
                      $fictandaimportar->Relojid = 13;
                    }
                    $this->model->FichadasTandaImportarExe($fictandaimportar);
                  }
                }else{
                  //---pasar siguiente registro, no cumple las condiciones de dni
                }
              }
              fclose($csv_file);
              $import_status = '?import_status=success';
          }else{
            $import_status = '?import_status=error';
          }
        }else{
          $import_status = '?import_status=invalid_file';
        }
      }
      header("Location: ../marcaciones/?c=marcacion&a=FichadasTandaDetalles&id=$fictandaimportar->Mtandaid");
    }
    public function FichadasTandaDetallesBaja(){
      $FTDB = new Marcacion();
      //-------datos personales -----
      //------Variables hidden ------
      $FTDB->MTid = $_REQUEST['hddmtandaide'];
      $FTDB->MTDetallesid = $_REQUEST['hddmtandadetalleide'];

      $this->model->FichadasTandaDetallesBajaExe($FTDB);
      header("Location: ../marcaciones/?c=marcacion&a=FichadasTandaDetalles&id=$FTDB->MTid");
    }
    public function FichadasTandaArchivar(){
      $FTB = new Marcacion();
      //-------datos personales -----
      //------Variables hidden ------
      $FTB->MTid = $_REQUEST['hddmartandaide'];
      //$FTDB->MTDetallesid = $_REQUEST['hddmtandadetalleide'];

      $this->model->FichadasTandaArchviarExe($FTB);
      header("Location: ../marcaciones/?c=marcacion&a=FichadasTanda");
    }
    public function FichadasTandaProceso(){
      date_default_timezone_set("America/Buenos_Aires");
      setlocale(LC_ALL, 'es_RA.UTF8');
      setlocale(LC_TIME, 'es_RA.utf-8','spanish');
      $fecha_actual = date("Y-m-d");
      $fictandadatos = $this->model->FichadasTandasXFechaListar($fecha_actual);
      //var_dump($fictandadasdatos);
      $fictandadatosc = count($fictandadatos);
      if($fictandadatosc > 0){
        //---Existen tandas para procesar
        require_once 'includes/pdf/fichadas-tanda.php';
        foreach($fictandadatos as $row){
          //--------------
          $fictandaid = $row->mtanda_id;
          $fictandanombre = $row->mtanda_nombre;
          $fictandafecdesde = $row->mtanda_fecha_desde;
          $fictandafechasta = $row->mtanda_fecha_hasta;
          $fictandadetalleiddatosc = $this->model->FichadasTandasDetallesIdFilasNum($fictandaid);
          if($fictandadetalleiddatosc->tandadetallec > 0){
            //-------tiene registros para procesar---
            $fictandadetallesdatos = $this->model->FichadasTandasDetallesXIdListar($fictandaid);
            //var_dump($fictandadetallesdatos);
            //$ver = include 'includes/pdf/fichadas-tanda.php';
            //require 'includes/pdf/fichadas-tanda.php';
            //require_once('includes/pdf/fichadas-tanda.php');
            //header("Location: ../marcaciones/?c=marcacion&a=FichadasTandaProcesoPrueba&id=$fictandaid");
            $res = FichadasTandasPDF($fictandadetallesdatos, $fictandaid, $fictandanombre, $fictandafecdesde, $fictandafechasta);
            //-----Pasar a proceso terminado, Insertar nombre de PDF------
            $this->model->FichadasTandaProcesoTerminar($res, $fictandaid);

            echo "Pase por Aqui: ".$fictandaid." - ".$res."<br>";



          }else{
            //-------No tiene registros para procesar ---
          }
        }
      }else{
        //--No existen tandas para procesar
      }
    }
    public function FichadasTandaDescarga(){
      $fileName = $_GET['id'];
      require_once 'includes/php/fichadas-tanda-descarga.php';
    }
    public function FichadasTandaDetallesEditarAutocompletar(){
      require_once 'includes/php/autocompletar_fichadas-tanda-detalles-editar.php';
    }
    public function FichadasTandaDetallesEditarHelp(){
      require_once 'includes/php/fichadas-tanda-detalles-editar-help.php';
    }
    public function FichadasTandaDetallesGuardar(){

      $FTDGI = new Marcacion();
      //-----Variables hidden ------
      $FTDGI->Mtandaid = $_REQUEST['hddfictandaide'];
      $FTDGI->Trabajoid = $_REQUEST['hddfictandadetalleltrabajoide'];
      $FTDGI->Secretariaid = $_REQUEST['hddfictandadetallesecrtariaide'];
      $FTDGI->Relojid = $_REQUEST['hddfictandadetallerelojide'];
      //----Variables del formulario -------
      $FTDGI->Empndoc = $_REQUEST['txtfictandadetallednieditar'];
      //------Funcion usada en importacion de tandas -----

      $fictandadetallednidatosc = $this->model->FichadasTandasDetallesDNIFilasNum($FTDGI->Mtandaid, $FTDGI->Empndoc);
      if($fictandadetallednidatosc->tandadetallec > 0){
        //----EL numero de DNI ya existe en esta tanda, agregar alerta con datos
      }else{
        //---- El numero de DNI no existe en esta tanda, Insertar registro
        $this->model->FichadasTandaImportarExe($FTDGI);
      }
      header("Location: ../marcaciones/?c=marcacion&a=FichadasTandaDetalles&id=$FTDGI->Mtandaid");

    }
    public function FichadasFechas(){
      require_once 'view/fichadas-fechas.php';
    }
    public function FichadasFechasRespuesta(){
      require_once 'view/fichadas-fechas-respuesta.php';
    }
    public function FichadasFechasPDF(){
      require_once 'includes/pdf/fichadas-fechas.php';
    }

    //////CODIGO antiguo//////////////////////



    public function BusquedaHistorico(){
      require_once 'view/busquedahistorico.php';
    }
    public function BusquedaPorReloj(){
      require_once 'view/busquedaporreloj.php';
    }
    public function BusquedaPorLote(){
      require_once 'view/fichadasporlote.php';
    }

    public function ImportarMarcacionesManual(){
      require_once 'view/marcacionesmanual.php';
    }
    public function ImprimirFichadaLoteI(){

      $nrodocto = $_GET['id'];
      require_once 'includes/pdf/fichadas-periodoil.php';

    }
    public function ImprimirFichadaLoteSinFiltro(){

      $nrodocto = $_GET['id'];
      require_once 'includes/pdf/fichadas-periodoisinfiltro.php';

    }
    public function ImprimirFichadaLoteSinFiltroDos(){

      $nrodocto = $_GET['id'];
      require_once 'includes/pdf/fichadas-periodoisinfiltro-dos.php';

    }
    public function MarcacionesReprocesar(){
      date_default_timezone_set("America/Buenos_Aires");
      $fecha_actual = date("Y-m-d");
      $accessid = $_GET['id'];

      $fecha_inicio = $this->model->ObtenerFecInicio();
      $fecha_final = $fecha_actual;
      foreach($this->model->ObtenerMarcacionesDes($fecha_inicio,$fecha_final,$accessid) as $row){
        $marcacionid = $row->marcacion_id;
        $marcacionaccessid = $row->marcacion_accessid;
        $marcaciondatetime = $row->marcacion_datetime;

        /*
        $marcacionfecha = date("Y-m-d", strtotime($marcaciondatetime));
        $fecha_i = date("Y-m-d",strtotime($marcacionfecha."- 1 days"));
        $fecha_f = date("Y-m-d",strtotime($marcacionfecha."+ 1 days"));
        */
        $fecha_i = date("Y-m-d",strtotime($marcaciondatetime."-1 hours"));
        $fecha_f = date("Y-m-d",strtotime($marcaciondatetime."+1 hours"));

        $relojid = $row->reloj_id;
        $relojsegid = $row->relojseg_id;

        $this->model->MarcacionesReprocesarExe($marcacionid, $marcacionaccessid, $marcaciondatetime, $relojid, $relojsegid, $fecha_i, $fecha_f);
        //$this->model->ProcesarMarcacionesRe($marcacionid, $marcacionaccessid, $marcaciondatetime, $relojid, $relojsegid, $fecha_i, $fecha_f);
      }

      //header("Location: index.php?c=marcacion&a=Crud&id=$rel->EmpId&startIndex=3");
      header("Location: index.php?c=marcacion&a=BusquedaPorFecha&id=25");
      //<li><a href="../marcaciones/?c=marcacion&a=BusquedaPorFecha">Busqueda por Fecha</a></li>
    }
    public function BusquedaPorFechaHelp(){
      require_once 'includes/php/busquedaporfecha-help.php';
    }
    /*
    public function GuardarMarcacionA(){
      exec('c:\WINDOWS\system32\cmd.exe /c START /B C:\xampp\htdocs\controlhorario\itktool\automatico.bat');
      $lineas = file('../../itktool/automatico-respuesta.txt');
      foreach($lineas as $numero => $linea){
      $dato = explode(" ", $linea);
      //-----Datos a insertar ------
      $ippuerto = explode(":", $dato[0]);
      $ip = $ippuerto[0];
      $nodo = $dato[1];
      $codigoe = $dato[2];
      $accion = "AUTOMATICO";
      $usuario = "root@localhost";

        $this->model->RelojesSeg($ip, $nodo, $codigoe, $accion, $usuario);
      }

		$reloj = new Marcacion();

    $reloj->Habilitar = 1;


		foreach($this->model->ListarRelojes($reloj) as $row){

		//----------Elimina los espacios de la variable------
		$nomarchivo = str_replace(' ', '', $row->reloj_nombre);
		//----------Pone todo el contenico de la variable en minuscula-----
		$nomarchivo = strtolower($nomarchivo);

		$xml = simplexml_load_file("../../itktool/historico_$nomarchivo.xml") or die("Error: Cannot create object");

		foreach ($xml->mark as $rowas) {

    	$accessidas = $rowas->access_id;
			$direccionas = $rowas->direction;
    	$sourceas = $rowas->source;
			$yearas = $rowas->datetime->year;
			$monthas = $rowas->datetime->month;
			$dayas = $rowas->datetime->day;
			$houras = $rowas->datetime->hour;
			$minuteas = $rowas->datetime->minute;
      $segundos = "00";
			$datatime = $yearas."-".$monthas."-".$dayas." ".$houras.":".$minuteas;
			//$datatimehoraas = $houras.":".$minuteas;
			$relojid = $row->reloj_id;

      $mark = new Marcacion();

			$mark->Accessid = $accessidas;
			$mark->Datetime = $datatime;
			//$mark->Hora = $datatimehoraas;
    	$mark->Direccion = $direccionas;
			$mark->Fuente = $sourceas;
      $mark->Relojid = $relojid;

        	$this->model->MarcacionAutomatica($mark);


	    }

      }

	}
  */
 }
