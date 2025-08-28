/*=============================================
  INICIALIZAR EL PLUGIN DE TELÉFONO
=============================================*/
var currentPath = window.location.pathname;

if (currentPath.endsWith("/productos")) {
  $("input[type=tel]").each(function () {
    window.intlTelInput(this, {
      initialCountry: "ve",
      showSelectDialCode: true,
    });
  });
}

/*=============================================
OBTENER Productos
=============================================*/

var tablaProductos = $("#tablaProductos").DataTable({
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
    url: "http/Productos.endpoint.php",
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
        const botonEditar = `<button class="btn btn-warning btn-sm" id="btnModalEditarProducto" data-bs-toggle="modal" data-bs-target="#modalEditarProducto" data-id="${data}"><i class="fa-solid fa-pen-to-square"></i></button>`;

        const botonEliminar = `<button class="btn btn-danger btn-sm" id="btnEliminarProducto" data-id="${data}"><i class="fa-solid fa-trash-can"></i></button>`;

        return `${botonEditar} ${botonEliminar}`;
      },
    },
  ],
  responsive: true,
  deferRender: true,
});

/*=============================================
CREAR Productos
=============================================*/

$("#formCrearProducto input[required]").on("input", function () {
  let allFilled = true;

  $("#formCrearProducto input[required]").each(function () {
    if ($(this).val().trim() === "") {
      allFilled = false;
      return false; // Salir del bucle each
    }
  });

  if (allFilled) {
    $("#btnRegistrarProducto").removeAttr("disabled");
  } else {
    $("#btnRegistrarProducto").attr("disabled", "disabled");
  }
});

$("#formCrearProducto").on("submit", function (e) {
  e.preventDefault();

  const nombres = $("#nuevoNombresProducto").val().trim();
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

  registrarProducto(JSON.stringify(data));
});

function registrarProducto(datos) {
  $.ajax({
    url: "http/productos.endpoint.php",
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
        tablaProductos.ajax.reload(null, true);
      } else {
        // Mensaje de registro si ocurre un error
        Swal.fire({
          title: "Error al registrar",
          text: respuesta.message,
          icon: "error",
        });
        tablaProductos.ajax.reload(null, true);
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
        tablaProductos.ajax.reload(null, true);
      }
    },
  });
}

/*=============================================
OBTENER DATO DEL Productos A EDITAR
=============================================*/
tablaProductos.on("click", "#btnModalEditarProducto", function () {
  let idCliente = $(this).attr("data-id");

  $.ajax({
    url: `http/Productos.endpoint.php?id=${idProducto}`,
    method: "GET",
    cache: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      $("#editarProducto").html(
        `${respuesta.data["razon_social"] || respuesta.data["nombres"]}`
      );
      $("#btnEditarProducto").attr("data-id", `${respuesta.data["id"]}`);
      $("#editarNombresProducto").val(respuesta.data["nombres"]);
      $("#editarRazonSocial").val(respuesta.data["razon_social"]);
      $("#editarTipoIdentificacion").val(respuesta.data["tipo_identificacion"]);
      $("#editarIdentificacion").val(respuesta.data["identificacion"]);
      $("#editarCodigoPais").val(respuesta.data["codigo_pais"]);
      $("#editarTelefono").val(respuesta.data["telefono"]);
      $("#editarCorreo").val(respuesta.data["correo"]);
      $("#editarDireccion").val(respuesta.data["direccion"]);
    },
  });
});

/*=============================================
EDITAR Producto
=============================================*/

$("#formEditarProducto").on("submit", function (e) {
  e.preventDefault();

  const idProducto = $("#btnEditarProducto").attr("data-id");
  const nombres = $("#editarNombresProducto").val().trim();
  const razon_social = $("#editarRazonSocial").val().trim();
  const tipo_identificacion = $("#editarTipoIdentificacion").val().trim();
  const identificacion = $("#editarIdentificacion").val();
  const direccion = $("#editarDireccion").val().trim();
  const codigo_pais = $("#editarCodigoPais").val().trim();
  const telefono = $("#editarTelefono").val().trim();
  const correo = $("#editarCorreo").val().trim();

  if (identificacion == "" || nombres == "") {
    alert("El usuario no puede quedar vacio");
    return;
  }

  const data = {
    id: idProducto,
    nombres: nombres,
    razon_social: razon_social,
    tipo_identificacion: tipo_identificacion,
    identificacion: identificacion,
    direccion: direccion,
    codigo_pais: codigo_pais,
    telefono: telefono,
    correo: correo,
  };

  editarProducto(JSON.stringify(data));
});

function editarProducto(datos) {
  $.ajax({
    url: `http/productos.endpoint.php`,
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
        tablaProductos.ajax.reload(null, true);
        $("#modalEditarProducto").modal("hide");
      } else {
        Swal.fire({
          title: "Error al actualizar",
          icon: "error",
        });
        tablaProductos.ajax.reload(null, true);
        $("#modalEditarProducto").modal("hide");
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
        tablaProductos.ajax.reload(null, true);
        $("#modalEditarProductos").modal("hide");
      }
    },
  });
}

/*=============================================
REVISAR SI EL Productos YA ESTÁ REGISTRADO
=============================================*/

$(".validarProducto").on("input", function () {
  $(".alerta").addClass("d-none");

  var identificacion = $(this).val();

  $.ajax({
    url: `http/productos.endpoint.php?identificacion=${identificacion}`,
    method: "GET",
    cache: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      if (respuesta.success == true) {
        $(".alerta").removeClass("d-none");
        $(".alerta").html(
          "<i class='fa-solid fa-triangle-exclamation'></i> Ya existe un Producto registrado con esta identificación"
        );
      } else {
        $(".alerta").addClass("d-none");
      }
    },
  });
});

/*=============================================
ELIMINAR Productos
=============================================*/
tablaProductos.on("click", "#btnEliminarProducto", function () {
  let idProducto = $(this).attr("data-id");

  Swal.fire({
    icon: "warning",
    title: "Advertencia",
    text: "¿Seguro que desea eliminar este Producto?. No podrá deshacer esta acción",
    showCancelButton: true,
    confirmButtonText: "Si, borrar",
    confirmButtonColor: "#D13415",
  }).then((result) => {
    if (result.isConfirmed) {
      eliminarProducto(idProducto);
    }
  });
});

function eliminarProducto(id) {
  $.ajax({
    url: `http/productos.endpoint.php?id=${id}`,
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
        tablaProductos.ajax.reload(null, true);
      }
    },
    error: function (respuesta) {
      Swal.fire({
        title: "Error al eliminar",
        icon: "error",
      });
      tablaProductos.ajax.reload(null, true);
      $("#modalEditarProducto").modal("hide");
    },
  });
}
