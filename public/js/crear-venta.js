var currentPath = window.location.pathname;

if (currentPath.endsWith("/crear-venta")) {
  $(document).ready(function () {
    // obtenerCategoriasProductos();
    // obtenerMarcasProductos();
  });
}

/*=============================================
  OBTENER CATEGORÍAS 
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
      if (respuesta.success === true) {
        respuesta.data.map((producto) => {
          // Crea un objeto jQuery para el HTML del producto
          const productoHtml = $(`
            <label class="contenedor-lista-producto">
              <input class="form-check-input flex-shrink-0" type="checkbox" value="${producto.id}">
              <span>
                ${producto.producto}
                <small class="d-block text-body-secondary">${producto.descripcion}</small>
              </span>
              <strong>${producto.precio_venta}$</strong>
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

            let dataProducto = {
              id: idProducto,
              nombre: nombreProducto,
              descripcion: descripcionProducto,
            };

            if ($(this).is(":checked")) {
              // Si se marca, agrega el producto al objeto
              listaProductosSeleccionados[idProducto] = dataProducto;

              // Agregar a la lista en la pantalla
              listaProductosSeleccionados.map((producto, i) => {
                productosObtenidos += `
                  <div>
                    <h5>${producto.nombre}</h5>
                  </div>
                `;
              });

              $("#productosSeleccionados").empty();
              setTimeout(() => {
                $("#productosSeleccionados").append(productosObtenidos);
              }, 100);

              // Vacía el contenedor como se había solicitado
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

$("#buscadorConsultarProducto").on("input", function () {
  let query = $(this).val().trim();

  query != "" ? consultarProductos(query) : console.log("vacio");
});
