<?php

namespace Controllers;

use Models\ActiveRecord;
use Models\AdminCita;
use MVC\Router;

class AdminController extends ActiveRecord{

    public static function index(Router $router){
        isSession(); // Comprueba si ya existe un inicio de sesion activo.
        isAdmin();

        $fecha = $_GET['fecha'] ?? date('Y-m-d'); // Busca una fecha via GET. Sino la encuentra, muestra la fecha del servidor. Es decir, la del dia actual.
        $fechas = explode('-', $fecha);

        if(!checkdate($fechas[1], $fechas[2], $fechas[0])){
            header('Location: /404');
        };


        // Comprueba la BD.
        $consulta = "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.servicio as servicio, servicios.precio  ";
        $consulta .= " FROM citas  ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON citas.usuariosID=usuarios.id  ";
        $consulta .= " LEFT OUTER JOIN citasServicios ";
        $consulta .= " ON citasServicios.citasID=citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id=citasServicios.serviciosID ";
        $consulta .= " WHERE fecha = '{$fecha}' ";

        $citas = AdminCita::SQL($consulta);

        
        $router->render('admin/index', ['nombre' => $_SESSION['nombre'], 'citas' => $citas, 'fecha' => $fecha]);
    }
}