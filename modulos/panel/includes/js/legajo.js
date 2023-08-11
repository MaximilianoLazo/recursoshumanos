$(document).ready(function() {
  $("#txtnrodocto").blur(function(){
  //$("#txtdni").blur(function() {
    if ($("#txtnrodocto").val()==""){
    }else{
        var valor = jQuery("#txtnrodocto").val();
        $.ajax ({
          url:"?c=legajo&a=DatosJubiladoCompletar",
          type:"POST",
          dataType:"json",
          data: {val:valor},
          success: function(res){
            //faltan controles
                  $('#txtnrodocto').val(res.txtnrodocto);
                  $('#cbotipodocumento').val(res.cbotipodocumento);
									$('#txtapellido').val(res.txtapellido);
									$('#txtnombres').val(res.txtnombres);
                  $('#txtfnac').val(res.fnac);
                  $('#cbosexo').val(res.cbosexo);
                  $('#cbocivil').val(res.cbocivil);
                  $('#txtcelular').val(res.txtcelular);
                  $('#cboobrasocial').val(res.cboobrasocial);
          }//success
        })//ajax+
      }
  })//blur

})//ready


$('#JubiladoEditarSitRev').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget) // Botón que activó el modal
    var titulo = button.data('titulo') // Extraer la información de atributos de datos
    var jubiladoidn = button.data('jubiladoidn') // Extraer la información de atributos de datos
    var dni = button.data('dni')
    var nombre = button.data('nombre')
    var fecha = button.data('fecha')
    var periodo=button.data('periodo')
    var modal = $(this)
    modal.find('.modal-header .modal-title').text(titulo)
    modal.find('.modal-body #id').val(jubiladoidn)
    modal.find('.modal-body #hddnombre').val(nombre)
    modal.find('.modal-body #textfecha').val(fecha)
    modal.find('.modal-body #hdddni').val(dni)
    modal.find('.modal-body #hddper').val(periodo)

})

$('#ApoderadoModificar').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget) // Botón que activó el modal
    var titulo = button.data('titulo') // Extraer la información de atributos de datos
    var apoderadoidn = button.data('pid')
    var jubiladoidn = button.data('jid')
    var apoderadonom = button.data('nom')
    var apoderadoape = button.data('ape')
    var apoderadodni = button.data('dni')
    var apoderadotipodni = button.data('tipodni')
    var apoderadodir = button.data('dir')
    var apoderadocelu = button.data('celu')

    var modal = $(this)
    modal.find('.modal-header .modal-title').text(titulo)
    modal.find('.modal-body #hddapoderadoidn').val(apoderadoidn)
    modal.find('.modal-body #hddjubiladoidn').val(jubiladoidn)
    modal.find('.modal-body #hddnom').val(apoderadonom)
    modal.find('.modal-body #hddape').val(apoderadoape)
    modal.find('.modal-body #hdddni').val(apoderadodni)
    modal.find('.modal-body #cbotipodoc').val(apoderadotipodni)
    modal.find('.modal-body #direccion').val(apoderadodir)
    modal.find('.modal-body #celular').val(apoderadocelu)
})


$('#ApoderadoEliminar').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget) // Botón que activó el modal
    var titulo = button.data('titulo') // Extraer la información de atributos de datos
    var apoderadoidn = button.data('dpid')
    var jubiladoidn = button.data('jubid')
    var apoderadonom = button.data('nombre')

    var modal = $(this)
    modal.find('.modal-header .modal-title').text(titulo)
    modal.find('.modal-body #hddapoderadoidn').val(apoderadoidn)
    modal.find('.modal-body #hddjubiladoidn').val(jubiladoidn)
    modal.find('.modal-body #hddnombre').val(apoderadonom)

})

$('#ConyugeEliminar').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget) // Botón que activó el modal
    var titulo = button.data('titulo') // Extraer la información de atributos de datos
    var apoderadoidn = button.data('pid')
    var jubiladoidn = button.data('jub')
    var apoderadonom = button.data('nombre')

    var modal = $(this)
    modal.find('.modal-header .modal-title').text(titulo)
    modal.find('.modal-body #hddapoderadoidn').val(apoderadoidn)
    modal.find('.modal-body #hddjubiladoidn').val(jubiladoidn)
    modal.find('.modal-body #hddnombre').val(apoderadonom)

})

$('#ApoderadoAlta').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget) // Botón que activó el modal
    var titulo = button.data('titulo') // Extraer la información de atributos de datos
    var jubiladoidn = button.data('juid')

    var modal = $(this)
    modal.find('.modal-header .modal-title').text(titulo)
    modal.find('.modal-body #hddjubiladoidn').val(jubiladoidn)

})

$('#ConyugeAlta').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget) // Botón que activó el modal
    var titulo = button.data('titulo') // Extraer la información de atributos de datos
    var jubiladoidn = button.data('pid')
    var familiarnom = button.data('nom')

    var modal = $(this)
    modal.find('.modal-header .modal-title').text(titulo)
    modal.find('.modal-body #hddjubiladoidn').val(jubiladoidn)
    modal.find('.modal-body #nombr').val(familiarnom)

})

