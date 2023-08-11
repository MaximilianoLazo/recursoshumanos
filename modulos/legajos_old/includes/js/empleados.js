	/*function load(page){
	}*/
	//------------nueva ventana modal empleado-editar-datospersonales--
	/*$('#dataAddEmpleado').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget) // Botón que activó el modal
		var titulo = button.data('titulo') // Extraer la información de atributos de datos
		//llenar datos en text
		var modal = $(this)
		modal.find('.modal-title').text(titulo)
		//$('.alert').hide();//Oculto alert
	})*/
	//---en desuso -----
	/*
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
	//------ en js empleado-editar -------
	/*
	jQuery(document).ready(function(){
		$('#empnrodocumento').blur (function(){
			var valor = jQuery("#empnrodocumento").val();
			$.ajax ({
				url:"includes/php/autocompletar_empleado.php",
				type:"POST",
				dataType:"json",
				data: {val:valor},
				success: function(res){
					$('.modal-body #empleadoid').val(res.empid);
					//$('#empnrodocumento').val(res.empdni);
					$('#empcuil').val(res.empcuil);
					$('#empnroleg').val(res.emplegajov);
					$('#empapellido').val(res.empapellido);
					$('#empnombres').val(res.empnombres);
					$('#empestcivil').val(res.empecivil);
					$('#empsexo').val(res.empsexo);
					$('#empfecnacto').val(res.empfecnacto);
					$('#empfecing').val(res.empfecingreso);
					/*
					$('#hijoescnom').val(res.hjoescuela);
					$('#hijoescnvl').val(res.hjoescnvl);
					$('#hijoescest').val(res.hjoescest);
					//---- datos de la madre o el padre ---
					$('#hijomoptdoc').val(res.hjomoptdoc);
					$('#hijomopndoc').val(res.hjomopndoc);
					$('#hijomopapellido').val(res.hjomopapellido);
					$('#hijomopnombres').val(res.hjomopnombres);
					//--- Datos del beneficiario
					$('#hijobentdoc').val(res.hjobentdoc);
					$('#hijobenndoc').val(res.hjobenndoc);
					$('#hijobenapellido').val(res.hjobenapellido);
					$('#hijobennombres').val(res.hjobennombres);
					$('#hijonrooficio').val(res.hjonrooficio);

					$('#hijoppdl').val(res.hjoppdl);
					var hijoppdl = jQuery("#hijoppdl").val();

					$('#hijopais').val(res.hjopais);

					$.get("includes/php/obtener_provincias.php","pais="+hijoppdl, function(data){
						$("#hijoprovincia").html(data);
						console.log(data);
					});
					$.get("includes/php/obtener_departamentos.php","provincia="+hijoppdl, function(data){
						$("#hijodepartamento").html(data);
						console.log(data);
					});
					$.get("includes/php/obtener_localidades.php","departamento="+hijoppdl, function(data){
						$("#hijolocalidad").html(data);
						console.log(data);
					});
					var hijodisc = res.hjodisccheck;
					if (hijodisc == 1) {
						$('#hijodisc').prop('checked', true);
					}else{
						$('#hijodisc').prop('checked', false);
					}
					var hijoesc = res.hjoescuelacheck;
					if (hijoesc == 1) {
						$('#hijoesc').prop('checked', true);
					}else{
						$('#hijoesc').prop('checked', false);
					}
					*//*
				}
			})
		})
	});
*/
