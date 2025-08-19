/*=============================================
EDITAR ROL
=============================================*/

$(".tablas").on("click", ".btnEditarRol", function(){

	var idRol = $(this).attr("idRol");

	var datos = new FormData();

    datos.append("idRol", idRol);

    $.ajax({

      url:"ajax/roles.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(respuesta){      

      	   $("#idRol").val(respuesta["id"]);

	         $("#editarRol").val(respuesta["rol"]);

	         $("#editarDescripcion").val(respuesta["descripcion"]);

	  }

  	})

})

/*=============================================
ELIMINAR ROL
=============================================*/
$(".tablas").on("click", ".btnEliminarRol", function(){

  var idRol = $(this).attr("idRol");

  swal({
    title: '¿Está seguro de borrar el Rol?',
    text: "¡Si no lo está puede cancelar la accíón!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Si, borrar Rol!'
  }).then(function(result){

    if(result.value){

      window.location = "index.php?ruta=roles&idRol="+idRol;

    }

  })

})
