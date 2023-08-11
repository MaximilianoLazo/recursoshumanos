function uploadFile( file ){
	var limit = 1048576*2,xhr;
	console.log( limit  )
	if( file ){
		if( file.size < limit ){
			xhr = new XMLHttpRequest();
			xhr.upload.addEventListener('load',function(e){
			}, false);
			xhr.upload.addEventListener('error',function(e){
			}, false);			
			xhr.open('POST','includes/upload.php');
            xhr.setRequestHeader("Cache-Control", "no-cache");
            xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
            nombrefoto=e.value+"_"+file.name;
            xhr.setRequestHeader("X-File-Name", nombrefoto);
            document.getElementById('nomfoto').value=nombrefoto;
            xhr.send(file);
		}else{
			alert('El archivo es mayor que 2MB!');
		}
	}
}
var upload_input = document.querySelectorAll('#archivo')[0];
var e=document.getElementById('email');
	upload_input.onchange = function(){	
	uploadFile( this.files[0] );
};