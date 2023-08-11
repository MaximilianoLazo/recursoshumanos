<?php
error_reporting(0);
require_once 'model/importacion.php';
date_default_timezone_set("America/Buenos_Aires");
session_start();
if(!isset($_SESSION["usuario_id"])){
  header("../legajos/login/index.php");
}

class ImportacionController{

    private $model;

    public function __CONSTRUCT(){
        $this->model = new Importacion();
    }
    public function Index(){
      require_once 'view/personal.php';
    }

    public function ProvinciasObtener(){
      require_once 'includes/php/obtener_provincias.php';
    }
    public function DepartamentosObtener(){
      require_once 'includes/php/obtener_departamentos.php';
    }
    public function LocalidadesObtener(){
      require_once 'includes/php/obtener_localidades.php';
    }
    public function Personal(){
      require_once 'view/personal.php';
    }
    $('#EmpleadoEditarDatosPersonales').on('shown.bs.modal', function (event){
      //$('#EmpleadoEditarDatosPersonales').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Botón que activó el modal
        var titulo = button.data('titulo') // Extraer la información de atributos de datos
        var empid = button.data('empid') // Extraer la información de atributos de datos
        var empnrodocto = button.data('empnrodocto')
        var empnrocuil = button.data('empnrocuil')
        var empnrolegajo = button.data('empnrolegajo')
        var empapellido = button.data('empapellido')
        var empnombres = button.data('empnombres')
        var empsexo = button.data('empsexo')
        var empestadocivil = button.data('empestadocivil')
        var empfecnac = button.data('empfecnac')
        var empfecing = button.data('empfecing')
        var empmovimiento = button.data('empmovimiento')
        var empdiscapa = button.data('empdisc')
      
      
        var modal = $(this)
        modal.find('.modal-header .modal-title').text(titulo)
        modal.find('.modal-body #hddempide').val(empid)
        modal.find('.modal-body #hddempnrodocto').val(empnrodocto)
        modal.find('.modal-body #hddempmovimientoe').val(empmovimiento)
        modal.find('.modal-body #txtnrodoctoe').val(empnrodocto)
        modal.find('.modal-body #txtempnrocuile').val(empnrocuil)
        modal.find('.modal-body #txtempnrolegajoe').val(empnrolegajo)
        modal.find('.modal-body #txtempapellidoe').val(empapellido)
        modal.find('.modal-body #txtempnombrese').val(empnombres)
        modal.find('.modal-body #cboempsexoe').val(empsexo)
        modal.find('.modal-body #cboempestadocivile').val(empestadocivil)
        modal.find('.modal-body #txtempfecnace').val(empfecnac)
        modal.find('.modal-body #txtempfecinge').val(empfecing)
             
        if(empmovimiento == 2){
          $('.modal-body #txtnrodoctoe').prop('disabled', true);
          $(".modal-body #txtempnrocuile").focus();
          //$('#txtempnrocuile').trigger('focus');
        }
        if(empdiscapa == 1){$('.modal-body #jubdisc').attr('checked',true);};
        $('.alert').hide();//Oculto alert
      
      })


