//Esta variable se utiliza para asignar el valor con el data-paso seleccionado
let paso = 1;

//Variables para tamaño de paginacion
const pasoInicial = 1;
const pasoFinal = 3;

//Objeto que contendra las citas y es const porque los objetos son como let
const cita = {
    id: '',
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
}


document.addEventListener('DOMContentLoaded', function() {
    mostrarSeccion();//Como la mandamos llamar al cargar el contendio se carga el contenedor con el paso 1 por el let 1
    iniciarApp();//Inicia todas las funciones
    
    
})

function iniciarApp() {
    tabs();//Cambiar secciones
    paginador(); //Ocultar y mostrar botones
    paginaSiguiente();
    paginaAnterior();

    consultarAPI();//Obtener informacion del backend de php
    nombreCliente();//Asignar nombre
    fechaCliente();//Asignar fecha
    horaCliente();//Asignar hora al cliente
    mostrarResumen();//Mostrando el objeto cita en resumen
    idCliente(); //Asignar id cliente

    cerrarSesion();
}


function mostrarSeccion() {
    //Ocultando div quitandoles la clade de mostrar
    const seccionAnterior = document.querySelector('.mostrar');//Seleccionamos mostrar
    if(seccionAnterior) { //Si hay un mostrar se elimina
        seccionAnterior.classList.remove('mostrar')
    }
    //Mostrando divs 
    const pasoSelector = `#paso-${paso}`; //Template string de la let paso que se actualiza con la funcion tabs
    const seccion = document.querySelector(pasoSelector);
    seccion.classList.add('mostrar');

    //Quitar resaltar a otros tabs
    const actual = document.querySelector('.actual');
    if (actual) {
        actual.classList.remove('actual')
    }
    //Resalta el tab actual
    const tab = document.querySelector(`[data-paso="${paso}"]`);//Seleccionamos el elemento con ese atributo en especifico
    tab.classList.add('actual');
}

function tabs() {
    const botones = document.querySelectorAll('.tabs button');
    botones.forEach( (boton) => { boton.addEventListener('click', 
    (e) => { paso = parseInt(e.target.dataset.paso);//Esto asigna un numero
         mostrarSeccion(); //Manda a llamar la funcion por cada click
         paginador();
    })
    //Aqui la e es el evento y se puede acceder al target que es el elemento que seleccionamos y despues a los atributos personalisables, dataset para esos atributos y luego el nombre que le asignamos
    //Con la funcion parseInt vamos a convertir eso a enteros por que esto nos lo da en entereos
    });

}

//Funcion para mostrar y ocultar tabs
function paginador() {
    anterior = document.querySelector('#anterior');
    siguiente = document.querySelector('#siguiente');
    
    if (paso === 1) {
        anterior.classList.add('ocultar');
        siguiente.classList.remove('ocultar');
    } else if (paso === 3) {
        siguiente.classList.add('ocultar');
        anterior.classList.remove('ocultar');
        //Se pone aqui porque cuando accedemos al paso 3 tenemos que llamarle para mostrar el resumen, si no solo se llamaria al principio de la aplicacion
        mostrarResumen();
    } else {
        siguiente.classList.remove('ocultar');
        anterior.classList.remove('ocultar');
    }
    mostrarSeccion();
}

//Con estas funciones cambiamos el valor del paso y mandamos a llamar a las dos funciones que cambian el estio de la pagina
function paginaAnterior() {
    anterior = document.querySelector('#anterior');
    anterior.addEventListener('click', function() {
        if(paso <= pasoInicial) return; //Este if valora el numero y cancela para no exceder limites
        paso--;
        paginador();
    }) 
}
function paginaSiguiente() {
    siguiente = document.querySelector('#siguiente')
    siguiente.addEventListener('click', function() {
        if(paso >= pasoFinal) return;
        paso++;
        paginador();
    }) 
}

//async para hacer una funcion asincrona, se necesita el asyn y await para que funcione
async function consultarAPI() {
    //Usualmente se utilizan con un try catch
    try {
        //Esta es la url del router que nos arroja los servicios en JSON
        const url = '/api/servicios';
        //Aqui el await detiene las siguientes lineas de codigo hasta que este terminado el fetch
        const resultado = await fetch(url); //fetch  es la funcion para consumir apis
        const servicios = await resultado.json();//Con json convertimos el json en un objeto con los elementos que obtenimos
        mostrarServicios(servicios);//Pasamos los servicios a una funcion
    } catch (error) {
        //Aqui visualizamos en la consola si hay un error
        console.log(error)
    }
}

