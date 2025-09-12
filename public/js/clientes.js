/*=============================================
  INICIALIZAR EL PLUGIN DE TELÉFONO
=============================================*/
var currentPath = window.location.pathname;

if (currentPath.endsWith("/clientes")) {
  $("input[type=tel]").each(function () {
    window.intlTelInput(this, {
      initialCountry: "ve",
      showSelectDialCode: true,
    });
  });
}

/*=============================================
OBTENER CLIENTES
=============================================*/

var tablaClientes = $("#tablaClientes").DataTable({
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
    url: "http/clientes.endpoint.php",
    type: "GET",
    dataType: "json",
    dataSrc: "data",
  },
  columns: [
    { data: "nombres" },
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
        const botonEditar = `<button class="btn btn-warning btn-sm" id="btnModalEditarCliente" data-bs-toggle="modal" data-bs-target="#modalEditarCliente" data-id="${data}"><i class="fa-solid fa-pen-to-square"></i></button>`;

        const botonEliminar = `<button class="btn btn-danger btn-sm" id="btnEliminarCliente" data-id="${data}"><i class="fa-solid fa-trash-can"></i></button>`;

        return `${botonEditar} ${botonEliminar}`;
      },
    },
  ],
  responsive: true,
  deferRender: true,
});

/*=============================================
CREAR CLIENTE
=============================================*/



$("#formCrearCliente input[required]").on("input", function () {
  let allFilled = true;

  $("#formCrearCliente input[required]").each(function () {
    if ($(this).val().trim() === "") {
      allFilled = false;
      return false; // Salir del bucle each
    }
  });

  if (allFilled) {
    $("#btnRegistrarCliente").removeAttr("disabled");
  } else {
    $("#btnRegistrarCliente").attr("disabled", "disabled");
  }
});

$("#formCrearCliente").on("submit", function (e) {
  e.preventDefault();

  const nombres = $("#nuevoNombresCliente").val().trim();
  const tipo_identificacion = $("#nuevoTipoIdentificacion").val().trim();
  const identificacion = $("#nuevoIdentificacion").val();
  const direccion = $("#nuevoDireccion").val().trim();
  const codigo_pais = $("#nuevoCodigoPais").val().trim();
  const telefono = $("#nuevoTelefono").val().trim();
  const correo = $("#nuevoCorreo").val().trim();

  if (
    nombres == "" ||
    tipo_identificacion == "" ||
    identificacion == "" ||
    codigo_pais == "" ||
    telefono == "" ||
    correo == "" ||
    direccion == ""

  ) {
    $(".alerta").removeClass("d-none");
    $(".alerta").html("Por favor, completa todos los campos.");
    return;
  }

  const data = {
    nombres: nombres,
    tipo_identificacion: tipo_identificacion,
    identificacion: identificacion,
    direccion: direccion,
    codigo_pais: codigo_pais,
    telefono: telefono,
    correo: correo,
  };

  registrarCliente(JSON.stringify(data));
});

function registrarCliente(datos) {
  $.ajax({
    url: "http/clientes.endpoint.php",
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
function vaciarCampos() {
    $('#nuevoNombresCliente').val('');
    $('#nuevoTipoIdentificacion').val('V');
    $('#nuevoIdentificacion').val('');
    $('#nuevoTelefono').val('');
    $('#nuevoCorreo').val('');
    $('#nuevoDireccion').prop('disabled', false).prop('readonly', false).val('');
}
vaciarCampos();

tablaClientes.ajax.reload(null, true);
        
        
      } else {
        // Mensaje de registro si ocurre un error
        Swal.fire({
          title: "Error al registrar",
          text: respuesta.message,
          icon: "error",
        });
        tablaClientes.ajax.reload(null, true);
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
        tablaClientes.ajax.reload(null, true);
      }
    },
  });
}



/*=============================================
OBTENER DATO DEL CLIENTE A EDITAR
=============================================*/
tablaClientes.on("click", "#btnModalEditarCliente", function () {
  let idCliente = $(this).attr("data-id");

  $.ajax({
    url: `http/clientes.endpoint.php?id=${idCliente}`,
    method: "GET",
    cache: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      $("#editarCliente").html(
        `${respuesta.data["razon_social"] || respuesta.data["nombres"]}`
      );
      $("#btnEditarCliente").attr("data-id", `${respuesta.data["id"]}`);
      $("#editarNombresCliente").val(respuesta.data["nombres"]);
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
EDITAR CLIENTE
=============================================*/

$("#formEditarCliente").on("submit", function (e) {
  e.preventDefault();

  const idCliente = $("#btnEditarCliente").attr("data-id");
  const nombres = $("#editarNombresCliente").val().trim();
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
    id: idCliente,
    nombres: nombres,
    tipo_identificacion: tipo_identificacion,
    identificacion: identificacion,
    direccion: direccion,
    codigo_pais: codigo_pais,
    telefono: telefono,
    correo: correo,
  };

  editarCliente(JSON.stringify(data));
});

function editarCliente(datos) {
  $.ajax({
    url: `http/clientes.endpoint.php`,
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
        tablaClientes.ajax.reload(null, true);
        $("#modalEditarCliente").modal("hide");
      } else {
        Swal.fire({
          title: "Error al actualizar",
          icon: "error",
        });
        tablaClientes.ajax.reload(null, true);
        $("#modalEditarCliente").modal("hide");
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
        tablaClientes.ajax.reload(null, true);
        $("#modalEditarCliente").modal("hide");
      }
    },
  });
}

/*=============================================
REVISAR SI EL CLIENTE YA ESTÁ REGISTRADO
=============================================*/

$(".validarCliente").on("input", function () {
  $(".alerta").addClass("d-none");

  var identificacion = $(this).val();

  $.ajax({
    url: `http/clientes.endpoint.php?identificacion=${identificacion}`,
    method: "GET",
    cache: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      if (respuesta.success == true) {
        $(".alerta").removeClass("d-none");
        $(".alerta").html(
          "<i class='fa-solid fa-triangle-exclamation'></i> Ya existe un cliente registrado con esta identificación"
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
tablaClientes.on("click", "#btnEliminarCliente", function () {
  let idCliente = $(this).attr("data-id");

  Swal.fire({
    icon: "warning",
    title: "Advertencia",
    text: "¿Seguro que desea eliminar este Cliente?. No podrá deshacer esta acción",
    showCancelButton: true,
    confirmButtonText: "Si, borrar",
    confirmButtonColor: "#D13415",
  }).then((result) => {
    if (result.isConfirmed) {
      eliminarCliente(idCliente);
    }
  });
});

function eliminarCliente(id) {
  $.ajax({
    url: `http/clientes.endpoint.php?id=${id}`,
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
        tablaClientes.ajax.reload(null, true);
      }
    },
    error: function (respuesta) {
      Swal.fire({
        title: "Error al eliminar",
        icon: "error",
      });
      tablaClientes.ajax.reload(null, true);
      $("#modalEditarCliente").modal("hide");
    },
  });
}

