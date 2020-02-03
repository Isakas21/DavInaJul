<?php
include "clases/libro.php";
include "helper/ValidadorForm.php";
include "helper/ValidadorLibro.php";
include "modelo/DaoLibros.php";
include "modelo/DaoClientes.php";

class Controlador
{

    private $DaoClientes;
    private $DaoLibros;


    public function __construct()
    {
        $this->DaoLibros = new DaoLibros();
        $this->DaoClientes = new DaoClientes();
    }

    public function run()
    {
        session_start();

        if (!isset($_POST['login']) && !isset($_SESSION['logeado']))  //no se ha enviado el formulario
        {
            // primera petición
            // se llama al método para mostrar el formulario inici
            $resultado = '<form id="form" action="index.php" method="post">
                <div class="datos">
                <label>Nombre</label>
                <input class="nom" type="text" name="nombre"><br />
                <label>Contraseña</label>
                <input class="nom" type="password" name="pass"><br />
                <input id="btnLog" type="submit" name="login" value="login">
                </div>
                </form>';
            $this->mostrarResultado($resultado, $this->crearLibros(), $this->mostrarLibro(), $this->añadirAlCarrito());
            exit();
        } else {
            // el formulario ya se ha enviado
            // se recogen y procesan los datos
            // se llama al método para mostrar el resultado
            if (isset($_POST['login'])) {
                $nombre = htmlspecialchars($_POST['nombre']);
                $contraseña = htmlspecialchars($_POST['pass']);

                if (empty($this->validar())) {

                    $datosCliente = $this->DaoClientes->checkLogin($nombre, $contraseña);
                    if ($datosCliente) {
                        echo "<input type='hidden' name='login' value='login'>";
                        $resultado = "Bienvenido/a $nombre";
                        $_SESSION['logeado'] = $_POST['login'];
                        $_SESSION['usuario'] = $nombre;
                        $_SESSION['contraseña'] = $contraseña;
                    } else {
                        $resultado = "";
                        $resultado .= '<form id="form" action="index.php" method="post">
                    <div class="datos">
                    <label>Nombre</label>
                    <input type="text" name="nombre" value=' . $nombre . '><br />
                    <label>Contraseña</label>
                    <input type="password" name="pass" /><br />
                    <input id="btnLog" type="submit" name="login" value="login">
                    </div>
                    </form>';
                    }
                } else {

                    $resultado = "";

                    if (isset($_POST['nombre'])) {
                        $nombre = $_POST['nombre'];
                    }
                    foreach ($this->validar() as $error) {
                        $resultado .= $error . "<br>";
                    }



                    $resultado .= '<form id="form" action="index.php" method="post">
                    <div class="datos">
                    <label>Nombre</label>
                    <input type="text" name="nombre" value=' . $nombre . '><br />
                    <label>Contraseña</label>
                    <input type="password" name="pass" /><br />
                    <input id="btnLog" type="submit" name="login" value="login">
                    </div>
                    </form>';
                }
            } else {

                $_POST['login'] = $_SESSION['logeado'];
                $nombre = $_SESSION['usuario'];
                $contraseña = $_SESSION['contraseña'];
                $resultado = "Bienvenido/a $nombre";

                if (isset($_POST['btnInsertar']) && $_POST['btnInsertar'] == "Insertar") {

                    $titulo = $_POST['txtTitulo'];
                    $descripcion = $_POST['txtDescripcion'];
                    $imagen = $_POST['txtImagen'];

                    if (empty($this->validar())) {

                        $libreria = new DaoLibros();

                        if (!$libreria->existeLibro($titulo, $descripcion)) {
                            $libro = new Libro($titulo, $descripcion, "CURRENT_DATE","img/$imagen");
                            $libreria->insertarLibros($libro);

                            $resultado .="<br>El libro se inserto correctamente"; 
                        } else{
                            $resultado .="<br>El libro ya existe"; 
                        }
                    } else {
                        
                        foreach ($this->validar() as $error) {
                            $resultado .="<br>". $error;
                        }
                    }
                }
            }


            $this->mostrarResultado($resultado, $this->crearLibros(), $this->mostrarLibro(), $this->añadirAlCarrito());
            exit();
        }
    }

    private function mostrarResultado($resultado, $libros, $detalle, $librosCarro)
    {
        // y se muestra la vista del resultado (la plantilla resultado.,php)
        include 'vistas/vista_resultado.php';
    }

    // Crea los datos con los que trabajará el formulario
    // @return Array $libros que contiene OBJETOS Libro
    private function crearLibros()
    {

        $datosLibros = $this->DaoLibros->mostrarLibros();
        $libros = array();

        foreach ($datosLibros as $datolibro) {
            $libro = new Libro($datolibro[1], $datolibro[2], $datolibro[3], $datolibro[4]);
            $libros[] = $libro;
        }

        if (isset($_POST['btnFiltro']) && $_POST['btnFiltro'] == 'filtrar') {
            return $this->ordenarLibro($libros);
        }
        return $libros;
    }

