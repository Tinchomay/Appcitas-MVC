<h1 class="nombre-pagina">Recuperar Password</h1>

<?php include_once __DIR__ . '/../templates/alertas.php' ?>

<?php if(!$error && !$completo) { ?>
    <p class="descripcion-pagina">Coloca tu nuevo password a continuacion</p>
<form method="POST" class="formulario">
    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" placeholder="Tu nuevo password" name="usuario[password]">
    </div>
    <input type="submit" value="Crear nueva contraseña" class="boton">
</form>
<?php } ?>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia sesion</a>
    <a href="/crear-cuenta">¿Aun no tienes una cuenta? Crear una</a>
</div>