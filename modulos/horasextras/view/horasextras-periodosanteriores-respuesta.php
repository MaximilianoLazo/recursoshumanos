<?php

  error_reporting(0);
  session_start();
  if(!isset($_SESSION['usuario_id'])){
    header('Location: ../login/index.php');
  }
  require_once '../../../database/Conexion.php';
  require_once '../model/horasextras.php';

  $horasextras = new HorasExtras();

  //----- datos extraidos
  //setlocale(LC_ALL,"es_ES");
  setlocale(LC_ALL, 'es_RA.UTF8');
  //setlocale(LC_TIME, "es_RA.UTF-8");
  setlocale(LC_TIME, 'es_RA.utf-8','spanish');
  //setlocale('es_ES.UTF-8'); // I'm french !
  $nrodocto = $_POST["NroDocto"];
  $fechai = $_POST["FechaI"];
  $fechaf = $_POST["FechaF"];
  //----- calculo para rango de fecahs ----
  $date_start = new DateTime($fechai);
  $date_end = new DateTime("$fechaf 23:59:59");

  $interval = '+1 days';
  $date_interval = DateInterval::createFromDateString($interval);
  $period = new DatePeriod($date_start, $date_interval, $date_end);

  //$datosempleado = $marcacion->ObtenerEmpleado($nrodocto);
  //$datoaccessid = $marcacion->ObtenerAccessId($nrodocto);
  //$accessid = $datoaccessid->marcacion_accessid;

?>

  <div class="row">
    <div class="col-md-6">
      <div class="clearfix">
        <h5 class="text-blue"><?php echo "Empleado: ".$datosempleado->legempleado_apellido.", ".$datosempleado->legempleado_nombres; ?></h5>
      </div>
    </div>
    <div class="col-md-6">
      <div class="clearfix">
        <div align="right">
          <a class="btn btn-danger" href="?c=marcacion&a=ImprimirFichadaLoteI&id=<?php echo $nrodocto; ?>">Imprimir Fichadas [PERIODO]</a>
          <a class="btn btn-warning" href="?c=marcacion&a=MarcacionesReprocesar&id=<?php echo $accessid; ?>">Re-Procesar</a>
        </div>
      </div>
    </div>
  </div>
  <p></p>
  <div class="row">
    
    <table class="data-table table-bordered stripe hover nowrap">
      <thead>
        <tr>
          <th>DNI</th>
          <th>Apellido y Nombres</th>
          <th>Lugar de Trabajo</th>
          <th>Hs Extras Simples</th>
          <th>Horas Extras Dobles</th>
          <th>Jornales</th>
          <th>Observaciones</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
       <?php
        foreach($horasextras->ListarHorasExtras() as $row):
          $nrodocto = $row->legempleado_nrodocto;
          $datosempleado = $horasextras->DatosEmpleado($nrodocto);
       ?>
        <tr>
          <td><?php echo $row->legempleado_nrodocto; ?></td>
          <td><?php echo $datosempleado->legempleado_apellido.", ".$datosempleado->legempleado_nombres; ?></td>
          <td><?php echo $row->trabajo_nombre; ?></td>
          <td class="dt-right"><?php echo $row->horasex_simples; ?></td>
          <td class="dt-right"><?php echo $row->horasex_dobles; ?></td>
          <td class="dt-right"><?php echo $row->horas_jornales; ?></td>
          <td><?php echo $row->horas_observaciones; ?></td>
          <td class="dt-right">
            <a  class="btn btn-primary" href="#"><i class='icon-copy fi-pencil'></i></a>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <script>
		$('document').ready(function(){
			$('.data-table').DataTable({
				scrollCollapse: true,
				autoWidth: false,
				responsive: true,
				columnDefs: [{
					className: "dt-right"
				}],
				columnDefs: [{
					targets: "datatable-nosort",
					orderable: false,
				}],
				columnDefs: [
					{
					targets: 3,
					render: $.fn.dataTable.render.number('.', ',', 2, ''),
					},
					{
					targets: 4,
					render: $.fn.dataTable.render.number('.', ',', 2, ''),
					},
					{
					targets: 5,
					render: $.fn.dataTable.render.number('.', ',', 2, ''),
					}
				],

				"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todo"]],
				"language": {
				"sProcessing":     "Procesando...",
				"sLengthMenu":     "Mostrar _MENU_ registros",
				"sZeroRecords":    "No se encontraron resultados",
				"sEmptyTable":     "Ningún dato disponible en esta tabla",
				"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
				"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
				"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
				"sInfoPostFix":    "",
				"sSearch":         "Buscar:",
				"sUrl":            "",
				"sInfoThousands":  ",",
				"sLoadingRecords": "Cargando...",
				"oPaginate": {
				"sFirst":    "Primero",
				"sLast":     "Último",
				"sNext":     "Siguiente",
				"sPrevious": "Anterior"
				},
				"oAria": {
				"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			}

				},
			});
		});
	</script>
