<?php

include_once "modelo/database.php";
include_once "clases/clientes.php";

class DaoClientes{

    private $db;

    public function __construct()
    {
       $this->db = new Database();
    }

    /**
     * Comprueba si el usuario insertado esta en la base de datos.
     *
     * @author	Davinajul
     * @since	v0.0.1
     * @version	v1.0.0	Friday, February 7th, 2020.
     * @access	public
     * @param	mixed	$cliente	
     * @return	void
     */
    public function checkLogin($cliente){
        $this->db->conectar();
        $nombre = $cliente->getNombre();
        $password = $cliente->getContraseña();
        $consulta = "SELECT `Nombre` FROM `Clientes` WHERE Nombre = '$nombre' AND Password = '$password'";
        $result = $this->db->ejecutarSql($consulta);
        if(!$result->fetch()){
            $this->db->desconectar();
            return false;
        }
        else {
            $this->db->desconectar();
            return true;
        }
    }

    /**
     * Añade el usuario insertado a la base de datos.
     *
     * @author	Davinajul
     * @since	v0.0.1
     * @version	v1.0.0	Friday, February 7th, 2020.
     * @access	public
     * @param	mixed	$cliente	
     * @return	void
     */

    public function registrarse($cliente){
        $this->db->conectar();
        $nombre = $cliente->getNombre();
        $password = $cliente->getContraseña();
        $insertar = "INSERT INTO `Clientes` (`Nombre`,`Password`) VALUES ('$nombre','$password')";
        $args = array();
        $result = $this->db->ejecutarSqlActualizacion($insertar,$args);
        $this->db->desconectar();
        
    }
}
