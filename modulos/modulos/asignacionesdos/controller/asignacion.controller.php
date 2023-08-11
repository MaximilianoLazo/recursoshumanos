<?php
require_once 'model/asignacion.php';

session_start();
if(!isset($_SESSION["usuario_id"])){
  header("../legajos/login/index.php");
}

class AsignacionController{

    private $model;

    public function __CONSTRUCT(){
        $this->model = new Asignacion();
    }

    public function Index(){
      require_once 'view/otrosbeneficiarios.php';
    }
    public function BeneficiariosTitulares(){
      require_once 'view/beneficiariostitulares.php';
    }
    public function OtrosBeneficiariosLiquidaciones(){
      require_once 'view/otrosbeneficiarios-liquidaciones.php';
    }
    public function OtrosBeneficiariosHistorico(){
      require_once 'view/otrosbeneficiarios-historico.php';
    }
    public function PaseALiquidaciones(){
      foreach($this->model->ListarOtrosBeniciarios() as $row){
        $empleadonrodocto = $row->empleado;
        $beneficiarionrodocto = $row->beneficiario;
        //-- Pre-Natal --
        $prenatal = $this->model->DatosPreNatal($empleadonrodocto, $beneficiarionrodocto);
        if($prenatal->prenatalc > 0){
          //--Tiene Pre-Natales
          $this->model->PasarPreNatalOB($empleadonrodocto, $beneficiarionrodocto);
        }else{
          //--No tiene Pre-Natales
        }
        //-- Hijo Menor --
        $fechaactual = date("Y-m-d");
        $fechafinaluno = date("Y-m-d",strtotime($fechaactual."- 5 year"));//resto 5 años
		    $fechafinal = date("Y-m-d",strtotime($fechafinaluno."- 5 month"));
        $hijomenor = $this->model->DatosHijoMenor($empleadonrodocto, $beneficiarionrodocto, $fechaactual, $fechafinal);
        if($hijomenor->hijom > 0){
          //--- Tiene Hijos MENORES ---
          $this->model->PasarHijoMenorOb($empleadonrodocto, $beneficiarionrodocto, $fechaactual, $fechafinal);
        }else{
          //---No tiene Hijos Menores
        }
        //-- Pre-escolar --
        $escuelanivel = 1;
        $hijopreescolar = $this->model->DatosHijosEsc($empleadonrodocto, $beneficiarionrodocto, $escuelanivel);
        if($hijopreescolar->escuelac > 0){
          //---- Tiene Hijos en Preescolar
          $this->model->PasarPreEscolarOb($empleadonrodocto, $beneficiarionrodocto, $escuelanivel);
        }else{
          //--- No tiene Hijos en Preescolar
        }
        //-- Esc Primaria --
        $escuelanivel = 2;
        $hijoprimaria = $this->model->DatosHijosEsc($empleadonrodocto, $beneficiarionrodocto, $escuelanivel);
        if($hijoprimaria->escuelac > 0){
          //---- Tiene Hijos en Preescolar
          $this->model->PasarPrimariaOb($empleadonrodocto, $beneficiarionrodocto, $escuelanivel);
        }else{
          //--- No tiene Hijos en Preescolar
        }
        //-- Esc Sec y Sup --
        $escuelanivel = 3;
        $escuelamedsup = $this->model->DatosHijosEsc($empleadonrodocto, $beneficiarionrodocto, $escuelanivel);
        if($escuelamedsup->escuelac > 0){
          //---- Tiene Hijos en Preescolar
          $this->model->PasarSecYSupOb($empleadonrodocto, $beneficiarionrodocto, $escuelanivel);
        }else{
          //--- No tiene Hijos en Preescolar
        }
        //-- Discapacidad --
        $hijodisc = $this->model->DatosHijoDisc($empleadonrodocto, $beneficiarionrodocto);
        if($hijodisc->hijodisc > 0){
          //-- Tiene hijos con discapacidad
          $this->model->PasarHijoDisc($empleadonrodocto, $beneficiarionrodocto);
        }else{
          //-- No tiene Hijos Con discapacidad
        }
        //-- Esc con Discapacidad --
        $hijodiscesc = $this->model->DatosHijoDiscEsc($empleadonrodocto, $beneficiarionrodocto);
        if($hijodiscesc->hijodiscesc > 0){
          //--- Tiene hijos con discapacidad en escuela ---
          $this->model->PasarHijoDiscEsc($empleadonrodocto, $beneficiarionrodocto);
        }else{
          //--- No tiene hijos escolares con discapacidad --
        }
        //-- Familia Numerosa --
        $totalasignaciones = $hijomenor->hijom + $hijopreescolar->escuelac + $hijoprimaria->escuelac + $escuelamedsup->escuelac + $hijodisc->hijodisc + $hijodiscesc->hijodiscesc;

        $familianum = 0;
        if($totalasignaciones < 3){
          //----- no tiene familia numerosa
        }else{
          $familianum = $totalasignaciones - 2;
          $this->model->PasarFamiliaNum($empleadonrodocto,$beneficiarionrodocto,$familianum);
        }

      }
      header("Location: index.php");

    }
    public function OtrosBenefiariosParametros(){
      require_once 'view/otrosbeneficiarios-parametros.php';
    }
    public function ImportarHaberesRemunerativos(){
      require_once 'view/haberesremunerativos.php';
    }
    public function CalcularImportesOB(){
      //---- Tipo de asignacion 1 // Pre-Natal ---
        //--- Rango 1
        $asignacion = 1;
        $rango = 1;
        $prenatalR1 = $this->model->ObtenerPreNatalRango($rango);
        $impdesde = $prenatalR1->paramprenatal_desde;
        $imphasta = $prenatalR1->paramprenatal_hasta;
        $importeasig = $prenatalR1->paramprenatal_importe;
        $this->model->CalcularPreNatalR1($impdesde,$imphasta,$asignacion,$importeasig);
        //--- Rango 2
        $asignacion = 1;
        $rango = 2;
        $prenatalR1 = $this->model->ObtenerPreNatalRango($rango);
        $impdesde = $prenatalR1->paramprenatal_desde;
        $imphasta = $prenatalR1->paramprenatal_hasta;
        $importeasig = $prenatalR1->paramprenatal_importe;
        $this->model->CalcularPreNatalR1($impdesde,$imphasta,$asignacion,$importeasig);
        //--- Rango 3
        $asignacion = 1;
        $rango = 3;
        $prenatalR1 = $this->model->ObtenerPreNatalRango($rango);
        $impdesde = $prenatalR1->paramprenatal_desde;
        $imphasta = $prenatalR1->paramprenatal_hasta;
        $importeasig = $prenatalR1->paramprenatal_importe;
        $this->model->CalcularPreNatalR1($impdesde,$imphasta,$asignacion,$importeasig);
        //--- Rango 4
        $asignacion = 1;
        $rango = 4;
        $prenatalR1 = $this->model->ObtenerPreNatalRango($rango);
        $impdesde = $prenatalR1->paramprenatal_desde;
        $imphasta = 999999;
        $importeasig = $prenatalR1->paramprenatal_importe;
        $this->model->CalcularPreNatalR1($impdesde,$imphasta,$asignacion,$importeasig);
      //---- Tipo de asignacion 2 // Hijo Menor ---
        //--- Rango 1
        $asignacion = 2;
        $rango = 1;
        $hijomenorR1 = $this->model->ObtenerHijoMenorRango($rango);
        $impdesde = $hijomenorR1->paramhijo_desde;
        $imphasta = $hijomenorR1->paramhijo_hasta;
        $importeasig = $hijomenorR1->paramhijo_importe;
        $this->model->CalcularPreNatalR1($impdesde,$imphasta,$asignacion,$importeasig);
        //--- Rango 2
        $asignacion = 2;
        $rango = 2;
        $hijomenorR1 = $this->model->ObtenerHijoMenorRango($rango);
        $impdesde = $hijomenorR1->paramhijo_desde;
        $imphasta = $hijomenorR1->paramhijo_hasta;
        $importeasig = $hijomenorR1->paramhijo_importe;
        $this->model->CalcularPreNatalR1($impdesde,$imphasta,$asignacion,$importeasig);
        //--- Rango 3
        $asignacion = 2;
        $rango = 3;
        $hijomenorR1 = $this->model->ObtenerHijoMenorRango($rango);
        $impdesde = $hijomenorR1->paramhijo_desde;
        $imphasta = $hijomenorR1->paramhijo_hasta;
        $importeasig = $hijomenorR1->paramhijo_importe;
        $this->model->CalcularPreNatalR1($impdesde,$imphasta,$asignacion,$importeasig);
        //--- Rango 4
        $asignacion = 2;
        $rango = 4;
        $hijomenorR1 = $this->model->ObtenerHijoMenorRango($rango);
        $impdesde = $hijomenorR1->paramhijo_desde;
        $imphasta = 999999;
        $importeasig = $hijomenorR1->paramhijo_importe;
        $this->model->CalcularPreNatalR1($impdesde,$imphasta,$asignacion,$importeasig);
      //---- Tipo de asignacion 3 // --- Hijo con Discapacidad
        //--- Rango 1
        $asignacion = 3;
        $rango = 1;
        $hijodiscR1 = $this->model->ObtenerHijoDiscRango($rango);
        $impdesde = $hijodiscR1->paramhijodisc_desde;
        $imphasta = $hijodiscR1->paramhijodisc_hasta;
        $importeasig = $hijodiscR1->paramhijodisc_importe;
        $this->model->CalcularPreNatalR1($impdesde,$imphasta,$asignacion,$importeasig);
        //--- Rango 2
        $asignacion = 3;
        $rango = 2;
        $hijodiscR1 = $this->model->ObtenerHijoDiscRango($rango);
        $impdesde = $hijodiscR1->paramhijodisc_desde;
        $imphasta = $hijodiscR1->paramhijodisc_hasta;
        $importeasig = $hijodiscR1->paramhijodisc_importe;
        $this->model->CalcularPreNatalR1($impdesde,$imphasta,$asignacion,$importeasig);
        //--- Rango 3
        $asignacion = 3;
        $rango = 3;
        $hijodiscR1 = $this->model->ObtenerHijoDiscRango($rango);
        $impdesde = $hijodiscR1->paramhijodisc_desde;
        $imphasta = 999999;
        $importeasig = $hijodiscR1->paramhijodisc_importe;
        $this->model->CalcularPreNatalR1($impdesde,$imphasta,$asignacion,$importeasig);
      //---- Tipo de asignacion 4 // Escuela Pre-escolar
        //---Rango 1
        $asignacion = 4;
        $rango = 1;
        $hijomenorR1 = $this->model->ObtenerHijoMenorRango($rango);
        $impdesde = $hijomenorR1->paramhijo_desde;
        $imphasta = $hijomenorR1->paramhijo_hasta;
        $opcion = 1;
        $asigadicional = $this->model->AsigAdicional($opcion);
        $importeasig = $hijomenorR1->paramhijo_importe + $asigadicional->paramescnvlo_importe;
        $this->model->CalcularPreNatalR1($impdesde,$imphasta,$asignacion,$importeasig);
        //---Rango 2
        $asignacion = 4;
        $rango = 2;
        $hijomenorR1 = $this->model->ObtenerHijoMenorRango($rango);
        $impdesde = $hijomenorR1->paramhijo_desde;
        $imphasta = $hijomenorR1->paramhijo_hasta;
        $opcion = 1;
        $asigadicional = $this->model->AsigAdicional($opcion);
        $importeasig = $hijomenorR1->paramhijo_importe + $asigadicional->paramescnvlo_importe;
        $this->model->CalcularPreNatalR1($impdesde,$imphasta,$asignacion,$importeasig);
        //---Rango 3
        $asignacion = 4;
        $rango = 3;
        $hijomenorR1 = $this->model->ObtenerHijoMenorRango($rango);
        $impdesde = $hijomenorR1->paramhijo_desde;
        $imphasta = $hijomenorR1->paramhijo_hasta;
        $opcion = 1;
        $asigadicional = $this->model->AsigAdicional($opcion);
        $importeasig = $hijomenorR1->paramhijo_importe + $asigadicional->paramescnvlo_importe;
        $this->model->CalcularPreNatalR1($impdesde,$imphasta,$asignacion,$importeasig);
        //---Rango 4
        $asignacion = 4;
        $rango = 4;
        $hijomenorR1 = $this->model->ObtenerHijoMenorRango($rango);
        $impdesde = $hijomenorR1->paramhijo_desde;
        $imphasta = 999999;
        $opcion = 1;
        $asigadicional = $this->model->AsigAdicional($opcion);
        $importeasig = $hijomenorR1->paramhijo_importe + $asigadicional->paramescnvlo_importe;
        $this->model->CalcularPreNatalR1($impdesde,$imphasta,$asignacion,$importeasig);
      //---- Tipo de asignacion 5 // Escuela Primaria
      //---Rango 1
      $asignacion = 5;
      $rango = 1;
      $hijomenorR1 = $this->model->ObtenerHijoMenorRango($rango);
      $impdesde = $hijomenorR1->paramhijo_desde;
      $imphasta = $hijomenorR1->paramhijo_hasta;
      $opcion = 2;
      $asigadicional = $this->model->AsigAdicional($opcion);
      $importeasig = $hijomenorR1->paramhijo_importe + $asigadicional->paramescnvlo_importe;
      $this->model->CalcularPreNatalR1($impdesde,$imphasta,$asignacion,$importeasig);
      //---Rango 2
      $asignacion = 5;
      $rango = 2;
      $hijomenorR1 = $this->model->ObtenerHijoMenorRango($rango);
      $impdesde = $hijomenorR1->paramhijo_desde;
      $imphasta = $hijomenorR1->paramhijo_hasta;
      $opcion = 2;
      $asigadicional = $this->model->AsigAdicional($opcion);
      $importeasig = $hijomenorR1->paramhijo_importe + $asigadicional->paramescnvlo_importe;
      $this->model->CalcularPreNatalR1($impdesde,$imphasta,$asignacion,$importeasig);
      //---Rango 3
      $asignacion = 5;
      $rango = 3;
      $hijomenorR1 = $this->model->ObtenerHijoMenorRango($rango);
      $impdesde = $hijomenorR1->paramhijo_desde;
      $imphasta = $hijomenorR1->paramhijo_hasta;
      $opcion = 2;
      $asigadicional = $this->model->AsigAdicional($opcion);
      $importeasig = $hijomenorR1->paramhijo_importe + $asigadicional->paramescnvlo_importe;
      $this->model->CalcularPreNatalR1($impdesde,$imphasta,$asignacion,$importeasig);
      //---Rango 4
      $asignacion = 5;
      $rango = 4;
      $hijomenorR1 = $this->model->ObtenerHijoMenorRango($rango);
      $impdesde = $hijomenorR1->paramhijo_desde;
      $imphasta = 999999;
      $opcion = 2;
      $asigadicional = $this->model->AsigAdicional($opcion);
      $importeasig = $hijomenorR1->paramhijo_importe + $asigadicional->paramescnvlo_importe;
      $this->model->CalcularPreNatalR1($impdesde,$imphasta,$asignacion,$importeasig);
      //---- Tipo de asignacion 6 // Escuela Secundaria y Superior
      //---Rango 1
      $asignacion = 6;
      $rango = 1;
      $hijomenorR1 = $this->model->ObtenerHijoMenorRango($rango);
      $impdesde = $hijomenorR1->paramhijo_desde;
      $imphasta = $hijomenorR1->paramhijo_hasta;
      $opcion = 3;
      $asigadicional = $this->model->AsigAdicional($opcion);
      $importeasig = $hijomenorR1->paramhijo_importe + $asigadicional->paramescnvlo_importe;
      $this->model->CalcularPreNatalR1($impdesde,$imphasta,$asignacion,$importeasig);
      //---Rango 2
      $asignacion = 6;
      $rango = 2;
      $hijomenorR1 = $this->model->ObtenerHijoMenorRango($rango);
      $impdesde = $hijomenorR1->paramhijo_desde;
      $imphasta = $hijomenorR1->paramhijo_hasta;
      $opcion = 3;
      $asigadicional = $this->model->AsigAdicional($opcion);
      $importeasig = $hijomenorR1->paramhijo_importe + $asigadicional->paramescnvlo_importe;
      $this->model->CalcularPreNatalR1($impdesde,$imphasta,$asignacion,$importeasig);
      //---Rango 3
      $asignacion = 6;
      $rango = 3;
      $hijomenorR1 = $this->model->ObtenerHijoMenorRango($rango);
      $impdesde = $hijomenorR1->paramhijo_desde;
      $imphasta = $hijomenorR1->paramhijo_hasta;
      $opcion = 3;
      $asigadicional = $this->model->AsigAdicional($opcion);
      $importeasig = $hijomenorR1->paramhijo_importe + $asigadicional->paramescnvlo_importe;
      $this->model->CalcularPreNatalR1($impdesde,$imphasta,$asignacion,$importeasig);
      //---Rango 4
      $asignacion = 6;
      $rango = 4;
      $hijomenorR1 = $this->model->ObtenerHijoMenorRango($rango);
      $impdesde = $hijomenorR1->paramhijo_desde;
      $imphasta = 999999;
      $opcion = 3;
      $asigadicional = $this->model->AsigAdicional($opcion);
      $importeasig = $hijomenorR1->paramhijo_importe + $asigadicional->paramescnvlo_importe;
      $this->model->CalcularPreNatalR1($impdesde,$imphasta,$asignacion,$importeasig);
      //---- Tipo de asignacion 7 // Escolar con Discapacidad
      //--- Rango 1
      $asignacion = 7;
      $rango = 1;
      $hijodiscR1 = $this->model->ObtenerHijoDiscRango($rango);
      $impdesde = $hijodiscR1->paramhijodisc_desde;
      $imphasta = $hijodiscR1->paramhijodisc_hasta;
      $opcion = 4;
      $asigadicional = $this->model->AsigAdicional($opcion);
      $importeasig = $hijodiscR1->paramhijodisc_importe + $asigadicional->paramescnvlo_importe;
      $this->model->CalcularPreNatalR1($impdesde,$imphasta,$asignacion,$importeasig);
      //--- Rango 2
      $asignacion = 7;
      $rango = 2;
      $hijodiscR1 = $this->model->ObtenerHijoDiscRango($rango);
      $impdesde = $hijodiscR1->paramhijodisc_desde;
      $imphasta = $hijodiscR1->paramhijodisc_hasta;
      $opcion = 4;
      $asigadicional = $this->model->AsigAdicional($opcion);
      $importeasig = $hijomenorR1->paramhijo_importe + $asigadicional->paramescnvlo_importe;
      $this->model->CalcularPreNatalR1($impdesde,$imphasta,$asignacion,$importeasig);
      //--- Rango 3
      $asignacion = 7;
      $rango = 3;
      $hijodiscR1 = $this->model->ObtenerHijoDiscRango($rango);
      $impdesde = $hijodiscR1->paramhijodisc_desde;
      $imphasta = 999999;
      $opcion = 4;
      $asigadicional = $this->model->AsigAdicional($opcion);
      $importeasig = $hijomenorR1->paramhijo_importe + $asigadicional->paramescnvlo_importe;
      $this->model->CalcularPreNatalR1($impdesde,$imphasta,$asignacion,$importeasig);
      //---- Tipo de asignacion 8 // Familia Numerosa
      $asignacion = 8;
      $opcion = 5;
      $asigadicional = $this->model->AsigAdicional($opcion);
      $importeasig = $asigadicional->paramescnvlo_importe;
      $this->model->CalcularFamNumR1($asignacion,$importeasig);
      header("Location: ../asignacionesdos/?c=asignacion&a=OtrosBeneficiariosLiquidaciones");
    }
    public function BusquedaOBReajuste(){
      require_once 'view/busquedaobreajuste.php';
    }
    public function GuardarOBReajuste(){
        $asig = new Asignacion();
        $asigimptotal = $_REQUEST['importeob'] + $_REQUEST['txtasignacionr'];
        $asig->Id = $_REQUEST['id'];
        $asig->NDocConsultado = $_REQUEST['ndocconsultado'];
        $asig->AsigReajuste = $_REQUEST['txtasignacionr'];
        $asig->AsigReajusteObs = $_REQUEST['txtasignacionobs'];
        $asig->AsigImpTotal = $asigimptotal;

        $this->model->RegistrarOBReajauste($asig);
        /*
        $lug->Trabajoid > 0
            ? $this->model->ActualizarL($lug)
            : $this->model->RegistrarL($lug);
        */
        //header("Location: index.php");
        header("Location: ../asignacionesdos/?c=asignacion&a=BusquedaOBReajuste&id=$asig->NDocConsultado");

        //header('Location:' . getenv('HTTP_REFERER'));

        ?>
        <!--
         <script type="text/javascript">
           //history.back();
           //history.go(-2);
           history.forward();
         </script>
       -->
        <!--
        <script type="text/javascript">
          //history.back();
          history.go(-2);
        </script>
        -->
        <?php
    }
    //------------ codigo Viejo -----
    public function GuardarL(){
        $lug = new Lugardetrabajo();

        $lug->Trabajoid = $_REQUEST['trabajoid'];
        $lug->Trabajonombre = $_REQUEST['trabajonombre'];
        $lug->Trabajosec = $_REQUEST['trabajosec'];
        $lug->Trabajoactivo = 1;

        $lug->Trabajoid > 0
            ? $this->model->ActualizarL($lug)
            : $this->model->RegistrarL($lug);

        header("Location: index.php");
    }
    public function DeshabilitarL(){
      $lugar = new Lugardetrabajo();

      $lugar->Trabajoid = $_REQUEST['trabajoid'];
      $lugar->Trabajoactivo = 0;

        $this->model->DeshabilitarLug($lugar);

      header("Location: index.php");
    }


