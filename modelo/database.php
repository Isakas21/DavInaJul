<?php
include "IDatabase.php";
include_once "config/config.php";

class Database implements IDatabase
{

    private $conexion;

    public function conectar()
    {
        try {
            $this->conexion = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USER, DB_PASS); // Se puede configurar el objeto
            $this->conexion->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
            $this->conexion->exec("set names utf8");
            //$this->conexion = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
            return ($this->conexion);
        } catch (PDOException $e) {
            echo " <p>Error: " . $e->getMessage() . "</p>\n";
            exit();
        }
    }

    public function desconectar()
    {
        $this->conexion = null;
    }

    public function ejecutarSql($sql)
    {

        $result = $this->conectar()->query($sql);
        return $result;
    }

    public function ejecutarSqlActualizacion($sql,$args)
    {
        $result = $this->conectar()->prepare($sql);
        $result->execute($args);
    }
}
