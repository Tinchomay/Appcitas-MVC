<?php
namespace Controllers;

use MVC\Router;
use Model\AdminCita;
class AdminController {
    public static function index(Router $router) {
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
        if(isset($_GET['fecha'])) {
            $fecha = s($_GET['fecha']);
            $fechaArray = explode('-', $fecha);
        
            if(count($fechaArray) == 3) {
                list($year, $month, $day) = $fechaArray;
                if(checkdate($month, $day, $year)) {
                    $fecha = $_GET['fecha'];
                } else {
                    header('Location: /admin');
                }
            } else {
                header('Location: /admin');
            }
        } else {
            $fecha = date('Y-m-d');
        }

        //Consultar la base de datos
        $consulta = "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
        $consulta .= " FROM citas  ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON citas.usuarioId=usuarios.id  ";
        $consulta .= " LEFT OUTER JOIN citasservicios ";
        $consulta .= " ON citasservicios.citaId=citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id=citasservicios.servicioId ";
        $consulta .= " WHERE fecha =  '{$fecha}' ORDER BY TIME(citas.hora) ASC";

        $citas = AdminCita::SQL($consulta);

        $router->render('admin/index', [
            'nombre' => $_SESSION['nombre'],
            'citas' => $citas,
            'fecha' => $fecha
        ]);
    }
}