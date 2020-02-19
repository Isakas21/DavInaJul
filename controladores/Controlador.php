<?php
require "clases/libro.php";
require "clases/clientes.php";
require "helper/ValidadorForm.php";
require "helper/ValidadorLibro.php";
require "modelo/DaoLibros.php";
require "modelo/DaoClientes.php";

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

        if (!isset($_POST['login']) && !isset($_SESSION['logeado']) && !isset($_POST['registrarse']))  //no se ha enviado el formulario
        {
            // primera petición
            // se llama al método para mostrar el formulario inici
            $resultado = '</div><form id="form" action="index.php" method="post">
                <div class="datos">
                <label>Nombre</label>
                <input class="nom" type="text" name="nombre">
                <label>Contraseña</label>
                <input class="nom" type="password" name="pass">
                <input id="btnLog" type="submit" name="login" value="login">
                <input id="btnReg" type="submit" name="registrarse" value="registrarse">
                </div>
                </form>';
            $this->mostrarResultado($resultado, $this->crearLibros(), $this->mostrarLibro(), $this->añadirAlCarrito());
            exit();
        } else {
            // el formulario ya se ha enviado
            // se recogen y procesan los datos
            // se llama al método para mostrar el resultado
            if (isset($_POST['login']) || isset($_POST['registrarse'])) {
                $nombre = htmlspecialchars($_POST['nombre']);
                $contraseña = htmlspecialchars($_POST['pass']);
                $cliente = new Cliente($nombre, $contraseña);

                if (empty($this->validar())) {

                    $datosCliente = $this->DaoClientes->checkLogin($cliente);
                    if ($datosCliente && isset($_POST['login'])) {
                        echo "<input type='hidden' name='login' value='login'>";
                        $resultado = "</div>Bienvenido/a " . $cliente->getNombre() .
                            '<form method="post"><input id="btnReg" type="submit" name="salir" value="salir"></form> ';
                        $_SESSION['logeado'] = $_POST['login'];
                        $_SESSION['usuario'] = $cliente->getNombre();
                        $_SESSION['contraseña'] = $cliente->getContraseña();
                    } else {
                        $resultado = "";

                        if (isset($_POST['login'])) {
                            $resultado .= "Usuario/Contraseña incorrecto";
                        }

                        if (isset($_POST['registrarse']) && $_POST['registrarse'] == 'registrarse') {
                            if (!$this->DaoClientes->checkLogin($cliente)) {
                                $this->DaoClientes->registrarse($cliente);
                                $resultado .= "<br>El usuario ha sido añadido a la base de datos";
                            } else {
                                $resultado .= "<br>El usuario ya existe en la base de datos";
                            }
                        }

                        $resultado .= '</div><form id="form" action="index.php" method="post">
                    <div class="datos">
                    <label>Nombre</label>
                    <input type="text" name="nombre" value=' . $cliente->getNombre() . '>
                    <label>Contraseña</label>
                    <input type="password" name="pass" />
                    <input id="btnLog" type="submit" name="login" value="login">
                    <input id="btnReg" type="submit" name="registrarse" value="registrarse">
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

                    $resultado .= '</div><form id="form" action="index.php" method="post">
                    <div class="datos">
                    <label>Nombre</label>
                    <input type="text" name="nombre" value=' . $cliente->getNombre() . '>
                    <label>Contraseña</label>
                    <input type="password" name="pass" />
                    <input id="btnLog" type="submit" name="login" value="login">
                    <input id="btnReg" type="submit" name="registrarse" value="registrarse">
                    </div>
                    </form>';
                }
            } else {

                if (isset($_POST['salir']) && $_POST['salir'] == "salir") {
                    session_destroy();
                    $resultado = '</div><form id="form" action="index.php" method="post">
                <div class="datos">
                <label>Nombre</label>
                <input class="nom" type="text" name="nombre">
                <label>Contraseña</label>
                <input class="nom" type="password" name="pass">
                <input id="btnLog" type="submit" name="login" value="login">
                <input id="btnReg" type="submit" name="registrarse" value="registrarse">
                </div>
                </form>';
                    $this->mostrarResultado($resultado, $this->crearLibros(), $this->mostrarLibro(), $this->añadirAlCarrito());
                } else {
                    $_POST['login'] = $_SESSION['logeado'];
                    $nombre = $_SESSION['usuario'];
                    $contraseña = $_SESSION['contraseña'];
                    $resultado = '</div>Bienvenido/a ' . $nombre .
                        '<form method="post"><input id="btnReg" type="submit" name="salir" value="salir"></form> ';
                }

                if (isset($_POST['btnBorrar']) && $_POST['btnBorrar'] == 'borrar') {
                    $this->borrarLibro();
                    $resultado .= "<br>El libro " . $_POST['detalles'] . " ha sido borrado";
                }

                if (isset($_POST['btnInsertar']) && $_POST['btnInsertar'] == "Insertar") {

                    $titulo = $_POST['txtTitulo'];
                    $descripcion = $_POST['txtDescripcion'];
                    $imagen = $_POST['txtImagen'];

                    if (empty($this->validar())) {

                        $libreria = new DaoLibros();
                        if ($imagen == "") {
                            $imagen = "logo.jpg";
                        }

                        if (!$libreria->existeLibro($titulo)) {
                            $libro = new Libro($titulo, $descripcion, "CURRENT_DATE", "img/$imagen");
                            $libreria->insertarLibros($libro);

                            $resultado .= "<br>El libro se inserto correctamente";
                        } else {
                            $resultado .= "<br>El libro ya existe";
                        }
                    } else {

                        foreach ($this->validar() as $error) {
                            $resultado .= "<br>" . $error . "";
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
        require 'vistas/vista_resultado.php';
    }

    /**
     * Crea los datos con los que trabajará el formulario
     *
     * @author	Davinajul
     * @since	v0.0.1
     * @version	v1.0.0	Friday, February 7th, 2020.
     * @access	private
     * @return	mixed
     */
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

    /**
     * Muestra los detalles del libro seleccionado en el botón Detalles del formulario
     *
     * @author	Davinajul
     * @since	v0.0.1
     * @version	v1.0.0	Friday, February 7th, 2020.	
     * @access	private
     * @return	mixed
     */
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
            $detalle[] = array("Titulo de libro", "Para insertar o borrar libros, debe estar registrado en nuestra base de datos", "img/logo.jpg");
        }
        return $detalle;
    }

    /**
     * Actualiza la página y ordena un array según el filtro utilizado
     *
     * @author	Davinajul
     * @since	v0.0.1
     * @version	v1.0.0	Friday, February 7th, 2020.
     * @access	private
     * @param	mixed	$libros	
     * @return	mixed
     */
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



    /**
     * Añade los libros al carrito para alquilar
     *
     * @author	Davinajul
     * @since	v0.0.1
     * @version	v1.0.0	Friday, February 7th, 2020.
     * @access	private
     * @return	mixed
     */
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


    /**
     * crearReglasValidacion.
     *
     * @author	Davinajul
     * @since	v0.0.1
     * @version	v1.0.0	Friday, February 7th, 2020.
     * @access	private
     * @return	mixed
     */
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

    /**
     * Comprueba que los campos contienen datos y además, que la contraseña debe tener más de 8 carácteres
     *
     * @author	Davinajul
     * @since	v0.0.1
     * @version	v1.0.0	Friday, February 7th, 2020.
     * @access	private
     * @return	mixed
     */
    private function validar()
    {

        if (isset($_POST['btnInsertar']) && $_POST['btnInsertar'] == "Insertar") {

            $validador = new ValidadorLibro();
            $imagen = $_POST['txtImagen'];
            if ($imagen == "") {
                $imagen = "logo.jpg";
            }
            $datosPost = array("titulo" => $_POST['txtTitulo'], "descripcion" => $_POST['txtDescripcion'], "imagen" => $imagen);
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

    /**
     * Borra los libros marcados de la base de datos.
     *
     * @author	Davinajul
     * @since	v0.0.1
     * @version	v1.0.0	Friday, February 7th, 2020.
     * @access	private
     * @return	void
     */
    private function borrarLibro()
    {
        $titulo = htmlspecialchars(stripslashes($_POST['detalles']));
        $this->DaoLibros->borrarLibro($titulo);
    }
}
