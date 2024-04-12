<div class="barra-usuario">
    <p class="nombre-cliente admin">Hola <span> <?php echo $nombre; ?></span></p>
    <a id="cerrar-sesion">Cerrar Sesion</a>
</div>
<div class="barra-servicios">
    <a href="/admin" class="boton">Ver citas</a>

    <a href="/servicios/crear" class="boton">Crear nuevo servicio</a>
</div>

<h1 class="nombre-pagina">Servicios</h1>
<p class="descripcion-pagina">Administracion de Servicios</p>

<?php if($aviso == 1) { ?>
    <p class="alerta exito">Servicio eliminado correctamente</p>
<?php } ?>

<ul class="servicios">
    <?php foreach($servicios as $servicio ){ ?>
        <li>
            <p>Nombre: <span> <?php echo $servicio->nombre; ?> </span></p>
            <p>Precio: <span> $ <?php echo $servicio->precio; ?> </span></p>
        </li>
        <div class="acciones">
            <a class="boton" href="/servicios/actualizar?id=<?php echo $servicio->id;?>">Actualizar</a>
            <form action="/servicios/eliminar" method="POST">
                <input type="hidden" value="<?php echo $servicio->id;?>" name="id" >
                <input type="submit" value="Eliminar" class="boton rojo">
            </form>
        </div>

    <?php } ?>
</ul>
 
<?php 
    $scrip = "<script src='/build/js/cerrarSesion.js'>
    </script><script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
?>