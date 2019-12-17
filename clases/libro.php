<?php
class Libro
{

    private $titulo;
    private $descripcion;
    private $fecha;
    private $imagen;
    
    function __construct($titulo, $descripcion, $fecha, $imagen)
    {
        $this->titulo = $titulo;
        $this->descripcion = $descripcion;
        $this->fecha = $fecha;
        $this->imagen = $imagen;
    }

    public function getTitulo()
    {
        return $this->titulo;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }
    
    public function getFecha()
    {
        return $this->fecha;
    }

    public function getImagen()
    {
        return $this->imagen;
    }
    
}
?>