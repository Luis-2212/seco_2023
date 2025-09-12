/*=============================================
OBTENER Categorias
=============================================*/

var tablaCategorias = $("#tablaCategorias").DataTable({
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
    url: "http/categorias.endpoint.php",
    type: "GET",
    dataType: "json",
    dataSrc: "data",
  },
  columns: [
    { data: "nombre_categoria" },
    { data: "descripcion" },
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
        const botonEditar = `<button class="btn btn-warning btn-sm" id="btnModalEditarCategoria" data-bs-toggle="modal" data-bs-target="#modalEditarCategoria" data-id="${data}"><i class="fa-solid fa-pen-to-square"></i></button>`;

        const botonEliminar = `<button class="btn btn-danger btn-sm" id="btnEliminarCategoria" data-id="${data}"><i class="fa-solid fa-trash-can"></i></button>`;

        return `${botonEditar} ${botonEliminar}`;
      },
    },
  ],
  responsive: true,
  deferRender: true,
});

/*=============================================
CREAR Categoria
=============================================*/

$("#formCrearCategoria input[required]").on("input", function () {
  let allFilled = true;

  $("#formCrearCategoria input[required]").each(function () {
    if ($(this).val().trim() === "") {
      allFilled = false;
      return false; // Salir del bucle each
    }
  });

  if (allFilled) {
    $("#btnRegistrarCategoria").removeAttr("disabled");
  } else {
    $("#btnRegistrarCategoria").attr("disabled", "disabled");
  }
});

$("#formCrearCategoria").on("submit", function (e) {
  e.preventDefault();

  const nombre_categoria = $("#nuevoNombreCategoria").val().trim();
  const descripcion = $("#nuevaDescripcionCategoria").val().trim();

  if (nombre_categoria == "" || descripcion == "") {
    $(".alerta").removeClass("d-none");
    $(".alerta").html("Por favor, completa todos los campos.");
    return;
  }

  const data = {
    nombre_categoria: nombre_categoria,
    descripcion: descripcion,
  };

  registrarCategoria(JSON.stringify(data));
});

function registrarCategoria(datos) {
  $.ajax({
    url: "http/categorias.endpoint.php",
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
        $("#formCrearCategoria")[0].reset();
        tablaCategorias.ajax.reload(null, true);
      } else {
        // Mensaje de registro si ocurre un error
        Swal.fire({
          title: "Error al registrar",
          text: respuesta.message,
          icon: "error",
          contentType: "application/json",
        });
        tablaCategorias.ajax.reload(null, true);
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
        tablaCategorias.ajax.reload(null, true);
      }
    },
  });
}

/*=============================================
OBTENER DATO DEL Categoria A EDITAR
=============================================*/
tablaCategorias.on("click", "#btnModalEditarCategoria", function () {
  let idCategoria = $(this).attr("data-id");

  $.ajax({
    url: `http/categorias.endpoint.php?id=${idCategoria}`,
    method: "GET",
    cache: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      $("#editarCategoria").html(`${respuesta.data["nombre_categoria"]}`);
      $("#btnEditarCategoria").attr("data-id", `${respuesta.data["id"]}`);
      $("#editarNombreCategoria").val(respuesta.data["nombre_categoria"]);
      $("#editarDescripcionCategoria").val(respuesta.data["descripcion"]);
    },
  });
});

/*=============================================
EDITAR Categoria
=============================================*/

$("#formEditarCategoria").on("submit", function (e) {
  e.preventDefault();

  const idCategoria = $("#btnEditarCategoria").attr("data-id");
  const nombre_categoria = $("#editarNombreCategoria").val();
  const descripcion = $("#editarDescripcionCategoria").val().trim();

  if (nombre_categoria == "") {
    alert("El nombre de la categoria no puede quedar vacio");
    return;
  }

  const data = {
    id: idCategoria,
    nombre_categoria: nombre_categoria,
    descripcion: descripcion,
  };

  editarCategoria(JSON.stringify(data));
});

function editarCategoria(datos) {
  $.ajax({
    url: `http/categorias.endpoint.php`,
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
        tablaCategorias.ajax.reload(null, true);
        $("#modalEditarCategoria").modal("hide");
      } else {
        Swal.fire({
          title: "Error al actualizar",
          icon: "error",
        });
        tablaCategorias.ajax.reload(null, true);
        $("#modalEditarCategoria").modal("hide");
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
        tablaCategorias.ajax.reload(null, true);
        $("#modalEditarCategoria").modal("hide");
      }
    },
  });
}

/*=============================================
REVISAR SI EL Categoria YA ESTÁ REGISTRADO
=============================================*/

$(".validarCategoria").on("input", function () {
  $(".alerta").addClass("d-none");

  var nombre_categoria = $(this).val();

  $.ajax({
    url: `http/categorias.endpoint.php?nombre_categoria=${nombre_categoria}`,
    method: "GET",
    cache: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      if (respuesta.success == true) {
        $(".alerta").removeClass("d-none");
        $(".alerta").html(
          "<i class='fa-solid fa-triangle-exclamation'></i> Ya existe esta categoria"
        );
      } else {
        $(".alerta").addClass("d-none");
      }
    },
  });
});

/*=============================================
ELIMINAR Categoria
=============================================*/
tablaCategorias.on("click", "#btnEliminarCategoria", function () {
  let idCategoria = $(this).attr("data-id");

  Swal.fire({
    icon: "warning",
    title: "Advertencia",
    text: "¿Seguro que desea eliminar este Categoria?. No podrá deshacer esta acción",
    showCancelButton: true,
    confirmButtonText: "Si, borrar",
    confirmButtonColor: "#D13415",
  }).then((result) => {
    if (result.isConfirmed) {
      eliminarCategoria(idCategoria);
    }
  });
});

function eliminarCategoria(id) {
  $.ajax({
    url: `http/categorias.endpoint.php?id=${id}`,
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
        tablaCategorias.ajax.reload(null, true);
      }
    },
    error: function (respuesta) {
      Swal.fire({
        title: "Error al eliminar",
        icon: "error",
      });
      tablaCategorias.ajax.reload(null, true);
      $("#modalEditarCategoria").modal("hide");
    },
  });
}
