<?php

require_once "funciones.php";


$nombre = 'lista_de_alumnos.json'; // Nombre del archivo final

//header("Content-Type: application/octet-stream");


$lista = leerDatos("alumnado.txt");

header('Content-type: application/json');
//header("Content-Disposition: attachment; filename=" . $nombre . ""); //archivo de salida
echo json_encode($lista);
exit;


?>
