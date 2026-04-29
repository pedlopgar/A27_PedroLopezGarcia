<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bd_videojuegos_estilos.css">
    <title>Document</title>
</head>

<body>

    <?php

    // =========================================================================
    /* Con session_start() lo que hace php es "pedirle" al navegador que nos de
    una cookie de sesión. Si hay una sesión activa, carga esos datos. Si no, nos
    crea una sesión vacía. */
    session_start();

    // =========================================================================
    /* Primero, tenemos que comprobar si la cookie de la sesión existe. Si
    existe, es porque el usuario había iniciado sesión correctamente. Por lo
    contrario, significa que no se tienen los permisos para editar la base de
    datos */
    if (isset($_SESSION["usuario"])) {

        // =========================================================================
        include("bd_videojuegos_datos.php"); // Obtenemos las variables de datos.php
        include("bd_videojuegos_funciones.php"); // Obtenemos las funciones contectarBDA() y obtenerUsuario()
    
        // =========================================================================
        /* Este if comprueba si, cuando se hace el GET, si hay un parámetro llamado
        id en la URL; y que, además, no esté vacío. De ser válido, copia del array
        generado por el GET la variable id y la almacena en otra variable del mismo
        nombre, para poder borrar un juego por su id. */
        if (isset($_GET["id"]) && $_GET["id"] != "") {

            $id = $_GET["id"];

            // =========================================================================
            /* Se llama a la función conectarBDA, que nos dirá si ha fallado o
            se ha hecho correctamente. En caso afirmativo, se le asigna a la variable 
            $conexion. Por lo tanto, lo que el if evalúa es:
            +   Si $conexion es válido entra.
            +   Si $conexion no es false, no entra. */
            if ($conexion = conectarBDA($host, $usuario, $pass, $bda)) {

                // Borraremos un juego, mediante su id, por medio de la consulta dentro de la función borrarJuego
                if (borrarJuego($conexion, $id)) {
                    echo "Registro eliminado correctamente<br>";
                } else {
                    echo "Error al eliminar<br>";
                }

                // Enlace para volver al listado
                echo "<a href='bd_videojuegos_listado.php'>Volver al listado</a>";
                
                //Cerramos la conexión con MySQL
                mysqli_close($conexion);
            } else {
                echo "Error de conexión";
            }

        } else {
            echo "ID no recibido<br>";
            echo "<a href='bd_videojuegos_listado.php'>Volver al listado</a>";
        }

    } else {
        echo "No hay sesión abierta.<br>";
        echo "<a href='bd_videojuegos_login.php'>Volver al login</a>";
    }
    ?>

</body>

</html>