<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;


class LoginController {

    public static function login(Router $router) {
        //Si ya inicio session lo mandamos a las citas
        if(session_status() == PHP_SESSION_NONE){
        //Si no hay ninguna sesión iniciada, inicia una
            session_start();
        }
        //Redireccion si ya inicio sesion
        if(isset($_SESSION['login']) && !$_SESSION['admin']) {
            header('Location: /cita');
        }
        if(isset($_SESSION['login']) && $_SESSION['admin']) {
            header('Location: /admin');
        }

        $auth = new Usuario;
        $alertas = Usuario::getAlertas();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $auth = new usuario($_POST['usuario']);
            $alertas = $auth->validarLogin();

            if(empty($alertas)) {
                $usuario = Usuario::where('email', $auth->email);

                if ($usuario) {
                    if($usuario->comprobarPassVer($auth->password)) {
                        //Crear variables de sesion
                        session_start();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;
                        $_SESSION['admin'] = $usuario->admin;

                        //Redireccionar si es admin
                        if ($usuario->admin === '1'){
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('Location: /admin');
                        } else{
                            header('Location: /cita');
                        }
                    }
                } else {
                    Usuario::setAlerta('error', 'El usuario no existe');
                }
            }
        }
        $alertas = Usuario::getAlertas();

        $router->render('auth/login', [
            'auth' => $auth,
            'alertas' => $alertas
        ]);

    }
    public static function crear(Router $router) {

        $usuario = new Usuario;

        $alertas = Usuario::getAlertas();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $usuario = new usuario($_POST['usuario']);
            $alertas = $usuario->validar();

            if(empty($alertas)) {

                $resultado = $usuario->existeUsuario();
                
                if($resultado->num_rows){
                    $alertas = Usuario::getAlertas();
                } else{
                    // Hash pass
                    $usuario->hashPassword();

                    //Generar token unico
                    $usuario->generarToken();

                    //Enviar correo
                    $email = new Email ($usuario->email, $usuario->nombre, $usuario->token);

                    $email->enviarConfirmacion();

                    //Crear usuario
                    $resultado = $usuario->guardar();
                    if ($resultado) {
                        header('Location: /mensaje');
                    }
                    
                }
            }
        }

        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }
    public static function logout(Router $router) {
        session_start();
        $_SESSION = [];
        header('Location: /');
    }
    public static function olvide(Router $router) {

        $alertas = Usuario::getAlertas();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST['usuario']);
            $alertas = $auth->validarOlvide();

            if(empty($alertas)) {
                $usuario = Usuario::where('email', $auth->email);
                //Validando que existe y este confirmado
                if($usuario && $usuario->confirmado === '1') {
                    //Generar token para recupera contraseña
                    $usuario->generarToken();
                    $usuario->guardar();

                    // Enviar email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();
                    
                    Usuario::setAlerta('exito', 'Correo de recuperacion enviado correctamente, revisa tu email');
                } else {
                    Usuario::setAlerta('error', 'El usuario no existe o no esta confirmado');
                }
            } 
        }

        $alertas = Usuario::getAlertas();
        
        $router->render('auth/olvide', [
            'alertas' => $alertas
        ]);
    }
    public static function recuperar(Router $router) {
        $error = false;
        $completo = false;
        $alertas = Usuario::getAlertas();
        //Sanitizando con la funcion s 
        $token = s($_GET['token']);
        $usuario = Usuario::where('token', $token);
        if(empty($usuario)) {
            Usuario::setAlerta('error', 'Token no valido');
            $error = true;
        } 
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $password = new Usuario($_POST['usuario']);
            $alertas = $password->validarPassword();

            if(empty($alertas)) {
                $usuario->password = null;
                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = null;

                $resultado = $usuario->guardar();
                $resultado = true;
                if($resultado) {
                    Usuario::setAlerta('exito', 'Contraseña restablecida correctamente');
                    $completo = true;
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar', [
            'alertas' => $alertas,
            'error' => $error,
            'completo' => $completo
        ]);
    }
    public static function mensaje(Router $router) {

        $router->render('auth/mensaje', [

        ]);

    }
    public static function confirmar (Router $router) {
        $alertas = Usuario::getAlertas();

        //Sanitizando con la funcion s 
        $token = s($_GET['token']);

        $usuario = Usuario::where('token', $token);

        if(empty($usuario)) {

            Usuario::setAlerta('error', 'Token no valido');

        } else{
            $usuario->confirmado = '1';
            $usuario->token = null;

            //Como aqui hay un ID, esto va a actualizar el registro
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta confirmada correctamente');
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas
        ]);

    }

}