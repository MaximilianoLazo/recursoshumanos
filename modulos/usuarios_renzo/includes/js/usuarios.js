$('#UsuarioEditar').on('shown.bs.modal', function (event) {

	var button = $(event.relatedTarget) // Botón que activó el modal
	var titulo = button.data('titulo') // Extraer la información de atributos de datos
	var usrid = button.data('usrid')
	var usr = button.data('usr')
	var usrtipo = button.data('usrtipo')


	var modal = $(this)
	modal.find('.modal-header .modal-title').text(titulo)
	modal.find('.modal-body #hddusuarioid').val(usrid)
	modal.find('.modal-body #txtusuario').val(usr)
	modal.find('.modal-body #cbousuariotipo').val(usrtipo)

	$(".modal-body #txtusuario").focus();
	//$('.alert').hide();//Oculto alert

})
$('#UsrEditarClave').on('shown.bs.modal', function (event) {

	var button = $(event.relatedTarget) // Botón que activó el modal
	var titulo = button.data('titulo') // Extraer la información de atributos de datos
	var usuarioid = button.data('usuarioid')

	var modal = $(this)
	modal.find('.modal-header .modal-title').text(titulo)
	modal.find('.modal-body #hddusuarioidclave').val(usuarioid)
	//$('.alert').hide();//Oculto alert

})
$('#UsuarioBaja').on('shown.bs.modal', function (event) {

	var button = $(event.relatedTarget) // Botón que activó el modal
	var titulo = button.data('titulo') // Extraer la información de atributos de datos
	var usridbaja = button.data('usridbaja')
	/*var usr = button.data('usr')
	var usrtipo = button.data('usrtipo')*/


	var modal = $(this)
	modal.find('.modal-header .modal-title').text(titulo)
	modal.find('.modal-body #hddusuarioidbaja').val(usridbaja)
	/*modal.find('.modal-body #txtusuario').val(usr)
	modal.find('.modal-body #cbousuariotipo').val(usrtipo)

	$(".modal-body #txtusuario").focus();*/
	//$('.alert').hide();//Oculto alert

})
$('#UsuarioHab').on('shown.bs.modal', function (event) {

	var button = $(event.relatedTarget) // Botón que activó el modal
	var titulo = button.data('titulo') // Extraer la información de atributos de datos
	var usridhab = button.data('usridhab')

	var modal = $(this)
	modal.find('.modal-header .modal-title').text(titulo)
	modal.find('.modal-body #hddusuarioidhab').val(usridhab)
	//$('.alert').hide();//Oculto alert

})
$('#UsuarioClaveRes').on('shown.bs.modal', function (event) {

	var button = $(event.relatedTarget) // Botón que activó el modal
	var titulo = button.data('titulo') // Extraer la información de atributos de datos
	var usridres = button.data('usridres')
	var usuariores = button.data('usuariores')

	var modal = $(this)
	modal.find('.modal-header .modal-title').text(titulo)
	modal.find('.modal-body #hddusuarioidres').val(usridres)
	modal.find('.modal-body #hddusuariores').val(usuariores)
	//$('.alert').hide();//Oculto alert

})
jQuery(document).ready(function () {
	//jQuery('#txtclavenueva, #txtclaveactual, #txtclavenuevarep').on('keyup', function() {
	jQuery('#btnclavecambiar').on('click', function () {
		//alert("HOLA");
		var UsrId = $("#hddusuarioidclave").val();
		var ClaAc = $("#txtclavenueva").val();
		var ClaNu = $("#txtclaveactual").val();
		var ClaNuRep = $("#txtclavenuevarep").val();
		//alert(UsrId);
		$.ajax({
			url: "?c=usuario&a=ClaveVerificar",
			type: "POST",
			dataType: "json",
			data: { usrid: UsrId, claac: ClaAc },
			success: function (res) {
				var respuesta = res.respuesta;
				//alert(respuesta);
				if (respuesta == 0) {
					$('#smlusuarionotificacion').css({ "color": "#FF0000" });
					$('#smlusuarionotificacion').text("* La contraseña actual es incorrecta");
				} else {
					//$('#smlusuarionotificacion').text("* OK");
					clavenu_lon = ClaNu.length;
					//alert(clavenu_lon);
					if (clavenu_lon < 6) {
						//menor 6
						//alert("NO");
						$('#smlusuarionotificacion').css({ "color": "#FF0000" });
						$('#smlusuarionotificacion').text("* La nueva contraseña debe tener al menos 6 caracteres");
					} else {
						//bien
						//alert("SI");
						if (ClaNu == ClaNuRep) {
							//--bine
							$('#smlusuarionotificacion').css({ "color": "#008000" });
							$('#smlusuarionotificacion').text("* OK");
							$.ajax({
								url: "?c=usuario&a=UsuarioCambiarClave",
								method: "POST",
								data: {
									UsuarioId: UsrId,
									Clave: ClaNu
								},
								success: function (data) {
									//obtener_icompras_asiento();
									/*jQuery("#divhcomercialescuatroac").html(data);*/
									$("#UsrEditarClave").modal('hide');
								}
							})
						} else {
							//--no
							$('#smlusuarionotificacion').css({ "color": "#FF0000" });
							$('#smlusuarionotificacion').text("* La nueva contraseña no coincide");
						}
					}
				}

			}
		})
	});
});