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

//------Al cargar el formulario datos de domicilio en vista-------
	//$.get("includes/php/obtener_provincias.php","pais="+$("#empppdl").val(), function(data){
    $.get("?c=empleado&a=ProvinciasObtener","pais="+$("#empppdl").val(), function(data){
      $("#cboempprovinciae").html(data);
      //console.log(data);
    });
    //$.get("includes/php/obtener_departamentos.php","provincia="+$("#empppdl").val(), function(data){
    $.get("?c=empleado&a=DepartamentosObtener","provincia="+$("#empppdl").val(), function(data){
      $("#cboempdepartamentoe").html(data);
      //console.log(data);
    });
    ////$.get("includes/php/obtener_localidades.php","departamento="+$("#empppdl").val(), function(data){
    //$.get("?c=empleado&a=LocalidadesObtener","departamento="+$("#empppdl").val(), function(data){
    //  $("#cboemplocalidade").html(data);
    //  //console.log(data);
    //});
    //----Al momento de cambiar datos de domicilio en vista-------
    /*en desuso por deshabilitacion de cajas
    $("#cboemppaism").change(function(){
      $.get("includes/php/obtener_provincias.php","pais="+$("#cboemppaism").val(), function(data){
        $("#cboempprovinciam").html(data);
        console.log(data);
      });
    });
    $("#cboempprovinciam").change(function(){
      $.get("includes/php/obtener_departamentos.php","provincia="+$("#cboempprovinciam").val(), function(data){
        $("#cboempdepartamentom").html(data);
        console.log(data);
      });
    });
    $("#cboempdepartamentom").change(function(){
      $.get("includes/php/obtener_localidades.php","departamento="+$("#cboempdepartamentom").val(), function(data){
        $("#cboemplocalidadm").html(data);
        console.log(data);
      });
    });
    */
    //----Al momento de cambiar datos de domicilio en modificacion-------
    $("#cboemppaism").change(function(){
      //$.get("includes/php/obtener_provincias.php","pais="+$("#cboemppaise").val(), function(data){
      $.get("?c=legajo&a=ProvinciasObtener","pais="+$("#cboemppaism").val(), function(data){
        $("#cboempprovinciae").html(data);
        //console.log(data);
      });
    });
    $("#cboempprovinciam").change(function(){
      //$.get("includes/php/obtener_departamentos.php","provincia="+$("#cboempprovinciae").val(), function(data){
      $.get("?c=legajo&a=DepartamentosObtener","provincia="+$("#cboempprovinciam").val(), function(data){
        $("#cboempdepartamentoe").html(data);
        //console.log(data);
      });
    });
    $("#cboempdepartamentom").change(function(){
      //$.get("includes/php/obtener_localidades.php","departamento="+$("#cboempdepartamentoe").val(), function(data){
      $.get("?c=legajo&a=LocalidadesObtener","departamento="+$("#cboempdepartamentom").val(), function(data){
        $("#cboemplocalidade").html(data);
        //console.log(data);
      });
    });
    //----Al momento de cambiar datos de domicilio conyuge en modificacion-------
    $("#cbocyepaism").change(function(){
      $.get("?c=legajo&a=ProvinciasObtener","pais="+$("#cbocyepaisme").val(), function(data){
        $("#cbocyeprovinciam").html(data);
      });
    });
    $("#cbocyeprovinciam").change(function(){
      $.get("?c=legajo&a=DepartamentosObtener","provincia="+$("#cbocyeprovinciam").val(), function(data){
        $("#cbocyedepartamentom").html(data);
      });
    });
    //$("#cbocyedepartamentom").change(function(){
    //  $.get("?c=legajo&a=LocalidadesObtener","departamento="+$("#cbocyedepartamentom").val(), function(data){
    //    $("#cbocyelocalidadm").html(data);
    //  });
    //});

})//ready


$('#JubiladoEditarSitRev').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget) // Botón que activó el modal
    var titulo = button.data('titulo') // Extraer la información de atributos de datos
    var jubiladoidn = button.data('jubiladoidn') // Extraer la información de atributos de datos
    var dni = button.data('dni')
    var nombre = button.data('nombre')
    var fecha = button.data('fecha')
    var periodo=button.data('periodo')
    var ventana=button.data('ventana')
    var modal = $(this)
    modal.find('.modal-header .modal-title').text(titulo)
    modal.find('.modal-body #id').val(jubiladoidn)
    modal.find('.modal-body #hddnombre').val(nombre)
    modal.find('.modal-body #textfecha').val(fecha)
    modal.find('.modal-body #hdddni').val(dni)
    modal.find('.modal-body #hddventana').val(ventana)

})

