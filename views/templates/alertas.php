<?php

foreach($alertas as $key => $alerta): // NG - 1.
    foreach($alerta as $mensaje): ?>
        <div class="alertas <?php echo $key; ?>">
            <?php echo $mensaje; ?>
        </div>
    <?php endforeach;
endforeach; ?>

<!--
    NOTAS GENERALES:

    1.- Se emplean dos foreach() seguidos dado que, como estas alertas vienen del modelo de "Usuarios" en el metodo de validarCuenta() en el que se definen por medio
    de la sintaxis: self::$alertas[$key][] = $value; la 1era llave hace referencia al tipo de mensaje (su $key), mientras que la 2da refiere directamente al mensaje
    que corresponde a su $key. Si por ejemplo en la 1era llave tenemos $key para valores de 'error' o 'exito', en el 2do foreach se mostraran los mensajes que
    corresponden a cada uno de ellos. Igualmente, estas $key se emplearan como clases segun sea el caso para luego definirlas en el SCSS sin la necesidad definirlas
    estaticamente.
-->
