<?php

define ("DB_SERVER", "localhost");
define ("DB_USER", "alumno");
define ("DB_PASS", "alumno");
define ("DB_NAME", "bddavinajul");

class Conexion {

    public function conectar(){
        try {
            $db = new PDO("mysql:host:" . DB_SERVER . ";dbname=" . DB_NAME, DB_USER, DB_PASS); // Se puede configurar el objeto
             $db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
              $db->exec("set names utf8mb4");
              $conectado = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
              if(!$conectado){
                echo "no esta conectado";
              } else {
                echo "Ha conectado";
              }
              return($db);
             } 
              catch(PDOException $e) {
                echo " <p>Error: " . $e->getMessage() . "</p>\n";
                exit();
        }
    }

    public function desconectar() {
        $db = null;
    }

    public function insertarLibro(){
        
    }
}
?>