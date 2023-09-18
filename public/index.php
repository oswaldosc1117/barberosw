<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\AdminController;
use Controllers\APIController;
use Controllers\CitasController;
use Controllers\LoginController;
use Controllers\ServicioController;
use MVC\Router;

$router = new Router();

// Iniciar sesion.
$router->get('/', [LoginController::class, 'login']);
$router->post('/', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);

// Recuperar password.
$router->get('/forget', [LoginController::class, 'forget']);
$router->post('/forget', [LoginController::class, 'forget']);
$router->get('/recovery', [LoginController::class, 'recovery']);
$router->post('/recovery', [LoginController::class, 'recovery']);

// Crear cuenta.
$router->get('/create-account', [LoginController::class, 'create']);
$router->post('/create-account', [LoginController::class, 'create']);

// Confirmar cuenta.
$router->get('/confirm-account', [LoginController::class, 'confirm']);
$router->get('/mensaje', [LoginController::class, 'mensaje']);

// Area privada.
$router->get('/citas', [CitasController::class, 'index']);
$router->get('/admin', [AdminController::class, 'index']);

// API de Citas.
$router->get('/api/servicios', [APIController::class, 'index']);
$router->post('/api/citas', [APIController::class, 'guardarCita']);
$router->post('/api/eliminar', [APIController::class, 'eliminar']);

// CRUD de Servicios.
$router->get('/servicios', [ServicioController::class, 'index']);
$router->get('/servicios/crear', [ServicioController::class, 'crear']);
$router->post('/servicios/crear', [ServicioController::class, 'crear']);
$router->get('/servicios/actualizar', [ServicioController::class, 'actualizar']);
$router->post('/servicios/actualizar', [ServicioController::class, 'actualizar']);
$router->post('/servicios/eliminar', [ServicioController::class, 'eliminar']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();