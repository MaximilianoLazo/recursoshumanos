<?php
  set_time_limit(1800);
  error_reporting(0);
  session_start();
  if(!isset($_SESSION['usuario_id'])){
    echo '<meta http-equiv="refresh" content="0;URL=../login/index.php">';
  }
  //----sona horario y formato de fechas--------
  date_default_timezone_set("America/Buenos_Aires");
  //setlocale(LC_ALL,"es_ES");
  setlocale(LC_ALL, 'es_RA.UTF8');
  //setlocale(LC_TIME, "es_RA.UTF-8");
  setlocale(LC_TIME, 'es_RA.utf-8','spanish');
  //setlocale('es_ES.UTF-8'); // I'm french
  $fechai = $_POST["IndumentariaLEFecIni"];
  $fechaf = $_POST["IndumentariaLEFecFin"];
  $secretaria = $_POST["IndumentariaLESec"];
  $ltrabajo = $_POST["IndumentariaLELTrabajo"];

  if($secretaria == 0 AND $ltrabajo == 0){
    //---sin filtro de secretaria ni lugar de trabajo
    $indumentariaentdatos = $this->model->IndumentariasEntregasListarXFecha($fechai, $fechaf);
  }elseif($secretaria > 0 AND $ltrabajo == 0){
    //---sin filtro de lugar de trabajo, con filtro de secretaria
    $indumentariaentdatos = $this->model->IndumentariasEntregasListarXFechaXSecretaria($fechai, $fechaf, $secretaria);
  }elseif($secretaria > 0 AND $ltrabajo > 0){
    //---con filtro de secretaria y lugar de trabajo
    $indumentariaentdatos = $this->model->IndumentariasEntregasListarXFechaXSecretariaXLTrabajo($fechai, $fechaf, $secretaria, $ltrabajo);
  }elseif($secretaria == 0 AND $ltrabajo > 0){
    //---sin filtro de secretaria, con filtro de lugar de trabajo
    $indumentariaentdatos = $this->model->IndumentariasEntregasListarXFechaXLTrabajo($fechai, $fechaf, $ltrabajo);
  }else{
    //---defaul, error----
  }

  //$indumentariaentdatos = $this->model->IndumentariasEntregasListarXFecha($fechai, $fechaf);

?>
<div class="row">
  <div class="col-md-12">
    <div id="no-more-tables">
      <div class="table-wrapper-scroll-y my-custom-scrollbar">
        <table border="1" class="table table-striped table-hover table-fixed">
          <thead>
            <tr>
              <th style="font-size: 10px;">FECHA</th>
              <th style="font-size: 10px;">DNI</th>
              <th style="font-size: 10px;">APELLIDO Y NOMBRES</th>
              <th style="font-size: 10px;">ORDEN</th>
              <th style="font-size: 10px;">CANT.</th>
              <th style="font-size: 10px;">INDUMENTARIA</th>
              <th style="font-size: 10px; text-align: center">TALLE</th>
              <th style="font-size: 10px;">COLOR</th>
              <th style="font-size: 10px;">OBSERVACION</th>
              <th style="font-size: 10px;">LUGAR DE TRABAJO</th>
              <th style="font-size: 10px;">SECRETARIA</th>
            </tr>
          </thead>
          <tbody>
            <?php
              foreach($indumentariaentdatos as $row):
                $indumentaria_fec = new DateTime($row->indumentaria_entrega_fecha);
                $indumentaria_fec_pantalla = $indumentaria_fec->format('d/m/Y');
            ?>
            <tr>
              <td style="font-size: 10px;" data-title="Licencia:">
                <?php echo $indumentaria_fec_pantalla; ?>
              </td>
              <td style="font-size: 10px; text-align: right" data-title="Licencia:">
                <?php echo $row->legempleado_nrodocto; ?>
              </td>
              <td style="font-size: 10px;" data-title="Licencia:">
                <?php echo $row->legempleado_apellido.", ".$row->legempleado_nombres; ?>
              </td>
              <td style="font-size: 10px; text-align: right" data-title="Licencia:">
                <?php echo $row->indumentaria_orden_id; ?>
              </td>
              <td style="font-size: 10px; text-align: right" data-title="Licencia:">
                <?php echo $row->indumentaria_entrega_cantidad; ?>
              </td>

              <td style="font-size: 10px;" data-title="Licencia:">
                <?php echo $row->indumentaria_nombre; ?>
              </td>
              <td style="font-size: 10px; text-align: center;" data-title="Dias:">
                <?php echo $row->indumentaria_talle_nombre; ?>
              </td>
              <td style="font-size: 10px;" data-title="Dias:">
                <?php echo $row->indumentaria_color_nombre; ?>
              </td>
              <td style="font-size: 10px;" data-title="Licencia:">
                <?php echo $row->indumentaria_entrega_observacion; ?>
              </td>
              <td style="font-size: 10px; " data-title="Dias:">
                <?php echo $row->trabajo_nombre; ?>
              </td>
              <td style="font-size: 12px; " data-title="Dias:">
                <?php echo $row->secretaria_nombre; ?>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<script>

</script>
