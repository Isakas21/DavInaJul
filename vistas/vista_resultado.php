<?php
include "cabecera.php";
include "helper/Utilidades.php";
include "helper/Input.php";
include_once "modelo/database.php";


if(isset($validador)){

    $errores = $validador->getErrores();
    if (!empty($errores))
    {
        echo "<div class='errores'>";
        foreach ($errores as $campo => $mensajeError)
        {
            echo "<p>$mensajeError</p>\n";
        }
        echo "</div>";
    }
}

echo "<div class='texto' />";
echo $resultado;
echo "</div>";
?>
</header>
<main>

    <section class="libros">

        <!-- LIBROS => Se tendrá que hacer en un bucle -->
        <div>
            Catálogo:
        </div>
        <!--CARRITO-->
        <form id='formLib' method='post'>
        <ul>
            <?php
            
            foreach ($libros as $libro) {
                echo "<li><form method='post' class='det'>" . $libro->getTitulo() . "
                <input type='submit' id='btnDet' name='btnDetalles' value='detalles'>
                <input type='hidden' name='detalles' value='". $libro->getTitulo() . "'>
                <input type='submit' name='btnBorrar' value='borrar'></form>
                <input type='checkbox' id='cbxLib' name='cbxLib[]' value='" . $libro->getTitulo() . "'"; 
                echo Utilidades::verificarCasillas(Input::get('cbxLib'), $libro->getTitulo()) .
                "></li><hr/>";
            }
            ?>
        <li>
            <input type="submit" name="btnAnadir" value='Alquilar'>
        </li>
        <li>
            Titulo: <input type="text" name="txtTitulo"><br>
            Descipcion: <input type="text" name="txtDescripcion"><br>
            Imagen: <input type="text" name="txtImagen"><br>
            <input type="submit" name="btnInsertar" value="Insertar">
            
        </li>
        </ul>
        </form>
    </section>

    <section class="cajafiltros">
        <!--CAJA DE BUSQUEDA Y FILTROS-->
        
        <h2>Filtrar por:</h2>

        <form method="post">
            <p>Búsqueda: <input type="search" name="busqueda" /></p>
            <ul>
                <li>
                    <input type="radio" name="filtro" value="novedad" checked>Novedad
                </li>
                <li>
                    <input type="radio" name="filtro" value="nombre">Nombre
                </li>
                <li>
                    <input type="submit" name="btnFiltro" value="filtrar">
                </li>
            </ul>
        </form>


    </section>
    <section class="ficha">
        <!--FICHA DEL LIBRO-->
        <?php

        echo "<h2>" . $detalle[0][0] . "</h2>";
        echo "<img src=" . $detalle[0][2] . "></img>";
        echo "<div><p>" . $detalle[0][1] . "</p></div>";
        ?>

    </section>

    <section>
        <div class="carrito">
            <h3>Carrito</h3>
            <hr>
            <ul>
                <?php
                    echo "$librosCarro";
                ?>
            </ul>
        </div>
    </section>
    <!--BOTON AÑADIR/QUITAR-->


    <section class="novedades">
        <!--SECCION DE NOVEDADES-->
        <div>
            <h3>Novedades</h3>
        </div>
        <div class="librosNuevos">
        <?php
        $contador = 0;
        for ($i = count($libros) - 1; $i >= 0; $i--) {
            if ($contador < 3) {
                echo "<article><p>" . $libros[$i]->getTitulo() . "</p><img src='" . $libros[$i]->getImagen() . "'/></article>";
                $contador++;
            }
        }
        ?>
        </div>
    </section>
</main>

</body>

</html>

<?php
include "pie.php";
?>