function mostrarServicios( servicios ) { 
    servicios.forEach( servicio  => { //Pasamos cada uno de los servicios en el for each
        const {id, nombre, precio} = servicio; //Aplicamos destructuring para crear variables

        //El proceso lo realizaremos por scriptin ya que tiene mas performance y es mas seguro
        //Creamos un parrafo
        const nombreServicio = document.createElement('P');
        //Agregamos clase para darle estilos
        nombreServicio.classList.add('nombre-servicio');
        //Asignamos el contenido con las variables de destructuring
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = `$ ${precio}`;

        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicio')
        servicioDiv.dataset.idServicio = id; //Asignando tributo personalizado

        //Seleccionar servicios, utilizamos un callback para poder pasar el servicio como parametro
        servicioDiv.onclick = function () {
            seleccionarServicio(servicio);
        }
        
        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);
        
        const contenedor = document.querySelector('#servicios');
        contenedor.appendChild(servicioDiv)

    })
}
//Funcion para añadir los objetos de los servicios al objeto cita, como ir sumandolos
function seleccionarServicio(servicio) {

    //Extraemos y creamos la variable servicio del objeto citas
    const {servicios} = cita;

    //Identifica a que contenedor se le da click
    const divServicio = document.querySelector(`[data-id-servicio="${servicio.id}"]`);


    //Comprobar si un servicio ya fue agregado
    //Some itera sobre todos los servicios que ya estan en el objeto por que se creo una variable con destructuring y accedemos a sus id y los comparamos con el id del servicio al que dimos click
    if( servicios.some( agregados => agregados.id === servicio.id)){
        //Filter nos retorna un array con los elementos que filtra, en este caso nos trae todos los que son distintos al del id que estamos seleccionando
        cita.servicios = servicios.filter( agregados => agregados.id !== servicio.id)
        divServicio.classList.remove('seleccionado');

    } else {
        //Aqui accedemos al valor de servicios del objeto cita y tomamos una copia de lo que hay para añadirle el servicio que viene como parametro, es importante los 3 puntos porque este nos asegura traernos la copia y reescribir el servicio
        cita.servicios = [...servicios, servicio];
        divServicio.classList.add('seleccionado');
    }
}
function nombreCliente() {
    const nombreInput = document.querySelector('#nombre').value;
    cita.nombre = nombreInput;

}
function fechaCliente() {
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('input', function(e) {
        //El objeto date de JS nos permite acceder a una funcion que dice en que numero de dia de la semana estamos, 0 es domingo, 1 es lunes
        const dia = new Date(e.target.value).getUTCDay();
        //Includes nos permite revisar si existe un elemento, en este caso dos elementos, los que estan entre corchetes
        if ([0].includes(dia)) {
            e.target.value = "";
            mostrarAlerta('Los domingos no abrimos, por favor selecciona otro dia', 'error', '.formulario');
        } else {
            //Importante, el objeto tiene que ir del lado izquierdo
            cita.fecha = e.target.value;
        }
        
    });
}