$('#SitRevistaAlta').on('show.bs.modal', function(event) {
  var button = $(event.relatedTarget) // Botón que activó el modal
  var titulo = button.data('titulo') // Extraer la información de atributos de datos
  var jubiladoidn = button.data('empid') // Extraer la información de atributos de datos
  var sucu = button.data('empsuc')
  var cuen = button.data('empbanco')
  var tipo = button.data('emptipo')
  var cat = button.data('empcat')
  var ventana=button.data('ventana')
  var modal = $(this)
  modal.find('.modal-header .modal-title').text(titulo)
  modal.find('.modal-body #hddjubiladoidn').val(jubiladoidn)
  modal.find('.modal-body #cbotipodoc').val(tipo)
  modal.find('.modal-body #sucursal').val(sucu)
  modal.find('.modal-body #cuenta').val(cuen)
  modal.find('.modal-body #cbotipojub').val(cat)
})

$('#JubiladoEditarSitRevJub').on('show.bs.modal', function(event) {
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

$('#CategoriaEliminar').on('show.bs.modal', function(event) {
  var button = $(event.relatedTarget) // Botón que activó el modal
  var titulo = button.data('titulo') // Extraer la información de atributos de datos
  var categoriaidn = button.data('cat')
  var jubiladoidn = button.data('jubid')
  var nom = button.data('nombre')


  var modal = $(this)
  modal.find('.modal-header .modal-title').text(titulo)
  modal.find('.modal-body #hddjubiladoidn').val(jubiladoidn)
  modal.find('.modal-body #hddnombre').val(nom)
  modal.find('.modal-body #hddcategoriaidn').val(categoriaidn)

})

$('#EmpleadoBaja').on('show.bs.modal', function (event){
  //$('#EmpleadoEditarDatosPersonales').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botón que activó el modal
    var titulo = button.data('titulo') // Extraer la información de atributos de datos
    var empid = button.data('empid') // Extraer la información de atributos de datos
    var empnrodocto = button.data('empnrodocto')

    var modal = $(this)
    modal.find('.modal-header .modal-title').text(titulo)
    modal.find('.modal-body #hddempide').val(empid)
    modal.find('.modal-body #hddempnrodoctoe').val(empnrodocto)

    $('.alert').hide();//Oculto alert

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
  var importeh=button.data('immp')
  //var dni = button.data('dni')
  var nombre = button.data('nombre1')
  var modal = $(this)
  modal.find('.modal-header .modal-title').text(titulo)
  modal.find('.modal-body #id').val(jubiladomodiidn)
  modal.find('.modal-body #nombre1').val(nombre)
  modal.find('.modal-body #hddimporte').val(importeh)

  //modal.find('.modal-body #hdddni').val(dni)

})

$('#GenerarHaberInicial').on('show.bs.modal', function(event) {

  var button = $(event.relatedTarget) // Botón que activó el modal
  var titulo = button.data('titulo') // Extraer la información de atributos de datos
  var jubiladomodiidn = button.data('pid') // Extraer la información de atributos de datos
  var nombre=button.data('nom')
  var importe=button.data('imp')
  //var dni = button.data('dni')
  //var nombre = button.data('nombre')
  var modal = $(this)
  modal.find('.modal-header .modal-title').text(titulo)
  modal.find('.modal-body #id').val(jubiladomodiidn)
  modal.find('.modal-body #hddimporte').val(importe)
  modal.find('.modal-body #hddnombre').val(nombre)

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

$('#EmpleadoEditarDatosPersonales').on('shown.bs.modal', function (event){
  //$('#EmpleadoEditarDatosPersonales').on('show.bs.modal', function (event) {

    var button = $(event.relatedTarget) // Botón que activó el modal
    var titulo = button.data('titulo') // Extraer la información de atributos de datos
    var empid = button.data('empid') // Extraer la información de atributos de datos
    var empnrodocto = button.data('empnrodocto')
    var empnrocuil = button.data('empnrocuil')
    var empnrolegajo = button.data('empnrolegajo')
    var empapellido = button.data('empapellido')
    var empnombres = button.data('empnombres')
    var empsexo = button.data('empsexo')
    var empestadocivil = button.data('empestadocivil')
    var empfecnac = button.data('empfecnac')
    var empfecing = button.data('empfecing')
    var empmovimiento = button.data('empmovimiento')
    var empdiscapa = button.data('empdisc')

    var modal = $(this)
    modal.find('.modal-header .modal-title').text(titulo)
    modal.find('.modal-body #hddempide').val(empid)
    modal.find('.modal-body #hddempnrodocto').val(empnrodocto)
    modal.find('.modal-body #hddempmovimientoe').val(empmovimiento)
    modal.find('.modal-body #txtnrodoctoe').val(empnrodocto)
    modal.find('.modal-body #txtempnrocuile').val(empnrocuil)
    modal.find('.modal-body #txtempnrolegajoe').val(empnrolegajo)
    modal.find('.modal-body #txtempapellidoe').val(empapellido)
    modal.find('.modal-body #txtempnombrese').val(empnombres)
    modal.find('.modal-body #cboempsexoe').val(empsexo)
    modal.find('.modal-body #cboempestadocivile').val(empestadocivil)
    modal.find('.modal-body #txtempfecnace').val(empfecnac)
    modal.find('.modal-body #txtempfecinge').val(empfecing)

    if(empdiscapa == 1){$('.modal-body #jubdisc').attr('checked',true);};


    if(empmovimiento == 2){
      $('.modal-body #txtnrodoctoe').prop('disabled', true);
      $('.modal-body #txtempnrolegajoe').prop('disabled', true);
      $(".modal-body #txtempnrocuile").focus();
      //$('#txtempnrocuile').trigger('focus');
    }



    $('.alert').hide();//Oculto alert

  })

  $('#EmpleadoEditarDomicilio').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botón que activó el modal
    var titulo = button.data('titulo') // Extraer la información de atributos de datos
    var empid = button.data('empid') // Extraer la información de atributos de datos
    var empnrodocto = button.data('empnrodocto')
    var empdireccion = button.data('empdireccion')
    var empdirecnro = button.data('empdirecnro')
    var empdirecpiso = button.data('empdirecpiso')
    var empcpostal = button.data('empcpostal')
    var emppais = button.data('emppais')
    var empprovincia = button.data('empprovincia')
    var empdepartamento = button.data('empdepartamento')
    var emplocalidad = button.data('emplocalidad')

    var modal = $(this)
    modal.find('.modal-title').text(titulo)
    modal.find('.modal-body #hddempide').val(empid)
    modal.find('.modal-body #hddempnrodoctoe').val(empnrodocto)
    modal.find('.modal-body #txtempdireccione').val(empdireccion)
    modal.find('.modal-body #txtempdirenroe').val(empdirecnro)
    modal.find('.modal-body #txtempdirecpisoe').val(empdirecpiso)
    modal.find('.modal-body #txtempcpostale').val(empcpostal)
    modal.find('.modal-body #cboemppaise').val(emppais)
    //modal.find('.modal-body #cboempprovinciae').val(empprovincia)
    //$.get("includes/php/obtener_provincias.php","pais="+$("#cboemppaise").val(), function(data){
    $.get("?c=legajo&a=ProvinciasObtener","pais="+$("#cboemppaise").val(), function(data){
      $("#cboempprovinciae").html(data);
      modal.find('.modal-body #cboempprovinciae').val(empprovincia)
      //console.log(data);
    });
    //modal.find('.modal-body #cboempprovinciae').val(empprovincia)
    //$.get("includes/php/obtener_departamentos.php",{provincia: empprovincia}, function(data){
    $.get("?c=legajo&a=DepartamentosObtener",{provincia: empprovincia}, function(data){
      $("#cboempdepartamentoe").html(data);
      modal.find('.modal-body #cboempdepartamentoe').val(empdepartamento)
      //console.log(data);
    });
    //$.get("includes/php/obtener_localidades.php",{departamento: empdepartamento}, function(data){
    $.get("?c=legajo&a=LocalidadesObtener",{departamento: empdepartamento}, function(data){
      $("#cboemplocalidade").html(data);
      modal.find('.modal-body #cboemplocalidade').val(emplocalidad)
      //console.log(data);
    });

    $('.alert').hide();//Oculto alert
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
$('#HijoModificar').on('show.bs.modal', function(event) {
  var button = $(event.relatedTarget) // Botón que activó el modal

  var titulo = button.data('titulo') // Extraer la información de atributos de datos
  var hijoidn = button.data('pid1')
  var jubiladoidn = button.data('jub')
  var hijonom = button.data('nom')
  var hijoape = button.data('ape')
  var hijodni = button.data('dni')
  var hijotipodni = button.data('tipodni')
  var hijodir = button.data('dir')
  var hijotipodoc = button.data('tipodoc')
  var fechanac = button.data('fec')

  var modal = $(this)
  modal.find('.modal-header .modal-title').text(titulo)
  modal.find('.modal-body #hddhijoidn').val(hijoidn)
  modal.find('.modal-body #hddjubiladoidn').val(jubiladoidn)
  modal.find('.modal-body #hddnom1').val(hijonom)
  modal.find('.modal-body #hddape1').val(hijoape)
  modal.find('.modal-body #hdddni').val(hijodni)
  modal.find('.modal-body #cbotipodoc').val(hijotipodni)
  modal.find('.modal-body #direccion').val(hijodir)
  modal.find('.modal-body #cbotipodoc').val(hijotipodoc)
  modal.find('.modal-body #textfecha').val(fechanac)

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

$(document).on("click", "#btnjubiladoeditar", function(){

  $('#btnjubiladoeditar').prop('disabled', false);
})

$(document).on("click", "#btncategoriamodificar", function(){
    alert($("#fecini").val());

    //controlar las fechas de carga de categoria
  //$('#btnjubiladoeditar').prop('disabled', false);
})

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
