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
	//----Al momento de cambiar datos de domicilio conyuge en modificacion-------
	$("#cbocyepaise").change(function(){
		$.get("?c=empleado&a=ProvinciasObtener","pais="+$("#cbocyepaise").val(), function(data){
			$("#cbocyeprovinciae").html(data);
		});
	});
	$("#cbocyeprovinciae").change(function(){
		$.get("?c=empleado&a=DepartamentosObtener","provincia="+$("#cbocyeprovinciae").val(), function(data){
			$("#cbocyedepartamentoe").html(data);
		});
	});
	$("#cbocyedepartamentoe").change(function(){
		$.get("?c=empleado&a=LocalidadesObtener","departamento="+$("#cbocyedepartamentoe").val(), function(data){
			$("#cbocyelocalidade").html(data);
		});
	});

});
$('#UsrEditarClave').on('shown.bs.modal', function (event) {
	
	var button = $(event.relatedTarget) // Botón que activó el modal
	var titulo = button.data('titulo') // Extraer la información de atributos de datos
	var usrid = button.data('usrid')
	/*var clicod = button.data('clicod')
	var clindoc = button.data('clindoc')
	var cliap = button.data('cliap')
	var clinom = button.data('clinom')
	var clidirec = button.data('clidirec')
	var cliemp = button.data('cliemp')
	var cliperti = button.data('cliperti')*/

	var modal = $(this)
	modal.find('.modal-header .modal-title').text(titulo)
	modal.find('.modal-body #hddusuarioid').val(usrid)
	modal.find('.modal-body #txtclavenueva').val(usrid)
	/*modal.find('.modal-body #txtclientegnrodoc').val(clindoc)
	modal.find('.modal-body #txtclientegapellido').val(cliap)
	modal.find('.modal-body #txtclientegnombres').val(clinom)
	modal.find('.modal-body #txtclientegdireccion').val(clidirec)
	modal.find('.modal-body #cboclientegempresa').val(cliemp)
	modal.find('.modal-body #cboclientetipoperiodo').val(cliperti)
	$(".modal-body #txtclientegnrodoc").focus();
	//$('.alert').hide();//Oculto alert
	if(cliid > 0){

		modal.find('.modal-body #cboclientetipoperiodo').hide();
		modal.find('.modal-body #lblclientetipoperiodo').hide();
		
		modal.find('.modal-body #txtclientecredito').hide();
		modal.find('.modal-body #lblclientecredito').hide();

	}else{

		modal.find('.modal-body #cboclientetipoperiodo').show();
		modal.find('.modal-body #lblclientetipoperiodo').show();

		modal.find('.modal-body #txtclientecredito').show();
		modal.find('.modal-body #lblclientecredito').show();

	}*/
	

})

//----- Ventana modal Empleados - Dar de baja---
$('#UsuarioEditar').on('show.bs.modal', function (event){
//$('#EmpleadoEditarDatosPersonales').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget) // Botón que activó el modal
	var titulo = button.data('titulo') // Extraer la información de atributos de datos
	/*var empid = button.data('empid') // Extraer la información de atributos de datos
	var empnrodocto = button.data('empnrodocto')*/

	var modal = $(this)
	modal.find('.modal-header .modal-title').text(titulo)
	/*modal.find('.modal-body #hddempide').val(empid)
	modal.find('.modal-body #hddempnrodoctoe').val(empnrodocto)*/


	$('.alert').hide();//Oculto alert

})
