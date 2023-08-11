	function load(page){

	}

	$('#dataUpdateReajuste').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget) // Botón que activó el modal
		var titulo = button.data('titulo') // Extraer la información de atributos de datos
		var id = button.data('id') // Extraer la información de atributos de datos
		var ndocconsultado = button.data('ndocconsultado')
		var hijondoc = button.data('hijondoc') // Extraer la información de atributos de datos
		var hijoapellido = button.data('hijoapellido') // Extraer la información de atributos de datos
		var hijonombres = button.data('hijonombres') // Extraer la información de atributos de datos
		var asigobtipo = button.data('asigobtipo') // Extraer la información de atributos de datos
		var asigobimporte = button.data('asigobimporte') // Extraer la información de atributos de datos
		var asigobreajuste = button.data('asigobreajuste') // Extraer la información de atributos de datos
		var asigobreajusteobs = button.data('asigobreajusteobs')
		var asigobimptotal = button.data('asigobimptotal')

		var modal = $(this)
		modal.find('.modal-title').text(titulo)
		modal.find('.modal-body #id').val(id)
		modal.find('.modal-body #ndocconsultado').val(ndocconsultado)
		modal.find('.hijondoc').text(hijondoc)
		modal.find('.hijoapellido').text(hijoapellido)
		modal.find('.hijonombres').text(hijonombres)
		modal.find('.asigobtipo').text(asigobtipo)
		modal.find('.modal-body #importeob').val(asigobimporte)
		modal.find('.modal-body #txtasignacionr').val(asigobreajuste)
		modal.find('.modal-body #asigobimporte').val(asigobimporte)
		modal.find('.modal-body #txtasignacionimpt').val(asigobimptotal)
		modal.find('.modal-body #txtasignacionobs').val(asigobreajusteobs)
		//$('.alert').hide();//Oculto alert
	})
