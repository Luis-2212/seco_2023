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
      sSortAscending: ": Activar para ordenar la columna de manera ascendente",
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
    { data: "nombres" },
    { data: "apellidos" },
    { data: "username" },
    { data: "rol" },
    {
      data: "ultimo_login",
      render: function (data) {
        if (!data) {
          return "";
        }
        // Convierte la fecha con moment y la formatea
        return moment(data).format("DD/MM/YYYY HH:mm:ss");
      },
    },
    {
      data: "fecha_creacion",
      render: function (data) {
        if (!data) {
          return "";
        }
        // Convierte la fecha con moment y la formatea
        return moment(data).format("DD/MM/YYYY HH:mm:ss");
      },
    },
    {
      data: "fecha_actualizacion",
      render: function (data) {
        if (!data) {
          return "";
        }
        // Convierte la fecha con moment y la formatea
        return moment(data).format("DD/MM/YYYY HH:mm:ss");
      },
    },
    {
      data: "id", // Usamos el ID del registro para los botones
      render: function (data, type, row) {
        const botonEditar = `<button class="btn btn-warning btn-sm" id="btnModalEditarUsuario" data-bs-toggle="modal" data-bs-target="#modalEditarUsuario" data-id="${data}"><i class="fa-solid fa-pen-to-square"></i></button>`;

        const botonEliminar = `<button class="btn btn-danger btn-sm" id="btnEliminarUsuario" data-id="${data}"><i class="fa-solid fa-trash-can"></i></button>`;

        return `${botonEditar} ${botonEliminar}`;
      },
    },
  ],
  responsive: true,
  deferRender: true,
});

/*=============================================
CREAR USUARIO
=============================================*/

$("#formCrearUsuario").on("submit", function (e) {
  e.preventDefault();

  const rol = $("#selectMostrarRoles").val().trim();
  const nombres = $("#nuevoNombres").val().trim();
  const apellidos = $("#nuevoApellidos").val().trim();
  const username = $("#nuevoUsername").val().trim();
  const password = $("#nuevoPassword").val().trim();

  if (
    rol == "" ||
    nombres == "" ||
    apellidos == "" ||
    username == "" ||
    password == ""
  ) {
    $(".alerta").removeClass("d-none");
    $(".alerta").html("Por favor, completa todos los campos.");
    return;
  }

  const data = {
    id_rol: rol,
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
        // Mensaje de registro exitoso
        Swal.fire({
          position: "top-end",
          icon: "success",
          title: "Registrado con exito",
          showConfirmButton: false,
          timer: 1500,
        });

        function vaciarCampos() {
      // Vaciar inputs de texto, password, number, textarea, etc.
    $('input:not([type="checkbox"], [type="radio"],[type="selec"])').val('');
    $('#selectMostrarRoles').val('');

}
vaciarCampos();
        tablaUsuarios.ajax.reload(null, true);
      } else {
        // Mensaje de registro si ocurre un error
        Swal.fire({
          title: "Error al registrar",
          icon: "error",
        });
        tablaUsuarios.ajax.reload(null, true);
      }
    },
    error: function (jqXHR) {
      if (jqXHR.status) {
        const errorResponse = jqXHR.responseJSON;
        Swal.fire({
          title: "Error al registrar",
          text: errorResponse.message,
          icon: "error",
        });
        tablaClientes.ajax.reload(null, true);
      }
    },
  });
}

/*=============================================
OBTENER DATO DEL USUARIO A EDITAR
=============================================*/
tablaUsuarios.on("click", "#btnModalEditarUsuario", function () {
  let idUsuario = $(this).attr("data-id");

  $.ajax({
    url: `http/usuarios.endpoint.php?id=${idUsuario}`,
    method: "GET",
    cache: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      $("#editarUsuario").html(
        `${respuesta.data["nombres"]} ${respuesta.data["apellidos"]}`
      );
      $("#btnEditarUsuario").attr("data-id", `${respuesta.data["id"]}`);
      $("#editarRoles").val(respuesta.data["id_rol"]);
      $("#editarNombres").val(respuesta.data["nombres"]);
      $("#editarApellidos").val(respuesta.data["apellidos"]);
      $("#editarUsername").val(respuesta.data["username"]);
    },
  });
});

