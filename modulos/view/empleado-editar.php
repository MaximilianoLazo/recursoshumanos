<?php
session_start();
if(!isset($_SESSION["usuario_id"])){
  header("../legajos/login/index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<?php include('../../includes/head.php'); ?>
	<link rel="stylesheet" type="text/css" href="../../src/plugins/jquery-steps/build/jquery.steps.css">
	<link rel="stylesheet" type="text/css" href="../../src/styles/tableadaptativa1.css">
	<link rel="stylesheet" type="text/css" href="../../src/styles/tableadaptativa2.css">
	<link rel="stylesheet" type="text/css" href="../../src/styles/tableadaptativa3.css">
	<link rel="stylesheet" type="text/css" href="../../src/styles/tableadaptativa4.css">
</head>
<body>
	<?php include('../../includes/header.php'); ?>
	<?php include('../../includes/sidebar.php'); ?>
	<!-- ******** ventanas modal ********** -->
  <!-- /////// step 1 - datos personales /////-->
  <!-- /////// dar de baja empleado ////////-->
  <?php include("includes/mdl/empleado-baja.php"); ?>
  <!-- /////// datos personales /////-->
  <?php include("includes/mdl/empleado-editar-datospersonales.php"); ?>
  <!-- /////// datos de domicilio /////-->
  <?php include("includes/mdl/empleado-editar-domicilio.php"); ?>
  <!-- /////// datos de contacto /////-->
  <?php include("includes/mdl/empleado-editar-contacto.php"); ?>
  <!-- /////// step 2 - Situacion de revista /////-->
  <!-- /////// step 3 - Estudios /////-->
  <!-- /////// step 4 - Marcaciones /////-->
  <!-- /////// step 5 - Conyuge /////-->
  <!-- /////// dar de baja conyuge ////////-->
  <?php include("includes/mdl/conyuge-baja.php"); ?>
  <!-- /////// datos de personales conyuge /////-->
  <?php include("includes/mdl/conyuge-editar-datospersonales.php"); ?>
  <!-- /////// datos de domicilio /////-->
  <?php include("includes/mdl/conyuge-editar-domicilio.php"); ?>
  <!-- /////// datos de contacto /////-->
  <?php include("includes/mdl/conyuge-editar-contacto.php"); ?>

  <!-- /////// step 6 - Hijos /////-->
  <?php include("includes/mdl/hijo-editar.php"); ?>
  <?php include("includes/mdl/hijo-eliminar.php"); ?>
  <?php include("includes/mdl/hijo-habilitar.php");?>
  <?php include("includes/mdl/hijo-deshabilitar.php");?>
  <?php include("includes/mdl/hijo-editar-escuela.php");?>
  <?php include("includes/mdl/hijo-editar-beneficiario.php");?>
  <?php include("includes/mdl/hijo-editar-mop.php");?>
  <!--Pre-Natal-->
  <?php include("includes/mdl/prenatal-editar.php");?>
  <?php include("includes/mdl/prenatal-eliminar.php");?>
  <?php include("includes/mdl/prenatal-editar-beneficiario.php");?>
  <?php include("includes/mdl/prenatal-editar-mop.php");?>
  <?php include("includes/mdl/prenatal-habilitar.php");?>
  <?php include("includes/mdl/prenatal-deshabilitar.php");?>


  <!-- /////// ventanas modal viejas /////-->
	<?php include("includes/mdl/contratoagregar.php");?>
  <?php include("includes/mdl/contratoactualizacion_individual.php");?>
  <?php include("includes/mdl/proveedoragregar.php");?>
  <?php include("includes/mdl/proveedoractualizacion_individual.php");?>
  <?php include("includes/mdl/legajoppermanente-editar.php");?>
  <?php include("includes/mdl/legajojornalero-editar.php");?>


	<?php include("includes/mdl/estudiomodificar.php");?>
	<?php include("includes/mdl/estudioeliminar.php");?>
	<?php include("includes/mdl/fichadaagregar.php");?>
  <?php include("includes/mdl/fichadamodificar.php");?>
  <?php include("includes/mdl/fichadaeliminar.php");?>
	<?php include("includes/mdl/relojmodificar.php");?>
	<?php //include("includes/mdl/conyugeagregar.php");?>


	<?php //include("includes/mdl/prenatalmodificar.php");?>
	<?php //include("includes/mdl/prenataleliminar.php");?>


	<?php include("includes/mdl/hijoconstancia.php");?>
  <!--- no sirven fueron remplazados ---->
  <?php //include("includes/mdl/hijomodificar.php");?>
  <?php //include("includes/mdl/hijoeliminar.php");?>
  <?php //include("includes/mdl/hijoasignacionhab.php");?>




	<div class="main-container">
		<div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Empleado</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
									<li class="breadcrumb-item"><a href="index.php">Empleados</a></li>
									<li class="breadcrumb-item active" aria-current="page">Edicion de Empleado</li>
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
        <?php
          $empleadondocto = $emp->legempleado_nrodocto;
        ?>
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
					<div class="clearfix">
						<h4 class="text-blue"><?php echo $emp->legempleado_apellido.", ".$emp->legempleado_nombres ?></h4>
						<p class="mb-30 font-14">Edicion de Empleado</p>
					</div>
					<div class="wizard-content">
						<form class="tab-wizard wizard-circle wizard" id="" action="?c=empleado&a=EmpleadoPadron" method="post" enctype="multipart/form-data">
							<!-- Step 1 -->
							<h5>Datos Personales</h5>
							<section>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <div align="right">
                        <button type="button"
                                class="btn btn-danger"
                                data-toggle="modal"
                                data-target="#EmpleadoBaja"
                                data-titulo="DAR DE BAJA EMPLEADO"
                                data-empid="<?php echo $emp->legempleado_id; ?>"
                                data-empnrodocto="<?php echo $emp->legempleado_nrodocto; ?>">
                                <!--<i class="fa fa-user-times" aria-hidden="true"></i>-->
                                <!--<i class="fi-minus-circle"></i>-->
                                <!--<i class="ion-power"></i>-->
                                <!--<i class="icon-copy fi-prohibited fa-lg"></i>-->
                                <i class="icon-copy fi-prohibited fa-lg"></i> DAR DE BAJA
                        </button>
                        <?php
                          if(empty($emp->legempleado_celular) AND empty($emp->legempleado_telefono) AND empty($emp->legempleado_email)){
                            ?>
                            <button type="button"
                                    class="btn btn-success"
                                    data-toggle="modal"
                                    data-target="#EmpleadoEditarContacto"
                                    data-titulo="Editar Datos de Contacto"
                                    data-empid="<?php echo $emp->legempleado_id; ?>"
                                    data-empnrodocto="<?php echo $emp->legempleado_nrodocto; ?>"
                                    data-empcelular="<?php echo $emp->legempleado_celular; ?>"
                                    data-emptelefono="<?php echo $emp->legempleado_telefono; ?>"
                                    data-empemail="<?php  echo $emp->legempleado_email; ?>">
                                    
                                    <!--<i class="ion-android-phone-portrait"></i>-->
                                    <!--<span class="ti-tablet"></span>-->
                                    <!--<i class="fa fa-vcard-o" aria-hidden="true"></i>-->
                                    <i class="icon-copy ion-social-whatsapp-outline fa-lg"></i> AGREGAR Datos de Contacto
                            </button>
                            <?php
                          }else{
                            //--- existen datos de contacto
                          }
                        ?>
                        <?php
                          if(empty($emp->legempleado_direccion)){
                            ?>
                            <button type="button"
                                    class="btn btn-success"
                                    data-toggle="modal"
                                    data-target="#EmpleadoEditarDomicilio"
                                    data-titulo="Editar Datos de Domicilio"
                                    data-empid="<?php echo $emp->legempleado_id; ?>"
                                    data-empnrodocto="<?php echo $emp->legempleado_nrodocto; ?>"
                                    data-empdireccion="<?php echo $emp->legempleado_direccion; ?>"
                                    data-empdirecnro="<?php echo $emp->legempleado_direcnro; ?>"
                                    data-empdirecpiso="<?php echo $emp->legempleado_direcpiso; ?>"
                                    data-empcpostal="<?php echo $emp->legempleado_codpostal; ?>"
                                    data-emppais="<?php echo $emp->pais_id; ?>"
                                    data-empprovincia="<?php echo $emp->provincia_id; ?>"
                                    data-empdepartamento="<?php echo $emp->departamento_id; ?>"
                                    data-emplocalidad="<?php echo $emp->localidad_id; ?>">
                                    <i class="ion-ios-home"></i> AGREGAR Datos de Domicilio
                            </button>
                            <?php
                          }else{
                            //--- Exiten datos de domicilio ---
                          }
                        ?>
                        <button type="button"
                                class="btn btn-primary"
                                data-toggle="modal"
                                data-target="#EmpleadoEditarDatosPersonales"
                                data-titulo="Editar Datos Personales"
                                data-empid="<?php echo $emp->legempleado_id; ?>"
                                data-empnrodocto="<?php echo $emp->legempleado_nrodocto; ?>"
                                data-empnrocuil="<?php echo $emp->legempleado_nrocuil; ?>"
                                data-empnrolegajo="<?php echo $emp->legempleado_numerop; ?>"
                                data-empapellido="<?php echo $emp->legempleado_apellido; ?>"
                                data-empnombres="<?php echo $emp->legempleado_nombres; ?>"
                                data-empsexo="<?php echo $emp->sexo_id; ?>"
                                data-empestadocivil="<?php echo $emp->estcivil_id; ?>"
                                data-empfecnac="<?php echo $emp->legempleado_fecnacto; ?>"
                                data-empfecing="<?php echo $emp->legempleado_fecingreso; ?>"
                                data-empmovimiento="2">
                                <i class="fa fa-edit" aria-hidden="true"></i> Editar Datos Personales
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<?php
											$nrodocto = $emp->legempleado_nrodocto;
											$legcontrato = $this->model->ObtenerContrato($nrodocto);
											?>
											<input type="hidden" name="empid" id="empid" value="<?php echo $emp->legempleado_id; ?>">
											<input type="hidden" name="empnrodocumento" id="empnrodocumento" value="<?php echo $emp->legempleado_nrodocto; ?>">
                      <input type="hidden" name="empppdl" id="empppdl" value="<?php echo $emp->pais_id."-".$emp->provincia_id."-".$emp->departamento_id."-".$emp->localidad_id; ?>">

											<!--<input type="hidden" name="contratoid" id="contratoid" value="<?php echo $emp->legcontrato_id; ?>">-->
											<!--<input type="hidden" name="imputacion" id="imputacion" value="<?php echo $legcontrato->imputacion_id."-".$legcontrato->impactividad_id; ?>">-->

										</div>
									</div>
								</div>
                <div class="row">
                  <div class="col-md-3">
                    <div class="row">
                      <div class="col-md-12">
    										<div class="form-group">
                          <?php
      											$img = '../../imagenes/legajos/'.$emp->legempleado_imagen.'.jpg';
      											if(file_exists($img)){
      										    ?>
                              <img src="../../imagenes/legajos/<?php echo $emp->legempleado_imagen; ?>.jpg" class="img-thumbnail" alt="Cinque Terre" width="304" height="236">
      										    <?php
      											}else{
          										if($emp->sexo_id == 1){
      										    ?>
                              <img src="../../imagenes/legajos/avatar-masculino.jpg" class="img-thumbnail" alt="Cinque Terre" width="304" height="236">
      										    <?php
      												}else{
      										    ?>
                              <img src="../../imagenes/legajos/avatar-femenino.jpg" class="img-thumbnail" alt="Cinque Terre" width="304" height="236">
      										    <?php
      												}
      											}
      										?>
    										</div>
                      </div>
                      <div class="col-md-12">
                        <button type="button" class="btn btn-success" style="font-size: 13px;">
                          <!--<i class="ion-android-camera"></i>-->
                          <!--<i class="fa fa-camera-retro" aria-hidden="true"></i>-->
                          <!--<i class="fa fa-camera" aria-hidden="true"></i>-->
                          <!--<i class="ion-camera"></i>-->
                          <i class="fa fa-camera-retro" aria-hidden="true"></i> Tomar Foto
                        </button>
                        <button type="button" class="btn btn-success" style="font-size: 13px;">
                          <i class="ion-image"></i> Subir Foto
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-9">
                    <div class="row">
    									<div class="col-md-4">
    										<div class="form-group">
    											<label for="txtnrodoctom">DNI:</label>
    											<input type="text" name="txtnrodoctom" id="txtnrodoctom" value="<?php echo $emp->legempleado_nrodocto; ?>" class="form-control" disabled>
    										</div>
    									</div>
                      <div class="col-md-4">
    										<div class="form-group">
    											<label for="txtempnrocuilm">CUIL :</label>
    											<input type="text" name="txtempnrocuilm" id="txtempnrocuilm" value="<?php echo $emp->legempleado_nrocuil; ?>" class="form-control" disabled>
    										</div>
    									</div>
                      <div class="col-md-4">
    										<div class="form-group">
    											<label for="txtempnrolegajom">Nro. de Legajo:</label>
    											<input type="text" name="txtempnrolegajom" id="txtempnrolegajom" value="<?php echo $emp->legempleado_numerop; ?>" class="form-control" disabled>
    										</div>
    									</div>
    								</div>
                    <div class="row">
    									<div class="col-md-12">
    										<div class="form-group">
    											<label for="txtempapellidom">Apellido:</label>
    											<input type="text" name="txtempapellidom" id="txtempapellidom" value="<?php echo $emp->legempleado_apellido; ?>" class="form-control" required disabled>
    										</div>
    									</div>
    								</div>
                    <div class="row">
                      <div class="col-md-12">
    										<div class="form-group">
    											<label for="txtempnombresm">Nombres:</label>
    											<input type="text" name="txtempnombresm" id="txtempnombresm" value="<?php echo $emp->legempleado_nombres; ?>" class="form-control" disabled>
    										</div>
    									</div>
                    </div>
                    <div class="row">
    									<div class="col-md-6">
    										<div class="form-group">
    											<label for="cboempsexom">Sexo:</label>
    											<select name="cboempsexom" id="cboempsexom" class="custom-select form-control" disabled>
    												<option></option>
    													<?php foreach($this->model->Sexos() as $row): ?>
    															<option value="<?php echo $row->sexo_id; ?>"<?php if (!(strcmp($row->sexo_id, $emp->sexo_id))) {echo "selected=\"selected\"";} ?>><?php echo $row->sexo_nombre; ?></option>
    												<?php endforeach; ?>
    											</select>
    										</div>
    									</div>
    									<div class="col-md-6">
    										<div class="form-group">
    											<label for="cboempestadocivilm">Estado Civil:</label>
    											<select name="cboempestadocivilm" id="cboempestadocivilm" class="custom-select form-control" disabled>
    												<option></option>
    													<?php foreach($this->model->EstadosC() as $row): ?>
    															<option value="<?php echo $row->estcivil_id; ?>"<?php if (!(strcmp($row->estcivil_id, $emp->estcivil_id))) {echo "selected=\"selected\"";} ?>><?php echo $row->estcivil_nombre; ?></option>
    												<?php endforeach; ?>
    											</select>
    										</div>
    									</div>
                    </div>
                    <div class="row">
    									<div class="col-md-6">
    										<div class="form-group">
    											<label for="cboempestadocivilm">Fecha de Nacimiento:</label>
    											<input type="date" name="cboempestadocivilm" id="cboempestadocivilm" class="form-control" value="<?php echo $emp->legempleado_fecnacto; ?>" placeholder="Select Date" disabled>
    										</div>
    									</div>
    									<div class="col-md-6">
    										<div class="form-group">
                          <label for="txtempfecingm">Fecha de Ingreso:</label>
                          <input type="date" name="txtempfecingm" id="txtempfecingm" value="<?php echo $emp->legempleado_fecingreso; ?>" class="form-control" disabled>
    										</div>
    									</div>
    								</div>
                  </div>
                </div>
                <!--//////////Final formulario empleado - datos personales///////// -->
                <?php
                  if(empty($emp->legempleado_direccion)){
                    //--- no existen datos de domincilio
                  }else{
                    ?>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <div align="right">
                            <button type="button"
                                    class="btn btn-primary"
                                    data-toggle="modal"
                                    data-target="#EmpleadoEditarDomicilio"
                                    data-titulo="Editar Datos de Domicilio"
                                    data-empid="<?php echo $emp->legempleado_id; ?>"
                                    data-empnrodocto="<?php echo $emp->legempleado_nrodocto; ?>"
                                    data-empdireccion="<?php echo $emp->legempleado_direccion; ?>"
                                    data-empdirecnro="<?php echo $emp->legempleado_direcnro; ?>"
                                    data-empdirecpiso="<?php echo $emp->legempleado_direcpiso; ?>"
                                    data-empcpostal="<?php echo $emp->legempleado_codpostal; ?>"
                                    data-emppais="<?php echo $emp->pais_id; ?>"
                                    data-empprovincia="<?php echo $emp->provincia_id; ?>"
                                    data-empdepartamento="<?php echo $emp->departamento_id; ?>"
                                    data-emplocalidad="<?php echo $emp->localidad_id; ?>">
                                    <i class="ion-ios-home"></i> Editar Datos de Domicilio
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
    								<div class="row">
    									<div class="col-md-3">
    										<div class="form-group">
    											<label for="txtempdireccionm">Direccion:</label>
    											<input type="text" name="txtempdireccionm" id="txtempdireccionm" value="<?php echo $emp->legempleado_direccion; ?>" class="form-control" disabled>
    										</div>
    									</div>
    									<div class="col-md-3">
    										<div class="form-group">
    											<label for="txtempdirenrom">Numero:</label>
    											<input type="text" name="txtempdirenrom" id="txtempdirenrom" value="<?php echo $emp->legempleado_direcnro; ?>" class="form-control" disabled>
    										</div>
    									</div>
    									<div class="col-md-3">
    										<div class="form-group">
    											<label for="txtempdirecpisom">Piso:</label>
    											<input type="text" name="txtempdirecpisom" id="txtempdirecpisom" value="<?php echo $emp->legempleado_direcpiso; ?>" class="form-control" disabled>
    										</div>
    									</div>
    									<div class="col-md-3">
    										<div class="form-group">
    											<label for="txtempcpostalm">Codigo Postal:</label>
    											<input type="text" name="txtempcpostalm" id="txtempcpostalm" value="<?php echo $emp->legempleado_codpostal; ?>" class="form-control" disabled>
    										</div>
    									</div>
                      <div class="col-md-3">
    										<div class="form-group">
    											<label for="cboemppaism">Pais:</label>
    											<select name="cboemppaism" id="cboemppaism" class="custom-select form-control" disabled>
    												<option></option>
    													<?php foreach($this->model->Paises() as $row): ?>
    															<option value="<?php echo $row->pais_id; ?>"<?php if (!(strcmp($row->pais_id, $emp->pais_id))) {echo "selected=\"selected\"";} ?>><?php echo $row->pais_nombre; ?></option>
    												<?php endforeach; ?>
    											</select>
    										</div>
    									</div>
    									<div class="col-md-3">
    										<div class="form-group">
    											<label for="cboempprovinciam">Provincia:</label>
    											<select name="cboempprovinciam" id="cboempprovinciam" class="custom-select form-control" disabled>
    												<option value=""></option>
    											</select>
    										</div>
    									</div>
    									<div class="col-md-3">
    										<div class="form-group">
    											<label for="cboempdepartamentom">Departamento:</label>
    											<select name="cboempdepartamentom" id="cboempdepartamentom" class="custom-select form-control" disabled>
    												<option></option>
    											</select>
    										</div>
    									</div>
    									<div class="col-md-3">
    										<div class="form-group">
    											<label for="cboemplocalidadm">Localidad:</label>
    											<select name="cboemplocalidadm" id="cboemplocalidadm" class="custom-select form-control" disabled>
    												<option></option>
    											</select>
    										</div>
    									</div>
    								</div>
                    <?php
                  }
                ?>
                <!--//////////Final formulario empleado - datos de domicilio///////// -->
                <?php
                  if(empty($emp->legempleado_celular) AND empty($emp->legempleado_telefono) AND empty($emp->legempleado_email)){
                    //--- no existen datos de contacto
                  }else{
                    ?>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <div align="right">
                            <button type="button"
                                    class="btn btn-primary"
                                    data-toggle="modal"
                                    data-target="#EmpleadoEditarContacto"
                                    data-titulo="Editar Datos de Contacto"
                                    data-empid="<?php echo $emp->legempleado_id; ?>"
                                    data-empnrodocto="<?php echo $emp->legempleado_nrodocto; ?>"
                                    data-empcelular="<?php echo $emp->legempleado_celular; ?>"
                                    data-emptelefono="<?php echo $emp->legempleado_telefono; ?>"
                                    data-empemail="<?php  echo $emp->legempleado_email; ?>">
                                    <!--<i class="fa fa-vcard-o" aria-hidden="true"></i>-->
                                    <i class="icon-copy ion-social-whatsapp-outline"></i> Editar Datos de Contacto
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="txtempcelularm">Celular:</label>
                          <input type="number" name="txtempcelularm" id="txtempcelularm" value="<?php echo $emp->legempleado_celular; ?>" class="form-control" disabled>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="txtemptelefonom">Telefono :</label>
                          <input type="number" name="txtemptelefonom" id="txtemptelefonom" value="<?php echo $emp->legempleado_telefono; ?>" class="form-control" disabled>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="txtempemailm">Email:</label>
                          <input type="email" name="txtempemailm" id="txtempemailm" class="form-control" value="<?php echo $emp->legempleado_email; ?>" disabled>
                        </div>
                      </div>
                    </div>
                    <?php
                  }
                ?>
							</section>
							<!-- Step 2 -->
							<h5>Situación de Revista</h5>
							<section>
                <?php
                  $tipolegajo = $emp->legtipo_id;
                  //---- Preguntar que tipo de legajo es --
                  if($tipolegajo == 0){
                    //---Ninguno
                    ?>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <div align="right">
                            <!-- Boton AGREGAR Contratado -->
                            <button type="button"
                                    class="btn btn-success"
                                    data-toggle="modal"
                                    data-target="#dataAddContrato"
                                    data-titulo="<?php echo "Alta de Contrato: "; ?>"
                                    data-empnrodocto="<?php echo $emp->legempleado_nrodocto; ?>"
                                    data-empid="<?php echo $emp->legempleado_id; ?>">AGREGAR Contrato
                            </button>
                            <!-- Boton AGREGAR Proveedor -->
                            <button type="button"
                                    class="btn btn-success"
                                    data-toggle="modal"
                                    data-target="#dataAddProveedor"
                                    data-titulo="<?php echo "Alta de Proveedor: "; ?>"
                                    data-empnrodocto="<?php echo $emp->legempleado_nrodocto; ?>"
                                    data-empid="<?php echo $emp->legempleado_id; ?>">AGREGAR Proveedor
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php
                  }elseif($tipolegajo == 1){
                    //---Contratado ---
                    date_default_timezone_set("America/Buenos_Aires");
                    $date = new DateTime(date("Y-m-d"));
                    $fecha_actual = $date->format('Y-m-d');
                    //--- Preguntar si el contrato esta vencido ---
                    if($fecha_actual > $legcontrato->legcontrato_fecfin){
                      //--- Contrato Vencido---
                      //---Incio pregunta dependencia
                      if($legcontrato->legcontrato_id != 0){
                        ?>
                          <div class="row">
      					            <div class="col-md-12">
      												<div class="form-group">
      													<div align="right">
                                  <button type="button"
                                          class="btn btn-outline-success"
                                          data-toggle="modal"
                                          data-target="#dataUpdateContratoI"
                                          data-titulo="<?php echo "Renovacion de Contrato: "; ?>"
                                          data-empnrodocto="<?php echo $emp->legempleado_nrodocto; ?>"
                                          data-empidactind="<?php echo $emp->legempleado_id; ?>"
                                          data-lcontidactind="<?php echo $legcontrato->legcontrato_id; ?>"
                                          data-tlegajo="<?php echo $emp->legtipo_id; ?>"
                                          data-fecinicio="<?php echo $contratodatos->legcontrato_fecinicio; ?>"
                                          data-fecfinalizacion="<?php echo $contratodatos->legcontrato_fecfin; ?>"
                                          data-contratosec="<?php echo $contratodatos->secretaria_id; ?>"
                                          data-contimputacion="<?php echo $contratodatos->imputacion_id; ?>"

                                          data-contdependencia="<?php echo $contratodatos->impdependencia_id; ?>"

                                          data-contactividad="<?php echo $contratodatos->impactividad_id; ?>"
                                          data-imputacion="<?php echo $contratodatos->imputacion_id."-".$contratodatos->impdependencia_id; ?>"
                                          data-secretaria="<?php echo $contratodatos->secretaria_id."-".$contratodatos->trabajo_id; ?>"
                                          data-conttarea="<?php echo $contratodatos->legcontrato_tarea; ?>"
                                          data-contltrabajo="<?php echo $contratodatos->trabajo_id; ?>"
                                          data-contsbasicoind="<?php echo $legcontrato->legcontrato_sbasico; ?>"
                                          data-nrosdocto="<?php echo $nrodoctosact; ?>">RENOVAR Contrato
                                  </button>
                                </div>
                              </div>
                            </div>
                          </div>
                        <?php
                      }else{
                        ?>
                        <div align="center"><h1>Error, Falta Dependencia</h1></div>
                        <?php
                      }
                      //--- fin pregunta dependencia
                    }else{
                      //--- Contrato Vigente
                      ?>
                        <div class="row">
  						            <div class="col-md-12">
  													<div class="form-group">
  														<div align="right">
                                <?php

                                $fechacontratoinicio = new DateTime($legcontrato->legcontrato_fecinicio);
                                $fechacontratofinal = new DateTime($legcontrato->legcontrato_fecfin);

                                $interval = $fechacontratoinicio->diff($date);
                                $diaspasados =  $interval->format('%a');
                                //---- Preguntar si esta disponible para editar ----
                                if($diaspasados < 198){
                                  //---- Contrato habilitado para editar
                                  ?>
                                    <button type="button"
                                            class="btn btn-primary"
                                            data-toggle="modal"
                                            data-target="#dataAddContrato"
                                            data-titulo="<?php echo "Alta de Contrato: "; ?>"
                                            data-empnrodocto="<?php echo $emp->legempleado_nrodocto; ?>"
                                            data-empid="<?php echo $emp->legempleado_id; ?>"
                                            data-lcontid="<?php echo $legcontrato->legcontrato_id; ?>"
                                            data-tlegajo="<?php echo $emp->legtipo_id; ?>"
                                            data-fecinicio="<?php echo $legcontrato->legcontrato_fecinicio; ?>"
                                            data-fecfinalizacion="<?php echo $legcontrato->legcontrato_fecfin; ?>"
                                            data-contratosec="<?php echo $legcontrato->secretaria_id; ?>"
                                            data-contimputacion="<?php echo $legcontrato->imputacion_id; ?>"
                                            data-contdependencia="<?php echo $legcontrato->impdependencia_id; ?>"
                                            data-imputacion="<?php echo $legcontrato->imputacion_id."-".$legcontrato->impdependencia_id; ?>"
                                            data-secretaria="<?php echo $legcontrato->secretaria_id."-".$legcontrato->trabajo_id; ?>"
                                            data-conttarea="<?php echo $legcontrato->legcontrato_tarea; ?>"
                                            data-contltrabajo="<?php echo $legcontrato->trabajo_id; ?>"
                                            data-modelocontrato="<?php echo $legcontrato->contrato_modelo_id; ?>"
                                            data-contsbasico="<?php echo $legcontrato->legcontrato_sbasico; ?>">Editar
                                    </button>
                                  <?php
                                }else{
                                  //---- Contrato No habilitado para editar
                                }
                                ?>
                                <a class="btn btn-danger" href="?c=empleado&a=ImprimirContratoI&id=<?php echo $emp->legempleado_nrodocto; ?>">Descargar Contrato</a>
                              </div>
                            </div>
                          </div>
                        </div>
                      <?php
                    }
                    //---- Datos de Contrato ----
                    //---Incio pregunta dependencia
                    if($legcontrato->legcontrato_id != 0){
                      ?>
                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="empcomtipo">Tipo de Legajo :</label>
                              <select name="empcomtipo" id="empcomtipo" class="custom-select form-control" disabled>
                                <option></option>
                                  <?php foreach($this->model->TiposLegajos() as $row): ?>
                                      <option value="<?php echo $row->legtipo_id; ?>"<?php if (!(strcmp($row->legtipo_id, $emp->legtipo_id))) {echo "selected=\"selected\"";} ?>><?php echo $row->legtipo_nombre; ?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>
                          </div>
                          <!--
                          <div class="col-md-1">
                            <div class="form-group">
                              <label for="empcategoria">CAT :</label>
                              <input type="text" name="empcategoria" id="empcategoria" value="<?php //echo $legcontrato->legcontrato_categoria; ?>" class="form-control" disabled>
                            </div>
                          </div>
                          -->
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="empfecinicio">Fecha de Inicio :</label>
                              <input type="date" name="empfecinicio" id="empfecinicio" value="<?php echo $legcontrato->legcontrato_fecinicio; ?>" class="form-control" disabled>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="empfecfin">Fecha de Fin :</label>
                              <input type="date" name="empfecfin" id="empfecfin" value="<?php echo $legcontrato->legcontrato_fecfin; ?>" class="form-control" disabled>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="empsecretaria">Secretaria :</label>
                              <select name="empsecretaria" id="empsecretaria" class="custom-select form-control" disabled>
                                <option></option>
                                  <?php foreach($this->model->Secretarias() as $row): ?>
                                      <option value="<?php echo $row->secretaria_id; ?>"<?php if (!(strcmp($row->secretaria_id, $legcontrato->secretaria_id))) {echo "selected=\"selected\"";} ?>><?php echo $row->secretaria_nombre; ?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="empimputacion">Imputacion :</label>
                              <select name="empimputacion" id="empimputacion" class="custom-select form-control" disabled>
                                <option></option>
                                  <?php foreach($this->model->ListarImputaciones() as $row): ?>
                                      <option value="<?php echo $row->imputacion_id; ?>"<?php if (!(strcmp($row->imputacion_id, $legcontrato->imputacion_id))) {echo "selected=\"selected\"";} ?>><?php echo $row->imputacion_codigow." ".$row->imputacion_nombre; ?></option>
                                  <?php endforeach; ?>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="empimpdependencia">Dependencia:</label>
                              <input type="text" name="empimpdependencia" id="empimpdependencia" value="<?php echo $legcontrato->impdependencia_nombre; ?>" class="form-control" disabled>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="empltrabajo">Lugar de Trabajo :</label>
                              <select name="empltrabajo" id="empltrabajo" class="custom-select form-control" disabled>
                                <option></option>
                                  <?php foreach($this->model->LugaresTrabajo() as $row): ?>
                                      <option value="<?php echo $row->trabajo_id; ?>"<?php if (!(strcmp($row->trabajo_id, $legcontrato->trabajo_id))) {echo "selected=\"selected\"";} ?>><?php echo $row->trabajo_nombre; ?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="emptarea">Tarea :</label>
                              <input type="text" name="emptarea" id="emptarea" value="<?php echo $legcontrato->legcontrato_tarea; ?>" class="form-control" disabled>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="emptarea">Modelo de contrato :</label>
                              <select name="emplcontratomodelo" id="emplcontratomodelo" class="custom-select from-control" disabled>
                              <?php foreach($this->model->ListarModeloContrato() as $row): ?>
                                <option value="<?php echo $row->contrato_modelo_id; ?>"<?php if (!(strcmp($row->contrato_modelo_id, $legcontrato->contrato_modelo_id))) {echo "selected=\"selected\"";} ?>><?php echo $row->contrato_modelonombre; ?></option>
                                        
                                <?php endforeach; ?>
                              </select>
                              
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="empbasico">Sueldo Basico <strong>$</strong> :</label>
                              <div class="input-group mb-3">
                                <!--
                                <div class="input-group-prepend">
                                  <span class="badge badge-secondary"><h4>$</h4></span>
                                </div>
                                -->
                                <input type="text" name="empbasico" id="empbasico" value="<?php echo $legcontrato->legcontrato_sbasico; ?>" class="form-control" disabled>
                              </div>
                            </div>
                          </div>
                        </div>
                      <?php
                    }else{
                      //---- Falta dependencia
                    }
                    //---Fin pregunta dependencia
                  }elseif($tipolegajo == 2){
                    //---Jornalero ---
                    //---Obtner datos Jornalero
                    $legjornalero = $this->model->ObtenerJornalero($nrodocto);
                    //echo var_dump($legjornalero);
                    ?>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <div align="right">
                            <button type="button"
                                    class="btn btn-primary"
                                    data-toggle="modal"
                                    data-target="#dataUpdateJornalero"
                                    data-titulo="<?php echo "Editar Jornalero: "; ?>"
                                    data-empnrodocto="<?php echo $emp->legempleado_nrodocto; ?>"
                                    data-empid="<?php echo $emp->legempleado_id; ?>"
                                    data-idjor="<?php echo $legjornalero->legjornalero_id; ?>"
                                    data-legtipojor="<?php echo $emp->legtipo_id; ?>"
                                    data-secretariajornalero="<?php echo $legjornalero->secretaria_id; ?>"
                                    data-imputacionjor="<?php echo $legjornalero->imputacion_id; ?>"
                                    data-ltrabajojor="<?php echo $legjornalero->trabajo_id; ?>"
                                    data-tareajor="<?php echo $legjornalero->legjornalero_tarea; ?>"
                                    data-sbasicojor="<?php echo ""; ?>"
                                    data-fecantiguedadjor="<?php echo $legjornalero->legjornalero_fecantiguedad; ?>">Editar Jornalero
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="empcomtipo">Tipo de Legajo :</label>
                          <select name="empcomtipo" id="empcomtipo" class="custom-select form-control" disabled>
                            <option></option>
                              <?php foreach($this->model->TiposLegajos() as $row): ?>
                                  <option value="<?php echo $row->legtipo_id; ?>"<?php if (!(strcmp($row->legtipo_id, $emp->legtipo_id))) {echo "selected=\"selected\"";} ?>><?php echo $row->legtipo_nombre; ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="empjorsecretaria">Secretaria :</label>
                          <select name="empjorsecretaria" id="empjorsecretaria" class="custom-select form-control" disabled>
                            <option></option>
                              <?php foreach($this->model->Secretarias() as $row): ?>
                                  <option value="<?php echo $row->secretaria_id; ?>"<?php if (!(strcmp($row->secretaria_id, $legjornalero->secretaria_id))) {echo "selected=\"selected\"";} ?>><?php echo $row->secretaria_nombre; ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="empimputacion">Imputacion :</label>
                          <select name="empimputacion" id="empimputacion" class="custom-select form-control" disabled>
                            <option></option>
                              <?php foreach($this->model->ListarImputaciones() as $row): ?>
                                  <option value="<?php echo $row->imputacion_id; ?>"<?php if (!(strcmp($row->imputacion_id, $legjornalero->imputacion_id))) {echo "selected=\"selected\"";} ?>><?php echo $row->imputacion_codigow." ".$row->imputacion_nombre; ?></option>
                              <?php endforeach; ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="empltrabajo">Lugar de Trabajo :</label>
                          <select name="empltrabajo" id="empltrabajo" class="custom-select form-control" disabled>
                            <option></option>
                              <?php foreach($this->model->LugaresTrabajo() as $row): ?>
                                  <option value="<?php echo $row->trabajo_id; ?>"<?php if (!(strcmp($row->trabajo_id, $legjornalero->trabajo_id))) {echo "selected=\"selected\"";} ?>><?php echo $row->trabajo_nombre; ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="emptarea">Tarea :</label>
                          <input type="text" name="emptarea" id="emptarea" value="<?php echo $legjornalero->legjornalero_tarea; ?>" class="form-control" disabled>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="empbasico">Sueldo Basico <strong>$</strong> :</label>
                          <div class="input-group mb-3">
                            <input type="text" name="empbasico" id="empbasico" value="" class="form-control" disabled>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="txtfecantiguedadpp">Fecha de Antigüedad :</label>
                          <div class="input-group mb-3">
                            <input type="date" name="txtfecantiguedadpp" id="txtfecantiguedadpp" value="<?php echo $legjornalero->legjornalero_fecantiguedad; ?>" class="form-control" disabled>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php
                  }elseif($tipolegajo == 3){
                    //---Planta Permante ---
                    //--- Obtener datos de contrato
                    $legppermanente = $this->model->ObtenerPPermanente($nrodocto);
                    ?>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <div align="right">
                            <button type="button"
                                    class="btn btn-primary"
                                    data-toggle="modal"
                                    data-target="#dataUpdatePPermanente"
                                    data-titulo="<?php echo "Editar Planta Permanente: "; ?>"
                                    data-empnrodocto="<?php echo $emp->legempleado_nrodocto; ?>"
                                    data-empid="<?php echo $emp->legempleado_id; ?>"
                                    data-idpp="<?php echo $legppermanente->legppermanente_id; ?>"
                                    data-legtipopp="<?php echo $emp->legtipo_id; ?>"
                                    data-categoriapp="<?php echo $legppermanente->legppermanente_categoria; ?>"
                                    data-secretariapp="<?php echo $legppermanente->secretaria_id; ?>"
                                    data-imputacionpp="<?php echo $legppermanente->imputacion_id; ?>"
                                    data-ltrabajopp="<?php echo $legppermanente->trabajo_id; ?>"
                                    data-tareapp="<?php echo $legppermanente->legppermanente_tarea; ?>"
                                    data-sbasicopp="<?php echo ""; ?>"
                                    data-fecantiguedadpp="<?php echo $legppermanente->legppermanente_fecantiguedad; ?>">Editar Planta Permanente
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="empcomtipo">Tipo de Legajo :</label>
                          <select name="empcomtipo" id="empcomtipo" class="custom-select form-control" disabled>
                            <option></option>
                              <?php foreach($this->model->TiposLegajos() as $row): ?>
                                  <option value="<?php echo $row->legtipo_id; ?>"<?php if (!(strcmp($row->legtipo_id, $emp->legtipo_id))) {echo "selected=\"selected\"";} ?>><?php echo $row->legtipo_nombre; ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="emptarea">Categoria :</label>
                          <input type="text" name="emptarea" id="emptarea" value="<?php echo $legppermanente->legppermanente_categoria; ?>" class="form-control" disabled>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="empsecretaria">Secretaria :</label>
                          <select name="empsecretaria" id="empsecretaria" class="custom-select form-control" disabled>
                            <option></option>
                              <?php foreach($this->model->Secretarias() as $row): ?>
                                  <option value="<?php echo $row->secretaria_id; ?>"<?php if (!(strcmp($row->secretaria_id, $legppermanente->secretaria_id))) {echo "selected=\"selected\"";} ?>><?php echo $row->secretaria_nombre; ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="empimputacion">Imputacion :</label>
                          <select name="empimputacion" id="empimputacion" class="custom-select form-control" disabled>
                            <option></option>
                              <?php foreach($this->model->ListarImputaciones() as $row): ?>
                                  <option value="<?php echo $row->imputacion_id; ?>"<?php if (!(strcmp($row->imputacion_id, $legppermanente->imputacion_id))) {echo "selected=\"selected\"";} ?>><?php echo $row->imputacion_codigow." ".$row->imputacion_nombre; ?></option>
                              <?php endforeach; ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="empltrabajo">Lugar de Trabajo :</label>
                          <select name="empltrabajo" id="empltrabajo" class="custom-select form-control" disabled>
                            <option></option>
                              <?php foreach($this->model->LugaresTrabajo() as $row): ?>
                                  <option value="<?php echo $row->trabajo_id; ?>"<?php if (!(strcmp($row->trabajo_id, $legppermanente->trabajo_id))) {echo "selected=\"selected\"";} ?>><?php echo $row->trabajo_nombre; ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="emptarea">Tarea :</label>
                          <input type="text" name="emptarea" id="emptarea" value="<?php echo $legppermanente->legppermanente_tarea; ?>" class="form-control" disabled>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="empbasico">Sueldo Basico <strong>$</strong> :</label>
                          <div class="input-group mb-3">
                            <input type="text" name="empbasico" id="empbasico" value="" class="form-control" disabled>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="txtfecantiguedadpp">Fecha de Antigüedad :</label>
                          <div class="input-group mb-3">
                            <input type="date" name="txtfecantiguedadpp" id="txtfecantiguedadpp" value="<?php echo $legppermanente->legppermanente_fecantiguedad; ?>" class="form-control" disabled>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php
                  }elseif($tipolegajo == 4){
                    //---Proveedores ---
                    //--- Obtener datos de proveedor
                    $legproveedor = $this->model->ObtenerProveedor($nrodocto);

                    date_default_timezone_set("America/Buenos_Aires");
                    $date = new DateTime(date("Y-m-d"));
                    $fecha_actual = $date->format('Y-m-d');
                    //--- Preguntar si el contrato esta vencido ---
                    if($fecha_actual > $legproveedor->legproveedor_fecfin){
                      //--- Contrato Vencido---
                        ?>
                          <div class="row">
      					            <div class="col-md-12">
      												<div class="form-group">
      													<div align="right">
                                  <button type="button"
                                          class="btn btn-outline-success"
                                          data-toggle="modal"
                                          data-target="#dataUpdateProveedorI"
                                          data-titulo="<?php echo "Renovacion Contrato Proveedor "; ?>"
                                          data-empid="<?php echo $emp->legempleado_id; ?>"
                                          data-empnrodocto="<?php echo $emp->legempleado_nrodocto; ?>"
                                          data-procontratoid="<?php echo $legproveedor->legproveedor_id; ?>"
                                          data-profecinicio="<?php echo $legproveedor->legproveedor_fecinicio; ?>"
                                          data-profecfinal="<?php echo $legproveedor->legproveedor_fecfin; ?>"
                                          data-prosecretaria="<?php echo $legproveedor->secretaria_id; ?>"
                                          data-proltrabajo="<?php echo $legproveedor->trabajo_id; ?>"
                                          data-protarea="<?php echo $legproveedor->legproveedor_tarea; ?>"
                                          data-prosbasico="<?php echo $legproveedor->legproveedor_sbasico; ?>"
                                          data-pronrosdocto="<?php echo $nrodoctosact; ?>">RENOVAR Contrato Proveedor
                                  </button>
                                </div>
                              </div>
                            </div>
                          </div>
                        <?php

                    }else{
                      //--- Contrato Vigente
                      ?>
                        <div class="row">
  						            <div class="col-md-12">
  													<div class="form-group">
  														<div align="right">
                                <?php

                                $fechaproveedorinicio = new DateTime($legproveedor->legproveedor_fecinicio);
                                $fechaproveedorfinal = new DateTime($legproveedor->legproveedor_fecfin);

                                $interval = $fechaproveedorinicio->diff($date);
                                $diaspasados =  $interval->format('%a');
                                //---- Preguntar si esta disponible para editar ----
                                if($diaspasados < 198){
                                  //---- Contrato habilitado para editar
                                  ?>
                                    <button type="button"
                                            class="btn btn-primary"
                                            data-toggle="modal"
                                            data-target="#dataAddProveedor"
                                            data-titulo="<?php echo "Edicion de Proveedor: "; ?>"
                                            data-empid="<?php echo $emp->legempleado_id; ?>"
                                            data-empnrodocto="<?php echo $emp->legempleado_nrodocto; ?>"
                                            data-procontid="<?php echo $legproveedor->legproveedor_id; ?>"
                                            data-profecinicio="<?php echo $legproveedor->legproveedor_fecinicio; ?>"
                                            data-profecfinal="<?php echo $legproveedor->legproveedor_fecfin; ?>"
                                            data-prosecretaria="<?php echo $legproveedor->secretaria_id; ?>"
                                            data-proltrabajo="<?php echo $legproveedor->trabajo_id; ?>"
                                            data-contmodelo="<?php echo $legproveedor->contrato_modelo_id; ?>"
                                            data-protarea="<?php echo $legproveedor->legproveedor_tarea; ?>"
                                            data-prosbasico="<?php echo $legproveedor->legproveedor_sbasico; ?>">EDITAR Proveedor
                                    </button>
                                  <?php
                                }else{
                                  //---- Contrato No habilitado para editar
                                }
                                ?>
                                <a class="btn btn-danger" href="?c=empleado&a=ImprimirProveedorI&id=<?php echo $emp->legempleado_nrodocto; ?>">DESCARGAR Contrato Proveedor</a>
                              </div>
                            </div>
                          </div>
                        </div>
                      <?php
                    }
                    //---- Datos de Contrato ----
                      ?>
                        <div class="row">
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="empcomtipo">Tipo de Legajo :</label>
                              <select name="empcomtipo" id="empcomtipo" class="custom-select form-control" disabled>
                                <option></option>
                                  <?php foreach($this->model->TiposLegajos() as $row): ?>
                                      <option value="<?php echo $row->legtipo_id; ?>"<?php if (!(strcmp($row->legtipo_id, $emp->legtipo_id))) {echo "selected=\"selected\"";} ?>><?php echo $row->legtipo_nombre; ?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="empcomtipo">Modelo de Contrato :</label>
                              <select name="empcomtipo" id="empcomtipo" class="custom-select form-control" disabled>
                                <option></option>
                                  <?php foreach($this->model->TiposLegajos() as $row): ?>
                                      <option value="<?php echo $row->legtipo_id; ?>"<?php if (!(strcmp($row->legtipo_id, $emp->legtipo_id))) {echo "selected=\"selected\"";} ?>><?php echo $row->legtipo_nombre; ?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="empfecinicio">Fecha de Inicio :</label>
                              <input type="date" name="empfecinicio" id="empfecinicio" value="<?php echo $legproveedor->legproveedor_fecinicio; ?>" class="form-control" disabled>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="empfecfin">Fecha de Fin :</label>
                              <input type="date" name="empfecfin" id="empfecfin" value="<?php echo $legproveedor->legproveedor_fecfin; ?>" class="form-control" disabled>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="empsecretaria">Secretaria :</label>
                              <select name="empsecretaria" id="empsecretaria" class="custom-select form-control" style="font-size: 13px;" disabled>
                                <option></option>
                                  <?php foreach($this->model->Secretarias() as $row): ?>
                                      <option value="<?php echo $row->secretaria_id; ?>"<?php if (!(strcmp($row->secretaria_id, $legproveedor->secretaria_id))) {echo "selected=\"selected\"";} ?>><?php echo $row->secretaria_nombre; ?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="empltrabajo">Lugar de Trabajo :</label>
                              <select name="empltrabajo" id="empltrabajo" class="custom-select form-control" disabled>
                                <option></option>
                                  <?php foreach($this->model->LugaresTrabajo() as $row): ?>
                                      <option value="<?php echo $row->trabajo_id; ?>"<?php if (!(strcmp($row->trabajo_id, $legproveedor->trabajo_id))) {echo "selected=\"selected\"";} ?>><?php echo $row->trabajo_nombre; ?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="emptarea">Tarea :</label>
                              <input type="text" name="emptarea" id="emptarea" value="<?php echo $legproveedor->legproveedor_tarea; ?>" class="form-control" disabled>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="empbasico">Sueldo Basico <strong>$</strong> :</label>
                              <div class="input-group mb-3">
                                <input type="text" name="empbasico" id="empbasico" value="<?php echo $legproveedor->legproveedor_sbasico; ?>" class="form-control" disabled>
                              </div>
                            </div>
                          </div>
                                    
                        </div>
                        <div class="row">
                          <div class="col-xs-6 col-sm-6">
                             <div class="form-group">
                               <label for="cbomodelocontrato" class="control-label">Modelo de contrato:</label>
                               <select name="cbomodelocontrato" id="cbomodelocontrato" class="custom-select form-control" disabled>
                                <option value="">--SELECCIONE--</option>
                                  <?php foreach($this->model->ListarModeloContrato() as $row): ?>
                                    <option value="<?php echo $row->contrato_modelo_id; ?>"<?php if (!(strcmp($row->contrato_modelo_id, $legproveedor->contrato_modelo_id))) {echo "selected=\"selected\"";} ?>><?php echo $row->contrato_modelonombre; ?></option>
                              <?php endforeach; ?>
                  
                                 </select>
                          </div>
          </div>
        </div>
                        
                      <?php
                  }elseif($tipolegajo == 5){
                    //---Funcionarios
                  }elseif($tipolegajo == 6){
                    //---Concejo deliberante ---
                  }else{
                    //--- Error
                  }
                ?>
							</section>
							<!-- Step 3 -->
							<h5>Estudios</h5>
							<section>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<div align="right">
												<button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#dataUpdateEstudio" data-titulo="<?php echo "Editar Curso / Carrera"; ?>" data-relojid="<?php echo $emp->reloj_id; ?>" data-accessid="<?php echo $emp->access_id; ?>" data-semanal="<?php echo $emp->legreloj_semanal; ?>" data-empnrodocto="<?php echo $emp->legempleado_nrodocto; ?>" data-empid="<?php echo $emp->legempleado_id; ?>"><i class="fi-clipboard-pencil fa-2x" aria-hidden="true"></i><i class="ion-plus-round"></i></button>
											</div>
										</div>
									</div>
									<!--
									<div class="col-md-12">
										<div class="form-group">
											<div class="alert-reloj alert alert-success alert-dismissible fade show" role="alert">
  											<strong>Bien hecho!</strong> Transacción realizada con exito.
  											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    										<span aria-hidden="true">&times;</span>
  											</button>
											</div>
										</div>
									</div>
									-->
									<div class="col-md-12">
										<div class="form-group">
											<table class="resp3">
										    <thead>
													<tr>
										        <th scope="col">Escuela / Instituto</th>
														<th scope="col">Nivel</th>
										        <th scope="col">Estado</th>
														<th scope="col">Titulo</th>
														<th width="20%" scope="col">Acciones</th>
										      </tr>
										    </thead>
										    <tbody>
													<?php
														$nrodocto = $emp->legempleado_nrodocto;
														foreach($this->model->ObtenerEstudios($nrodocto) as $row):
													?>
										      <tr>
										        <td>
															<?php	echo $row->escuela_nombre; ?>
														</td>
														<td>
															<?php	echo $row->escnivel_nombre; ?>
														</td>
														<td>
															<?php	echo $row->escestado_nombre; ?>
														</td>
														<td>
															<?php	echo $row->legestudio_titulo; ?>
														</td>
														<td>
															<button type="button" class="btn btn-outline-danger"><i class='fa fa-file-pdf-o fa-1x'></i></button>
															<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dataUpdateEstudio" data-titulo="<?php echo "Nuev@ Curso / Carrera"; ?>" data-id="<?php echo $row->legestudio_id; ?>" data-empid="<?php echo $emp->legempleado_id; ?>" data-empnrodocto="<?php echo $emp->legempleado_nrodocto; ?>" data-estudioesc="<?php echo $row->escuela_id; ?>" data-estudionvl="<?php echo $row->escnivel_id; ?>" data-estudioestado="<?php echo $row->escestado_id; ?>" data-estudiotitulo="<?php echo $row->legestudio_titulo; ?>"><i class='icon-copy fi-pencil'></i></button>
															<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#dataDeleteEstudio" data-id="<?php echo $row->legestudio_id; ?>" data-empid="<?php echo $emp->legempleado_id; ?>"><i class="icon-copy fa fa-trash" aria-hidden="true"></i></button>
														</td>
										      </tr>
												<?php endforeach; ?>
										    </tbody>
										  </table>
										</div>
									</div>
								</div>
							</section>
							<!-- Step 4 -->
							<h5>Marcaciones</h5>
							<section>
							<?php
									$nrodocto = $emp->legempleado_nrodocto;
									$legreloj = $this->model->ObtenerReloj2($nrodocto);
									if(!empty($legreloj->legempleado_nrodocto)){
									?>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<div align="right">

													<button type="button"
                                  class="btn btn-outline-primary"
                                  data-toggle="modal"
                                  data-target="#dataUpdateReloj"
                                  data-titulo="<?php echo "Datos de Reloj: "; ?>"
                                  data-relojid="<?php echo $legreloj->reloj_id; ?>"
                                  data-accessid="<?php echo $legreloj->marcacion_accessid; ?>"
                                  data-semanal="<?php echo $legreloj->legreloj_semanal; ?>"
                                  data-empnrodocto="<?php echo $emp->legempleado_nrodocto; ?>"
                                  data-empid="<?php echo $emp->legempleado_id; ?>">Editar Reloj
                          </button>

                          <a class="btn btn-danger" href="../marcaciones/?c=marcacion&a=ImprimirFichadaLoteI&id=<?php echo $emp->legempleado_nrodocto; ?>">Imprimir Fichadas [PERIODO]</a>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label for="empreloj">Reloj :</label>
												<select name="empreloj" id="empreloj" class="custom-select form-control" disabled>
													<option></option>
														<?php foreach($this->model->Relojes() as $row): ?>
																<option value="<?php echo $row->reloj_id; ?>"<?php if (!(strcmp($row->reloj_id, $legreloj->reloj_id))) {echo "selected=\"selected\"";} ?>><?php echo $row->reloj_nombre; ?></option>
													<?php endforeach; ?>
												</select>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<?php
													$relojid = $legreloj->reloj_id;
													$datoreloj = $this->model->Reloj($relojid);
												?>
												<label for="empreltipo">Tipo :</label>
												<input type="text" name="empreltipo" id="empreltipo" value="<?php echo $datoreloj->relojtipo_nombre; ?>" class="form-control" disabled>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label for="emprelip">IP :</label>
												<input type="text" name="emprelip" id="emprelip" value="<?php echo $datoreloj->reloj_ip; ?>" class="form-control" disabled>
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label for="emprelnodo">Nodo :</label>
												<input type="text" name="emprelnodo" id="emprelnodo" value="<?php echo $datoreloj->reloj_nodo; ?>" class="form-control" disabled>
											</div>
										</div>
									</div>


									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label for="emprelojid">ID :</label>
												<input type="text" name="emprelojid" id="emprelojid" value="<?php echo $legreloj->marcacion_accessid; ?>" class="form-control" disabled>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="emprelsemanal">Semanal? :</label>
												<div class="custom-control custom-checkbox mb-5">
													<input type="checkbox" name="emprelsemanal" id="emprelsemanal" value="1" <?php if($legreloj->legreloj_semanal==1){echo 'checked="checked"';}?> class="custom-control-input" disabled>
													<label class="custom-control-label" for="emprelsemanal"></label>
												</div>
											</div>
									</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<div align="right">
													<button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#dataUpdateFichado" data-titulo="<?php echo "Nueva Marcacion: "; ?>" data-relojid="<?php echo $legreloj->reloj_id; ?>" data-accessidup="<?php echo $legreloj->marcacion_accessid; ?>" data-semanal="<?php echo $legreloj->legreloj_semanal; ?>" data-empnrodocto="<?php echo $emp->legempleado_nrodocto; ?>" data-empid="<?php echo $emp->legempleado_id; ?>">AGREGAR Fichada</button>
												</div>
											</div>
										</div>
										<!--
										<div class="col-md-12">
											<div class="form-group">
												<div class="alert-reloj alert alert-success alert-dismissible fade show" role="alert">
													<strong>Bien hecho!</strong> Transacción realizada con exito.
													<button type="button" class="close" data-dismiss="alert" aria-label="Close">
													<span aria-hidden="true">&times;</span>
													</button>
												</div>
											</div>
										</div>
										-->
										<div class="col-md-12">
											<div class="form-group">
												<table class="resp">
													<thead>
														<tr>
															<th scope="col">Lunes</th>
															<th scope="col">Martes</th>
															<th scope="col">Miercoles</th>
															<th scope="col">Jueves</th>
															<th scope="col">Viernes</th>
															<th scope="col">Sabado</th>
															<th scope="col">Domingo</th>
															<th width="15%" scope="col">Acciones</th>
														</tr>
													</thead>
													<tbody>
														<?php
															$nrodocto = $emp->legempleado_nrodocto;
															foreach($this->model->ObtenerReloj($nrodocto) as $row):
														?>
														<tr>
															<td>
																<?php
																if($row->legreloj_lunes == 0){
																	?>
																		<h6 class="text-orange">No Ficha</h6>
																	<?php
																}else{
																	echo "E[".$row->legreloj_luneshe."] - S[".$row->legreloj_luneshs."]";
																}
																?>
															</td>
															<td>
																<?php
																if($row->legreloj_martes == 0){
																	?>
																		<h6 class="text-orange">No Ficha</h6>
																	<?php
																}else{
																	echo "E[".$row->legreloj_marteshe."] - S[".$row->legreloj_marteshs."]";
																}
																?>
															</td>
															<td>
																<?php
																if($row->legreloj_miercoles == 0){
																	?>
																		<h6 class="text-orange">No Ficha</h6>
																	<?php
																}else{
																	echo "E[".$row->legreloj_miercoleshe."] - S[".$row->legreloj_miercoleshs."]";
																}
																?>
															</td>
															<td>
																<?php
																if($row->legreloj_jueves == 0){
																	?>
																		<h6 class="text-orange">No Ficha</h6>
																	<?php
																}else{
																	echo "E[".$row->legreloj_jueveshe."] - S[".$row->legreloj_jueveshs."]";
																}
																?>
															</td>
															<td>
																<?php
																if($row->legreloj_viernes == 0){
																	?>
																		<h6 class="text-orange">No Ficha</h6>
																	<?php
																}else{
																	echo "E[".$row->legreloj_vierneshe."] - S[".$row->legreloj_vierneshs."]";
																}
																?>
															</td>
															<td>
																<?php
																if($row->legreloj_sabado == 0){
																	?>
																		<h6 class="text-orange">No Ficha</h6>
																	<?php
																}else{
																	echo "E[".$row->legreloj_sabadohe."] - S[".$row->legreloj_sabadohs."]";
																}
																?>
															</td>
															<td>
																<?php
																if($row->legreloj_domingo == 0){
																	?>
																		<h6 class="text-orange">No Ficha</h6>
																	<?php
																}else{
																	echo "E[".$row->legreloj_domingohe."] - S[".$row->legreloj_domingohs."]";
																}
																?>
															</td>
															<td>
																<button type="button"
                                        class="btn btn-primary"
                                        data-toggle="modal"
                                        data-target="#dataUpdateFichado"
                                        data-id="<?php echo $row->legreloj_id; ?>"
                                        data-accessidup="<?php echo $row->marcacion_accessid; ?>"
                                        data-empid="<?php echo $emp->legempleado_id; ?>"
                                        data-titulo="<?php echo "Reloj: ".$row->reloj_nombre.""; ?>"
                                        data-empnrodocto="<?php echo $row->legempleado_nrodocto; ?>"
                                        data-luneshe="<?php echo $row->legreloj_luneshe; ?>"
                                        data-luneshs="<?php echo $row->legreloj_luneshs; ?>"
                                        data-lunes="<?php echo $row->legreloj_lunes; ?>"
                                        data-marteshe="<?php echo $row->legreloj_marteshe; ?>"
                                        data-marteshs="<?php echo $row->legreloj_marteshs; ?>"
                                        data-martes="<?php echo $row->legreloj_martes; ?>"
                                        data-miercoleshe="<?php echo $row->legreloj_miercoleshe; ?>"
                                        data-miercoleshs="<?php echo $row->legreloj_miercoleshs; ?>"
                                        data-miercoles="<?php echo $row->legreloj_miercoles; ?>"
                                        data-jueveshe="<?php echo $row->legreloj_jueveshe; ?>"
                                        data-jueveshs="<?php echo $row->legreloj_jueveshs; ?>"
                                        data-jueves="<?php echo $row->legreloj_jueves; ?>"
                                        data-vierneshe="<?php echo $row->legreloj_vierneshe; ?>" d
                                        ata-vierneshs="<?php echo $row->legreloj_vierneshs; ?>"
                                        data-viernes="<?php echo $row->legreloj_viernes; ?>"
                                        data-sabadohe="<?php echo $row->legreloj_sabadohe; ?>"
                                        data-sabadohs="<?php echo $row->legreloj_sabadohs; ?>"
                                        data-sabado="<?php echo $row->legreloj_sabado; ?>"
                                        data-domingohe="<?php echo $row->legreloj_domingohe; ?>"
                                        data-domingohs="<?php echo $row->legreloj_domingohs; ?>"
                                        data-domingo="<?php echo $row->legreloj_domingo; ?>">
                                        <i class='icon-copy fi-pencil'></i>
                                </button>
																<button type="button"
                                        class="btn btn-danger"
                                        data-toggle="modal"
                                        data-target="#dataDelete"
                                        data-id="<?php echo $row->legreloj_id; ?>"
                                        data-empid="<?php echo $emp->legempleado_id; ?>">
                                        <i class="icon-copy fa fa-trash" aria-hidden="true"></i>
                                </button>
															</td>
														</tr>
													<?php endforeach; ?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<?php
									}else{
										?>
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<div align="right">
														<button type="button"
                                    class="btn btn-outline-primary"
                                    data-toggle="modal"
                                    data-target="#dataAddFichado"
                                    data-titulo="<?php echo "Nueva Marcacion: "; ?>"
                                    data-relojid=""
                                    data-accessid=""
                                    data-semanal=""
                                    data-empnrodocto="<?php echo $emp->legempleado_nrodocto; ?>"
                                    data-empid="<?php echo $emp->legempleado_id; ?>">AGREGAR Fichadas
                            </button>
													</div>
												</div>
											</div>
										</div>
										<?php
									}
							  ?>
							</section>
							<!-- Step 5 -->
							<h5>Conyuge</h5>
							<section>
								<?php
									//-----------Obtener Conyuge -----------------
									$datosconyuge = $this->model->ConyugeObtener($empleadondocto);

									if(empty($datosconyuge->legconyuge_nrodocto)){
                    //----------No existe Conyuge, Aca va el boton AGREGAR--------
                    ?>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <div align="right">
                            <button type="button"
                                    class="btn btn-success"
                                    data-toggle="modal"
                                    data-target="#ConyugeEditarDatosPersonales"
                                    data-titulo="AGREGAR Conyuge"
                                    data-empid="<?php echo $emp->legempleado_id; ?>"
                                    data-empnrodocto="<?php echo $emp->legempleado_nrodocto; ?>"
                                    data-cyeid="<?php echo $datosconyuge->legconyuge_id; ?>"
                                    data-cyeapellido="<?php echo $datosconyuge->legconyuge_apellido; ?>"
                                    data-cyenombres="<?php echo $datosconyuge->legconyuge_nombres; ?>"
                                    data-cyenrodocto="<?php echo $datosconyuge->legconyuge_nrodocto; ?>"
                                    data-cyenrocuil="<?php echo $datosconyuge->legconyuge_nrocuil; ?>"
                                    data-cyesexo="<?php echo $datosconyuge->sexo_id; ?>"
                                    data-cyefecnac="<?php echo $datosconyuge->legconyuge_fecnacto; ?>"
                                    data-cyemovimiento="1">
                                    <i class="fa fa-edit" aria-hidden="true"></i> AGREGAR CONYUGE
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php
                  }else{
                    //---------Existe Conyuge ---------------
										?>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <div align="right">
                            <button type="button"
                                    class="btn btn-danger"
                                    data-toggle="modal"
                                    data-target="#ConyugeBaja"
                                    data-titulo="DAR DE BAJA CONYUGE"
                                    data-empid="<?php echo $emp->legempleado_id; ?>"
                                    data-empnrodocto="<?php echo $emp->legempleado_nrodocto; ?>"
                                    data-cyeid="<?php echo $datosconyuge->legconyuge_id; ?>"
                                    data-cyendoc="<?php echo $datosconyuge->legconyuge_nrodocto; ?>">
                                    <i class="ion-power"></i> DAR DE BAJA
                            </button>
                            <?php
                              if(empty($datosconyuge->legconyuge_celular) AND empty($datosconyuge->legconyuge_telefono) AND empty($datosconyuge->legconyuge_email)){
                                ?>
                                <button type="button"
                                        class="btn btn-success"
                                        data-toggle="modal"
                                        data-target="#ConyugeEditarContacto"
                                        data-titulo="Editar Datos de Contacto"
                                        data-empid="<?php echo $emp->legempleado_id; ?>"
                                        data-empnrodocto="<?php echo $emp->legempleado_nrodocto; ?>"
                                        data-cyeid="<?php echo $datosconyuge->legconyuge_id; ?>"
                                        data-cyecelular="<?php echo $datosconyuge->legconyuge_celular; ?>"
                                        data-cyetelefono="<?php echo $datosconyuge->legconyuge_telefono; ?>"
                                        data-cyeemail="<?php  echo $datosconyuge->legconyuge_email; ?>">
                                        <!--<i class="fa fa-vcard-o" aria-hidden="true"></i>-->
                                        <i class="icon-copy ion-social-whatsapp-outline"></i> AGREGAR Datos de Contacto
                                </button>
                                <?php
                              }
                              if(empty($datosconyuge->legconyuge_direccion)){
                                ?>
                                <button type="button"
                                        class="btn btn-success"
                                        data-toggle="modal"
                                        data-target="#ConyugeEditarDomicilio"
                                        data-titulo="Editar Datos de Domicilio"
                                        data-empid="<?php echo $emp->legempleado_id; ?>"
                                        data-empnrodocto="<?php echo $emp->legempleado_nrodocto; ?>"
                                        data-cyeid="<?php echo $datosconyuge->legconyuge_id; ?>"
                                        data-cyedireccion="<?php echo $datosconyuge->legconyuge_direccion; ?>"
                                        data-cyedirecnro="<?php echo $datosconyuge->legconyuge_direcnro; ?>"
                                        data-cyedirecpiso="<?php echo $datosconyuge->legconyuge_direcpiso; ?>"
                                        data-cyecpostal=""
                                        data-cyepais="<?php echo $datosconyuge->pais_id; ?>"
                                        data-cyeprovincia="<?php echo $datosconyuge->provincia_id; ?>"
                                        data-cyedepartamento="<?php echo $datosconyuge->departamento_id; ?>"
                                        data-cyelocalidad="<?php echo $datosconyuge->localidad_id; ?>">
                                        <i class="ion-ios-home"></i> AGREGAR Datos de Domicilio
                                </button>
                                <?php
                              }
                            ?>
                            <button type="button"
                                    class="btn btn-primary"
                                    data-toggle="modal"
                                    data-target="#ConyugeEditarDatosPersonales"
                                    data-titulo="Editar Datos Personales"
                                    data-empid="<?php echo $emp->legempleado_id; ?>"
                                    data-empnrodocto="<?php echo $emp->legempleado_nrodocto; ?>"
                                    data-cyeid="<?php echo $datosconyuge->legconyuge_id; ?>"
                                    data-cyeapellido="<?php echo $datosconyuge->legconyuge_apellido; ?>"
                                    data-cyenombres="<?php echo $datosconyuge->legconyuge_nombres; ?>"
                                    data-cyenrodocto="<?php echo $datosconyuge->legconyuge_nrodocto; ?>"
                                    data-cyenrocuil="<?php echo $datosconyuge->legconyuge_nrocuil; ?>"
                                    data-cyesexo="<?php echo $datosconyuge->sexo_id; ?>"
                                    data-cyefecnac="<?php echo $datosconyuge->legconyuge_fecnacto; ?>"
                                    data-cyemovimiento="2">
                                    <i class="fa fa-edit" aria-hidden="true"></i> Editar Datos Personales
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="txtcyeapellidom" class="control-label">Apellido :</label>
													<input type="text" name="txtcyeapellidom" id="txtcyeapellidom" value="<?php echo $datosconyuge->legconyuge_apellido; ?>" class="form-control" disabled>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="txtcyenombresm" class="control-label">Nombres :</label>
													<input type="text" name="txtcyenombresm" id="txtcyenombresm" value="<?php echo $datosconyuge->legconyuge_nombres; ?>" class="form-control" disabled>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-3">
												<div class="form-group">
													<label for="txtcyenrodoctom" class="control-label">DNI :</label>
													<input type="number" name="txtcyenrodoctom" id="txtcyenrodoctom" value="<?php echo $datosconyuge->legconyuge_nrodocto; ?>" class="form-control" disabled>
												</div>
											</div>
                      <div class="col-md-3">
												<div class="form-group">
													<label for="txtcyenrocuilm" class="control-label">CUIL :</label>
													<input type="text" name="txtcyenrocuilm" id="txtcyenrocuilm" value="<?php echo $datosconyuge->legconyuge_nrocuil; ?>" class="form-control" disabled>
												</div>
											</div>
                      <div class="col-md-3">
												<div class="form-group">
													<label for="cbocyesexom" class="control-label">Sexo :</label>
													<select name="cbocyesexom" id="cbocyesexom" class="custom-select form-control" disabled>
														<option value="">--Seleccione--</option>
															<?php foreach($this->model->ObtenerSexos() as $row): ?>
																	<option value="<?php echo $row->sexo_id; ?>"<?php if (!(strcmp($row->sexo_id, $datosconyuge->sexo_id))) {echo "selected=\"selected\"";} ?>><?php echo $row->sexo_nombre; ?></option>
														<?php endforeach; ?>
													</select>
												</div>
											</div>
                      <div class="col-md-3">
												<div class="form-group">
													<label for="txtcyefecnactom" class="control-label">Fecha de Nacimiento :</label>
													<input type="date" name="txtcyefecnactom" id="txtcyefecnactom" value="<?php echo $datosconyuge->legconyuge_fecnacto; ?>" class="form-control" placeholder="Select Date" disabled>
												</div>
											</div>
										</div>
                    <hr/>
                    <?php
                    if(!empty($datosconyuge->legconyuge_direccion)){
                      //-------Existe datos de direccion ------
                      ?>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <div align="right">
                              <button type="button"
                                      class="btn btn-primary"
                                      data-toggle="modal"
                                      data-target="#ConyugeEditarDomicilio"
                                      data-titulo="Editar Datos de Domicilio"
                                      data-empid="<?php echo $emp->legempleado_id; ?>"
                                      data-empnrodocto="<?php echo $emp->legempleado_nrodocto; ?>"
                                      data-cyeid="<?php echo $datosconyuge->legconyuge_id; ?>"
                                      data-cyedireccion="<?php echo $datosconyuge->legconyuge_direccion; ?>"
                                      data-cyedirecnro="<?php echo $datosconyuge->legconyuge_direcnro; ?>"
                                      data-cyedirecpiso="<?php echo $datosconyuge->legconyuge_direcpiso; ?>"
                                      data-cyecpostal="<?php echo $datosconyuge->legconyuge_codpostal; ?>"
                                      data-cyepais="<?php echo $datosconyuge->pais_id; ?>"
                                      data-cyeprovincia="<?php echo $datosconyuge->provincia_id; ?>"
                                      data-cyedepartamento="<?php echo $datosconyuge->departamento_id; ?>"
                                      data-cyelocalidad="<?php echo $datosconyuge->localidad_id; ?>">
                                      <i class="ion-ios-home"></i> Editar Datos de Domicilio
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-3">
  												<div class="form-group">
  													<label for="txtcyedireccionm" class="control-label">Direccion :</label>
  													<input type="text" name="txtcyedireccionm" id="txtcyedireccionm" value="<?php echo $datosconyuge->legconyuge_direccion; ?>" class="form-control" disabled>
  												</div>
  											</div>
                        <div class="col-md-3">
  												<div class="form-group">
  													<label for="txtcyedirecnrom" class="control-label">Nro :</label>
  													<input type="text" name="txtcyedirecnrom" id="txtcyedirecnrom" value="<?php echo $datosconyuge->legconyuge_direcnro; ?>" class="form-control" disabled>
  												</div>
  											</div>
  											<div class="col-md-3">
  												<div class="form-group">
  													<label for="txtcyedirecpisom" class="control-label">Piso :</label>
  													<input type="text" name="txtcyedirecpisom" id="txtcyedirecpisom" value="<?php echo $datosconyuge->legconyuge_direcpiso; ?>" class="form-control" disabled>
  												</div>
  											</div>
  											<div class="col-md-3">
  												<div class="form-group">
  													<label for="txtcyecpostalm" class="control-label">Codigo Postal:</label>
  													<input type="text" name="txtcyecpostalm" id="txtcyecpostalm" value="<?php echo $datosconyuge->legconyuge_codpostal; ?>" class="form-control" disabled>
  												</div>
  											</div>
                        <div class="col-md-3">
  												<div class="form-group">
  													<label for="cbocyepaism" class="control-label">Pais :</label>
  													<select name="cbocyepaism" id="cbocyepaism" class="custom-select form-control" disabled>
  														<option value="">--Seleccione--</option>
  															<?php foreach($this->model->Paises() as $row): ?>
  																	<option value="<?php echo $row->pais_id; ?>"<?php if (!(strcmp($row->pais_id, $datosconyuge->pais_id))) {echo "selected=\"selected\"";} ?>><?php echo $row->pais_nombre; ?></option>
  														<?php endforeach; ?>
  													</select>
  												</div>
  											</div>
  											<div class="col-md-3">
  												<div class="form-group">
  													<label for="cbocyeprovinciam" class="control-label">Provincia :</label>
  													<select name="cbocyeprovinciam" id="cbocyeprovinciam" class="custom-select form-control" disabled>
  														<option value="">--Seleccione--</option>
  															<?php foreach($this->model->Provincias() as $row): ?>
  																	<option value="<?php echo $row->provincia_id; ?>"<?php if (!(strcmp($row->provincia_id, $datosconyuge->provincia_id))) {echo "selected=\"selected\"";} ?>><?php echo $row->provincia_nombre; ?></option>
  														<?php endforeach; ?>
  													</select>
  												</div>
  											</div>
  											<div class="col-md-3">
  												<div class="form-group">
  													<label for="cbocyedepartamentom" class="control-label">Departamento :</label>
  													<select name="cbocyedepartamentom" id="cbocyedepartamentom" class="custom-select form-control" disabled>
  														<option value="">--Seleccione--</option>
  															<?php foreach($this->model->departamentos() as $row): ?>
  																	<option value="<?php echo $row->departamento_id; ?>"<?php if (!(strcmp($row->departamento_id, $datosconyuge->departamento_id))) {echo "selected=\"selected\"";} ?>><?php echo $row->departamento_nombre; ?></option>
  														<?php endforeach; ?>
  													</select>
  												</div>
  											</div>
  											<div class="col-md-3">
  												<div class="form-group">
  													<label for="cbocyelocalidadm" class="control-label">Localidad :</label>
  													<select name="cbocyelocalidadm" id="cbocyelocalidadm" class="custom-select form-control" disabled>
  														<option value="">--Seleccione--</option>
  															<?php foreach($this->model->Localidades() as $row): ?>
  																	<option value="<?php echo $row->localidad_id; ?>"<?php if (!(strcmp($row->localidad_id, $datosconyuge->localidad_id))) {echo "selected=\"selected\"";} ?>><?php echo $row->localidad_nombre; ?></option>
  														<?php endforeach; ?>
  													</select>
  												</div>
  											</div>
                      </div>
                      <hr/>
                      <?php
                    }
                    //if(!empty($datosconyuge->legconyuge_direccion)){
                    if(!empty($datosconyuge->legconyuge_celular) OR !empty($datosconyuge->legconyuge_telefono) OR !empty($datosconyuge->legconyuge_email)){
                      //--------------Existen datos de contacto
                      ?>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <div align="right">
                              <button type="button"
                                      class="btn btn-primary"
                                      data-toggle="modal"
                                      data-target="#ConyugeEditarContacto"
                                      data-titulo="Editar Datos de Contacto"
                                      data-empid="<?php echo $emp->legempleado_id; ?>"
                                      data-empnrodocto="<?php echo $emp->legempleado_nrodocto; ?>"
                                      data-cyeid="<?php echo $datosconyuge->legconyuge_id; ?>"
                                      data-cyecelular="<?php echo $datosconyuge->legconyuge_celular; ?>"
                                      data-cyetelefono="<?php echo $datosconyuge->legconyuge_telefono; ?>"
                                      data-cyeemail="<?php  echo $datosconyuge->legconyuge_email; ?>">
                                      <!--<i class="fa fa-vcard-o" aria-hidden="true"></i>-->
                                      <i class="icon-copy ion-social-whatsapp-outline"></i> Editar Datos de Contacto
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
  											<div class="col-md-4">
  												<div class="form-group">
  													<label for="txtcyecelularm" class="control-label">Celular :</label>
  													<input type="text" name="txtcyecelularm" id="txtcyecelularm" value="<?php echo $datosconyuge->legconyuge_celular; ?>" class="form-control" disabled>
  												</div>
  											</div>
  											<div class="col-md-4">
  												<div class="form-group">
  													<label for="txtcyetelefonom" class="control-label">Telefono :</label>
  													<input type="text" name="txtcyetelefonom" id="txtcyetelefonom" value="<?php echo $datosconyuge->legconyuge_telefono; ?>" class="form-control" disabled>
  												</div>
  											</div>
  											<div class="col-md-4">
  												<div class="form-group">
  													<label for="txtcyeemailm" class="control-label">Email :</label>
  													<input type="email" name="txtcyeemailm" id="txtcyeemailm" value="<?php echo $datosconyuge->legconyuge_email; ?>" class="form-control" disabled>
  												</div>
  											</div>
  										</div>
                      <?php
                    }

                  }
                  ?>
							</section>
							<!-- Step 6 -->
							<h5>Hijos</h5>
							<section>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<div align="right">

												<button type="button" class="btn btn-info view_data" data-toggle="modal" data-target="#dataConstanciaHijo" data-id="<?php echo $emp->legempleado_nrodocto; ?>">Constancias ESCOLARES</button>

                        <!-- boton agregar prenatal-->
												<button type="button"
                                class="btn btn-primary"
                                data-toggle="modal"
                                data-target="#dataUpdatePreNatal"
                                data-titulo="<?php echo "Nuevo Pre-Natal"; ?>"
                                data-empid="<?php echo $emp->legempleado_id; ?>"
                                data-empnrodocto="<?php echo $emp->legempleado_nrodocto; ?>"
                                data-bennrodocto="<?php echo $emp->legempleado_nrodocto; ?>">
                                AGREGAR Pre-Natal
                        </button>
                        <!-- boton agregar hijo -->
												<button type="button"
                                class="btn btn-success"
                                data-toggle="modal"
                                data-target="#dataUpdateHijo"
                                data-titulo="<?php echo "Agregar nuevo hijo"; ?>"
                                data-empnrodocto="<?php echo $emp->legempleado_nrodocto; ?>"
                                data-empid="<?php echo $emp->legempleado_id; ?>"
                                data-bennrodocto="<?php echo $emp->legempleado_nrodocto; ?>">
                                AGREGAR Hijo
                        </button>
											</div>
										</div>
									</div>
									<!-- PRE-NATAL -->
									<div class="col-md-12">
										<div class="form-group">
											<?php
												$empleadonrodocto = $emp->legempleado_nrodocto;
												$prenatal = $this->model->ObtenerPreNatal($empleadonrodocto);
												$prenatalc = count($prenatal);
												if($prenatalc > 0){
													?>
													<div class="clearfix">
                            <h5 class="text-blue">
                              <label>
                                Pre-Natal/es
                                <span class="badge badge-pill badge-primary">
                                  <?php echo $prenatalc; ?>
                                </span>
                              </label>
                            </h5>
														<p></p>
													</div>
													<table class="resp2">
														<thead>
															<tr>
																<th scope="col">FUM</th>
																<th scope="col">FPP</th>
																<th scope="col">BENEFICIARIO</th>
																<th width="18%" scope="col">ACCIONES</th>
															</tr>
														</thead>
														<tbody>
															<?php
																foreach($prenatal as $row):
															?>
															<tr>
																<?php
																	$fum = date("d/m/Y", strtotime($row->legprenatal_fecum));
																	$fpp = date("d/m/Y", strtotime($row->legprenatal_fecpp));
																?>
																<td><?php echo $fum; ?></td>
																<td><?php echo $fpp; ?></td>
																<td>
																	<?php echo $row->legprenatal_benndoc." - ".$row->legprenatal_benapellido.", ".$row->legprenatal_bennombres; ?>
																</td>

                                <td style="text-align: right;">
                                  <div class="dropdown">
              											<a class="btn btn-info dropdown-toggle" href="#" role="button" data-toggle="dropdown">
              												Opciones
              											</a>
              											<div class="dropdown-menu dropdown-menu-right">

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
              		                       data-target="#dataViewHijo"
              		                       data-titulo="<?php echo ""; ?>">
                                         <i class="fa fa-eye" style="color: #00b347;"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Ver detalles</em>
              		                    </a>

              												<a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
                                         data-target="#dataUpdatePreNatal"
                                         data-titulo="<?php echo "Editar Pre-Natal: "; ?>"
                                         data-prenid="<?php echo $row->legprenatal_id; ?>"
                                         data-empid="<?php echo $emp->legempleado_id; ?>"
                                         data-empnrodocto="<?php echo $row->legempleado_nrodocto; ?>"
                                         data-bennrodocto="<?php echo $row->legprenatal_benndoc; ?>"
                                         data-prenatalfecum="<?php echo $row->legprenatal_fecum; ?>"
                                         data-prenatalfecpp="<?php echo $row->legprenatal_fecpp; ?>">
                                         <i class="ion-compose fa-lg" style="color: #0000ff;"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Editar Pre-Natal</em>
              		                    </a>

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
                                         data-target="#dataDeletePreNatal"
                                         data-prenid="<?php echo $row->legprenatal_id; ?>"
                                         data-empid="<?php echo $emp->legempleado_id; ?>"
                                         data-empndoc="<?php echo $emp->legempleado_nrodocto; ?>"
                                         data-benndoc="<?php echo $row->legprenatal_benndoc; ?>">
                                         <i class="ion-android-delete fa-lg" style="color: #FF0000"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Eliminar Pre-Natal</em>
              		                    </a>


                                      <?php
                                        if($row->legempleado_nrodocto == $row->legprenatal_benndoc){
                                          //------ mismo beneficiario
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Agregar otro beneficiario"
                                             data-target="#UpdateBeneficiarioPreNatal"
                                             data-titulo="<?php echo "Agregar otro beneficiario" ?>"
                                             data-prenid="<?php echo $row->legprenatal_id; ?>"
                                             data-empid="<?php echo $emp->legempleado_id; ?>"
                                             data-empndoc="<?php echo $emp->legempleado_nrodocto; ?>"
                                             data-benndoc="<?php echo $row->legprenatal_benndoc; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #00b347;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Agregar otro beneficiario</em>
                  		                    </a>
                                          <?php
                                        }else{
                                          //-----distinto beficiario
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Editar datos de otro beneficiario"
                                             data-target="#UpdateBeneficiarioPreNatal"
                                             data-titulo="<?php echo "Editar otro beneficiario"; ?>"
                                             data-prenid="<?php echo $row->legprenatal_id; ?>"
                                             data-empid="<?php echo $emp->legempleado_id; ?>"
                                             data-empndoc="<?php echo $emp->legempleado_nrodocto; ?>"
                                             data-benndoc="<?php echo $row->legprenatal_benndoc; ?>"
                                             data-prenbenndoc="<?php echo $row->legprenatal_benndoc; ?>"
                                             data-prenbennoficio="<?php echo $row->legprenatal_bennoficio; ?>"
                                             data-prenbenapellido="<?php echo $row->legprenatal_benapellido; ?>"
                                             data-prenbennombres="<?php echo $row->legprenatal_bennombres; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Editar otro beneficiario</em>
                  		                    </a>
                                          <?php
                                        }
                                      ?>
                                      <?php
                                      if($row->legprenatal_madrendoc > 0){
                                        //--Existen datos de mop
                                        if($emp->sexo_id == 1){
                                          //empleado masculino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Editar datos de la madre"
                                             data-target="#UpdatemopPreNatal"
                                             data-titulo="<?php echo "Editar datos de la madre"; ?>"
                                             data-prenmopid="<?php echo $row->legprenatal_id; ?>"
                                             data-empmopid="<?php echo $emp->legempleado_id; ?>"
                                             data-prenmopndoc="<?php echo $row->legprenatal_madrendoc; ?>"
                                             data-prenmopapellido="<?php echo $row->legprenatal_madreapellido; ?>"
                                             data-prenmopnombres="<?php echo $row->legprenatal_madrenombres; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Editar datos de la madre</em>
                  		                    </a>
                                          <?php
                                        }else{
                                          //empleado femenino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Editar datos del Padre"
                                             data-target="#UpdatemopPreNatal"
                                             data-titulo="<?php echo "Editar datos del padre"; ?>"
                                             data-prenmopid="<?php echo $row->legprenatal_id; ?>"
                                             data-empmopid="<?php echo $emp->legempleado_id; ?>"
                                             data-prenmopndoc="<?php echo $row->legprenatal_madrendoc; ?>"
                                             data-prenmopapellido="<?php echo $row->legprenatal_madreapellido; ?>"
                                             data-prenmopnombres="<?php echo $row->legprenatal_madrenombres; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Editar datos del padre</em>
                  		                    </a>
                                          <?php
                                        }
                                      }else{
                                        //-- No hay datos de mop
                                        if($emp->sexo_id == 1){
                                          //empleado masculino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Agregar datos de la madre"
                                             data-target="#UpdatemopPreNatal"
                                             data-titulo="<?php echo "Agregar datos de la madre"; ?>"
                                             data-prenmopid="<?php echo $row->legprenatal_id; ?>"
                                             data-empmopid="<?php echo $emp->legempleado_id; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #00b347;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Agregar datos de la madre</em>
                  		                    </a>
                                          <?php
                                        }else{
                                          //empleado femenino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Agregar datos del padre"
                                             data-target="#UpdatemopPreNatal"
                                             data-titulo="<?php echo "Agregar datos del padre"; ?>"
                                             data-prenmopid="<?php echo $row->legprenatal_id; ?>"
                                             data-empmopid="<?php echo $emp->legempleado_id; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Agregar datos del padre</em>
                  		                    </a>
                                          <?php
                                        }
                                      }
                                      ?>
                                      <a href="#"
                                         class="dropdown-item"
                                         data-toggle="modal"
                                         title="Deshabilitar Pre-Natal"
                                         data-target="#dataDisablePreNatal"
                                         data-titulo="<?php echo "Deshabilitar Pre-Natal"; ?>"
                                         data-prenid="<?php echo $row->legprenatal_id; ?>"
                                         data-empid="<?php echo $emp->legempleado_id; ?>"
                                         data-empndoc="<?php echo $emp->legempleado_nrodocto; ?>"
                                         data-benndoc="<?php echo $row->legprenatal_benndoc; ?>">
                                         <i class="fa fa-toggle-off" ></i>
                                         &nbsp;&nbsp;&nbsp;<em>Deshabilitar asignacion</em>
                                      </a>
              											</div>
              										</div>
																</td>
															</tr>
														<?php endforeach; ?>
														</tbody>
													</table>
													<?php
												}else{
													//---- No tiene Pre-Natal -----
												}
											?>
										</div>
									</div>
									<!-- HIJOS MENORES -->
									<div class="col-md-12">
										<div class="form-group">
											<?php
												$empleadonrodocto = $emp->legempleado_nrodocto;
												$fechaactual = date("Y-m-d");
				                //resto 5 años
                        $fechafinal = date("Y-m-d",strtotime($fechaactual."- 6 year"));//resto 5 años
        				        //$fechafinal = date("Y-m-d",strtotime($fechafinaluno."- 1 month"));

												$hijosmenores = $this->model->ObtenerHijosMenores($empleadonrodocto, $fechaactual, $fechafinal);
												$hijosmenoresc = count($hijosmenores);
												if($hijosmenoresc > 0){
													?>
													<div class="clearfix">
														<h5 class="text-blue">
                              <label>
                                Hijo/s menor/es
                                <span class="badge badge-pill badge-primary">
                                  <?php echo $hijosmenoresc; ?>
                                </span>
                              </label>
                            </h5>
														<p></p>
													</div>


													<table class="resp2">
														<thead>
															<tr>
																<th scope="col">DNI</th>
																<th scope="col">APELLIDO Y NOMBRES</th>
																<th scope="col">EDAD</th>
																<th scope="col">BENEFICIARIO</th>
																<th width="18%" scope="col">ACCIONES</th>
															</tr>
														</thead>
														<tbody>
															<?php
																foreach($hijosmenores as $row):
																//$hijodireccion = $row->pais_id."-".$row->provincia_id."-".$row->departamento_id."-".$row->localidad_id;
															?>
															<tr>
																<td>
																	<?php	echo $row->leghijo_nrodocto; ?>
																</td>
																<td>
																	<?php echo $row->leghijo_apellido.", ".$row->leghijo_nombres;	?>
																</td>
																<td>
																	<?php
																	$fechanacimiento = $row->leghijo_fecnacto;
																	$edad = $this->model->CalculaEdad($fechanacimiento);
                                  if($edad > 0){
																	  echo $edad;
                                  }else{
                                    echo "*";
                                  }
																	?>
																</td>
																<td>
																	<?php echo $row->leghijo_benndoc." - ".$row->leghijo_benapellido.", ".$row->leghijo_bennombres; ?>
																</td>
																<td style="text-align: right;">
                                  <div class="dropdown">
              											<a class="btn btn-info dropdown-toggle" href="#" role="button" data-toggle="dropdown">
              												Opciones
              											</a>
              											<div class="dropdown-menu dropdown-menu-right">

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
              		                       data-target="#dataViewHijo"
              		                       data-titulo="<?php echo ""; ?>">
                                         <i class="fa fa-eye" style="color: #00b347;"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Ver detalles</em>
              		                    </a>

              												<a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
                                         data-target="#dataUpdateHijo"
                                         data-titulo="<?php echo "Edicion: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                         data-id="<?php echo $row->leghijo_id; ?>"
                                         data-hijotdoc="<?php echo $row->leghijo_tipodocto; ?>"
                                         data-hijondoc="<?php echo $row->leghijo_nrodocto; ?>"
                                         data-hijoapellido="<?php echo $row->leghijo_apellido; ?>"
                                         data-hijonombres="<?php echo $row->leghijo_nombres; ?>"
                                         data-hijonrocuil="<?php echo $row->leghijo_nrocuil; ?>"
                                         data-hijosexo="<?php echo $row->sexo_id; ?>"
                                         data-hijofecnacto="<?php echo $row->leghijo_fecnacto; ?>"
                                         data-hijodireccion="<?php echo $row->leghijo_direccion; ?>"
                                         data-hijodirecnro="<?php echo $row->leghijo_direcnro; ?>"
                                         data-hijodirecpiso="<?php echo $row->leghijo_direcpiso; ?>"
                                         data-hijocodpostal="<?php echo $row->leghijo_codpostal; ?>"
                                         data-hijoppdl="<?php echo $row->pais_id."-".$row->provincia_id."-".$row->departamento_id."-".$row->localidad_id; ?>"
                                         data-hijopais="<?php echo $row->pais_id; ?>"
                                         data-hijoprovincia="<?php echo $row->provincia_id; ?>"
                                         data-hijodepartamento="<?php echo $row->departamento_id; ?>"
                                         data-hijolocalidad="<?php echo $row->localidad_id; ?>"
                                         data-hijodisc="<?php echo $row->leghijo_disc; ?>"
                                         data-hijoesc="<?php echo $row->leghijo_esc; ?>"
                                         data-hijoescnom="<?php echo $row->escuela_id; ?>"
                                         data-hijoescnvl="<?php echo $row->escnivel_id; ?>"
                                         data-hijoescest="<?php echo $row->escestado_id; ?>"
                                         data-hijomoptdoc="<?php echo $row->leghijo_moptdoc; ?>"
                                         data-hijomopndoc="<?php echo $row->leghijo_mopndoc; ?>"
                                         data-hijomopapellido="<?php echo $row->leghijo_mopapellido; ?>"
                                         data-hijomopnombres="<?php echo $row->leghijo_mopnombres; ?>"
                                         data-hijobentdoc="<?php echo $row->leghijo_bentdoc; ?>"
                                         data-hijobennoficio="<?php echo $row->leghijo_bennoficio; ?>"
                                         data-hijobenndoc="<?php echo $row->leghijo_benndoc; ?>"
                                         data-hijobenapellido="<?php echo $row->leghijo_benapellido; ?>"
                                         data-hijobennombres="<?php echo $row->leghijo_bennombres; ?>"
                                         data-empid="<?php echo $emp->legempleado_id; ?>"
                                         data-empnrodocto="<?php echo $emp->legempleado_nrodocto; ?>"
                                         data-bennrodocto="<?php echo $row->leghijo_benndoc; ?>">
                                         <i class="ion-compose fa-lg" style="color: #0000ff;"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Editar hijo</em>
              		                    </a>

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
                                         data-target="#dataDeleteHijo"
                                         data-id="<?php echo $row->leghijo_id; ?>"
                                         data-empid="<?php echo $emp->legempleado_id; ?>"
                                         data-empndoc="<?php echo $emp->legempleado_nrodocto; ?>"
                                         data-benndoc="<?php echo $row->leghijo_benndoc; ?>">
                                         <i class="ion-android-delete fa-lg" style="color: #FF0000"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Eliminar hijo</em>
              		                    </a>

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
              		                       data-target="#dataUpdateEscuelaHijo"
              		                       data-titulo="<?php echo "Agregar Escuela"; ?>"
                                         data-hijoid="<?php echo $row->leghijo_id; ?>"
                                         data-empid="<?php echo $emp->legempleado_id; ?>"
                                         data-empnrodocto="<?php echo $emp->legempleado_nrodocto; ?>"
                                         data-bennrodocto="<?php echo $row->leghijo_benndoc; ?>">
                                         <span class="ti-home" style="color: #00b347;"></span>
              													 &nbsp;&nbsp;&nbsp;<em>Agregar datos escolares</em>
              		                    </a>


                                      <?php
                                        if($row->legempleado_nrodocto == $row->leghijo_benndoc){
                                          //------ mismo beneficiario
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Agregar otro beneficiario"
                                             data-target="#UpdateBeneficiarioHijo"
                                             data-titulo="<?php echo "Agregar otro beneficiario" ?>"
                                             data-hijoid="<?php echo $row->leghijo_id; ?>"
                                             data-empid="<?php echo $emp->legempleado_id; ?>"
                                             data-empndoc="<?php echo $emp->legempleado_nrodocto; ?>"
                                             data-benndoc="<?php echo $row->leghijo_benndoc; ?>"
                                             data-hbenndoc="<?php echo $row->leghijo_benndoc; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #00b347;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Agregar otro beneficiario</em>
                  		                    </a>
                                          <?php
                                        }else{
                                          //-----distinto beficiario
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Editar datos de otro beneficiario"
                                             data-target="#UpdateBeneficiarioHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijoid="<?php echo $row->leghijo_id; ?>"
                                             data-empid="<?php echo $emp->legempleado_id; ?>"
                                             data-empndoc="<?php echo $emp->legempleado_nrodocto; ?>"
                                             data-benndoc="<?php echo $row->leghijo_benndoc; ?>"
                                             data-hbenndoc="<?php echo $row->leghijo_benndoc; ?>"
                                             data-hbennoficio="<?php echo $row->leghijo_bennoficio; ?>"
                                             data-hbenapellido="<?php echo $row->leghijo_benapellido; ?>"
                                             data-hbennombres="<?php echo $row->leghijo_bennombres; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Editar otro beneficiario</em>
                  		                    </a>
                                          <?php
                                        }
                                      ?>
                                      <?php
                                      if($row->leghijo_mopndoc > 0){
                                        //--Existen datos de mop
                                        if($emp->sexo_id == 1){
                                          //empleado masculino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legempleado_id; ?>"
                                             data-hmopndoc="<?php echo $row->leghijo_mopndoc; ?>"
                                             data-hmopapellido="<?php echo $row->leghijo_mopapellido; ?>"
                                             data-hmopnombres="<?php echo $row->leghijo_mopnombres; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Editar datos de la madre</em>
                  		                    </a>
                                          <?php
                                        }else{
                                          //empleado femenino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legempleado_id; ?>"
                                             data-hmopndoc="<?php echo $row->leghijo_mopndoc; ?>"
                                             data-hmopapellido="<?php echo $row->leghijo_mopapellido; ?>"
                                             data-hmopnombres="<?php echo $row->leghijo_mopnombres; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Editar datos del padre</em>
                  		                    </a>
                                          <?php
                                        }
                                      }else{
                                        //-- No hay datos de mop
                                        if($emp->sexo_id == 1){
                                          //empleado masculino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legempleado_id; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #00b347;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Agregar datos de la madre</em>
                  		                    </a>
                                          <?php
                                        }else{
                                          //empleado femenino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legempleado_id; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Agregar datos del padre</em>
                  		                    </a>
                                          <?php
                                        }
                                      }
                                      ?>
                                      <a href="#"
                                         class="dropdown-item"
                                         data-toggle="modal"
                                         title="Deshabilitar Asignacion"
                                         data-target="#dataDisableHijo"
                                         data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                         data-id="<?php echo $row->leghijo_id; ?>"
                                         data-empid="<?php echo $emp->legempleado_id; ?>"
                                         data-empndoc="<?php echo $emp->legempleado_nrodocto; ?>"
                                         data-benndoc="<?php echo $row->leghijo_benndoc; ?>">
                                         <i class="fa fa-toggle-off" ></i>
                                         &nbsp;&nbsp;&nbsp;<em>Deshabilitar asignacion</em>
                                      </a>
              											</div>
              										</div>
																</td>
															</tr>
														<?php endforeach; ?>
														</tbody>
													</table>
													<?php
												}else{
													//---- No tiene Hijos menores
												}
											?>
										</div>
									</div>
									<!-- HIJO PRE-ESCOLAR -->
									<div class="col-md-12">
										<div class="form-group">
											<?php
												$escuelanivel = 1;
												$hijospreescolar = $this->model->ObtenerHijosEscolares($empleadonrodocto, $escuelanivel);
												$hijospreescolarc = count($hijospreescolar);
												if($hijospreescolarc > 0){
													?>
													<div class="clearfix">
                            <h5 class="text-blue">
                              <label>
                                Hijo/s Pre-Escolar/es
                                <span class="badge badge-pill badge-primary">
                                  <?php echo $hijospreescolarc; ?>
                                </span>
                              </label>
                            </h5>
														<p></p>
													</div>
													<table class="resp2">
														<thead>
															<tr>
																<th scope="col">DNI</th>
																<th scope="col">APELLIDO Y NOMBRES</th>
																<th scope="col">ESCUELA</th>
																<th scope="col">BENEFICIARIO</th>
																<th width="18%" scope="col">ACCIONES</th>
															</tr>
														</thead>
														<tbody>
															<?php
																foreach($hijospreescolar as $row):
															?>
															<tr>
																<td><?php	echo $row->leghijo_nrodocto; ?></td>
																<td><?php echo $row->leghijo_apellido.", ".$row->leghijo_nombres;	?></td>
																<td><?php echo $row->escuela_nombre; ?></td>
																<td><?php echo $row->leghijo_benndoc." - ".$row->leghijo_benapellido.", ".$row->leghijo_bennombres; ?></td>
                                <td style="text-align: right;">
                                  <div class="dropdown">
              											<a class="btn btn-info dropdown-toggle" href="#" role="button" data-toggle="dropdown">
              												Opciones
              											</a>
              											<div class="dropdown-menu dropdown-menu-right">

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
              		                       data-target="#dataViewHijo"
              		                       data-titulo="<?php echo ""; ?>">
                                         <i class="fa fa-eye" style="color: #00b347;"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Ver detalles</em>
              		                    </a>

              												<a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
                                         data-target="#dataUpdateHijo"
                                         data-titulo="<?php echo "Edicion: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                         data-id="<?php echo $row->leghijo_id; ?>"
                                         data-hijotdoc="<?php echo $row->leghijo_tipodocto; ?>"
                                         data-hijondoc="<?php echo $row->leghijo_nrodocto; ?>"
                                         data-hijoapellido="<?php echo $row->leghijo_apellido; ?>"
                                         data-hijonombres="<?php echo $row->leghijo_nombres; ?>"
                                         data-hijonrocuil="<?php echo $row->leghijo_nrocuil; ?>"
                                         data-hijosexo="<?php echo $row->sexo_id; ?>"
                                         data-hijofecnacto="<?php echo $row->leghijo_fecnacto; ?>"
                                         data-hijodireccion="<?php echo $row->leghijo_direccion; ?>"
                                         data-hijodirecnro="<?php echo $row->leghijo_direcnro; ?>"
                                         data-hijodirecpiso="<?php echo $row->leghijo_direcpiso; ?>"
                                         data-hijocodpostal="<?php echo $row->leghijo_codpostal; ?>"
                                         data-hijoppdl="<?php echo $row->pais_id."-".$row->provincia_id."-".$row->departamento_id."-".$row->localidad_id; ?>"
                                         data-hijopais="<?php echo $row->pais_id; ?>"
                                         data-hijoprovincia="<?php echo $row->provincia_id; ?>"
                                         data-hijodepartamento="<?php echo $row->departamento_id; ?>"
                                         data-hijolocalidad="<?php echo $row->localidad_id; ?>"
                                         data-hijodisc="<?php echo $row->leghijo_disc; ?>"
                                         data-hijoesc="<?php echo $row->leghijo_esc; ?>"
                                         data-hijoescnom="<?php echo $row->escuela_id; ?>"
                                         data-hijoescnvl="<?php echo $row->escnivel_id; ?>"
                                         data-hijoescest="<?php echo $row->escestado_id; ?>"
                                         data-hijomoptdoc="<?php echo $row->leghijo_moptdoc; ?>"
                                         data-hijomopndoc="<?php echo $row->leghijo_mopndoc; ?>"
                                         data-hijomopapellido="<?php echo $row->leghijo_mopapellido; ?>"
                                         data-hijomopnombres="<?php echo $row->leghijo_mopnombres; ?>"
                                         data-hijobentdoc="<?php echo $row->leghijo_bentdoc; ?>"
                                         data-hijobennoficio="<?php echo $row->leghijo_bennoficio; ?>"
                                         data-hijobenndoc="<?php echo $row->leghijo_benndoc; ?>"
                                         data-hijobenapellido="<?php echo $row->leghijo_benapellido; ?>"
                                         data-hijobennombres="<?php echo $row->leghijo_bennombres; ?>"
                                         data-empid="<?php echo $emp->legempleado_id; ?>"
                                         data-empnrodocto="<?php echo $emp->legempleado_nrodocto; ?>"
                                         data-bennrodocto="<?php echo $row->leghijo_benndoc; ?>">
                                         <i class="ion-compose fa-lg" style="color: #0000ff;"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Editar hijo</em>
              		                    </a>

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
                                         data-target="#dataDeleteHijo"
                                         data-id="<?php echo $row->leghijo_id; ?>"
                                         data-empid="<?php echo $emp->legempleado_id; ?>"
                                         data-empndoc="<?php echo $emp->legempleado_nrodocto; ?>"
                                         data-benndoc="<?php echo $row->leghijo_benndoc; ?>">
                                         <i class="ion-android-delete fa-lg" style="color: #FF0000"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Eliminar hijo</em>
              		                    </a>

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
              		                       data-target="#dataUpdateEscuelaHijo"
              		                       data-titulo="<?php echo "Agregar Escuela"; ?>"
                                         data-hijoid="<?php echo $row->leghijo_id; ?>"
                                         data-empid="<?php echo $emp->legempleado_id; ?>"
                                         data-empnrodocto="<?php echo $emp->legempleado_nrodocto; ?>"
                                         data-bennrodocto="<?php echo $row->leghijo_benndoc; ?>"
                                         data-hescid="<?php echo $row->escuela_id; ?>"
                                         data-hescnvl="<?php echo $row->escnivel_id; ?>">
                                         <span class="ti-home" style="color: #00b347;"></span>
              													 &nbsp;&nbsp;&nbsp;<em>Editar datos escolares</em>
              		                    </a>


                                      <?php
                                        if($row->legempleado_nrodocto == $row->leghijo_benndoc){
                                          //------ mismo beneficiario
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Agregar otro beneficiario"
                                             data-target="#UpdateBeneficiarioHijo"
                                             data-titulo="<?php echo "Agregar otro beneficiario" ?>"
                                             data-hijoid="<?php echo $row->leghijo_id; ?>"
                                             data-empid="<?php echo $emp->legempleado_id; ?>"
                                             data-empndoc="<?php echo $emp->legempleado_nrodocto; ?>"
                                             data-benndoc="<?php echo $row->leghijo_benndoc; ?>"
                                             data-hbenndoc="<?php echo $row->leghijo_benndoc; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #00b347;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Agregar otro beneficiario</em>
                  		                    </a>
                                          <?php
                                        }else{
                                          //-----distinto beficiario
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Editar datos de otro beneficiario"
                                             data-target="#UpdateBeneficiarioHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijoid="<?php echo $row->leghijo_id; ?>"
                                             data-empid="<?php echo $emp->legempleado_id; ?>"
                                             data-empndoc="<?php echo $emp->legempleado_nrodocto; ?>"
                                             data-benndoc="<?php echo $row->leghijo_benndoc; ?>"
                                             data-hbenndoc="<?php echo $row->leghijo_benndoc; ?>"
                                             data-hbennoficio="<?php echo $row->leghijo_bennoficio; ?>"
                                             data-hbenapellido="<?php echo $row->leghijo_benapellido; ?>"
                                             data-hbennombres="<?php echo $row->leghijo_bennombres; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Editar otro beneficiario</em>
                  		                    </a>
                                          <?php
                                        }
                                      ?>
                                      <?php
                                      if($row->leghijo_mopndoc > 0){
                                        //--Existen datos de mop
                                        if($emp->sexo_id == 1){
                                          //empleado masculino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legempleado_id; ?>"
                                             data-hmopndoc="<?php echo $row->leghijo_mopndoc; ?>"
                                             data-hmopapellido="<?php echo $row->leghijo_mopapellido; ?>"
                                             data-hmopnombres="<?php echo $row->leghijo_mopnombres; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Editar datos de la madre</em>
                  		                    </a>
                                          <?php
                                        }else{
                                          //empleado femenino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legempleado_id; ?>"
                                             data-hmopndoc="<?php echo $row->leghijo_mopndoc; ?>"
                                             data-hmopapellido="<?php echo $row->leghijo_mopapellido; ?>"
                                             data-hmopnombres="<?php echo $row->leghijo_mopnombres; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Editar datos del padre</em>
                  		                    </a>
                                          <?php
                                        }
                                      }else{
                                        //-- No hay datos de mop
                                        if($emp->sexo_id == 1){
                                          //empleado masculino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legempleado_id; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #00b347;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Agregar datos de la madre</em>
                  		                    </a>
                                          <?php
                                        }else{
                                          //empleado femenino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legempleado_id; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Agregar datos del padre</em>
                  		                    </a>
                                          <?php
                                        }
                                      }
                                      ?>
                                      <a href="#"
                                         class="dropdown-item"
                                         data-toggle="modal"
                                         title="Deshabilitar Asignacion"
                                         data-target="#dataDisableHijo"
                                         data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                         data-id="<?php echo $row->leghijo_id; ?>"
                                         data-empid="<?php echo $emp->legempleado_id; ?>"
                                         data-empndoc="<?php echo $emp->legempleado_nrodocto; ?>"
                                         data-benndoc="<?php echo $row->leghijo_benndoc; ?>">
                                         <i class="fa fa-toggle-off" ></i>
                                         &nbsp;&nbsp;&nbsp;<em>Deshabilitar asignacion</em>
                                      </a>
              											</div>
              										</div>

																</td>
															</tr>
														<?php endforeach; ?>
														</tbody>
													</table>
													<?php
												}else{
													//---- No tiene Hijos en escuela pre-escolar
												}
											?>
										</div>
									</div>
									<!-- HIJO EN ESCUELA PRIMARIA -->
									<div class="col-md-12">
										<div class="form-group">
											<?php
												$escuelanivel = 2;
												$hijospreescolar = $this->model->ObtenerHijosEscolares($empleadonrodocto, $escuelanivel);
												$hijospreescolarc = count($hijospreescolar);
												if($hijospreescolarc > 0){
													?>
													<div class="clearfix">
                            <h5 class="text-blue">
                              <label>
                                Hijo/s en Escuela Primaria
                                <span class="badge badge-pill badge-primary">
                                  <?php echo $hijospreescolarc; ?>
                                </span>
                              </label>
                            </h5>
														<p></p>
													</div>
													<table class="resp2">
														<thead>
															<tr>
																<th scope="col">DNI</th>
																<th scope="col">APELLIDO Y NOMBRES</th>
																<th scope="col">ESCUELA</th>
																<th scope="col">BENEFICIARIO</th>
																<th width="18%" scope="col">ACCIONES</th>
															</tr>
														</thead>
														<tbody>
															<?php
																//$nrodocto = $emp->legempleado_nrodocto;
																foreach($hijospreescolar as $row):
															?>
															<tr>
																<td>
																	<?php	echo $row->leghijo_nrodocto; ?>
																</td>
																<td>
																	<?php echo $row->leghijo_apellido.", ".$row->leghijo_nombres;	?>
																</td>
																<td>
																	<?php echo $row->escuela_nombre;	?>
																</td>
																<td>
																	<?php echo $row->leghijo_benndoc." - ".$row->leghijo_benapellido.", ".$row->leghijo_bennombres; ?>
																</td>
                                <td style="text-align: right;">
                                  <div class="dropdown">
              											<a class="btn btn-info dropdown-toggle" href="#" role="button" data-toggle="dropdown">
              												Opciones
              											</a>
              											<div class="dropdown-menu dropdown-menu-right">

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
              		                       data-target="#dataViewHijo"
              		                       data-titulo="<?php echo ""; ?>">
                                         <i class="fa fa-eye" style="color: #00b347;"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Ver detalles</em>
              		                    </a>

              												<a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
                                         data-target="#dataUpdateHijo"
                                         data-titulo="<?php echo "Edicion: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                         data-id="<?php echo $row->leghijo_id; ?>"
                                         data-hijotdoc="<?php echo $row->leghijo_tipodocto; ?>"
                                         data-hijondoc="<?php echo $row->leghijo_nrodocto; ?>"
                                         data-hijoapellido="<?php echo $row->leghijo_apellido; ?>"
                                         data-hijonombres="<?php echo $row->leghijo_nombres; ?>"
                                         data-hijonrocuil="<?php echo $row->leghijo_nrocuil; ?>"
                                         data-hijosexo="<?php echo $row->sexo_id; ?>"
                                         data-hijofecnacto="<?php echo $row->leghijo_fecnacto; ?>"
                                         data-hijodireccion="<?php echo $row->leghijo_direccion; ?>"
                                         data-hijodirecnro="<?php echo $row->leghijo_direcnro; ?>"
                                         data-hijodirecpiso="<?php echo $row->leghijo_direcpiso; ?>"
                                         data-hijocodpostal="<?php echo $row->leghijo_codpostal; ?>"
                                         data-hijoppdl="<?php echo $row->pais_id."-".$row->provincia_id."-".$row->departamento_id."-".$row->localidad_id; ?>"
                                         data-hijopais="<?php echo $row->pais_id; ?>"
                                         data-hijoprovincia="<?php echo $row->provincia_id; ?>"
                                         data-hijodepartamento="<?php echo $row->departamento_id; ?>"
                                         data-hijolocalidad="<?php echo $row->localidad_id; ?>"
                                         data-hijodisc="<?php echo $row->leghijo_disc; ?>"
                                         data-hijoesc="<?php echo $row->leghijo_esc; ?>"
                                         data-hijoescnom="<?php echo $row->escuela_id; ?>"
                                         data-hijoescnvl="<?php echo $row->escnivel_id; ?>"
                                         data-hijoescest="<?php echo $row->escestado_id; ?>"
                                         data-hijomoptdoc="<?php echo $row->leghijo_moptdoc; ?>"
                                         data-hijomopndoc="<?php echo $row->leghijo_mopndoc; ?>"
                                         data-hijomopapellido="<?php echo $row->leghijo_mopapellido; ?>"
                                         data-hijomopnombres="<?php echo $row->leghijo_mopnombres; ?>"
                                         data-hijobentdoc="<?php echo $row->leghijo_bentdoc; ?>"
                                         data-hijobennoficio="<?php echo $row->leghijo_bennoficio; ?>"
                                         data-hijobenndoc="<?php echo $row->leghijo_benndoc; ?>"
                                         data-hijobenapellido="<?php echo $row->leghijo_benapellido; ?>"
                                         data-hijobennombres="<?php echo $row->leghijo_bennombres; ?>"
                                         data-empid="<?php echo $emp->legempleado_id; ?>"
                                         data-empnrodocto="<?php echo $emp->legempleado_nrodocto; ?>"
                                         data-bennrodocto="<?php echo $row->leghijo_benndoc; ?>">
                                         <i class="ion-compose fa-lg" style="color: #0000ff;"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Editar hijo</em>
              		                    </a>

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
                                         data-target="#dataDeleteHijo"
                                         data-id="<?php echo $row->leghijo_id; ?>"
                                         data-empid="<?php echo $emp->legempleado_id; ?>"
                                         data-empndoc="<?php echo $emp->legempleado_nrodocto; ?>"
                                         data-benndoc="<?php echo $row->leghijo_benndoc; ?>">
                                         <i class="ion-android-delete fa-lg" style="color: #FF0000"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Eliminar hijo</em>
              		                    </a>

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
              		                       data-target="#dataUpdateEscuelaHijo"
              		                       data-titulo="<?php echo "Agregar Escuela"; ?>"
                                         data-hijoid="<?php echo $row->leghijo_id; ?>"
                                         data-empid="<?php echo $emp->legempleado_id; ?>"
                                         data-empnrodocto="<?php echo $emp->legempleado_nrodocto; ?>"
                                         data-bennrodocto="<?php echo $row->leghijo_benndoc; ?>"
                                         data-hescid="<?php echo $row->escuela_id; ?>"
                                         data-hescnvl="<?php echo $row->escnivel_id; ?>">
                                         <span class="ti-home" style="color: #00b347;"></span>
              													 &nbsp;&nbsp;&nbsp;<em>Editar datos escolares</em>
              		                    </a>


                                      <?php
                                        if($row->legempleado_nrodocto == $row->leghijo_benndoc){
                                          //------ mismo beneficiario
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Agregar otro beneficiario"
                                             data-target="#UpdateBeneficiarioHijo"
                                             data-titulo="<?php echo "Agregar otro beneficiario" ?>"
                                             data-hijoid="<?php echo $row->leghijo_id; ?>"
                                             data-empid="<?php echo $emp->legempleado_id; ?>"
                                             data-empndoc="<?php echo $emp->legempleado_nrodocto; ?>"
                                             data-benndoc="<?php echo $row->leghijo_benndoc; ?>"
                                             data-hbenndoc="<?php echo $row->leghijo_benndoc; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #00b347;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Agregar otro beneficiario</em>
                  		                    </a>
                                          <?php
                                        }else{
                                          //-----distinto beficiario
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Editar datos de otro beneficiario"
                                             data-target="#UpdateBeneficiarioHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijoid="<?php echo $row->leghijo_id; ?>"
                                             data-empid="<?php echo $emp->legempleado_id; ?>"
                                             data-empndoc="<?php echo $emp->legempleado_nrodocto; ?>"
                                             data-benndoc="<?php echo $row->leghijo_benndoc; ?>"
                                             data-hbenndoc="<?php echo $row->leghijo_benndoc; ?>"
                                             data-hbennoficio="<?php echo $row->leghijo_bennoficio; ?>"
                                             data-hbenapellido="<?php echo $row->leghijo_benapellido; ?>"
                                             data-hbennombres="<?php echo $row->leghijo_bennombres; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Editar otro beneficiario</em>
                  		                    </a>
                                          <?php
                                        }
                                      ?>
                                      <?php
                                      if($row->leghijo_mopndoc > 0){
                                        //--Existen datos de mop
                                        if($emp->sexo_id == 1){
                                          //empleado masculino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legempleado_id; ?>"
                                             data-hmopndoc="<?php echo $row->leghijo_mopndoc; ?>"
                                             data-hmopapellido="<?php echo $row->leghijo_mopapellido; ?>"
                                             data-hmopnombres="<?php echo $row->leghijo_mopnombres; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Editar datos de la madre</em>
                  		                    </a>
                                          <?php
                                        }else{
                                          //empleado femenino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legempleado_id; ?>"
                                             data-hmopndoc="<?php echo $row->leghijo_mopndoc; ?>"
                                             data-hmopapellido="<?php echo $row->leghijo_mopapellido; ?>"
                                             data-hmopnombres="<?php echo $row->leghijo_mopnombres; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Editar datos del padre</em>
                  		                    </a>
                                          <?php
                                        }
                                      }else{
                                        //-- No hay datos de mop
                                        if($emp->sexo_id == 1){
                                          //empleado masculino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legempleado_id; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #00b347;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Agregar datos de la madre</em>
                  		                    </a>
                                          <?php
                                        }else{
                                          //empleado femenino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legempleado_id; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Agregar datos del padre</em>
                  		                    </a>
                                          <?php
                                        }
                                      }
                                      ?>
                                      <a href="#"
                                         class="dropdown-item"
                                         data-toggle="modal"
                                         title="Deshabilitar Asignacion"
                                         data-target="#dataDisableHijo"
                                         data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                         data-id="<?php echo $row->leghijo_id; ?>"
                                         data-empid="<?php echo $emp->legempleado_id; ?>"
                                         data-empndoc="<?php echo $emp->legempleado_nrodocto; ?>"
                                         data-benndoc="<?php echo $row->leghijo_benndoc; ?>">
                                         <i class="fa fa-toggle-off" ></i>
                                         &nbsp;&nbsp;&nbsp;<em>Deshabilitar asignacion</em>
                                      </a>
              											</div>
              										</div>
																</td>
															</tr>
														<?php endforeach; ?>
														</tbody>
													</table>
													<?php
												}else{
													//---- No tiene Hijos en escuela primaria
												}
											?>
										</div>
									</div>
									<!-- HIJOS EN ESCUELA SECUNDARIA Y SUPERIOR -->
									<div class="col-md-12">
										<div class="form-group">
											<?php
												$escuelanivel = 3;
												$hijospreescolar = $this->model->ObtenerHijosEscolares($empleadonrodocto, $escuelanivel);
												$hijospreescolarc = count($hijospreescolar);
												if($hijospreescolarc > 0){
													?>
													<div class="clearfix">
                            <h5 class="text-blue">
                              <label>
                                Hijo/s en Escuela Secunadria y Superior
                                <span class="badge badge-pill badge-primary">
                                  <?php echo $hijospreescolarc; ?>
                                </span>
                              </label>
                            </h5>
														<p></p>
													</div>
													<table class="resp2">
														<thead>
															<tr>
																<th scope="col">DNI</th>
																<th scope="col">APELLIDO Y NOMBRES</th>
																<th scope="col">ESCUELA</th>
																<th scope="col">BENEFICIARIO</th>
																<th width="18%" scope="col">ACCIONES</th>
															</tr>
														</thead>
														<tbody>
															<?php
																foreach($hijospreescolar as $row):
															?>
															<tr>
																<td>
																	<?php	echo $row->leghijo_nrodocto; ?>
																</td>
																<td>
																	<?php echo $row->leghijo_apellido.", ".$row->leghijo_nombres;	?>
																</td>
																<td>
																	<?php echo $row->escuela_nombre;	?>
																</td>
																<td>
																	<?php echo $row->leghijo_benndoc." - ".$row->leghijo_benapellido.", ".$row->leghijo_bennombres; ?>
																</td>
                                <td style="text-align: right;">
                                  <div class="dropdown">
              											<a class="btn btn-info dropdown-toggle" href="#" role="button" data-toggle="dropdown">
              												Opciones
              											</a>
              											<div class="dropdown-menu dropdown-menu-right">

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
              		                       data-target="#dataViewHijo"
              		                       data-titulo="<?php echo ""; ?>">
                                         <i class="fa fa-eye" style="color: #00b347;"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Ver detalles</em>
              		                    </a>

              												<a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
                                         data-target="#dataUpdateHijo"
                                         data-titulo="<?php echo "Edicion: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                         data-id="<?php echo $row->leghijo_id; ?>"
                                         data-hijotdoc="<?php echo $row->leghijo_tipodocto; ?>"
                                         data-hijondoc="<?php echo $row->leghijo_nrodocto; ?>"
                                         data-hijoapellido="<?php echo $row->leghijo_apellido; ?>"
                                         data-hijonombres="<?php echo $row->leghijo_nombres; ?>"
                                         data-hijonrocuil="<?php echo $row->leghijo_nrocuil; ?>"
                                         data-hijosexo="<?php echo $row->sexo_id; ?>"
                                         data-hijofecnacto="<?php echo $row->leghijo_fecnacto; ?>"
                                         data-hijodireccion="<?php echo $row->leghijo_direccion; ?>"
                                         data-hijodirecnro="<?php echo $row->leghijo_direcnro; ?>"
                                         data-hijodirecpiso="<?php echo $row->leghijo_direcpiso; ?>"
                                         data-hijocodpostal="<?php echo $row->leghijo_codpostal; ?>"
                                         data-hijoppdl="<?php echo $row->pais_id."-".$row->provincia_id."-".$row->departamento_id."-".$row->localidad_id; ?>"
                                         data-hijopais="<?php echo $row->pais_id; ?>"
                                         data-hijoprovincia="<?php echo $row->provincia_id; ?>"
                                         data-hijodepartamento="<?php echo $row->departamento_id; ?>"
                                         data-hijolocalidad="<?php echo $row->localidad_id; ?>"
                                         data-hijodisc="<?php echo $row->leghijo_disc; ?>"
                                         data-hijoesc="<?php echo $row->leghijo_esc; ?>"
                                         data-hijoescnom="<?php echo $row->escuela_id; ?>"
                                         data-hijoescnvl="<?php echo $row->escnivel_id; ?>"
                                         data-hijoescest="<?php echo $row->escestado_id; ?>"
                                         data-hijomoptdoc="<?php echo $row->leghijo_moptdoc; ?>"
                                         data-hijomopndoc="<?php echo $row->leghijo_mopndoc; ?>"
                                         data-hijomopapellido="<?php echo $row->leghijo_mopapellido; ?>"
                                         data-hijomopnombres="<?php echo $row->leghijo_mopnombres; ?>"
                                         data-hijobentdoc="<?php echo $row->leghijo_bentdoc; ?>"
                                         data-hijobennoficio="<?php echo $row->leghijo_bennoficio; ?>"
                                         data-hijobenndoc="<?php echo $row->leghijo_benndoc; ?>"
                                         data-hijobenapellido="<?php echo $row->leghijo_benapellido; ?>"
                                         data-hijobennombres="<?php echo $row->leghijo_bennombres; ?>"
                                         data-empid="<?php echo $emp->legempleado_id; ?>"
                                         data-empnrodocto="<?php echo $emp->legempleado_nrodocto; ?>"
                                         data-bennrodocto="<?php echo $row->leghijo_benndoc; ?>">
                                         <i class="ion-compose fa-lg" style="color: #0000ff;"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Editar hijo</em>
              		                    </a>

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
                                         data-target="#dataDeleteHijo"
                                         data-id="<?php echo $row->leghijo_id; ?>"
                                         data-empid="<?php echo $emp->legempleado_id; ?>"
                                         data-empndoc="<?php echo $emp->legempleado_nrodocto; ?>"
                                         data-benndoc="<?php echo $row->leghijo_benndoc; ?>">
                                         <i class="ion-android-delete fa-lg" style="color: #FF0000"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Eliminar hijo</em>
              		                    </a>

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
              		                       data-target="#dataUpdateEscuelaHijo"
              		                       data-titulo="<?php echo "Agregar Escuela"; ?>"
                                         data-hijoid="<?php echo $row->leghijo_id; ?>"
                                         data-empid="<?php echo $emp->legempleado_id; ?>"
                                         data-empnrodocto="<?php echo $emp->legempleado_nrodocto; ?>"
                                         data-bennrodocto="<?php echo $row->leghijo_benndoc; ?>"
                                         data-hescid="<?php echo $row->escuela_id; ?>"
                                         data-hescnvl="<?php echo $row->escnivel_id; ?>">
                                         <span class="ti-home" style="color: #00b347;"></span>
              													 &nbsp;&nbsp;&nbsp;<em>Editar datos escolares</em>
              		                    </a>


                                      <?php
                                        if($row->legempleado_nrodocto == $row->leghijo_benndoc){
                                          //------ mismo beneficiario
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Agregar otro beneficiario"
                                             data-target="#UpdateBeneficiarioHijo"
                                             data-titulo="<?php echo "Agregar otro beneficiario" ?>"
                                             data-hijoid="<?php echo $row->leghijo_id; ?>"
                                             data-empid="<?php echo $emp->legempleado_id; ?>"
                                             data-empndoc="<?php echo $emp->legempleado_nrodocto; ?>"
                                             data-benndoc="<?php echo $row->leghijo_benndoc; ?>"
                                             data-hbenndoc="<?php echo $row->leghijo_benndoc; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #00b347;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Agregar otro beneficiario</em>
                  		                    </a>
                                          <?php
                                        }else{
                                          //-----distinto beficiario
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Editar datos de otro beneficiario"
                                             data-target="#UpdateBeneficiarioHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijoid="<?php echo $row->leghijo_id; ?>"
                                             data-empid="<?php echo $emp->legempleado_id; ?>"
                                             data-empndoc="<?php echo $emp->legempleado_nrodocto; ?>"
                                             data-benndoc="<?php echo $row->leghijo_benndoc; ?>"
                                             data-hbenndoc="<?php echo $row->leghijo_benndoc; ?>"
                                             data-hbennoficio="<?php echo $row->leghijo_bennoficio; ?>"
                                             data-hbenapellido="<?php echo $row->leghijo_benapellido; ?>"
                                             data-hbennombres="<?php echo $row->leghijo_bennombres; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Editar otro beneficiario</em>
                  		                    </a>
                                          <?php
                                        }
                                      ?>
                                      <?php
                                      if($row->leghijo_mopndoc > 0){
                                        //--Existen datos de mop
                                        if($emp->sexo_id == 1){
                                          //empleado masculino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legempleado_id; ?>"
                                             data-hmopndoc="<?php echo $row->leghijo_mopndoc; ?>"
                                             data-hmopapellido="<?php echo $row->leghijo_mopapellido; ?>"
                                             data-hmopnombres="<?php echo $row->leghijo_mopnombres; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Editar datos de la madre</em>
                  		                    </a>
                                          <?php
                                        }else{
                                          //empleado femenino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legempleado_id; ?>"
                                             data-hmopndoc="<?php echo $row->leghijo_mopndoc; ?>"
                                             data-hmopapellido="<?php echo $row->leghijo_mopapellido; ?>"
                                             data-hmopnombres="<?php echo $row->leghijo_mopnombres; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Editar datos del padre</em>
                  		                    </a>
                                          <?php
                                        }
                                      }else{
                                        //-- No hay datos de mop
                                        if($emp->sexo_id == 1){
                                          //empleado masculino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legempleado_id; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #00b347;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Agregar datos de la madre</em>
                  		                    </a>
                                          <?php
                                        }else{
                                          //empleado femenino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legempleado_id; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Agregar datos del padre</em>
                  		                    </a>
                                          <?php
                                        }
                                      }
                                      ?>
                                      <a href="#"
                                         class="dropdown-item"
                                         data-toggle="modal"
                                         title="Deshabilitar Asignacion"
                                         data-target="#dataDisableHijo"
                                         data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                         data-id="<?php echo $row->leghijo_id; ?>"
                                         data-empid="<?php echo $emp->legempleado_id; ?>"
                                         data-empndoc="<?php echo $emp->legempleado_nrodocto; ?>"
                                         data-benndoc="<?php echo $row->leghijo_benndoc; ?>">
                                         <i class="fa fa-toggle-off" ></i>
                                         &nbsp;&nbsp;&nbsp;<em>Deshabilitar asignacion</em>
                                      </a>
              											</div>
              										</div>
																</td>
															</tr>
														<?php endforeach; ?>
														</tbody>
													</table>
													<?php
												}else{
													//---- No tiene Hijos en escuela secundaria y superior ----
												}
											?>
										</div>
									</div>
									<!-- HIJOS CON DISCAPACIDAD -->
									<div class="col-md-12">
										<div class="form-group">
											<?php
												$hijosconcapacidadesdiferentes = $this->model->ObtenerHijosConCapacidadesDiferentes($empleadonrodocto);
												$hijosconcapacidadesdiferentesc = count($hijosconcapacidadesdiferentes);
												if($hijosconcapacidadesdiferentesc > 0){
													?>
													<div class="clearfix">
                            <h5 class="text-blue">
                              <label>
                                Hijo/s con Discapacidad
                                <span class="badge badge-pill badge-primary">
                                  <?php echo $hijosconcapacidadesdiferentesc; ?>
                                </span>
                              </label>
                            </h5>
														<p></p>
													</div>
													<table class="resp2">
														<thead>
															<tr>
																<th scope="col">DNI</th>
																<th scope="col">APELLIDO Y NOMBRES</th>
																<th scope="col">EDAD</th>
																<th scope="col">BENEFICIARIO</th>
																<th width="18%" scope="col">ACCIONES</th>
															</tr>
														</thead>
														<tbody>
															<?php
																//$nrodocto = $emp->legempleado_nrodocto;
																foreach($hijosconcapacidadesdiferentes as $row):
															?>
															<tr>
																<td>
																	<?php	echo $row->leghijo_nrodocto; ?>
																</td>
																<td>
																	<?php echo $row->leghijo_apellido.", ".$row->leghijo_nombres;	?>
																</td>
																<td>
                                  <?php
																	$fechanacimiento = $row->leghijo_fecnacto;
																	$edad = $this->model->CalculaEdad($fechanacimiento);
                                  if($edad > 0){
																	  echo $edad;
                                  }else{
                                    echo "*";
                                  }
																	?>
                                </td>
																<td>
																	<?php echo $row->leghijo_benndoc." - ".$row->leghijo_benapellido.", ".$row->leghijo_bennombres; ?>
																</td>
                                <td style="text-align: right;">
                                  <div class="dropdown">
              											<a class="btn btn-info dropdown-toggle" href="#" role="button" data-toggle="dropdown">
              												Opciones
              											</a>
              											<div class="dropdown-menu dropdown-menu-right">

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
              		                       data-target="#dataViewHijo"
              		                       data-titulo="<?php echo ""; ?>">
                                         <i class="fa fa-eye" style="color: #00b347;"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Ver detalles</em>
              		                    </a>

              												<a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
                                         data-target="#dataUpdateHijo"
                                         data-titulo="<?php echo "Edicion: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                         data-id="<?php echo $row->leghijo_id; ?>"
                                         data-hijotdoc="<?php echo $row->leghijo_tipodocto; ?>"
                                         data-hijondoc="<?php echo $row->leghijo_nrodocto; ?>"
                                         data-hijoapellido="<?php echo $row->leghijo_apellido; ?>"
                                         data-hijonombres="<?php echo $row->leghijo_nombres; ?>"
                                         data-hijonrocuil="<?php echo $row->leghijo_nrocuil; ?>"
                                         data-hijosexo="<?php echo $row->sexo_id; ?>"
                                         data-hijofecnacto="<?php echo $row->leghijo_fecnacto; ?>"
                                         data-hijodireccion="<?php echo $row->leghijo_direccion; ?>"
                                         data-hijodirecnro="<?php echo $row->leghijo_direcnro; ?>"
                                         data-hijodirecpiso="<?php echo $row->leghijo_direcpiso; ?>"
                                         data-hijocodpostal="<?php echo $row->leghijo_codpostal; ?>"
                                         data-hijoppdl="<?php echo $row->pais_id."-".$row->provincia_id."-".$row->departamento_id."-".$row->localidad_id; ?>"
                                         data-hijopais="<?php echo $row->pais_id; ?>"
                                         data-hijoprovincia="<?php echo $row->provincia_id; ?>"
                                         data-hijodepartamento="<?php echo $row->departamento_id; ?>"
                                         data-hijolocalidad="<?php echo $row->localidad_id; ?>"
                                         data-hijodisc="<?php echo $row->leghijo_disc; ?>"
                                         data-hijoesc="<?php echo $row->leghijo_esc; ?>"
                                         data-hijoescnom="<?php echo $row->escuela_id; ?>"
                                         data-hijoescnvl="<?php echo $row->escnivel_id; ?>"
                                         data-hijoescest="<?php echo $row->escestado_id; ?>"
                                         data-hijomoptdoc="<?php echo $row->leghijo_moptdoc; ?>"
                                         data-hijomopndoc="<?php echo $row->leghijo_mopndoc; ?>"
                                         data-hijomopapellido="<?php echo $row->leghijo_mopapellido; ?>"
                                         data-hijomopnombres="<?php echo $row->leghijo_mopnombres; ?>"
                                         data-hijobentdoc="<?php echo $row->leghijo_bentdoc; ?>"
                                         data-hijobennoficio="<?php echo $row->leghijo_bennoficio; ?>"
                                         data-hijobenndoc="<?php echo $row->leghijo_benndoc; ?>"
                                         data-hijobenapellido="<?php echo $row->leghijo_benapellido; ?>"
                                         data-hijobennombres="<?php echo $row->leghijo_bennombres; ?>"
                                         data-empid="<?php echo $emp->legempleado_id; ?>"
                                         data-empnrodocto="<?php echo $emp->legempleado_nrodocto; ?>"
                                         data-bennrodocto="<?php echo $row->leghijo_benndoc; ?>">
                                         <i class="ion-compose fa-lg" style="color: #0000ff;"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Editar hijo</em>
              		                    </a>

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
                                         data-target="#dataDeleteHijo"
                                         data-id="<?php echo $row->leghijo_id; ?>"
                                         data-empid="<?php echo $emp->legempleado_id; ?>"
                                         data-empndoc="<?php echo $emp->legempleado_nrodocto; ?>"
                                         data-benndoc="<?php echo $row->leghijo_benndoc; ?>">
                                         <i class="ion-android-delete fa-lg" style="color: #FF0000"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Eliminar hijo</em>
              		                    </a>

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
              		                       data-target="#dataUpdateEscuelaHijo"
              		                       data-titulo="<?php echo "Agregar Escuela"; ?>"
                                         data-hijoid="<?php echo $row->leghijo_id; ?>"
                                         data-empid="<?php echo $emp->legempleado_id; ?>"
                                         data-empnrodocto="<?php echo $emp->legempleado_nrodocto; ?>"
                                         data-bennrodocto="<?php echo $row->leghijo_benndoc; ?>">
                                         <span class="ti-home" style="color: #00b347;"></span>
              													 &nbsp;&nbsp;&nbsp;<em>Agregar datos escolares</em>
              		                    </a>


                                      <?php
                                        if($row->legempleado_nrodocto == $row->leghijo_benndoc){
                                          //------ mismo beneficiario
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Agregar otro beneficiario"
                                             data-target="#UpdateBeneficiarioHijo"
                                             data-titulo="<?php echo "Agregar otro beneficiario" ?>"
                                             data-hijoid="<?php echo $row->leghijo_id; ?>"
                                             data-empid="<?php echo $emp->legempleado_id; ?>"
                                             data-empndoc="<?php echo $emp->legempleado_nrodocto; ?>"
                                             data-benndoc="<?php echo $row->leghijo_benndoc; ?>"
                                             data-hbenndoc="<?php echo $row->leghijo_benndoc; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #00b347;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Agregar otro beneficiario</em>
                  		                    </a>
                                          <?php
                                        }else{
                                          //-----distinto beficiario
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Editar datos de otro beneficiario"
                                             data-target="#UpdateBeneficiarioHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijoid="<?php echo $row->leghijo_id; ?>"
                                             data-empid="<?php echo $emp->legempleado_id; ?>"
                                             data-empndoc="<?php echo $emp->legempleado_nrodocto; ?>"
                                             data-benndoc="<?php echo $row->leghijo_benndoc; ?>"
                                             data-hbenndoc="<?php echo $row->leghijo_benndoc; ?>"
                                             data-hbennoficio="<?php echo $row->leghijo_bennoficio; ?>"
                                             data-hbenapellido="<?php echo $row->leghijo_benapellido; ?>"
                                             data-hbennombres="<?php echo $row->leghijo_bennombres; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Editar otro beneficiario</em>
                  		                    </a>
                                          <?php
                                        }
                                      ?>
                                      <?php
                                      if($row->leghijo_mopndoc > 0){
                                        //--Existen datos de mop
                                        if($emp->sexo_id == 1){
                                          //empleado masculino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legempleado_id; ?>"
                                             data-hmopndoc="<?php echo $row->leghijo_mopndoc; ?>"
                                             data-hmopapellido="<?php echo $row->leghijo_mopapellido; ?>"
                                             data-hmopnombres="<?php echo $row->leghijo_mopnombres; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Editar datos de la madre</em>
                  		                    </a>
                                          <?php
                                        }else{
                                          //empleado femenino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legempleado_id; ?>"
                                             data-hmopndoc="<?php echo $row->leghijo_mopndoc; ?>"
                                             data-hmopapellido="<?php echo $row->leghijo_mopapellido; ?>"
                                             data-hmopnombres="<?php echo $row->leghijo_mopnombres; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Editar datos del padre</em>
                  		                    </a>
                                          <?php
                                        }
                                      }else{
                                        //-- No hay datos de mop
                                        if($emp->sexo_id == 1){
                                          //empleado masculino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legempleado_id; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #00b347;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Agregar datos de la madre</em>
                  		                    </a>
                                          <?php
                                        }else{
                                          //empleado femenino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legempleado_id; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Agregar datos del padre</em>
                  		                    </a>
                                          <?php
                                        }
                                      }
                                      ?>
                                      <a href="#"
                                         class="dropdown-item"
                                         data-toggle="modal"
                                         title="Deshabilitar Asignacion"
                                         data-target="#dataDisableHijo"
                                         data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                         data-id="<?php echo $row->leghijo_id; ?>"
                                         data-empid="<?php echo $emp->legempleado_id; ?>"
                                         data-empndoc="<?php echo $emp->legempleado_nrodocto; ?>"
                                         data-benndoc="<?php echo $row->leghijo_benndoc; ?>">
                                         <i class="fa fa-toggle-off" ></i>
                                         &nbsp;&nbsp;&nbsp;<em>Deshabilitar asignacion</em>
                                      </a>
              											</div>
              										</div>
																</td>
															</tr>
														<?php endforeach; ?>
														</tbody>
													</table>
													<?php
												}else{
													//---- No tiene Hijos con discapacidad
												}
											?>
										</div>
									</div>
									<!-- HIJOS ESCOLARES CON DISCAPACIDAD -->
									<div class="col-md-12">
										<div class="form-group">
											<?php
												$hijosescconcapacidadesdiferentes= $this->model->ObtenerHijosEscConCapacidadesDiferentes($empleadonrodocto);
												$hijosescconcapacidadesdiferentesc = count($hijosescconcapacidadesdiferentes);
												if($hijosescconcapacidadesdiferentesc > 0){
													?>
													<div class="clearfix">
                            <h5 class="text-blue">
                              <label>
                                Hijo/s escolares con Discapacidad
                                <span class="badge badge-pill badge-primary">
                                  <?php echo $hijosescconcapacidadesdiferentesc; ?>
                                </span>
                              </label>
                            </h5>
														<p></p>
													</div>
													<table class="resp2">
														<thead>
															<tr>
																<th scope="col">DNI</th>
																<th scope="col">APELLIDO Y NOMBRES</th>
																<th scope="col">ESCUELA</th>
																<th scope="col">BENEFICIARIO</th>
																<th width="18%" scope="col">ACCIONES</th>
															</tr>
														</thead>
														<tbody>
															<?php
																//$nrodocto = $emp->legempleado_nrodocto;
																foreach($hijosescconcapacidadesdiferentes as $row):
															?>
															<tr>
																<td>
																	<?php	echo $row->leghijo_nrodocto; ?>
																</td>
																<td>
																	<?php echo $row->leghijo_apellido.", ".$row->leghijo_nombres;	?>
																</td>
																<td>
																	<?php echo $row->escuela_nombre;	?>
																</td>
																<td>
																	<?php echo $row->leghijo_benndoc." - ".$row->leghijo_benapellido.", ".$row->leghijo_bennombres; ?>
																</td>
                                <td style="text-align: right;">
                                  <div class="dropdown">
              											<a class="btn btn-info dropdown-toggle" href="#" role="button" data-toggle="dropdown">
              												Opciones
              											</a>
              											<div class="dropdown-menu dropdown-menu-right">

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
              		                       data-target="#dataViewHijo"
              		                       data-titulo="<?php echo ""; ?>">
                                         <i class="fa fa-eye" style="color: #00b347;"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Ver detalles</em>
              		                    </a>

              												<a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
                                         data-target="#dataUpdateHijo"
                                         data-titulo="<?php echo "Edicion: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                         data-id="<?php echo $row->leghijo_id; ?>"
                                         data-hijotdoc="<?php echo $row->leghijo_tipodocto; ?>"
                                         data-hijondoc="<?php echo $row->leghijo_nrodocto; ?>"
                                         data-hijoapellido="<?php echo $row->leghijo_apellido; ?>"
                                         data-hijonombres="<?php echo $row->leghijo_nombres; ?>"
                                         data-hijonrocuil="<?php echo $row->leghijo_nrocuil; ?>"
                                         data-hijosexo="<?php echo $row->sexo_id; ?>"
                                         data-hijofecnacto="<?php echo $row->leghijo_fecnacto; ?>"
                                         data-hijodireccion="<?php echo $row->leghijo_direccion; ?>"
                                         data-hijodirecnro="<?php echo $row->leghijo_direcnro; ?>"
                                         data-hijodirecpiso="<?php echo $row->leghijo_direcpiso; ?>"
                                         data-hijocodpostal="<?php echo $row->leghijo_codpostal; ?>"
                                         data-hijoppdl="<?php echo $row->pais_id."-".$row->provincia_id."-".$row->departamento_id."-".$row->localidad_id; ?>"
                                         data-hijopais="<?php echo $row->pais_id; ?>"
                                         data-hijoprovincia="<?php echo $row->provincia_id; ?>"
                                         data-hijodepartamento="<?php echo $row->departamento_id; ?>"
                                         data-hijolocalidad="<?php echo $row->localidad_id; ?>"
                                         data-hijodisc="<?php echo $row->leghijo_disc; ?>"
                                         data-hijoesc="<?php echo $row->leghijo_esc; ?>"
                                         data-hijoescnom="<?php echo $row->escuela_id; ?>"
                                         data-hijoescnvl="<?php echo $row->escnivel_id; ?>"
                                         data-hijoescest="<?php echo $row->escestado_id; ?>"
                                         data-hijomoptdoc="<?php echo $row->leghijo_moptdoc; ?>"
                                         data-hijomopndoc="<?php echo $row->leghijo_mopndoc; ?>"
                                         data-hijomopapellido="<?php echo $row->leghijo_mopapellido; ?>"
                                         data-hijomopnombres="<?php echo $row->leghijo_mopnombres; ?>"
                                         data-hijobentdoc="<?php echo $row->leghijo_bentdoc; ?>"
                                         data-hijobennoficio="<?php echo $row->leghijo_bennoficio; ?>"
                                         data-hijobenndoc="<?php echo $row->leghijo_benndoc; ?>"
                                         data-hijobenapellido="<?php echo $row->leghijo_benapellido; ?>"
                                         data-hijobennombres="<?php echo $row->leghijo_bennombres; ?>"
                                         data-empid="<?php echo $emp->legempleado_id; ?>"
                                         data-empnrodocto="<?php echo $emp->legempleado_nrodocto; ?>"
                                         data-bennrodocto="<?php echo $row->leghijo_benndoc; ?>">
                                         <i class="ion-compose fa-lg" style="color: #0000ff;"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Editar hijo</em>
              		                    </a>

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
                                         data-target="#dataDeleteHijo"
                                         data-id="<?php echo $row->leghijo_id; ?>"
                                         data-empid="<?php echo $emp->legempleado_id; ?>"
                                         data-empndoc="<?php echo $emp->legempleado_nrodocto; ?>"
                                         data-benndoc="<?php echo $row->leghijo_benndoc; ?>">
                                         <i class="ion-android-delete fa-lg" style="color: #FF0000"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Eliminar hijo</em>
              		                    </a>

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
              		                       data-target="#dataUpdateEscuelaHijo"
              		                       data-titulo="<?php echo "Agregar Escuela"; ?>"
                                         data-hijoid="<?php echo $row->leghijo_id; ?>"
                                         data-empid="<?php echo $emp->legempleado_id; ?>"
                                         data-empnrodocto="<?php echo $emp->legempleado_nrodocto; ?>"
                                         data-bennrodocto="<?php echo $row->leghijo_benndoc; ?>"
                                         data-hescid="<?php echo $row->escuela_id; ?>"
                                         data-hescnvl="<?php echo $row->escnivel_id; ?>">
                                         <span class="ti-home" style="color: #00b347;"></span>
              													 &nbsp;&nbsp;&nbsp;<em>Editar datos escolares</em>
              		                    </a>


                                      <?php
                                        if($row->legempleado_nrodocto == $row->leghijo_benndoc){
                                          //------ mismo beneficiario
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Agregar otro beneficiario"
                                             data-target="#UpdateBeneficiarioHijo"
                                             data-titulo="<?php echo "Agregar otro beneficiario" ?>"
                                             data-hijoid="<?php echo $row->leghijo_id; ?>"
                                             data-empid="<?php echo $emp->legempleado_id; ?>"
                                             data-empndoc="<?php echo $emp->legempleado_nrodocto; ?>"
                                             data-benndoc="<?php echo $row->leghijo_benndoc; ?>"
                                             data-hbenndoc="<?php echo $row->leghijo_benndoc; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #00b347;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Agregar otro beneficiario</em>
                  		                    </a>
                                          <?php
                                        }else{
                                          //-----distinto beficiario
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Editar datos de otro beneficiario"
                                             data-target="#UpdateBeneficiarioHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijoid="<?php echo $row->leghijo_id; ?>"
                                             data-empid="<?php echo $emp->legempleado_id; ?>"
                                             data-empndoc="<?php echo $emp->legempleado_nrodocto; ?>"
                                             data-benndoc="<?php echo $row->leghijo_benndoc; ?>"
                                             data-hbenndoc="<?php echo $row->leghijo_benndoc; ?>"
                                             data-hbennoficio="<?php echo $row->leghijo_bennoficio; ?>"
                                             data-hbenapellido="<?php echo $row->leghijo_benapellido; ?>"
                                             data-hbennombres="<?php echo $row->leghijo_bennombres; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Editar otro beneficiario</em>
                  		                    </a>
                                          <?php
                                        }
                                      ?>
                                      <?php
                                      if($row->leghijo_mopndoc > 0){
                                        //--Existen datos de mop
                                        if($emp->sexo_id == 1){
                                          //empleado masculino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legempleado_id; ?>"
                                             data-hmopndoc="<?php echo $row->leghijo_mopndoc; ?>"
                                             data-hmopapellido="<?php echo $row->leghijo_mopapellido; ?>"
                                             data-hmopnombres="<?php echo $row->leghijo_mopnombres; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Editar datos de la madre</em>
                  		                    </a>
                                          <?php
                                        }else{
                                          //empleado femenino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legempleado_id; ?>"
                                             data-hmopndoc="<?php echo $row->leghijo_mopndoc; ?>"
                                             data-hmopapellido="<?php echo $row->leghijo_mopapellido; ?>"
                                             data-hmopnombres="<?php echo $row->leghijo_mopnombres; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Editar datos del padre</em>
                  		                    </a>
                                          <?php
                                        }
                                      }else{
                                        //-- No hay datos de mop
                                        if($emp->sexo_id == 1){
                                          //empleado masculino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legempleado_id; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #00b347;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Agregar datos de la madre</em>
                  		                    </a>
                                          <?php
                                        }else{
                                          //empleado femenino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legempleado_id; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Agregar datos del padre</em>
                  		                    </a>
                                          <?php
                                        }
                                      }
                                      ?>
                                      <a href="#"
                                         class="dropdown-item"
                                         data-toggle="modal"
                                         title="Deshabilitar Asignacion"
                                         data-target="#dataDisableHijo"
                                         data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                         data-id="<?php echo $row->leghijo_id; ?>"
                                         data-empid="<?php echo $emp->legempleado_id; ?>"
                                         data-empndoc="<?php echo $emp->legempleado_nrodocto; ?>"
                                         data-benndoc="<?php echo $row->leghijo_benndoc; ?>">
                                         <i class="fa fa-toggle-off" ></i>
                                         &nbsp;&nbsp;&nbsp;<em>Deshabilitar asignacion</em>
                                      </a>
              											</div>
              										</div>
																</td>
															</tr>
														<?php endforeach; ?>
														</tbody>
													</table>
													<?php
												}else{
													//---- No tiene Hijos escolares con discapacidad
												}
											?>
										</div>
									</div>
                  <!-- HIJO CON ASIGNACION DESHABILITADA -->
									<div class="col-md-12">
										<div class="form-group">
											<?php
												//$escuelanivel = 1;
												$hijosasignaciondes = $this->model->ObtenerHijosAsignacionDeshabilitada($empleadonrodocto);
												$hijosasignaciondesc = count($hijosasignaciondes);
												if($hijosasignaciondesc > 0){
													?>
													<div class="clearfix">
                            <h5 class="text-danger">
                              <label>
                                Hijo/s con Asignacion Deshabilitada
                                <span class="badge badge-pill badge-danger">
                                  <?php echo $hijosasignaciondesc; ?>
                                </span>
                              </label>
                            </h5>
														<p></p>
													</div>
													<table class="resp2">
														<thead>
															<tr>
																<th scope="col">DNI</th>
																<th scope="col">APELLIDO Y NOMBRES</th>
																<th scope="col">ESCUELA</th>
																<th scope="col">BENEFICIARIO</th>
																<th width="18%" scope="col">ACCIONES</th>
															</tr>
														</thead>
														<tbody>
															<?php
																//$nrodocto = $emp->legempleado_nrodocto;
																foreach($hijosasignaciondes as $row):
															?>
															<tr>
																<td><?php	echo $row->leghijo_nrodocto; ?></td>
																<td><?php echo $row->leghijo_apellido.", ".$row->leghijo_nombres;	?></td>
																<td>
                                  <?php
                                    if($row->leghijo_esc == 1){
                                      //escolar
                                      //echo $row->escuela_nombre;
                                      echo "*";
                                    }else{
                                      //no escolar
                                      echo "*";
                                    }
                                  ?>
                                </td>

																<td><?php echo $row->leghijo_benndoc." - ".$row->leghijo_benapellido.", ".$row->leghijo_bennombres; ?></td>
                                <td style="text-align: right;">
                                  <div class="dropdown">
              											<a class="btn btn-info dropdown-toggle" href="#" role="button" data-toggle="dropdown">
              												Opciones
              											</a>
              											<div class="dropdown-menu dropdown-menu-right">

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
              		                       data-target="#dataViewHijo"
              		                       data-titulo="<?php echo ""; ?>">
                                         <i class="fa fa-eye" style="color: #00b347;"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Ver detalles</em>
              		                    </a>

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
                                         data-target="#dataDeleteHijo"
                                         data-id="<?php echo $row->leghijo_id; ?>"
                                         data-empid="<?php echo $emp->legempleado_id; ?>"
                                         data-empndoc="<?php echo $emp->legempleado_nrodocto; ?>"
                                         data-benndoc="<?php echo $row->leghijo_benndoc; ?>">
                                         <i class="ion-android-delete fa-lg" style="color: #FF0000"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Eliminar hijo</em>
              		                    </a>

                                      <a href="#"
                                         class="dropdown-item"
                                         data-toggle="modal"
                                         title="Habilitar Asignacion"
                                         data-target="#dataEnableHijo"
                                         data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                         data-id="<?php echo $row->leghijo_id; ?>"
                                         data-empid="<?php echo $emp->legempleado_id; ?>"
                                         data-empndoc="<?php echo $emp->legempleado_nrodocto; ?>"
                                         data-benndoc="<?php echo $row->leghijo_benndoc; ?>">
                                         <i class="fa fa-toggle-on" style="color: #00b347;"></i>
                                         &nbsp;&nbsp;&nbsp;<em>Habilitar asignacion</em>
                                      </a>
              											</div>
              										</div>
																</td>
															</tr>
														<?php endforeach; ?>
														</tbody>
													</table>
													<?php
												}else{
													//---- No tiene Hijos en escuela pre-escolar
												}
											?>
										</div>
									</div>
                  <!-- Pre-Natal CON ASIGNACION DESHABILITADA -->
									<div class="col-md-12">
										<div class="form-group">
											<?php
												//$escuelanivel = 1;
												$prenatalasignaciondes = $this->model->ObtenerPreNatalAsignacionDeshabilitada($empleadonrodocto);
												$prenatalasignaciondesc = count($prenatalasignaciondes);
												if($prenatalasignaciondesc > 0){
													?>
													<div class="clearfix">
                            <h5 class="text-danger">
                              <label>
                                Pre-Natal/s con Asignacion Deshabilitada
                                <span class="badge badge-pill badge-danger">
                                  <?php echo $prenatalasignaciondesc; ?>
                                </span>
                              </label>
                            </h5>
														<p></p>
													</div>
													<table class="resp2">
														<thead>
                              <tr>
																<th scope="col">FUM</th>
																<th scope="col">FPP</th>
																<th scope="col">BENEFICIARIO</th>
																<th width="18%" scope="col">ACCIONES</th>
															</tr>
														</thead>
														<tbody>
															<?php
																//$nrodocto = $emp->legempleado_nrodocto;
																foreach($prenatalasignaciondes as $row):
                                  $fum = date("d/m/Y", strtotime($row->legprenatal_fecum));
																	$fpp = date("d/m/Y", strtotime($row->legprenatal_fecpp));
															?>
															<tr>
																<td><?php	echo $fum; ?></td>
																<td><?php echo $fpp;	?></td>
																<td>
                                  <?php echo $row->legprenatal_benndoc." - ".$row->legprenatal_benapellido.", ".$row->legprenatal_bennombres; ?>
                                </td>
                                <td style="text-align: right;">
                                  <div class="dropdown">
              											<a class="btn btn-info dropdown-toggle" href="#" role="button" data-toggle="dropdown">
              												Opciones
              											</a>
              											<div class="dropdown-menu dropdown-menu-right">

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
              		                       data-target="#dataViewHijo"
              		                       data-titulo="<?php echo ""; ?>">
                                         <i class="fa fa-eye" style="color: #00b347;"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Ver detalles</em>
              		                    </a>

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
                                         data-target="#dataDeletePreNatal"
                                         data-prenid="<?php echo $row->legprenatal_id; ?>"
                                         data-empid="<?php echo $emp->legempleado_id; ?>"
                                         data-empndoc="<?php echo $emp->legempleado_nrodocto; ?>"
                                         data-benndoc="<?php echo $row->legprenatal_benndoc; ?>">
                                         <i class="ion-android-delete fa-lg" style="color: #FF0000"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Eliminar Pre-Natal</em>
              		                    </a>

                                      <a href="#"
                                         class="dropdown-item"
                                         data-toggle="modal"
                                         title="Habilitar Pre-Natal"
                                         data-target="#dataEnablePreNatal"
                                         data-titulo="<?php echo "Habilitar Pre-Natal"; ?>"
                                         data-prenid="<?php echo $row->legprenatal_id; ?>"
                                         data-empid="<?php echo $emp->legempleado_id; ?>"
                                         data-empndoc="<?php echo $emp->legempleado_nrodocto; ?>"
                                         data-benndoc="<?php echo $row->legprenatal_benndoc; ?>">
                                         <i class="fa fa-toggle-on" style="color: #00b347;"></i>
                                         &nbsp;&nbsp;&nbsp;<em>Habilitar asignacion</em>
                                      </a>

              											</div>
              										</div>
																</td>
															</tr>
														<?php endforeach; ?>
														</tbody>
													</table>
													<?php
												}else{
													//---- No tiene Hijos en escuela pre-escolar
												}
											?>
										</div>
									</div>
									<!-- HIJOS SIN ASIGNACION -->
									<div class="col-md-12">
										<div class="form-group">
											<?php
												$hijossinasignacion = $this->model->ObtenerHijosSinAsignacion($empleadonrodocto, $fechaactual, $fechafinal);
												$hijossinasignacionc = count($hijossinasignacion);
												if($hijossinasignacionc > 0){
													?>
													<div class="clearfix">
                            <h5 class="text-danger">
                              <label>
                                Hijo/s sin asignacion/es
                                <span class="badge badge-pill badge-danger">
                                  <?php echo $hijossinasignacionc; ?>
                                </span>
                              </label>
                            </h5>
														<p></p>
													</div>
													<table class="resp2">
														<thead>
															<tr>
																<th scope="col">DNI</th>
																<th scope="col">APELLIDO Y NOMBRES</th>
																<th scope="col">EDAD</th>
																<th scope="col">BENEFICIARIO</th>
																<th width="18%" scope="col">ACCIONES</th>
															</tr>
														</thead>
														<tbody>
															<?php
																foreach($hijossinasignacion as $row):
															?>
															<tr>
																<td>
																	<?php	echo $row->leghijo_nrodocto; ?>
																</td>
																<td>
																	<?php echo $row->leghijo_apellido.", ".$row->leghijo_nombres;	?>
																</td>
																<td>
                                </td>
																<td>
																	<?php echo $row->leghijo_benndoc." - ".$row->leghijo_benapellido.", ".$row->leghijo_bennombres; ?>
																</td>
                                <td style="text-align: right;">
                                  <div class="dropdown">
              											<a class="btn btn-info dropdown-toggle" href="#" role="button" data-toggle="dropdown">
              												Opciones
              											</a>
              											<div class="dropdown-menu dropdown-menu-right">

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
              		                       data-target="#dataViewHijo"
              		                       data-titulo="<?php echo ""; ?>">
                                         <i class="fa fa-eye" style="color: #00b347;"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Ver detalles</em>
              		                    </a>

              												<a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
                                         data-target="#dataUpdateHijo"
                                         data-titulo="<?php echo "Edicion: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                         data-id="<?php echo $row->leghijo_id; ?>"
                                         data-hijotdoc="<?php echo $row->leghijo_tipodocto; ?>"
                                         data-hijondoc="<?php echo $row->leghijo_nrodocto; ?>"
                                         data-hijoapellido="<?php echo $row->leghijo_apellido; ?>"
                                         data-hijonombres="<?php echo $row->leghijo_nombres; ?>"
                                         data-hijonrocuil="<?php echo $row->leghijo_nrocuil; ?>"
                                         data-hijosexo="<?php echo $row->sexo_id; ?>"
                                         data-hijofecnacto="<?php echo $row->leghijo_fecnacto; ?>"
                                         data-hijodireccion="<?php echo $row->leghijo_direccion; ?>"
                                         data-hijodirecnro="<?php echo $row->leghijo_direcnro; ?>"
                                         data-hijodirecpiso="<?php echo $row->leghijo_direcpiso; ?>"
                                         data-hijocodpostal="<?php echo $row->leghijo_codpostal; ?>"
                                         data-hijoppdl="<?php echo $row->pais_id."-".$row->provincia_id."-".$row->departamento_id."-".$row->localidad_id; ?>"
                                         data-hijopais="<?php echo $row->pais_id; ?>"
                                         data-hijoprovincia="<?php echo $row->provincia_id; ?>"
                                         data-hijodepartamento="<?php echo $row->departamento_id; ?>"
                                         data-hijolocalidad="<?php echo $row->localidad_id; ?>"
                                         data-hijodisc="<?php echo $row->leghijo_disc; ?>"
                                         data-hijoesc="<?php echo $row->leghijo_esc; ?>"
                                         data-hijoescnom="<?php echo $row->escuela_id; ?>"
                                         data-hijoescnvl="<?php echo $row->escnivel_id; ?>"
                                         data-hijoescest="<?php echo $row->escestado_id; ?>"
                                         data-hijomoptdoc="<?php echo $row->leghijo_moptdoc; ?>"
                                         data-hijomopndoc="<?php echo $row->leghijo_mopndoc; ?>"
                                         data-hijomopapellido="<?php echo $row->leghijo_mopapellido; ?>"
                                         data-hijomopnombres="<?php echo $row->leghijo_mopnombres; ?>"
                                         data-hijobentdoc="<?php echo $row->leghijo_bentdoc; ?>"
                                         data-hijobennoficio="<?php echo $row->leghijo_bennoficio; ?>"
                                         data-hijobenndoc="<?php echo $row->leghijo_benndoc; ?>"
                                         data-hijobenapellido="<?php echo $row->leghijo_benapellido; ?>"
                                         data-hijobennombres="<?php echo $row->leghijo_bennombres; ?>"
                                         data-empid="<?php echo $emp->legempleado_id; ?>"
                                         data-empnrodocto="<?php echo $emp->legempleado_nrodocto; ?>"
                                         data-bennrodocto="<?php echo $row->leghijo_benndoc; ?>">
                                         <i class="ion-compose fa-lg" style="color: #0000ff;"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Editar hijo</em>
              		                    </a>
                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
              		                       data-target="#dataUpdateEscuelaHijo"
              		                       data-titulo="<?php echo "Agregar Escuela"; ?>"
                                         data-hijoid="<?php echo $row->leghijo_id; ?>"
                                         data-empid="<?php echo $emp->legempleado_id; ?>"
                                         data-empnrodocto="<?php echo $emp->legempleado_nrodocto; ?>"
                                         data-bennrodocto="<?php echo $row->leghijo_benndoc; ?>"
                                         data-hescid="<?php echo $row->escuela_id; ?>"
                                         data-hescnvl="<?php echo $row->escnivel_id; ?>">
                                         <span class="ti-home" style="color: #00b347;"></span>
              													 &nbsp;&nbsp;&nbsp;<em>Editar datos escolares</em>
              		                    </a>
                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
                                         data-target="#dataDeleteHijo"
                                         data-id="<?php echo $row->leghijo_id; ?>"
                                         data-empid="<?php echo $emp->legempleado_id; ?>"
                                         data-empndoc="<?php echo $emp->legempleado_nrodocto; ?>"
                                         data-benndoc="<?php echo $row->leghijo_benndoc; ?>">
                                         <i class="ion-android-delete fa-lg" style="color: #FF0000"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Eliminar hijo</em>
              		                    </a>
              											</div>
              										</div>
																</td>
															</tr>
														<?php endforeach; ?>
														</tbody>
													</table>
													<?php
												}else{
													//---- No tiene Hijos menores
												}
											?>
										</div>
									</div>
								</div>
                <br><br>
                <br><br>
                <br><br>
                <br><br>
							</section>
						</form>
					</div>
				</div>
				<!-- success Popup html Start -->

				<!-- success Popup html End -->
			</div>
			<?php include('../../includes/footer.php'); ?>
		</div>
	</div>
	<?php include('../../includes/script.php'); ?>
	<script src="../../src/plugins/jquery-steps/build/jquery.steps.js"></script>
  <script src="includes/js/empleado-editar.js"></script>
	<!--<script src="includes/js/empleadoseditar.js"></script>-->
	<script src="includes/js/contrato.js"></script>
	<script src="includes/js/estudios.js"></script>
	<script src="includes/js/relojes.js"></script>
	<!--<script src="includes/js/conyuge.js"></script>-->
	<script src="includes/js/prenatal.js"></script>
	<script src="includes/js/hijos.js"></script>

  <!--<script src="../../src/plugins/bootstrap-select/dist/js/bootstrap-select.min.js"></script>-->
  <!--<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>-->


	<script>
			/*
			var form = $(this);
			form.validate({
				errorPlacement: function errorPlacement(error, element) { element.before(error); },
				rules: {
					//confirm: {
					//equalTo: "#empapellido"
					//}
				}
			});
			*/

			$(".tab-wizard").steps({
				headerTag: "h5",
				bodyTag: "section",
				transitionEffect: "fade",
				//saveState: true,
				enableAllSteps: true,
				startIndex: <?php echo $_REQUEST['startIndex']; ?>,
				titleTemplate: '<span class="step">#index#</span> #title#',
				labels: {
					current: "current step:",
        	pagination: "Pagination",
        	finish: "Ir a Listado",
        	next: "Siguiente",
        	previous: "Anterior",
        	loading: "Loading ..."
				},
				/*
				onStepChanging: function (event, currentIndex, newIndex){

					var form = $(this);
        	form.validate().settings.ignore = ":disabled,:hidden";

        	return form.valid();


    		},
				*/
				/*
    		onFinishing: function (event, currentIndex){
        	form.validate().settings.ignore = ":disabled";
        	return form.valid();
    		},
				*/
				onFinished: function (event, currentIndex){
					var form = $(this);
          form.submit();
				}
			});
	</script>
</body>
</html>
