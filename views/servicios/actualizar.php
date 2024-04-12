<div class="barra-usuario">
    <p class="nombre-cliente admin">Hola <span> <?php echo $nombre; ?></span></p>
    <a id="cerrar-sesion">Cerrar Sesion</a>
</div>

<div class="barra-servicios">
    <a href="/admin" class="boton">Ver citas</a>
    <a href="/servicios" class="boton">Ver servicios</a>
    <a href="/servicios/crear" class="boton">Crear nuevo servicio</a>
</div>

<h1 class="nombre-pagina">Actualizar servicios</h1>
<p class="descripcion-pagina">Actualiza el servicio a continuacion</p>

<?php include_once __DIR__ . '/../templates/alertas.php' ?>

<form method="POST" class="formulario">
    <?php include_once __DIR__ . '/formulario.php' ?>
    <input type="submit" value="Actualizar servicio" class="boton">
</form>

<?php 
    $scrip = "<script src='/build/js/cerrarSesion.js'>
    </script><script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
?>