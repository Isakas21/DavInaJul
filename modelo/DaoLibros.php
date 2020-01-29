<?php

include "modelo/database.php";
include_once "clases/libro.php";

class DaoLibros
{

    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function mostrarLibros()
    {
        $this->db->conectar();
        $consulta = "SELECT * FROM `libros`";
        $result = $this->db->ejecutarSql($consulta);
        if (!$result) {
            $this->db->desconectar();
            echo "<p>Error en la consulta.</p>";
        } else {
            while ($libro = $result->fetch()) {
                $libros[] = $libro;
            }
            $this->db->desconectar();
            return $libros;
        }
    }

    

    public function existeLibro($titulo, $descripcion)
    {
        $this->db->conectar();
        $consulta = "SELECT * FROM `libros`";
        $result = $this->db->ejecutarSql($consulta);
        if (!$result) {
            $this->db->desconectar();
            echo "<p>Error en la consulta.</p>";
        } else {
            $listaLibros = $result->fetchAll();
            if(in_array($titulo, $listaLibros) && in_array($descripcion, $listaLibros)){
                return true;
            }
            else{
                return false;
            }
        }
    }

    public function insertarLibros($libro)
    {
        $insertar = "INSERT INTO `libros` (`Titulo`,`Descripcion`,`Fecha`,`Imagen`)
        VALUES ('','Libro para aprender jQuery',CURRENT_DATE,'img/jQuery.jpg')";
    }
}
