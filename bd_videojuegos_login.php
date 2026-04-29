<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bd_videojuegos_estilos.css">
    <title>Login</title>
</head>

<body>

    <?php

    // =========================================================================
    /* Con session_start() lo que hace php es "pedirle" al navegador que nos de
    una cookie de sesión. Si hay una sesión activa, carga esos datos. Si no, nos
    crea una sesión vacía. */
    session_start();

    // =========================================================================
    include("bd_videojuegos_datos.php"); // Obtenemos las variables de datos.php
    include("bd_videojuegos_funciones.php"); // Obtenemos las funciones contectarBDA() y obtenerUsuario()
    
    /* Aquí lo que haremos será almacenar en la variable $mensaje
    el String que generaremos con cada output del código. Por ejemplo, cuando el
    inicio de sesión sea exitoso, lo guaratemos aquí; y, porsteriormente, se irá
    invocando según se requiera. */
    $mensaje = "";

    // =========================================================================
    /* Primero, se llama a la función conectarBDA, que nos dirá si ha fallado o
    se ha hecho correctamente. En caso afirmativo, se le asigna a la variable 
    $conexion. Por lo tanto, lo que el if evalúa es:
    +   Si $conexion es válido entra.
    +   Si $conexion no es false, no entra. */
    if ($conexion = conectarBDA($host, $usuario, $pass, $bda)) {
        //Compruba que, tanto "usuario" como "password" se han enviado y no están vacíos
        if (isset($_POST["usuario"]) && $_POST["usuario"] != "" && isset($_POST["password"]) && $_POST["password"] != "") {
            //Copiamos los datos enviados a sus variables "normales" y homólogas
            $user = $_POST["usuario"];
            $passw = $_POST["password"];

            /* Los datos del usuario que vamos a buscar se almacenarán en el
            array $fila. */
            $fila = obtenerUsuario($conexion, $user);

            //Comprobamos primero si el array no está vacío y existe
            if ($fila) {
                /* Comprobamos si la contraseña que hemos almacenado se
                corresponde con la que está en la columna "password" de la base
                de datos */
                if ($passw == $fila["password"]) {
                    $_SESSION["usuario"] = $user; // Si todo va bien, asignamos a la cookie de sesión la variable que teníamos para comprobar el usuario
                    $mensaje = "Acceso correcto. Bienvenido/a " . $_SESSION["usuario"] . ".";
                } else {
                    $mensaje = "Acceso no autorizado.";
                }
            } else {
                $mensaje = "Acceso no autorizado.";
            }
        }
        //Cerramos la conexión con MySQL
        mysqli_close($conexion);
    } else {
        $mensaje = "Error de conexión.";
    }

    // =========================================================================
    /* Activamos el mensaje siempre que el contenido de este no esté vacío. */
    if ($mensaje != "") {
        echo "<p>" . $mensaje . "</p>";
    }

    // =========================================================================
    /*Comprobamos si la cookie de la sesión existe. Si existe, es porque el
    usuario había iniciado sesión correctamente. Por lo contrario, significa que
    no se tienen los permisos para editar la base de datos */
    if (isset($_SESSION["usuario"])) {
        //Muestra el usuario con el que se ha podido entrar, además de las opciones que puede usar
        echo "<p>Usuario actual: " . $_SESSION["usuario"] . "</p>";
        echo "<a href='bd_videojuegos_listado.php'>Entrar a la aplicación</a><br>";
        echo "<a href='bd_videojuegos_logout.php'>Cerrar sesión</a><br><br>";
    }
    ?>

    <!-- Aquí mostramos el formulario para enviar los datos -->
    <form method="POST">
        Usuario: <input type="text" name="usuario"><br>
        Contraseña: <input type="password" name="password"><br>
        <input type="submit" value="Entrar">
    </form>

</body>

</html>