/*=============================================
EDITAR USUARIO
=============================================*/

$("#formEditarUsuario").on("submit", function (e) {
  e.preventDefault();

  const idUsuario = $("#btnEditarUsuario").attr("data-id");
  const rol = $("#editarRoles").val();
  const nombres = $("#editarNombres").val().trim();
  const apellidos = $("#editarApellidos").val().trim();
  const username = $("#editarUsername").val().trim();
  const password =
    $("#editarPassword").val() != "" ? $("#editarPassword").val().trim() : null;

  if (username == "") {
    alert("El usuario no puede quedar vacio");
    return;
  }

  const data = {
    id: idUsuario,
    id_rol: rol,
    nombres: nombres,
    apellidos: apellidos,
    username: username,
    password: password != "" ? password : null,
  };

  editarUsuario(JSON.stringify(data));
});

function editarUsuario(datos) {
  $.ajax({
    url: `http/usuarios.endpoint.php`,
    method: "PUT",
    data: datos,
    cache: false,
    contentType: "Application/json",
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      if (respuesta.success === true) {
        Swal.fire({
          position: "center",
          icon: "success",
          title: "Actualizado con exito",
          showConfirmButton: false,
          timer: 1500,
        });
        tablaUsuarios.ajax.reload(null, true);
        $("#modalEditarUsuario").modal("hide");
      } else {
        Swal.fire({
          title: "Error al actualizar",
          icon: "error",
        });
        tablaUsuarios.ajax.reload(null, true);
        $("#modalEditarUsuario").modal("hide");
      }
    },
    error: function (jqXHR) {
      if (jqXHR.status) {
        const errorResponse = jqXHR.responseJSON;
        Swal.fire({
          title: "Error al actualizar",
          text: errorResponse.message,
          icon: "error",
        });
        tablaUsuarios.ajax.reload(null, true);
        $("#modalEditarUsuario").modal("hide");
      }
    },
  });
}

/*=============================================
REVISAR SI EL USUARIO YA ESTÁ REGISTRADO
=============================================*/

$(".validarUsuario").on("input", function () {
  $(".alerta").addClass("d-none");

  var usuario = $(this).val();

  $.ajax({
    url: `http/usuarios.endpoint.php?username=${usuario}`,
    method: "GET",
    cache: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      if (respuesta.success == true) {
        $(".alerta").removeClass("d-none");
        $(".alerta").html(
          "<i class='fa-solid fa-triangle-exclamation'></i> Este Usuario ya existe, escoja otro"
        );
      } else {
        $(".alerta").addClass("d-none");
      }
    },
  });
});

/*=============================================
ELIMINAR USUARIO
=============================================*/
tablaUsuarios.on("click", "#btnEliminarUsuario", function () {
  let idUsuario = $(this).attr("data-id");

  Swal.fire({
    icon: "warning",
    title: "Advertencia",
    text: "¿Seguro que desea eliminar este Usuario?. No podrá deshacer esta acción",
    showCancelButton: true,
    confirmButtonText: "Si, borrar",
    confirmButtonColor: "#D13415",
  }).then((result) => {
    if (result.isConfirmed) {
      eliminarUsuario(idUsuario);
    }
  });
});

function eliminarUsuario(id) {
  $.ajax({
    url: `http/usuarios.endpoint.php?id=${id}`,
    method: "DELETE",
    cache: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      if (respuesta.success === true) {
        // Mensaje de registro exitoso
        Swal.fire({
          position: "center",
          icon: "success",
          title: "Eliminado con exito",
          showConfirmButton: false,
          timer: 1500,
        });
        tablaUsuarios.ajax.reload(null, true);
      }
    },
    error: function (respuesta) {
      Swal.fire({
        title: "Error al eliminar",
        icon: "error",
      });
      tablaUsuarios.ajax.reload(null, true);
      $("#modalEditarUsuario").modal("hide");
    },
  });
}

/*=============================================
CONFIRMAR CONTRASEÑA
=============================================*/
$(".confirmarPass").on("input", function () {
  $(".confirmarPass").val() === $(".pass").val()
    ? $("#btnRegistrarUsuario").removeAttr("disabled")
    : $("#btnRegistrarUsuario").attr("disabled", "disabled");
});