$('#CategoriaAlta').on('show.bs.modal', function(event) {
  var button = $(event.relatedTarget) // Botón que activó el modal
  var titulo = button.data('titulo') // Extraer la información de atributos de datos
  var jubiladoidn = button.data('pid')
  var familiarnom = button.data('nom')

  var modal = $(this)
  modal.find('.modal-header .modal-title').text(titulo)
  modal.find('.modal-body #hddjubiladoidn').val(jubiladoidn)
  modal.find('.modal-body #nombr').val(familiarnom)

})

$('#JubiladoModificar').on('show.bs.modal', function(event) {

    var button = $(event.relatedTarget) // Botón que activó el modal
    var titulo = button.data('titulo') // Extraer la información de atributos de datos
    var importemodiidn = button.data('pid') // Extraer la información de atributos de datos
   
    //var dni = button.data('dni')
    //var nombre = button.data('nombre')
    var modal = $(this)
    modal.find('.modal-header .modal-title').text(titulo)
    modal.find('.modal-body #id').val(importemodiidn)
    
    //modal.find('.modal-body #hddnombre').val(nombre)
    //modal.find('.modal-body #hdddni').val(dni)

})

$('#ImporteModificar').on('show.bs.modal', function(event) {

  var button = $(event.relatedTarget) // Botón que activó el modal
  var titulo = button.data('titulo') // Extraer la información de atributos de datos
  var jubiladomodiidn = button.data('pid') // Extraer la información de atributos de datos
  var nombrejubi=button.data('nombredelmes')
  var importeh=button.data('immp')
  //var dni = button.data('dni')
  //var nombre = button.data('nombre')
  var modal = $(this)
  modal.find('.modal-header .modal-title').text(titulo)
  modal.find('.modal-body #id').val(jubiladomodiidn)
  modal.find('.modal-body #nombre1').val(nombrejubi)
    modal.find('.modal-body #hddimporte').val(importeh)
  //modal.find('.modal-body #hddnombre').val(nombre)
  //modal.find('.modal-body #hdddni').val(dni)

})

$('#ConyugeModificar').on('show.bs.modal', function(event) {

    var button = $(event.relatedTarget) // Botón que activó el modal
    var titulo = button.data('titulo') // Extraer la información de atributos de datos
    var jubiladomodiidn = button.data('jub') // Extraer la información de atributos de datos
    var conyugemodiidn = button.data('pid')
    var dni = button.data('dninro')
    var dnitipo = button.data('dnitipo')
    var nombre = button.data('nom')
    var apellido = button.data('ape')
    var fecha = button.data('fec')
    var direccion = button.data('dir')
    var celular = button.data('cel')
    var modal = $(this)
    modal.find('.modal-header .modal-title').text(titulo)
    modal.find('.modal-body #hddjubiladoidn').val(jubiladomodiidn)
    modal.find('.modal-body #hddconyugeidn').val(conyugemodiidn)
    modal.find('.modal-body #hddapellido').val(apellido)
    modal.find('.modal-body #hddnombre').val(nombre)
    modal.find('.modal-body #hdddni').val(dni)
    modal.find('.modal-body #cbotipodoc').val(dnitipo)
    modal.find('.modal-body #textfecha').val(fecha)
    modal.find('.modal-body #direccion').val(direccion)
    modal.find('.modal-body #celular').val(celular)
          //modal.find('.modal-body #hddnombre').val(nombre)
    //modal.find('.modal-body #hdddni').val(dni)

})

$('#FamiliarEditar').on('show.bs.modal', function(event) {

    var button = $(event.relatedTarget) // Botón que activó el modal
    var titulo = button.data('titulo') // Extraer la información de atributos de datos
    var familiaridn = button.data('pid') // Extraer la información de atributos de datos
    var familiarnom = button.data('nom')
    //var dni = button.data('dni')
    //var nombre = button.data('nombre')
    var modal = $(this)
    modal.find('.modal-header .modal-title').text(titulo)
    modal.find('.modal-body #id').val(familiaridn)
    modal.find('.modal-body #nombr').val(familiarnom)
    //modal.find('.modal-body #hddnombre').val(nombre)
    //modal.find('.modal-body #hdddni').val(dni)

})
$('#HaberEditar').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget) // Botón que activó el modal
    var titulo = button.data('titulo') // Extraer la información de atributos de datos
    var jubiidn = button.data('pid') // Extraer la información de atributos de datos
    var jubinom = button.data('nom')
    //var dni = button.data('dni')
    //var nombre = button.data('nombre')
    var modal = $(this)
    modal.find('.modal-header .modal-title').text(titulo)
    modal.find('.modal-body #id').val(jubiidn)
    modal.find('.modal-body #nombr').val(jubinom)
    //modal.find('.modal-body #hddnombre').val(nombre)
    //modal.find('.modal-body #hdddni').val(dni)

})

