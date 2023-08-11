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
        $periodoob = new Marcacionautomatica();
        $periodo = $periodoob->PeriodoActual();
        //$periodocerrado = $periodo->periodo_cerrado;
        if($periodo->periodo_cerrado == 0){
          //----- Periodo actual abierto -------
          exec('c:\WINDOWS\system32\cmd.exe /c START /B C:\xampp\htdocs\controlhorario\itktool\automatico.bat');
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
              foreach($this->model->ObtenerReloj($ip, $nodo) as $row){
                //----------Elimina los espacios de la variable------
            		$nomarchivo = str_replace(' ', '', $row->reloj_nombre);
            		//----------Pone todo el contenico de la variable en minuscula-----
            		$nomarchivo = strtolower($nomarchivo);
                //----------Obtener archivo xml --------------
            		$xml = simplexml_load_file("../../itktool/historico/historico_$nomarchivo.xml") or die("Error: Cannot create object");
                //---------- Recorrer archivo xml --------
                foreach ($xml->mark as $rowas) {
                	$accessidas = $rowas->access_id;
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
            			$mark->Datetime = $datetime;
                	$mark->Direccion = $direccionas;
            			$mark->Fuente = $sourceas;
                  $mark->Relojid = $relojid;
                  $mark->Ultimoid = $ultimoid;
                  $mark->Estado = 1;
                  //------ Insert de Marcaciones -----
                  $this->model->MarcAutomatica($mark);
            	   }
              }
              //-------- Recorrer marcaciones Insertadas y Procesar ------
              foreach($this->model->ObtenerMarcaciones($ultimoid) as $row){
                $marcacionid = $row->marcacion_id;
                $marcacionaccessid = $row->marcacion_accessid;
                $marcaciondatetime = $row->marcacion_datetime;
                $relojid = $row->reloj_id;
                $relojsegid = $row->relojseg_id;
                $periodoinicio = $periodo->periodo_hsext_jor_i;
                $periodofin = $periodo->periodo_hsext_jor_f;
                $periodoid = $periodo->periodo_id;
                $this->model->ProcesarMarcaciones($marcacionid, $marcacionaccessid, $marcaciondatetime, $relojid, $relojsegid, $periodoid, $periodoinicio, $periodofin);
              }
            }else{
              // -------- No se pudo establecer Conexion con el reloj o la tabla esta vacia -----
            }
          }
        }else{
          //----- Periodo cerrado, las marcaciones no se procesan
          echo "periodo cerrado";
        }
	   }
 }
