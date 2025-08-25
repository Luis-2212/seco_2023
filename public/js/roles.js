$(document).ready(function () {
  obtenerRoles();
});

/*=============================================
OBTENER ROLES
=============================================*/

function obtenerRoles() {
  $.ajax({
    url: "http/roles.endpoint.php",
    method: "GET",
    dataType: "json",
    cache: false,
    contentType: "Application/json",
    success: function (respuesta) {
      if (respuesta.success === true) {
        let mostrarRoles =
          "<option value='' selected>Seleccionar Cargo</option>";

        $(".selectMostrarRoles").empty();

        respuesta.data.forEach((rol) => {
          mostrarRoles += `
            <option value="${rol.id}">${rol.rol}</option>
          `;
        });

        $(".selectMostrarRoles").append(mostrarRoles);
      } else {
        swal.fire({
          title: "Error al registrar",
          icon: "error",
          draggable: true,
        });
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.error(
        "Error en la solicitud:",
        jqXHR.responseJSON,
        textStatus,
        errorThrown
      );
    },
  });
}

/*=============================================
CREAR ROL
=============================================*/

$("#formCrearRol").on("submit", function (e) {
  e.preventDefault();

  const rol = $("#nuevoRol").val().trim();
  const descripcion = $("#nuevaDescripcion").val().trim();

  const data = {
    rol: rol,
    descripcion: descripcion,
  };

  registrarRol(JSON.stringify(data));
});

function registrarRol(datos) {
  $.ajax({
    url: "http/roles.endpoint.php",
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
        $("#modalAgregarRol").modal("hide");
        obtenerRoles();
      } else {
        // Mensaje de registro si ocurre un error
        Swal.fire({
          title: "Error al registrar cargo",
          icon: "error",
        });
        $("#modalAgregarRol").modal("hide");
        obtenerRoles();
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.error("Error en la solicitud:", textStatus, errorThrown);
    },
  });
}

/*=============================================
REVISAR SI EL ROL YA ESTÁ REGISTRADO
=============================================*/

$(".validarRol").on("input", function () {
  $(".alertaRoles").addClass("d-none");

  let rol = $(this).val();

  $.ajax({
    url: `http/roles.endpoint.php?rol=${rol}`,
    method: "GET",
    cache: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      if (respuesta.success == true) {
        $(".alertaRoles").removeClass("d-none");
        $(".alertaRoles").html(
          "<i class='fa-solid fa-triangle-exclamation'></i> Este Cargo ya existe"
        );
        $("#btnAgregarRol").attr("disabled", "disabled");
      } else {
        $(".alertaRoles").addClass("d-none");
        $("#btnAgregarRol").removeAttr("disabled");
      }
    },
    error: function () {
      $("#btnAgregarRol").removeAttr("disabled");
    },
  });
});
