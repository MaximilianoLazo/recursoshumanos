	function load(page){

	}

		//------------ llena formulario edicion --------
		$('#dataUpdateTarea').on('show.bs.modal', function (event){
		  var button = $(event.relatedTarget) // Botón que activó el modal
			var titulo = button.data('titulo')
			var id = button.data('id')
			var tareanombre = button.data('tareanombre')

		  var modal = $(this)
		  modal.find('.modal-title').text(titulo)
			modal.find('.modal-body #TareaId').val(id)
			modal.find('.modal-body #TxtTareaNombre').val(tareanombre)
		  $('.alert').hide();//Oculto alert
		})
		//------ llena formulario para eliminacion ------
		$('#dataDeleteTarea').on('show.bs.modal', function (event){
		  var button = $(event.relatedTarget) // Botón que activó el modal
		  var id = button.data('id') // Extraer la información de atributos de datos

			var modal = $(this)
		  modal.find('.modal-body #TareaId').val(id)
		})
