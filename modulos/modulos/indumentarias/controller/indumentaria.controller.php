<?php
require_once 'model/indumentaria.php';

session_start();
if(!isset($_SESSION["usuario_id"])){
	header("../legajos/login/index.php");
}
//----sona horario y formato de fechas--------
date_default_timezone_set("America/Buenos_Aires");
//setlocale(LC_ALL,"es_ES");
setlocale(LC_ALL, 'es_RA.UTF8');
//setlocale(LC_TIME, "es_RA.UTF-8");
setlocale(LC_TIME, 'es_RA.utf-8','spanish');
//setlocale('es_ES.UTF-8'); // I'm french !

class IndumentariaController{

    private $model;

    public function __CONSTRUCT(){
        $this->model = new Indumentaria();
    }

    public function Index(){
      require_once 'view/indumentaria.php';
    }
		public function IndumentariaRespuesta(){
      require_once 'view/indumentaria-respuesta.php';
    }
		public function IndumentariaHelp(){
			require_once 'includes/php/indumentaria-help.php';
    }
		public function IndumentariaTalleObtener(){
      require_once 'includes/php/indumentaria-talle-obtener.php';
    }
		public function IndumentariaCarroGuardar(){
			$datetime = new DateTime();
			$fecha_actual = $datetime->format('Y-m-d');

      $ica = new Indumentaria();

			$ica->Indentregaid = $_REQUEST['IndEntregaId'];
			$ica->Empndoc = $_REQUEST['Empndoc'];

			$datosmumorden = $this->model->IndumentariaOrdenObtener($ica->Empndoc);
			// Se evalúa a true ya que $var está vacia
			if(empty($datosmumorden->indumentaria_orden_id)){
    		//echo '$var es o bien 0, vacía, o no se encuentra definida en absoluto';
				$ica->Indumentariaorden = $this->model->IndumentariaOrdenGuardarExe($ica->Empndoc);
			}else{
				$ica->Indumentariaorden = $datosmumorden->indumentaria_orden_id;
			}

			$empleadodatos = $this->model->EmpleadoObtener($ica->Empndoc);
			//----obtner lugar de trabajo y secretaria
			if($empleadodatos->legtipo_id == 1){
				//-----CONTRATADO
				$contratadodatos = $this->model->ContratadoObtener($ica->Empndoc);
				$ica->Trabajoid = $contratadodatos->trabajo_id;
				$ica->Secretariaid = $contratadodatos->secretaria_id;
			}elseif($empleadodatos->legtipo_id == 2){
				//-----JORNALERO
				$jornalerodatos = $this->model->JornaleroObtener($ica->Empndoc);
				$ica->Trabajoid = $jornalerodatos->trabajo_id;
				$ica->Secretariaid = $jornalerodatos->secretaria_id;
			}elseif($empleadodatos->legtipo_id == 3){
				//----PLANTA PERMANENTE
				$ppermanentedatos = $this->model->PPermanenteObtener($ica->Empndoc);
				$ica->Trabajoid = $ppermanentedatos->trabajo_id;
				$ica->Secretariaid = $ppermanentedatos->secretaria_id;
			}elseif($empleadodatos->legtipo_id == 4){
				//----PROVEEDOR
				$proveedordatos = $this->model->ProveedorObtener($ica->Empndoc);
				$ica->Trabajoid = $proveedordatos->trabajo_id;
				$ica->Secretariaid = $proveedordatos->secretaria_id;
			}else{
				//----DEFAULT, ERROR
			}

      $ica->Indumentariaid = $_REQUEST['IndumentariaId'];
      $ica->Talleid = $_REQUEST['TalleId'];
      $ica->Colorid = $_REQUEST['ColorId'];
      $ica->Indumentariac = $_REQUEST['IndumentariaC'];
      $ica->Indumentariaobs = $_REQUEST['IndumentariaObs'];
			$ica->IndumentariaFecha = $fecha_actual;

			$ica->Indentregaid > 0
					? $this->model->IndumentariaCarroActualizar($ica)
					: $this->model->IndumentariaCarroGuardarExe($ica);

			require_once 'includes/php/indumentaria-carro-datos.php';
    }
		public function IndumentariaCarroEliminar(){
      $ica = new Indumentaria();

			$ica->Indentregaid = $_REQUEST['IndEntregaId'];
			$ica->Empndoc = $_REQUEST['Empndoc'];

			$this->model->IndumentariaCarroEliminarExe($ica);

			require_once 'includes/php/indumentaria-carro-datos.php';
    }
		public function IndumentariaEntregaGuardar(){
			$datetime = new DateTime();
			$fecha_actual = $datetime->format('Y-m-d');

			//$entrega_numero = $_REQUEST['id'];
			$entrega_numero = $_REQUEST['hddindordenide'];

			$this->model->IndumentariaOrdenTerminar($entrega_numero);
			$this->model->IndumentariaEntregaGuardarExe($entrega_numero, $fecha_actual);

			$opstock = $_REQUEST['ckecindentrega'];
      if($opstock == 1){
				//---Descontar Stock ----
				$this->model->IndumentariaStockDescontar($entrega_numero, $fecha_actual);
      }else{
				//---No se descuenta Stock
			}

			header("Location: index.php?c=indumentaria&a=IndumentariaEntregaExito&id=$entrega_numero");

    }
		public function IndumentariaEntregaExito(){
			require_once 'view/indumentaria-entrega-exito.php';
    }
		public function IndumentariaESExito(){
			require_once 'view/indumentaria-entrega-stock-exito.php';
    }
		public function IndumentariaEntregaExitoComprobante(){
			require_once 'includes/pdf/indumentaria-entrega-comprobante.php';
    }
		public function IndumentariaEntregada(){
      require_once 'includes/php/indumentaria-entregada-datos.php';
    }
		public function IndumentariaEntregaListadoEmp(){
			require_once 'includes/pdf/indumentaria-entrega-listado-empleado.php';
    }
		public function IndumentariaEntregadaListados(){
      require_once 'view/indumentaria-entregada-listados.php';
    }
		public function IndumentariaEntregadaListadosEmpleados(){
      require_once 'view/indumentaria-entregada-listados-empleados.php';
    }
		public function IndumentariaEntregadaListadosEmpleadosDatos(){
      require_once 'includes/php/indumentaria-entregada-listados-empleados-datos.php';
    }
		public function IndumentariaEntregadaListadosEmpleadosPDF(){
      require_once 'includes/pdf/indumentaria-entrega-listado-empleados.php';
    }
		/*public function IndumentariaEntregadaListadosDos(){
      require_once 'view/indumentaria-entregada-listados-dos.php';
    }*/
		/*public function IndumentariaEntregadaListadosRespuesta(){
      require_once 'view/indumentaria-entregada-listados-respuesta.php';
    }*/
		/*public function IndumentariaEntregadaListadoFechasSecLTrabajo(){
      require_once 'includes/php/indumentaria-entregada-listado-fec-sec-ltrabajo.php';
    }*/
		public function IndumentariaTipoTalleColorABM(){
      require_once 'view/indumentariatipo-talle-color-abm.php';
    }
		public function IndumentariaTipoGuardar(){
        $intt = new Indumentaria();

        $intt->TipoIndumentariaid = $_REQUEST['hddindtipoide'];
        $intt->TipoIndumentarianombre = $_REQUEST['txtindtiponombree'];


        $intt->TipoIndumentariaid > 0
            ? $this->model->IndumentariaTipoActualizar($intt)
            : $this->model->IndumentariaTipoGuardarExe($intt);

				header("Location: index.php?c=indumentaria&a=IndumentariaTipoTalleColorABM");

    }
		public function IndumentariaTipoEliminar(){
        $intteliminar = new Indumentaria();

        $intteliminar->TipoIndumentariaid = $_REQUEST['hddindumentariaidd'];

        $this->model->IndumentariaTipoEliminarExe($intteliminar);

				header("Location: index.php?c=indumentaria&a=IndumentariaTipoTalleColorABM");

    }
		public function IndumentariaTalleGuardar(){
        $inttalle = new Indumentaria();

        $inttalle->Talleindumentariaid = $_REQUEST['hddindtalleide'];
        $inttalle->Talleindumentarianombre = $_REQUEST['txtindumentariatallenombree'];
				$inttalle->Induementariaid = $_REQUEST['cboindumentarianombrete'];

        $inttalle->Talleindumentariaid > 0
            ? $this->model->IndumentariaTalleActualizar($inttalle)
            : $this->model->IndumentariaTalleGuardarExe($inttalle);

				header("Location: index.php?c=indumentaria&a=IndumentariaTipoTalleColorABM");

    }
		public function IndumentariaTalleEliminar(){
        $inttalleeliminar = new Indumentaria();

        $inttalleeliminar->TalleIndumentariaid = $_REQUEST['hddindumentariatalleidd'];

        $this->model->IndumentariaTalleEliminarExe($inttalleeliminar);

				header("Location: index.php?c=indumentaria&a=IndumentariaTipoTalleColorABM");

    }
		public function IndumentariaColorGuardar(){
        $intcolor = new Indumentaria();

        $intcolor->Colorindumentariaid = $_REQUEST['hddindcoloride'];
        $intcolor->Colorindumentarianombre = $_REQUEST['txtindcolornombree'];

        $intcolor->Colorindumentariaid > 0
            ? $this->model->IndumentariaColorActualizar($intcolor)
            : $this->model->IndumentariaColorGuardarExe($intcolor);

				header("Location: index.php?c=indumentaria&a=IndumentariaTipoTalleColorABM");

    }
		public function IndumentariaColorEliminar(){
        $intcoloreliminar = new Indumentaria();

        $intcoloreliminar->ColorIndumentariaid = $_REQUEST['hddindumentariacoloridd'];

        $this->model->IndumentariaColorEliminarExe($intcoloreliminar);

				header("Location: index.php?c=indumentaria&a=IndumentariaTipoTalleColorABM");

    }
		public function IndumentariaStock(){
      require_once 'view/indumentaria-stock.php';
    }
		public function IndumentariaStockGuardar(){
        $indstock = new Indumentaria();

				$indstock->Stockindumentariaid = $_REQUEST['hddindstockide'];
				$indstock->Stockindumentariac = $_REQUEST['hddindstockcantidade'];
        $indstock->Stockindumentariacbarras = $_REQUEST['txtindstockcbarrase'];
        $indstock->Indumentariaid = $_REQUEST['cboindstocknombree'];
				$indstock->Indumentariatalleid = $_REQUEST['cboindstocktallee'];
        $indstock->Indumentariacolorid = $_REQUEST['cboindstockcolore'];
				$indstock->Stockindumentariacantidad = $_REQUEST['txtindstockcantidade'];
        $indstock->Stockindumentariacantidadmin = $_REQUEST['txtindstockcantidadmine'];

				if($indstock->Stockindumentariaid > 0){
					//----Boton Editar
					$indstock->Stockindumentariacantidad = $indstock->Stockindumentariacantidad +
																								 $indstock->Stockindumentariac;
				}else{
					//---Boton Agregar
				}

        $indstock->Stockindumentariaid > 0
            ? $this->model->IndumentariaStockActualizar($indstock)
            : $this->model->IndumentariaStockGuardarExe($indstock);
				//$this->model->IndumentariaStockGuardarExe($indstock);

				header("Location: index.php?c=indumentaria&a=IndumentariaStock");

    }
		public function IndumentariaStockAutocompletar(){
      require_once 'includes/php/autocompletar_indumentaria_stock.php';
    }
		public function IndumentariaOrden(){
			require_once 'view/indumentaria-orden.php';
    }
		public function IndumentariaOrdenRespuesta(){
			require_once 'view/indumentaria-orden-respuesta.php';
    }
		public function IndumentariaEntregar(){

			$datetime = new DateTime();
			$fecha_actual = $datetime->format('Y-m-d');

			//$entstock = new Indumentaria();
			$entrega_numero = $_REQUEST['id'];
			$this->model->IndumentariaStockDescontar($entrega_numero, $fecha_actual);
			//header("Location: index.php?c=indumentaria&a=IndumentariaEntregaExito");
			header("Location: index.php?c=indumentaria&a=IndumentariaESExito&id=$entrega_numero");

    }
}