$('#JubiladoEditar1').on('show.bs.modal', function (event){
//$('#EmpleadoEditarDatosPersonales').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget) // Botón que activó el modal
	var titulo = button.data('titulo') // Extraer la información de atributos de datos
	var pid = button.data('pid')
	var idninro = button.data('idninro')
	var idnitip = button.data('idnitip')
	var iape = button.data('iape')
	var inom = button.data('inom')
	var ifnac = button.data('ifnac')
	var ieciv = button.data('ieciv')
	var icel = button.data('icel')
	var iobsoc = button.data('iobsoc')
	var isex = button.data('isex')

	var modal = $(this)
	modal.find('.modal-header .modal-title').text(titulo)
	modal.find('.modal-body #hddindividuoid').val(pid)
	modal.find('.modal-body #cbotipodocumento').val(idnitip)
	modal.find('.modal-body #txtnrodocto').val(idninro)
	modal.find('.modal-body #txtapellido').val(iape)
	modal.find('.modal-body #txtnombres').val(inom)
	modal.find('.modal-body #txtfnac').val(ifnac)
	modal.find('.modal-body #cbosexo').val(isex)
	modal.find('.modal-body #cboecivil').val(ieciv)
	modal.find('.modal-body #txtcelular').val(icel)
	modal.find('.modal-body #cboobrasocial').val(iobsoc)

//	$('.alert').hide();//Oculto alert

})

$('#DomicilioEditar').on('show.bs.modal', function (event){
//$('#EmpleadoEditarDatosPersonales').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget) // Botón que activó el modal
	var dtitulo = button.data('titulo') // Extraer la información de atributos de datos
	var dpid = button.data('dpid')
	var didindiv = button.data('didindiv')
	var dnomcalle = button.data('dnomcalle')
	var dcallenro = button.data('dcallenro')
	var dcasadepto = button.data('dcasadepto')
	var diloc = button.data('diloc')
	var dreferencia = button.data('dreferencia')

	var modal = $(this)
	modal.find('.modal-header .modal-title').text(dtitulo)
	modal.find('.modal-body #hddindividuodid').val(didindiv)
	modal.find('.modal-body #hdddomicilioid').val(dpid)
	modal.find('.modal-body #txtcalle').val(dnomcalle)
  modal.find('.modal-body #txtnrocalle').val(dcallenro)
	modal.find('.modal-body #txtcasadepto').val(dcasadepto)
	modal.find('.modal-body #cbolocalidad').val(diloc)
	modal.find('.modal-body #txtreferencia').val(dreferencia)

	//$('.alert').hide();//Oculto alert

})


  $('#FamiliarEditar').on('show.bs.modal', function (event){
//$('#EmpleadoEditarDatosPersonales').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget) // Botón que activó el modal
	var ftitulo = button.data('ftitulo') // Extraer la información de atributos de datos
	var fid = button.data('fid')
	var fidindiv = button.data('fidindiv')
	var fvinculo = button.data('fvinculo')
	var fnombre = button.data('fnombre')
	var fapellido = button.data('fapellido')
	var fdni = button.data('fdni')
	var ffnacto = button.data('ffnacto')
	var fsalud = button.data('fsalud')
	var focupacion = button.data('focupacion')
	var fingresos = button.data('fingresos')
	var feducacion = button.data('feducacion')

var modal = $(this)
  modal.find('.modal-header .modal-title').text(ftitulo)
	modal.find('.modal-body #hddindividuoid').val(fidindiv)
	modal.find('.modal-body #hddfamiliarid').val(fid)
	modal.find('.modal-body #cbotipovinculo').val(fvinculo)
	modal.find('.modal-body #txtfnom').val(fnombre)
	modal.find('.modal-body #txtfap').val(fapellido)
	modal.find('.modal-body #txtfdni').val(fdni)
	modal.find('.modal-body #txtffnac').val(ffnacto)
	modal.find('.modal-body #cbofsalud').val(fsalud)
	modal.find('.modal-body #cboocupacion').val(focupacion)
	modal.find('.modal-body #txtfingresos').val(fingresos)
	modal.find('.modal-body #cboescolaridad').val(feducacion)
	$('.alert').hide();//Oculto alert

})

//$(document).on("click", "#btnjubiladoeditar", function(){

//    $.get("?c=legajo&a=JubiladoEdicion", "jubi_id=" + $("#hddjubiladoidn").val(), function(data) {
//    $("#hddjubiladoidn").html(data);
//    modal.find('.modal-body #hddjubiladoidn').val(jubiladoidn);
//    })
//})

 

//$(document).on("click", "#btnapoderadoeditar", function(){
//    $.get("?c=legajo&a=ApoderadoEdicion", "jubi_id=" + $("#hddjubiladoidn").val(), function(data) {
//    $("#hddjubiladoidn").html(data);
//    modal.find('.modal-body #hddjubiladoidn').val(apoderadoidn);
//    })
//})

//$(document).on("click", "#btnjubiladomodificar", function(){
//    $.get("?c=legajo&a=JubiladoModificar", "jub=" + $("#hddjubiladoidn").val(), function(data) {
//    $("#hddjubiladoidn").html(data);
//    modal.find('.modal-body #hddjubiladoidn').val(jubiladoidn);
//    })
//})
