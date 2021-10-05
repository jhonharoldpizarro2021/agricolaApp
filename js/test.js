function insertar()
{
  $.ajax({
		cache:false,
		dataType:"jsonp",
		type:"POST",
		url: "../querys/test.php",
		data: {opcion:1,nombre:nombre,id_padre:id_padre,codigo:codigo,descp:descp,area:area},
		success: function(res)
		{
			if(res.estado == "ERROR")
			{
				$("#validacion").html("Se presentó un error. Error:"+ res.msg);
			}else if(res.estado == "OK")
			{

        $("#validacion").html("Registro con éxito.");
			}
		}
	});
}

function Consultar()
{
  $.ajax({
		cache:false,
		dataType:"jsonp",
		type:"POST",
		url: "../querys/test.php",
		data: {opcion:4,id:id},
		success: function(res)
		{
			if(res.estado == "ERROR")
			{
				$("#validacion").html("Se presentó un error. Error:"+ res.msg);
			}else if(res.estado == "EMPTY"){
        $("#validacion").html("No hay datos");
      }else if(res.estado == "OK")
			{
        for( var i=0; i < res.unidades.length; i++)
        {
          $("#validacion").html("Nombre:"+ res.unidades[i].nombre);
        }
			}
		}
	});
}
