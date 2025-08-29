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

function consultarProductos(query) {
  let productosObtenidos = "";

  $.ajax({
    url: `http/consultarProductos.endpoint.php?query=${query}`,
    type: "GET",
    dataType: "json",
    success: function (respuesta) {
      $("#seccionProductosConsultar").empty();
      if (respuesta.success === true) {
        console.log(respuesta);

        respuesta.data.map((producto) => {
          productosObtenidos += `
            <div>${producto.producto}</div>
          `;
        });
        $("#seccionProductosConsultar").append(productosObtenidos);
      }
    },
  });
}

$("#buscadorConsultarProducto").on("input", function () {
  let query = $(this).val().trim();

  query != "" ? consultarProductos(query) : console.log("vacio");
});
