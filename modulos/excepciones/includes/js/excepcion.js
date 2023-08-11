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
		$('#dataUpdateExcepcion').on('show.bs.modal', function (event){
		  var button = $(event.relatedTarget) // Botón que activó el modal
			var titulo = button.data('titulo')
			var id = button.data('id')
			var periodo = button.data('periodo')
			var fecha = button.data('fecha')
			var nrodocto = button.data('nrodocto')
			var horai = button.data('horai')
			var horaf = button.data('horaf')
			var ficha = button.data('ficha')

		  var modal = $(this)
		  modal.find('.modal-title').text(titulo)
			modal.find('.modal-body #excepcionid').val(id)
			modal.find('.modal-body #excepcionperiodo').val(periodo)
			modal.find('.modal-body #excepcionfecha').val(fecha)
			modal.find('.modal-body #excepcionnrodocto').val(nrodocto)
			modal.find('.modal-body #excepcionhorai').val(horai)
			modal.find('.modal-body #excepcionhoraf').val(horaf)
			if (ficha == 1) {
				modal.find('.modal-body #excepcionficha').prop('checked', true);
			}else{
				modal.find('.modal-body #excepcionficha').prop('checked', false);
			}
		  $('.alert').hide();//Oculto alert
		})
		//------ llena formulario para eliminacion ------
		$('#dataDeleteLugarDeTrabajo').on('show.bs.modal', function (event){
		  var button = $(event.relatedTarget) // Botón que activó el modal
		  var id = button.data('id') // Extraer la información de atributos de datos

			var modal = $(this)
		  modal.find('.modal-body #trabajoid').val(id)
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
