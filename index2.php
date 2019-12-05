<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Formularios y Ficheros</title>
        <!--Estilos-->
	<style>
			body {
    			background-color: linen;
			}

			h1 {
    			color: maroon;
    			margin-left: 40px;
    			text-align: center;
			} 
			table, th, td {
    			border: 1px solid black;
    			padding: 5px;
    			text-align: center;
			}
			table {
    			border-spacing: 15px;
			}
		</style>
        <?php

        // Funcion de Filtrado de Datos
        require_once 'Funciones.php';
        ?>
    </head>
    <body>
        <h2>Formulario Ejemplo:</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            DNI:        <input type="text" name="dni" maxlength="50"><br>
            Nombre:        <input type="text" name="nombre" maxlength="50"><br>
            E-mail:     <input type="text" name="email" maxlength="50"><br>
            Contraseña: <input type="password" name="password"><br>
            Idiomas:
            <input type="checkbox" name="idiomas[]" value="castellano" checked="checked">Castellano</input>
            <input type="checkbox" name="idiomas[]" value="ingles">Inglés</input>
            <input type="checkbox" name="idiomas[]" value="frances">Francés</input>
            <input type="checkbox" name="idiomas[]" value="chino">Chino</input><br>
            Matrícula:
            <input type="radio" name="matricula" value="modular" checked="checked">Modular</input>
            <input type="radio" name="matricula" value="completa">Completa</input><br>
            Lenguaje preferido:
            <select name="lenguaje">
                <option value="php" selected="selected">PHP</option>
                <option value="java">JAVA</option>
                <option value="c#">C#</option>
                <option value="phyton">phyton</option>
            </select> <br>
            Fecha de matriculacion:
            <input type="date" name="fechamatricula"></input><br>
            Foto:
            <input type="file" name="archivo" id="archivo"></input>
            <p>
                <input type="submit" name="submit" value="Enviar">
                <input type="reset" value="borrar todo"></p>
        </form>
        <?php

        // Procesamos los datos
        if (isset($_POST["submit"]) && $_SERVER["REQUEST_METHOD"] === "POST") {
            // El dni, nombre y contraseña son campos obligatorios
            if (empty($_POST["nombre"])) {
                $errores[] = "El nombre es requerido";
            }
            if (empty($_POST["dni"])) {
                $errores[] = "El DNI es requerido";
            }
            if (empty($_POST["password"]) || strlen($_POST["password"]) < 5) {
                $errores[] = "La contraseña es requerida y ha de ser mayor a 5 caracteres";
            }
            // El email es obligatorio y ha de tener formato adecuado
            if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) || empty($_POST["email"])) {
                $errores[] = "No se ha indicado email o el formato no es correcto";
            }
            // Si el array $errores está vacío, se aceptan los datos y se asignan a variables
            if (empty($errores)) {
                $nombre = filtrado($_POST["nombre"]);
                $dni = filtrado($_POST["dni"]);
                $password = filtrado($_POST["password"]);
                $email = filtrado($_POST["email"]);
                // Utilizamos implode para pasar el array a string
                $idiomas = filtrado(implode(", ", $_POST["idiomas"]));
                
                $matricula = filtrado($_POST["matricula"]);
                $lenguaje = filtrado($_POST["lenguaje"]);
                $fechamatricula = filtrado($_POST["fechamatricula"]);
                
                // Procesamos la foto le añadimos una coletilla para que no hay ados fotos iguales
                $foto = nombreFoto($_FILES['archivo']['tmp_name']);
                // Copiamos la foto
                if ($_FILES['archivo']["error"] > 0){
                    echo "Error: " . $_FILES['archivo']['error'] . "<br>";
                }else{
                    move_uploaded_file($_FILES['archivo']['tmp_name'],"fotos/" . $foto);
                }

                
                // Lo guardamos en un fichero
                // Creamos la cadena 
                $sal = $dni. "|" .$nombre. "|" .$email. "|" .$password. "|" .$idiomas. "|" .$matricula. "|" .$lenguaje. "|" .$fechamatricula . "|" .$foto;
                //echo $sal;
                // Grabamos los ficheros en el disco
                salvarDatos($sal);
                alerta("Alumno/a añadido con éxito");
  
            // Hay errores 
            } else {
                alerta("Hay errores al procesar su formulario");
                echo "<ul>";
                foreach ($errores as $error) {
                    echo "<li> $error </li>";
                }
                echo "</ul>";
            }
        }
        // Mostramos ya los alumnos que hay
        leerDatos();
        
        ?> 
        
        
    </body>
</html>
