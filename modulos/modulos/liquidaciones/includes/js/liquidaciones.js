//---- Autocompletado de datos de empleados -----
jQuery(document).ready(function(){
	$('#txtnrodoctoe').blur (function(){
		var valor = jQuery("#txtnrodoctoe").val();
		$.ajax ({
			//url:"includes/php/autocompletar_empleado.php",
			url:"?c=empleado&a=EmpleadoAutocompletar",
			type:"POST",
			dataType:"json",
			data: {val:valor},
			success: function(res){
				$('.alert').hide();
				$('.modal-body #hddempide').val(res.empid);
				//$('#txtnrodoctoe').val(res.empdni);
				$('#txtempnrocuile').val(res.empcuil);
				$('#txtempnrolegajoe').val(res.emplegajo);
				$('#txtempapellidoe').val(res.empapellido);
				$('#txtempnombrese').val(res.empnombres);
				$('#cboempsexoe').val(res.empsexo);
				$('#cboempestadocivile').val(res.empecivil);
				$('#txtempfecnace').val(res.empfecnacto);
				$('#txtempfecinge').val(res.empfecingreso);

				var empactivo = res.empactivo;
				if(empactivo == 1){
					/*$("input").prop('disabled', true);
					$("select").prop('disabled', true);*/
					$("#txtempnrocuile").prop('disabled', true);
					$("#txtempnrolegajoe").prop('disabled', true);
					$("#txtempapellidoe").prop('disabled', true);
					$("#txtempnombrese").prop('disabled', true);
					$("#cboempsexoe").prop('disabled', true);
					$("#cboempestadocivile").prop('disabled', true);
					$("#txtempfecnace").prop('disabled', true);
					$("#txtempfecinge").prop('disabled', true);
					$("#btnempleadoguardar").prop('disabled', true);
					$("#txtnrodoctoe").focus();
					$(".alert-empactivo").show();
				}else if(empactivo == 0){
					//$('#hddempmovimientoe').val(3);
					$("#txtempnrocuile").prop('disabled', false);
					$("#txtempnrolegajoe").prop('disabled', false);
					$("#txtempapellidoe").prop('disabled', false);
					$("#txtempnombrese").prop('disabled', false);
					$("#cboempsexoe").prop('disabled', false);
					$("#cboempestadocivile").prop('disabled', false);
					$("#txtempfecnace").prop('disabled', false);
					$("#txtempfecinge").prop('disabled', false);
					$("#btnempleadoguardar").prop('disabled', false);
					$("#txtempnrocuile").focus();
					$(".alert-empinactivo").show();
				}else{
					//$('#hddempmovimientoe').val(1);
					$("#txtempnrocuile").prop('disabled', false);
					$("#txtempnrolegajoe").prop('disabled', false);
					$("#txtempapellidoe").prop('disabled', false);
					$("#txtempnombrese").prop('disabled', false);
					$("#cboempsexoe").prop('disabled', false);
					$("#cboempestadocivile").prop('disabled', false);
					$("#txtempfecnace").prop('disabled', false);
					$("#txtempfecinge").prop('disabled', false);
					$("#btnempleadoguardar").prop('disabled', false);
					$("#txtempnrocuile").focus();
				}

			}
		})
	})
});

