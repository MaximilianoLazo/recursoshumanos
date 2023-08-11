	function load(page){
		var parametros = {"action":"ajax","page":page};
		$("#loader").fadeIn('slow');
		$.ajax({
			url:'paises_ajax.php',
			data: parametros,
			 beforeSend: function(objeto){
			$("#loader").html("<img src='loader.gif'>");
			},
			success:function(data){
				$(".outer_div").html(data).fadeIn('slow');
				$("#loader").html("");
			}
		})
	}

	$('#dataAddConyuge').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget) // Botón que activó el modal
		var titulo = button.data('titulo') // Extraer la información de atributos de datos
		var empid = button.data('empid') // Extraer la información de atributos de datos
		var empnrodocto = button.data('empnrodocto') // Extraer la información de atributos de datos
		//$.get("includes/php/obtener_provincias.php","pais="+$("#conyugepais").val(), function(data){
		$.get("?c=empleado&a=ProvinciasObtener","pais="+$("#conyugepais").val(), function(data){
			$("#conyugeprovincia").html(data);
			console.log(data);
		});
		//$.get("includes/php/obtener_departamentos.php","provincia="+$("#conyugeprovincia").val(), function(data){
		$.get("?c=empleado&a=DepartamentosObtener","provincia="+$("#conyugeprovincia").val(), function(data){
			$("#conyugedepartamento").html(data);
			console.log(data);
		});
		//$.get("includes/php/obtener_localidades.php","departamento="+$("#conyugedepartamento").val(), function(data){
		$.get("?c=empleado&a=LocalidadesObtener","departamento="+$("#conyugedepartamento").val(), function(data){
			$("#conyugelocalidad").html(data);
			console.log(data);
		});

		var modal = $(this)
		modal.find('.modal-title').text(titulo)
		modal.find('.modal-body #empid').val(empid)
		modal.find('.modal-body #empnrodocto').val(empnrodocto)
		//$('.alert').hide();//Oculto alert
	})

		$('#dataUpdate').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget) // Botón que activó el modal
		  var empnrodocto = button.data('empnrodocto') // Extraer la información de atributos de datos
		  var id = button.data('id') // Extraer la información de atributos de datos
			var empid = button.data('empid') // Extraer la información de atributos de datos
			var relojnom = button.data('relojnom') // Extraer la información de atributos de datos
			var luneshe = button.data('luneshe') // Extraer la información de atributos de datos
			var luneshs = button.data('luneshs') // Extraer la información de atributos de datos
			var lunes = button.data('lunes')
			var marteshe = button.data('marteshe') // Extraer la información de atributos de datos
			var marteshs = button.data('marteshs') // Extraer la información de atributos de datos
			var martes = button.data('martes')
			var miercoleshe = button.data('miercoleshe') // Extraer la información de atributos de datos
			var miercoleshs = button.data('miercoleshs') // Extraer la información de atributos de datos
			var miercoles = button.data('miercoles')
			var jueveshe = button.data('jueveshe') // Extraer la información de atributos de datos
			var jueveshs = button.data('jueveshs') // Extraer la información de atributos de datos
			var jueves = button.data('jueves')
			var vierneshe = button.data('vierneshe') // Extraer la información de atributos de datos
			var vierneshs = button.data('vierneshs') // Extraer la información de atributos de datos
			var viernes = button.data('viernes')
			var sabadohe = button.data('sabadohe') // Extraer la información de atributos de datos
			var sabadohs = button.data('sabadohs') // Extraer la información de atributos de datos
			var sabado = button.data('sabado')
			var domingohe = button.data('domingohe') // Extraer la información de atributos de datos
			var domingohs = button.data('domingohs') // Extraer la información de atributos de datos
			var domingo = button.data('domingo')

		  var modal = $(this)
		  modal.find('.modal-title').text('Reloj: '+relojnom)
		  modal.find('.modal-body #id').val(id)
			modal.find('.modal-body #empid').val(empid)
		  modal.find('.modal-body #empnrodocto').val(empnrodocto)
			modal.find('.modal-body #luneshe').val(luneshe)
			modal.find('.modal-body #luneshs').val(luneshs)
			if (lunes == 1) {
    		modal.find('.modal-body #lunes').prop('checked', true);
			}else{
    		modal.find('.modal-body #lunes').prop('checked', false);
			}
			modal.find('.modal-body #marteshe').val(marteshe)
			modal.find('.modal-body #marteshs').val(marteshs)
			if (martes == 1) {
    		modal.find('.modal-body #martes').prop('checked', true);
			}else{
    		modal.find('.modal-body #martes').prop('checked', false);
			}
			modal.find('.modal-body #miercoleshe').val(miercoleshe)
			modal.find('.modal-body #miercoleshs').val(miercoleshs)
			if (miercoles == 1) {
    		modal.find('.modal-body #miercoles').prop('checked', true);
			}else{
    		modal.find('.modal-body #miercoles').prop('checked', false);
			}
			modal.find('.modal-body #jueveshe').val(jueveshe)
			modal.find('.modal-body #jueveshs').val(jueveshs)
			if (jueves == 1) {
    		modal.find('.modal-body #jueves').prop('checked', true);
			}else{
    		modal.find('.modal-body #jueves').prop('checked', false);
			}
			modal.find('.modal-body #vierneshe').val(vierneshe)
			modal.find('.modal-body #vierneshs').val(vierneshs)
			if (viernes == 1) {
    		modal.find('.modal-body #viernes').prop('checked', true);
			}else{
    		modal.find('.modal-body #viernes').prop('checked', false);
			}
			modal.find('.modal-body #sabadohe').val(sabadohe)
			modal.find('.modal-body #sabadohs').val(sabadohs)
			if (sabado == 1) {
    		modal.find('.modal-body #sabado').prop('checked', true);
			}else{
    		modal.find('.modal-body #sabado').prop('checked', false);
			}
			modal.find('.modal-body #domingohe').val(domingohe)
			modal.find('.modal-body #domingohs').val(domingohs)
			if (domingo == 1) {
    		modal.find('.modal-body #domingo').prop('checked', true);
			}else{
    		modal.find('.modal-body #domingo').prop('checked', false);
			}
		  $('.alert').hide();//Oculto alert
		})

		$('#dataDelete').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget) // Botón que activó el modal
		  var id = button.data('id') // Extraer la información de atributos de datos
			var empid = button.data('empid')
			var modal = $(this)
		  modal.find('.modal-body #relojid').val(id)
			modal.find('.modal-body #empid').val(empid)
		})

	$( "#actualidarDatos" ).submit(function( event ) {
		var parametros = $(this).serialize();
			 $.ajax({
					type: "POST",
					url: "modificar.php",
					data: parametros,
					 beforeSend: function(objeto){
						$("#datos_ajax").html("Mensaje: Cargando...");
					  },
					success: function(datos){
					$("#datos_ajax").html(datos);

					load(1);
				  }
			});
		  event.preventDefault();
		});

		$( "#guardarDatos" ).submit(function( event ) {
		var parametros = $(this).serialize();
			 $.ajax({
					type: "POST",
					url: "agregar.php",
					data: parametros,
					 beforeSend: function(objeto){
						$("#datos_ajax_register").html("Mensaje: Cargando...");
					  },
					success: function(datos){
					$("#datos_ajax_register").html(datos);

					load(1);
				  }
			});
		  event.preventDefault();
		});

		$( "#eliminarDatos" ).submit(function( event ) {
		var parametros = $(this).serialize();
			 $.ajax({
					type: "POST",
					url: "eliminar.php",
					data: parametros,
					 beforeSend: function(objeto){
						$(".datos_ajax_delete").html("Mensaje: Cargando...");
					  },
					success: function(datos){
					$(".datos_ajax_delete").html(datos);

					$('#dataDelete').modal('hide');
					load(1);
				  }
			});
		  event.preventDefault();
		});
		$("#conyugepais").change(function(){
			//$.get("includes/php/obtener_provincias.php","pais="+$("#conyugepais").val(), function(data){
			$.get("?c=empleado&a=ProvinciasObtener","pais="+$("#conyugepais").val(), function(data){
				$("#conyugeprovincia").html(data);
				console.log(data);
			});
		});
		$("#conyugeprovincia").change(function(){
			//$.get("includes/php/obtener_departamentos.php","provincia="+$("#conyugeprovincia").val(), function(data){
			$.get("?c=empleado&a=DepartamentosObtener","provincia="+$("#conyugeprovincia").val(), function(data){
				$("#conyugedepartamento").html(data);
				console.log(data);
			});
		});
		$("#conyugedepartamento").change(function(){
			//$.get("includes/php/obtener_localidades.php","departamento="+$("#conyugedepartamento").val(), function(data){
			$.get("?c=empleado&a=LocalidadesObtener","departamento="+$("#conyugedepartamento").val(), function(data){
				$("#conyugelocalidad").html(data);
				console.log(data);
			});
		});
