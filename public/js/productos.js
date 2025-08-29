var currentPath = window.location.pathname;

if (currentPath.endsWith("/productos")) {
  $(document).ready(function () {
    obtenerCategoriasProductos();
    obtenerMarcasProductos();
  });
}

/*=============================================
  OBTENER CATEGORÍAS 
=============================================*/

function obtenerCategoriasProductos() {
  $.ajax({
    url: "http/categorias.endpoint.php",
    type: "GET",
    dataType: "json",
    success: function (respuesta) {
      if (respuesta.success === true) {
        let mostrarCategorias =
          "<option value='' selected>Seleccionar Categoría</option>";

        $(".selectMostrarCategorias").empty();

        respuesta.data.forEach((categoria) => {
          mostrarCategorias += `
            <option value="${categoria.id}">${categoria.nombre_categoria}</option>
          `;
        });

        $(".selectMostrarCategorias").append(mostrarCategorias);
      } else {
        swal.fire({
          title: "Error al registrar",
          icon: "error",
          draggable: true,
        });
      }
    },
  });
}

/*=============================================
  OBTENER MARCAS 
=============================================*/

function obtenerMarcasProductos() {
  $.ajax({
    url: "http/marcas.endpoint.php",
    type: "GET",
    dataType: "json",
    success: function (respuesta) {
      if (respuesta.success === true) {
        let mostrarMarcas =
          "<option value='' selected>Seleccionar Marca</option>";

        $(".selectMostrarMarcas").empty();

        respuesta.data.forEach((marca) => {
          mostrarMarcas += `
            <option value="${marca.id}">${marca.nombre_marca}</option>
          `;
        });

        $(".selectMostrarMarcas").append(mostrarMarcas);
      } else {
        swal.fire({
          title: "Error al registrar",
          icon: "error",
          draggable: true,
        });
      }
    },
  });
}

/*=============================================
  CREAR CATEGORÍAS 
=============================================*/

$("#formCrearCategoriaProducto").on("submit", function (e) {
  e.preventDefault();

  const categoria = $("#nuevoCategoriaProducto").val().trim();
  const descripcion = $("#nuevaDescripcionProducto").val().trim();

  const data = {
    nombre_categoria: categoria,
    descripcion: descripcion,
  };

  registrarCategoriasProductos(JSON.stringify(data));
});

function registrarCategoriasProductos(datos) {
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
        $("#modalAgregarCategoria").modal("hide");
        obtenerCategoriasProductos();
      } else {
        // Mensaje de registro si ocurre un error
        Swal.fire({
          title: "Error al registrar categoría",
          icon: "error",
        });
        $("#modalAgregarCategoria").modal("hide");
        obtenerCategoriasProductos();
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
      $("#modalAgregarCategoria").modal("hide");
    },
  });
}

/*=============================================
  CREAR MARCA
=============================================*/

$("#formCrearMarcaProducto").on("submit", function (e) {
  e.preventDefault();

  const marca = $("#nuevoMarcaProducto").val().trim();

  const data = {
    nombre_marca: marca,
  };

  registrarMarcasProductos(JSON.stringify(data));
});

function registrarMarcasProductos(datos) {
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
        $("#modalAgregarMarca").modal("hide");
        obtenerMarcasProductos();
      } else {
        // Mensaje de registro si ocurre un error
        Swal.fire({
          title: "Error al registrar categoría",
          icon: "error",
        });
        $("#modalAgregarMarca").modal("hide");
        obtenerMarcasProductos();
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
      $("#modalAgregarMarca").modal("hide");
    },
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
    url: "http/productos.endpoint.php",
    type: "GET",
    dataType: "json",
    dataSrc: "data",
  },
  columns: [
    // { data: "estado" },
    {
      data: "estado",
      render: function (data, type, row) {
        const botonEstado = `<button class="btn ${
          data == "Disponible" ? "btn-success" : "btn-danger"
        } btn-sm">${data}</button>`;

        return `${botonEstado}`;
      },
    },
    { data: "nombre" },
    { data: "categoria" },
    { data: "marca" },
    { data: "stock" },
    { data: "unidad_medida" },
    { data: "precio_compra" },
    { data: "precio_venta" },
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

  const nombre = $("#nuevoNombreProducto").val().trim();
  const id_categoria = $("#nuevoIdCategoria").val().trim();
  const id_marca = $("#nuevoIdMarca").val().trim();
  const descripcion = $("#nuevoDescripcionProducto").val().trim();
  const unidad_medida = $("#nuevoUnidadMedida").val().trim();
  const stock = $("#nuevoStock").val().trim();
  const precio_compra = $("#nuevoPrecioCompra").val().trim();
  const precio_venta = $("#nuevoPrecioVenta").val().trim();
  const estado = $("#nuevoStock").val().trim() > 1 ? "Disponible" : "Agotado";

  if (
    nombre == "" ||
    id_categoria == "" ||
    id_marca == "" ||
    descripcion == "" ||
    unidad_medida == "" ||
    stock == "" ||
    precio_compra == "" ||
    precio_venta == ""
  ) {
    $(".alerta").removeClass("d-none");
    $(".alerta").html("Por favor, completa todos los campos.");
    return;
  }

  if (stock < 0) {
    $(".alerta").removeClass("d-none");
    $(".alerta").html("La cantidad no puede ser menor a 0.");
    return;
  }

  const data = {
    nombre: nombre,
    id_categoria: id_categoria,
    id_marca: id_marca,
    descripcion: descripcion,
    unidad_medida: unidad_medida,
    stock: stock,
    precio_compra: precio_compra,
    precio_venta: precio_venta,
    estado: estado,
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
  let idProducto = $(this).attr("data-id");

  $.ajax({
    url: `http/productos.endpoint.php?id=${idProducto}`,
    method: "GET",
    cache: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      $("#editarProducto").html(`${respuesta.data["nombre"]}`);
      $("#btnEditarProducto").attr("data-id", `${respuesta.data["id"]}`);
      $("#editarNombreProducto").val(respuesta.data["nombre"]);
      $("#editarIdCategoria").val(respuesta.data["id_categoria"]);
      $("#editarIdMarca").val(respuesta.data["id_marca"]);
      $("#editarDescripcionProducto").val(respuesta.data["descripcion"]);
      $("#editarUnidadMedida").val(respuesta.data["unidad_medida"]);
      $("#editarStock").val(respuesta.data["stock"]);
      $("#editarPrecioCompra").val(respuesta.data["precio_compra"]);
      $("#editarPrecioVenta").val(respuesta.data["precio_venta"]);
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
        text: "Contacte con un administrador",
        icon: "error",
      });
      tablaProductos.ajax.reload(null, true);
      $("#modalEditarProducto").modal("hide");
    },
  });
}