    //---------- codigo viejo --------------

    public function Crud(){
        $emp = new Panel();

        if(isset($_REQUEST['id'])){
            $emp = $this->model->Obtener($_REQUEST['id']);
        }

        //require_once 'view/header.php';
        require_once 'view/empleado-editar.php';
        //require_once 'view/footer.php';
    }


    public function GuardarR(){
        $rel = new Empleado();

        $rel->Id = $_REQUEST['id'];
        $rel->EmpId = $_REQUEST['empid'];
        $rel->Empnrodocto = $_REQUEST['empnrodocto'];
        $rel->Relojid = $_REQUEST['relojid'];
        $rel->Accessid = $_REQUEST['accessid'];
        $rel->Semanal = $_REQUEST['semanal'];
        $rel->Lunes = $_REQUEST['lunes'];
        if($rel->Lunes == 1){

        }else{
          $rel->Lunes = 0;
        }
        $rel->Luneshe = $_REQUEST['luneshe'];
        $rel->Luneshs = $_REQUEST['luneshs'];
        $rel->Martes = $_REQUEST['martes'];
        if($rel->Martes == 1){

        }else{
          $rel->Martes = 0;
        }
        $rel->Marteshe = $_REQUEST['marteshe'];
        $rel->Marteshs = $_REQUEST['marteshs'];
        $rel->Miercoles = $_REQUEST['miercoles'];
        if($rel->Miercoles == 1){

        }else{
          $rel->Miercoles = 0;
        }
        $rel->Miercoleshe = $_REQUEST['miercoleshe'];
        $rel->Miercoleshs = $_REQUEST['miercoleshs'];
        $rel->Jueves = $_REQUEST['jueves'];
        if($rel->Jueves == 1){

        }else{
          $rel->Jueves = 0;
        }
        $rel->Jueveshe = $_REQUEST['jueveshe'];
        $rel->Jueveshs = $_REQUEST['jueveshs'];
        $rel->Viernes = $_REQUEST['viernes'];
        if($rel->Viernes == 1){

        }else{
          $rel->Viernes = 0;
        }
        $rel->Vierneshe = $_REQUEST['vierneshe'];
        $rel->Vierneshs = $_REQUEST['vierneshs'];
        $rel->Sabado = $_REQUEST['sabado'];
        if($rel->Sabado == 1){

        }else{
          $rel->Sabado = 0;
        }
        $rel->Sabadohe = $_REQUEST['sabadohe'];
        $rel->Sabadohs = $_REQUEST['sabadohs'];
        $rel->Domingo = $_REQUEST['domingo'];
        if($rel->Domingo == 1){

        }else{
          $rel->Domingo = 0;
        }
        $rel->Domingohe = $_REQUEST['domingohe'];
        $rel->Domingohs = $_REQUEST['domingohs'];
        $rel->Activo = 1;

        $rel->Id > 0
            ? $this->model->ActualizarR($rel)
            : $this->model->RegistrarR($rel);

        header("Location: index.php?c=empleado&a=Crud&id=$rel->EmpId&startIndex=3");

    }
    public function DeshabilitarR(){
      $des = new Empleado();

      $des->Activo = 0;
      $des->RelId = $_REQUEST['relojid'];
      $des->EmpId = $_REQUEST['empid'];

        $this->model->DeshabilitarRel($des);

      header("Location: index.php?c=empleado&a=Crud&id=$des->EmpId&startIndex=3");
    }
    public function GuardarH(){
        $hjo = new Empleado();

        $hjo->Id = $_REQUEST['id'];
        $hjo->Empid = $_REQUEST['empid'];
        $hjo->Empnrodocto = $_REQUEST['empnrodocto'];
        $hjo->Hjobentdoc = $_REQUEST['hijobentdoc'];
        $hjo->Hjobenndoc = $_REQUEST['hijobenndoc'];
        $hjo->Hjobenapellido = $_REQUEST['hijobenapellido'];
        $hjo->Hjobennombres = $_REQUEST['hijobennombres'];
        $hjo->Hjomoptdoc = $_REQUEST['hijomoptdoc'];
        $hjo->Hjomopndoc = $_REQUEST['hijomopndoc'];
        $hjo->Hjomopapellido = $_REQUEST['hijomopapellido'];
        $hjo->Hjomopnombres = $_REQUEST['hijomopnombres'];
        $hjo->Hjotdoc = $_REQUEST['hijotdoc'];
        $hjo->Hjondoc = $_REQUEST['hijondoc'];
        $hjo->Hjonrocuil = $_REQUEST['hijonrocuil'];
        $hjo->Hjoapellido = $_REQUEST['hijoapellido'];
        $hjo->Hjonombres = $_REQUEST['hijonombres'];
        $hjo->Hjosexo = $_REQUEST['hijosexo'];
        $hjo->Hjofecnacto = $_REQUEST['hijofecnacto'];
        $hjo->Hjodireccion = $_REQUEST['hijodireccion'];
        $hjo->Hjodirecnro = $_REQUEST['hijodirecnro'];
        $hjo->Hjodirecpiso = $_REQUEST['hijodirecpiso'];
        $hjo->Hjopais = $_REQUEST['hijopais'];
        $hjo->Hjoprovincia = $_REQUEST['hijoprovincia'];
        $hjo->Hjodepartamento = $_REQUEST['hijodepartamento'];
        $hjo->Hjolocalidad = $_REQUEST['hijolocalidad'];
        $hjo->Hjocodpostal = $_REQUEST['hijocodpostal'];
        $hjo->Hjodisc = $_REQUEST['hijodisc'];
        if($hjo->Hjodisc == 1){

        }else{
          $hjo->Hjodisc = 0;
        }
        $hjo->Hjoesc = $_REQUEST['hijoesc'];
        if($hjo->Hjoesc == 1){

        }else{
          $hjo->Hjoesc = 0;
        }
        $hjo->Hjoescnom = $_REQUEST['hijoescnom'];
        $hjo->Hjoescnvl = $_REQUEST['hijoescnvl'];
        $hjo->Hjoescest = $_REQUEST['hijoescest'];
        $hjo->Hjoactivo = 1;

        $hjo->Id > 0
            ? $this->model->ActualizarH($hjo)
            : $this->model->RegistrarH($hjo);

        header("Location: index.php?c=empleado&a=Crud&id=$hjo->Empid&startIndex=5");

    }
    public function DeshabilitarH(){
      $hjo = new Empleado();

      $hjo->Activo = 0;
      $hjo->Hijoid = $_REQUEST['hijoid'];
      $hjo->Empid = $_REQUEST['empid'];

        $this->model->DeshabilitarHjo($hjo);

      header("Location: index.php?c=empleado&a=Crud&id=$hjo->Empid&startIndex=5");
    }
    public function GuardarC(){
        $cye = new Empleado();

        $cye->Cyetdoc = $_REQUEST['conyugetdoc'];
        $cye->Cyendoc = $_REQUEST['conyugendoc'];
        $cye->Cyeapellido = $_REQUEST['conyugeapellido'];
        $cye->Cyenombres = $_REQUEST['conyugenombres'];
        $cye->Cyecuil = $_REQUEST['conyugenrocuil'];
        $cye->Cyesexo = $_REQUEST['conyugesexo'];
        $cye->Cyefecnacto = $_REQUEST['conyugefecnacto'];
        $cye->Cyedireccion = $_REQUEST['conyugedireccion'];
        $cye->Cyedirecnro = $_REQUEST['conyugedirecnro'];
        $cye->Cyedirecpiso = $_REQUEST['conyugedirecpiso'];
        $cye->Cyecpostal = $_REQUEST['conyugecodpostal'];
        $cye->Cyecelular = $_REQUEST['conyugecelular'];
        $cye->Cyetelefono = $_REQUEST['conyugetelefono'];
        $cye->Cyeemail = $_REQUEST['conyugeemail'];
        $cye->Cyepais = $_REQUEST['conyugepais'];
        $cye->Cyeprovincia = $_REQUEST['conyugeprovincia'];
        $cye->Cyedepartamento = $_REQUEST['conyugedepartamento'];
        $cye->Cyelocalidad = $_REQUEST['conyugelocalidad'];
        $cye->Cyeactivo = 1;
        $cye->Empnrodocto = $_REQUEST['empnrodocto'];
        $cye->Empid = $_REQUEST['empid'];

        $this->model->RegistrarC($cye);

        header("Location: index.php?c=empleado&a=Crud&id=$cye->Empid#steps-uid-0-h-2");
    }
    public function GuardarEs(){
        $est = new Empleado();

        $est->Id = $_REQUEST['id'];
        $est->Empid = $_REQUEST['empid'];
        $est->Empnrodocto = $_REQUEST['empnrodocto'];
        $est->Estudioesc = $_REQUEST['estudioesc'];
        $est->Estudionvl = $_REQUEST['estudionvl'];
        $est->Estudioestado = $_REQUEST['estudioestado'];
        $est->Estudiotitulo = $_REQUEST['estudiotitulo'];
        $est->Estudioarchivo = "";
        $est->Estudioactivo = 1;

        $est->Id > 0
            ? $this->model->ActualizarEs($est)
            : $this->model->RegistrarEs($est);

        header("Location: index.php?c=empleado&a=Crud&id=$est->Empid&startIndex=2");

    }
    public function DeshabilitarEs(){
      $est = new Empleado();

      $est->Activo = 0;
      $est->Estudioid = $_REQUEST['estudioid'];
      $est->Empid = $_REQUEST['empid'];

        $this->model->DeshabilitarEst($est);

      header("Location: index.php?c=empleado&a=Crud&id=$est->Empid&startIndex=2");
    }
    public function GuardarE(){
        $empg = new Empleado();

        //-------datos personales -----
        $empg->Id = $_REQUEST['empid'];
        $empg->Empnrodocumento = $_REQUEST['empnrodocumento'];
        $empg->Emptdoc = $_REQUEST['emptdoc'];
        $empg->Empapellido = $_REQUEST['empapellido'];
        $empg->Empnombres = $_REQUEST['empnombres'];
        $empg->Empcuil = $_REQUEST['empcuil'];
        $empg->Empnroleg = $_REQUEST['empnroleg'];
        $empg->Empsexotres = $_REQUEST['empsexo'];
        $empg->Empestcivil = $_REQUEST['empestcivil'];
        $empg->Empfecnacto = $_REQUEST['empfecnacto'];
        $empg->Empnrolegv = $_REQUEST['empnrolegv'];
        $empg->Empdireccion = $_REQUEST['empdireccion'];
        $empg->Empdirecnro = $_REQUEST['empdirecnro'];
        $empg->Empdirecpiso = $_REQUEST['empdirecpiso'];
        $empg->Empcpostal = $_REQUEST['empcpostal'];
        $empg->Empcelular = $_REQUEST['empcelular'];
        $empg->Emptelefono = $_REQUEST['emptelefono'];
        $empg->Empemail = $_REQUEST['empemail'];
        $empg->Emppais = $_REQUEST['emppais'];
        $empg->Empprovincia = $_REQUEST['empprovincia'];
        $empg->Empdepartamento = $_REQUEST['empdepartamento'];
        $empg->Emplocalidad = $_REQUEST['emplocalidad'];
        $empg->Empfecing = $_REQUEST['empfecing'];
        $empg->Empfecbaja = $_REQUEST['empfecbaja'];
        $empg->Empactivo = $_REQUEST['empactivo'];
        if($empg->Empactivo == 1){

        }else{
          $empg->Empactivo = 0;
        }
        //------- Datos de contrato ------
        $empg->Empcontratoid = $_REQUEST['contratoid'];
        $empg->Empcomtipo = $_REQUEST['empcomtipo'];
        $empg->Empcategoria = $_REQUEST['empcategoria'];
        $empg->Empfecinicio = $_REQUEST['empfecinicio'];
        $empg->Empfecfin = $_REQUEST['empfecfin'];
        $empg->Empinputacion = $_REQUEST['empimputacion'];
        $empg->Empsecretaria = $_REQUEST['empsecretaria'];
        $empg->Empltrabajo = $_REQUEST['empltrabajo'];
        $empg->Emptarea = $_REQUEST['emptarea'];
        $empg->Empbasico = $_REQUEST['empbasico'];
        //--------- Datos de marcaciones --------------
        $empg->Empreloj = $_REQUEST['empreloj'];
        $empg->Emprelojid = $_REQUEST['emprelojid'];
        $empg->Emprelsemanal = $_REQUEST['emprelsemanal'];
        if($empg->Emprelsemanal == 1){
          $empg->Emprelsemanal = 1;
        }else{
          $empg->Emprelsemanal = 0;
        }
        //----------- Datos de Conyuge ----------------
        $empg->Empcyetdoc = $_REQUEST['cyetdoc'];
        $empg->Empcyendoc = $_REQUEST['cyendoc'];
        $empg->Empcyeapellido = $_REQUEST['cyeapellido'];
        $empg->Empcyenombres = $_REQUEST['cyenombres'];
        $empg->Empcyenrocuil = $_REQUEST['cyenrocuil'];
        $empg->Empcyesexo = $_REQUEST['cyesexo'];
        $empg->Empcyefecnacto = $_REQUEST['cyefecnacto'];
        $empg->Empcyedireccion = $_REQUEST['cyedireccion'];
        $empg->Empcyedirecnro = $_REQUEST['cyedirecnro'];
        $empg->Empcyedirecpiso = $_REQUEST['cyedirecpiso'];
        $empg->Empcyecodpostal = $_REQUEST['cyecodpostal'];
        $empg->Empcyecelular = $_REQUEST['cyecelular'];
        $empg->Empcyetelefono = $_REQUEST['cyetelefono'];
        $empg->Empcyeemail = $_REQUEST['cyeemail'];
        $empg->Empcyepais = $_REQUEST['cyepais'];
        $empg->Empcyeprovincia = $_REQUEST['cyeprovincia'];
        $empg->Empcyedepartamento = $_REQUEST['cyedepartamento'];
        $empg->Empcyelocalidad = $_REQUEST['cyelocalidad'];

        $empg->Id > 0
            ? $this->model->ActualizarE($empg)
            : $this->model->RegistrarE($empg);

        header("Location: index.php?c=empleado&a=Crud&id=$empg->Id&startIndex=0");

    }


    public function Eliminar(){
        $this->model->Eliminar($_REQUEST['id']);

        header('Location: index.php');
    }

}
