<?php
//error_reporting(0);
session_start();
if(!isset($_SESSION['usuario_id'])){
  header('Location: ../login/index.php');
}
$ndocconsultado = $_GET["id"];
// Esto evaluará a TRUE así que el texto se imprimirá.
if(isset($_GET["id"])){
  //echo "Esta variable está definida, así que se imprimirá";
  $valorimput = $ndocconsultado;
}else{
  $valorimput = null;
}

?>
<!DOCTYPE html>
<html>
<head>
	<?php include('../../includes/head.php'); ?>
  <link rel="stylesheet" type="text/css" href="../../src/plugins/tabla-car/tabla-car.css">

</head>
<body>
	<?php include('../../includes/header.php'); ?>
	<?php include('../../includes/sidebar.php'); ?>
	<!--**********ventanas modal***********-->
	<?php include("includes/mdl/indumentariatipo-editar.php");?>
  <?php include("includes/mdl/indumentariatipo-baja.php");?>
  <?php include("includes/mdl/indumentariatalle-editar.php");?>
  <?php include("includes/mdl/indumentariatalle-baja.php");?>
  <?php include("includes/mdl/indumentariacolor-editar.php");?>
  <?php include("includes/mdl/indumentariacolor-baja.php");?>
	<div class="main-container">
    <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">

					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Entrega & Consulta de Indumentarias</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item active"><a href="index.php">Inicio</a></li>
									<li class="breadcrumb-item" aria-current="page">Entrega & Consulata de Indumentarias</li>
								</ol>
							</nav>
						</div>
						<div class="col-md-6 col-sm-12 text-right">
							<!--
							<div class="dropdown">
								<a class="btn btn-primary dropdown-toggle" href="#" role="button" data-toggle="dropdown">
									January 2018
								</a>
								<div class="dropdown-menu dropdown-menu-right">
									<a class="dropdown-item" href="#">Export List</a>
									<a class="dropdown-item" href="#">Policies</a>
									<a class="dropdown-item" href="#">View Assets</a>
								</div>
							</div>
							-->
						</div>
					</div>
				</div>
				<!-- Simple Datatable start -->
				<!--<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">-->
					<div class="clearfix mb-20">
						<div class="pull-left">
							<h5 class="text-blue">Indumentaria</h5>
						</div>
					</div>
          <div class="row">
  					<div class="col-lg-4 col-md-6 col-sm-12 mb-30">
  						<div class="pd-20 bg-white border-radius-4 box-shadow">
  							<h4 class="mb-20">Tipos de Indumentaria</h4>
                <div class="row">
      						<div class="col-md-12">
      							<div class="form-group">
      								<div align="right">
                        <button type="button"
      													class="btn btn-success"
      													data-toggle="modal"
      													data-target="#IndumentariaTipoEditar"
      													data-titulo="<?php echo "AGREGAR Indumentaria TIPO"; ?>">
                                <span style="font-size: 20px; color: #2d572c;">
                                  <i class="icon-copy ion-plus-round"></i>
                                </span>
      									</button>
      								</div>
      							</div>
      						</div>
      					</div>
                <div id="tblcontenidoentregas">
                  <div class="row">
                   <div class="col-md-12">
                    <div id="no-more-tables">
                      <div class="table-wrapper-scroll-y my-custom-scrollbar">
                        <table border="1" class="table table-striped table-hover table-fixed">
                          <thead>
                            <tr>
                              <th style="font-size: 14px;">INDUMENTARIA</th>
                              <th style="font-size: 14px;">ACCIONES</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              foreach($this->model->IndumentariaListar() as $row):
                            ?>
                            <tr>
                              <td style="font-size: 14px;" data-title="Indumentaria:">
                                <?php echo $row->indumentaria_nombre; ?>
                              </td>
                              <td width="8%" style="font-size: 14px; text-align: right" data-title="Acciones:">
                                <a href="#"
                                   data-toggle="modal"
                                   data-target="#IndumentariaTipoEditar"
                                   data-titulo="<?php echo "EDITAR Indumentaria TIPO"; ?>"
                                   data-indtipoid="<?php echo $row->indumentaria_id; ?>"
                                   data-indtiponombre="<?php echo $row->indumentaria_nombre; ?>">
                                   <span style="font-size: 15px; color: #3b83bd;">
                                     <i class="ion-android-create"></i>
                                   </span>
                                </a>

                                &nbsp;
                                &nbsp;

                                <a href="#"
                                   data-toggle="modal"
                                   data-target="#IndumentariaTipoBaja"
                                   data-titulo="<?php echo "QUITAR Indumentaria TIPO"; ?>"
                                   data-indumentariaid="<?php echo $row->indumentaria_id; ?>">
                                   <span style="font-size: 15px; color: #e61919;">
                                     <i class="ion-android-close"></i>
                                   </span>
                                </a>
                              </td>
                            </tr>
                            <?php endforeach; ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                 </div>
                </div>
  						</div>
  					</div>
  					<div class="col-lg-4 col-md-6 col-sm-12 mb-30">
  						<div class="pd-20 bg-white border-radius-4 box-shadow">
  							<h4 class="mb-20">Talles</h4>
                <!--
  							<div class="list-group">
  								<a href="#" class="list-group-item list-group-item-action active">Cras justo odio</a>
  								<a href="#" class="list-group-item list-group-item-action">Dapibus ac facilisis in</a>
  								<a href="#" class="list-group-item list-group-item-action">Morbi leo risus</a>
  								<a href="#" class="list-group-item list-group-item-action">Porta ac consectetur ac</a>
  								<a href="#" class="list-group-item list-group-item-action disabled">Vestibulum at eros</a>
  							</div>
                -->
                <div class="row">
      						<div class="col-md-12">
      							<div class="form-group">
      								<div align="right">
                        <button type="button"
      													class="btn btn-success"
      													data-toggle="modal"
      													data-target="#IndumentariaTalleEditar"
      													data-titulo="<?php echo "AGREGAR Indumentaria Talle"; ?>">
                                <span style="font-size: 20px; color: #2d572c;">
                                  <i class="icon-copy ion-plus-round"></i>
                                </span>
      									</button>
      								</div>
      							</div>
      						</div>
      					</div>
                <div id="tblcontenidoentregas">
                  <div class="row">
                   <div class="col-md-12">
                    <div id="no-more-tables">
                      <div class="table-wrapper-scroll-y my-custom-scrollbar">
                        <table border="1" class="table table-striped table-hover table-fixed">
                          <thead>
                            <tr>
                              <th style="font-size: 14px;">INDUMENTARIA</th>
                              <th style="font-size: 14px;">TALLE</th>
                              <th style="font-size: 14px;">ACCIONES</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              foreach($this->model->IndumentariaTalleListar() as $row):
                            ?>
                            <tr>
                              <td style="font-size: 14px;" data-title="Indumentaria:">
                                <?php echo $row->indumentaria_nombre; ?>
                              </td>
                              <td style="font-size: 14px;" data-title="Talle:">
                                <?php echo $row->indumentaria_talle_nombre; ?>
                              </td>
                              <td width="8%" style="font-size: 14px; text-align: right" data-title="Acciones:">
                                <a href="#"
                                   data-toggle="modal"
                                   data-target="#IndumentariaTalleEditar"
                                   data-titulo="<?php echo "EDITAR Indumentaria Talle"; ?>"
                                   data-indtalleid="<?php echo $row->indumentaria_talle_id; ?>"
                                   data-indtallenombre="<?php echo $row->indumentaria_talle_nombre; ?>"
                                   data-indumentariaid="<?php echo $row->indumentaria_id; ?>">
                                   <span style="font-size: 15px; color: #3b83bd;">
                                     <i class="ion-android-create"></i>
                                   </span>
                                </a>
                                &nbsp;
                                &nbsp;
                                <a href="#"
                                   data-toggle="modal"
                                   data-target="#IndumentariaTalleBaja"
                                   data-titulo="<?php echo "QUITAR Indumentaria Talle"; ?>"
                                   data-indumentariatalleid="<?php echo $row->indumentaria_talle_id; ?>">
                                   <span style="font-size: 15px; color: #e61919;">
                                     <i class="ion-android-close"></i>
                                   </span>
                                </a>
                              </td>
                            </tr>
                            <?php endforeach; ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                 </div>
                </div>
  						</div>
  					</div>
  					<div class="col-lg-4 col-md-6 col-sm-12 mb-30">
  						<div class="pd-20 bg-white border-radius-4 box-shadow">
  							<h4 class="mb-20">Colores</h4>
                <div class="row">
      						<div class="col-md-12">
      							<div class="form-group">
      								<div align="right">
                        <button type="button"
      													class="btn btn-success"
      													data-toggle="modal"
      													data-target="#IndumentariaColorEditar"
      													data-titulo="<?php echo "AGREGAR Indumentaria Color"; ?>">
                                <span style="font-size: 20px; color: #2d572c;">
                                  <i class="icon-copy ion-plus-round"></i>
                                </span>
      									</button>
      								</div>
      							</div>
      						</div>
      					</div>
                <div id="tblcontenidoentregas">
                  <div class="row">
                   <div class="col-md-12">
                    <div id="no-more-tables">
                      <div class="table-wrapper-scroll-y my-custom-scrollbar">
                        <table border="1" class="table table-striped table-hover table-fixed">
                          <thead>
                            <tr>
                              <th style="font-size: 14px;">COLOR</th>
                              <th style="font-size: 14px;">ACCIONES</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              foreach($this->model->IndumentariaColorListar() as $row):
                            ?>
                            <tr>
                              <td style="font-size: 14px;" data-title="Color:">
                                <?php echo $row->indumentaria_color_nombre; ?>
                              </td>
                              <td width="8%" style="font-size: 14px; text-align: right" data-title="Acciones:">
                                <a href="#"
                                   data-toggle="modal"
                                   data-target="#IndumentariaColorEditar"
                                   data-titulo="<?php echo "EDITAR Indumentaria Color"; ?>"
                                   data-indcolorid="<?php echo $row->indumentaria_color_id; ?>"
                                   data-indcolornombre="<?php echo $row->indumentaria_color_nombre; ?>">
                                   <span style="font-size: 15px; color: #3b83bd;">
                                     <i class="ion-android-create"></i>
                                   </span>
                                </a>
                                &nbsp;
                                &nbsp;
                                <a href="#"
                                   data-toggle="modal"
                                   data-target="#IndumentariaColorBaja"
                                   data-titulo="<?php echo "QUITAR Indumentaria Color"; ?>"
                                   data-indumentariacolorid="<?php echo $row->indumentaria_color_id; ?>">
                                   <span style="font-size: 15px; color: #e61919;">
                                     <i class="ion-android-close"></i>
                                   </span>
                                </a>
                              </td>
                            </tr>
                            <?php endforeach; ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                 </div>
                </div>
  						</div>
  					</div>




  				</div>
			  <!--</div>-->
			<?php include('../../includes/footer.php'); ?>
		  </div>
	  </div>
  </div>
  <?php include('../../includes/script.php'); ?>
  <!-- busqueda de empleados -->
	<script src="../../src/plugins/typeahead/typeahead.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../../src/plugins/typeahead/typeahead.css">
  <!--script propios del formulario -->
	<script src="includes/js/indumentaria.js"></script>
  <script>
		jQuery(document).ready(function(){
			//--- resultado en vivo de marcaciones ---------
			jQuery("#btnbusquedaindumentariaenviar").click(function(){
				//cogemos el valor del input
				var nrodocto = jQuery("#txtbusquedaindumentarianrodocto").val();
				var params = {
					"NroDocto" : nrodocto,
				};
				//llamada al fichero PHP con AJAX
				$.ajax({
					data:  params,
          url:   '?c=indumentaria&a=IndumentariaRespuesta',
					dataType: 'html',
					type:  'post',
					beforeSend: function () {
						//mostramos gif "cargando"
						//jQuery('#loading_spinner').show();
						//antes de enviar la petición al fichero PHP, mostramos mensaje
						jQuery("#tabladato").html("<div class='col-md-12'>Cargando Datos...</div>");
					},
					success:  function (response) {
						//escondemos gif
						//jQuery('#loading_spinner').hide();
						//mostramos salida del PHP
						jQuery("#tabladato").html(response);
					}
				});
			});
      //------Al cargar el Formulario -------
      var nrodocto = jQuery("#txtbusquedaindumentarianrodocto").val();
      //if(node === null){
      if(nrodocto === ""){ //true
        //----Campo vacio ----
      }else{
        //--- resultado en vivo de marcaciones ---------
  			jQuery(document).ready(function(){
  				var params = {
  					"NroDocto" : nrodocto
  				};
  				//--------llamada al fichero PHP con AJAX
  				$.ajax({
  					data:  params,
            url:   '?c=indumentaria&a=IndumentariaRespuesta',
  					dataType: 'html',
  					type:  'post',
  					beforeSend: function () {
  						//mostramos gif "cargando"
  						//jQuery('#loading_spinner').show();
  						//antes de enviar la petición al fichero PHP, mostramos mensaje
              jQuery("#tabladato").html("<div class='col-md-12'>Cargando Datos...</div>");
  					},
  					success:  function (response) {
  						//escondemos gif
  						//jQuery('#loading_spinner').hide();
  						//mostramos salida del PHP
              jQuery("#tabladato").html(response);
  					}
  				});
  			});
      }
		});
  </script>
</body>
</html>
