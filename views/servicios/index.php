<h1 class="nombre-pagina">Servicios</h1>
<p class="descripcion-pagina">Administración de Servicios</p>

<?php include_once __DIR__ . '/../templates/barra.php'; ?>

<ul class="servicios">
    <?php foreach($servicios as $servicio): ?>
        <li>
            <p>Nombre: <span><?php echo $servicio->servicio; ?></span></p> <!--NG - 1. -->
            <p>Precio: <span>$<?php echo $servicio->precio; ?></span></p>

            <div class="acciones">
                <a class="boton" href="/servicios/actualizar?id=<?php echo $servicio->id; ?>">Actualizar</a>

                <form action="/servicios/eliminar" method="POST">
                    <input type="hidden" name="id" value="<?php echo $servicio->id; ?>">
                    <input type="submit" value="Borrar" class="boton-eliminar">
                </form>
            </div>
        </li>

    
    <?php endforeach; ?>
</ul>


<!--
    NOTAS GENERALES

    1.- El 1er servicio corresponde al que se crea en el foreach, el 2do es el que corresponde a la columna de la tabla de "servicios" de la base de datos (SQL),
    definida en el modelo de Servicios.
-->