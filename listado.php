<?php
    // Incluimos los ficheros que ncesitamos
    require_once "funciones.php";
?>



    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header clearfix">
                    <h2 class="pull-left">Fichas del Alumnado</h2>
                </div>

                    <!-- Aquí va el nuevo botón para dar de alta, podría ir al final -->   
                    <a href="descargar_json.php" class="btn pull-right" target="_blank"><span class="glyphicon glyphicon-download"></span>  JSON</a>
                    <a href="descargar_xml.php" class="btn pull-right" target="_blank"><span class="glyphicon glyphicon-download"></span>  XML</a>
                    <a href="descargar_txt.php" class="btn pull-right" target="_blank"><span class="glyphicon glyphicon-download"></span>  TXT</a>
                    <a href="fichero/alumnado.txt" class="btn pull-right" target="_blank"><span class="glyphicon glyphicon-download"></span>  Fichero</a>
                    <a href="crear.php" class="btn btn-success pull-right"><span class="glyphicon glyphicon-user"></span>  Nuevo Alumno/a</a>
                    
            </div>
            <!-- Linea para dividir -->
            <div class="page-header clearfix">        
            </div>
            <?php


           $lista = leerDatos("alumnado.txt");
            

            // Si hay filas (no nulo), pues mostramos la tabla
            if (!is_null($lista) && count($lista) > 0) {
                echo "<table class='table table-bordered table-striped'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>DNI</th>";
                echo "<th>Nombre</th>";
                echo "<th>EMail</th>";
                echo "<th>Contraseña</th>";
                echo "<th>Idiomas</th>";
                echo "<th>Matrícula</th>";
                echo "<th>Lenguajes</th>";
                echo "<th>Fecha</th>";
                echo "<th>Foto</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";


                // Recorremos los registros encontrado
                foreach ($lista as $al) {
                    // Pintamos cada fila
                    echo "<tr>";
                    echo "<td>" . $al["dni"]. "</td>";
                    echo "<td>" . $al["nombre"]. "</td>";
                    echo "<td>" . $al["email"]. "</td>";
                    echo "<td>" . $al["password"]. "</td>";
                    echo "<td>" . $al["idiomas"]. "</td>";
                    echo "<td>" . $al["matricula"]. "</td>";
                    echo "<td>" . $al["lenguajes"]. "</td>";
                    echo "<td>" . $al["fecha"]. "</td>";
                    echo "<td><img src='fotos/".$al["foto"]."' width='120px' height='120px'></td>";
    
     
                    
                    //echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                // Si no hay nada seleccionado
                echo "<p class='lead'><em>No se ha encontrado datos de alumnos/as.</em></p>";
            }
            ?>

        </div>
    </div>        

<br><br><br><br>