<?php

namespace Controllers;

use Models\Servicios;
use MVC\Router;

class ServicioController{
    public static function index(Router $router){
        isSession();
        isAdmin();

        $servicios = Servicios::all();

        $router->render('servicios/index', ['nombre' => $_SESSION['nombre'], 'servicios' => $servicios]);
    }


    public static function crear(Router $router){
        isSession();
        isAdmin();

        $servicio = new Servicios;
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validar();

            if(empty($alertas)){
                // Alerta de Exito.
                $servicio->guardar();
                Servicios::setAlerta('exito', 'Servicio Creado Correctamente');

                header('refresh: 2, /servicios');
            }
        }

        $alertas = Servicios::getAlertas();

        $router->render('servicios/crear', ['nombre' => $_SESSION['nombre'], 'servicio' => $servicio, 'alertas' => $alertas]);
    }


    public static function actualizar(Router $router){
        isSession();
        isAdmin();

        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

        if(!$id){
            header('Location: /servicios');
        }

        $servicio = Servicios::find($id);
        $alertas = [];
        

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $servicio->sincronizar($_POST);

            $alertas = $servicio->validar();
            if(empty($alertas)){

                $servicio->guardar();
                
                // Alerta de Exito.
                Servicios::setAlerta('exito', 'Servicio Actualizado Correctamente');

                header('refresh: 2, /servicios');
            }
        }

        $alertas = Servicios::getAlertas();

        $router->render('servicios/actualizar', ['nombre' => $_SESSION['nombre'], 'servicio' => $servicio, 'alertas' => $alertas]);
    }


    public static function Eliminar(){
        isSession();
        isAdmin();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $_POST['id'];
            $servicio = Servicios::find($id);
            $servicio->eliminar();
            
            header('Location: /servicios');
        }
    }
}


