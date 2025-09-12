/*=============================================
OBTENER MARCAS
=============================================*/

var tablaMarcas = $("#tablaMarcas").DataTable({
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
    url: "http/marcas.endpoint.php",
    type: "GET",
    dataType: "json",
    dataSrc: "data",
  },
  columns: [
    { data: "nombre_marca" },
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
        const botonEditar = `<button class="btn btn-warning btn-sm" id="btnModalEditarMarca" data-bs-toggle="modal" data-bs-target="#modalEditarMarca" data-id="${data}"><i class="fa-solid fa-pen-to-square"></i></button>`;

        const botonEliminar = `<button class="btn btn-danger btn-sm" id="btnEliminarMarca" data-id="${data}"><i class="fa-solid fa-trash-can"></i></button>`;

        return `${botonEditar} ${botonEliminar}`;
      },
    },
  ],
  responsive: true,
  deferRender: true,
});

/*=============================================
CREAR MARCA
=============================================*/

$("#formCrearMarca input[required]").on("input", function () {
  let allFilled = true;

  $("#formCrearMarca input[required]").each(function () {
    if ($(this).val().trim() === "") {
      allFilled = false;
      return false; // Salir del bucle each
    }
  });

  if (allFilled) {
    $("#btnRegistrarMarca").removeAttr("disabled");
  } else {
    $("#btnRegistrarMarca").attr("disabled", "disabled");
  }
});

$("#formCrearMarca").on("submit", function (e) {
  e.preventDefault();

  const nombre_marca = $("#nuevoNombreMarca").val().trim();

  if (nombre_marca == "") {
    $(".alerta").removeClass("d-none");
    $(".alerta").html("Por favor, completa todos los campos.");
    return;
  }

  const data = {
    nombre_marca: nombre_marca,
  };

  registrarMarca(JSON.stringify(data));
});

function registrarMarca(datos) {
  $.ajax({
    url: "http/marcas.endpoint.php",
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
                // Vaciar los campos del formulario
        $("#formCrearMarca")[0].reset();
        tablaMarcas.ajax.reload(null, true);
      } else {
        // Mensaje de registro si ocurre un error
        Swal.fire({
          title: "Error al registrar",
          text: respuesta.message,
          icon: "error",
          contentType: "application/json",
        });
        tablaMarcas.ajax.reload(null, true);
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
        tablaMarcas.ajax.reload(null, true);
      }
    },
  });
}

/*=============================================
OBTENER DATO DEL MARCA A EDITAR
=============================================*/
tablaMarcas.on("click", "#btnModalEditarMarca", function () {
  let idMarca = $(this).attr("data-id");

  $.ajax({
    url: `http/marcas.endpoint.php?id=${idMarca}`,
    method: "GET",
    cache: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      $("#editarMarca").html(`${respuesta.data["nombre_marca"]}`);
      $("#btnEditarMarca").attr("data-id", `${respuesta.data["id"]}`);
      $("#editarNombreMarca").val(respuesta.data["nombre_marca"]);
    },
  });
});

/*=============================================
EDITAR MARCA
=============================================*/

$("#formEditarMarca").on("submit", function (e) {
  e.preventDefault();

  const idMarca = $("#btnEditarMarca").attr("data-id");
  const nombre_marca = $("#editarNombreMarca").val();

  if (nombre_marca == "") {
    alert("El nombre de la Marca no puede quedar vacio");
    return;
  }

  const data = {
    id: idMarca,
    nombre_marca: nombre_marca,
  };

  editarMarca(JSON.stringify(data));
});

function editarMarca(datos) {
  $.ajax({
    url: `http/marcas.endpoint.php`,
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
        tablaMarcas.ajax.reload(null, true);
        $("#modalEditarMarca").modal("hide");
      } else {
        Swal.fire({
          title: "Error al actualizar",
          icon: "error",
        });
        tablaMarcas.ajax.reload(null, true);
        $("#modalEditarMarca").modal("hide");
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
        tablaMarcas.ajax.reload(null, true);
        $("#modalEditarMarca").modal("hide");
      }
    },
  });
}

/*=============================================
REVISAR SI EL MARCA YA ESTÁ REGISTRADO
=============================================*/

$(".validarMarca").on("input", function () {
  $(".alerta").addClass("d-none");

  var nombre_marca = $(this).val();

  $.ajax({
    url: `http/marcas.endpoint.php?nombre_marca=${nombre_marca}`,
    method: "GET",
    cache: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      if (respuesta.success == true) {
        $(".alerta").removeClass("d-none");
        $(".alerta").html(
          "<i class='fa-solid fa-triangle-exclamation'></i> Ya existe esta Marca"
        );
      } else {
        $(".alerta").addClass("d-none");
      }
    },
  });
});

/*=============================================
ELIMINAR MARCA
=============================================*/
tablaMarcas.on("click", "#btnEliminarMarca", function () {
  let idMarca = $(this).attr("data-id");

  Swal.fire({
    icon: "warning",
    title: "Advertencia",
    text: "¿Seguro que desea eliminar este Marca?. No podrá deshacer esta acción",
    showCancelButton: true,
    confirmButtonText: "Si, borrar",
    confirmButtonColor: "#D13415",
  }).then((result) => {
    if (result.isConfirmed) {
      eliminarMarca(idMarca);
    }
  });
});

function eliminarMarca(id) {
  $.ajax({
    url: `http/marcas.endpoint.php?id=${id}`,
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
        tablaMarcas.ajax.reload(null, true);
      }
    },
    error: function (respuesta) {
      Swal.fire({
        title: "Error al eliminar",
        icon: "error",
      });
      tablaMarcas.ajax.reload(null, true);
      $("#modalEditarMarca").modal("hide");
    },
  });
}
