/*=============================================
INICIAR SESIÓN
=============================================*/

$("#btnCerrarSesion").on("click", function (e) {
  e.preventDefault();

  cerrarSesion();
});

function cerrarSesion(datos) {
  $.ajax({
    url: "http/logout.endpoint.php",
    method: "POST",
    // data: datos,
    dataType: "json",
    cache: false,
    contentType: "Application/json",
    success: function (respuesta) {
      if (respuesta.success === true) {
        // Redirigir al usuario a la página principal o dashboard
        window.location = "login";
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.error("Error en la solicitud:", textStatus, errorThrown);
      // Aquí puedes manejar el error, por ejemplo, mostrando una alerta al usuario.
    },
  });
}
