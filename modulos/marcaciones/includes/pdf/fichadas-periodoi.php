<?php

  set_time_limit(1800);

  require_once '../../../../database/Conexion.php';
  require_once '../../model/marcacion.php';

  $fichadolote = new Marcacion();

  $nrodocto = $_POST["NroDni"];
  $fechainicial = $_POST["FechaI"];
  $fechafinal = $_POST["FechaF"];

  //------MPDF--------------
  include("../../../../src/plugins/mpdf/mpdf.php");
  $mpdf = new mPDF('s', 'A4');

  $periodoultimoc = $fichadolote->PeriodoUCerrado();

  /*$periodonombre = $periodoultimoc->periodo_nombre;
  $fechainicial = $periodoultimoc->periodo_hsext_jor_i;
  $fechafinal = $periodoultimoc->periodo_hsext_jor_f;*/


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


  $empleadodatos = $fichadolote->EmpleadoObtener($nrodocto);
  $legajotipo = $empleadodatos->legtipo_id;
  //----- Obtener datos de situacion de Revista -----
  $empleadocontratodatos = $fichadolote->ObtenerEmpleadoContrato($nrodocto, $legajotipo);
  if(empty($empleadocontratodatos)){
    //---No existe o esta vacia
    $empleadocategoria = "-";
    $empleadolugardetrabajo = "-";
  }else{
    //-- Existe un contrato
    $trabajoid = $empleadocontratodatos->trabajo_id;
    $lugardetrabajo = $fichadolote->ObtenerLugarDeTrabajoXId($trabajoid);
    $empleadolugardetrabajo = $lugardetrabajo->trabajo_nombre;
    if($legajotipo == 3){
      $empleadocategoria = $empleadocontratodatos->legppermanente_categoria;
    }else{
      //$legtipoid = $empleadocontratodatos->legtipo_id;
      $legajotipo = $fichadolote->ObtenerLegajoTipoId($legajotipo);
      $empleadocategoria = $legajotipo->legtipo_nombre;
    }
  }
  $empleadofichadas = $fichadolote->ObterEmpleadoFichadas($nrodocto);
  $empleadofichadassinprocesar = $fichadolote->ObtenerFichadasSinProcesar($nrodocto, $fechainicial, $fechafinal);

  $html = '
  <table width="100%">
    <tr>
      <td width="7%" align="left" rowspan="5"><img src="../../../../src/images/logo-personal1.png" width="45px" height="60px"/></td>
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
  <div class="titulo">Informe de novedades</div>
  <table width="100%" class="tablanovedades">
    <thead>
      <tr>
        <th width="14%" class="tablanovedades-tituloi">FECHA</th>
        <th width="6%" class="tablanovedades-tituloc">ENTRADA</th>
        <th width="6%" class="tablanovedades-tituloc">SALIDA</th>
        <th width="6%" class="tablanovedades-tituloc">ENTRADA</th>
        <th width="6%" class="tablanovedades-tituloc">SALIDA</th>
        <th width="6%" class="tablanovedades-tituloc">ENTRADA</th>
        <th width="6%" class="tablanovedades-tituloc">SALIDA</th>
        <th class="tablanovedades-tituloi">NOVEDADES</th>
      </tr>
    </thead>';
    foreach($periodofechas as $periodofecha){

      $fechamdy = $periodofecha->format('m/d/Y');
      $fechasql = $periodofecha->format('Y-m-d');
      $fechamuestra = (iconv('ISO-8859-2', 'UTF-8', strftime("%a %d/%m/%Y", strtotime("$fechamdy"))));
      $feriadosdiaactual = $fichadolote->ObtenerFeriadosDia($fechasql);
      $licenciasempleadodia = $fichadolote->ObtenerLicenciasDia($fechasql, $nrodocto);
      //---- Verificar novedades y feriados ---
      if(empty($feriadosdiaactual) AND empty($licenciasempleadodia)){
        //--- No existe feriado ni licencias ---
        $novedad = "<td class='tablanovedades-cuerpoi'></td>";
      }else{
        //--- Preguntar si no existe feriado---
        if(empty($feriadosdiaactual)){
          //---- No existe feriado, Si licencia
          //$novedad = "<td class='tablanovedades-cuerpoi' style='color: #921a25'>Licencia: $licenciaempleadodia->licencia_nombre</td>";
          $novedad = null;
          foreach($licenciasempleadodia as $key => $licenciaempleadodia){
            if ($licenciaempleadodia === end($licenciasempleadodia)) {
              //echo "ÚLTIMO ELEMENTO";
              $novedad = $novedad."Licencia: ".$licenciaempleadodia->licencia_nombre;
            }else{
              $novedad = $novedad."Licencia: ".$licenciaempleadodia->licencia_nombre."<br>";
            }
          }
          $novedad = "<td class='tablanovedades-cuerpoi' style='color: #921a25'>$novedad</td>";
        }else{
          //---Existe feriado, Preguntar licencia
          if(empty($licenciasempleadodia)){
            //--- No existe licencia, si feriado
            //$novedad = "<td class='tablanovedades-cuerpoi' style='color: #0000a3'>Feriado: $feriadodiaactual->feriado_observacion</td>";
            $novedad = null;
            foreach($feriadosdiaactual as $key => $feriadodiaactual){
              //$novedad = $novedad."Feriado: ".$feriadodiaactual->feriado_observacion."<br>";
              if ($feriadodiaactual === end($feriadosdiaactual)) {
                //echo "ÚLTIMO ELEMENTO";
                $novedad = $novedad."Feriado: ".$feriadodiaactual->feriado_observacion;
              }else{
                $novedad = $novedad."Feriado: ".$feriadodiaactual->feriado_observacion."<br>";
              }
            }
            $novedad = "<td class='tablanovedades-cuerpoi' style='color: #0000a3'>$novedad</td>";
          }else{
            //--- Existe licencia y feriado
            //$novedad = "<td class='tablanovedades-cuerpoi'><div style='color: #0000a3'>Feriado: $feriadodiaactual->feriado_observacion</div><div style='color: #921a25'>Licencia: $licenciaempleadodia->licencia_nombre</div></td>";
            $novedad = null;
            $novedadl = null;
            $novedadf = null;
            foreach($licenciasempleadodia as $key => $licenciaempleadodia){
              //$novedad = $novedad."Licencia: ".$licenciaempleadodia->licencia_nombre."<br>";
              if ($licenciaempleadodia === end($licenciasempleadodia)) {
                //echo "ÚLTIMO ELEMENTO";
                $novedadl = $novedadl."Licencia: ".$licenciaempleadodia->licencia_nombre."<br>";
              }else{
                $novedadl = $novedadl."Licencia: ".$licenciaempleadodia->licencia_nombre."<br>";
              }
            }
            foreach($feriadosdiaactual as $key => $feriadodiaactual){
              //$novedad = $novedad."Feriado: ".$feriadodiaactual->feriado_observacion."<br>";
              if ($feriadodiaactual === end($feriadosdiaactual)) {
                //echo "ÚLTIMO ELEMENTO";
                $novedadf = $novedadf."Feriado: ".$feriadodiaactual->feriado_observacion;
              }else{
                $novedadf = $novedadf."Feriado: ".$feriadodiaactual->feriado_observacion."<br>";
              }
            }
            $novedad = "<td class='tablanovedades-cuerpoi'>
                          <div style='color: #921a25'>$novedadl</div>
                          <div style='color: #0000a3'>$novedadf</div>
                        </td>";


          }
        }
      }
      $fichadasempleadoc = $fichadolote->ObtenerFichadaDia($fechasql, $nrodocto);
      $fichadasdia = $fichadolote->ObtenerMarcacionesDia($fechasql, $nrodocto);
      $fichadasdiac = count($fichadasdia);
      $horame1 = null;
      $horams1 = null;
      $horame2 = null;
      $horams2 = null;
      $horame3 = null;
      $horams3 = null;

      if($fichadasdiac == 0){
        //---No tiene fichadas
        $fichadas = "<td class='tablanovedades-cuerpoc'></td>
                     <td class='tablanovedades-cuerpoc'></td>
                     <td class='tablanovedades-cuerpoc'></td>
                     <td class='tablanovedades-cuerpoc'></td>
                     <td class='tablanovedades-cuerpoc'></td>
                     <td class='tablanovedades-cuerpoc'></td>
                   ";
      }elseif($fichadasdiac == 1){
        //---Tine 1 Fichada ---
        list($fechame1, $horame1) = explode(" ", $fichadasdia[0]->mprocesop_entrada);
        list($fechams1, $horams1) = explode(" ", $fichadasdia[0]->mprocesop_salida);
        if($fichadasdia[0]->mprocesop_entrada == "0000-00-00 00:00:00"){
          $horame1m = "<strong>?</strong>";
        }else{
          //---
          list($hh, $mm, $ss) = explode(":", $horame1);
          $horame1m = $hh.":".$mm;
        }
        if($fichadasdia[0]->mprocesop_salida == "0000-00-00 00:00:00"){
          $horams1m = "<strong>?</strong>";
        }else{
          //---
          list($hh, $mm, $ss) = explode(":", $horams1);
          $horams1m = $hh.":".$mm;
        }

        $fichadas = "<td class='tablanovedades-cuerpoc'>$horame1m</td>
                     <td class='tablanovedades-cuerpoc'>$horams1m</td>
                     <td class='tablanovedades-cuerpoc'></td>
                     <td class='tablanovedades-cuerpoc'></td>
                     <td class='tablanovedades-cuerpoc'></td>
                     <td class='tablanovedades-cuerpoc'></td>
                   ";
      }elseif($fichadasdiac == 2){
        //---Tiene 2 Fichadas ---
        //---- Fichada 1
        list($fechame1, $horame1) = explode(" ", $fichadasdia[0]->mprocesop_entrada);
        list($fechams1, $horams1) = explode(" ", $fichadasdia[0]->mprocesop_salida);
        if($fichadasdia[0]->mprocesop_entrada == "0000-00-00 00:00:00"){
          $horame1m = "<strong>?</strong>";
        }else{
          //---
          list($hh, $mm, $ss) = explode(":", $horame1);
          $horame1m = $hh.":".$mm;
        }
        if($fichadasdia[0]->mprocesop_salida == "0000-00-00 00:00:00"){
          $horams1m = "<strong>?</strong>";
        }else{
          //---
          list($hh, $mm, $ss) = explode(":", $horams1);
          $horams1m = $hh.":".$mm;
        }
        //---Fichada 2
        //---Tiene 2 Fichadas ---
        list($fechame2, $horame2) = explode(" ", $fichadasdia[1]->mprocesop_entrada);
        list($fechams2, $horams2) = explode(" ", $fichadasdia[1]->mprocesop_salida);
        if($fichadasdia[1]->mprocesop_entrada == "0000-00-00 00:00:00"){
          $horame2m = "<strong>?</strong>";
        }else{
          //---
          list($hh, $mm, $ss) = explode(":", $horame2);
          $horame2m = $hh.":".$mm;
        }
        if($fichadasdia[1]->mprocesop_salida == "0000-00-00 00:00:00"){
          $horams2m = "<strong>?</strong>";
        }else{
          //---
          list($hh, $mm, $ss) = explode(":", $horams2);
          $horams2m = $hh.":".$mm;
        }

        $fichadas = "<td class='tablanovedades-cuerpoc'>$horame1m</td>
                     <td class='tablanovedades-cuerpoc'>$horams1m</td>
                     <td class='tablanovedades-cuerpoc'>$horame2m</td>
                     <td class='tablanovedades-cuerpoc'>$horams2m</td>
                     <td class='tablanovedades-cuerpoc'></td>
                     <td class='tablanovedades-cuerpoc'></td>
                   ";
      }elseif($fichadasdiac == 3){
        //---Tiene 3 Fichadas ---
        //---No tiene fichadas
        $fichadas = "<td class='tablanovedades-cuerpoc'></td>
                     <td class='tablanovedades-cuerpoc'></td>
                     <td class='tablanovedades-cuerpoc'></td>
                     <td class='tablanovedades-cuerpoc'></td>
                     <td class='tablanovedades-cuerpoc'></td>
                     <td class='tablanovedades-cuerpoc'></td>
                   ";
      }else{
        //---Tiene mas de 3 fichadas
      }

      $html.='
      <tbody>
      <tr>
        <td class="tablanovedades-cuerpoi">'.$fechamuestra.'</td>
        '.$fichadas.'
        '.$novedad.'
      </tr>';
    }
    $html.='
    </tbody>
  </table>
  <div class="titulo">Novedades sin procesar</div>
  <table width="100%" class="tablanovsinprocesar">
    <thead>
      <tr>
        <th width="14%" class="tablanovsinprocesar-titulo">FECHA</th>
        <th class="tablanovsinprocesar-titulo">HORARIOS</th>
        <th class="tablanovsinprocesar-titulo">NOVEDADES</th>
      </tr>
    </thead>
    <tbody>';
    foreach($empleadofichadassinprocesar as $row){
      $fechamuestra2 = (iconv('ISO-8859-2', 'UTF-8', strftime("%a %d/%m/%Y", strtotime("$row->marcacion_datetime"))));
      $fechamuestra3 = (iconv('ISO-8859-2', 'UTF-8', strftime("%Y/%m/%d", strtotime("$row->marcacion_datetime"))));
      $html.='
        <tr>
          <td class="tablanovsinprocesar-cuerpo">'.$fechamuestra2.'</td>
          <td class="tablanovsinprocesar-cuerpo">';
          $fichadasinprocesardia = $fichadolote->ObtenerFichadasSinProcesarDia($nrodocto, $fechamuestra3);
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
  ';
  $fooster = '<div class="fooster">Sistema de Recursos Humanos © 2019 Adhemar Caminos - Pagina {PAGENO} de {nbpg}</div>';

  $css = file_get_contents('../css/fichadas-periodoc.css');
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
