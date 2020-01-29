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
            $this->db->desconectar();
            echo "<script type='text/javascript'> alert('Usuario/Contraseña incorrecto');</script>";
            return false;
        }
        else {
            $this->db->desconectar();
            return true;
        }
    }
}
?>