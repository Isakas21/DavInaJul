<?php

include_once "modelo/database.php";

class DaoClientes{

    private $db;

    public function __construct()
    {
       $this->db = new Database();
    }

    public function checkLogin($nombre, $password){
        $this->db->conectar();
        $consulta = "SELECT `Nombre` FROM `Clientes` WHERE Nombre = '$nombre' AND Password = '$password'";
        $result = $this->db->ejecutarSql($consulta);
        if(!$result->fetch()){
            echo "<script type='text/javascript'> alert('Usuario/Contraseña incorrecto');</script>";
            $this->db->desconectar();
            return false;
        }
        else {
            $this->db->desconectar();
            return true;
        }
    }

    public function registrarse($nombre, $password){
        $this->db->conectar();
        $insertar = "INSERT INTO `Clientes` (`Nombre`,`Password`) VALUES ('$nombre','$password')";
        $args = array();
        $result = $this->db->ejecutarSqlActualizacion($insertar,$args);
        $this->db->desconectar();
        
    }
}
