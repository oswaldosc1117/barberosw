<h1 class="nombre-pagina">BarberOSW</h1>
<p class="descripcion-pagina">Inicia Sesión con tus Datos</p>

<?php include_once __DIR__ . "/../templates/alertas.php"; ?>


<form class="formulario" method="POST" action="/">
    <div class="campo">
        <label for="email">E-Mail</label>
        <input type="email" id="email" name="email" placeholder="Introduce tu Correo Electrónico" value="<?php echo s($auth->email); ?>">
    </div>

    <div class="campo">
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" placeholder="Introduce una Contraseña">
    </div>

    <div class="boton-centrado">
        <input type="submit" class="boton" value="Iniciar Sesión">
    </div>
</form>

<div class="acciones">
    <a href="/create-account">¿Aún no tienes una Cuenta? Crea una</a>
    <a href="/forget">¿Olvidaste tu Contraseña?</a>
</div>