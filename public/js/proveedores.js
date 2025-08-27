/*=============================================
  INICIALIZAR EL PLUGIN DE TELÉFONO
=============================================*/
const currentPath = window.location.pathname;

if (currentPath.endsWith("/proveedores")) {
  $("input[type=tel]").each(function () {
    window.intlTelInput(this, {
      initialCountry: "ve",
      showSelectDialCode: true,
    });
  });
}

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
    { data: "razon_social" },
    { data: "tipo_rif" },
    { data: "rif" },
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

  const razon_social = $("#nuevoRazonSocialProveedor").val().trim();
  const tipo_rif = $("#nuevoTipoRif").val();
  const rif = $("#nuevoRif").val();
  const direccion = $("#nuevoDireccionProveedor").val().trim();
  const codigo_pais = $("#nuevoCodigoPaisProveedor").val().trim();
  const telefono = $("#nuevoTelefonoProveedor").val().trim();
  const correo = $("#nuevoCorreoProveedor").val().trim();

  if (
    razon_social == "" ||
    tipo_rif == "" ||
    rif == "" ||
    codigo_pais == "" ||
    telefono == "" ||
    correo == ""
  ) {
    $(".alerta").removeClass("d-none");
    $(".alerta").html("Por favor, completa todos los campos.");
    return;
  }

  const data = {
    razon_social: razon_social,
    tipo_rif: tipo_rif,
    rif: rif,
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
      $("#editarProveedor").html(`${respuesta.data["razon_social"]}`);
      $("#btnEditarProveedor").attr("data-id", `${respuesta.data["id"]}`);
      $("#editarRazonSocialProveedor").val(respuesta.data["razon_social"]);
      $("#editarTipoRif").val(respuesta.data["tipo_rif"]);
      $("#editarRif").val(respuesta.data["rif"]);
      $("#editarCodigoPaisProveedor").val(respuesta.data["codigo_pais"]);
      $("#editarTelefonoProveedor").val(respuesta.data["telefono"]);
      $("#editarCorreoProveedor").val(respuesta.data["correo"]);
      $("#editarDireccionProveedor").val(respuesta.data["direccion"]);
    },
  });
});

/*=============================================
EDITAR PROVEEDOR
=============================================*/

$("#formEditarProveedor").on("submit", function (e) {
  e.preventDefault();

  const idProveedor = $("#btnEditarProveedor").attr("data-id");
  const razon_social = $("#editarRazonSocialProveedor").val().trim();
  const tipo_rif = $("#editarTipoRif").val().trim();
  const rif = $("#editarRif").val();
  const direccion = $("#editarDireccionProveedor").val().trim();
  const codigo_pais = $("#editarCodigoPaisProveedor").val().trim();
  const telefono = $("#editarTelefonoProveedor").val().trim();
  const correo = $("#editarCorreoProveedor").val().trim();

  if (rif == "") {
    alert("El RIF proveedor es requerido");
    return;
  }

  const data = {
    id: idProveedor,
    razon_social: razon_social,
    tipo_rif: tipo_rif,
    rif: rif,
    direccion: direccion,
    codigo_pais: codigo_pais,
    telefono: telefono,
    correo: correo,
  };

  editarProveedor(JSON.stringify(data));
});

function editarProveedor(datos) {
  $.ajax({
    url: `http/proveedores.endpoint.php`,
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
        tablaProveedores.ajax.reload(null, true);
        $("#modalEditarProveedor").modal("hide");
      } else {
        Swal.fire({
          title: "Error al actualizar",
          icon: "error",
        });
        tablaProveedores.ajax.reload(null, true);
        $("#modalEditarProveedores").modal("hide");
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
        tablaProveedores.ajax.reload(null, true);
        $("#modalEditarProveedor").modal("hide");
      }
    },
  });
}

/*=============================================
REVISAR SI EL PROVEEDOR YA ESTÁ REGISTRADO
=============================================*/

$(".validarProveedor").on("input", function () {
  $(".alerta").addClass("d-none");

  var rif = $(this).val();

  $.ajax({
    url: `http/proveedores.endpoint.php?rif=${rif}`,
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
ELIMINAR PROVEEDOR
=============================================*/
tablaProveedores.on("click", "#btnEliminarProveedor", function () {
  let idProveedor = $(this).attr("data-id");

  Swal.fire({
    icon: "warning",
    title: "Advertencia",
    text: "¿Seguro que desea eliminar este Proveedor?. No podrá deshacer esta acción",
    showCancelButton: true,
    confirmButtonText: "Si, borrar",
    confirmButtonColor: "#D13415",
  }).then((result) => {
    if (result.isConfirmed) {
      eliminarProveedor(idProveedor);
    }
  });
});

function eliminarProveedor(id) {
  $.ajax({
    url: `http/proveedores.endpoint.php?id=${id}`,
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
        tablaProveedores.ajax.reload(null, true);
      }
    },
    error: function (respuesta) {
      Swal.fire({
        title: "Error al eliminar",
        icon: "error",
      });
      tablaProveedores.ajax.reload(null, true);
      $("#modalEditarProveedores").modal("hide");
    },
  });
}
