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
                <span class="fw-semibold">${producto.producto}</span>
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
                productosObtenidos += `
                  <tr>
                    <td>
                      <input type="checkbox" checked class="form-check-input check-producto-venta" id="productoNum-${i}" value="${producto.id}" />
                    </td>
                    <td class="text-start">${producto.nombre}</td>
                    <td class="w-25">
                      <div class="input-group">
                        <span class="input-group-text shadow-sm d-flex justify-content-center">${producto.unidad_medida}</span>
                        <input type="number" class="form-control shadow-sm cantidad-producto-venta" placeholder="0"/>
                      </div>
                    </td>
                    <td class="fs-4 text-end text-success fw-semibold precio-producto-venta">${producto.precio}</td>
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

            $(document).on("change", ".check-producto-venta", function (e) {
              e.preventDefault();
              let totalVenta = $("#totalVenta").val();
              let netoVenta = $("#totalNetoVenta").val();
              let precioProductoLista =
                listaProductosSeleccionados[$(this).val()].precio;

              if ($(this).not(":checked")) {
                let calcularNetoVenta =
                  parseFloat(netoVenta) - parseFloat(precioProductoLista);

                let calcularTotalVenta =
                  parseFloat(totalVenta) - parseFloat(calcularNetoVenta);

                $("#totalNetoVenta").val(calcularNetoVenta.toFixed(2));
                $("#totalVenta").val(
                  calcularTotalVenta <= 0
                    ? "0.00"
                    : calcularTotalVenta.toFixed(2)
                );
                delete listaProductosSeleccionados[$(this).val()];
                $(this).parent("td").parent("tr").empty();
              }
            });
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

$(document).on("input", ".cantidad-producto-venta", function () {
  let totalVenta = 0;

  // Itera sobre cada fila de la tabla de productos seleccionados
  $("#productosSeleccionados tr").each(function () {
    // Busca el input de cantidad dentro de la fila actual
    const cantidadInput = $(this).find(".cantidad-producto-venta");
    // Extrae la cantidad, convirtiéndola a un número
    const cantidad = parseFloat(cantidadInput.val()) || 0;

    // Busca el precio del producto dentro de la fila actual
    const precioTexto = $(this).find("td:last-child").text().trim();
    // Extrae el precio, eliminando el símbolo de '$' y convirtiéndolo a un número
    const precio = parseFloat(precioTexto.replace("$", "")) || 0;

    // Calcula el subtotal para este producto y lo suma al total general
    totalVenta += cantidad * precio;
  });

  // Puedes usar este valor para mostrarlo en un elemento de la página, por ejemplo:
  $("#totalNetoVenta").val(totalVenta.toFixed(2));
  $("#totalNetoVenta").removeClass("border-danger-subtle");
  $("#totalNetoVenta").addClass("border-success-subtle");
  $("#totalNetoVenta").trigger("change");
});

$("#totalNetoVenta").on("change", function () {
  let netoActual = $(this).val();
  let valorIVA = parseInt($("#ivaVenta").val()) / 100;

  let totalConImpuesto = parseFloat(netoActual) * valorIVA;
  let totalProcesar = parseFloat(netoActual) + totalConImpuesto;
  $("#totalVenta").removeClass("border-danger");
  $("#totalVenta").addClass("border-success");
  $("#totalVenta").val(totalProcesar.toFixed(2));
});

$("#buscadorConsultarProducto").on("input", function () {
  let query = $(this).val().trim();

  query != ""
    ? consultarProductos(query)
    : $("#seccionProductosConsultar").empty();
});

/*=============================================
  OBTENER CLIENTE
=============================================*/

function consultarClientes(query) {
  if (!query || query == "") {
    $("#resultadosClientes").empty();
  }
  $("#resultadosClientes").empty();

  $.ajax({
    type: "GET",
    url: `http/consultarClientes.endpoint.php?query=${query}`,
    dataType: "json",
    success: function (respuesta) {
      respuesta.data.map((cliente) => {
        const clientesHtml = $(`
          <li data-id-cliente="${cliente.id}" data-nombre-cliente="${cliente.nombres}" data-identificacion-cliente="${cliente.identificacion}" class="p-2 bg-white list-group-item list-group-item-action itemConsultarCliente">
            ${cliente.nombres} - ${cliente.tipo_identificacion}-${cliente.identificacion}
          </li>
        `);

        $("#resultadosClientes").removeClass("d-none");
        $("#resultadosClientes").append(clientesHtml);
      });

      // Asigna el evento de cambio al dar click en el cliente
      $(".itemConsultarCliente").click(function () {
        // Los datos del cliente se obtienen de los atributos
        const idCliente = $(this).attr("data-id-cliente");
        const nombreCliente = $(this).attr("data-nombre-cliente");
        const identificacionCliente = $(this).attr(
          "data-identificacion-cliente"
        );

        $("#idClienteSeleccionado").val(idCliente);
        $("#nombreClienteSeleccionado").val(nombreCliente);
        $("#identificacionClienteSeleccionado").val(identificacionCliente);

        $("#nombreClienteSeleccionado").removeClass("border-danger");
        $("#nombreClienteSeleccionado").addClass("border-success");

        $("#identificacionClienteSeleccionado").removeClass("border-danger");
        $("#identificacionClienteSeleccionado").addClass("border-success");

        $("#resultadosClientes").empty();
        $("#buscadorCliente").val("");
      });
    },
    error: function (error) {
      console.log(error.responseText);
      $("#resultadosClientes").empty();

      $("#resultadosClientes").append(
        `<li class="p-2">Sin resultados, <a href="#">Agregue un nuevo cliente</a></li>`
      );
    },
  });
}

$("#buscadorCliente").on("input", function () {
  let query = $(this).val().trim();

  query != "" ? consultarClientes(query) : $("#resultadosClientes").empty();
});

function verificarCamposRequeridos() {
  // Selecciona todos los inputs que tienen el atributo 'required'
  const camposRequeridos = $("input[required]");
  // Filtra los inputs para ver cuáles tienen un valor
  const camposConValor = camposRequeridos.filter(function () {
    return $(this).val().trim() !== "";
  });

  // Compara el número de inputs requeridos con los que tienen valor
  if (camposRequeridos.length === camposConValor.length) {
    // Si todos tienen valor, muestra una alerta
    $("#btnCrearVenta").removeAttr("disabled");
  } else {
    $("#btnCrearVenta").attr("disabled", "disabled");
  }
}

// Asocia la función al evento 'change' de todos los inputs requeridos
$(document).on("change", "input[required]", verificarCamposRequeridos);

$("#formCrearVenta").submit(function (e) {
  e.preventDefault();
  if ($("#totalVenta").val() == "0.00" || $("#totalVenta").val() == "") {
    return alert("El valor total no debe ser 0.00");
  }

  console.log(listaProductosSeleccionados);
  return alert("si");
});
