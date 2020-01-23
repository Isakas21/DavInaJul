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
    
 
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function setImagen($imagen)
    {
        $this->imagen = $imagen;

        return $this;
    }
}
?>