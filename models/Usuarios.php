<?php

namespace Models;

class Usuarios extends ActiveRecord{
    // Base de Datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token', 'recovery'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;
    public $recovery;

    public function __construct($argumentos = []){
        $this->id = $argumentos['id'] ?? null;
        $this->nombre = $argumentos['nombre'] ?? '';
        $this->apellido = $argumentos['apellido'] ?? '';
        $this->email = $argumentos['email'] ?? '';
        $this->password = $argumentos['password'] ?? '';
        $this->telefono = $argumentos['telefono'] ?? '';
        $this->admin = $argumentos['admin'] ?? 0;
        $this->confirmado = $argumentos['confirmado'] ?? 0;
        $this->token = $argumentos['token'] ?? '';
        $this->recovery = $argumentos['recovery'] ?? '';
    }

    // Mensajes de Validacion para la creacion de una cuenta
    public function validarCuenta(){ // NG - 1.

        if(!$this->nombre && !$this->apellido && !$this->email && !$this->password){
            self::$alertas['error'][] = 'Todos los campos son Obligatorios';
        }
        
        elseif(!$this->nombre || !$this->apellido || !$this->email || !$this->password){
            if(!$this->nombre){
                self::$alertas['error'][] = 'El Nombre es Obligatorio';
            }
    
            if(!$this->apellido){
                self::$alertas['error'][] = 'El Apellido es Obligatorio';
            }
    
            if(!$this->email){
                self::$alertas['error'][] = 'Debes proporcionar una dirección de Correo';
            }
    
            if(!$this->password){
                self::$alertas['error'][] = 'Debes proporcionar una Contraseña';
            }
        }
            
        if($this->password && strlen($this->password) > 1 && strlen($this->password) < 6){
            self::$alertas['error'][] = 'La contraseña debe tener al menos 6 caracteres';
        }

        return self::$alertas;
    }


    // Mensajes de validacion para el inicio de sesion
    public function validarLogin(){

        if(!$this->email && !$this->password){
            self::$alertas['error'][] = 'Todos los campos son Obligatorios';
        }

        elseif(!$this->email || !$this->password){
            if(!$this->email){
                self::$alertas['error'][] = 'El E-Mail es Obligatorio';
            }
    
            if(!$this->password){
                self::$alertas['error'][] = 'La Contraseña es Obligatoria';
            }
        }
        
        return self::$alertas;
    }


    // Mensajes de validacion para comprobar el email en el caso de que haya que recuperar la cuenta
    public function validarEmail(){
        if(!$this->email){
            self::$alertas['error'][] = 'El E-Mail es Obligatorio';
        }

        return self::$alertas;
    }


    // Mensajes para recuperar el password en caso de que el usuario la haya olvidado
    public function recuperarPassword(){
        if(!$this->password){
            self::$alertas['error'][] = 'La contraseña es Obligatoria';
        }
        
        elseif(strlen($this->password) < 6){
            self::$alertas['error'][] = 'La contraseña debe tener al menos 6 caracteres';
        }
        
        elseif($this->password && !$this->recovery){
            self::$alertas['error'][] = 'Debes confirmar tu contraseña';
        }
        
        elseif($this->password != $this->recovery){
            self::$alertas['error'][] = 'Las contraseñas no son iguales';
        }

        return self::$alertas;
    }


    // Confirmar si el usuario ya existe en BD
    public function existeUsuario(){
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

        $resultado = self::$db->query($query);

        if($resultado->num_rows){
            self::$alertas['error'][] = 'El usuario ya existe';
        }

        return $resultado;
    }


    // Hashear Password
    public function hashPassword(){
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }


    // Generar un Token
    public function generarToken(){
        $this->token = uniqid();
    }

    // Verificar password
    public function verificarPassword($password){
        $resultado = password_verify($password, $this->password);

        if(!$resultado || !$this->confirmado){
            self::$alertas['error'][] = 'Tú clave es Incorrecta o tú cuenta aún no ha sido confirmada';
        } else{
            return true;
        }
    }
}

/** NOTAS GENERALES
 * 
 * 1.- En las alertas, se emplean dos corchetes dado que el 1ero hace alusion al tipo del mensaje, mientras que el 2do mostrara el mensaje de error correspondiente.
 */