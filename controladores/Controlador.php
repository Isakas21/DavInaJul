<?php
include "clases/libro.php";
class Controlador
{
    public function run()
    {
        session_start();
            
        


        if (!isset($_POST['login']) && !isset($_SESSION['logeado']))  //no se ha enviado el formulario
        { 
            
          
            // primera petición
            //se llama al método para mostrar el formulario inici
            $resultado = '<form id="form" action="index.php" method="post">
            <div id="datos">
                <label>Nombre</label>
                <input type="text" name="nombre" /><br />
                <label>Contraseña</label>
                <input type="password" name="pass" /><br />
                <label>&nbsp;</label>
                <input type="submit" name="login" value="login">
            </div>
        </form>';
            $this->mostrarResultado($resultado, $this->crearLibros(), $this->mostrarLibro());
            exit();
        } else{
            //el formulario ya se ha enviado
            //se recogen y procesan los datos
            //se llama al método para mostrar el resultado
            if(isset($_POST['login'])){
            $nombre = $_POST['nombre'];
            $contraseña = $_POST['pass'];
            $resultado = "Bienvenido/a $nombre";
            
            $_SESSION['logeado'] = $_POST['login'];
            $_SESSION['usuario'] = $nombre;
            $_SESSION['contraseña'] = $contraseña;
            } else{
                $_SESSION['logeado'] = $_POST['login'];
                $_SESSION['usuario'] = $nombre;
                $_SESSION['contraseña'] = $contraseña;
            }

            

            $this->mostrarResultado($resultado, $this->crearLibros(), $this->mostrarLibro());
            exit();
        }
    }

    private function mostrarResultado($resultado, $libros, $detalle)
    {
        // y se muestra la vista del resultado (la plantilla resultado.,php)
        include 'vistas/vista_resultado.php';
    }

    private function crearLibros()
    {
        $libros = array(
            new Libro("PHP para doomies", "Enseñanzas de PHP", "educativo", "05-12-2019", "img/harold.png"),
            new Libro("Java para doomies", "Enseñanzas de Java", "educativo", "08-12-2019", "img/harold.png"),
            new Libro("C para doomies", "Enseñanzas de C", "educativo", "06-12-2019", "img/harold.png"),
            new Libro("HTML para doomies", "Enseñanzas de HTML", "educativo", "29-11-2019", "img/harold.png"),
            new Libro("HTML para doomies", "Enseñanzas de HTML", "educativo", "29-11-2019", "img/harold.png"),
            new Libro("HTML para doomies", "Enseñanzas de HTML", "educativo", "29-11-2019", "img/harold.png"),
            new Libro("HTML para doomies", "Enseñanzas de HTML", "educativo", "29-11-2019", "img/harold.png"),
            new Libro("HTML para doomies", "Enseñanzas de HTML", "educativo", "29-11-2019", "img/harold.png"),
            new Libro("HTML para doomies", "Enseñanzas de HTML", "educativo", "29-11-2019", "img/harold.png")
        );
        return $libros;
    }

    private function mostrarLibro()
    {
        
        $detalle = array();
        if (isset($_POST['detalles']) && $_POST['btnDetalles'] == 'detalles') {
            $titulo = $_POST['detalles'];
            $detalle = array();
            $libros = $this->crearLibros();
            foreach ($libros as $libro) {
                if ($libro->getTitulo() == $titulo) {
                    $detalle[] = array($libro->getTitulo(), $libro->getDescripcion(), $libro->getImagen());
                }
            }
        } else {
            $detalle[] = array("Titulo del libro", "Descripción del libro", "img/harold.png");
        }
        return $detalle;
    }
    
}
?>