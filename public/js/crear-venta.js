var currentPath = window.location.pathname;

if (currentPath.endsWith("/crear-venta")) {
  $(document).ready(function () {
    // obtenerCategoriasProductos();
    // obtenerMarcasProductos();
  });
}

/*=============================================
  OBTENER PRODUCTOS
=============================================*/

let listaProductosSeleccionados = [];
function consultarProductos(query) {
  let productosObtenidos = "";

  $.ajax({
    url: `http/consultarProductos.endpoint.php?query=${query}`,
    type: "GET",
    dataType: "json",
    success: function (respuesta) {
      $("#seccionProductosConsultar").empty();
      $("#seccionProductosConsultar").addClass("d-block");
      $("#seccionProductosConsultar").removeClass("d-none");
      if (respuesta.success === true) {
        respuesta.data.map((producto) => {
          // Crea un objeto jQuery para el HTML del producto
          const productoHtml = $(`
            <label class="contenedor-lista-producto">
              <input class="form-check-input flex-shrink-0 shadow-sm" type="checkbox" value="${producto.id}">
              <div class="info-producto-consultado">
                <span class="fw-semibold fs-4">${producto.producto}</span>
                <div>Stock: <b>${producto.stock}</b> <i>${producto.unidad_medida}</i></div>
                <small class="d-block text-body-secondary">${producto.descripcion}</small>
              </div>
              <strong class="fs-3">${producto.precio_venta}$</strong>
            </label>
          `);

          // Asigna el evento de cambio al input del checkbox
          productoHtml.find('input[type="checkbox"]').on("change", function () {
            // El ID del producto se obtiene del valor del checkbox
            const idProducto = $(this).val();
            // El nombre del producto se obtiene del span
            const nombreProducto = $(this)
              .closest("label")
              .find("span")
              .text()
              .trim();
            // La descripcion del producto se obtiene del small
            const descripcionProducto = $(this)
              .closest("label")
              .find("small")
              .text()
              .trim();
            // El precio del producto se obtiene del strong
            const precioProducto = $(this)
              .closest("label")
              .find("strong")
              .text()
              .trim();
            // El Stock del producto se obtiene del <b>
            const stockProducto = $(this)
              .closest("label")
              .find("b")
              .text()
              .trim();
            // La unidad de medida del producto se obtiene del i
            const medidaProducto = $(this)
              .closest("label")
              .find("i")
              .text()
              .trim();

            let dataProducto = {
              id: idProducto,
              nombre: nombreProducto,
              descripcion: descripcionProducto,
              precio: precioProducto,
              stock: stockProducto,
              unidad_medida: medidaProducto,
            };

            if ($(this).is(":checked")) {
              // Si se marca, agrega el producto al objeto
              listaProductosSeleccionados[idProducto] = dataProducto;

              // Agregar a la lista en la pantalla
              listaProductosSeleccionados.map((producto, i) => {
                console.log(producto);
                productosObtenidos += `
                  <tr>
                    <td>
                      <input type="checkbox" checked class="form-check-input check-producto-venta" id="productoNum-${i}" value="${producto.id}" />
                    </td>
                    <td class="fs-5">${producto.nombre}</td>
                    <td class="d-flex align-items-center gap-1">
                      <input type="number" class="form-control w-25 cantidad-producto-venta" placeholder="0"/> ${producto.unidad_medida}
                    </td>
                    <td class="fs-4 text-end fw-semibold">${producto.precio}</td>
                  </tr>
                `;
              });

              $("#productosSeleccionados").empty();
              setTimeout(() => {
                $("#productosSeleccionados").append(productosObtenidos);
              }, 100);

              // Vacíar el contenedor
              $("#seccionProductosConsultar").empty();
              $("#buscadorConsultarProducto").val("");
            } else {
              // Si se desmarca, elimina el producto del objeto
              delete listaProductosSeleccionados[idProducto];
              $("#buscadorConsultarProducto").val("");
            }

            console.log(listaProductosSeleccionados); // Muestra el objeto actualizado en la consola
          });

          // Añade el elemento al contenedor principal
          $("#seccionProductosConsultar").append(productoHtml);
        });
      }
    },
    error: function () {
      $("#seccionProductosConsultar").empty();
    },
  });
}

// $(".check-producto-venta").each(function () {
$(".check-producto-venta").on("change", function () {
  alert("aasd");
  // if ($(this).not(":checked")) {
  //   $(this).addClass("d-none");
  // }
});
// });

$("#buscadorConsultarProducto").on("input", function () {
  let query = $(this).val().trim();

  query != "" ? consultarProductos(query) : console.log("vacio");
});

/*=============================================
  OBTENER CLIENTE
=============================================*/

function consultarClientes(query) {
  let listaClientes = "";
  $("#resultadosClientes").empty();

  $.ajax({
    type: "GET",
    url: `http/consultarClientes.endpoint.php?query=${query}`,
    dataType: "json",
    success: function (respuesta) {
      console.log(respuesta.data);

      respuesta.data.map((cliente) => {
        listaClientes += `
          <li class="p-2 list-group-item list-group-item-action">${cliente.nombres} | ${cliente.tipo_identificacion}-${cliente.identificacion}</li>
        `;
      });

      $("#resultadosClientes").append(listaClientes);
    },
    error: function (error) {
      console.log(error.responseText);
      $("#resultadosClientes").empty();

      $("#resultadosClientes").append(
        `<li>Sin resultados, <a href="#">Agregué uno</a></li>`
      );
    },
  });
}

$("#buscadorCliente").on("input", function () {
  let query = $(this).val().trim();

  query != "" ? consultarClientes(query) : console.log("vacio");
});
