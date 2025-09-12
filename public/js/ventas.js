/*=============================================
OBTENER CLIENTES
=============================================*/

var tablaClientes = $("#tablaReportesVentas").DataTable({
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
    url: "http/ventas.endpoint.php",
    type: "GET",
    dataType: "json",
    dataSrc: "data",
  },
  columns: [
    { data: "codigo_recibo" },
    { data: "tipo_identificacion" },
    { data: "identificacion" },
    { data: "nombres_cliente" },
    { data: "valor_neto" },
    { data: "impuesto" },
    { data: "valor_total" },
    { data: "nombre_usuario" },
    { data: "apellido_usuario" },
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
      data: "codigo_recibo",
      render: function (data, type, row) {
        const botonImprimirReporteVenta = `<a href="recibo?codigo=${data}" target="_blank" class="btn btn-danger btn-sm" id="btnImprimirReporteVenta" data-id="${data}"><i class="fa-solid fa-file-invoice"></i></a>`;

        return `${botonImprimirReporteVenta}`;
      },
    },
  ],
  responsive: true,
  deferRender: true,
});
