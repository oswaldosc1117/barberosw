
<h1 class="nombre-pagina">Reestablece tu Contraseña</h1>
<p class="descripcion-pagina">Introduce tu E-Mail para recuperar tu cuenta</p>

<?php include_once __DIR__ . "/../templates/alertas.php"; ?>

<form action="/forget" method="POST" class="formulario">
    <div class="campo">
        <label for="email">E-Mail:</label>
        <input type="email" name="email" id="email" placeholder="Introduce tu Correo Electrónico">
    </div>

    <div class="boton-centrado">
        <input type="submit" value="Recuperar Cuenta" class="boton">
    </div>
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una Cuenta? Inicia Sesión</a>
    <a href="/create-account">¿Aún no tienes una Cuenta? Crea Una</a>
</div>