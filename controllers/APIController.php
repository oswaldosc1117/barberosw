<?php

namespace Controllers;

use Models\ActiveRecord;
use Models\Citas;
use Models\CitasServicios;
use Models\Servicios;

class APIController{
    public static function index(){
        $servicios = Servicios::all();
        echo json_encode($servicios);
    }

 
    public static function guardarCita(){
        // Almacena la cita y devuelve en ID.
        $cita = new Citas($_POST);
        $resultado = $cita->guardar();

        $id = $resultado['id'];

        // Almacena los servicios con el ID de la cita.
        $idServicios = explode(",", $_POST['servicios']);

        foreach($idServicios as $idServicio){
            $argumentos = ['citasID' => $id, 'serviciosID' => $idServicio];

            $citasServicios = new CitasServicios($argumentos);
            $citasServicios->guardar();
        }

        echo json_encode(['resultado' => $resultado]);
    }


    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $_POST['id'];

            $cita = Citas::find($id);
            $cita->eliminar();

            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
    }
}