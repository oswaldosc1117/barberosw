<?php

namespace Models;

class AdminCita extends ActiveRecord{
    protected static $tabla = 'citasservicios';
    protected static $columnasDB = ['id', 'hora', 'cliente', 'email', 'telefono', 'servicio', 'precio'];

    public $id;
    public $hora;
    public $cliente;
    public $email;
    public $telefono;
    public $servicio;
    public $precio;

    public function __construct($argumentos = []){
       $this->id = $argumentos['id'] ?? null; 
       $this->hora = $argumentos['hora'] ?? ''; 
       $this->cliente = $argumentos['cliente'] ?? ''; 
       $this->email = $argumentos['email'] ?? ''; 
       $this->telefono = $argumentos['telefono'] ?? ''; 
       $this->servicio = $argumentos['servicio'] ?? ''; 
       $this->precio = $argumentos['precio'] ?? ''; 
    }
}