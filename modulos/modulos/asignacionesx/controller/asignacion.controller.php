<?php
require_once 'model/asignacion.php';
error_reporting(0);
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
class AsignacionController{

    private $model;

    public function __CONSTRUCT(){
        $this->model = new Asignacion();
    }
    /*public function Index(){
      require_once 'view/asignaciones.php';
    }*/
    //--------ASIGNACIONES FAMILIARES -------
    public function Asignaciones(){
      require_once 'view/asignaciones.php';
    }
    public function AsignacionesOB(){
      require_once 'view/asignaciones-ob.php';
    }
    public function AsignacionesOBLiquidaciones(){
      require_once 'view/asignaciones-obliquidaciones.php';
    }
    public function AsignacionesBusqueda(){
      require_once 'view/asignaciones-busqueda.php';
    }
    public function AyudaEscolar(){
      require_once 'view/ayuda-escolar.php';
    }
    public function AyudaEscolarOB(){
      require_once 'view/ayuda-escolar-ob.php';
    }
    public function AyudaEscolarOBLiquidaciones(){
      require_once 'view/ayuda-escolar-obliquidaciones.php';
    }
    //-------AYUDA ESCOLAR ---------
    public function AsignacionesPaseALiq(){
      //------Poner asignaciones en Waldbott en 0 -----
      $this->model->WaldbottAsignacionesReset();
      //-----Datos de Periodo actual ----
      $periododatos = $this->model->PeriodoActualObtener();
      //id de periodo anterior -----
      $pia = $periododatos->periodo_id - 1;
      //-----Listara Asiganaciones --------------
      foreach($this->model->AsignacionesListado() as $row){
        $empleadonrodocto = $row->empleado;
        $beneficiarionrodocto = $row->empleado;
        //----datos de empleado ---
        $empleadodatos = $this->model->EmpleadoAYNObtener($empleadonrodocto);
        //-- Conyuge --
        $conyuge = $this->model->ConyugeFilasNum($empleadonrodocto);
        if($conyuge->conyugec > 0){
          //--Tiene Conyuge,
          $conyugedatos = $this->model->ConyugeObtener($empleadonrodocto);
          //----datos para enviar
          $conyugeg = new Asignacion();
          $conyugeg->Titular = 1;
          $conyugeg->Empndoc = $empleadodatos->legempleado_nrodocto;
          $conyugeg->Empapellido = $empleadodatos->legempleado_apellido;
          $conyugeg->Empnombres = $empleadodatos->legempleado_nombres;
          $conyugeg->Benid = $empleadodatos->legempleado_id;
          $conyugeg->Benndoc = $empleadodatos->legempleado_nrodocto;
          $conyugeg->Benapellido = $empleadodatos->legempleado_apellido;
          $conyugeg->Bennombres = $empleadodatos->legempleado_nombres;
          $conyugeg->Phcid = $conyugedatos->legconyuge_id;
          $conyugeg->Phcnoficio = "";
          $conyugeg->Phcndoc = $conyugedatos->legconyuge_nrodocto;
          $conyugeg->Phcapellido = $conyugedatos->legconyuge_apellido;
          $conyugeg->Phcnombres = $conyugedatos->legconyuge_nombres;
          $conyugeg->Periodoid = $periododatos->periodo_id;
          $conyugeg->Liqcodid = 200;
          $conyugeg->Asigtipoid = 9;
          $conyugeg->Asigcantidad = 1;
          $conyugeg->Asigestado = 1;
          //----Guardar asignacion ----
          $conyugeg->Asignacionid = $this->model->AsignacionGuardarExe($conyugeg);
        }else{
          //--No tiene Conyuge
        }
        //-- Pre-Natal --
        $prenatal = $this->model->PreNatalFilasNum($empleadonrodocto, $beneficiarionrodocto);
        if($prenatal->prenatalc > 0){
          //--Tiene Pre-Natales
          $prenataldatos = $this->model->PreNatalObtener($empleadonrodocto, $beneficiarionrodocto);
          $prenatalg = new Asignacion();
          foreach($prenataldatos as $value_uno){
            //----datos para enviar
            $prenatalg->Titular = 1;
            $prenatalg->Empndoc = $empleadodatos->legempleado_nrodocto;
            $prenatalg->Empapellido = $empleadodatos->legempleado_apellido;
            $prenatalg->Empnombres = $empleadodatos->legempleado_nombres;
            $prenatalg->Benid = $empleadodatos->legempleado_id;
            $prenatalg->Benndoc = $empleadodatos->legempleado_nrodocto;
            $prenatalg->Benapellido = $empleadodatos->legempleado_apellido;
            $prenatalg->Bennombres = $empleadodatos->legempleado_nombres;
            $prenatalg->Phcid = $value_uno->legprenatal_id;
            $prenatalg->Phcnoficio = "";
            $prenatalg->Phcndoc = 0;
            $prenatalg->Phcapellido = "";
            $prenatalg->Phcnombres = "";
            $prenatalg->Periodoid = $periododatos->periodo_id;
            $prenatalg->Liqcodid = 214;
            $prenatalg->Asigtipoid = 1;
            $prenatalg->Asigcantidad = 1;
            $prenatalg->Asigestado = 1;
            //----Guardar asignacion ----
            $prenatalg->Asignacionid = $this->model->AsignacionGuardarExe($prenatalg);

          }
        }//--No tiene Pre-Natales

        //-- Hijo Menor --
        $fecha_actual = date("Y-m-d");
        $fecha_uno = date("Y-m-d",strtotime($fecha_actual."- 6 year"));//resto 5 años
		    $fecha_final = date("Y-m-d",strtotime($fecha_uno."- 1 month"));//resto 5 meses
        $hijomenor = $this->model->HijoMenorFilasNum($empleadonrodocto, $beneficiarionrodocto, $fecha_actual, $fecha_final);
        if($hijomenor->hijom > 0){
          //--- Tiene Hijos MENORES ---
          $hijomenordatos = $this->model->HijoMenorObtener($empleadonrodocto, $beneficiarionrodocto, $fecha_actual, $fecha_final);
          $hijomg = new Asignacion();
          foreach($hijomenordatos as $value_dos){
            //----datos para enviar
            $hijomg->Titular = 1;
            $hijomg->Empndoc = $empleadodatos->legempleado_nrodocto;
            $hijomg->Empapellido = $empleadodatos->legempleado_apellido;
            $hijomg->Empnombres = $empleadodatos->legempleado_nombres;
            $hijomg->Benid = $empleadodatos->legempleado_id;
            $hijomg->Benndoc = $empleadodatos->legempleado_nrodocto;
            $hijomg->Benapellido = $empleadodatos->legempleado_apellido;
            $hijomg->Bennombres = $empleadodatos->legempleado_nombres;
            $hijomg->Phcid = $value_dos->leghijo_id;
            $hijomg->Phcnoficio = $value_dos->leghijo_bennoficio;
            $hijomg->Phcndoc = $value_dos->leghijo_nrodocto;
            $hijomg->Phcapellido = $value_dos->leghijo_apellido;
            $hijomg->Phcnombres = $value_dos->leghijo_nombres;
            $hijomg->Periodoid = $periododatos->periodo_id;
            $hijomg->Liqcodid = 201;
            $hijomg->Asigtipoid = 2;
            $hijomg->Asigcantidad = 1;
            $hijomg->Asigestado = 1;
            //----Guardar asignacion ----
            $hijomg->Asignacionid = $this->model->AsignacionGuardarExe($hijomg);

          }
        }//---No tiene Hijos Menores

        //-- Pre-escolar --
        $escuelanivel = 1;
        $hijopreescolar = $this->model->HijosEscFilasNum($empleadonrodocto, $beneficiarionrodocto, $escuelanivel);
        if($hijopreescolar->escuelac > 0){
          //---- Tiene Hijos en Preescolar
          $hijopreescolardatos = $this->model->HijosEscObtener($empleadonrodocto, $beneficiarionrodocto, $escuelanivel);
          $hijoesc1 = new Asignacion();
          foreach($hijopreescolardatos as $value_tres){
            //----datos para enviar
            $hijoesc1->Titular = 1;
            $hijoesc1->Empndoc = $empleadodatos->legempleado_nrodocto;
            $hijoesc1->Empapellido = $empleadodatos->legempleado_apellido;
            $hijoesc1->Empnombres = $empleadodatos->legempleado_nombres;
            $hijoesc1->Benid = $empleadodatos->legempleado_id;
            $hijoesc1->Benndoc = $empleadodatos->legempleado_nrodocto;
            $hijoesc1->Benapellido = $empleadodatos->legempleado_apellido;
            $hijoesc1->Bennombres = $empleadodatos->legempleado_nombres;
            $hijoesc1->Phcid = $value_tres->leghijo_id;
            $hijoesc1->Phcnoficio = $value_tres->leghijo_bennoficio;
            $hijoesc1->Phcndoc = $value_tres->leghijo_nrodocto;
            $hijoesc1->Phcapellido = $value_tres->leghijo_apellido;
            $hijoesc1->Phcnombres = $value_tres->leghijo_nombres;
            $hijoesc1->Periodoid = $periododatos->periodo_id;
            $hijoesc1->Liqcodid = 204;
            $hijoesc1->Asigtipoid = 4;
            $hijoesc1->Asigcantidad = 1;
            $hijoesc1->Asigestado = 1;
            //----Guardar asignacion ----
            $hijoesc1->Asignacionid = $this->model->AsignacionGuardarExe($hijoesc1);
          }
        }//--- No tiene Hijos en Preescolar

        //-- Esc Primaria --
        $escuelanivel = 2;
        $hijoprimaria = $this->model->HijosEscFilasNum($empleadonrodocto, $beneficiarionrodocto, $escuelanivel);
        if($hijoprimaria->escuelac > 0){
          //---- Tiene Hijos en Primaria
          $hijoescprimariadatos = $this->model->HijosEscObtener($empleadonrodocto, $beneficiarionrodocto, $escuelanivel);
          $hijoesc2 = new Asignacion();
          foreach($hijoescprimariadatos as $value_cuatro){
            //----datos para enviar
            $hijoesc2->Titular = 1;
            $hijoesc2->Empndoc = $empleadodatos->legempleado_nrodocto;
            $hijoesc2->Empapellido = $empleadodatos->legempleado_apellido;
            $hijoesc2->Empnombres = $empleadodatos->legempleado_nombres;
            $hijoesc2->Benid = $empleadodatos->legempleado_id;
            $hijoesc2->Benndoc = $empleadodatos->legempleado_nrodocto;
            $hijoesc2->Benapellido = $empleadodatos->legempleado_apellido;
            $hijoesc2->Bennombres = $empleadodatos->legempleado_nombres;
            $hijoesc2->Phcid = $value_cuatro->leghijo_id;
            $hijoesc2->Phcnoficio = $value_cuatro->leghijo_bennoficio;
            $hijoesc2->Phcndoc = $value_cuatro->leghijo_nrodocto;
            $hijoesc2->Phcapellido = $value_cuatro->leghijo_apellido;
            $hijoesc2->Phcnombres = $value_cuatro->leghijo_nombres;
            $hijoesc2->Periodoid = $periododatos->periodo_id;
            $hijoesc2->Liqcodid = 206;
            $hijoesc2->Asigtipoid = 5;
            $hijoesc2->Asigcantidad = 1;
            $hijoesc2->Asigestado = 1;
            //----Guardar asignacion ----
            $hijoesc2->Asignacionid = $this->model->AsignacionGuardarExe($hijoesc2);

          }

        }//--- No tiene Hijos en Escuela Primaria

        //-- Esc Sec y Sup --
        $escuelanivel = 3;
        $escuelamedsup = $this->model->HijosEscFilasNum($empleadonrodocto, $beneficiarionrodocto, $escuelanivel);
        if($escuelamedsup->escuelac > 0){
          //---- Tiene Hijos en escuela secuntaria y superior
          $hijoescsecsupdatos = $this->model->HijosEscObtener($empleadonrodocto, $beneficiarionrodocto, $escuelanivel);
          $hijoesc3 = new Asignacion();
          foreach($hijoescsecsupdatos as $value_cinco){
            //----datos para enviar
            $hijoesc3->Titular = 1;
            $hijoesc3->Empndoc = $empleadodatos->legempleado_nrodocto;
            $hijoesc3->Empapellido = $empleadodatos->legempleado_apellido;
            $hijoesc3->Empnombres = $empleadodatos->legempleado_nombres;
            $hijoesc3->Benid = $empleadodatos->legempleado_id;
            $hijoesc3->Benndoc = $empleadodatos->legempleado_nrodocto;
            $hijoesc3->Benapellido = $empleadodatos->legempleado_apellido;
            $hijoesc3->Bennombres = $empleadodatos->legempleado_nombres;
            $hijoesc3->Phcid = $value_cinco->leghijo_id;
            $hijoesc3->Phcnoficio = $value_cinco->leghijo_bennoficio;
            $hijoesc3->Phcndoc = $value_cinco->leghijo_nrodocto;
            $hijoesc3->Phcapellido = $value_cinco->leghijo_apellido;
            $hijoesc3->Phcnombres = $value_cinco->leghijo_nombres;
            $hijoesc3->Periodoid = $periododatos->periodo_id;
            $hijoesc3->Liqcodid = 209;
            $hijoesc3->Asigtipoid = 6;
            $hijoesc3->Asigcantidad = 1;
            $hijoesc3->Asigestado = 1;
            //----Guardar asignacion ----
            $hijoesc3->Asignacionid = $this->model->AsignacionGuardarExe($hijoesc3);

          }
        }//--- No tiene Hijos en escuela secundaria y superior

        //-- Discapacidad --
        $hijodisc = $this->model->HijoDiscFilasNum($empleadonrodocto, $beneficiarionrodocto);
        if($hijodisc->hijodisc > 0){
          //-- Tiene hijos con discapacidad
          $hijodiscdatos = $this->model->HijoDiscObtener($empleadonrodocto, $beneficiarionrodocto);
          $hijoesc4 = new Asignacion();
          foreach($hijodiscdatos as $value_seis){
            //----datos para enviar
            $hijoesc4->Titular = 1;
            $hijoesc4->Empndoc = $empleadodatos->legempleado_nrodocto;
            $hijoesc4->Empapellido = $empleadodatos->legempleado_apellido;
            $hijoesc4->Empnombres = $empleadodatos->legempleado_nombres;
            $hijoesc4->Benid = $empleadodatos->legempleado_id;
            $hijoesc4->Benndoc = $empleadodatos->legempleado_nrodocto;
            $hijoesc4->Benapellido = $empleadodatos->legempleado_apellido;
            $hijoesc4->Bennombres = $empleadodatos->legempleado_nombres;
            $hijoesc4->Phcid = $value_seis->leghijo_id;
            $hijoesc4->Phcnoficio = $value_seis->leghijo_bennoficio;
            $hijoesc4->Phcndoc = $value_seis->leghijo_nrodocto;
            $hijoesc4->Phcapellido = $value_seis->leghijo_apellido;
            $hijoesc4->Phcnombres = $value_seis->leghijo_nombres;
            $hijoesc4->Periodoid = $periododatos->periodo_id;
            $hijoesc4->Liqcodid = 202;
            $hijoesc4->Asigtipoid = 3;
            $hijoesc4->Asigcantidad = 1;
            $hijoesc4->Asigestado = 1;
            //----Guardar asignacion ----
            $hijoesc4->Asignacionid = $this->model->AsignacionGuardarExe($hijoesc4);

          }
        }//-- No tiene Hijos Con discapacidad

        //-- Esc con Discapacidad --
        $hijodiscesc = $this->model->HijoDiscEscFilasNum($empleadonrodocto, $beneficiarionrodocto);
        if($hijodiscesc->hijodiscesc > 0){
          //--- Tiene hijos con discapacidad en escuela ---
          $hijodiscescdatos = $this->model->HijoDiscEscObtener($empleadonrodocto, $beneficiarionrodocto);
          $hijoesc5 = new Asignacion();
          foreach($hijodiscescdatos as $value_siete){
            //----datos para enviar
            $hijoesc5->Titular = 1;
            $hijoesc5->Empndoc = $empleadodatos->legempleado_nrodocto;
            $hijoesc5->Empapellido = $empleadodatos->legempleado_apellido;
            $hijoesc5->Empnombres = $empleadodatos->legempleado_nombres;
            $hijoesc5->Benid = $empleadodatos->legempleado_id;
            $hijoesc5->Benndoc = $empleadodatos->legempleado_nrodocto;
            $hijoesc5->Benapellido = $empleadodatos->legempleado_apellido;
            $hijoesc5->Bennombres = $empleadodatos->legempleado_nombres;
            $hijoesc5->Phcid = $value_siete->leghijo_id;
            $hijoesc5->Phcnoficio = $value_siete->leghijo_bennoficio;
            $hijoesc5->Phcndoc = $value_siete->leghijo_nrodocto;
            $hijoesc5->Phcapellido = $value_siete->leghijo_apellido;
            $hijoesc5->Phcnombres = $value_siete->leghijo_nombres;
            $hijoesc5->Periodoid = $periododatos->periodo_id;
            $hijoesc5->Liqcodid = 212;
            $hijoesc5->Asigtipoid = 7;
            $hijoesc5->Asigcantidad = 1;
            $hijoesc5->Asigestado = 1;
            //----Guardar asignacion ----
            $hijoesc5->Asignacionid = $this->model->AsignacionGuardarExe($hijoesc5);

          }

        }//--- No tiene hijos escolares con discapacidad --

        //-- Familia Numerosa --
        $totalasignaciones = $hijomenor->hijom +
                             $hijopreescolar->escuelac +
                             $hijoprimaria->escuelac +
                             $escuelamedsup->escuelac +
                             $hijodisc->hijodisc +
                             $hijodiscesc->hijodiscesc;

        $familianum = 0;
        if($totalasignaciones < 3){
          //----- no tiene familia numerosa
          $familianum = 0;
        }else{
          $familianum = $totalasignaciones - 2;
          //----datos para enviar
          $famnumg = new Asignacion();
          $famnumg->Titular = 1;
          $famnumg->Empndoc = $empleadodatos->legempleado_nrodocto;
          $famnumg->Empapellido = $empleadodatos->legempleado_apellido;
          $famnumg->Empnombres = $empleadodatos->legempleado_nombres;
          $famnumg->Benid = $empleadodatos->legempleado_id;
          $famnumg->Benndoc = $empleadodatos->legempleado_nrodocto;
          $famnumg->Benapellido = $empleadodatos->legempleado_apellido;
          $famnumg->Bennombres = $empleadodatos->legempleado_nombres;
          $famnumg->Phcid = 0;
          $famnumg->Phcnoficio = "";
          $famnumg->Phcndoc = 0;
          $famnumg->Phcapellido = "";
          $famnumg->Phcnombres = "";
          $famnumg->Periodoid = $periododatos->periodo_id;
          $famnumg->Liqcodid = 203;
          $famnumg->Asigtipoid = 8;
          $famnumg->Asigcantidad = $familianum;
          $famnumg->Asigestado = 1;
          //----Guardar asignacion ----
          $this->model->AsignacionGuardarExe($famnumg);
          //$this->model->FamiliaNumAOBPasarExe($empleadonrodocto,$beneficiarionrodocto,$familianum);
        }
        //----Pasar a liquidaciones Waldbott ---
        $wald = new Asignacion();
        $wald->Nrodocto = $empleadonrodocto;
        $wald->Conyuge = $conyuge->conyugec;
        $wald->Prenatal = $prenatal->prenatalc;
        $wald->Hijomenor = $hijomenor->hijom + $hijopreescolar->escuelac + $hijoprimaria->escuelac + $escuelamedsup->escuelac;
        $wald->Hijodisc = $hijodisc->hijodisc + $hijodiscesc->hijodiscesc;
        $wald->Hijopreescolar = $hijopreescolar->escuelac;
        $wald->Hijoprimaria = $hijoprimaria->escuelac;
        $wald->Hijomedsub = $escuelamedsup->escuelac;
        $wald->Hijodiscesc = $hijodiscesc->hijodiscesc;
        $wald->FamNumerosa = $familianum;
        $this->model->WaldbottAPasarExe($wald);
      }
      //header("Location: index.php");
      header("Location: ../asignaciones/?c=asignacion&a=Asignaciones");
    }
    public function AsignacionesOBPaseALiq(){
      //-----Datos de Periodo actual ----
      $periododatos = $this->model->PeriodoActualObtener();
      //id de periodo anterior -----
      $pia = $periododatos->periodo_id - 1;

      foreach($this->model->AsignacionesOBListado() as $row){
        $empleadonrodocto = $row->empleado;
        $beneficiarionrodocto = $row->beneficiario;
        //----datos de empleado ---
        $empleadodatos = $this->model->EmpleadoAYNObtener($empleadonrodocto);
        //----datos de beneficiario ---
        $beneficiariodatos = $this->model->EmpleadoAYNObtener($beneficiarionrodocto);
        //-- Pre-Natal --
        $prenatal = $this->model->PreNatalFilasNum($empleadonrodocto, $beneficiarionrodocto);
        if($prenatal->prenatalc > 0){
          //--Tiene Pre-Natales
          $prenataldatos = $this->model->PreNatalObtener($empleadonrodocto, $beneficiarionrodocto);
          $prenatalg = new Asignacion();
          foreach($prenataldatos as $value_uno){
            //----datos para enviar
            $prenatalg->Titular = 2;
            $prenatalg->Empndoc = $empleadodatos->legempleado_nrodocto;
            $prenatalg->Empapellido = $empleadodatos->legempleado_apellido;
            $prenatalg->Empnombres = $empleadodatos->legempleado_nombres;
            $prenatalg->Benid = $value_uno->legempleado_id_ben;
            $prenatalg->Benndoc = $value_uno->legprenatal_benndoc;
            $prenatalg->Benapellido = $value_uno->legprenatal_benapellido;
            $prenatalg->Bennombres = $value_uno->legprenatal_bennombres;
            $prenatalg->Phcid = $value_uno->legprenatal_id;
            $prenatalg->Phcnoficio = "";
            $prenatalg->Phcndoc = 0;
            $prenatalg->Phcapellido = "";
            $prenatalg->Phcnombres = "";
            $prenatalg->Periodoid = $periododatos->periodo_id;
            $prenatalg->Liqcodid = 214;
            $prenatalg->Asigtipoid = 1;
            $prenatalg->Asigcantidad = 1;
            $prenatalg->Asigestado = 1;
            //----Guardar asignacion ----
            $prenatalg->Asignacionid = $this->model->AsignacionGuardarExe($prenatalg);
          }
        }//--No tiene Pre-Natales

        //-- Hijo Menor --
        $fecha_actual = date("Y-m-d");
        $fecha_uno = date("Y-m-d",strtotime($fecha_actual."- 5 year"));//resto 5 años
		    $fecha_final = date("Y-m-d",strtotime($fecha_uno."- 5 month"));//resto 5 meses
        $hijomenor = $this->model->HijoMenorFilasNum($empleadonrodocto, $beneficiarionrodocto, $fecha_actual, $fecha_final);
        if($hijomenor->hijom > 0){
          //--- Tiene Hijos MENORES ---
          $hijomenordatos = $this->model->HijoMenorObtener($empleadonrodocto, $beneficiarionrodocto, $fecha_actual, $fecha_final);
          $hijomg = new Asignacion();
          foreach($hijomenordatos as $value_dos){
            //----datos para enviar
            $hijomg->Titular = 2;
            $hijomg->Empndoc = $empleadodatos->legempleado_nrodocto;
            $hijomg->Empapellido = $empleadodatos->legempleado_apellido;
            $hijomg->Empnombres = $empleadodatos->legempleado_nombres;
            $hijomg->Benid = $value_dos->legempleado_id_ben;
            $hijomg->Benndoc = $value_dos->leghijo_benndoc;
            $hijomg->Benapellido = $value_dos->leghijo_benapellido;
            $hijomg->Bennombres = $value_dos->leghijo_bennombres;
            $hijomg->Phcid = $value_dos->leghijo_id;
            $hijomg->Phcnoficio = $value_dos->leghijo_bennoficio;
            $hijomg->Phcndoc = $value_dos->leghijo_nrodocto;
            $hijomg->Phcapellido = $value_dos->leghijo_apellido;
            $hijomg->Phcnombres = $value_dos->leghijo_nombres;
            $hijomg->Periodoid = $periododatos->periodo_id;
            $hijomg->Liqcodid = 201;
            $hijomg->Asigtipoid = 2;
            $hijomg->Asigcantidad = 1;
            $hijomg->Asigestado = 1;
            //----Guardar asignacion ----
            $hijomg->Asignacionid = $this->model->AsignacionGuardarExe($hijomg);
          }
        }//---No tiene Hijos Menores

        //-- Pre-escolar --
        $escuelanivel = 1;
        $hijopreescolar = $this->model->HijosEscFilasNum($empleadonrodocto, $beneficiarionrodocto, $escuelanivel);
        if($hijopreescolar->escuelac > 0){
          //---- Tiene Hijos en Preescolar
          $hijopreescolardatos = $this->model->HijosEscObtener($empleadonrodocto, $beneficiarionrodocto, $escuelanivel);
          $hijoesc1 = new Asignacion();
          foreach($hijopreescolardatos as $value_tres){
            //----datos para enviar
            $hijoesc1->Titular = 2;
            $hijoesc1->Empndoc = $empleadodatos->legempleado_nrodocto;
            $hijoesc1->Empapellido = $empleadodatos->legempleado_apellido;
            $hijoesc1->Empnombres = $empleadodatos->legempleado_nombres;
            $hijoesc1->Benid = $value_tres->legempleado_id_ben;
            $hijoesc1->Benndoc = $value_tres->leghijo_benndoc;
            $hijoesc1->Benapellido = $value_tres->leghijo_benapellido;
            $hijoesc1->Bennombres = $value_tres->leghijo_bennombres;
            $hijoesc1->Phcid = $value_tres->leghijo_id;
            $hijoesc1->Phcnoficio = $value_tres->leghijo_bennoficio;
            $hijoesc1->Phcndoc = $value_tres->leghijo_nrodocto;
            $hijoesc1->Phcapellido = $value_tres->leghijo_apellido;
            $hijoesc1->Phcnombres = $value_tres->leghijo_nombres;
            $hijoesc1->Periodoid = $periododatos->periodo_id;
            $hijoesc1->Liqcodid = 204;
            $hijoesc1->Asigtipoid = 4;
            $hijoesc1->Asigcantidad = 1;
            $hijoesc1->Asigestado = 1;
            //----Guardar asignacion ----
            $hijoesc1->Asignacionid = $this->model->AsignacionGuardarExe($hijoesc1);
          }
        }//--- No tiene Hijos en Preescolar

        //-- Esc Primaria --
        $escuelanivel = 2;
        $hijoprimaria = $this->model->HijosEscFilasNum($empleadonrodocto, $beneficiarionrodocto, $escuelanivel);
        if($hijoprimaria->escuelac > 0){
          //---- Tiene Hijos en Primaria
          $hijoescprimariadatos = $this->model->HijosEscObtener($empleadonrodocto, $beneficiarionrodocto, $escuelanivel);
          $hijoesc2 = new Asignacion();
          foreach($hijoescprimariadatos as $value_cuatro){
            //----datos para enviar
            $hijoesc2->Titular = 2;
            $hijoesc2->Empndoc = $empleadodatos->legempleado_nrodocto;
            $hijoesc2->Empapellido = $empleadodatos->legempleado_apellido;
            $hijoesc2->Empnombres = $empleadodatos->legempleado_nombres;
            $hijoesc2->Benid = $value_cuatro->legempleado_id_ben;
            $hijoesc2->Benndoc = $value_cuatro->leghijo_benndoc;
            $hijoesc2->Benapellido = $value_cuatro->leghijo_benapellido;
            $hijoesc2->Bennombres = $value_cuatro->leghijo_bennombres;
            $hijoesc2->Phcid = $value_cuatro->leghijo_id;
            $hijoesc2->Phcnoficio = $value_cuatro->leghijo_bennoficio;
            $hijoesc2->Phcndoc = $value_cuatro->leghijo_nrodocto;
            $hijoesc2->Phcapellido = $value_cuatro->leghijo_apellido;
            $hijoesc2->Phcnombres = $value_cuatro->leghijo_nombres;
            $hijoesc2->Periodoid = $periododatos->periodo_id;
            $hijoesc2->Liqcodid = 206;
            $hijoesc2->Asigtipoid = 5;
            $hijoesc2->Asigcantidad = 1;
            $hijoesc2->Asigestado = 1;
            //----Guardar asignacion ----
            $hijoesc2->Asignacionid = $this->model->AsignacionGuardarExe($hijoesc2);
          }
        }//--- No tiene Hijos en Escuela Primaria

        //-- Esc Sec y Sup --
        $escuelanivel = 3;
        $escuelamedsup = $this->model->HijosEscFilasNum($empleadonrodocto, $beneficiarionrodocto, $escuelanivel);
        if($escuelamedsup->escuelac > 0){
          //---- Tiene Hijos en escuela secuntaria y superior
          $hijoescsecsupdatos = $this->model->HijosEscObtener($empleadonrodocto, $beneficiarionrodocto, $escuelanivel);
          $hijoesc3 = new Asignacion();
          foreach($hijoescsecsupdatos as $value_cinco){
            //----datos para enviar
            $hijoesc3->Titular = 2;
            $hijoesc3->Empndoc = $empleadodatos->legempleado_nrodocto;
            $hijoesc3->Empapellido = $empleadodatos->legempleado_apellido;
            $hijoesc3->Empnombres = $empleadodatos->legempleado_nombres;
            $hijoesc3->Benid = $value_cinco->legempleado_id_ben;
            $hijoesc3->Benndoc = $value_cinco->leghijo_benndoc;
            $hijoesc3->Benapellido = $value_cinco->leghijo_benapellido;
            $hijoesc3->Bennombres = $value_cinco->leghijo_bennombres;
            $hijoesc3->Phcid = $value_cinco->leghijo_id;
            $hijoesc3->Phcnoficio = $value_cinco->leghijo_bennoficio;
            $hijoesc3->Phcndoc = $value_cinco->leghijo_nrodocto;
            $hijoesc3->Phcapellido = $value_cinco->leghijo_apellido;
            $hijoesc3->Phcnombres = $value_cinco->leghijo_nombres;
            $hijoesc3->Periodoid = $periododatos->periodo_id;
            $hijoesc3->Liqcodid = 209;
            $hijoesc3->Asigtipoid = 6;
            $hijoesc3->Asigcantidad = 1;
            $hijoesc3->Asigestado = 1;
            //----Guardar asignacion ----
            $hijoesc3->Asignacionid = $this->model->AsignacionGuardarExe($hijoesc3);
          }
        }//--- No tiene Hijos en escuela secundaria y superior


        //-- Discapacidad --
        $hijodisc = $this->model->HijoDiscFilasNum($empleadonrodocto, $beneficiarionrodocto);
        if($hijodisc->hijodisc > 0){
          //-- Tiene hijos con discapacidad
          $hijodiscdatos = $this->model->HijoDiscObtener($empleadonrodocto, $beneficiarionrodocto);
          $hijoesc4 = new Asignacion();
          foreach($hijodiscdatos as $value_seis){
            //----datos para enviar
            $hijoesc4->Titular = 2;
            $hijoesc4->Empndoc = $empleadodatos->legempleado_nrodocto;
            $hijoesc4->Empapellido = $empleadodatos->legempleado_apellido;
            $hijoesc4->Empnombres = $empleadodatos->legempleado_nombres;
            $hijoesc4->Benid = $value_seis->legempleado_id_ben;
            $hijoesc4->Benndoc = $value_seis->leghijo_benndoc;
            $hijoesc4->Benapellido = $value_seis->leghijo_benapellido;
            $hijoesc4->Bennombres = $value_seis->leghijo_bennombres;
            $hijoesc4->Phcid = $value_seis->leghijo_id;
            $hijoesc4->Phcnoficio = $value_seis->leghijo_bennoficio;
            $hijoesc4->Phcndoc = $value_seis->leghijo_nrodocto;
            $hijoesc4->Phcapellido = $value_seis->leghijo_apellido;
            $hijoesc4->Phcnombres = $value_seis->leghijo_nombres;
            $hijoesc4->Periodoid = $periododatos->periodo_id;
            $hijoesc4->Liqcodid = 202;
            $hijoesc4->Asigtipoid = 3;
            $hijoesc4->Asigcantidad = 1;
            $hijoesc4->Asigestado = 1;
            //----Guardar asignacion ----
            $hijoesc4->Asignacionid = $this->model->AsignacionGuardarExe($hijoesc4);
          }
        }//-- No tiene Hijos Con discapacidad


        //-- Esc con Discapacidad --
        $hijodiscesc = $this->model->HijoDiscEscFilasNum($empleadonrodocto, $beneficiarionrodocto);
        if($hijodiscesc->hijodiscesc > 0){
          //--- Tiene hijos con discapacidad en escuela ---
          $hijodiscescdatos = $this->model->HijoDiscEscObtener($empleadonrodocto, $beneficiarionrodocto);
          $hijoesc5 = new Asignacion();
          foreach($hijodiscescdatos as $value_siete){
            //----datos para enviar
            $hijoesc5->Titular = 2;
            $hijoesc5->Empndoc = $empleadodatos->legempleado_nrodocto;
            $hijoesc5->Empapellido = $empleadodatos->legempleado_apellido;
            $hijoesc5->Empnombres = $empleadodatos->legempleado_nombres;
            $hijoesc5->Benid = $value_siete->legempleado_id_ben;
            $hijoesc5->Benndoc = $value_siete->leghijo_benndoc;
            $hijoesc5->Benapellido = $value_siete->leghijo_benapellido;
            $hijoesc5->Bennombres = $value_siete->leghijo_bennombres;
            $hijoesc5->Phcid = $value_siete->leghijo_id;
            $hijoesc5->Phcnoficio = $value_siete->leghijo_bennoficio;
            $hijoesc5->Phcndoc = $value_siete->leghijo_nrodocto;
            $hijoesc5->Phcapellido = $value_siete->leghijo_apellido;
            $hijoesc5->Phcnombres = $value_siete->leghijo_nombres;
            $hijoesc5->Periodoid = $periododatos->periodo_id;
            $hijoesc5->Liqcodid = 212;
            $hijoesc5->Asigtipoid = 7;
            $hijoesc5->Asigcantidad = 1;
            $hijoesc5->Asigestado = 1;
            //----Guardar asignacion ----
            $hijoesc5->Asignacionid = $this->model->AsignacionGuardarExe($hijoesc5);
          }
        }//--- No tiene hijos escolares con discapacidad --

        //-- Familia Numerosa --
        $totalasignaciones = $hijomenor->hijom +
                             $hijopreescolar->escuelac +
                             $hijoprimaria->escuelac +
                             $escuelamedsup->escuelac +
                             $hijodisc->hijodisc +
                             $hijodiscesc->hijodiscesc;

        $familianum = 0;
        if($totalasignaciones < 3){
          //----- no tiene familia numerosa
          $familianum = 0;
        }else{
          $familianum = $totalasignaciones - 2;
          //----datos para enviar
          $famnumg = new Asignacion();
          $famnumg->Titular = 2;
          $famnumg->Empndoc = $empleadodatos->legempleado_nrodocto;
          $famnumg->Empapellido = $empleadodatos->legempleado_apellido;
          $famnumg->Empnombres = $empleadodatos->legempleado_nombres;
          $famnumg->Benid = $beneficiariodatos->legempleado_id;
          $famnumg->Benndoc = $beneficiariodatos->legempleado_nrodocto;
          $famnumg->Benapellido = $beneficiariodatos->legempleado_apellido;
          $famnumg->Bennombres = $beneficiariodatos->legempleado_nombres;
          $famnumg->Phcid = 0;
          $famnumg->Phcnoficio = "";
          $famnumg->Phcndoc = 0;
          $famnumg->Phcapellido = "";
          $famnumg->Phcnombres = "";
          $famnumg->Periodoid = $periododatos->periodo_id;
          $famnumg->Liqcodid = 203;
          $famnumg->Asigtipoid = 8;
          $famnumg->Asigcantidad = $familianum;
          $famnumg->Asigestado = 1;
          //----Guardar asignacion ----
          $this->model->AsignacionGuardarExe($famnumg);
        }
      }

      header("Location: ../asignaciones/?c=asignacion&a=AsignacionesOB");
    }
    public function AyudaEscolarOBPaseALiq(){
      //-----Datos de Periodo actual ----
      $periododatos = $this->model->PeriodoActualObtener();
      //id de periodo anterior -----
      $pia = $periododatos->periodo_id - 1;

      foreach($this->model->AyudaEscolarOBListado() as $row){
        $empleadonrodocto = $row->empleado;
        $beneficiarionrodocto = $row->beneficiario;
        //----datos de empleado ---
        $empleadodatos = $this->model->EmpleadoAYNObtener($empleadonrodocto);
        //----datos de beneficiario ---
        $beneficiariodatos = $this->model->EmpleadoAYNObtener($beneficiarionrodocto);
        //-- Pre-escolar --
        $escuelanivel = 1;
        $hijopreescolar = $this->model->HijosEscFilasNum($empleadonrodocto, $beneficiarionrodocto, $escuelanivel);
        if($hijopreescolar->escuelac > 0){
          //---- Tiene Hijos en Preescolar
          $hijopreescolardatos = $this->model->HijosEscObtener($empleadonrodocto, $beneficiarionrodocto, $escuelanivel);
          $hijoesc1 = new Asignacion();
          foreach($hijopreescolardatos as $value_tres){
            //----datos para enviar
            $hijoesc1->Titular = 2;
            $hijoesc1->Empndoc = $empleadodatos->legempleado_nrodocto;
            $hijoesc1->Empapellido = $empleadodatos->legempleado_apellido;
            $hijoesc1->Empnombres = $empleadodatos->legempleado_nombres;
            $hijoesc1->Benid = $value_tres->legempleado_id_ben;
            $hijoesc1->Benndoc = $value_tres->leghijo_benndoc;
            $hijoesc1->Benapellido = $value_tres->leghijo_benapellido;
            $hijoesc1->Bennombres = $value_tres->leghijo_bennombres;
            $hijoesc1->Phcid = $value_tres->leghijo_id;
            $hijoesc1->Phcnoficio = $value_tres->leghijo_bennoficio;
            $hijoesc1->Phcndoc = $value_tres->leghijo_nrodocto;
            $hijoesc1->Phcapellido = $value_tres->leghijo_apellido;
            $hijoesc1->Phcnombres = $value_tres->leghijo_nombres;
            $hijoesc1->Periodoid = $periododatos->periodo_id;
            $hijoesc1->Liqcodid = 255;// AYUDA ESCUELA PREESCOLAR
            $hijoesc1->Asigtipoid = 10;
            $hijoesc1->Asigcantidad = 1;
            $hijoesc1->Asigestado = 1;
            //----Guardar asignacion ----
            $hijoesc1->Asignacionid = $this->model->AsignacionGuardarExe($hijoesc1);
          }
        }//--- No tiene Hijos en Preescolar

        //-- Esc Primaria --
        $escuelanivel = 2;
        $hijoprimaria = $this->model->HijosEscFilasNum($empleadonrodocto, $beneficiarionrodocto, $escuelanivel);
        if($hijoprimaria->escuelac > 0){
          //---- Tiene Hijos en Primaria
          $hijoescprimariadatos = $this->model->HijosEscObtener($empleadonrodocto, $beneficiarionrodocto, $escuelanivel);
          $hijoesc2 = new Asignacion();
          foreach($hijoescprimariadatos as $value_cuatro){
            //----datos para enviar
            $hijoesc2->Titular = 2;
            $hijoesc2->Empndoc = $empleadodatos->legempleado_nrodocto;
            $hijoesc2->Empapellido = $empleadodatos->legempleado_apellido;
            $hijoesc2->Empnombres = $empleadodatos->legempleado_nombres;
            $hijoesc2->Benid = $value_cuatro->legempleado_id_ben;
            $hijoesc2->Benndoc = $value_cuatro->leghijo_benndoc;
            $hijoesc2->Benapellido = $value_cuatro->leghijo_benapellido;
            $hijoesc2->Bennombres = $value_cuatro->leghijo_bennombres;
            $hijoesc2->Phcid = $value_cuatro->leghijo_id;
            $hijoesc2->Phcnoficio = $value_cuatro->leghijo_bennoficio;
            $hijoesc2->Phcndoc = $value_cuatro->leghijo_nrodocto;
            $hijoesc2->Phcapellido = $value_cuatro->leghijo_apellido;
            $hijoesc2->Phcnombres = $value_cuatro->leghijo_nombres;
            $hijoesc2->Periodoid = $periododatos->periodo_id;
            $hijoesc2->Liqcodid = 256;//AYUDA ESCUELA PRIMARIA
            $hijoesc2->Asigtipoid = 11;
            $hijoesc2->Asigcantidad = 1;
            $hijoesc2->Asigestado = 1;
            //----Guardar asignacion ----
            $hijoesc2->Asignacionid = $this->model->AsignacionGuardarExe($hijoesc2);
          }
        }//--- No tiene Hijos en Escuela Primaria

        //-- Esc Sec y Sup --
        $escuelanivel = 3;
        $escuelamedsup = $this->model->HijosEscFilasNum($empleadonrodocto, $beneficiarionrodocto, $escuelanivel);
        if($escuelamedsup->escuelac > 0){
          //---- Tiene Hijos en escuela secuntaria y superior
          $hijoescsecsupdatos = $this->model->HijosEscObtener($empleadonrodocto, $beneficiarionrodocto, $escuelanivel);
          $hijoesc3 = new Asignacion();
          foreach($hijoescsecsupdatos as $value_cinco){
            //----datos para enviar
            $hijoesc3->Titular = 2;
            $hijoesc3->Empndoc = $empleadodatos->legempleado_nrodocto;
            $hijoesc3->Empapellido = $empleadodatos->legempleado_apellido;
            $hijoesc3->Empnombres = $empleadodatos->legempleado_nombres;
            $hijoesc3->Benid = $value_cinco->legempleado_id_ben;
            $hijoesc3->Benndoc = $value_cinco->leghijo_benndoc;
            $hijoesc3->Benapellido = $value_cinco->leghijo_benapellido;
            $hijoesc3->Bennombres = $value_cinco->leghijo_bennombres;
            $hijoesc3->Phcid = $value_cinco->leghijo_id;
            $hijoesc3->Phcnoficio = $value_cinco->leghijo_bennoficio;
            $hijoesc3->Phcndoc = $value_cinco->leghijo_nrodocto;
            $hijoesc3->Phcapellido = $value_cinco->leghijo_apellido;
            $hijoesc3->Phcnombres = $value_cinco->leghijo_nombres;
            $hijoesc3->Periodoid = $periododatos->periodo_id;
            $hijoesc3->Liqcodid = 258;//SUB.AYDA ESC. MyS
            $hijoesc3->Asigtipoid = 12;
            $hijoesc3->Asigcantidad = 1;
            $hijoesc3->Asigestado = 1;
            //----Guardar asignacion ----
            $hijoesc3->Asignacionid = $this->model->AsignacionGuardarExe($hijoesc3);
          }
        }//--- No tiene Hijos en escuela secundaria y superior

        //-- Esc con Discapacidad --
        $hijodiscesc = $this->model->HijoDiscEscFilasNum($empleadonrodocto, $beneficiarionrodocto);
        if($hijodiscesc->hijodiscesc > 0){
          //--- Tiene hijos con discapacidad en escuela ---
          $hijodiscescdatos = $this->model->HijoDiscEscObtener($empleadonrodocto, $beneficiarionrodocto);
          $hijoesc5 = new Asignacion();
          foreach($hijodiscescdatos as $value_siete){
            //----datos para enviar
            $hijoesc5->Titular = 2;
            $hijoesc5->Empndoc = $empleadodatos->legempleado_nrodocto;
            $hijoesc5->Empapellido = $empleadodatos->legempleado_apellido;
            $hijoesc5->Empnombres = $empleadodatos->legempleado_nombres;
            $hijoesc5->Benid = $value_siete->legempleado_id_ben;
            $hijoesc5->Benndoc = $value_siete->leghijo_benndoc;
            $hijoesc5->Benapellido = $value_siete->leghijo_benapellido;
            $hijoesc5->Bennombres = $value_siete->leghijo_bennombres;
            $hijoesc5->Phcid = $value_siete->leghijo_id;
            $hijoesc5->Phcnoficio = $value_siete->leghijo_bennoficio;
            $hijoesc5->Phcndoc = $value_siete->leghijo_nrodocto;
            $hijoesc5->Phcapellido = $value_siete->leghijo_apellido;
            $hijoesc5->Phcnombres = $value_siete->leghijo_nombres;
            $hijoesc5->Periodoid = $periododatos->periodo_id;
            $hijoesc5->Liqcodid = 257;//AYUDA ESCUELA DISCAPACIDAD
            $hijoesc5->Asigtipoid = 13;
            $hijoesc5->Asigcantidad = 1;
            $hijoesc5->Asigestado = 1;
            //----Guardar asignacion ----
            $hijoesc5->Asignacionid = $this->model->AsignacionGuardarExe($hijoesc5);
          }
        }//--- No tiene hijos escolares con discapacidad --

        //-- Familia Numerosa --

      }

      header("Location: ../asignaciones/?c=asignacion&a=AyudaEscolarOB");
    }
    //////////////----------CODIGOS PARA CAMBIO DE NOMBRES-------
    public function CalcularImportesOB(){
      //----manejo de fechas ----
      $datetime = new DateTime();
			//$fecha_actual = $datetime->format('Y-m-d');
      $mes_actual = $datetime->format('n');
      //---- Perido actual -----------
      $periodoactivo = $this->model->PeriodoActualObtener();
      $periodoid = $periodoactivo->periodo_id;
      //---- Tipo de asignacion 1 // Pre-Natal ---
      $asignaciontipo = 214;
      $prenatalparam = $this->model->ObtenerAsignacionesParametros($asignaciontipo);
      foreach($prenatalparam as $row){
        $impdesde = $row->asigparam_desde;
        $imphasta = $row->asigparam_hasta;
        $imp_asignacion = $row->asigparam_importe;
        $this->model->LiquidarAsignacionesOB($asignaciontipo,$impdesde,$imphasta,$imp_asignacion,$periodoid);
      }
      //---- Tipo de asignacion 2 // Hijo Menor ---
      $asignaciontipo = 201;
      $hijomenorparam = $this->model->ObtenerAsignacionesParametros($asignaciontipo);
      foreach($hijomenorparam as $row){
        $impdesde = $row->asigparam_desde;
        $imphasta = $row->asigparam_hasta;
        $imp_asignacion = $row->asigparam_importe;
        $this->model->LiquidarAsignacionesOB($asignaciontipo,$impdesde,$imphasta,$imp_asignacion,$periodoid);
      }
      //---- Tipo de asignacion 3 // --- Hijo con Discapacidad
      $asignaciontipo = 202;
      $hijodiscparam = $this->model->ObtenerAsignacionesParametros($asignaciontipo);
      foreach($hijodiscparam as $row){
        $impdesde = $row->asigparam_desde;
        $imphasta = $row->asigparam_hasta;
        $imp_asignacion = $row->asigparam_importe;
        $this->model->LiquidarAsignacionesOB($asignaciontipo,$impdesde,$imphasta,$imp_asignacion,$periodoid);
      }
      //---- Tipo de asignacion 4 // Escuela Pre-escolar
      $asignaciontipo = 201;
      $escuela = 204;
      $preescolarparam = $this->model->ObtenerAsignacionesParametros($asignaciontipo);
      foreach($preescolarparam as $row){
        $impdesde = $row->asigparam_desde;
        $imphasta = $row->asigparam_hasta;
        $imp_uno = $row->asigparam_importe;
        $asignacionesc = $this->model->ObtenerAsignacionesEscolares($escuela);
        $imp_dos = $asignacionesc->asigparam_importe;
        $imp_asignacion = $imp_uno + $imp_dos;
        $this->model->LiquidarAsignacionesOB($escuela,$impdesde,$imphasta,$imp_asignacion,$periodoid);
      }
      //---- Tipo de asignacion 5 // Escuela Primaria
      $asignaciontipo = 201;
      $escuela = 206;
      $escprimariaparam = $this->model->ObtenerAsignacionesParametros($asignaciontipo);
      foreach($escprimariaparam as $row){
        $impdesde = $row->asigparam_desde;
        $imphasta = $row->asigparam_hasta;
        $imp_uno = $row->asigparam_importe;
        $asignacionesc = $this->model->ObtenerAsignacionesEscolares($escuela);
        $imp_dos = $asignacionesc->asigparam_importe;
        $imp_asignacion = $imp_uno + $imp_dos;
        $this->model->LiquidarAsignacionesOB($escuela,$impdesde,$imphasta,$imp_asignacion,$periodoid);
        //$this->model->LiquidarAsignacionesOBFamNum($escuela,$impdesde,$imphasta,$imp_asignacion,$periodoid);
      }
      //---- Tipo de asignacion 6 // Escuela Secundaria y Superior
      $asignaciontipo = 201;
      $escuela = 209;
      $escsecsupparam = $this->model->ObtenerAsignacionesParametros($asignaciontipo);
      foreach($escsecsupparam as $row){
        $impdesde = $row->asigparam_desde;
        $imphasta = $row->asigparam_hasta;
        $imp_uno = $row->asigparam_importe;
        $asignacionesc = $this->model->ObtenerAsignacionesEscolares($escuela);
        $imp_dos = $asignacionesc->asigparam_importe;
        $imp_asignacion = $imp_uno + $imp_dos;
        $this->model->LiquidarAsignacionesOB($escuela,$impdesde,$imphasta,$imp_asignacion,$periodoid);
      }
      //---- Tipo de asignacion 7 // Escolar con Discapacidad
      $asignaciontipo = 202;
      $escuela = 212;
      $escdiscparam = $this->model->ObtenerAsignacionesParametros($asignaciontipo);
      foreach($escdiscparam as $row){
        $impdesde = $row->asigparam_desde;
        $imphasta = $row->asigparam_hasta;
        $imp_uno = $row->asigparam_importe;
        $asignacionesc = $this->model->ObtenerAsignacionesEscolares($escuela);
        $imp_dos = $asignacionesc->asigparam_importe;
        $imp_asignacion = $imp_uno + $imp_dos;
        $this->model->LiquidarAsignacionesOB($escuela,$impdesde,$imphasta,$imp_asignacion,$periodoid);
      }
      //---- Tipo de asignacion 8 // Familia Numerosa
      $asignaciontipo = 203;
      $escsecsupparam = $this->model->ObtenerAsignacionesParametros($asignaciontipo);
      foreach($escsecsupparam as $row){
        $impdesde = $row->asigparam_desde;
        $imphasta = $row->asigparam_hasta;
        $imp_asignacion = $row->asigparam_importe;
        $this->model->LiquidarAsignacionesOB($asignaciontipo,$impdesde,$imphasta,$imp_asignacion,$periodoid);
      }
      foreach($this->model->AsignacionesOBLiqListado($periodoid) as $row){
        //----listado de beneficiarios a liquidar---

        $empndoc = $row->empleado;
        $benndoc = $row->beneficiario;
        $liqcodigos = $this->model->AsignacionesXCodigoObtener($empndoc,$benndoc,$periodoid);

        foreach ($liqcodigos as $liqcodigo) {
          //$this->model->LiquidarAsignacionesOBLote($empndoc,$benndoc,$periodoid);
          $liqcodigo->empndoc = $empndoc;
          $liqcodigo->benndoc = $benndoc;
          $liqcodigo->periodoid = $periodoid;
          $this->model->LiquidarAsignacionesOBLote($liqcodigo);
        }

        if($mes_actual == 1){
          $cargasfamiliares = $this->model->LiquidarAsignacionesOBLoteDoble($empndoc,$benndoc,$periodoid);
        }
        $this->model->HaberesRemunerativosObtener($empndoc, $benndoc, $periodoid);
  			$this->model->AsignacionesFamiliaresObtener($empndoc, $benndoc, $periodoid);
  			$this->model->HaberesNoRemunerativosObtener($empndoc, $benndoc, $periodoid);
  			$this->model->DescuentosObtener($empndoc, $benndoc, $periodoid);
        $this->model->SueldoNetoObtener($empndoc, $benndoc, $periodoid);
        //$this->model->ReLiquidarOB($empndoc, $benndoc, $periodoid);
      }

      header("Location: ../asignaciones/?c=asignacion&a=AsignacionesOBLiquidaciones");
    }
    public function LiquidarAyudaEscolarOB(){
      //----manejo de fechas ----
      $datetime = new DateTime();
			//$fecha_actual = $datetime->format('Y-m-d');
      $mes_actual = $datetime->format('n');
      //---- Perido actual -----------
      $periodoactivo = $this->model->PeriodoActualObtener();
      $periodoid = $periodoactivo->periodo_id;
      //---- Ayuda Escuela Pre-escolar
      $asignaciontipo = 255;
      //$escuela = 204;
      $preescolarparam = $this->model->ObtenerAsignacionesParametros($asignaciontipo);
      foreach($preescolarparam as $row){
        $impdesde = $row->asigparam_desde;
        $imphasta = $row->asigparam_hasta;
        $imp_uno = $row->asigparam_importe;
        //$asignacionesc = $this->model->ObtenerAsignacionesEscolares($escuela);
        //$imp_dos = $asignacionesc->asigparam_importe;
        $imp_asignacion = $imp_uno;
        $this->model->LiquidarAsignacionesOB($asignaciontipo,$impdesde,$imphasta,$imp_asignacion,$periodoid);
      }
      //---- Ayuda Escuela Primaria
      $asignaciontipo = 256;
      //$escuela = 206;
      $escprimariaparam = $this->model->ObtenerAsignacionesParametros($asignaciontipo);
      foreach($escprimariaparam as $row){
        $impdesde = $row->asigparam_desde;
        $imphasta = $row->asigparam_hasta;
        $imp_uno = $row->asigparam_importe;
        //$asignacionesc = $this->model->ObtenerAsignacionesEscolares($escuela);
        //$imp_dos = $asignacionesc->asigparam_importe;
        $imp_asignacion = $imp_uno;
        $this->model->LiquidarAsignacionesOB($asignaciontipo,$impdesde,$imphasta,$imp_asignacion,$periodoid);
      }
      //---- Ayuda Escuela Secundaria y Superior
      $asignaciontipo = 258;
      //$escuela = 209;
      $escsecsupparam = $this->model->ObtenerAsignacionesParametros($asignaciontipo);
      foreach($escsecsupparam as $row){
        $impdesde = $row->asigparam_desde;
        $imphasta = $row->asigparam_hasta;
        $imp_uno = $row->asigparam_importe;
        //$asignacionesc = $this->model->ObtenerAsignacionesEscolares($escuela);
        //$imp_dos = $asignacionesc->asigparam_importe;
        $imp_asignacion = $imp_uno;
        $this->model->LiquidarAsignacionesOB($asignaciontipo,$impdesde,$imphasta,$imp_asignacion,$periodoid);
      }
      //---- Ayuda Escolar Escolar con Discapacidad
      $asignaciontipo = 257;
      //$escuela = 212;
      $escdiscparam = $this->model->ObtenerAsignacionesParametros($asignaciontipo);
      foreach($escdiscparam as $row){
        $impdesde = $row->asigparam_desde;
        $imphasta = $row->asigparam_hasta;
        $imp_uno = $row->asigparam_importe;
        //$asignacionesc = $this->model->ObtenerAsignacionesEscolares($escuela);
        //$imp_dos = $asignacionesc->asigparam_importe;
        $imp_asignacion = $imp_uno;
        $this->model->LiquidarAsignacionesOB($asignaciontipo,$impdesde,$imphasta,$imp_asignacion,$periodoid);
      }

      foreach($this->model->AyudaEscolarOBLiqListado($periodoid) as $row){
        //----listado de beneficiarios a liquidar---

        $empndoc = $row->empleado;
        $benndoc = $row->beneficiario;
        $liqcodigos = $this->model->AyudaEscolarXCodigoObtener($empndoc,$benndoc,$periodoid);

        foreach ($liqcodigos as $liqcodigo) {
          //$this->model->LiquidarAsignacionesOBLote($empndoc,$benndoc,$periodoid);
          $liqcodigo->empndoc = $empndoc;
          $liqcodigo->benndoc = $benndoc;
          $liqcodigo->periodoid = $periodoid;
          $this->model->LiquidarAyudaEscolarOBLote($liqcodigo);
        }

        /*if($mes_actual == 1){
          $cargasfamiliares = $this->model->LiquidarAsignacionesOBLoteDoble($empndoc,$benndoc,$periodoid);
        }*/
        $this->model->HaberesRemunerativosObtener_AE($empndoc, $benndoc, $periodoid);
  			$this->model->AsignacionesFamiliaresObtener_AE($empndoc, $benndoc, $periodoid);
  			$this->model->HaberesNoRemunerativosObtener_AE($empndoc, $benndoc, $periodoid);
  			$this->model->DescuentosObtener_AE($empndoc, $benndoc, $periodoid);
        $this->model->SueldoNetoObtener_AE($empndoc, $benndoc, $periodoid);
        //$this->model->ReLiquidarOB($empndoc, $benndoc, $periodoid);
      }

      header("Location: ../asignaciones/?c=asignacion&a=AyudaEscolarOBLiquidaciones");
    }
/////////////-----------CODIGOS VIEJOSSS---------------



