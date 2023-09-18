<?php

namespace Models;

class Citas extends ActiveRecord{
    // Base de Datos
    protected static $tabla = 'citas';
    protected static $columnasDB = ['id', 'fecha', 'hora', 'usuariosID'];

    public $id;
    public $fecha;
    public $hora;
    public $usuariosID;

    public function __construct($argumentos = []){
        $this->id = $argumentos['id'] ?? null;
        $this->fecha = $argumentos['fecha'] ?? '';
        $this->hora = $argumentos['hora'] ?? '';
        $this->usuariosID = $argumentos['usuariosID'] ?? '';
    }
}