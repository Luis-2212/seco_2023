/*=============================================
  INICIALIZAR EL PLUGIN DE TELÉFONO
=============================================*/
// var input = document.querySelector(".codigo-pais");
// window.intlTelInput(input, {
//   initialCountry: "ve",
// });
$(document).ready(function () {
  var input = $(".codigo-pais").get(0);

  window.intlTelInput(input, {
    initialCountry: "ve",
    showSelectDialCode: true,
  });
});
