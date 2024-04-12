<?php

namespace Controllers;

use Model\Cita;
use Model\CitasServicios;
use Model\Servicio;

class APIController {

    public static function index() {
        $servicios = Servicio::all();
        //Json encode convierte en JSON los array y objetos que extraimos de la BD
        echo json_encode($servicios);//Hacemos echo para que se puedan ver
    }

    public static function guardar() {

        //Almacena la cita y devuelve el resultado y el id insertado
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();

        //Almacenar citasServicios
        $id = $resultado['id'];
        //Separando los servicios con explode
        $idServicios = explode(",", $_POST['servicios']);
        //Aplicamos un foreach para que guarde los multiples registros si hay varios servicios
        foreach($idServicios as $idServicio) {
            $args = [
                'citaId' => $id,
                'servicioId' => $idServicio
            ];
            $citaServicio = new CitasServicios($args);
            $citaServicio->guardar();
        }
        //Mandamos la respuesta del active record, recordando que va a ser un array que posteriormente sera convertida a un objeto con la funcion asincrona de JS
        echo json_encode(['resultado' => $resultado]);
    }

    public static function eliminar() {
        //Eliminar cita
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //Validando entero
            $id = s($_POST['id']);
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if(!$id) {
                header('Location: /error');
            }
            $cita = Cita::where('id', $id);
            if(!$cita) {
                header('Location: /error');
            }
            $cita->eliminar();
            //Con este valor redireccionamos al usuario a la pagina donde estaba antes
            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
        }
}