<h1 class="nombre-pagina">Recuperar Contraseña</h1>
<p class="descripcion-pagina">Introduce una nueva Contraseña</p>

<?php include_once __DIR__ . "/../templates/alertas.php"; ?>

<?php if($error) return; ?>

<form class="formulario" method="POST">
    <div class="campo">
        <label for="password">Contraseña:</label>
        <input type="password", name="password", id="password", placeholder="Tu Contraseña">
    </div>

    <div class="campo">
        <label for="recovery">Confirmar:</label>
        <input type="password", name="recovery", id="recovery", placeholder="Introduce nuevamente tu Contraseña">
    </div>

    <div class="boton-centrado">
        <input class="boton" type="submit" value="Reestablecer Contraseña">
    </div>
</form>

<div class="acciones">
    <a href="/">¿Tienes una cuenta? Inicia Sesión</a>
    <a href="/create-account">¿Aún no tienes una Cuenta? Crea una</a>
</div>