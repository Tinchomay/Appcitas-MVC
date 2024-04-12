document.addEventListener('DOMContentLoaded', function() {
    iniciarApp()
})

function iniciarApp() {
    buscarPorFecha();
    alertaEliminar();
    cerrarSesion();
    cambiarFechaAdmin();
}

function buscarPorFecha() {
    const fechaInput = document.querySelector('#fecha');
    fechaInput.addEventListener('input', function(e) {
        const fechaSeleccionada = e.target.value;

        window.location = `?fecha=${fechaSeleccionada}`;
    })
}

function alertaEliminar() {
    const botonesEliminar = document.querySelectorAll('.eliminar-servicios');
    botonesEliminar.forEach( function(boton) {
        boton.addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: "¿Estas seguro?",
                text: "Estas a punto de eliminar una cita",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: 'Cancelar',
                confirmButtonText: "Eliminar"
              }).then((result) => {
                if (result.isConfirmed) {
                  Swal.fire({
                    title: "Eliminada",
                    text: "La cita ha sido eliminada correctamente",
                    icon: "success"
                  }).then((()=> boton.submit()))
                } 
              });
        })
    })
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

function cambiarFechaAdmin() {
  const fecha = document.querySelector('#fecha').value;
  const contenedorFechaAdmin = document.querySelector('#contenedorFechaAdmin');
  const fechaObjeto = new Date(fecha);
  const mes = fechaObjeto.getMonth();
  //Con el +2 se compenza el uso del objeto fecha dos veces
  const dia = fechaObjeto.getDate() + 2 ;
  const year = fechaObjeto.getFullYear();

  //Date.UTC devuelve el numero de milisegundos que hay entre la media nochen del 1 enero de 1970 hasta la fecha que le pasamos
  const fechaUTC = new Date ( Date.UTC(year, mes, dia) )
  const opciones = {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'}
  const fechaFormateada = fechaUTC.toLocaleDateString('es-MX', opciones);
  const fechaFor = document.createElement('H3');
  fechaFor.textContent = fechaFormateada;
  contenedorFechaAdmin.appendChild(fechaFor);

}