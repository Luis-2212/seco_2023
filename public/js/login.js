/*=============================================
INICIAR SESIÓN
=============================================*/

$("#formIniciarSesion").on("submit", function (e) {
  e.preventDefault();

  const username = $("#ingUsuario").val().trim();
  const password = $("#ingPassword").val().trim();

  if (username == "" || password == "") {
    $("#alerta").removeClass("d-none");
    $("#alerta").html("Por favor, completa todos los campos.");
    return;
  }

  const data = {
    username: username,
    password: password,
  };

  iniciarSesion(JSON.stringify(data));
});

function iniciarSesion(datos) {
  $.ajax({
    url: "http/login.endpoint.php",
    method: "POST",
    data: datos,
    dataType: "json",
    cache: false,
    contentType: "Application/json",
    success: function (respuesta) {
      if (respuesta.success === true) {
        // Redirigir al usuario a la página principal o dashboard
        window.location = "inicio";
        console.log(respuesta.success);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      if (jqXHR.responseJSON.status === 401) {
        $(".alertaLogin").removeClass("d-none");
        $(".alertaLogin").html("Usuario o contraseña incorrecta");
      }
    },
  });
}