function mostrarAlerta(mensaje, tipo, ubicacion, desaparece = true) {
    //Con este if revisamos si no hay otra alerta ya para evitar que nos llenemos de alertas y si hay la eliminamos para que se muestre otra alerta
    alertaPrevia = document.querySelector('.alerta');
    if(alertaPrevia) {
        alertaPrevia.remove();
    }

    contenedorFecha = document.querySelector(ubicacion)
    alerta = document.createElement('DIV');
    alerta.textContent = mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);

    contenedorFecha.appendChild(alerta);

    //Eliminar alerta con el tiempo
    if(desaparece) {
        setTimeout(() => {
        alerta.remove();
        }, 3000);
    }
}
function horaCliente() {
    const inputHora = document.querySelector('#hora');
    inputHora.addEventListener('input', function(e) {
        const horaCita = e.target.value;
        //Podemos separar la hora que nos entrga el sistema en formato de 24 hrs con la funcion split pasandole que va a separar, colocamos los corchetes para acceder de una vez al indice del array
        const hora = horaCita.split(":")[0];
        if (hora < 9 || hora >19){
            mostrarAlerta('El horario de trabajo es de 09:00 am a 08:00 pm', 'error', '.formulario')
        } else {
            cita.hora = e.target.value
        }
    });
}
function mostrarResumen() {
    contenidoResumen = document.querySelector('.contenido-resumen');

    //Vamos a aplicar un while para limpiar el resumen por si quedo una alerta o contenido, este codigo elimina uno por uno los hijos de contenido resumen
    while(contenidoResumen.firstChild){
        contenidoResumen.removeChild(contenidoResumen.firstChild)
    }
    //Validar que todos los campos esten llenos, utilizamos el metodo Object.values(var) que nos permite ver los valores de nuestro objeto. Posteriormente validamos si hay algun string vacio con includes
    if(Object.values(cita).includes('') || cita.servicios.length === 0) {
        mostrarAlerta('Hacen falta datos, favor de validar los servicios y la informacion de la cita', 'error', '.contenido-resumen', false)
        //Con este return paramos el codigo si falta algo y no utilizar un else
        return;
    } 
    // Aqui continua el codigo si no se paro por un error
    //Mostrando datos de cita
    const {nombre, fecha, hora, servicios} = cita;

    const  nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Nombre: </span>${nombre}`;

    //Formatear fecha 
    //Cada vez que utilizamos el objeto fecha se resta un dia
    const fechaObjeto = new Date(fecha);
    const mes = fechaObjeto.getMonth();
    //Con el +2 se compenza el uso del objeto fecha dos veces
    const dia = fechaObjeto.getDate() + 2;
    const year = fechaObjeto.getFullYear();

    //Date.UTC devuelve el numero de milisegundos que hay entre la media nochen del 1 enero de 1970 hasta la fecha que le pasamos
    const fechaUTC = new Date ( Date.UTC(year, mes, dia) )
    const opciones = {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'}
    const fechaFormateada = fechaUTC.toLocaleDateString('es-MX', opciones);
 

    const  fechaCliente = document.createElement('P');
    fechaCliente.innerHTML = `<span>Fecha: </span>${fechaFormateada}`;

    const  horaCliente = document.createElement('P');
    horaCliente.innerHTML = `<span>Hora: </span>${hora}`;

    const headingCita = document.createElement('H3');
    headingCita.textContent = 'Resumen de cita';
    headingCita.classList.add('text-center');
    contenidoResumen.appendChild(headingCita);

    contenidoResumen.appendChild(nombreCliente);
    contenidoResumen.appendChild(fechaCliente);
    contenidoResumen.appendChild(horaCliente);
    
    //Heading
    const heading = document.createElement('H3');
    heading.textContent = 'Resumen de servicios';
    heading.classList.add('text-center1');
    contenidoResumen.appendChild(heading);
    //Aplicamos un for each para iterar sobre los servicios
    servicios.forEach( function(servicio) {
        const contenedorServicio = document.createElement('DIV');
        contenedorServicio.classList.add('contenedor-servicio')

        const nombreServicio = document.createElement('P');
        nombreServicio.textContent = servicio.nombre;
        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `<span>$ </span>${servicio.precio}`;

        contenedorServicio.appendChild(nombreServicio);
        contenedorServicio.appendChild(precioServicio);
        contenidoResumen.appendChild(contenedorServicio);
    })

    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.textContent = 'Reservar cita';
    botonReservar.onclick = function() {
        Swal.fire({
            title: "¿Estas seguro?",
            text: "Estas a punto de crear una cita",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            cancelButtonText: "Cancelar",
            confirmButtonText: "Crear cita"
        }).then((result)=> { 
            if (result.isConfirmed) {
                reservarCita() 
            }
        });
    }
    contenidoResumen.appendChild(botonReservar);
    
}

async function reservarCita() {
    const {id, fecha, hora, servicios} = cita;

    //Como servicios es un array hay que iterar sobre el pero con un map para que se puedan almacenar los valores en la variable y como en la base de datos solo ocupamos el id de servicio esto vamos a almacenar en la variable
    const idServicio = servicios.map(function(servicio) {
        return servicio.id;
    })
    //Creando el objeto que tendra los datos, este actuara como el submit
    const datos = new FormData();
    //Con append agregamos valores al objeto, que en este caso son los de destructuring, en el primer valor va la llave y en el segundo la key
    //Aqui tienen que estar los public del modelo
    datos.append('usuarioId', id)
    datos.append('fecha', fecha)
    datos.append('hora', hora)
    datos.append('servicios', idServicio)
    //Consejo, si queremos comprobar los valores de este objeto no lo podremos hacer con un console.log normal, pero podemos creaar una copia y asi si podremos console.log([...datos]);

    try {
        //Peticion hacia la api
        const url = '/api/citas';

        //Cuando realizamos una consulta a una api no es necesario el segundo parametro, pero cuando hacemos una peticion es obligatorio, el segundo parametro son configuraciones que en este caso es el metodo post y body que es el objeto FormData al que le asignamos valores
        const respuesta = await fetch(url, { method: 'POST', body: datos });
        //Segundo await para guardar el resultado en json, el resultado sera lo que tengamos como respuesta en nuestra api
        const resultado = await respuesta.json();
        
        //Accedemos a reultado.resultado por lo que retorna active record
        // console.log(resultado.resultado);

        if(resultado.resultado) {
            //Podemos poner otro icono de completado con success en lugar de error, tambien podemos eliminar el footer
            Swal.fire({
                icon: "success",
                title: "Cita creada",
                text: "La cita fue creada correctamente",
                //Ya no es necesario el button
                // button: 'OK'
                //Utilizamos el then para que cuando se quite la alerta se recargue la pagina
            })
            setTimeout(() => {
                window.location.reload();
            }, 3000);
        }
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "Algo ocurrio mal",
            text: "La cita no pudo ser creada, intenta nuevamente",
        });
        console.log(error);
    }
}
function idCliente() {
    const idcliente = document.querySelector('#id').value;
    cita.id = idcliente;
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
