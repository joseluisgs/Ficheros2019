<?php

require_once "funciones.php";


$nombre = 'lista_de_alumnos.txt'; // Nombre del archivo final

header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=" . $nombre . ""); //archivo de salida

$lista = leerDatos("alumnado.txt");

// Si hay filas (no nulo), pues mostramos la tabla
if (!is_null($lista) && count($lista) > 0) {
    foreach ($lista as $al) {
        echo "DNI: " . $al["dni"]. "---";
        echo "Nombre: " . $al["nombre"]. "---";
        echo "E-MAil: " . $al["email"]. "---";
        echo "Password: " . $al["password"]. "---";
        echo "Idiomas: " . $al["idiomas"]. "---";
        echo "Matricula: " . $al["matricula"]. "---";
        echo "Lenguajes: " . $al["lenguajes"]. "---";
        echo "Fecha: " . $al["fecha"];
        echo PHP_EOL;
    }
}else{
    echo "No se ha encontrado datos de alumnos";
}

?>