    public function BeneficiariosTitulares(){
      require_once 'view/beneficiariostitulares.php';
    }

    public function OtrosBeneficiariosHistorico(){
      require_once 'view/otrosbeneficiarios-historico.php';
    }
    public function AsignacionesPaseALiquidaciones(){

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
      $hrrem = new Asignacion();

      if(isset($_POST['btnhremunerativosimportar'])){
        // validate to check uploaded file is a valid csv file
        $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
        if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$file_mimes)){
          if(is_uploaded_file($_FILES['file']['tmp_name'])){
            $csv_file = fopen($_FILES['file']['tmp_name'], 'r');
            //fgetcsv($csv_file);
            // get data records from csv file
            $periodoactual = $this->model->PeriodoActualObtener();
            $periodoid = $periodoactual->periodo_id;
            $hrremunc = $this->model->HaberesRemExistentesObtener($periodoid);
            $liqcoddatos = $this->model->LiquidacionCodigoObtener(485);

            while(($datos = fgetcsv($csv_file, 1000, ";")) !== FALSE){
              // Check if employee already exists with same email
              //$concepto = $datos[8];

			        // if employee already exist then update details otherwise insert new record
              //if($hrremunc->hrremunc == 0) {
                //--- No existen los haberes remunerativos
                $hrrem->Liqtipoid = 1;
                $hrrem->Empnrodocto = $datos[2];
                $hrrem->Liqnrodocto = $datos[2];
                $hrrem->Legnrodocto = $datos[0];
                $hrrem->Titular = 1;
                $hrrem->Liqcodid = 485;
                $hrrem->Liqcoddesc = $liqcoddatos->liqcod_descripcion;
                $hrrem->Liqcantidad = 0;
                $hrrem->Liqcodtipoid = 6;
                /*
                $sac_original = (string)$datos[4];
                $sac_original = (string)$sac_original;
                $sac_importe = str_replace(',', '.', $sac_original);
                */
                $importe_original = (string)$datos[5];
                $importe_original = (string)$importe_original;
                $hremunerativo_importe = str_replace(',', '.', $importe_original);
                //$hrrem->Liqimporte = $hremunerativo_importe - $sac_importe;
                $hrrem->Liqimporte = $hremunerativo_importe;

                $hrrem->Ccostos = $datos[3];
                //$ccostos_num = preg_replace("[^0-9]", "", $ccostos);
                /*$ccostos_num = filter_var($ccostos, FILTER_SANITIZE_NUMBER_INT);
                $imputaciondatos = $this->model->ImputacionObtener($ccostos_num);*/
                /*
                $string = 'Sarah has 4 dolls and 6 bunnies.';
                $int = (int) filter_var($string, FILTER_SANITIZE_NUMBER_INT);
                echo("The extracted numbers are: $int \n");
                */
                /*if($imputaciondatos->imputacion_id != 0){

                }else{
                  $imputaciondatos->imputacion_id = $ccostos_num;
                }*/
                //$hrrem->Ccostos = $imputaciondatos->imputacion_id;

                $hrrem->Periodoid = $periodoid;
                $hrrem->Liqobs = "";
                $hrrem->Estado = 1;

                if(is_numeric($hrrem->Legnrodocto)){
                  //es numerico se inserta
                  $this->model->HaberesRemunerativosGuardarExe($hrrem);
                }//no es numerico se descarta
              //}//---existen los haberes remunerativos
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
      header("Location: ../asignaciones/?c=asignacion&a=AsignacionesOBLiquidaciones");
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
        header("Location: ../asignaciones/?c=asignacion&a=BusquedaOBReajuste&id=$asig->NDocConsultado");

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
    public function AsignacionesOBExportarCSV(){
      require_once 'includes/csv/asignacionesob-listado.php';
    }
    public function AyudaEscolarOBExportarCSV(){
      require_once 'includes/csv/ayudaescolarob-listado.php';
    }
    public function AsignacionesOBExportarPDF(){
      require_once 'includes/pdf/asignacionesob-listado.php';
    }
    public function AyudaEscolarOBExportarPDF(){
      require_once 'includes/pdf/ayudaescolarob-listado.php';
    }
}
