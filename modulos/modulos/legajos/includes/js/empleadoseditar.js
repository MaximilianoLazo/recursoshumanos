$(document).ready(function(){

	////////////////////esto ya esta en empleado-editar/////////////
	/*
	//------al cargar el formulario-------
	$.get("includes/php/obtener_provincias.php","pais="+$("#empppdl").val(), function(data){
		$("#empprovincia").html(data);
		console.log(data);
	});
	$.get("includes/php/obtener_departamentos.php","provincia="+$("#empppdl").val(), function(data){
		$("#empdepartamento").html(data);
		console.log(data);
	});
	$.get("includes/php/obtener_localidades.php","departamento="+$("#empppdl").val(), function(data){
		$("#emplocalidad").html(data);
		console.log(data);
	});
	//$.get("includes/php/obtener_dependencias.php","imputacion="+$("#imputacion").val(), function(data){
		//$("#empimpdependencia").html(data);
		//console.log(data);
	//});
	//----al momento de cambiar-------
	$("#emppais").change(function(){
		$.get("includes/php/obtener_provincias.php","pais="+$("#emppais").val(), function(data){
			$("#empprovincia").html(data);
			console.log(data);
		});
	});
	$("#empprovincia").change(function(){
		$.get("includes/php/obtener_departamentos.php","provincia="+$("#empprovincia").val(), function(data){
			$("#empdepartamento").html(data);
			console.log(data);
		});
	});
	$("#empdepartamento").change(function(){
		$.get("includes/php/obtener_localidades.php","departamento="+$("#empdepartamento").val(), function(data){
			$("#emplocalidad").html(data);
			console.log(data);
		});
	});
	*/
	////////////////////fin esto ya esta en empleado-editar/////////////


	
	/*
	$("#empimputacion").change(function(){
		$.get("includes/php/obtener_dependencias.php","imputacion="+$("#empimputacion").val(), function(data){
			$("#empimpdependencia").html(data);
			console.log(data);
		});
	});
	*/
	//-----auto llenar datos reloj despues del cambio de dato ------
	jQuery(document).ready(function(){
		$('#empreloj').change({source:'includes/php/autocompletar_reloj.php', minLength:1});
		$('#empreloj').click (function(){
			var valor=$(this).val();
			$.ajax ({
				url:"includes/php/autocompletar_reloj2.php",
				type:"POST",
				dataType:"json",
				data: {val:valor},
				success: function(res){
					$('#emprelip').val(res.emprelip);
					$('#emprelnodo').val(res.emprelnodo);
					$('#empreltipo').val(res.empreltipo);
				 }
			})
		})

	});
	$("#frm-relojeditar").submit(function(){
			//return $(this).validate();
			$('.alert-reloj').show();
	});
});
