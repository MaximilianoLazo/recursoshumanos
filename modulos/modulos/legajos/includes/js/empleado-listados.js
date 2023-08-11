	/*function load(page){
	}*/
	/*
	$('#dataAddEmpleado').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget) // Botón que activó el modal
		var titulo = button.data('titulo') // Extraer la información de atributos de datos
		//llenar datos en text
		var modal = $(this)
		modal.find('.modal-title').text(titulo)
		//$('.alert').hide();//Oculto alert
	})
	*/
	$("#CboSecretarias").change(function(){
		$.get("includes/php/obtener_lugaresdetrabajo2.php","secretaria="+$("#CboSecretarias").val(), function(data){
			$("#CboEmpLTrabajo").html(data);
			console.log(data);
		});
	});
	/*
	$("#empprovincia").change(function(){
		$.get("includes/php/obtener_departamentos.php","provincia="+$("#empprovincia").val(), function(data){
			$("#empdepartamento").html(data);
			console.log(data);
		});
	});
	*/
	/*
	$("#empdepartamento").change(function(){
		$.get("includes/php/obtener_localidades.php","departamento="+$("#empdepartamento").val(), function(data){
			$("#emplocalidad").html(data);
			console.log(data);
		});
	});
*/
