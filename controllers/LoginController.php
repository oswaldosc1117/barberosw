<?php

namespace Controllers;

use Classes\Email;
use Models\Usuarios;
use MVC\Router;

class LoginController{

    public static function login(Router $router){
        $alertas = [];
        $auth = new Usuarios();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuarios($_POST);
            $alertas = $auth->validarLogin();
        

            if(empty($alertas)){
                // Comprobar que existe el usuario.
                $usuario = Usuarios::where('email', $auth->email); 
                
                if($usuario){
                    // Verificar el password.
                    if($usuario->verificarPassword($auth->password)){
                        // Autenticar al usuario.
                        isSession();

                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        // Redireccionamiento para admins o clientes.
                        if($usuario->admin === "1"){
                            $_SESSION['admin'] = $usuario->admin ?? null;

                            header('Location: /admin');
                        } else{
                            // Clientes.
                            header('Location: /citas');
                        }
                    }
                } else{
                    Usuarios::setAlerta('error', 'El Usuario no Existe');
                }
            }
        }

        $alertas = Usuarios::getAlertas();

        $router->render('auth/login', ['alertas' => $alertas, 'auth' => $auth]);
    }


    public static function logout(){
        session_start();

        $_SESSION = [];

        header('Location: /');
    }


    public static function forget(Router $router){
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuarios($_POST);
            $alertas = $auth->validarEmail();

            if(empty($alertas)){
                $usuario = Usuarios::where('email', $auth->email);

                if($usuario && $usuario->confirmado === "1"){
                    // Generar un token.
                    $usuario->generarToken();
                    $usuario->guardar();

                    // Enviar E-mail.
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->enviarInstrucciones();

                    // Alerta de exito.
                    Usuarios::setAlerta('exito', 'Un codigo de recuperacion ha sido enviado a tu correo');

                } else{
                    Usuarios::setAlerta('error', 'El usuario no existe o no esta confirmado');
                }
            }
        }

        $alertas = Usuarios::getAlertas();

        $router->render('auth/forget', ['alertas' => $alertas]);
    }


    public static function recovery(Router $router){
        $alertas = [];
        $error = false;

        $token = s($_GET['token']);
        
        // Buscar usuario por su token
        $usuario = Usuarios::where('token', $token);

        if(empty($usuario)){
            Usuarios::setAlerta('error', 'Token no valido');
            $error = true;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            // Leer el nuevo password y guardarlo
            $password = new Usuarios($_POST);
            $alertas = $password->recuperarPassword();

            if(empty($alertas)){
                $usuario->password = null;

                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = null;
                
                $resultado = $usuario->guardar();
                if($resultado){
                    header('Location: /');
                }
            }
        }

        $alertas = Usuarios::getAlertas();

        $router->render('auth/recovery', ['alertas' => $alertas, 'error' => $error]);
    }


    public static function create(Router $router){
        $usuario = new Usuarios;
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarCuenta();

            // Revisar que el array de $alertas este vacio.
            if(empty($alertas)){
                // Verificar si el usuario no esta registrado.
                $resultado = $usuario->existeUsuario();

                if($resultado->num_rows){
                    $alertas = Usuarios::getAlertas();
                } else{
                    // Hashear password.
                    $usuario->hashPassword();

                    // Generar un token unico.
                    $usuario->generarToken();

                    // Enviar un email.
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token); // NG - 1.
                    $email->enviarConfirmacion();

                    // Crear el usuario.
                    $resultado = $usuario->guardar();

                    if($resultado){
                        header('Location: /mensaje');
                    }
                }
            }
        }

        $router->render('auth/create-account', ['usuario' => $usuario, 'alertas' => $alertas]);
    }


    public static function mensaje(Router $router){
        $router->render('auth/mensaje');
    }


    public static function confirm(Router $router){
        $alertas = [];
        $token = s($_GET['token']);
        $usuario = Usuarios::where('token', $token);

        if(empty($usuario)){
            // Mostrar mensaje de error.
            Usuarios::setAlerta('error', 'Token no Válido');
        } else{
            // Usuario confirmado
            $usuario->confirmado = "1";
            $usuario->token = null;
            $usuario->guardar();
            Usuarios::setAlerta('exito', 'Cuenta Comprobada Correctamente');
        }

        // Obtener alertas.
        $alertas = Usuarios::getAlertas();

        // Renderizar la vista.
        $router->render('auth/confirm-account', ['alertas' => $alertas]);
    }
}

/** NOTAS GENERALES
 * 
 * 1.- Al poseer una clase como public, puedo instanciarla desde cualquier parte. No obstante, puedo pasar adicionalmente atributos de otras clases en dicha clase
 * nueva.
*/