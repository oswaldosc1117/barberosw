<?php

namespace Models;

class Servicios extends ActiveRecord{

    protected static $tabla = 'servicios';
    protected static $columnasDB = ['id', 'servicio', 'precio'];

    public $id;
    public $servicio;
    public $precio;

    public function __construct($argumentos = []){
        $this->id = $argumentos['id'] ?? null;
        $this->servicio = $argumentos['servicio'] ?? '';
        $this->precio = $argumentos['precio'] ?? '';
    }

    public function validar(){
        if(!$this->servicio){
            self::$alertas['error'][] = 'El Nombre del Servicio es Obligatorio';
        }

        if(!$this->precio){
            self::$alertas['error'][] = 'El Precio del Servicio es Obligatorio';
        }

        if(!is_numeric($this->precio)){
            self::$alertas['error'][] = 'El formato del precio no es válido';
        }
        
        return self::$alertas;
    }
}