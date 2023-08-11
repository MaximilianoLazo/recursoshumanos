<?php
require_once 'model/marcacion.php';

class MarcacionController{

    private $model;

    public function __CONSTRUCT(){
        $this->model = new Marcacion();
    }


    public function Index(){

        //require_once 'view/header.php';
        //require_once 'view/alumno.php';
        //require_once 'view/footer.php';

    }
    public function BusquedaPorFecha(){

        //require_once 'view/header.php';
        require_once 'view/busquedaporfecha.php';
        //require_once 'view/footer.php';

    }
    public function BusquedaHistorico(){

        //require_once 'view/header.php';
        require_once 'view/busquedahistorico.php';
        //require_once 'view/footer.php';

    }

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
 }
