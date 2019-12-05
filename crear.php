<?php
// Incluimos los directorios a trabajar
require_once "funciones.php";

// Variables temporales
$dni = $nombre = $apellidos = $email = $password = "";
$dniErr = $nombreErr = $apellidosErr = $emailErr = $passwordErr= "";
$errores=[];
 
// Procesamos el formulario al pulsar el botón aceptar de esta ficha
if(isset($_POST["submit"]) && $_SERVER["REQUEST_METHOD"] == "POST"){
    
     // Validamos el dni
     $dniVal = filtrado($_POST["dni"]);
     if(empty($dniVal)){
         $dniErr = "Por favor introduzca un DNI válido.";
         $errores[] = "El DNI no es valido";
     } else{
         $dni= $dniVal;
     }

    // Validamos el nombre
    $nombreVal = filtrado($_POST["nombre"]);
    if(empty($nombreVal)){
        $nombreErr = "Por favor introduzca un nombre válido.";
        $errores[] = "El nombre no es valido";
        // Un ejemplo de validar expresiones regulares directamente desde PHP
    } else{
        $nombre= $nombreVal;
    }
    
    // Validamos el email
    $emailVal = filtrado($_POST["email"]);
    if(empty($emailVal)){
        $emailsErr = "Por favor introduzca email válido.";
        $errores[] = "El nombre no es valido";
    } else{
        $email= $emailVal;
    }

    // Validamos el password
    $passwordVal = filtrado($_POST["password"]);
    $passwordVal = hash(md5,$passwordVal);
    if(empty($_POST["password"]) || strlen($_POST["password"]) < 5){
        $passwordErr = "Por favor introduzca password válido de más de cinco carácteres.";
        $errores[] = "El password noes válido o tiene menos de cinco carácateres";
    } else{
        $password= $passwordVal;
    }

    
    // Chequeamos los errores antes de insertar en el fichero
    if(empty($errores)){
        $nombre = $nombreVal;
        $dni = $dniVal;
        $password = $passwordVal;
        $email = $emailVal;
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
        salvarDatos($sal, "alumnado.txt");
        alerta("Alumno/a añadido con éxito");
        header("location: index.php");
        exit();
    }

}
?>
 
<!-- Cabecera de la página web -->
<?php require_once "cabecera.php"; ?>
<!-- Cuerpo de la página web -->
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Crear Alumno/a</h2>
                    </div>
                    <p>Por favor rellene este formulario para añadir un nuevo alumno/a a la base de datos de la clase.</p>
                    <!-- Formulario-->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                        <!-- DNI-->
                        <div class="form-group <?php echo (!empty($dniErr)) ? 'error: ' : ''; ?>">
                            <label>DNI</label>
                            <input type="text" required name="dni" class="form-control" value="<?php echo $dni; ?>">
                            <span class="help-block"><?php echo $dniErr;?></span>
                        </div>
                        <!-- Nombre-->
                        <div class="form-group <?php echo (!empty($nombreErr)) ? 'error: ' : ''; ?>">
                            <label>Nombre</label>
                            <input type="text" required name="nombre" class="form-control" value="<?php echo $nombre; ?>">
                            <span class="help-block"><?php echo $nombreErr;?></span>
                        </div>
                        <!-- Email -->
                        <div class="form-group <?php echo (!empty($emailErr)) ? 'error: ' : ''; ?>">
                            <label>E-Mail</label>
                            <input type="email" required name="email" class="form-control" value="<?php echo $email; ?>">
                            <span class="help-block"><?php echo $emailErr;?></span>
                        </div>
                         <!-- Password -->
                         <div class="form-group <?php echo (!empty($passwordErr)) ? 'error: ' : ''; ?>">
                            <label>Contraseña</label>
                            <input type="password" required name="password" class="form-control" value="<?php echo $password; ?>">
                            <span class="help-block"><?php echo $passwordErr;?></span>
                        </div>
                         <!-- Idiomas -->
                         <div class="form-group">
                            <label>Idiomas</label>
                            <input type="checkbox" name="idiomas[]" value="castellano" checked="checked">Castellano</input>
                            <input type="checkbox" name="idiomas[]" value="ingles">Inglés</input>
                            <input type="checkbox" name="idiomas[]" value="frances">Francés</input>
                            <input type="checkbox" name="idiomas[]" value="chino">Chino</input>
                        </div>
                        <!-- Matrícula -->
                        <div class="form-group">
                            <label>Matrícula</label>
                            <input type="radio" name="matricula" value="modular" checked="checked">Modular</input>
                            <input type="radio" name="matricula" value="completa">Completa</input><br>
                        </div>
                        <!-- Lenguaje-->
                        <div class="form-group">
                        <label>Lenguaje</label>
                            <select name="lenguaje">
                                <option value="php" selected="selected">PHP</option>
                                <option value="java">JAVA</option>
                                <option value="c#">C#</option>
                                <option value="phyton">phyton</option>
                            </select>
                        </div>
                        <!-- Fecha-->
                        <div class="form-group">
                        <label>Fecha de Matriculación</label>
                            <input type="date" required name="fechamatricula"></input><div>
                        </div>
                         <!-- Foto-->
                         <div class="form-group">
                        <label>Fotografía</label>
                            <input type="file"  required name="archivo" id="archivo"></input>
                        </div>
                        


                        </div>
                         <button type="submit"  name="submit" class="btn btn-primary"> <span class="glyphicon glyphicon-ok"></span>  Aceptar</button>
                        <a href="index.php" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Cancelar</a>
                    </form>
                </div>
                <?php
                    if(!empty($errores)){
                        alerta("Hay errores al procesar su formulario");
                        echo "<ul>";
                        foreach ($errores as $error) {
                            echo "<li> $error </li>";
                        }
                        echo "</ul>";
                    }
                ?>
            </div>        
        </div>
    </div>
    <br><br><br><br>
<!-- Pie de la página web -->
<?php require_once "pie.php"; ?>