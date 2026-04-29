<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bd_videojuegos_estilos.css">
    <title>Biblioteca</title>
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
        /* Se llama a la función conectarBDA, que nos dirá si ha fallado o
        se ha hecho correctamente. En caso afirmativo, se le asigna a la variable 
        $conexion. Por lo tanto, lo que el if evalúa es:
        +   Si $conexion es válido entra.
        +   Si $conexion no es false, no entra. */
        if ($conexion = conectarBDA($host, $usuario, $pass, $bda)) {

            /* Se ejecuta la función obtenerJuegos, la cuál hace una consulta MySQL que
            se encarga de devolvernos un conjunto de filas, que no un array, el cuál es
            almacenado den la variable $resultado. */
            $resultado = obtenerJuegos($conexion);

            // Muestra el usuario actual, gracias a la cookie de SESSION
            echo "<p>Usuario: " . $_SESSION["usuario"] . "</p>";
            // Muestra las acciones, fuera de la tabla, que puede hacer el usuario
            echo "<a href='bd_videojuegos_insertar.php'>Añadir juego</a> | ";
            echo "<a href='bd_videojuegos_logout.php'>Cerrar sesión</a><br><br>";
            // Creamos la tabla
            echo "<table>";
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Nombre</th>";
            echo "<th>Fecha</th>";
            echo "<th>Distribuidora</th>";
            echo "<th>Desarrolladora</th>";
            echo "<th>Acciones</th>";
            echo "</tr>";

            // =========================================================================
            /* Con este while se hacen tres cosas a la vez:
                +   Se lee una fila que sale de mysqli_fetch_array($resultado).
                +   Se guarda la fila resultante en $fila.
                +   Se comrpueba si es válida. Si no lo es, el while para.

                Queremos poner cada elemnto de la fila, según su nombre, en el espacio
                correspondiente en la fila de la tabla. Para ello, de este "array" MySQL
                iremos especificando qué elemento entrará en acción por cada fila que el
                while irá "dibujando". */
            while ($fila = mysqli_fetch_array($resultado)) {
                echo "<tr>";
                echo "<td>" . $fila["id"] . "</td>";
                echo "<td>" . $fila["nombre"] . "</td>";
                echo "<td>" . $fila["fecha_lanzamiento"] . "</td>";
                echo "<td>" . $fila["distribuidora"] . "</td>";
                echo "<td>" . $fila["desarrolladora"] . "</td>";
                // Aquí ponemos los enlaces para poder editar o borrar lo juegos
                echo "<td>
                    <a href='bd_videojuegos_editar.php?id=" . $fila["id"] . "'>Editar</a> |
                    <a href='bd_videojuegos_borrar.php?id=" . $fila["id"] . "'>Borrar</a> </td>";
                echo "</tr>";
            }

            echo "</table>";

            //Cerramos la conexión con MySQL
            mysqli_close($conexion);

        } else {
            echo "Error de conexión";
        }

    } else {
        echo "No hay sesión abierta.<br>";
        echo "<a href='bd_videojuegos_login.php'>Volver al login</a>";
    }
    ?>

</body>

</html>