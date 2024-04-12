<div class="barra-usuario">
    <p class="nombre-cliente admin">Hola <span> <?php echo $nombre; ?></span></p>
    <a id="cerrar-sesion">Cerrar Sesion</a>
</div>

<div class="barra-servicios">
    <a href="/admin" class="boton">Ver citas</a>
    <a href="/servicios" class="boton">Ver servicios</a>
</div>

<h1 class="nombre-pagina">Crear Servicio</h1>
<p class="descripcion-pagina">Crea un servicio a continuacion</p>

<?php include_once __DIR__ . '/../templates/alertas.php' ?>

<form action="/servicios/crear" method="POST" class="formulario" novalidate>
    <?php include_once __DIR__ . '/formulario.php' ?>
    <input type="submit" value="Crear servicio" class="boton" id="crear-servicio">
</form>

<?php 
    $scrip = "<script src='/build/js/crearServicio.js'>
    </script><script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
?>