    // Muestra los detalles del libro seleccionado en el botón Detalles del formulario 
    // @return Array $detalle que contiene titulo, descripción y portada del libro
    private function mostrarLibro()
    {
        $detalle = array();
        if (isset($_POST['detalles']) && isset($_POST['btnDetalles'])) {

            if ($_POST['btnDetalles'] == 'detalles') {
                $titulo = $_POST['detalles'];
                $detalle = array();
                $libros = $this->crearLibros();
                foreach ($libros as $libro) {
                    if ($libro->getTitulo() == $titulo) {
                        $detalle[] = array($libro->getTitulo(), $libro->getDescripcion(), $libro->getImagen());
                    }
                }
            }
        } else {
            $detalle[] = array("Titulo del libro", "Descripción del libro", "img/logo.png");
        }
        return $detalle;
    }

    // Actualiza la página y ordena un array según el filtro utilizado
    // @param $libros - Array de libros a ordenar
    // @return $libros - Array de libros modificado y ordenado
    private function ordenarLibro($libros)
    {

        $ordenados = array();
        $titulos = array();
        $mayor = "";

        if ($_POST['busqueda'] !== "" && $_POST['busqueda'] !== null) {
            $librosEncontrados = array();
            $busqueda = htmlspecialchars($_POST['busqueda']);
            $busqueda = strtolower($busqueda);
            foreach ($libros as $libro) {
                $title = $libro->getTitulo();
                $title = strtolower($title);
                if (strpos($title, $busqueda) !== false) {
                    $librosEncontrados[] = $libro;
                    $libros = $librosEncontrados;
                }
            }
            if (empty($librosEncontrados)) {
                echo "<script type='text/javascript'> alert('Sin resultados');</script>";
            }
        }
        if (isset($_POST['filtro']) && $_POST['filtro'] == 'novedad') {
            for ($i = count($libros) - 1; $i >= 0; $i--) {
                $ordenados[] = $libros[$i];
            }
            $libros = $ordenados;
        } elseif (isset($_POST['filtro']) && $_POST['filtro'] == 'nombre') {
            foreach ($libros as $libro) {
                $titulos[] = $libro->getTitulo();
            }
            sort($titulos);
            array_multisort($libros, $titulos);
        }

        return $libros;
    }

    // @To do - Añade los libros seleccionados a un array para alquilarlos
    // @return $librosCarro - libros seleccionados 
    private function añadirAlCarrito()
    {

        $librosCarro = "";

        if (isset($_POST['btnAnadir']) && $_POST['btnAnadir'] == "Alquilar") {


            if (isset($_POST['cbxLib'])) {
                foreach ($_POST['cbxLib'] as $titulo) {
                    $librosCarro .= "<li>$titulo</li>";
                }
            } else {
                $librosCarro =  "No has seleccionado ningun libro";
            }
        } else {
            $librosCarro = "El carrito esta vacio";
        }

        return $librosCarro;
    }


    // @return Array con las reglas de validación
    private function crearReglasValidacion()
    {
        if (isset($_POST['btnInsertar']) && $_POST['btnInsertar'] == "Insertar") {
            $reglasValidacion = array(
                "titulo" => array("required" => true),
                "descripcion" => array("required" => true),
                "imagen" => array("required" => false, "formato" => true)
            );
        } else {
            $reglasValidacion = array(
                "nombre" => array("required" => true),
                "contraseña" => array("required" => true, "min" => 8)
            );
        }
        return $reglasValidacion;
    }



    // Comprueba que los campos contienen datos y además, que la contraseña debe tener más de 8 carácteres
    // @return Array con los mensajes de error si no se han cumplido alguna regla, si esta vacio, los campos son correctos
    private function validar()
    {

        if (isset($_POST['btnInsertar']) && $_POST['btnInsertar'] == "Insertar") {

            $validador = new ValidadorLibro();

            $datosPost = array("titulo" => $_POST['txtTitulo'], "descripcion" => $_POST['txtDescripcion'], "txtImagen" => $_POST['txtImagen']);
            $reglasValidacion = $this->crearReglasValidacion();
            $validador->validar($datosPost, $reglasValidacion);
        } else {

            $validador = new ValidadorForm();

            $datosPost = array("nombre" => $_POST['nombre'], "contraseña" => $_POST['pass']);
            $reglasValidacion = $this->crearReglasValidacion();
            $validador->validar($datosPost, $reglasValidacion);
        }

        return $validador->getErrores();
    }



    public function crearLibro()
    {
        $titulo = htmlspecialchars(stripslashes($_POST['titulo']));
        $descripcion = htmlspecialchars(stripslashes($_POST['descripcion']));
        $fecha = 'CURRENT_DATE';
        $imagen = htmlspecialchars(stripslashes($_POST['imagen']));

        if ($this->DaoLibros->existeLibro($titulo, $descripcion)) {

            echo "existe";
        } else {
            $libro = new Libro($titulo, $descripcion, $fecha, $imagen);
            echo "no existe";
            return $libro;
        }
    }
}
