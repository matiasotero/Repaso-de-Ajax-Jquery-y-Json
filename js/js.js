function EnviarDatos(){

	//CREO UN OBJETO JSON
    var patente=document.getElementById("autocomplete").value;
    var ahora=new Date();
    var horarioEntrada=ahora.getFullYear()+"-"+("0"+(ahora.getMonth()+1)).slice(-2)+"-"+("0"+(ahora.getDay()+1)).slice(-2)+" "+ahora.getHours()+":"+ahora.getMinutes()+":"+ahora.getSeconds();
    //var fotoArchivo=document.getElementById("fotoAutito");
    //var fotoArchivo=document.forms["ingresoDeAutos"]["fotoAutito"].files[0];
    //var foto = $("#fotoAutito");
    var archivo = $("#fotoAutito").val();
    var formData = new FormData();
    var auto={}	
	var pagina = "gestion.php";
	
    $.ajax({
        type: 'POST',//GET o POST. GET DEFAULT.
        url: pagina,//PAGINA DESTINO DE LA PETICION
        dataType: "text",//INDICA EL TIPO QUE SE ESPERA RECIBIR DESDE EL SERVIDOR (XML, HTML, TEXT, JSON, SCRIPT) 
        //data: {miPersona : persona},//DATO A SER ENVIADO AL SERVIDOR. TIPO: OBJETO, STRING, ARRAY.
        async: true//ESTABLECE EL MODO DE PETICION. DEFECTO ASINCRONICO.
    })
	.done(function (resultado) {//RECUPERO LA RESPUESTA DEL SERVIDOR EN 'RESULTADO', DE ACUERDO AL DATATYPE.
		$("#divResultado").html(resultado);
        
        console.log("Se enviaron los datos!");
        //console.log(horarioEntrada);
        //console.log(fotoArchivo.value);
        console.log("foto: "+archivo);

	})
	.fail(function (jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);

    }); 	

}
