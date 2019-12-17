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
            echo "<input type='hidden' name='login' value='login'>";

            $_SESSION['logeado'] = $_POST['login'];
            $_SESSION['usuario'] = $nombre;
            $_SESSION['contraseña'] = $contraseña;
            } else{
                $_POST['login'] = $_SESSION['logeado'];
                $nombre = $_SESSION['usuario'];
                $contraseña = $_SESSION['contraseña'];
                $resultado = "Bienvenido/a $nombre";
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
            new Libro("PHP para doomies", "Enseñanzas de PHP", "05-12-2019", "img/harold.png"),
            new Libro("Java para doomies", "Enseñanzas de Java", "08-12-2019", "img/harold.png"),
            new Libro("C para doomies", "Enseñanzas de C", "06-12-2019", "img/harold.png"),
            new Libro("1 para doomies", "Enseñanzas de HTML", "29-11-2019", "img/harold.png"),
            new Libro("2 para doomies", "Enseñanzas de HTML", "29-11-2019", "img/harold.png"),
            new Libro("3 para doomies", "Enseñanzas de HTML", "29-11-2019", "img/harold.png"),
            new Libro("4 para doomies", "Enseñanzas de HTML", "29-11-2019", "img/harold.png"),
            new Libro("Javascript para doomies", "Enseñanzas de HTML", "29-11-2019", "img/harold.png"),
            new Libro("6 para doomies", "Enseñanzas de HTML", "29-11-2019", "img/harold.png")
        );
        if (isset($_POST['btnFiltro']) && $_POST['btnFiltro'] == 'filtrar'){
            return $this->ordenarLibro($libros);
        }
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

    private function ordenarLibro($libros)
    {
        $ordenados=array();
        $titulos=array();
        $mayor = "";
        if ($_POST['filtro'] == 'novedad'){
            for ($i = count($libros) - 1; $i >= 0; $i--){
                $ordenados[] = $libros[$i];
            }
            $libros = $ordenados;
            return $libros;
        } elseif($_POST['filtro'] == 'nombre'){
            foreach($libros as $libro){
                $titulos[] = $libro->getTitulo();
            }
            sort($titulos);
            array_multisort($libros, $titulos);

            return $libros;
        } 
        
    }
}
?>