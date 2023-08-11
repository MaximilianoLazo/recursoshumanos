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


		$('#dataUpdateEstudio').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget) // Botón que activó el modal
			var titulo = button.data('titulo')
			var id = button.data('id')
			var empid = button.data('empid')
			var empnrodocto = button.data('empnrodocto')
			var estudioesc = button.data('estudioesc')
			var estudionvl = button.data('estudionvl')
			var estudioestado = button.data('estudioestado')
			var estudiotitulo = button.data('estudiotitulo')

		  var modal = $(this)
		  modal.find('.modal-title').text(titulo)
			modal.find('.modal-body #id').val(id)
			modal.find('.modal-body #empid').val(empid)
			modal.find('.modal-body #empnrodocto').val(empnrodocto)
			modal.find('.modal-body #estudioesc').val(estudioesc)
			modal.find('.modal-body #estudionvl').val(estudionvl)
			modal.find('.modal-body #estudioestado').val(estudioestado)
			modal.find('.modal-body #estudiotitulo').val(estudiotitulo)
		  $('.alert').hide();//Oculto alert
		})

		$('#dataDeleteEstudio').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget) // Botón que activó el modal
		  var id = button.data('id') // Extraer la información de atributos de datos
			var empid = button.data('empid')
			var modal = $(this)
		  modal.find('.modal-body #estudioid').val(id)
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
