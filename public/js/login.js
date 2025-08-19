/*=============================================
INICIAR SESIÓN
=============================================*/

$("#formIniciarSesion").on("submit", function (e) {
  e.preventDefault();

  const username = $("#ingUsuario").val().trim();
  const password = $("#ingPassword").val().trim();

  if (username === "" || password === "") {
    $("#alerta").removeClass("d-none");
    $("#alerta").html("Por favor, completa todos los campos.");
    return;
  }

  const data = {
    username: username,
    password: password,
  };

  iniciarSesion(data);
});

function iniciarSesion(datos) {
  $.ajax({
    url: "http/usuarios.endpoint.php",
    method: "POST",
    data: datos,
    dataType: "json",
    success: function (respuesta) {
      if (respuesta.status === "success") {
        // Redirigir al usuario a la página principal o dashboard
        window.location = "inicio.php";
      }
      console.log(respuesta);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.error("Error en la solicitud:", textStatus, errorThrown);
      // Aquí puedes manejar el error, por ejemplo, mostrando una alerta al usuario.
    },
  });
}
