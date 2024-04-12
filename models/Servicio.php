<?php


namespace Model;

class Servicio extends ActiveRecord{
    //BD
    protected static $tabla = 'servicios';
    protected static $columnasDB = ['id', 'nombre', 'precio'];

    public $id;
    public $nombre;
    public $precio;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->precio = $args['precio'] ?? '';
    }

    public function validar() {
        if(!$this->nombre){
            self::$alertas['error'][] = 'Falta el nombre';
        }

        //Numeric revisa si es un numero
        if(is_numeric($this->precio)) {
            if (strlen( $this->precio ) > 8){
                self::$alertas['error'][] = 'El precio solo puede tener hasta 8 digitos';
            }
        } else {
            self::$alertas['error'][] = 'Falta el precio';
        }
        return self::$alertas;
    }
}