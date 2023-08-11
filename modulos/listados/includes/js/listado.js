	function load(page){

	}
		//------------- llena formulario de Vista --------
		$('#dataViewEscuela').on('show.bs.modal', function (event){
			var button = $(event.relatedTarget) // Botón que activó el modal
			var titulo = button.data('titulo')
			var id = button.data('id')
			var escnro = button.data('escnro')
			var escnombre = button.data('escnombre')
			var escdireccion = button.data('escdireccion')
			var escdirecnro = button.data('escdirecnro')
			var escdirecpiso = button.data('escdirecpiso')
			var esccpostal = button.data('esccpostal')
			var esctelefono = button.data('esctelefono')
			var escemail = button.data('escemail')
			var escpais = button.data('escpais')
			var escppdl = button.data('escppdl')

			var modal = $(this)
			modal.find('.modal-title').text(titulo)
			modal.find('.modal-body #escuelaid').val(id)
			modal.find('.dato1').val(escnombre)
			modal.find('.modal-body #escuelanro').val(escnro)
			modal.find('.modal-body #escueladireccion').val(escdireccion)
			modal.find('.modal-body #escueladirecnro').val(escdirecnro)
			modal.find('.modal-body #escueladirecpiso').val(escdirecpiso)
			modal.find('.modal-body #escuelacpostal').val(esccpostal)
			modal.find('.modal-body #escuelatelefono').val(esctelefono)
			modal.find('.modal-body #escuelaemail').val(escemail)
			modal.find('.modal-body #escuelapais').val(escpais)
			modal.find('.modal-body #escuelappdl').val(escppdl)
			$.get("view/get_provincias.php","pais="+$("#escuelappdl").val(), function(data){
			$("#escuelaprovincia").html(data);
			console.log(data);
			});
			$.get("view/get_departamentos.php","provincia="+$("#escuelappdl").val(), function(data){
			$("#escueladepartamento").html(data);
			console.log(data);
			});
			$.get("view/get_localidades.php","departamento="+$("#escuelappdl").val(), function(data){
			$("#escuelalocalidad").html(data);
			console.log(data);
			});
			$('.alert').hide();//Oculto alert
		})
		//------------ llena formulario edicion --------
		$('#dataUpdatelistado').on('show.bs.modal', function (event){
		  var button = $(event.relatedTarget) // Botón que activó el modal
			var titulo = button.data('titulo')
			var id = button.data('id')
			var ferfecha = button.data('ferfecha')
			var ferobservacion = button.data('ferobservacion')

		  var modal = $(this)
		  modal.find('.modal-title').text(titulo)
			modal.find('.modal-body #listadoid').val(id)
			modal.find('.modal-body #listadofecha').val(ferfecha)
			modal.find('.modal-body #listadoobservacion').val(ferobservacion)
		  $('.alert').hide();//Oculto alert
		})
		//------ llena formulario para eliminacion ------
		$('#dataDeletelistado').on('show.bs.modal', function (event){
		  var button = $(event.relatedTarget) // Botón que activó el modal
		  var id = button.data('id') // Extraer la información de atributos de datos

			var modal = $(this)
		  modal.find('.modal-body #listadoid').val(id)
		})
		//------ llenado de combos con datos filtrados al cambiar un dato -----
		$("#escuelapais").change(function(){
			$.get("view/get_provincias.php","pais="+$("#escuelapais").val(), function(data){
				$("#escuelaprovincia").html(data);
				console.log(data);
			});
		});
		$("#escuelaprovincia").change(function(){
			$.get("view/get_departamentos.php","provincia="+$("#escuelaprovincia").val(), function(data){
				$("#escueladepartamento").html(data);
				console.log(data);
			});
		});
		$("#escueladepartamento").change(function(){
			$.get("view/get_localidades.php","departamento="+$("#escueladepartamento").val(), function(data){
				$("#escuelalocalidad").html(data);
				console.log(data);
			});
		});
