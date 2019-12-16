<?php
include "cabecera.php";

echo "<div class='texto' />";
echo $resultado;
echo "</div>";
?>
</header>
<main>

    <section class="libros">

        <!-- LIBROS => Se tendrá que hacer en un bucle -->
        <div>
            Carrito:
        </div>
        <!--CARRITO-->
        <ul>
            <?php
            foreach ($libros as $libro) {
                echo "<li>" . $libro->getTitulo() . "<form method='post'><input type='submit' name='btnDetalles' value='detalles'>
                        <input type='checkbox' value='" . $libro->getTitulo() . "'><input type='hidden' name='detalles' value='" . $libro->getTitulo() . "'>
                        </form></li>";
            }
            ?>
        </ul>
    </section>

    <section class="cajafiltros">
        <!--CAJA DE BUSQUEDA Y FILTROS-->
        <p>Búsqueda: <input type="search" /></p>
        <h2>Filtrar por:</h2>

        <form method="post">
            <ul>
                <li>
                    <input type="radio" name="filtro" value="novedad" checked>Novedad
                </li>
                <li>
                    <input type="radio" name="filtro" value="nombre">Nombre
                </li>
                <li>
                    <input type="radio" name="filtro" value="categoria">Categoría
                </li>
                <li>
                    <input type="submit" name="btnFiltro" value="filtrar">
                </li>
            </ul>
        </form>

        <div>
            <!--GENEROS (+ de 4)-->
            <input type="checkbox" />Género 1
            <input type="checkbox" />Género 2
            <input type="checkbox" />Género 3
            <input type="checkbox" />Género 4
        </div>

    </section>
    <section class="ficha">
        <!--FICHA DEL LIBRO-->
        <?php

        echo "<h2>" . $detalle[0][0] . "</h2>";
        echo "<img src=" . $detalle[0][2] . "></img>";
        echo "<div><p>" . $detalle[0][1] . "</p></div>";
        ?>

    </section>

    <input type="button">añadir/quitar
    <!--BOTON AÑADIR/QUITAR-->


    <section class="novedades">
        <!--SECCION DE NOVEDADES-->
        <div>
            <h3>Novedades</h3>
        </div>
        <?php
        $contador = 0;
        for ($i = count($libros) - 1; $i >= 0; $i--) {
            if ($contador < 3) {
                echo "<article><p>" . $libros[$i]->getTitulo() . "</p><img src='" . $libros[$i]->getImagen() . "'/></article>";
                $contador++;
            }
        }
        ?>

        </article>
    </section>
</main>

</body>

</html>

<?php
include "pie.php";
?>