<?php
class Cliente
{

    private $nombre;
    private $contraseña;
    
    function __construct($nombre, $contraseña)
    {
        $this->nombre = $nombre;
        $this->contraseña = $contraseña;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getContraseña()
    {
        return $this->contraseña;

    }
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }
    
    public function setContraseña($contraseña)
    {
        $this->contraseña = $contraseña;

        return $this;
    }
}

?>