<h1 class="nombre-pagina"> Crear cuenta</h1>
<p class="descripcion-pagina">LLena el siguiente formulario para crear una cuenta </p>
<?php 
    include_once __DIR__ . '/../templates/alertas.php'
?>
<form action="/crear-cuenta" method="POST" class="formulario">
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="usuario[nombre]" placeholder="Tu Nombre" value="<?php echo $usuario->nombre ?>" required>
    </div>
    <div class="campo">
        <label for="apellido">Apellido</label>
        <input type="text" id="apellido" name="usuario[apellido]" placeholder="Tu Apellido" value="<?php echo $usuario->apellido ?>" required>
    </div>
    <div class="campo">
        <label for="telefono">Telefono</label>
        <input type="tel" id="telefono" name="usuario[telefono]" placeholder="Tu Telefono" value="<?php echo $usuario->telefono ?>" required>
    </div>
    <div class="campo">
        <label for="email">E-mail</label>
        <input type="tel" id="email" name="usuario[email]" placeholder="Tu Email" value="<?php echo $usuario->email ?>" required>
    </div>
    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" name="usuario[password]" placeholder="Tu password" required>
    </div>

    <input type="submit" class="boton" value="Crear cuenta">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta?</a>
    <a href="/olvide">¿Olvidaste tu password?</a>
</div>