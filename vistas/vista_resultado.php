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
                    foreach($libros as $libro){
                        echo "<li>" . $libro->getTitulo() . "<form method='post'><input type='submit' name='btnDetalles' value='detalles'>
                        <input type='checkbox' value='" . $libro->getTitulo() . "'><input type='hidden' name='detalles' value='" .$libro->getTitulo() ."'>
                        </form></li>";
                    }
                ?>
            </ul>
        </section>

        <section class="cajafiltros">
            <!--CAJA DE BUSQUEDA Y FILTROS-->
            <p>Búsqueda: <input type="search" /></p>
            <h2>Filtrar por:</h2>
            <ul>
                <li>
                    <input type="radio">Novedad
                </li>
                <li>
                    <input type="radio">Disponibilidad
                </li>
                <li>
                    <input type="radio">Nombre
                </li>
                <li>
                    <input type="radio">Categoría
                </li>
            </ul>

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
                echo "<div><p>" . $detalle[0][1]. "</p></div>";
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
                    $novedades = array(array("titulo","descripcion","imagen","00-00-2000"),
                    array("titulo","descripcion","imagen","0-0-2000"),
                    array("titulo","descripcion","imagen","0-0-2000"));
                    foreach ($libros as $libro){
                        if ($libro->getFecha() > $novedades[0][4]){
                            $novedades[0] = $libro;
                        }else if ($libro->getFecha() > $novedades[1][4]){
                            $novedades[1] = $libro;
                        } else if ($libro->getFecha() > $novedades[2][4]){
                            $novedades[2] = $libro;
                        }
                    }
                    foreach($novedades as $libro){
                        echo "<article><p>" .$libro[0]. "</p><img src='" .$libro[2] ."'/></article>";
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
