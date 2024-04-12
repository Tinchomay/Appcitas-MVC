<h1 class="nombre-pagina">Panel de administracion</h1>
<div class="barra-usuario">
    <p class="nombre-cliente admin">Hola <span> <?php echo $nombre; ?></span></p>
    <a id="cerrar-sesion">Cerrar Sesion</a>
</div>

<div class="barra-servicios">
    <a href="/servicios" class="boton">Ver servicios</a>
    <a href="/servicios/crear" class="boton">Crear nuevo servicio</a>
</div>
<h2>Buscar citas</h2>
<div class="busqueda">
    <form class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="fecha" value="<?php echo $fecha ?>">
        </div>
    </form>
</div>

<div id="citas-admin">
    <div id="contenedorFechaAdmin">
        <h3 >Citas del </h3>
    </div>
    <ul class="citas">
        <?php
        //Declaramos esta variable para que no marque error
        $idCita = 0;
        //Aqui el key es la posicion del arreglo, que en este caso es cada objeto iniciando desde 0
        if($citas){
            foreach($citas as $key => $cita) {
                //Aqui evaluamos con un if si el id de la cita es distinta, si es distinta ejecutamos de nuevo, esto lo hacemos para no estar repitiendo ya que en nuestra base de datos se guarda varias veces el mismo id cuando seleccionan varios servicios
                if($idCita !== $cita->id) {
                    //Esta variable esta bien para que se ponga en cero cada vez que entramos a un nuevo grupo de citas
                    $total = 0 ?>
                    <li>
                        <p>ID: <span> <?php echo $cita->id; ?></span></p>
                        <p>Hora: <span> <?php echo $cita->hora; ?></span></p>
                        <p>Cliente: <span> <?php echo $cita->cliente; ?></span></p>
                        <p>Email: <span> <?php echo $cita->email; ?></span></p>
                        <p>Telefono: <span> <?php echo $cita->telefono; ?></span></p>
                        <h3>Servicios</h3>
                <?php 
                    $idCita = $cita->id; 
                } ?>
                        <p class="servicio"><?php echo $cita->servicio;?> <span><?php echo "$" . $cita->precio;?></span></p>
                <?php if($idCita !== $cita->id) { ?>
                    </li>
                <?php } ?>
                <?php 
                    //La suma tiene que quedar afuera del if para que se ejecute por cada servicio
                    $total += $cita->precio;
                    //Retorna el id actual que esta recorriendo el for each
                    $actual = $cita->id;
                    //Esto asigna el valor del id del proximo objeto, estos dos solo van ser distintos cuando se termine el grupo de la misma cita
                    $proximo = $citas[$key + 1]->id ?? 0;
                    //Aqui comparamos cuando son distintas las dos variables y cuando lo son mostramos el total abajo
                    if (esUltimo($actual, $proximo)){?>
                        <div class="contenedor-final-servicios">
                            <p class="total">Total $<?php echo $total; ?></p>
                            <form class="eliminar-servicios" method="POST" action="/api/eliminar">
                                <input type="hidden" name="id" value="<?php echo $cita->id; ?>">
                                <input type="image" src="build/img/icono_eliminar.svg" class="imagen-eliminar-servicios">
                            </form>
                        </div>
                        
                <?php } ?>
            <?php }
        } else { ?>
            <h3 class="alerta error">No se encontraron citas</h3>
            
        <?php }?>
    </ul>
</div>

<!-- <script src="build/js/fecha.js"></script> -->
<?php 
    $scrip = "<script src='build/js/buscador.js'>
    </script><script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
?>


