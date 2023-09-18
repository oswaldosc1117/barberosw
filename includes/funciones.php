<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

// Comprobar el inicio de sesion
function isSession(): void{
    if(!isset($_SESSION)){
        session_start();
    }
}

// Comprobar si es el ultimo elemento de una iteracion foreach para calcular el total del costo de los servicios.
function esUltimo(string $actual, string $proximo): bool{
    if($actual !== $proximo){
        return true;
    } else{
        return false;
    }
}

// Comprobar que el usuario esta autenticado para que no pueda acceder a paginas que requieren de un inicio de sesion.
function isAuth(): void{
    if(!isset($_SESSION['login'])){
        header('Location: /');
    }
}


function isAdmin(): void{
    if(!isset($_SESSION['admin'])){
        header('Location: /');
    }
}