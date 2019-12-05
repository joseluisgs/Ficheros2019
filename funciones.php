<?php

// Constantes
if ( !defined('ROOT_PATH') )
    define('ROOT_PATH', dirname(__FILE__)."/");

if ( !defined('FILE_PATH') )
    define('FILE_PATH', ROOT_PATH."fichero/");

if ( !defined('IMAGE_PATH') )
    define('IMAGE_PATH', ROOT_PATH."fotos/");



// alerta de texto
function alerta($texto) {
    echo '<script type="text/javascript">alert("' . $texto . '")</script>';
}

// filtrado de datos de formulario
function filtrado($datos) {
    $datos = trim($datos); // Elimina espacios antes y después de los datos
    $datos = stripslashes($datos); // Elimina backslashes \
    $datos = htmlspecialchars($datos); // Traduce caracteres especiales en entidades HTML
    return $datos;
}

// salva los datos en el fichero
function salvarDatos($cadena, $fichero){
    $fp = fopen(FILE_PATH.$fichero, "a");
    fputs($fp, $cadena);
    fputs($fp, "\n");
    fclose($fp);
}

function leerDatos($fichero){
    // Creamos una lista vacía
    $lista=[];
    $fp = fopen(FILE_PATH.$fichero, "r");
    while(!feof($fp)) {
        $linea = fgets($fp);
        $datos = explode("|", $linea);
        if (count($datos)>2) {
            $al=[
                "dni"=>$datos[0],
                "nombre"=>$datos[1],
                "email"=>$datos[2],
                "password"=>$datos[3],
                "idiomas"=>$datos[4],
                "matricula"=>$datos[5],
                "lenguajes"=>$datos[6],
                "fecha"=>$datos[7],
                "foto"=>$datos[8],
            ];
            $lista[]=$al;
        }
    }

    fclose($fp);
    return $lista;

}

// le añadimos una coletilla para que no haya dos fotos iguales
function nombreFoto($cadena){
    $datos=hash_file('md5', $cadena) . ".jpg";
    return $datos;
}


