$(document).ready(function () {
  obtenerRoles();
  /*=============================================
OBTENER USUARIOS
=============================================*/

  var tablaUsuarios = $("#tablaUsuarios").DataTable({
    language: {
      sProcessing: "Procesando...",
      sLengthMenu: "Mostrar _MENU_ registros",
      sZeroRecords: "No se encontraron resultados",
      sEmptyTable: "Ningún dato disponible en esta tabla",
      sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
      sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0",
      sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
      sSearch: "Buscar:",
      sLoadingRecords: "Cargando...",
      oAria: {
        sSortAscending:
          ": Activar para ordenar la columna de manera ascendente",
        sSortDescending:
          ": Activar para ordenar la columna de manera descendente",
      },
    },
    ajax: {
      url: "http/usuarios.endpoint.php",
      type: "GET",
      dataType: "json",
      dataSrc: "data",
    },
    columns: [
      { data: "id_rol" },
      { data: "username" },
      { data: "nombres" },
      { data: "apellidos" },
      { data: "ultimo_login" },
    ],
    responsive: true, // ✅ Mejora visual en dispositivos móviles
    deferRender: true, // ✅ Mejora el rendimiento si hay muchos registros
  });

  // $.ajax({
  //   type: "GET",
  //   url: "http/usuarios.endpoint.php",
  //   // data: "data",
  //   dataType: "Application/json",
  //   success: function (response) {
  //     console.log("respuesta", response);
  //   },
  // });
});

/*=============================================
OBTENER ROLES
=============================================*/

function obtenerRoles() {
  let mostrarRoles = "";

  $.ajax({
    url: "http/roles.endpoint.php",
    method: "GET",
    dataType: "json",
    cache: false,
    contentType: "Application/json",
    success: function (respuesta) {
      if (respuesta.success === true) {
        $("#selectMostrarRoles").html(
          "<option value='' default>Seleccionar Rol</option>"
        );

        $("#selectMostrarRoles").empty();

        respuesta.data.forEach((rol) => {
          mostrarRoles += `
            <option value="${rol.id}">${rol.rol}</option>
          `;
        });

        $("#selectMostrarRoles").append(mostrarRoles);
      } else {
        swal.fire({
          title: "Error al registrar",
          icon: "error",
          draggable: true,
        });
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.error("Error en la solicitud:", textStatus, errorThrown);
      // Aquí puedes manejar el error, por ejemplo, mostrando una alerta al usuario.
    },
  });
}

/*=============================================
CREAR USUARIO
=============================================*/

$("#formCrearUsuario").on("submit", function (e) {
  e.preventDefault();

  const rol = $("#nuevoRol").val().trim();
  const nombres = $("#nuevoNombres").val().trim();
  const apellidos = $("#nuevoApellidos").val().trim();
  const username = $("#nuevoUsername").val().trim();
  const password = $("#ingPassword").val().trim();

  if (
    rol == "" ||
    nombres == "" ||
    apellidos == "" ||
    username == "" ||
    password == ""
  ) {
    $("#alerta").removeClass("d-none");
    $("#alerta").html("Por favor, completa todos los campos.");
    alert("Por favor, completa todos los campos.");
    return;
  }

  const data = {
    rol: rol,
    nombres: nombres,
    apellidos: apellidos,
    username: username,
    password: password,
  };

  registrarUsuario(JSON.stringify(data));
});

function registrarUsuario(datos) {
  $.ajax({
    url: "http/usuarios.endpoint.php",
    method: "POST",
    data: datos,
    dataType: "json",
    cache: false,
    contentType: "Application/json",
    success: function (respuesta) {
      if (respuesta.success === true) {
        // Redirigir al usuario a la página principal o dashboard
        swal.fire({
          title: "Registrado con exito",
          icon: "success",
          draggable: true,
        });
        console.log(respuesta.success);
      } else {
        swal.fire({
          title: "Error al registrar",
          icon: "error",
          draggable: true,
        });
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.error("Error en la solicitud:", textStatus, errorThrown);
      // Aquí puedes manejar el error, por ejemplo, mostrando una alerta al usuario.
    },
  });
}
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
