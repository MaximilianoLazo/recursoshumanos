		$(document).ready(function(){
			//---- Al momento de cambiar la imputacion llenar selec con las dependencias correspondientes ---
			$("#CboEmpImputacionAdd").change(function(){
				$.get("includes/php/obtener_dependencias.php","imputacion="+$("#CboEmpImputacionAdd").val(), function(data){
					$("#CboEmpImpDependenciaAdd").html(data);
					console.log(data);
				});
			});
			/*
			$("#CboEmpSecretariaAdd").change(function(){
				$.get("includes/php/obtener_lugaresdetrabajo.php","secretaria="+$("#CboEmpSecretariaAdd").val(), function(data){
					$("#CboEmpLugarDeTrabajoAdd").html(data);
					console.log(data);
				});
			});
			*/
			//----- Filtros de selec al cambiar en actualizacion de contratos

			$("#cboempimputacionact").change(function(){
				$.get("includes/php/obtener_dependencias.php","imputacion="+$("#cboempimputacionact").val(), function(data){
					$("#cboempactividadact").html(data);
					console.log(data);
					//alert('Seleccionado');
				});
			});

			//-----Fin Filtros de selec al cambiar en actualizacion de contratos

			$("#cboempimputacionacti").change(function(){
				$.get("includes/php/obtener_dependencias.php","imputacion="+$("#cboempimputacionacti").val(), function(data){
					$("#cboempdependenciaacti").html(data);
					console.log(data);
					//alert('Seleccionado');
				});
			});


			$("#datosant").change(function(){
				//alert('Seleccionado');
				if($("#datosant").is(':checked')){
	    		//alert('Seleccionado bien ');
					//alert("El checkbox con valor " + $(this).val() + " está seleccionado");
					var contratoid = $("#ContratoIdActInd").val();
					console.log(contratoid);

					//--- llamar formulario de datos contrato vencido ----
					var params = {
						"Id" : contratoid
					};
					//llamada al fichero PHP con AJAX
					$.ajax({
						data:  params,
						url:   'includes/php/autocompletar_contratoanterior.php',
						//dataType: 'html',
						dataType:"json",
						type:  'post',
						beforeSend: function () {
							//mostramos gif "cargando"
							//jQuery('#loading_spinner').show();
							//antes de enviar la petición al fichero PHP, mostramos mensaje
							//jQuery("#tabladato").html("   Déjame pensar un poco...");
						},
						success:  function (response) {
							//escondemos gif
							//jQuery('#loading_spinner').hide();
							//mostramos salida del PHP
							//jQuery("#tabladato").html(response);
							//jQuery("#TxtEmpSuedoBasicoAdd").html(response.numero);
							//jQuery("#txtempcategoriaacti").html(response.letra);
							$("#cboemptipolegajoacti").val(response.legajotipo);
							//$("#txtempcategoriaacti").val(response.categoria);
							$("#txtempfechainicioacti").val(response.fecinicio);
							$("#txtempfechafinalizacionacti").val(response.fecfinal);
							$("#cboempsecretariaacti").val(response.secretaria);
							$("#cboempimputacionacti").val(response.imputacion);

							$.get("includes/php/obtener_dependencias.php","imputacion="+$("#cboempimputacionacti").val(), function(data){
								$("#cboempdependenciaacti").html(data);
								$("#cboempdependenciaacti").val(response.impdependencia);
								console.log(data);
							});

							$("#txtemptareaacti").val(response.tarea);
							$("#cboemplugardetrabajoacti").val(response.trabajo);

							$("#txtempsueldobasicoacti").val(response.sbasico);
							//$('#emprelnodo').val(res.emprelnodo);
							//$('#empreltipo').val(res.empreltipo);
						}
					});
				}
			});

			$("#proveedordatosanteriores").change(function(){
				if($("#proveedordatosanteriores").is(':checked')){
					var procontratoid = $("#hddprocontratoid").val();
					console.log(procontratoid);
					//--- llamar formulario de datos contrato vencido ----
					var params = {
						"Id" : procontratoid
					};
					//llamada al fichero PHP con AJAX
					$.ajax({
						data:  params,
						url:   'includes/php/autocompletar_proveedoranterior.php',
						//dataType: 'html',
						dataType:"json",
						type:  'post',
						beforeSend: function () {
							//mostramos gif "cargando"
							//jQuery('#loading_spinner').show();
							//antes de enviar la petición al fichero PHP, mostramos mensaje
							//jQuery("#tabladato").html("   Déjame pensar un poco...");
						},
						success:  function (response) {
							//escondemos gif
							//jQuery('#loading_spinner').hide();
							//mostramos salida del PHP
							//jQuery("#tabladato").html(response);
							$("#txtprofechainicioacti").val(response.profecinicio);
							$("#txtprofechafinalacti").val(response.profecfinal);
							$("#cboprosecretariaacti").val(response.prosecretaria);
							$("#cboproltrabajoacti").val(response.proltrabajo);
							$("#txtprotareaacti").val(response.protarea);
							$("#txtprosueldobasicoacti").val(response.prosbasico);
						}
					});
				}
			});
		});
		//----- llenar ventana modal con datos de edicion de contrato ---
		$('#dataAddContrato').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget) // Botón que activó el modal
			var titulo = button.data('titulo') // Extraer la información de atributos de datos
			var empid = button.data('empid') // Extraer la información de atributos de datos
			var lcontid = button.data('lcontid')
			var empnrodocto = button.data('empnrodocto') // Extraer la información de atributos de datos
			var tipolegajo = button.data('tlegajo') // Extraer la información de atributos de datos
			var categoria = button.data('categoria') // Extraer la información de atributos de datos
			var fecinicio = button.data('fecinicio') // Extraer la información de atributos de datos
			var fecfinalizacion = button.data('fecfinalizacion') // Extraer la información de atributos de datos
			var contratosec = button.data('contratosec') // Extraer la información de atributos de datos
			var imputacion = button.data('imputacion')
			var secretaria = button.data('secretaria')
			var contimputacion = button.data('contimputacion') // Extraer la información de atributos de datos
			var contdependencia = button.data('contdependencia') // Extraer la información de atributos de datos
			var conttarea = button.data('conttarea') // Extraer la información de atributos de datos
			var contltrabajo = button.data('contltrabajo') // Extraer la información de atributos de datos
			var contsbasico = button.data('contsbasico') // Extraer la información de atributos de dat
			var contmodelo = button.data('modelocontrato')
			var modal = $(this)
			modal.find('.modal-title').text(titulo)
			modal.find('.modal-body #EmpId').val(empid)
			modal.find('.modal-body #ContratoId').val(lcontid)
			modal.find('.modal-body #EmpNroDocto').val(empnrodocto)
			modal.find('.modal-body #CboEmpTipoLegajoAdd').val(tipolegajo)
			modal.find('.modal-body #TxtEmpCategoriaAdd').val(categoria)
			modal.find('.modal-body #TxtEmpFechaInicioAdd').val(fecinicio)
			modal.find('.modal-body #TxtEmpFechaFinalizacionAdd').val(fecfinalizacion)
			modal.find('.modal-body #CboEmpSecretariaAdd').val(contratosec)
			modal.find('.modal-body #Imputacion').val(imputacion)
			modal.find('.modal-body #Secretaria').val(secretaria)
			modal.find('.modal-body #CboEmpImputacionAdd').val(contimputacion)
			modal.find('.modal-body #CboModeloContrato').val(contmodelo)
			modal.find('.modal-body #CboEmpImpDependenciaAdd').val(contdependencia)
			$.get("includes/php/obtener_dependencias.php","imputacion="+$("#Imputacion").val(), function(data){
				$("#CboEmpImpDependenciaAdd").html(data);
				console.log(data);
			});

			modal.find('.modal-body #TxtEmpTareaAdd').val(conttarea)

			modal.find('.modal-body #CboEmpLugarDeTrabajoAdd').val(contltrabajo)
			/*
			$.get("includes/php/obtener_lugaresdetrabajo.php","secretaria="+$("#Secretaria").val(), function(data){
				$("#CboEmpLugarDeTrabajoAdd").html(data);
				console.log(data);
			});
			*/
			modal.find('.modal-body #TxtEmpSuedoBasicoAdd').val(contsbasico)
			$('.alert').hide();//Oculto alert
		})
		//----- llenar ventana modal con datos de edicion de contrato ---
		$('#dataAddProveedor').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget) // Botón que activó el modal
			var titulo = button.data('titulo') // Extraer la información de atributos de datos
			var empid = button.data('empid') // Extraer la información de atributos de datos
			var empnrodocto = button.data('empnrodocto') // Extraer la información de atributos de datos
			var procontid = button.data('procontid')

			var profecinicio = button.data('profecinicio') // Extraer la información de atributos de datos
			var profecfinal = button.data('profecfinal') // Extraer la información de atributos de datos
			var prosecretaria = button.data('prosecretaria') // Extraer la información de atributos de datos
			var proltrabajo = button.data('proltrabajo') // Extraer la información de atributos de datos
			var protarea = button.data('protarea') // Extraer la información de atributos de datos
			var prosbasico = button.data('prosbasico') // Extraer la información de atributos de datos
			var contmodelo = button.data('contmodelo')
			var modal = $(this)
			modal.find('.modal-title').text(titulo)
			modal.find('.modal-body #hddempid').val(empid)
			modal.find('.modal-body #hddempnrodocto').val(empnrodocto)
			modal.find('.modal-body #hddcontratoproid').val(procontid)

			modal.find('.modal-body #txtprofecinicioadd').val(profecinicio)
			modal.find('.modal-body #txtprofecfinaladd').val(profecfinal)
			modal.find('.modal-body #cboprosecretariaad').val(prosecretaria)
			modal.find('.modal-body #cboprolugardetrabajoadd').val(proltrabajo)
			modal.find('.modal-body #txtprotareaadd').val(protarea)
			modal.find('.modal-body #cbomodelocontrato').val(contmodelo)
			modal.find('.modal-body #txtprosueldobasicoadd').val(prosbasico)
			$('.alert').hide();//Oculto alert
		})
		//------ Formulario modal de actualicacion de contrato ----
		$('#dataUpdateContrato').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget) // Botón que activó el modal
			var titulo = button.data('titulo') // Extraer la información de atributos de datos
			var empid = button.data('empid') // Extraer la información de atributos de datos
			var lcontid = button.data('lcontid')
			var empnrodocto = button.data('empnrodocto') // Extraer la información de atributos de datos
			var tipolegajo = button.data('tlegajo') // Extraer la información de atributos de datos
			var categoria = button.data('categoria') // Extraer la información de atributos de datos
			var fecinicio = button.data('fecinicio') // Extraer la información de atributos de datos
			var fecfinalizacion = button.data('fecfinalizacion') // Extraer la información de atributos de datos
			var contratosec = button.data('contratosec') // Extraer la información de atributos de datos
			var imputacion = button.data('imputacion')
			var secretaria = button.data('secretaria')
			var contimputacion = button.data('contimputacion') // Extraer la información de atributos de datos
			var contactividad = button.data('contactividad') // Extraer la información de atributos de datos
			var conttarea = button.data('conttarea') // Extraer la información de atributos de datos
			var contltrabajo = button.data('contltrabajo') // Extraer la información de atributos de datos
			var contsbasico = button.data('contsbasico') // Extraer la información de atributos de datos
			var nrosdocto = button.data('nrosdocto')

			var modal = $(this)
			modal.find('.modal-title').text(titulo)
			//------ Variables
			modal.find('.modal-body #EmpId').val(empid)
			modal.find('.modal-body #EmpNroDocto').val(empnrodocto)
			modal.find('.modal-body #ContratoId').val(lcontid)
			modal.find('.modal-body #Secretaria').val(secretaria)
			modal.find('.modal-body #Imputacion').val(imputacion)
			modal.find('.modal-body #NrosDocto').val(nrosdocto)
			//---- Fin de Variables ---
			//------ Tipo de Legajo ----
			modal.find('.modal-body #cboemptipolegajoact').val(tipolegajo)
			//----- Contegoria ------
			modal.find('.modal-body #txtempcategoriaact').val(categoria)
			//---- Fecha de inicio de contrato
			modal.find('.modal-body #txtempfechainicioact').val(fecinicio)
			//----- Fecha de finalizacion de contrato ----
			modal.find('.modal-body #txtempfechafinalizacionact').val(fecfinalizacion)
			//------ selec de secretaria sin filtros ----
			modal.find('.modal-body #cboempsecretariaact').val(contratosec)
			//----- Selec de la imputacion ----
			modal.find('.modal-body #cboempimputacionact').val(contimputacion)
			//----- Actividad de tal imputacion -------
			/*modal.find('.modal-body #cboempactividadact').val(contactividad)
			$.get("includes/php/obtener_actividades.php","imputacion="+$("#Imputacion").val(), function(data){
				$("#cboempactividadact").html(data);
				console.log(data);
			});*/

			modal.find('.modal-body #cboempactividadact').val(contactividad)
			$.get("includes/php/obtener_dependencias.php","imputacion="+$("#Imputacion").val(), function(data){
				$("#cboempactividadact").html(data);
				console.log(data);
			});
			modal.find('.modal-body #cboempactividadact').val(contactividad)

			//-----Fin Actividad de tal imputacion -------
			modal.find('.modal-body #txtemptareaact').val(conttarea)
			//------ Lugar de Trabajo ------
			modal.find('.modal-body #cboemplugardetrabajoact').val(contltrabajo)
			/*
			//----- Filtra lugares de trabajo por secretaria -------
			$.get("includes/php/obtener_lugaresdetrabajo.php","secretaria="+$("#Secretaria").val(), function(data){
				$("#cboemplugardetrabajoact").html(data);
				console.log(data);
			});
			*/
			//----- Fin Lugar de Trabajo ---
			modal.find('.modal-body #txtempsueldobasicoact').val(contsbasico)
			$('.alert').hide();//Oculto alert
		})
		//------Fin Formulario modal de actualicacion de contrato ----
		//------ Formulario modal de actualicacion de contrato individual ----
		$('#dataUpdateContratoI').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget) // Botón que activó el modal
			var titulo = button.data('titulo') // Extraer la información de atributos de datos
			var empidactind = button.data('empidactind') // Extraer la información de atributos de datos
			var lcontidactind = button.data('lcontidactind')
			var empnrodocto = button.data('empnrodocto') // Extraer la información de atributos de datos
			var tipolegajo = button.data('tlegajo') // Extraer la información de atributos de datos
			var categoriaind = button.data('categoriaind') // Extraer la información de atributos de datos
			var fecinicio = button.data('fecinicio') // Extraer la información de atributos de datos
			var fecfinalizacion = button.data('fecfinalizacion') // Extraer la información de atributos de datos
			var contratosec = button.data('contratosec') // Extraer la información de atributos de datos
			var imputacion = button.data('imputacion')
			var secretaria = button.data('secretaria')
			var contimputacion = button.data('contimputacion') // Extraer la información de atributos de datos
			var contdependencia = button.data('contdependencia') // Extraer la información de atributos de datos
			var conttarea = button.data('conttarea') // Extraer la información de atributos de datos
			var contltrabajo = button.data('contltrabajo') // Extraer la información de atributos de datos
			var contsbasicoind = button.data('contsbasicoind') // Extraer la información de atributos de datos
			var nrosdocto = button.data('nrosdocto')

			var modal = $(this)
			modal.find('.modal-title').text(titulo)
			//------ Variables
			modal.find('.modal-body #ContratoIdActInd').val(lcontidactind)
			modal.find('.modal-body #EmpIdActInd').val(empidactind)
			modal.find('.modal-body #EmpNroDoctoActInd').val(empnrodocto)


			//modal.find('.modal-body #adhemar').val(empid)
			modal.find('.modal-body #Secretaria').val(secretaria)
			modal.find('.modal-body #Imputacion').val(imputacion)
			modal.find('.modal-body #NrosDocto').val(nrosdocto)
			//---- Fin de Variables ---
			//------ Tipo de Legajo ----
			//modal.find('.modal-body #cboemptipolegajoact').val(tipolegajo)
			//----- Contegoria ------
			//modal.find('.modal-body #txtempcategoriaacti').val(categoriaind)
			//---- Fecha de inicio de contrato
			//modal.find('.modal-body #txtempfechainicioact').val(fecinicio)
			//----- Fecha de finalizacion de contrato ----
			//modal.find('.modal-body #txtempfechafinalizacionact').val(fecfinalizacion)
			//------ selec de secretaria sin filtros ----
			//modal.find('.modal-body #cboempsecretariaact').val(contratosec)
			//----- Selec de la imputacion ----
			//modal.find('.modal-body #cboempimputacionact').val(contimputacion)
			//----- Actividad de tal imputacion -------
			//modal.find('.modal-body #cboempactividadact').val(contdependencia)
			/*
			$.get("includes/php/obtener_actividades.php","imputacion="+$("#Imputacion").val(), function(data){
				$("#cboempactividadact").html(data);
				console.log(data);
			});
			*/
			//-----Fin Actividad de tal imputacion -------
			//modal.find('.modal-body #txtemptareaact').val(conttarea)
			//------ Lugar de Trabajo ------
			//modal.find('.modal-body #cboemplugardetrabajoact').val(contltrabajo)
			/*
			//----- Filtra lugares de trabajo por secretaria -------
			$.get("includes/php/obtener_lugaresdetrabajo.php","secretaria="+$("#Secretaria").val(), function(data){
				$("#cboemplugardetrabajoact").html(data);
				console.log(data);
			});
			*/
			//----- Fin Lugar de Trabajo ---
			//modal.find('.modal-body #txtempsueldobasicoacti').val(contsbasicoind)
			$('.alert').hide();//Oculto alert
		})
		$('#dataUpdateProveedorI').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget) // Botón que activó el modal
			var titulo = button.data('titulo') // Extraer la información de atributos de datos
			var empid = button.data('empid') // Extraer la información de atributos de datos
			var empnrodocto = button.data('empnrodocto') // Extraer la información de atributos de datos
			var procontratoid = button.data('procontratoid')

			var profecinicio = button.data('profecinicio') // Extraer la información de atributos de datos
			var profecfinal = button.data('profecfinal') // Extraer la información de atributos de datos
			var prosecretaria = button.data('prosecretaria') // Extraer la información de atributos de datos
			var proltrabajo = button.data('proltrabajo') // Extraer la información de atributos de datos
			var protarea = button.data('protarea') // Extraer la información de atributos de datos
			var prosbasico = button.data('prosbasico') // Extraer la información de atributos de datos
			//var nrosdocto = button.data('nrosdocto')

			var modal = $(this)
			modal.find('.modal-title').text(titulo)
			//------ Variables
			modal.find('.modal-body #hddproid').val(empid)
			modal.find('.modal-body #hddpronrodocto').val(empnrodocto)
			modal.find('.modal-body #hddprocontratoid').val(procontratoid)
			$('.alert').hide();//Oculto alert
		})
		//------Fin Formulario modal de actualicacion de contrato individual ----
		$('#dataUpdateFichado').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget) // Botón que activó el modal
			var titulo = button.data('titulo') // Extraer la información de atributos de datos
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
			var id = button.data('id') // Extraer la información de atributos de datos
			var empid = button.data('empid') // Extraer la información de atributos de datos
			var empnrodocto = button.data('empnrodocto') // Extraer la información de atributos de datos
			var relojid = button.data('relojid') // Extraer la información de atributos de datos
			var accessid = button.data('accessid') // Extraer la información de atributos de datos
			var semanal = button.data('semanal') // Extraer la información de atributos de datos

		  var modal = $(this)
		  modal.find('.modal-title').text(titulo)
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
			modal.find('.modal-body #id').val(id)
			modal.find('.modal-body #empid').val(empid)
			modal.find('.modal-body #empnrodocto').val(empnrodocto)
		  modal.find('.modal-body #relojid').val(relojid)
			modal.find('.modal-body #accessid').val(accessid)
			modal.find('.modal-body #semanal').val(semanal)
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
		$('#dataUpdatePPermanente').on('show.bs.modal', function(event){
			var button = $(event.relatedTarget) // Botón que activó el modal
			var titulo = button.data('titulo') // Extraer la información de atributos de datos
			var empid = button.data('empid')
			var idpp = button.data('idpp')
			var empnrodocto = button.data('empnrodocto')
			var legtipopp = button.data('legtipopp')
			var categoriapp = button.data('categoriapp')
			var secretariapp = button.data('secretariapp')
			var imputacionpp = button.data('imputacionpp')
			var ltrabajopp = button.data('ltrabajopp')
			var tareapp = button.data('tareapp')
			var sbasicopp = button.data('sbasicopp')
			var fecantiguedadpp = button.data('fecantiguedadpp')

			var modal = $(this)
			modal.find('.modal-title').text(titulo)
			modal.find('.modal-body #hddempidpp').val(empid)
			modal.find('.modal-body #hddppid').val(idpp)
			modal.find('.modal-body #hddempnrodoctopp').val(empnrodocto)
			modal.find('.modal-body #cbotipolegajopp').val(legtipopp)
			modal.find('.modal-body #txtcategoriapp').val(categoriapp)
			modal.find('.modal-body #cbosecretariapp').val(secretariapp)
			modal.find('.modal-body #cboimputacionpp').val(imputacionpp)
			modal.find('.modal-body #cbolugartrabajopp').val(ltrabajopp)
			modal.find('.modal-body #txttareapp').val(tareapp)
			//modal.find('.modal-body #txtsuedobasicopp').val(sbasicopp)
			modal.find('.modal-body #txtfecantiguedadpp').val(fecantiguedadpp)

			$('.alert').hide();//Oculto alert
		})
		$('#dataUpdateJornalero').on('show.bs.modal', function(event){
			var button = $(event.relatedTarget) // Botón que activó el modal
			var titulo = button.data('titulo') // Extraer la información de atributos de datos
			var empid = button.data('empid')
			var idjor = button.data('idjor')
			var empnrodocto = button.data('empnrodocto')
			var legtipojor = button.data('legtipojor')
			var secretariajornalero = button.data('secretariajornalero')
			var imputacionjor = button.data('imputacionjor')
			var ltrabajojor = button.data('ltrabajojor')
			var tareajor = button.data('tareajor')
			var sbasicojor = button.data('sbasicojor')
			var fecantiguedadjor = button.data('fecantiguedadjor')

			var modal = $(this)
			modal.find('.modal-title').text(titulo)
			modal.find('.modal-body #hddempidjor').val(empid)
			modal.find('.modal-body #hddidjor').val(idjor)
			modal.find('.modal-body #hddempnrodoctojor').val(empnrodocto)
			modal.find('.modal-body #cbotipolegajojor').val(legtipojor)
			modal.find('.modal-body #cbosecretariajornalero').val(secretariajornalero)
			modal.find('.modal-body #cboimputacionjor').val(imputacionjor)
			modal.find('.modal-body #cbolugartrabajojor').val(ltrabajojor)
			modal.find('.modal-body #txttareajor').val(tareajor)
			//modal.find('.modal-body #txtsuedobasicopp').val(sbasicopp)
			modal.find('.modal-body #txtfecantiguedadjor').val(fecantiguedadjor)

			$('.alert').hide();//Oculto alert
		})
