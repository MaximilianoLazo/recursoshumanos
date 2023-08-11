<?php

  set_time_limit(1800);

  $nrodocto = $_POST["NroDni"];
  $fechainicio = $_POST["FechaI"];
  $fechafinal = $_POST["FechaF"];
  //------MPDF--------------
  require_once __DIR__ . '../../../../../vendor/autoload.php';
  $mpdf = new mPDF('s', 'A4');

  //----sona horario y formato de fechas--------
  date_default_timezone_set("America/Buenos_Aires");
  //setlocale(LC_ALL,"es_ES");
  setlocale(LC_ALL, 'es_RA.UTF8');
  //setlocale(LC_TIME, "es_RA.UTF-8");
  setlocale(LC_TIME, 'es_RA.utf-8','spanish');
  //setlocale('es_ES.UTF-8'); // I'm french !
  $fecha_i_sql = new DateTime($fechainicio);
  $fecha_i = $fecha_i_sql->format('d/m/Y');
  $fecha_f_sql = new DateTime($fechafinal);
  $fecha_f = $fecha_f_sql->format('d/m/Y');

  $datetime = new DateTime();
  $fecha_actual_ymdhis = $datetime->format('YmdHis');
  $fecha_actual_y = $datetime->format('Y');
  $fecha_hora_actual = $datetime->format('d/m/Y H:i:s');


  $date_start = new DateTime($fechainicio);
  $date_end = new DateTime("$fechafinal 23:59:59");

  $interval = '+1 days';
  $date_interval = DateInterval::createFromDateString($interval);
  $periodo = new DatePeriod($date_start, $date_interval, $date_end);

  $empleadodatos = $this->model->EmpleadoObtener($nrodocto);

  if($empleadodatos->legtipo_id == 1){
    //---Contratado
    $empsituacionrev = $this->model->ContratadoObtener($nrodocto);
    //-----CATEGORIA O TIPO DE LEGAJO ---
    $legajonombreobj = $this->model->LegajoNombreXIdObtner($empleadodatos->legtipo_id);
    $empcategoria = $legajonombreobj->legtipo_nombre;
    //-----LUGAR DE TRABAJO -------
    $empltrabajoobj = $this->model->LTrabajoXIdObtener($empsituacionrev->trabajo_id);
    $empltrabajo = $empltrabajoobj->trabajo_nombre;
  }elseif($empleadodatos->legtipo_id == 2){
    //----Jornalero
    $empsituacionrev = $this->model->JornaleroObtener($nrodocto);
    //-----CATEGORIA O TIPO DE LEGAJO ---
    $legajonombreobj = $this->model->LegajoNombreXIdObtner($empleadodatos->legtipo_id);
    $empcategoria = $legajonombreobj->legtipo_nombre;
    //-----LUGAR DE TRABAJO -------
    $empltrabajoobj = $this->model->LTrabajoXIdObtener($empsituacionrev->trabajo_id);
    $empltrabajo = $empltrabajoobj->trabajo_nombre;
  }elseif($empleadodatos->legtipo_id == 3){
    //----PPermanente ----
    $empsituacionrev = $this->model->PPermanenteObtener($nrodocto);
    //-----CATEGORIA O TIPO DE LEGAJO ---
    $empcategoria = $empsituacionrev->legppermanente_categoria;
    //-----LUGAR DE TRABAJO -------
    $empltrabajoobj = $this->model->LTrabajoXIdObtener($empsituacionrev->trabajo_id);
    $empltrabajo = $empltrabajoobj->trabajo_nombre;
  }elseif($empleadodatos->legtipo_id == 4){
    //---Proveedor -----
    $empsituacionrev = $this->model->ProveedorObtener($nrodocto);
    //-----CATEGORIA O TIPO DE LEGAJO ---
    $legajonombreobj = $this->model->LegajoNombreXIdObtner($empleadodatos->legtipo_id);
    $empcategoria = $legajonombreobj->legtipo_nombre;
    //-----LUGAR DE TRABAJO -------
    $empltrabajoobj = $this->model->LTrabajoXIdObtener($empsituacionrev->trabajo_id);
    $empltrabajo = $empltrabajoobj->trabajo_nombre;
  }else{
    //----Ninguno de los anteriores
    $empcategoria = "";
    $empltrabajo = "";
  }

  $empfichadas = $this->model->EmpFicCronograma($nrodocto);

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
          </table>
          <br>';


    $empleadodatos = $this->model->EmpleadoObtener($nrodocto);

    if($empleadodatos->legtipo_id == 1){
      //---Contratado
      $empsituacionrev = $this->model->ContratadoObtener($nrodocto);
      //-----CATEGORIA O TIPO DE LEGAJO ---
      $legajonombreobj = $this->model->LegajoNombreXIdObtner($empleadodatos->legtipo_id);
      $empcategoria = $legajonombreobj->legtipo_nombre;
      //-----LUGAR DE TRABAJO -------
      $empltrabajoobj = $this->model->LTrabajoXIdObtener($empsituacionrev->trabajo_id);
      $empltrabajo = $empltrabajoobj->trabajo_nombre;
    }elseif($empleadodatos->legtipo_id == 2){
      //----Jornalero
      $empsituacionrev = $this->model->JornaleroObtener($nrodocto);
      //-----CATEGORIA O TIPO DE LEGAJO ---
      $legajonombreobj = $this->model->LegajoNombreXIdObtner($empleadodatos->legtipo_id);
      $empcategoria = $legajonombreobj->legtipo_nombre;
      //-----LUGAR DE TRABAJO -------
      $empltrabajoobj = $this->model->LTrabajoXIdObtener($empsituacionrev->trabajo_id);
      $empltrabajo = $empltrabajoobj->trabajo_nombre;
    }elseif($empleadodatos->legtipo_id == 3){
      //----PPermanente ----
      $empsituacionrev = $this->model->PPermanenteObtener($nrodocto);
      //-----CATEGORIA O TIPO DE LEGAJO ---
      $empcategoria = $empsituacionrev->legppermanente_categoria;
      //-----LUGAR DE TRABAJO -------
      $empltrabajoobj = $this->model->LTrabajoXIdObtener($empsituacionrev->trabajo_id);
      $empltrabajo = $empltrabajoobj->trabajo_nombre;
    }elseif($empleadodatos->legtipo_id == 4){
      //---Proveedor -----
      $empsituacionrev = $this->model->ProveedorObtener($nrodocto);
      //-----CATEGORIA O TIPO DE LEGAJO ---
      $legajonombreobj = $this->model->LegajoNombreXIdObtner($empleadodatos->legtipo_id);
      $empcategoria = $legajonombreobj->legtipo_nombre;
      //-----LUGAR DE TRABAJO -------
      $empltrabajoobj = $this->model->LTrabajoXIdObtener($empsituacionrev->trabajo_id);
      $empltrabajo = $empltrabajoobj->trabajo_nombre;
    }else{
      //----Ninguno de los anteriores
      $empcategoria = "";
      $empltrabajo = "";
    }



    $empfichadas = $this->model->EmpFicCronograma($nrodocto);
    /*$empleadofichadassinprocesar = $this->model->ObtenerFichadasSinProcesar($nrodocto, $fechainicial, $fechafinal);*/

    $html = '
    <table width="100%">
      <tr>
        <td width="8%" align="left" rowspan="5"><img src="../../src/images/logo-personal1.png" width="45px" height="60px"/></td>
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
          <td class="tablaempleado-cuerpo">'.$empcategoria.'</td>
          <td class="tablaempleado-cuerpo">'.$empltrabajo.'</td>
          <td class="tablaempleado-cuerpo">'.$fecha_i.' al '.$fecha_f.'</td>
          <td class="tablaempleado-cuerpo">'.$fecha_hora_actual.'</td>
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
        foreach($empfichadas as $row){
          if($row->legreloj_lunes == 1){
            list($hh, $mm, $ss) = explode(":", $row->legreloj_luneshe);
            $lunese = $hh.":".$mm;
            list($hh, $mm, $ss) = explode(":", $row->legreloj_luneshs);
            $luness = $hh.":".$mm;
            $lunes = "E[".$lunese."] - S[".$luness."]";
          }else{
            $lunes = "NO FICHA";
          }
          if($row->legreloj_martes == 1){
            list($hh, $mm, $ss) = explode(":", $row->legreloj_marteshe);
            $martese = $hh.":".$mm;
            list($hh, $mm, $ss) = explode(":", $row->legreloj_marteshs);
            $martess = $hh.":".$mm;
            $martes = "E[".$martese."] - S[".$martess."]";
          }else{
            $martes = "NO FICHA";
          }
          if($row->legreloj_miercoles == 1){
            list($hh, $mm, $ss) = explode(":", $row->legreloj_miercoleshe);
            $miercolese = $hh.":".$mm;
            list($hh, $mm, $ss) = explode(":", $row->legreloj_miercoleshs);
            $miercoless = $hh.":".$mm;
            $miercoles = "E[".$miercolese."] - S[".$miercoless."]";
          }else{
            $miercoles = "NO FICHA";
          }
          if($row->legreloj_jueves == 1){
            list($hh, $mm, $ss) = explode(":", $row->legreloj_jueveshe);
            $juevese = $hh.":".$mm;
            list($hh, $mm, $ss) = explode(":", $row->legreloj_jueveshs);
            $juevess = $hh.":".$mm;
            $jueves = "E[".$juevese."] - S[".$juevess."]";
          }else{
            $jueves = "NO FICHA";
          }
          if($row->legreloj_viernes == 1){
            list($hh, $mm, $ss) = explode(":", $row->legreloj_vierneshe);
            $viernese = $hh.":".$mm;
            list($hh, $mm, $ss) = explode(":", $row->legreloj_vierneshs);
            $vierness = $hh.":".$mm;
            $viernes = "E[".$viernese."] - S[".$vierness."]";
          }else{
            $viernes = "NO FICHA";
          }
          if($row->legreloj_sabado == 1){
            list($hh, $mm, $ss) = explode(":", $row->legreloj_sabadohe);
            $sabadoe = $hh.":".$mm;
            list($hh, $mm, $ss) = explode(":", $row->legreloj_sabadohs);
            $sabados = $hh.":".$mm;
            $sabado = "E[".$sabadoe."] - S[".$sabados."]";
          }else{
            $sabado = "NO FICHA";
          }
          if($row->legreloj_domngo == 1){
            list($hh, $mm, $ss) = explode(":", $row->legreloj_domingohe);
            $domingoe = $hh.":".$mm;
            list($hh, $mm, $ss) = explode(":", $row->legreloj_domingohs);
            $domingos = $hh.":".$mm;
            $domingo = "E[".$domingoe."] - S[".$domingos."]";
          }else{
            $domingo = "NO FICHA";
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
          <th class="tablanovedades-tituloc">HORARIOS</th>
          <th width="35%" class="tablanovedades-tituloi">NOVEDADES</th>
        </tr>
      </thead>';
      foreach($periodo as $row){

        $fechamdy = $row->format('m/d/Y');
        $fechasql = $row->format('Y-m-d');
        $fecha_pantalla = (iconv('ISO-8859-2', 'UTF-8', strftime("%a %d/%m/%Y", strtotime("$fechamdy"))));

        //----------------------------------------------------
        $fichadasinprocesardia = $this->model->FichadasHistoricoDiaObtener($nrodocto, $fechasql);
        $feriadosdiaactual = $this->model->FeriadosDiaObtener($fechasql);
        $licenciasempleadodia = $this->model->LicenciasDiaObtener($fechasql, $nrodocto);
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

        $html.='
        <tbody>
        <tr>
          <td class="tablanovedades-cuerpoi2">'.$fecha_pantalla.'</td>
          <td class="tablanovsinprocesar-cuerpo">';
            foreach($fichadasinprocesardia as $row3){
              $html.='
              <label>'.$row3->emp_fichada.' - </label>';
            }
            $html.='
          </td>
          '.$novedad.'
        </tr>';
      }
      $html.='
      </tbody>
    </table>';

    $fooster = '<div class="fooster">Sistema de Recursos Humanos <span class="copy">©</span> 2018~'.$fecha_actual_y.' Adhemar Caminos | pág. {PAGENO}/{nbpg}</div>';

    $css = file_get_contents('includes/css/fichadas-fechas.css');
    $mpdf->writeHTML($css, 1);
    $mpdf->SetHTMLFooter($fooster);
    $mpdf->AddPage('P','','','','',25,15,10,12,0,5);
    $mpdf->WriteHTML($html, 2);
    $mpdf->Output("Fichadas_".$empleadodatos->legempleado_apellido."_".$empleadodatos->legempleado_nombres."_".$fecha_actual_ymdhis.".pdf", 'D');
    exit;
    //==============================================================
    //==============================================================
    //==============================================================
    //==============================================================
    //==============================================================

?>
