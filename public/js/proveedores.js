/*=============================================
OBTENER PROVEEDORES
=============================================*/

var tablaProveedores = $("#tablaProveedores").DataTable({
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
    url: "http/proveedores.endpoint.php",
    type: "GET",
    dataType: "json",
    dataSrc: "data",
  },
  columns: [
    { data: "nombres" },
    { data: "razon_social" },
    { data: "tipo_identificacion" },
    { data: "identificacion" },
    { data: "direccion" },
    { data: "codigo_pais" },
    { data: "telefono" },
    { data: "correo" },
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
        const botonEditar = `<button class="btn btn-warning btn-sm" id="btnModalEditarProveedor" data-bs-toggle="modal" data-bs-target="#modalEditarProveedor" data-id="${data}"><i class="fa-solid fa-pen-to-square"></i></button>`;

        const botonEliminar = `<button class="btn btn-danger btn-sm" id="btnEliminarProveedor" data-id="${data}"><i class="fa-solid fa-trash-can"></i></button>`;

        return `${botonEditar} ${botonEliminar}`;
      },
    },
  ],
  responsive: true,
  deferRender: true,
});

/*=============================================
CREAR PROVEEDOR
=============================================*/

$("#formCrearProveedor input[required]").on("input", function () {
  let allFilled = true;

  $("#formCrearProveedor input[required]").each(function () {
    if ($(this).val().trim() === "") {
      allFilled = false;
      return false; // Salir del bucle each
    }
  });

  if (allFilled) {
    $("#btnRegistrarProveedor").removeAttr("disabled");
  } else {
    $("#btnRegistrarProveedor").attr("disabled", "disabled");
  }
});

$("#formCrearProveedor").on("submit", function (e) {
  e.preventDefault();

  const nombres = $("#nuevoNombresProveedor").val().trim();
  const razon_social = $("#nuevoRazonSocial").val().trim();
  const tipo_identificacion = $("#nuevoTipoIdentificacion").val().trim();
  const identificacion = $("#nuevoIdentificacion").val();
  const direccion = $("#nuevoDireccion").val().trim();
  const codigo_pais = $("#nuevoCodigoPais").val().trim();
  const telefono = $("#nuevoTelefono").val().trim();
  const correo = $("#nuevoCorreo").val().trim();

  if (
    nombres == "" ||
    razon_social == "" ||
    tipo_identificacion == "" ||
    identificacion == "" ||
    codigo_pais == "" ||
    telefono == "" ||
    correo == ""
  ) {
    $(".alerta").removeClass("d-none");
    $(".alerta").html("Por favor, completa todos los campos.");
    return;
  }

  const data = {
    nombres: nombres,
    razon_social: razon_social,
    tipo_identificacion: tipo_identificacion,
    identificacion: identificacion,
    direccion: direccion,
    codigo_pais: codigo_pais,
    telefono: telefono,
    correo: correo,
  };

  registrarProveedor(JSON.stringify(data));
});

function registrarProveedor(datos) {
  $.ajax({
    url: "http/proveedores.endpoint.php",
    method: "POST",
    data: datos,
    dataType: "json",
    cache: false,
    contentType: "Application/json",
    success: function (respuesta) {
      if (respuesta.success === true) {
        // Mensaje de registro exitoso
        Swal.fire({
          position: "center",
          icon: "success",
          title: "Registrado con exito",
          showConfirmButton: false,
          timer: 1500,
        });
        tablaProveedores.ajax.reload(null, true);
      } else {
        // Mensaje de registro si ocurre un error
        Swal.fire({
          title: "Error al registrar",
          text: respuesta.message,
          icon: "error",
        });
        tablaProveedores.ajax.reload(null, true);
      }
    },
    error: function (jqXHR) {
      if (jqXHR.status) {
        const errorResponse = jqXHR.responseJSON;
        Swal.fire({
          title: "Error al Registrar",
          text: errorResponse.message,
          icon: "error",
        });
        tablaProveedores.ajax.reload(null, true);
      }
    },
  });
}

/*=============================================
OBTENER DATO DEL PROVEEDOR A EDITAR
=============================================*/
tablaProveedores.on("click", "#btnModalEditarProveedor", function () {
  let idProveedor = $(this).attr("data-id");

  $.ajax({
    url: `http/proveedores.endpoint.php?id=${idProveedor}`,
    method: "GET",
    cache: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      $("#editarProveedor").html(
        `${respuesta.data["razon_social"] || respuesta.data["nombres"]}`
      );
      $("#btnEditarProveedor").attr("data-id", `${respuesta.data["id"]}`);
      $("#editarNombresProveedor").val(respuesta.data["nombres"]);
      $("#editarRazonSocial").val(respuesta.data["razon_social"]);
      $("#editarTipoIdentificacion").val(respuesta.data["tipo_identificacion"]);
      $("#editarIdentificacion").val(respuesta.data["identificacion"]);
      $("#editarCodigoPais").val(respuesta.data["codigo_pais"]);
      $("#editarTelefono").val(respuesta.data["telefono"]);
      $("#editarDireccion").val(respuesta.data["direccion"]);
    },
  });
});

