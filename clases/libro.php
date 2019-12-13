<?php
class Libro
{

    private $titulo;
    private $descripcion;
    private $categoria;
    private $fecha;
    private $imagen;

    function __construct($titulo, $descripcion, $categoria, $fecha, $imagen)
    {
        $this->titulo = $titulo;
        $this->descripcion = $descripcion;
        $this->categoria = $categoria;
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

    public function getCategoria()
    {
        return $this->categoria;
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