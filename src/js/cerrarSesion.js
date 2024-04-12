document.addEventListener('DOMContentLoaded', function() {
    iniciarApp();
})

function iniciarApp() {
    cerrarSesion();
}

function cerrarSesion() {
    const botonLogout = document.querySelector('#cerrar-sesion')
    botonLogout.addEventListener('click', function() {
        Swal.fire({
            title: "¿Estas seguro?",
            text: "Estas a punto de cerrar sesion",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Cerrar sesion"
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire({
                title: "Session cerrada",
                text: "Se ha cerrado la sesion correctamente",
                icon: "success"
              }).then( () => {
                window.location.replace('/logout');
              });
            }
          });
    })
}