    public function CJMDGPersonalImportar(){
      $cjimp = new Importacion();

      if(isset($_POST['btnbancobersadescimportar'])){
        // validate to check uploaded file is a valid csv file

        $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
        if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$file_mimes)){
          //
          if(is_uploaded_file($_FILES['file']['tmp_name'])){
              $txt_file = fopen($_FILES['file']['tmp_name'], 'r');

              //Output a line of the file until the end is reached
              while(!feof($txt_file)){

                $linea = fgets($txt_file);

                // Se evalúa a true ya que $var está vacia
                if (!empty($linea)) {
                  //echo '$var es o bien 0, vacía, o no se encuentra definida en absoluto';
                  $cjimp->RegistroCompleto = str_split($linea, 250);

                  //echo "--------------------"."<br/>";
                  $contador = 0;
                  foreach ($cjimp->RegistroCompleto as $value) {
                    $contador = $contador + 1;
                    # code...
                    $cjimp->contador=$contador;
                    echo "ID: ".$contador."<br>";

                    echo $value."<br>";

                    $espuno = " ";
                    $espdos = "*";
                    
                    $value_dos = str_replace($espuno, $espdos, $value);

                    echo "---------------------------------------"."<br>";
                    echo $value_dos."<br>";

                    $cjimp->APNOM = substr($value, 0, 30);
                    $apellidonombres = explode(" ", $cjimp->APNOM);
                    $cjimp->Apellido = $apellidonombres[0]; // porción1
                    $cjimp->Nombres = $apellidonombres[1]." ".$apellidonombres[2]." ".$apellidonombres[3]." ".$apellidonombres[4]; // porción2
                    //---Apellido-------
                    echo "APELLIDO: ".$cjimp->Apellido."<br>";
                    //----Nombres-------
                    echo "NOMBRES: ".$cjimp->Nombres."<br>";
                    //----Direccion
                    $cjimp->Direccion = substr($value, 30, 29);
                    echo "DIRECCION: ".$cjimp->Direccion."<br>";
                    //--- localidad
                    $cjimp->Localidad = substr($value, 60, 12);
                    echo "LOCALIDAD: ".$cjimp->Localidad."<br>";
                    //--- provincia
                    $cjimp->Provincia = substr($value, 72, 10);
                    echo "PROVINCIA: ".$cjimp->Provincia."<br>";
                    //---tipo docto
                    $cjimp->TipoDocto = substr($value, 82, 3);

                    if ($cjimp->TipoDocto=="DNI"){
                      $cjimp->Tipo=1;
                    }elseif($cjimp->TipoDocto=="LC "){
                      $cjimp->Tipo=3;
                    }elseif($cjimp->TipoDocto=="LE "){
                      $cjimp->Tipo=2;
                    }else{
                      $cjimp->Tipo=0;
                    }
                    echo "TIPO DOCTO: ".$cjimp->Tipo . "-".$cjimp->TipoDocto."<br>";
                    //---numero docto
                    $cjimp->NumDocto = substr($value, 85, 8);
                    echo "NUMERO DOCTO: ".$cjimp->NumDocto."<br>";
                    //---numero de legajo
                    $cjimp->NumLegajo = substr($value, 244, 6);
                    echo "NRO LEGAJO: ".$cjimp->NumLegajo."<br>";
                    //---Fecha de Ingreso
                    $cjimp->FecIngreso = substr($value, 97, 6);
                 
                    $year = substr($cjimp->FecIngreso, 0, 2);
                    $mes = substr($cjimp->FecIngreso, 2, 2);
                    $dia = substr($cjimp->FecIngreso, 4, 2);

                    if($year < 24){
                      $year_cuatro = "20".$year;
                    }else{
                      $year_cuatro = "19".$year;
                    }

                    $fecha_ingreso_ymd = $year_cuatro."-".$mes."-".$dia;
                    echo "FEC INGRESO: ".$fecha_ingreso_ymd."<br>";

                    //---categoria en sistema
                    $cjimp->CategoriaBen_dos = substr($value, 103, 2);
                    echo "CAT JUB/PEN/AC: ".$cjimp->CategoriaBen_dos."<br>";
                    //----sub categoria-----
                    $cjimp->CategoriaSup = substr($value, 213, 1);
                    echo "SUB CAT JUB/PEN/AC: ".$cjimp->CategoriaSup."<br>";

                    if($cjimp->CategoriaBen_dos == 2){
                      //echo "DISCAPACIDAD2022"."<br>";
                    }
                    //---Discapacidad
                    //$cjimp->Discapacidad = substr($value, 106, 1);
                    echo "Disc: "."No se usa?"."<br>";
                    //-------Estado Civil -----
                    $cjimp->civil = substr($value, 107, 1);
                    echo "EST CIVIL: ".$cjimp->civil."<br>";
                    //----Fecha de Egreso-------
                    $cjimp->fecegr = substr($value, 108, 6);

                    $year_e = substr($cjimp->fecegr, 0, 2);
                    $mes_e = substr($cjimp->fecegr, 2, 2);
                    $dia_e = substr($cjimp->fecegr, 4, 2);

                    if($year < 24){
                      $year_cuatro_e = "20".$year_e;
                    }else{
                      $year_cuatro_e = "19".$year_e;
        
                    }

                    if($mes_e == "  "){
                      $fecha_egreso_ymd = "0000-00-00";
                    }else{
                      $fecha_egreso_ymd = $year_cuatro_e."-".$mes_e."-".$dia_e;
                    }
                    
                    echo "FEC EGRESO: ".$fecha_egreso_ymd."<br>";

                    //------Sexo-------------
                    $cjimp->sexo = substr($value, 114, 1);
                    echo "Sexo: ".$cjimp->sexo."<br>";
                    //-----Fecha de Nacimiento -----
                    $cjimp->fecnac = substr($value, 115, 6);
                    echo "Fecha Nacimiento: ".$cjimp->fecnac."<br>";
                    //----CUIL
                    echo "CUIL: "."CUIL no encontrado..."."<br>";
                    //----Cta BERSA
                    echo "CTA BERSA: "."CTA BERSA no encontrada..."."<br>";
                    //----obra social ------
                    $cjimp->os = substr($value, 121, 6);
                    echo "OBRA SOCIAL: ".$cjimp->os."<br>";
                    //----Categoria Escalafon (Categoria de Jub)
                    $cjimp->cat = substr($value, 199, 14);
                    echo "Escalafon: ".$cjimp->cat."<br>";
                    //============Apoderado=============
                    //----apoderado tipo de documento
                    echo "======APODERADO=========="."<br>";
                    $cjimp->tipodocap = substr($value, 187, 3);
                    echo "APODERADO TIPO DOCTO: ".$cjimp->tipodocap."<br>";
                    //---apoderado numero documento----
                    $cjimp->nrodocap = substr($value, 190, 8);
                    echo "APODERADO NRODOCTO: ".$cjimp->nrodocap."<br>";
                    //---apoderado apellido y nombres-------
                    $cjimp->apod = substr($value, 127, 30);
            
                    $apellidonombresap = explode(" ", $cjimp->apod);
                    $cjimp->ApellidoAp = $apellidonombresap[0]; // porción1
                    $cjimp->NombresAp = $apellidonombresap[1]." ".$apellidonombresap[2]." ".$apellidonombresap[3]." ".$apellidonombresap[4]; // porción2
                    //-----apoderado apellido
                    echo "APODERADO NOMBRES: ".$cjimp->NombresAp."<br>";
                    //----apoderado nombres
                    echo "APODERADO APELLIDO: ".$cjimp->ApellidoAp."<br>";
                    //----apoderado direccion
                    $cjimp->dir = substr($value, 157, 30);
                    echo "APODERADO DIRECCION: ".$cjimp->dir."<br>";


                    
                    //*******************************************************
                    //echo "ver" . $cjimp->NumDocto;
                    $cui11=0;
                    if($cjimp->sexo=="F"){$cui1=2;$cui2=7;}else{$cui1=2;$cui2=0;}
                    $cui111=$cui1*5;
                    $cui122=$cui2*4;
                    
                    //if(substr($cjimp->NumDocto, 0, 1)==""){$cui3=0;}else{$cui3=substr($cjimp->NumDocto, 0, 1)*3;}
                    //$cui4=substr($cjimp->NumDocto, 1, 1)*2;
                    //$cui5=substr($cjimp->NumDocto, 2, 1)*7;
                    //$cui6=substr($cjimp->NumDocto, 3, 1)*6;
                    //$cui7=substr($cjimp->NumDocto, 4, 1)*5;
                    //$cui8=substr($cjimp->NumDocto, 5, 1)*4;
                    //$cui9=substr($cjimp->NumDocto, 6, 1)*3;
                    //$cui10=substr($cjimp->NumDocto, 7, 1)*2;
                    //$cui11=($cui111+$cui122+$cui3+$cui4+$cui5+$cui6+$cui7+$cui8+$cui9+$cui10)/11;
                    $cuil11 = 0;
                    $cuil12 = 0;
                    $cui3 = 0;
                    //$cui12= explode(".", $cui11);
                    $cui12= $cui11;
                    if($cui12[1]==0){$cui13=0;}else{$cui13=11-(substr($cui12[1],0,1)+1);}
                    //$cui13=$cui12[0]-$cui12[1];

                    if($cui3==0){$cuifinal=$cui1.$cui2."0".substr($cjimp->NumDocto, 1, 8).$cui13;}
                    else{$cuifinal=$cui1.$cui2.$cjimp->NumDocto.$cui13;}
                    //echo "CUIL: " . $cuifinal."<br>";
                    $cjimp->cuil=$cuifinal;
                    //*******************************************************
                    

                   
                    echo "<br><br>";

                    //$res=$this->model->CJMDGPersonalImportar($cjimp);
                  }

                }
              }
              fclose($txt_file);
              $import_status = '?import_status=success';
          }else{
            $import_status = '?import_status=error';
          }
        }else{
          $import_status = '?import_status=invalid_file';
        }
      }
      //header("Location: ../bancos/?c=banco&a=BancoBersaCreditos");
    }
    public function CJMDGFamiliarImportar(){
      $cjimp = new Importacion();

      if(isset($_POST['btnbancobersadescimportar'])){
        // validate to check uploaded file is a valid csv file

        $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
        if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$file_mimes)){
          //
          if(is_uploaded_file($_FILES['file']['tmp_name'])){
              $txt_file = fopen($_FILES['file']['tmp_name'], 'r');

              //Output a line of the file until the end is reached
              while(!feof($txt_file)){

                $linea = fgets($txt_file);

                // Se evalúa a true ya que $var está vacia
                if (!empty($linea)) {
                  //echo '$var es o bien 0, vacía, o no se encuentra definida en absoluto';
                  $cjimp->RegistroCompleto = str_split($linea, 130);

                  //echo "--------------------"."<br/>";
                  $contador = 0;
                  foreach ($cjimp->RegistroCompleto as $value) {
                    $contador = $contador + 1;
                    # code...
                    $cjimp->contador=$contador;
                    echo "ID: ".$contador."<br>";

                    echo $value."<br>";

                    $espuno = " ";
                    $espdos = "*";
                    
                    $value_dos = str_replace($espuno, $espdos, $value);

                    echo "---------------------------------------"."<br>";
                    echo $value_dos."<br>";

                    $cjimp->APNOM = substr($value, 0, 30);
                    $apellidonombres = explode(" ", $cjimp->APNOM);
                    $cjimp->Apellido = $apellidonombres[0]; // porción1
                    $cjimp->Nombres = $apellidonombres[1]." ".$apellidonombres[2]." ".$apellidonombres[3]." ".$apellidonombres[4]; // porción2
                    //---Apellido-------
                    echo "APELLIDO: ".$cjimp->Apellido."<br>";
                    //----Nombres-------
                    echo "NOMBRES: ".$cjimp->Nombres."<br>";
                    //----Direccion--------
                    $cjimp->Direccion = substr($value, 30, 30);
                    echo "DIRECCION: ".$cjimp->Direccion."<br>";
                    //----Localidad--------
                    $cjimp->Localiad = substr($value, 60, 12);
                    echo "LOCALIDAD: ".$cjimp->Localiad."<br>";
                    //----Entre Rios--------
                    $cjimp->Provincia = substr($value, 72, 10);
                    echo "PROVINCIA: ".$cjimp->Provincia."<br>";
                    //----Tipo de Documento--------
                    $cjimp->Tipodocto = substr($value, 82, 3);
                    echo "TIPO DOCTO: ".$cjimp->Tipodocto."<br>";
                    //----Numero de Documento--------
                    $cjimp->Numdocto = substr($value, 85, 8);
                    echo "NUMERO DOCTO: ".$cjimp->Numdocto."<br>";
                    //----Estado Civil--------
                    $cjimp->EstadoCivil = substr($value, 93, 1);
                    echo "ESTADO CIVIL: ".$cjimp->EstadoCivil."<br>";
                    //----Sexo--------
                    $cjimp->Sexo = substr($value, 94, 1);
                    echo "SEXO: ".$cjimp->Sexo."<br>";
                    //----TIPO DE FAMILIAR--------
                    $cjimp->Fecnac = substr($value, 95, 6);
                    echo "FEC DE NACIMIENTO: ".$cjimp->Fecnac."<br>";
                    //----TIPO DE FAMILIAR--------
                    $cjimp->Tipofamiliar = substr($value, 101, 10);
                    echo "TIPO DE FAMILIAR: ".$cjimp->Tipofamiliar."<br>";
                    
                    echo "<br><br>";

                    //$res=$this->model->CJMDGPersonalImportar($cjimp);
                  }

                }
              }
              fclose($txt_file);
              $import_status = '?import_status=success';
          }else{
            $import_status = '?import_status=error';
          }
        }else{
          $import_status = '?import_status=invalid_file';
        }
      }
      //header("Location: ../bancos/?c=banco&a=BancoBersaCreditos");
    }

    public function CJMDGBERSAImportar(){
      $cjimp = new Importacion();
      $contador = 0;
      $periodo=$this->model->PeriodoObtener();

      if(isset($_POST['btnbancobersaimportar'])){
        // validate to check uploaded file is a valid csv file

        $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
        if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$file_mimes)){
          //
          if(is_uploaded_file($_FILES['file']['tmp_name'])){
              $txt_file = fopen($_FILES['file']['tmp_name'], 'r');

              //Output a line of the file until the end is reached
              while(!feof($txt_file)){

                $linea = fgets($txt_file);

                // Se evalúa a true ya que $var está vacia
                if (!empty($linea)) {
                  //echo '$var es o bien 0, vacía, o no se encuentra definida en absoluto';
                  $cjimp->RegistroCompleto = str_split($linea, 250);

                  //echo "--------------------"."<br/>";

                  foreach ($cjimp->RegistroCompleto as $value) {

                    $contador = $contador + 1;
                    # code...
                    $cjimp->contador=$contador;
                    echo "ID: ".$contador."<br>";

                    echo $value."<br>";
                    $cjimp->dni = substr($value,5, 8);
                    //$dni = explode(" ", $cjimp->dni);
                    echo "DNI: ".$cjimp->dni."<br>";

                    $datos_jub = $this->model->ObtenerDatosJub($cjimp->dni);
                    foreach ($datos_jub as $value1) {
                      $ape=$value1->cjmdg_personal_apellido;

                      $cjimp->nroleg2=$value1->cjmdg_personal_nroleg2;
                      $cjimp->nroleg=$value1->cjmdg_personal_nroleg;

                      echo $ape."<br>";
                    }
                    $cjimp->cuil = substr($value,3, 11);
                    //$dni = explode(" ", $cjimp->dni);
                    echo "CUIL: ".$cjimp->cuil."<br>";

                    $cjimp->cuota_mes = substr($value,21, 2);
                    echo "CUOTA MES: ".$cjimp->cuota_mes."<br>";

                    $cjimp->cuota_total = substr($value,24, 2);
                    //$dni = explode(" ", $cjimp->dni);
                    echo "TOTAL CUOTAS: ".$cjimp->cuota_total."<br>";

                    //*******************************************************
                    echo "<br>" ;

                    echo "<br><br>";

                    $res=$this->model->CJMDGBERSAImportar($cjimp,$periodo->periodo_id);
                  }

                }
              }
              fclose($txt_file);
              $import_status = '?import_status=success';
          }else{
            $import_status = '?import_status=error';
          }
        }else{
          $import_status = '?import_status=invalid_file';
        }
      }
      //header("Location: ../bancos/?c=banco&a=BancoBersaCreditos");
    }

    //////////////////////////////////////////////////////////////////////////////
    public function BancoBersaCreditos(){
      /*$emp = new Empleado();

      if(isset($_REQUEST['id'])){
        $emp = $this->model->Obtener($_REQUEST['id']);
      }*/
      $periododatos = $this->model->PeriodoActualObtener();
      $bersacreditos = $this->model->BersaCreditosListar($periododatos->periodo_id);
      require_once 'view/banco-bersa-creditos.php';
    }

    public function BancoBersaCredImportar(){
      $bcoimp = new Banco();
      $periododatos = $this->model->PeriodoActualObtener();
      $bcoimp->Bcoperiodo = $periododatos->periodo_id;
      if(isset($_POST['btnbancobersadescimportar'])){
        // validate to check uploaded file is a valid csv file
        //$fictandaimportar->Mtandaid = $_REQUEST['hddmtandaide'];
        $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
        if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$file_mimes)){
          //
          if(is_uploaded_file($_FILES['file']['tmp_name'])){
              $txt_file = fopen($_FILES['file']['tmp_name'], 'r');

              //Output a line of the file until the end is reached
              while(!feof($txt_file)){
                //echo fgets($txt_file). "<br />";
                $linea = fgets($txt_file);
                //echo $linea."</br>";
                //echo substr('abcdef', 0, 1);// bcdef

                // Se evalúa a true ya que $var está vacia
                if (!empty($linea)) {
                  //echo '$var es o bien 0, vacía, o no se encuentra definida en absoluto';
                  $bcoimp->Bconrodocto = substr($linea, 5, 8);
                  //echo "DNI: ".$bcoimp->Bconrodocto."<br/>";
                  $empleadodatos = $this->model->ObtenerEmpleado($bcoimp->Bconrodocto);
                  if($empleadodatos->legempleado_numerol > 0){
                    $bcoimp->Bcolegnumerol = $empleadodatos->legempleado_numerol;
                  }else{
                    $bcoimp->Bcolegnumerol = 0;
                  }
                  $bcoimp->Bconrocuil = substr($linea, 3, 11);
                  //echo "CUIL: ".$bcoimp->Bconrocuil."<br/>";
                  $importe_entero = substr($linea, 14, 5);
                  $importe_decimal = substr($linea, 19, 2);
                  $importe = $importe_entero.".".$importe_decimal;
                  $bcoimp->Bcoimporte = number_format($importe, 2, '.', '');
                  //echo "IMPORTE: ".$bcoimp->Bcoimporte."<br/>";
                  $bcoimp->Bcocuotas = substr($linea, 21, 5);
                  //echo "CUOTAS: ".$bcoimp->Bcocuotas."<br/>";
                  $bcoimp->Bcoarchivonom = $_FILES['file']['name'];
                  //echo "ARCHIVO NOMBRE: ".$bcoimp->Bcoarchivonom."</BR>";
                  $bcoimp->Bcolineacompleta = $linea;
                  //echo "LINIA COMPLETA: ".$linea."<BR/>";
                  //echo "--------------------"."<br/>";

                  $this->model->BancoBersaCredImportarExe($bcoimp);
                }
              }
              fclose($txt_file);
              $import_status = '?import_status=success';
          }else{
            $import_status = '?import_status=error';
          }
        }else{
          $import_status = '?import_status=invalid_file';
        }
      }
      header("Location: ../bancos/?c=banco&a=BancoBersaCreditos");
    }
    public function BersaCreditosPaseALiq(){
      $bcoliq = new Banco();
      //------Resetear todos los valores anteriores -----
      $this->model->WaldbottBersaCreditosReset();
      //-----Listar creditos bersa ------r--------
      $periododatos = $this->model->PeriodoActualObtener();
      $bersacreditos = $this->model->BersaCreditosListar($periododatos->periodo_id);
      foreach($bersacreditos as $row){
        $bcoliq->Bcolegajo = $row->legempleado_numerol;
        $bcocreditoimporte_format = number_format($row->bco_credito_importe, 2, ',', '');
        $bcoliq->BcoImporte = $bcocreditoimporte_format;
        if($bcoliq->Bcolegajo > 0){
          $this->model->BersaCreditosPaseALiqExe($bcoliq);
        }
      }
      //header("Location: index.php");
      header("Location: ../bancos/?c=banco&a=BancoBersaCreditos");
    }
}
