<?php

require "modelo/Database.php";
require_once "clases/libro.php";

class DaoLibros
{

    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * mostrarLibros.
     *
     * @author	Davinajul
     * @since	v0.0.1
     * @version	v1.0.0	Friday, February 7th, 2020.
     * @access	public
     * @return	void
     */
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



    /**
     * existeLibro.
     *
     * @author	Davinajul
     * @since	v0.0.1
     * @version	v1.0.0	Friday, February 7th, 2020.
     * @access	public
     * @param	mixed	$titulo	
     * @return	void
     */
    public function existeLibro($titulo)
    {
        $this->db->conectar();
        $consulta = "SELECT * FROM `libros`";
        $result = $this->db->ejecutarSql($consulta);
        if (!$result) {
            $this->db->desconectar();
            echo "<p>Error en la consulta.</p>";
        } else {
    
            $listaLibros = $result->fetchAll(PDO::FETCH_ASSOC);
            foreach ($listaLibros as $libro) {
                if ($libro['Titulo'] == $titulo) {
                    $this->db->desconectar();
                    return true;
                }
            }
            $this->db->desconectar();
            return false;
        }
    }

    /**
     * insertarLibros.
     *
     * @author	Davinajul
     * @since	v0.0.1
     * @version	v1.0.0	Friday, February 7th, 2020.
     * @access	public
     * @param	mixed	$libro	
     * @return	void
     */
    public function insertarLibros($libro)
    {
        $this->db->conectar();
        $insertar = "INSERT INTO `libros` (`Titulo`,`Descripcion`,`Fecha`,`Imagen`) VALUES ("."'". $libro->getTitulo()."','".$libro->getDescripcion()."',".$libro->getFecha().",'".$libro->getImagen()."'".")";
        $args = array();
        $result = $this->db->ejecutarSqlActualizacion($insertar,$args);
        $this->db->desconectar();
    }

    /**
     * borrarLibro.
     *
     * @author	Davinajul
     * @since	v0.0.1
     * @version	v1.0.0	Friday, February 7th, 2020.
     * @access	public
     * @param	mixed	$titulo	
     * @return	void
     */
    public function borrarLibro($titulo)
    {
        $this->db->conectar();
        $borrar = "DELETE FROM `libros` WHERE `titulo` =  "."'".$titulo."'";
        $args = array();
        $result = $this->db->ejecutarSqlActualizacion($borrar,$args);
        $this->db->desconectar();
    }
}
