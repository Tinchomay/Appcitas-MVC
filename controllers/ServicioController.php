<?php 

namespace Controllers;

use Model\Servicio;
use Model\Usuario;
use MVC\Router;

class ServicioController {
    public static function index(Router $router){
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
        if(isset($_SESSION['login'])) {
            if(!$_SESSION['admin']) {
                header('Location: /');
            }
        } else {
            header('Location: /');
        }
        $aviso = $_GET['aviso'] ?? '';
        $servicios = Servicio::all();

        $router->render('servicios/index', [
            'nombre' => $_SESSION['nombre'],
            'servicios' => $servicios,
            'aviso' => $aviso
        ]);
    }

    public static function actualizar(Router $router){
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
        if(isset($_SESSION['login'])) {
            if(!$_SESSION['admin']) {
                header('Location: /');
            }
        } else {
            header('Location: /');
        }
        $id = s($_GET['id']);
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: /servicios');
        }
        $servicio = Servicio::find($id);
        if(!$servicio) {
            header('Location: /servicios');
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio->sincronizar($_POST);

            $alertas = $servicio->validar();

            if (empty($alertas)) {

                $resultado = $servicio->guardar();

                if($resultado) {
                    Usuario::setAlerta('exito', 'Servicio actualizado correctamente');
                    $servicio = new Usuario();
                }
            }
        }

        $alertas = Servicio::getAlertas();


        $router->render('servicios/actualizar', [
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
        
    }

    public static function eliminar (){
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
        if(isset($_SESSION['login'])) {
            if(!$_SESSION['admin']) {
                header('Location: /');
            }
        } else {
            header('Location: /');
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = s($_POST['id']);
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if (!$id) {
                header('Location: /servicios');
            }
            $servicio = Servicio::find($id);
            if(!$servicio) {
                header('Location: /servicios');
            }
            
            $resultado = $servicio->eliminar();

            if($resultado) {
                header('Location: /servicios?aviso=1');
            }
        }

    }

    public static function crear (Router $router){
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
        if(isset($_SESSION['login'])) {
            if(!$_SESSION['admin']) {
                header('Location: /');
            }
        } else {
            header('Location: /');
        }
        $servicio = new Servicio();
        $alertas = Servicio::getAlertas();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validar();
            
            if(empty($alertas)) {
               $resultado = $servicio->guardar();
               if($resultado) {
                Servicio::setAlerta('exito', 'Servicio creado correctamente');
                $servicio = new Servicio();
               }
            }

        }
        $alertas = Servicio::getAlertas();
        $router->render('servicios/crear', [
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }
}