/*=============================================
EDITAR CLIENTE
=============================================*/

// $("#formEditarCliente").on("submit", function (e) {
//   e.preventDefault();

//   const idCliente = $("#btnEditarCliente").attr("data-id");
//   const rol = $("#editarRoles").val();
//   const nombres = $("#editarNombres").val().trim();
//   const apellidos = $("#editarApellidos").val().trim();
//   const username = $("#editarUsername").val().trim();
//   const password =
//     $("#editarPassword").val() != "" ? $("#editarPassword").val().trim() : null;

//   if (username == "") {
//     alert("El usuario no puede quedar vacio");
//     return;
//   }

//   const data = {
//     id: idCliente,
//     id_rol: rol,
//     nombres: nombres,
//     apellidos: apellidos,
//     username: username,
//     password: password != "" ? password : null,
//   };

//   editarCliente(JSON.stringify(data));
// });

// function editarCliente(datos) {
//   $.ajax({
//     url: `http/clientes.endpoint.php`,
//     method: "PUT",
//     data: datos,
//     cache: false,
//     contentType: "Application/json",
//     processData: false,
//     dataType: "json",
//     success: function (respuesta) {
//       if (respuesta.success === true) {
//         Swal.fire({
//           position: "center",
//           icon: "success",
//           title: "Actualizado con exito",
//           showConfirmButton: false,
//           timer: 1500,
//         });
//         tablaClientes.ajax.reload(null, true);
//         $("#modalEditarCliente").modal("hide");
//       } else {
//         Swal.fire({
//           title: "Error al actualizar",
//           icon: "error",
//         });
//         tablaClientes.ajax.reload(null, true);
//         $("#modalEditarCliente").modal("hide");
//       }
//     },
//     error: function (jqXHR) {
//       if (jqXHR.status) {
//         const errorResponse = jqXHR.responseJSON;
//         Swal.fire({
//           title: "Error al actualizar",
//           text: errorResponse.message,
//           icon: "error",
//         });
//         tablaClientes.ajax.reload(null, true);
//         $("#modalEditarCliente").modal("hide");
//       }
//     },
//   });
// }

/*=============================================
REVISAR SI EL PROVEEDOR YA ESTÁ REGISTRADO
=============================================*/

$(".validarProveedor").on("input", function () {
  $(".alerta").addClass("d-none");

  var identificacion = $(this).val();

  $.ajax({
    url: `http/proveedores.endpoint.php?identificacion=${identificacion}`,
    method: "GET",
    cache: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      if (respuesta.success == true) {
        $(".alerta").removeClass("d-none");
        $(".alerta").html(
          "<i class='fa-solid fa-triangle-exclamation'></i> Ya existe un proveedor registrado con esta identificación"
        );
      } else {
        $(".alerta").addClass("d-none");
      }
    },
  });
});

/*=============================================
ELIMINAR CLIENTE
=============================================*/
// tablaClientes.on("click", "#btnEliminarCliente", function () {
//   let idCliente = $(this).attr("data-id");

//   Swal.fire({
//     icon: "warning",
//     title: "Advertencia",
//     text: "¿Seguro que desea eliminar este Usuario?. No podrá deshacer esta acción",
//     showCancelButton: true,
//     confirmButtonText: "Si, borrar",
//     confirmButtonColor: "#D13415",
//   }).then((result) => {
//     if (result.isConfirmed) {
//       eliminarUsuario(idCliente);
//     }
//   });
// });

// function eliminarUsuario(id) {
//   $.ajax({
//     url: `http/clientes.endpoint.php?id=${id}`,
//     method: "DELETE",
//     cache: false,
//     processData: false,
//     dataType: "json",
//     success: function (respuesta) {
//       if (respuesta.success === true) {
//         // Mensaje de registro exitoso
//         Swal.fire({
//           position: "center",
//           icon: "success",
//           title: "Eliminado con exito",
//           showConfirmButton: false,
//           timer: 1500,
//         });
//         tablaClientes.ajax.reload(null, true);
//       }
//     },
//     error: function (respuesta) {
//       Swal.fire({
//         title: "Error al eliminar",
//         icon: "error",
//       });
//       tablaClientes.ajax.reload(null, true);
//       $("#modalEditarCliente").modal("hide");
//     },
//   });
// }
