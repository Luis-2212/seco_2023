/*=============================================
EDITAR USUARIO
=============================================*/
$(".DataTable").on("click", "#btnEditarUsuario", function () {
  var idUsuario = $(this).attr("idUsuario");

  var datos = new FormData();
  datos.append("idUsuario", idUsuario);

  $.ajax({
    url: "http/usuarios.endpoint.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      $("#idUsuario").val(respuesta["id"]);
      $("#editarNombres").val(respuesta["nombres"]);
      $("#editarEmail").val(respuesta["email"]);
      $("#editarUsuario").val(respuesta["usuario"]);
      $("#editarRoles").val(respuesta["id_rol"]);

      $("#passwordActual").val(respuesta["password"]);
    },
  });
});

/*=============================================
REVISAR SI EL USUARIO YA ESTÁ REGISTRADO
=============================================*/

$("#nuevoUsuario").on("input", function () {
  $("#alerta").addClass("d-none");

  var usuario = $(this).val();

  var datos = new FormData();
  datos.append("validarUsuario", usuario);

  $.ajax({
    url: "http/usuarios.endpoint.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      if (respuesta) {
        $("#alerta").removeClass("d-none");
        $("#alerta").html("Este usuario ya existe");

        $("#nuebtnRegistrarUsuariovoUsuario").attr("disabled");
      }
    },
  });
});

/*=============================================
  ELIMINAR USUARIO
=============================================*/
$(".DataTable").on("click", "#btnEliminarUsuario", function () {
  var idEliminarUsuario = $(this).attr("idEliminarUsuario");

  Swal.fire({
    title: "¿Seguro que desea eliminar este Usuario?",
    showCancelButton: true,
    confirmButtonText: "Si, borrar",
    confirmButtonColor: "#3CC860",
  }).then((result) => {
    if (result.isConfirmed) {
      var datos = new FormData();

      datos.append("idEliminarUsuario", idEliminarUsuario);

      $.ajax({
        url: "http/usuarios.endpoint.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
          window.location = "usuarios";
        },
        error: function (respuesta) {
          Swal.fire({
            icon: "error",
            title: "¡Error, este usuario tiene reportes asignados!",
            confirmButtonText: "Ok",
          }).then((result) => {
            if (result.isConfirmed) {
              window.location = "usuarios";
            }
          });
        },
      });
    }
  });
});

/*=============================================
CONFIRMAR CONTRASEÑA
=============================================*/
$(".confirmarPass").on("input", function () {
  $(".confirmarPass").val() === $(".pass").val()
    ? $("#btnRegistrarUsuario").removeAttr("disabled")
    : $("#btnRegistrarUsuario").attr("disabled", "disabled");
});
