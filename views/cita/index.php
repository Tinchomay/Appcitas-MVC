<div class="barra-usuario">
    <p class="nombre-cliente">Hola <span> <?php echo $nombre; ?></span></p>
    <a id="cerrar-sesion">Cerrar Sesion</a>
</div>

<h1 class="nombre-pagina">Crear nueva cita</h1>
<p class="descripcion-pagina">Elige tus servicios y coloca tus datos</p>

<div id="app">
    <nav class="tabs">
        <!-- Con estos atributos personalizables vamos a mapear con JS los pasos con los id de cada contenedor, se crean con data guion y lo que queramos -->
        <button type="button" data-paso="1" class="actual">Servicios</button>
        <button type="button" data-paso="2">Informacion Cita</button>
        <button type="button" data-paso="3">Resumen</button>
    </nav>

    <div id="paso-1" class="seccion " >
        <h2>Servicios</h2>
        <p class="text-center">Elige tus servicios a continuacion</p>
        <!-- Vamos a incluir la informacion con JS -->
        <div id="servicios" class="listado-servicios">

        </div>
    </div>

    <div id="paso-2" class="seccion">
        <h2>Tus Datos y Cita</h2>
        <p class="text-center">Coloca tus datos y fecha de cita</p>
        <form class="formulario" >
            <div class="campo">
               <label for="nombre">Nombre</label> 
               <input type="text" id="nombre" placeholder="Tu Nombre" value="<?php echo $nombre;?>" disabled>
            </div>
            <div class="campo">
               <label for="fecha">Fecha</label> 
               <!-- El atributo es año, mes y dia, podemos utilizar la funcion strtotime para sumar dias a nuestra fecha como por ejemplo para no poder seleccionar el mismo dia-->
               <input type="date" id="fecha" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
            </div>
            <div class="campo">
               <label for="hora">Hora</label> 
               <input type="time" id="hora" required step="1800">
            </div>
            <input type="hidden" value="<?php echo $id;?>" id="id">
        </form>
    </div>

    <div id="paso-3" class="seccion contenido-resumen">
        <h2>Resumen</h2>
        <p class="text-center">Verifica que la informacion sea correcta</p>
    </div>

    <div class="paginacion" >
        <!-- Estas entidades sirven para poner flechitas antes o despues -->
        <button id="anterior" class="boton">&laquo; Anterior</button>
        <button id="siguiente" class="boton">Siguiente &raquo;</button>
    </div>
</div>

<?php $scrip = " <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<script src='build/js/app.js'></script> " ?>

