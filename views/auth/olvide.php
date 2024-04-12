<h1 class="nombre-pagina">¿Olvidaste tu password?</h1>
<p class="descripcion-pagina">Restablece tu password escribiendo tu email</p>

<?php include_once __DIR__ . '/../templates/alertas.php' ?>

<form action="/olvide" class="formulario" method="POST">
    <div class="campo">
        <label for="email">E-mail</label>
        <input type="email" name="usuario[email]" id="email" placeholder="Tu Email" required>
    </div>

    <input type="submit" class="boton" value="Restablecer">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta?</a>
    <a href="/crear-cuenta">¿Aun no tienes una cuenta? Crear una</a>
</div>