	/*
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
	*/

	$('#dataUpdateOBConfPreNatal').on('show.bs.modal', function (event){
		var button = $(event.relatedTarget) // Botón que activó el modal
		var titulo = button.data('titulo') // Extraer la información de atributos de datos
		var obcpniduno = button.data('obcpniduno') // Extraer la información de atributos de datos
		var obcpnhastauno = button.data('obcpnhastauno') // Extraer la información de atributos de datos
		var obcpniddos = button.data('obcpniddos') // Extraer la información de atributos de datos
		var obcpndesdedos = button.data('obcpndesdedos')
		var obcpnhastados = button.data('obcpnhastados') // Extraer la información de atributos de datos
		var obcpnidtres = button.data('obcpnidtres') // Extraer la información de atributos de datos
		var obcpndesdetres = button.data('obcpndesdetres') // Extraer la información de atributos de datos
		var obcpnhastatres = button.data('obcpnhastatres') // Extraer la información de atributos de datos
		var obcpnidcuatro = button.data('obcpnidcuatro') // Extraer la información de atributos de datos
		var obcpndesdecuatro = button.data('obcpndesdecuatro') // Extraer la información de atributos de datos

		var modal = $(this)
		modal.find('.modal-title').text(titulo)
		modal.find('.modal-body #obcpniduno').val(obcpniduno)
		modal.find('.modal-body #txtobcpnhastaunoed').val(obcpnhastauno)
		modal.find('.modal-body #obcpniddos').val(obcpniddos)
		modal.find('.modal-body #txtobcpndesdedosed').val(obcpndesdedos)
		modal.find('.modal-body #txtobcpnhastadosed').val(obcpnhastados)
		modal.find('.modal-body #obcpnidtres').val(obcpnidtres)
		modal.find('.modal-body #txtobcpndesdetresed').val(obcpndesdetres)
		modal.find('.modal-body #txtobcpnhastatresed').val(obcpnhastatres)
		modal.find('.modal-body #obcpnidcuatro').val(obcpnidcuatro)
		modal.find('.modal-body #txtobcpndesdecuatroed').val(obcpndesdecuatro)
		//$('.alert').hide();//Oculto alert
	})
	$('#dataUpdateOBConfHijo').on('show.bs.modal', function (event){
		var button = $(event.relatedTarget) // Botón que activó el modal
		var titulo = button.data('titulo') // Extraer la información de atributos de datos
		var obchiduno = button.data('obchiduno') // Extraer la información de atributos de datos
		var obchhastauno = button.data('obchhastauno') // Extraer la información de atributos de datos
		var obchiddos = button.data('obchiddos') // Extraer la información de atributos de datos
		var obchdesdedos = button.data('obchdesdedos')
		var obchhastados = button.data('obchhastados') // Extraer la información de atributos de datos
		var obchidtres = button.data('obchidtres') // Extraer la información de atributos de datos
		var obchdesdetres = button.data('obchdesdetres') // Extraer la información de atributos de datos
		var obchhastatres = button.data('obchhastatres') // Extraer la información de atributos de datos
		var obchidcuatro = button.data('obchidcuatro') // Extraer la información de atributos de datos
		var obchdesdecuatro = button.data('obchdesdecuatro') // Extraer la información de atributos de datos

		var modal = $(this)
		modal.find('.modal-title').text(titulo)
		modal.find('.modal-body #obchiduno').val(obchiduno)
		modal.find('.modal-body #txtobchhastaunoed').val(obchhastauno)
		modal.find('.modal-body #obchiddos').val(obchiddos)
		modal.find('.modal-body #txtobchdesdedosed').val(obchdesdedos)
		modal.find('.modal-body #txtobchhastadosed').val(obchhastados)
		modal.find('.modal-body #obchidtres').val(obchidtres)
		modal.find('.modal-body #txtobchdesdetresed').val(obchdesdetres)
		modal.find('.modal-body #txtobchhastatresed').val(obchhastatres)
		modal.find('.modal-body #obchidcuatro').val(obchidcuatro)
		modal.find('.modal-body #txtobchdesdecuatroed').val(obchdesdecuatro)
		//$('.alert').hide();//Oculto alert
	})
	$('#dataDeletePreNatal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget) // Botón que activó el modal
		var id = button.data('id') // Extraer la información de atributos de datos
		var empid = button.data('empid')
		var modal = $(this)
		modal.find('.modal-body #prenatalid').val(id)
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
