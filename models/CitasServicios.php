<?php

namespace Models;

class CitasServicios extends ActiveRecord{

    // Base de Datos.
    protected static $tabla = 'citasservicios';
    protected static $columnasDB = ['id', 'citasID', 'serviciosID'];

    public $id;
    public $citasID;
    public $serviciosID;

    public function __construct($argumentos = []){
        $this->id = $argumentos['id'] ?? null;
        $this->citasID = $argumentos['citasID'] ?? '';
        $this->serviciosID = $argumentos['serviciosID'] ?? '';
    }
}