<?php

  if(!isset($_SESSION["logged"])) {

    return header("Location: login");
  } 


?>

<div class="content-wrapper px-2 py-3 pb-5 text-bg-light contenedor-principal">

  <nav aria-label="breadcrumb">

    <ol class="breadcrumb">

      <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>

      <li class="breadcrumb-item active" aria-current="page">Ventas</li>

    </ol>

  </nav>

  <!--=============================================
  SECCIÓN DEL TITULO DEL MÓDULO
  =============================================-->

  <section class="content-header bg-dark py-2 px-3 rounded mb-3 shadow-lg">

    <h4 class="text-light">Reportes de</h4>

    <hr class="border border-2 border-warning mt-0">

    <h3 class="text-warning fw-bold">VENTAS</h3>

  </section>

  <a href="crear-venta" class="btn btn-warning shadow px-5 py-3" type="button">
    <i class="fa-solid fa-cash-register"></i> Generar Venta <i class="fa-solid fa-money-check-dollar"></i>
  </a>

  <!--=============================================
  SECCION PARA CONSULTAR VENTAS
  =============================================-->

  <section class="content py-3">

    <div class="container-fluid">

      <h4>Todas las ventas</h4>

      <div class="table-responsive p-2 rounded shadow-lg">

        <table class="table table-sm table-bordered table-striped table-light table-hover align-middle" id="tablaReportesVentas" width="100%">         

          <thead>         

            <tr class="table-dark">           

              <th>Número de Nota de entrega</th>
              <th>Nac.</th>
              <th>Núm. Documento</th>
              <th>Nombres Cliente</th>
              <th>Total neto $</th>
              <th>Impuesto %</th>
              <th>Total $</th>
              <th>Nombre del Usuario</th>
              <th>Apellido del Usuario</th>
              <th>Fecha creación</th>
              <th>Acciones</th>

            </tr> 

          </thead>

          <tbody></tbody>

        </table>

      </div>

    </div>

  </section>

</div>
