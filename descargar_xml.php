<?php

require_once "funciones.php";


$nombre = 'lista_de_alumnos.xml'; // Nombre del archivo final

$lista = leerDatos("alumnado.txt");

$doc = new DOMDocument('1.0', 'UTF-8');
$alumnos = $doc->createElement('alumnos');

foreach ($lista as $fila) {
    // Creamos el nodo
    $alumno = $doc->createElement('alumno');
    // Añadimos elementos
    $alumno->appendChild($doc->createElement('dni', $fila['dni']));
    $alumno->appendChild($doc->createElement('nombre', $fila['nombre']));
    $alumno->appendChild($doc->createElement('email', $fila['email']));
    $alumno->appendChild($doc->createElement('password', $fila['password']));
    $alumno->appendChild($doc->createElement('idiomas', $fila['idiomas']));
    $alumno->appendChild($doc->createElement('matricula', $fila['matricula']));
    $alumno->appendChild($doc->createElement('lenguajes', $fila['lenguajes']));
    $alumno->appendChild($doc->createElement('fecha', $fila['fecha']));

    //Insertamos
    $alumnos->appendChild($alumno);
}

$doc->appendChild($alumnos);
header('Content-type: application/xml');
//header("Content-Disposition: attachment; filename=" . $nombre . ""); //archivo de salida
echo $doc->saveXML();

exit;


?>
