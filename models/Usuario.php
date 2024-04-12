<?php

namespace Model;

class Usuario extends ActiveRecord {

    public static $tabla = 'usuarios';
    public static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token = $args['token'] ?? '';
    }

    public function validar() {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'Falta el nombre';
        }
        if (!$this->apellido) {
            self::$alertas['error'][] = 'Falta el apellido';
        }
        if (!$this->telefono) {
            self::$alertas['error'][] = 'Falta el telefono';
        }
        if (strlen($this->telefono) < 10) {
            self::$alertas['error'][] = 'El telefono tiene que ser de 10 digitos';
        }

        if ($this->email){
            $patron = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
            if (!preg_match($patron, $this->email)){
                self::$alertas['error'][] = 'El formato del correo no es valido';
            }
        } else {
            self::$alertas['error'][] = 'Falta el email';
        }
        
        if ($this->password){
            if (strlen($this->password) < 8) {
                self::$alertas['error'][] = 'El password tiene que tener 8 caracteres o mas';
            }
        } else {
            self::$alertas['error'][] = 'Falta el password';
        }  

        //Si ponemos este return solo vasta guardar el resultado en una variable y pasarla con render, no necesitamos llamar a la funcion para obtener los errores
        return self::$alertas;
    }

    public function validarLogin() {
        if ($this->email){
            $patron = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
            if (!preg_match($patron, $this->email)){
                self::$alertas['error'][] = 'El formato del correo no es valido';
            }
        } else {
            self::$alertas['error'][] = 'Falta el email';
        }

        if ($this->password){
            if (strlen($this->password) < 8) {
                self::$alertas['error'][] = 'El password tiene que tener 8 caracteres o mas';
            }
        } else {
            self::$alertas['error'][] = 'Falta el password';
        }        
        
        
        return self::$alertas;
    }

    //Revisar si el usuario ya existe
    public function existeUsuario() {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE email = '" .  $this->email . "' LIMIT 1;";
        
        $resultado = self::$db->query($query);

        if($resultado->num_rows){
            self::$alertas['error'][] = 'El usuario ya existe';
        }  
        
        return $resultado;
    }

    public function hashPassword() {
        //Asigna el nuevo valor al objeto
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    }

    public function generarToken(){
        //Uniqid genera una serie de numeros aleatorios que son perfectos para comprobar un token
        $this->token = uniqid();
    }
    public function comprobarPassVer($contrausuario){
        $resultado = password_verify($contrausuario, $this->password);
        
        if(!$this->confirmado || !$resultado) {
            self::$alertas['error'][] = 'La contraseña es incorrecta o el usuario no esta confirmado';
        }   else {
            return true;
        }
    }

    public function validarOlvide() {
        if ($this->email){
            $patron = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
            if (!preg_match($patron, $this->email)){
                self::$alertas['error'][] = 'El formato del correo no es valido';
            }
        } else {
            self::$alertas['error'][] = 'Falta el email';
        }

        return self::$alertas;
    }

    public function validarPassword() {
        if ($this->password){
            if (strlen($this->password) < 8) {
                self::$alertas['error'][] = 'El password tiene que tener 8 caracteres o mas';
            }
        } else {
            self::$alertas['error'][] = 'Falta el password';
        }  

        return self::$alertas;
    }
}