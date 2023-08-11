<?php
require_once 'model/login.php';
session_start();
if(!isset($_SESSION["usuario_id"])){
  header("../legajos/login/index.php");
}
class LoginController{

    private $model;

    public function __CONSTRUCT(){
        $this->model = new Login();
    }

    public function Index(){

      $periodo_actual=new login;
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
      require_once 'view/login.php';
    }
    public function ListadoDeUsuarios(){
      require_once 'view/usuario.php';
    }
    public function UsuariosListado(){
      require_once 'view/usuario.php';
    }
    public function RecuperarClave(){
      require_once 'view/usuario-recupera-clave.php';
    }
    public function UsuarioCambiaClave(){

      if(empty($_REQUEST['id']) AND empty($_REQUEST['token'])){
        exit;
      }

      $user_id = $_REQUEST['id'];
      $token = $_REQUEST['token'];

      if(!$this->model->verificaTokenPass($user_id, $token)){
        echo 'No se pudo verificar los Datos';
        exit;
      }

      require_once 'view/usuario-cambia-clave.php';

    }
    public function UsuarioRecuperarClave(){
        require_once 'view/usuario-recupera-clave.php';
    }
    public function UsuarioClaveGuardar(){

      $user_id = $_POST['user_id'];
      $token = $_POST['token'];
      $password = $_POST['password'];
      $con_password = $_POST['con_password'];


    	if($this->model->validaPassword($password, $con_password)){

    		$pass_hash = $this->model->hashPassword($password);

    		if($this->model->cambiaPassword($pass_hash, $user_id, $token)){
    			echo "Contrase&ntilde;a Modificada <br> <a href='index.php' >Iniciar Sesion</a>";
    		}else{
    			echo "Error al modificar contrase&ntilde;a";
    		}

    	}else{
    		echo 'Las contraseñas no coinciden';
    	}

    }

}
