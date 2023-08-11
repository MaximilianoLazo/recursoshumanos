
function refresca(){
	var xmlHttp;
	if (window.XMLHttpRequest){
		xmlHttp=new XMLHttpRequest();
	}else{
		xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlHttp.onreadystatechange=function(){
		if(xmlHttp.readyState==4){
			document.getElementById("online").innerHTML=xmlHttp.responseText;
			setTimeout('refresca()',1000);
		}
	}
	xmlHttp.open("GET","includes/online.php",true);
	xmlHttp.send(null);
	}
	window.onload = function startrefresh(){
	setTimeout('refresca()',1000);
}
function objetoAjax(){
	var xmlhttp=false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
 
	try {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	} catch (E) {
		xmlhttp = false;
	}
}
 
if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
	  xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}




function login(){
  divResultado = document.getElementById('mensaje');
  email=document.form1.email.value;
  pass=document.form1.password.value;
  ajax=objetoAjax();
  ajax.open("POST", "includes/iniciar.php",true);
  ajax.onreadystatechange=function() {
  	if (ajax.readyState==4) {
		divResultado.innerHTML = ajax.responseText
	}
 }
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("email="+email+"&password="+pass)
}
		function LimpiarCampos(){
		  document.form1.email.value="";
		  document.form1.password.value="";
		  document.form1.email.focus();
		}		



function enviar(){
  divResultado = document.getElementById('res');
  email=document.nuevo_user.email.value;
				pass=document.nuevo_user.password.value;
				nom=document.nuevo_user.nombre.value;
				ape=document.nuevo_user.ap.value;
				foto=document.nuevo_user.nomfoto.value;
				tipo=document.nuevo_user.tipo.value; 
  ajax=objetoAjax();
  ajax.open("POST", "includes/insertar_nuevo_usuario.php",true);
  ajax.onreadystatechange=function() {
  	if (ajax.readyState==4) {
		divResultado.innerHTML = ajax.responseText
		Limpiar();
	}
 }
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("email="+email+"&password="+pass+"&nombre="+nom+"&ap="+ape+"&tipo="+tipo+"&fotos="+foto)
	  setTimeout('document.location.reload()',2000);
}
		function Limpiar(){
		  document.nuevo_user.email.value="";
		  document.nuevo_user.password.value="";
		  document.nuevo_user.nombre.value="";
		  document.nuevo_user.ap.value="";
		  document.nuevo_user.fotos.value="";
		  document.nuevo_user.tipo.value="";
		  document.nuevo_user.email.focus();
		}	