
<h1 class="nombre-pagina">Crear Cuenta</h1>
<p class="descripcion-pagina">Introduce tus datos en el siguiente formulario</p>

<?php include_once __DIR__ . "/../templates/alertas.php"; ?>

<form action="/create-account" class="formulario" method="POST">

    <div class="campo">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" placeholder="Tu Nombre" value="<?php echo s($usuario->nombre); ?>">
    </div>

    <div class="campo">
        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" placeholder="Tu Apellido" value="<?php echo s($usuario->apellido); ?>">
    </div>

    <div class="campo">
        <label for="telefono">Teléfono:</label>
        <input type="tel" id="telefono" name="telefono" placeholder="Tu Teléfono" value="<?php echo s($usuario->telefono); ?>">
    </div>

    <div class="campo">
        <label for="email">E-Mail:</label>
        <input type="email" id="email" name="email" placeholder="Tu E-Mail" value="<?php echo s($usuario->email); ?>">
    </div>

    <div class="campo">
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" placeholder="Tu Contraseña">
        <!--No es recomendable incluir un value a los passwords para mayor seguridad y privacidad de los datos-->
    </div>

    <div class="boton-centrado">
        <input type="submit" value="Registrate" class="boton">
    </div>
</form> <!--Cierre de formulario-->

<div class="acciones">
    <a href="/">¿Ya tienes una Cuenta? Inicia Sesión</a>
</div>