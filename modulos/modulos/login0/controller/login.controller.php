<?php
require_once 'model/login.php';

class LoginController{

    private $model;

    public function __CONSTRUCT(){
        $this->model = new Login();
    }

    public function Index(){
        //require_once 'view/header.php';
        require_once 'view/login.php';
        //require_once 'view/footer.php';
    }
    public function ListadoDeUsuarios(){
        require_once 'view/usuario.php';
    }
    public function RecuperarClave(){
        require_once 'view/usuario-recupera-clave.php';
    }
    public function Crud(){
        $emp = new Login();

        if(isset($_REQUEST['id'])){
            $emp = $this->model->Obtener($_REQUEST['id']);
        }

        //require_once 'view/header.php';
        //require_once 'view/empleado-editar.php';
        //require_once 'view/footer.php';
    }
    public function UsuarioCambiaClave(){

      if(empty($_REQUEST['id']) AND empty($_REQUEST['token'])){
        //$emp = $this->model->Obtener($_REQUEST['id']);
        //echo "estoy ACA";
        exit;
      }
      //
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

    //////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////
    ///////////////////////////////////////////////
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