$(document).ready(function(){
	//------Al cargar el formulario datos de domicilio en vista-------
	//$.get("includes/php/obtener_provincias.php","pais="+$("#empppdl").val(), function(data){
	$.get("?c=empleado&a=ProvinciasObtener","pais="+$("#empppdl").val(), function(data){
		$("#cboempprovinciam").html(data);
		//console.log(data);
	});
	//$.get("includes/php/obtener_departamentos.php","provincia="+$("#empppdl").val(), function(data){
	$.get("?c=empleado&a=DepartamentosObtener","provincia="+$("#empppdl").val(), function(data){
		$("#cboempdepartamentom").html(data);
		//console.log(data);
	});
	//$.get("includes/php/obtener_localidades.php","departamento="+$("#empppdl").val(), function(data){
	$.get("?c=empleado&a=LocalidadesObtener","departamento="+$("#empppdl").val(), function(data){
		$("#cboemplocalidadm").html(data);
		//console.log(data);
	});
	//----Al momento de cambiar datos de domicilio en vista-------
	/*en desuso por deshabilitacion de cajas
	$("#cboemppaism").change(function(){
		$.get("includes/php/obtener_provincias.php","pais="+$("#cboemppaism").val(), function(data){
			$("#cboempprovinciam").html(data);
			console.log(data);
		});
	});
	$("#cboempprovinciam").change(function(){
		$.get("includes/php/obtener_departamentos.php","provincia="+$("#cboempprovinciam").val(), function(data){
			$("#cboempdepartamentom").html(data);
			console.log(data);
		});
	});
	$("#cboempdepartamentom").change(function(){
		$.get("includes/php/obtener_localidades.php","departamento="+$("#cboempdepartamentom").val(), function(data){
			$("#cboemplocalidadm").html(data);
			console.log(data);
		});
	});
	*/
	//----Al momento de cambiar datos de domicilio en modificacion-------
	$("#cboemppaise").change(function(){
		//$.get("includes/php/obtener_provincias.php","pais="+$("#cboemppaise").val(), function(data){
		$.get("?c=empleado&a=ProvinciasObtener","pais="+$("#cboemppaise").val(), function(data){
			$("#cboempprovinciae").html(data);
			//console.log(data);
		});
	});
	$("#cboempprovinciae").change(function(){
		//$.get("includes/php/obtener_departamentos.php","provincia="+$("#cboempprovinciae").val(), function(data){
		$.get("?c=empleado&a=DepartamentosObtener","provincia="+$("#cboempprovinciae").val(), function(data){
			$("#cboempdepartamentoe").html(data);
			//console.log(data);
		});
	});
	$("#cboempdepartamentoe").change(function(){
		//$.get("includes/php/obtener_localidades.php","departamento="+$("#cboempdepartamentoe").val(), function(data){
		$.get("?c=empleado&a=LocalidadesObtener","departamento="+$("#cboempdepartamentoe").val(), function(data){
			$("#cboemplocalidade").html(data);
			//console.log(data);
		});
	});

});
//----- Ventana modal Empleados - Dar de baja---
$('#EmpleadoBaja').on('show.bs.modal', function (event){
//$('#EmpleadoEditarDatosPersonales').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget) // Botón que activó el modal
	var titulo = button.data('titulo') // Extraer la información de atributos de datos
	var empid = button.data('empid') // Extraer la información de atributos de datos
	var empnrodocto = button.data('empnrodocto')

	var modal = $(this)
	modal.find('.modal-header .modal-title').text(titulo)
	modal.find('.modal-body #hddempide').val(empid)
	modal.find('.modal-body #hddempnrodoctoe').val(empnrodocto)

	/*
	//--- llenar tabla con datos de imputacion seleccionada ----
	var params = {
		"Id" : empid
	};
	//llamada al fichero PHP con AJAX
	$.ajax({
		data:  params,
		url:   'includes/php/empleado-baja.php',
		dataType: 'html',
		type:  'post',
		beforeSend: function () {
			//mostramos gif "cargando"
			//jQuery('#loading_spinner').show();
			//antes de enviar la petición al fichero PHP, mostramos mensaje
			jQuery("#tabladato").html("   Déjame pensar un poco...");
		},
		success:  function (response) {
			//escondemos gif
			//jQuery('#loading_spinner').hide();
			//mostramos salida del PHP
			jQuery("#tabladato").html(response);
		}
	});
	*/
	$('.alert').hide();//Oculto alert

})
//----- Ventana modal Empleados - Datos Personales---
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
	$('.alert').hide();//Oculto alert

})
/*function enfoque(){
	$('#txtnrodoctoe').prop('disabled', true);
	$('#txtempnrocuile').val(255000);
	//$(".txtempnrocuile").focus();
	 //$('#txtempnrocuile').trigger('focus');
	//$("input#txtempnrocuile").focus();
	//document.getElementById("txtempnrocuile").focus();
	//$(event.currentTarget).find('input#photo_name').first().focus()
}*/
//----- llenar ventana modal con datos de edicion de contrato ---
$('#EmpleadoEditarDomicilio').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget) // Botón que activó el modal
	var titulo = button.data('titulo') // Extraer la información de atributos de datos
	var empid = button.data('empid') // Extraer la información de atributos de datos
	var empnrodocto = button.data('empnrodocto')
	var empdireccion = button.data('empdireccion')
	var empdirecnro = button.data('empdirecnro')
	var empdirecpiso = button.data('empdirecpiso')
	var empcpostal = button.data('empcpostal')
	var emppais = button.data('emppais')
	var empprovincia = button.data('empprovincia')
	var empdepartamento = button.data('empdepartamento')
	var emplocalidad = button.data('emplocalidad')

	var modal = $(this)
	modal.find('.modal-title').text(titulo)
	modal.find('.modal-body #hddempide').val(empid)
	modal.find('.modal-body #hddempnrodoctoe').val(empnrodocto)
	modal.find('.modal-body #txtempdireccione').val(empdireccion)
	modal.find('.modal-body #txtempdirenroe').val(empdirecnro)
	modal.find('.modal-body #txtempdirecpisoe').val(empdirecpiso)
	modal.find('.modal-body #txtempcpostale').val(empcpostal)
	modal.find('.modal-body #cboemppaise').val(emppais)
	//modal.find('.modal-body #cboempprovinciae').val(empprovincia)
	//$.get("includes/php/obtener_provincias.php","pais="+$("#cboemppaise").val(), function(data){
	$.get("?c=empleado&a=ProvinciasObtener","pais="+$("#cboemppaise").val(), function(data){
		$("#cboempprovinciae").html(data);
		modal.find('.modal-body #cboempprovinciae').val(empprovincia)
		//console.log(data);
	});
	//modal.find('.modal-body #cboempprovinciae').val(empprovincia)
	//$.get("includes/php/obtener_departamentos.php",{provincia: empprovincia}, function(data){
	$.get("?c=empleado&a=DepartamentosObtener",{provincia: empprovincia}, function(data){
		$("#cboempdepartamentoe").html(data);
		modal.find('.modal-body #cboempdepartamentoe').val(empdepartamento)
		//console.log(data);
	});
	//$.get("includes/php/obtener_localidades.php",{departamento: empdepartamento}, function(data){
	$.get("?c=empleado&a=LocalidadesObtener",{departamento: empdepartamento}, function(data){
		$("#cboemplocalidade").html(data);
		modal.find('.modal-body #cboemplocalidade').val(emplocalidad)
		//console.log(data);
	});

	$('.alert').hide();//Oculto alert
})
//----- llenar ventana modal con datos de edicion de contrato ---
$('#EmpleadoEditarContacto').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget) // Botón que activó el modal
	var titulo = button.data('titulo') // Extraer la información de atributos de datos
	var empid = button.data('empid') // Extraer la información de atributos de datos
	var empnrodocto = button.data('empnrodocto')
	var empcelular = button.data('empcelular')
	var emptelefono = button.data('emptelefono')
	var empemail = button.data('empemail')

	var modal = $(this)
	modal.find('.modal-title').text(titulo)
	modal.find('.modal-body #hddempide').val(empid)
	modal.find('.modal-body #hddempnrodoctoe').val(empnrodocto)
	modal.find('.modal-body #txtempcelulare').val(empcelular)
	modal.find('.modal-body #txtemptelefonoe').val(emptelefono)
	modal.find('.modal-body #txtempemaile').val(empemail)

	$('.alert').hide();//Oculto alert
})
//----------------todo lo nuevo-------
//----- Ventana modal liquidacionse - alta descuentos ---
$('#LiquidacionAltaDescuentos').on('show.bs.modal', function (event){
//$('#EmpleadoEditarDatosPersonales').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget) // Botón que activó el modal
	var titulo = button.data('titulo') // Extraer la información de atributos de datos
	var ndoc = button.data('ndoc')
	var empndoc = button.data('empndoc')
	var periodo = button.data('periodo')
	var titular = button.data('titular')

	var modal = $(this)
	modal.find('.modal-header .modal-title').text(titulo)
	modal.find('.modal-body #hddndoce').val(ndoc)
	modal.find('.modal-body #hddempndoclde').val(empndoc)
	modal.find('.modal-body #hddperiodoe').val(periodo)
	modal.find('.modal-body #hddtitulare').val(titular)

	$('.alert').hide();//Oculto alert

})
$('#LiquidacionAltaHaberes').on('show.bs.modal', function (event){
//$('#EmpleadoEditarDatosPersonales').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget) // Botón que activó el modal
	var titulo = button.data('titulo') // Extraer la información de atributos de datos
	var licempndoc = button.data('licempndoc')
	var titular = button.data('titular')

	var modal = $(this)
	modal.find('.modal-header .modal-title').text(titulo)
	modal.find('.modal-body #hddlicndoc').val(licempndoc)


	$('.alert').hide();//Oculto alert

})