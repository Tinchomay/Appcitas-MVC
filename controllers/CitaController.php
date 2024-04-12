<?php 

namespace Controllers;

use MVC\Router;

class CitaController {

    public static function index(Router $router) {
        if(session_status() == PHP_SESSION_NONE){
            // Si no hay ninguna sesión iniciada, inicia una
            session_start();
        }
        if(!isset($_SESSION['login'])) {
            header('Location: /');
        }
        if($_SESSION['admin'] == 1){
            header('Location: /admin'); 
        }

        $nombre = $_SESSION['nombre'] ?? '';
        $id = $_SESSION['id'] ?? '';

        $router->render('cita/index', [
            'nombre' => $nombre,
            'id' => $id
        ]);
    }
}