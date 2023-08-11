<?php
require_once 'model/horasextras.php';

session_start();
if(!isset($_SESSION["usuario_id"])){
  header("../legajos/login/index.php");
}

class HorasExtrasController{

    private $model;

    public function __CONSTRUCT(){
        $this->model = new HorasExtras();
    }

    public function Index(){
      require_once 'view/horasextras.php';
    }
    public function HorasExtrasResumen(){
      require_once 'view/horasextras-resumen.php';
    }
    public function HorasExtrasPeriodosAnteriores(){
      require_once 'view/horasextras-periodosanteriores.php';
    }
    public function GuardarHorasExtras(){
        $hse = new HorasExtras();

        $hse->Hsexperiodoid = $_REQUEST['cbohsextrasperiodo'];
        $hse->Hsexdni = $_REQUEST['hsextrasdni'];
        $hse->Hsexltrabajoid = $_REQUEST['hddhsexltrabajoid'];
        $hse->Hsexltrabajonombre = $_REQUEST['hddhsexltrabajonombre'];

        $hse->Hsexsimples = $_REQUEST['hsextrassimples'];
        $hse->Hsexdobles = $_REQUEST['hsextrasdobles'];
        $hse->Hsjornales = $_REQUEST['hsjornales'];

        $hse->Hsexobservaciones = $_REQUEST['hsexobservaciones'];

        $this->model->GuardarHorasExtrasExe($hse);

        header("Location: index.php");
    }
    public function HorasExtrasIngresarAyuda(){
      require_once 'includes/php/horasextrasingresar-ayuda.php';
    }
    public function PasarHorasExtrasLiquidaciones(){
      require_once 'includes/php/horasextras-liquidaciones.php';
      header("Location: index.php");
    }
}
