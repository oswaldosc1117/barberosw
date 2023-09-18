<h1 class="nombre-pagina">Crear Nueva Cita</h1>
<p class="descripcion-pagina">Elige tus servicios a tu gusto</p>

<?php
    include_once __DIR__ . '/../templates/barra.php';
?>

<div id="app">

    <nav class="tabs">
        <button type="button" data-paso="1">Servicios</button> <!-- NG - 1 -->
        <button type="button" data-paso="2">Tus Datos</button>
        <button type="button" data-paso="3">Resumen</button>
    </nav>

    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <p class="text-center">Selecciona los servicios que desees</p>
        <div id="servicios" class="listado-servicios"></div>
    </div>

    <div id="paso-2" class="seccion">
        <h2>Tus Datos</h2>
        <p class="text-center">Coloca tus datos y selecciona la fecha de tu cita</p>

        <form class="formulario">
            <div class="campo">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" placeholder="Tu nombre" value="<?php echo $nombre; ?>" disabled>
            </div>

            <div class="campo">
                <label for="fecha">Fecha:</label>
                <input type="date" id="fecha" min="<?php echo date('Y-m-d', strtotime('+1 day'));?>"> <!--NG - 2 -->
            </div>
            
            <div class="campo">
                <label for="hora">Hora:</label>
                <input type="time" id="hora">
            </div>

            <input type="hidden" id="id" value="<?php echo $id; ?>">

        </form>
    </div> <!--Cierre de paso-2-->

    <div id="paso-3" class="seccion contenido-resumen">
        <h2>Resumen</h2>
        <p class="text-center">Verifica que la informacion de tu cita sea correcta</p>
    </div>

    <div class="paginacion">
        <button id="anterior" class="boton">&laquo; Anterior</button>
        <button id="siguiente" class="boton">Siguiente &raquo;</button>
    </div>
</div> <!--Cierre de app-->

<?php

    $script = "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script src='build/js/app.js'></script>
    ";
?>

<!--
    NOTAS GENERALES

    1.- Atributos globales data-*: Llamados atributos de datos modificables , permite a la información propietaria ser intercambiada entre el HTML y su
    representación en el DOM que puede ser usada por scripts. Todos esos datos modificables están disponibles a través de la interface del elemento HTMLElement,
    el atributo se establece encendido. La propiedad HTMLElement.dataset otorga acceso a ellos.

    2.- strtotime() Convierte una descripción de fecha/hora textual en Inglés a una fecha Unix.
-->

