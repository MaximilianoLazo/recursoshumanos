<?php

  set_time_limit(1800);

  require_once '../../database/Conexion.php';
  require_once 'model/marcacion.php';

  $fichadolotel = new Marcacion();

  $nrodocto = $_GET["id"];
  //$fechainicial = $_POST["FechaI"];
  //$fechafinal = $_POST["FechaF"];

  //------MPDF--------------
  include("../../src/plugins/mpdf/mpdf.php");
  $mpdf = new mPDF('s', 'A4');

  $periodoultimoc = $fichadolotel->PeriodoUCerrado();

  /*$periodonombre = $periodoultimoc->periodo_nombre;*/
  /*$fechainicial = $periodoultimoc->periodo_hsext_jor_i;
  $fechafinal = $periodoultimoc->periodo_hsext_jor_f;*/
  $fechainicial = "2020-07-01";
  $fechafinal = "2020-07-14";


  date_default_timezone_set("America/Buenos_Aires");
  //setlocale(LC_ALL,"es_ES");
  setlocale(LC_ALL, 'es_RA.UTF8');
  //setlocale(LC_TIME, "es_RA.UTF-8");
  setlocale(LC_TIME, 'es_RA.utf-8','spanish');
  //setlocale('es_ES.UTF-8'); // I'm french !

  $fecha_actual = new DateTime();
  $fechaactual = $fecha_actual->format('d/m/Y H:i');

  $date_start = new DateTime($fechainicial);
  $date_end = new DateTime("$fechafinal 23:59:59");

  $interval = '+1 days';
  $date_interval = DateInterval::createFromDateString($interval);
  $periodofechas = new DatePeriod($date_start, $date_interval, $date_end);


  $empleadodatos = $fichadolotel->EmpleadoObtener($nrodocto);
  $legajotipo = $empleadodatos->legtipo_id;
  //----- Obtener datos de situacion de Revista -----
  $empleadocontratodatos = $fichadolotel->ObtenerEmpleadoContrato($nrodocto, $legajotipo);
  if(empty($empleadocontratodatos)){
    //---No existe o esta vacia
    $empleadocategoria = "-";
    $empleadolugardetrabajo = "-";
  }else{
    //-- Existe un contrato
    $trabajoid = $empleadocontratodatos->trabajo_id;
    $lugardetrabajo = $fichadolotel->ObtenerLugarDeTrabajoXId($trabajoid);
    $empleadolugardetrabajo = $lugardetrabajo->trabajo_nombre;
    if($legajotipo == 3){
      $empleadocategoria = $empleadocontratodatos->legppermanente_categoria;
    }else{
      //$legtipoid = $empleadocontratodatos->legtipo_id;
      $legajotipo = $fichadolotel->ObtenerLegajoTipoId($legajotipo);
      $empleadocategoria = $legajotipo->legtipo_nombre;
    }
  }
  $empleadofichadas = $fichadolotel->ObterEmpleadoFichadas($nrodocto);
  $empleadofichadashistorico = $fichadolotel->ObtenerFichadasHistoricoDos($nrodocto, $fechainicial, $fechafinal);
  $licenciasempleadodia = $fichadolotel->ObtenerLicenciasPeriodo($nrodocto, $fechainicial, $fechafinal);
  $html = '
  <table width="100%">
    <tr>
      <td width="7%" align="left" rowspan="5"><img src="../../src/images/logo-personal1.png" width="45px" height="60px"/></td>
      <td height="10px"></td>
      <td></td>
    </tr>
    <tr>
      <td class="headerdesci">Departamento Personal</td>
      <td class="headerdescd">personal@gualeguay.gob.ar</td>
    </tr>
    <tr>
      <td class="headerdesci">Secretaría de Hacienda y Producción</td>
      <td class="headerdescd">03444 423468 • 3 de febrero 80</td>
    </tr>
    <tr>
      <td class="headerdescinegrita">Municipalidad de Gualeguay</td>
      <td class="headerdescd">2840 • Gualeguay • Entre Ríos • Argentina</td>
    </tr>
    <tr>
      <td height="10px"></td>
      <td></td>
    </tr>
  </table>';

  $html.= '
  <div class="titulo">'.$empleadodatos->legempleado_apellido.', '.$empleadodatos->legempleado_nombres.'</div>
  <table width="100%" class="tablaempleado">
    <thead>
      <tr>
        <th width="10%" class="tablaempleado-titulo">DNI</th>

        <th class="tablaempleado-titulo">CAT</th>
        <th class="tablaempleado-titulo">LUGAR DE TRABAJO</th>
        <th width="25%" class="tablaempleado-titulo">PERIODO</th>
        <th width="14%" class="tablaempleado-titulo">FECHA IMPRESION</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="tablaempleado-cuerpo">'.$nrodocto.'</td>
        <td class="tablaempleado-cuerpo">'.$empleadocategoria.'</td>
        <td class="tablaempleado-cuerpo">'.$empleadolugardetrabajo.'</td>
        <td class="tablaempleado-cuerpo">'.$periodonombre.' '.$date_start->format('d/m/Y').' al '.$date_end->format('d/m/Y').'</td>
        <td class="tablaempleado-cuerpo">'.$fechaactual.'</td>
      </tr>
    </tbody>
  </table>
  <div class="titulo">Cronograma de Trabajo</div>
  <table width="100%" class="tablacronograma">
    <thead>
      <tr>
        <th width="14%" class="tablacronograma-titulo">LUNES</th>
        <th width="14%" class="tablacronograma-titulo">MARTES</th>
        <th width="15%" class="tablacronograma-titulo">MIERCOLES</th>
        <th width="14%" class="tablacronograma-titulo">JUEVES</th>
        <th width="15%" class="tablacronograma-titulo">VIERNES</th>
        <th width="14%" class="tablacronograma-titulo">SABADO</th>
        <th width="14%" class="tablacronograma-titulo">DOMINGO</th>
      </tr>
    </thead>
    <tbody>';
      foreach($empleadofichadas as $row){
        if($row->legreloj_lunes == 1){
          list($hh, $mm, $ss) = explode(":", $row->legreloj_luneshe);
          $lunese = $hh.":".$mm;
          list($hh, $mm, $ss) = explode(":", $row->legreloj_luneshs);
          $luness = $hh.":".$mm;
          $lunes = "E[".$lunese."] - S[".$luness."]";
        }else{
          $lunes = "No Ficha";
        }
        if($row->legreloj_martes == 1){
          list($hh, $mm, $ss) = explode(":", $row->legreloj_marteshe);
          $martese = $hh.":".$mm;
          list($hh, $mm, $ss) = explode(":", $row->legreloj_marteshs);
          $martess = $hh.":".$mm;
          $martes = "E[".$martese."] - S[".$martess."]";
        }else{
          $martes = "No Ficha";
        }
        if($row->legreloj_miercoles == 1){
          list($hh, $mm, $ss) = explode(":", $row->legreloj_miercoleshe);
          $miercolese = $hh.":".$mm;
          list($hh, $mm, $ss) = explode(":", $row->legreloj_miercoleshs);
          $miercoless = $hh.":".$mm;
          $miercoles = "E[".$miercolese."] - S[".$miercoless."]";
        }else{
          $miercoles = "No Ficha";
        }
        if($row->legreloj_jueves == 1){
          list($hh, $mm, $ss) = explode(":", $row->legreloj_jueveshe);
          $juevese = $hh.":".$mm;
          list($hh, $mm, $ss) = explode(":", $row->legreloj_jueveshs);
          $juevess = $hh.":".$mm;
          $jueves = "E[".$juevese."] - S[".$juevess."]";
        }else{
          $jueves = "No Ficha";
        }
        if($row->legreloj_viernes == 1){
          list($hh, $mm, $ss) = explode(":", $row->legreloj_vierneshe);
          $viernese = $hh.":".$mm;
          list($hh, $mm, $ss) = explode(":", $row->legreloj_vierneshs);
          $vierness = $hh.":".$mm;
          $viernes = "E[".$viernese."] - S[".$vierness."]";
        }else{
          $viernes = "No Ficha";
        }
        if($row->legreloj_sabado == 1){
          list($hh, $mm, $ss) = explode(":", $row->legreloj_sabadohe);
          $sabadoe = $hh.":".$mm;
          list($hh, $mm, $ss) = explode(":", $row->legreloj_sabadohs);
          $sabados = $hh.":".$mm;
          $sabado = "E[".$sabadoe."] - S[".$sabados."]";
        }else{
          $sabado = "No Ficha";
        }
        if($row->legreloj_domngo == 1){
          list($hh, $mm, $ss) = explode(":", $row->legreloj_domingohe);
          $domingoe = $hh.":".$mm;
          list($hh, $mm, $ss) = explode(":", $row->legreloj_domingohs);
          $domingos = $hh.":".$mm;
          $domingo = "E[".$domingoe."] - S[".$domingos."]";
        }else{
          $domingo = "No Ficha";
        }
      $html.='
        <tr>
          <td class="tablacronograma-cuerpo">'.$lunes.'</td>
          <td class="tablacronograma-cuerpo">'.$martes.'</td>
          <td class="tablacronograma-cuerpo">'.$miercoles.'</td>
          <td class="tablacronograma-cuerpo">'.$jueves.'</td>
          <td class="tablacronograma-cuerpo">'.$viernes.'</td>
          <td class="tablacronograma-cuerpo">'.$sabado.'</td>
          <td class="tablacronograma-cuerpo">'.$domingo.'</td>
        </tr>';
      }
      $html.='
    </tbody>
  </table>
  <div class="titulo">Informe Novedades</div>
  <table width="100%" class="tablanovsinprocesar">
    <thead>
      <tr>
        <th width="14%" class="tablanovsinprocesar-titulo">FECHA</th>
        <th class="tablanovsinprocesar-titulo">HORARIOS</th>
        <th class="tablanovsinprocesar-titulo">NOVEDADES</th>
      </tr>
    </thead>
    <tbody>';
    foreach($empleadofichadashistorico as $row){
      $fechamuestra2 = (iconv('ISO-8859-2', 'UTF-8', strftime("%a %d/%m/%Y", strtotime("$row->marcacion_datetime"))));
      $fechamuestra3 = (iconv('ISO-8859-2', 'UTF-8', strftime("%Y/%m/%d", strtotime("$row->marcacion_datetime"))));
      $html.='
        <tr>
          <td class="tablanovsinprocesar-cuerpo">'.$fechamuestra2.'</td>
          <td class="tablanovsinprocesar-cuerpo">';
          $fichadasinprocesardia = $fichadolotel->ObtenerFichadasHistoricoDiaDos($nrodocto, $fechamuestra3);
          foreach($fichadasinprocesardia as $row2){
          $html.='
            <label>'.$row2->ejem33.' - </label>
          ';
          }
          $html.='
          </td>
          <td class="tablanovsinprocesar-cuerpo"></td>
        </tr>';
    }
    $html.='
    </tbody>
  </table>
  <div class="titulo">licencias</div>
  <table width="100%" class="tablanovsinprocesar">
    <thead>
      <tr>
        <th width="14%" class="tablanovsinprocesar-titulo">FECHA</th>
        <th class="tablanovsinprocesar-titulo">LICENCIAS</th>
        <th class="tablanovsinprocesar-titulo">NOVEDADES</th>
      </tr>
    </thead>
    <tbody>';
    foreach($licenciasempleadodia as $row){
      $fechamuestra2 = (iconv('ISO-8859-2', 'UTF-8', strftime("%a %d/%m/%Y", strtotime("$row->lproceso_fecha"))));
      //$fechamuestra3 = (iconv('ISO-8859-2', 'UTF-8', strftime("%Y/%m/%d", strtotime("$row->marcacion_datetime"))));
      $html.='
        <tr>
          <td class="tablanovsinprocesar-cuerpo">'.$fechamuestra2.'</td>
          <td class="tablanovsinprocesar-cuerpo">'.$row->licencia_nombre.'</td>
          <td class="tablanovsinprocesar-cuerpo"></td>
        </tr>';

          }

    $html.='
    </tbody>
  </table>
  ';
  $fooster = '<div class="fooster">Sistema de Recursos Humanos © 2019 Adhemar Caminos - Pagina {PAGENO} de {nbpg}</div>';

  $css = file_get_contents('includes/css/fichadas-periodoc.css');
  $mpdf->writeHTML($css, 1);
  $mpdf->SetHTMLFooter($fooster);
  //$mpdf->AddPage('P');
  $mpdf->AddPage('P','','','','',15,15,10,12,0,5);
  $mpdf->WriteHTML($html, 2);


//==============================================================
//==============================================================
//==============================================================

$mpdf->Output("Fichadas.pdf", 'D');
exit;
//==============================================================
//==============================================================
//==============================================================
//==============================================================
//==============================================================
?>
