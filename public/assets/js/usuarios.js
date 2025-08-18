document.addEventListener("DOMContentLoaded", function () {
  /* OBTENER USUARIOS */
  let tablaUsuarios = document.querySelector("#tablaUsuarios tbody");

  const obtenerUsuarios = async (item, id) => {
    tablaUsuarios.innerHTML = "";

    let datosUsuarios = "";

    try {
      const respuesta = await fetch(
        `../controlador/controlador_usuarios.php?item=${item}&value=${id}`
      );
      const datos = await respuesta.json();

      if (datos.success) {
        const listaUsuarios = Array.isArray(datos.data)
          ? datos.data
          : [datos.data];

        if (listaUsuarios.length > 0) {
          datosUsuarios = "";
          listaUsuarios.forEach((usuario, i) => {
            // El controlador no devuelve "apellido", solo "nombre"
            datosUsuarios += `
            <tr>
              <td>${i + 1}</td>
              <td>${usuario.nombre}</td> 
              <td>${usuario.usuario}</td>
              <td><button type="button" class="btnEditarUsuario" id-usuario="${
                usuario.id
              }">ID</button></td>
            </tr>
          `;
          });
          tablaUsuarios.innerHTML = datosUsuarios;
        } else {
          // En caso de que el array esté vacío
          tablaUsuarios.innerHTML =
            '<tr><td colspan="4">Sin resultados</td></tr>';
        }
      } else {
        console.error("Error:", datos.mensaje);
      }
    } catch (error) {
      console.error("Error al obtener usuario:", error);
    }
  };

  // const dataUsuarios = obtenerUsuarios("id", 1);
  obtenerUsuarios(null, null);

  /* CREAR USUARIO */
  let nombreUsuario = document.querySelector("#agrergarNombre");
  let apellidoUsuario = document.querySelector("#agrergarApellido");
  let username = document.querySelector("#agrergarUsername");
  let passwordUsuario = document.querySelector("#agregarPassword");
  let confirmarPassword = document.querySelector("#agregarConfirmarPassword");

  let formNuevoUsuario = document.querySelector("#formAgregarUsuario");
  let btnAgregarUsuario = document.querySelector("#btnAgregarUsuario");

  // Función para confirmar la contraseña
  const confirmarMismaPassword = () => {
    // Obtenemos los valores de los campos de input
    let pass = passwordUsuario.value;
    let confirmar = confirmarPassword.value;

    if (pass === confirmar && pass !== "") {
      console.log("¡La contraseña coincide!");
    } else {
      console.error("La contraseña no coincide o está vacía.");
    }
  };

  confirmarPassword.addEventListener("keyup", confirmarMismaPassword);
  confirmarPassword.addEventListener("blur", confirmarMismaPassword);

  // Función para crear un usuario nuevo
  const crearUsuario = async (nombre, apellido, usuario, password) => {
    // Objeto con los datos del nuevo usuario
    const datosUsuario = {
      nombre: nombre,
      apellido: apellido,
      usuario: usuario,
      password: password,
    };

    try {
      const respuesta = await fetch(`../controlador/controlador_usuarios.php`, {
        method: "POST", // Usamos el método POST para crear recursos
        headers: {
          "Content-Type": "application/json",
        },
        // Convertimos el objeto a una cadena JSON para el cuerpo de la solicitud
        body: JSON.stringify(datosUsuario),
      });

      if (!respuesta.ok) {
        throw new Error(`Error en la solicitud: ${respuesta.status}`);
      }

      const datos = await respuesta.json();

      if (datos.success) {
        console.log("Usuario creado con éxito:", datos.mensaje);
        console.log("Detalles del nuevo usuario:", datos.data);
        return datos.data; // Retorna los datos del usuario creado
      } else {
        console.error("Error al crear el usuario:", datos.mensaje);
        return null;
      }
    } catch (error) {
      console.error("Ha ocurrido un error en la solicitud:", error);
      return null;
    }
  };

  // formNuevoUsuario.addEventListener("submit", function (e) {
  //   e.preventDefault();

  //   let nombre = nombreUsuario.value;
  //   let apellido = apellidoUsuario.value;
  //   let usuario = username.value;
  //   let password = passwordUsuario.value;

  //   crearUsuario(nombre, apellido, usuario, password);
  // });

  btnAgregarUsuario.addEventListener("click", function () {
    alert(nombreUsuario.value);
  });
});
