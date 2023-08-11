$(document).ready(function(){
	$('#txtbusquedaindumentarianrodocto').typeahead({
		minLength: 3,
    source: function(query, process){
      return $.ajax({
				url: "?c=indumentaria&a=IndumentariaHelp",
        type: 'post',
        data: {query: query},
        dataType: 'json',
        success: function(result){
          var resultList = result.map(function(item){
            var aItem = {id: item.Id, name: item.Name};
            return JSON.stringify(aItem);
          });
          return process(resultList);
        }
      });
    },
		matcher: function(obj){
      var item = JSON.parse(obj);
      return ~item.name.toLowerCase().indexOf(this.query.toLowerCase())
    },
    sorter: function(items){
      var beginswith = [], caseSensitive = [], caseInsensitive = [], item;
      while (aItem = items.shift()){
        var item = JSON.parse(aItem);
        if (!item.name.toLowerCase().indexOf(this.query.toLowerCase())) beginswith.push(JSON.stringify(item));
        else if (~item.name.indexOf(this.query)) caseSensitive.push(JSON.stringify(item));
        else caseInsensitive.push(JSON.stringify(item));
      }
      return beginswith.concat(caseSensitive, caseInsensitive)
    },
    highlighter: function(obj){
      var item = JSON.parse(obj);
      var query = this.query.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, '\\$&')
      return item.name.replace(new RegExp('(' + query + ')', 'ig'), function($1, match){
      	return '<strong>' + match + '</strong>'
      })
    },
    updater: function(obj){
      var item = JSON.parse(obj);
      return item.id;
    }
	});
	//--- AGREGANDO DATOS AL CARRO---

	$(document).on("click", "#btnindcarroadd", function(){

		var nrodocto = $("#hddempnrodoctoe").val();
		var indentregaid = $("#hddindentregaide").val();
		var indumentariaid = $("#cboindcarronombree").val();
		var talleid = $("#cboindcarrotallee").val();
		var colorid = $("#cboindcarrocolore").val();
		var indumentariac = $("#txtindcarrocantidade").val();
		var indumentariaobs = $("#txtindcarroobse").val();

		if(indumentariaid == null || indumentariaid == 0){

			//document.getElementById("smlindumentaria").setAttribute("style","color:red;");
			$('#smlindumentaria').text("* Campo requerido");
			$('#smlindumentaria').css({"color": "#FF0000"});
			//document.getElementById("cboindcarronombree").setAttribute("style","border-color:red;");
			$('#cboindcarronombree').css({"border-color": "#FF0000"});
			$("#cboindcarronombree").focus();

		}else if(talleid == null || talleid == 0){

			$('#smltalle').text("* Campo requerido");
			$('#smltalle').css({"color": "#FF0000"});
			$('#cboindcarrotallee').css({"border-color": "#FF0000"});
			$("#cboindcarrotallee").focus();

		}else if(colorid == null || colorid == 0){

			$('#smlcolor').text("* Campo requerido");
			$('#smlcolor').css({"color": "#FF0000"});
			$('#cboindcarrocolore').css({"border-color": "#FF0000"});
			$("#cboindcarrocolore").focus();

		}else if(indumentariac == null || indumentariac == 0){

			$('#smlcantidad').text("* Campo requerido");
			$('#smlcantidad').css({"color": "#FF0000"});
			$('#txtindcarrocantidade').css({"border-color": "#FF0000"});
			$("#txtindcarrocantidade").focus();

		}else{
			$.ajax({
				url: "?c=indumentaria&a=IndumentariaCarroGuardar",
				method: "POST",
				data: {
					Empndoc: nrodocto,
					IndEntregaId: indentregaid,
					IndumentariaId: indumentariaid,
					TalleId: talleid,
					ColorId: colorid,
					IndumentariaC: indumentariac,
					IndumentariaObs: indumentariaobs
				},
				success: function(data){
					//obtener_icompras_asiento();
					jQuery("#tblindumentariacarro").html(data);
					$("#IndumentariaCarroEditar").modal('hide');
				}
			})
		}
	})
	//--- QUITANDO DATOS AL CARRO---
	$(document).on("click", "#btnindcarrodelete", function(){

		var nrodocto = $("#hddempnrodoctod").val();
		var indentregaid = $("#hddindentregaidd").val();

		$.ajax({
			url: "?c=indumentaria&a=IndumentariaCarroEliminar",
			method: "POST",
			data: {
				Empndoc: nrodocto,
				IndEntregaId: indentregaid
			},
			success: function(data){
				jQuery("#tblindumentariacarro").html(data);
				$("#IndumentariaCarroBaja").modal('hide');
			}
		})
	})
});
//----- Ventana modal indumentaria, carro, editar---
//$('#EmpleadoEditarDatosPersonales').on('shown.bs.modal', function (event){
$('#IndumentariaCarroEditar').on('show.bs.modal', function (event){
//$('#EmpleadoEditarDatosPersonales').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget) // Botón que activó el modal
	var titulo = button.data('titulo') // Extraer la información de atributos de datos
	var empid = button.data('empid') // Extraer la información de atributos de datos
	var empnrodocto = button.data('empnrodocto')
	var indentregaid = button.data('indentregaid')
	var indumentaria = button.data('indumentaria')
	var indtalle = button.data('indtalle')
	var indcolor = button.data('indcolor')
	var indcantidad = button.data('indcantidad')
	var indobs = button.data('indobs')

	var modal = $(this)
	modal.find('.modal-header .modal-title').text(titulo)
	modal.find('.modal-body #hddempide').val(empid)
	modal.find('.modal-body #hddempnrodoctoe').val(empnrodocto)
	modal.find('.modal-body #hddindentregaide').val(indentregaid)
	modal.find('.modal-body #cboindcarronombree').val(indumentaria)

	$.get("?c=indumentaria&a=IndumentariaTalleObtener","id="+$("#cboindcarronombree").val(), function(data){
		$("#cboindcarrotallee").html(data);
		modal.find('.modal-body #cboindcarrotallee').val(indtalle)
	});

	modal.find('.modal-body #cboindcarrocolore').val(indcolor)
	modal.find('.modal-body #txtindcarrocantidade').val(indcantidad)
	modal.find('.modal-body #txtindcarroobse').val(indobs)
	//$('.alert').hide();//Oculto alert
})
//----- Ventana modal indumentaria carro - Dar de baja---
$('#IndumentariaCarroBaja').on('show.bs.modal', function (event){
	var button = $(event.relatedTarget) // Botón que activó el modal
	var titulo = button.data('titulo') // Extraer la información de atributos de datos
	var empnrodocto = button.data('empnrodocto') // Extraer la información de atributos de datos
	var indentregaid = button.data('indentregaid') // Extraer la información de atributos de datos

	var modal = $(this)
	modal.find('.modal-header .modal-title').text(titulo)
	modal.find('.modal-body #hddempnrodoctod').val(empnrodocto)
	modal.find('.modal-body #hddindentregaidd').val(indentregaid)
	//$('.alert').hide();//Oculto alert

})
//----- Ventana modal indumentaria, carro, cerrar indumentaria---
$('#IndumentariaCarroCerrar').on('show.bs.modal', function (event){
	var button = $(event.relatedTarget) // Botón que activó el modal
	var titulo = button.data('titulo') // Extraer la información de atributos de datos
	var indordenid = button.data('indordenid')
	/*var empid = button.data('empid') // Extraer la información de atributos de datos
	var empnrodocto = button.data('empnrodocto')
	var indentregaid = button.data('indentregaid')
	var indumentaria = button.data('indumentaria')
	var indtalle = button.data('indtalle')
	var indcolor = button.data('indcolor')
	var indcantidad = button.data('indcantidad')
	var indobs = button.data('indobs')*/

	var modal = $(this)
	modal.find('.modal-header .modal-title').text(titulo)
	modal.find('.modal-body #hddindordenide').val(indordenid)
	/*modal.find('.modal-body #hddempide').val(empid)
	modal.find('.modal-body #hddempnrodoctoe').val(empnrodocto)
	modal.find('.modal-body #hddindentregaide').val(indentregaid)
	modal.find('.modal-body #cboindcarronombree').val(indumentaria)

	$.get("?c=indumentaria&a=IndumentariaTalleObtener","id="+$("#cboindcarronombree").val(), function(data){
		$("#cboindcarrotallee").html(data);
		modal.find('.modal-body #cboindcarrotallee').val(indtalle)
	});

	modal.find('.modal-body #cboindcarrocolore').val(indcolor)
	modal.find('.modal-body #txtindcarrocantidade').val(indcantidad)
	modal.find('.modal-body #txtindcarroobse').val(indobs)*/
	//$('.alert').hide();//Oculto alert
})
//-----------FIN INDUMENTARIA - CERRAR ORDEN -------
//----Al momento de cambiar datos de Indumentaria-------
$("#cboindcarronombree").change(function(){
	$.get("?c=indumentaria&a=IndumentariaTalleObtener","id="+$("#cboindcarronombree").val(), function(data){
		$("#cboindcarrotallee").html(data);
	});
});
//--------INICIO- Validaciones de formilario carro indumentaria ----
//----indumentaria-----
$("#cboindcarronombree").change(function(){
	var indumentariaid = $("#cboindcarronombree").val();
	if(indumentariaid == null || indumentariaid == 0){
		$('#smlindumentaria').text("* Campo requerido");
		$('#smlindumentaria').css({"color": "#FF0000"});
		$('#cboindcarronombree').css({"border-color": "#FF0000"});
	}else{
		$('#smlindumentaria').text("* Campo requerido");
		$('#smlindumentaria').css({"color": "#9a9a9a"});
		$('#cboindcarronombree').css({"border-color": "#9a9a9a"});
	}
});
//--------indumentaria talle -----
$("#cboindcarrotallee").change(function(){
	var talleid = $("#cboindcarrotallee").val();
	if(talleid == null || talleid == 0){
		$('#smltalle').text("* Campo requerido");
		$('#smltalle').css({"color": "#FF0000"});
		$('#cboindcarrotallee').css({"border-color": "#FF0000"});
	}else{
		$('#smltalle').text("* Campo requerido");
		$('#smltalle').css({"color": "#9a9a9a"});
		$('#cboindcarrotallee').css({"border-color": "#9a9a9a"});
	}
});
//--------indumentaria color -----
$("#cboindcarrocolore").change(function(){
	var colorid = $("#cboindcarrocolore").val();
	if(colorid == null || colorid == 0){
		$('#smlcolor').text("* Campo requerido");
		$('#smlcolor').css({"color": "#FF0000"});
		$('#cboindcarrocolore').css({"border-color": "#FF0000"});
	}else{
		$('#smlcolor').text("* Campo requerido");
		$('#smlcolor').css({"color": "#9a9a9a"});
		$('#cboindcarrocolore').css({"border-color": "#9a9a9a"});
	}
});
//------indumentaria cantidad ------
$("#txtindcarrocantidade").change(function(){
	var cantidadid = $("#txtindcarrocantidade").val();
	if(cantidadid == null || cantidadid == 0){
		$('#smlcantidad').text("* Campo requerido");
		$('#smlcantidad').css({"color": "#FF0000"});
		$('#txtindcarrocantidade').css({"border-color": "#FF0000"});
	}else{
		$('#smlcantidad').text("* Campo requerido");
		$('#smlcantidad').css({"color": "#9a9a9a"});
		$('#txtindcarrocantidade').css({"border-color": "#9a9a9a"});
	}
});
//--------FINAL- Validaciones de formilario carro indumentaria ----
//------- INDUMETARIA TIPO INICIO--------------------
$('#IndumentariaTipoEditar').on('show.bs.modal', function (event){
	var button = $(event.relatedTarget) // Botón que activó el modal
	var titulo = button.data('titulo') // Extraer la información de atributos de datos
	var indtipoid = button.data('indtipoid') // Extraer la información de atributos de datos
	var indtiponombre = button.data('indtiponombre') // Extraer la información de atributos de datos

	var modal = $(this)
	modal.find('.modal-header .modal-title').text(titulo)
	modal.find('.modal-body #hddindtipoide').val(indtipoid)
	modal.find('.modal-body #txtindtiponombree').val(indtiponombre)
	//$('.alert').hide();//Oculto alert

})
$('#IndumentariaTipoBaja').on('show.bs.modal', function (event){
	var button = $(event.relatedTarget) // Botón que activó el modal
	var titulo = button.data('titulo') // Extraer la información de atributos de datos
	var indumentariaid = button.data('indumentariaid') // Extraer la información de atributos de datos

	var modal = $(this)
	modal.find('.modal-header .modal-title').text(titulo)
	modal.find('.modal-body #hddindumentariaidd').val(indumentariaid)
	//$('.alert').hide();//Oculto alert

})
//-------INDUMENTARIA TIPO FIN-------------------------
//-------INDUEMENTARIA TALLE INICIO ---------------------
$('#IndumentariaTalleEditar').on('show.bs.modal', function (event){

	var button = $(event.relatedTarget) // Botón que activó el modal
	var titulo = button.data('titulo') // Extraer la información de atributos de datos
	var indtalleid = button.data('indtalleid') // Extraer la información de atributos de datos
	var indtallenombre = button.data('indtallenombre') // Extraer la información de atributos de datos
	var indumentariaid = button.data('indumentariaid') // Extraer la información de atributos de datos

	var modal = $(this)
	modal.find('.modal-header .modal-title').text(titulo)
	modal.find('.modal-body #hddindtalleide').val(indtalleid)
	modal.find('.modal-body #txtindumentariatallenombree').val(indtallenombre)
	modal.find('.modal-body #cboindumentarianombrete').val(indumentariaid)
	//$('.alert').hide();//Oculto alert

})
$('#IndumentariaTalleBaja').on('show.bs.modal', function (event){
	var button = $(event.relatedTarget) // Botón que activó el modal
	var titulo = button.data('titulo') // Extraer la información de atributos de datos
	var indumentariatalleid = button.data('indumentariatalleid') // Extraer la información de atributos de datos

	var modal = $(this)
	modal.find('.modal-header .modal-title').text(titulo)
	modal.find('.modal-body #hddindumentariatalleidd').val(indumentariatalleid)
	//$('.alert').hide();//Oculto alert

})
//-------INDUEMENTARIA TALLE FIN ----------------------
//-------INDUEMENTARIA COLOR INICIO ---------------------
$('#IndumentariaColorEditar').on('show.bs.modal', function (event){

	var button = $(event.relatedTarget) // Botón que activó el modal
	var titulo = button.data('titulo') // Extraer la información de atributos de datos
	var indcolorid = button.data('indcolorid') // Extraer la información de atributos de datos
	var indcolornombre = button.data('indcolornombre') // Extraer la información de atributos de datos

	var modal = $(this)
	modal.find('.modal-header .modal-title').text(titulo)
	modal.find('.modal-body #hddindcoloride').val(indcolorid)
	modal.find('.modal-body #txtindcolornombree').val(indcolornombre)
	//$('.alert').hide();//Oculto alert

})
$('#IndumentariaColorBaja').on('show.bs.modal', function (event){
	var button = $(event.relatedTarget) // Botón que activó el modal
	var titulo = button.data('titulo') // Extraer la información de atributos de datos
	var indumentariacolorid = button.data('indumentariacolorid') // Extraer la información de atributos de datos

	var modal = $(this)
	modal.find('.modal-header .modal-title').text(titulo)
	modal.find('.modal-body #hddindumentariacoloridd').val(indumentariacolorid)
	//$('.alert').hide();//Oculto alert

})
//-------INDUEMENTARIA COLOR FIN ----------------------
//-------INDUMENTARIA STOCK INICIO----------------------
$('#IndumentariaStockEditar').on('show.bs.modal', function (event){

	var button = $(event.relatedTarget) // Botón que activó el modal
	var titulo = button.data('titulo') // Extraer la información de atributos de datos
  var indstockid = button.data('indstockid') // Extraer la información de atributos de datos
	var indstockc = button.data('indstockc')
	var indstockcdb = button.data('indstockcdb')
	var indumentariaid = button.data('indumentariaid')
	var indumentariatalleid = button.data('indumentariatalleid')
	var indumentariacolorid = button.data('indumentariacolorid')
	var indstockmin = button.data('indstockmin')

	var modal = $(this)
	modal.find('.modal-header .modal-title').text(titulo)
	modal.find('.modal-body #hddindstockide').val(indstockid)
	modal.find('.modal-body #hddindstockcantidade').val(indstockc)
	modal.find('.modal-body #txtindstockcbarrase').val(indstockcdb)
	modal.find('.modal-body #cboindstocknombree').val(indumentariaid)
	$.get("?c=indumentaria&a=IndumentariaTalleObtener","id="+$("#cboindstocknombree").val(), function(data){
		$("#cboindstocktallee").html(data);
		modal.find('.modal-body #cboindstocktallee').val(indumentariatalleid)
	});
	modal.find('.modal-body #cboindstockcolore').val(indumentariacolorid)
	modal.find('.modal-body #txtindstockcantidadmine').val(indstockmin)
	modal.find('.modal-body #txtindstockcantidadacte').val(indstockc)
	//$('.alert').hide();//Oculto alert
	if(indstockid > 0){
		modal.find('.modal-body #cboindstocknombree').prop('disabled', true);
		modal.find('.modal-body #cboindstocktallee').prop('disabled', true);
		modal.find('.modal-body #cboindstockcolore').prop('disabled', true);
	}else{
		modal.find('.modal-body #cboindstocknombree').prop('disabled', false);
		modal.find('.modal-body #cboindstocktallee').prop('disabled', false);
		modal.find('.modal-body #cboindstockcolore').prop('disabled', false);
	}
	modal.find('.modal-body #txtindstockcantidadacte').prop('disabled', true);
	//$("#txtindstockcantidadacte").prop('disabled', true);

})
//----Al momento de cambiar datos de Indumentaria Stock-------
$("#cboindstocknombree").change(function(){
	$.get("?c=indumentaria&a=IndumentariaTalleObtener","id="+$("#cboindstocknombree").val(), function(data){
		$("#cboindstocktallee").html(data);
	});
});
jQuery('#cboindstocknombree, #cboindstocktallee, #cboindstockcolore').on('change', function(){

	var indumentariaidf = $("#cboindstocknombree").val();
	var indumentariatalleidf = $("#cboindstocktallee").val();
	var indumentariacoloridf = $("#cboindstockcolore").val();

	if(indumentariaidf > 0 && indumentariatalleidf > 0 && indumentariacoloridf > 0){
		//-----verdadero ----
		//console.log("VERDADERO");
		$.ajax ({
			//url:"includes/php/autocompletar_empleado.php",
			url:"?c=indumentaria&a=IndumentariaStockAutocompletar",
			type:"POST",
			dataType:"json",
			data: {
				indumentariaidf: indumentariaidf,
				indumentariatalleidf: indumentariatalleidf,
				indumentariacoloridf: indumentariacoloridf
			},
			success: function(res){

				var opcion = res.opcion;
				if(opcion == 1){
					$('.modal-body #hddindstockide').val(res.indumentariastockid);
					$('.modal-body #hddindstockcantidade').val(res.indumentariastockcantidad);
					$('.modal-body #txtindstockcbarrase').val(res.indumentariacbarra);
					$('.modal-body #txtindstockcantidadacte').val(res.indumentariastockcantidad);
					$('.modal-body #txtindstockcantidadmine').val(res.indumentariastockminimo);
					/*$("input").prop('disabled', true);
					$("select").prop('disabled', true);*/
					/*$("#txtempnrocuile").prop('disabled', true);
					$("#txtempnrolegajoe").prop('disabled', true);
					$("#txtempapellidoe").prop('disabled', true);
					$("#txtempnombrese").prop('disabled', true);
					$("#cboempsexoe").prop('disabled', true);
					$("#cboempestadocivile").prop('disabled', true);
					$("#txtempfecnace").prop('disabled', true);
					$("#txtempfecinge").prop('disabled', true);
					$("#btnempleadoguardar").prop('disabled', true);
					$("#txtnrodoctoe").focus();
					$(".alert-empactivo").show();*/
				}else if(opcion == 0){
					$('.modal-body #hddindstockide').val(res.indumentariastockid);
					$('.modal-body #hddindstockcantidade').val(res.indumentariastockcantidad);
					$('.modal-body #txtindstockcbarrase').val(res.indumentariacbarra);
					$('.modal-body #txtindstockcantidadacte').val(res.indumentariastockcantidad);
					$('.modal-body #txtindstockcantidadmine').val(res.indumentariastockminimo);
					//$('#hddempmovimientoe').val(3);
					/*$("#txtempnrocuile").prop('disabled', false);
					$("#txtempnrolegajoe").prop('disabled', false);
					$("#txtempapellidoe").prop('disabled', false);
					$("#txtempnombrese").prop('disabled', false);
					$("#cboempsexoe").prop('disabled', false);
					$("#cboempestadocivile").prop('disabled', false);
					$("#txtempfecnace").prop('disabled', false);
					$("#txtempfecinge").prop('disabled', false);
					$("#btnempleadoguardar").prop('disabled', false);
					$("#txtempnrocuile").focus();
					$(".alert-empinactivo").show();*/
				}else{
					//$('#hddempmovimientoe').val(1);
					/*$("#txtempnrocuile").prop('disabled', false);
					$("#txtempnrolegajoe").prop('disabled', false);
					$("#txtempapellidoe").prop('disabled', false);
					$("#txtempnombrese").prop('disabled', false);
					$("#cboempsexoe").prop('disabled', false);
					$("#cboempestadocivile").prop('disabled', false);
					$("#txtempfecnace").prop('disabled', false);
					$("#txtempfecinge").prop('disabled', false);
					$("#btnempleadoguardar").prop('disabled', false);
					$("#txtempnrocuile").focus();*/
				}

			}
		})
	}else{
		//-----falso------
		console.log("FALSO");
	}

	//console.log("VERDADERO");
});
//-------INDUMENTARIA STOCK FIN-------------------------
