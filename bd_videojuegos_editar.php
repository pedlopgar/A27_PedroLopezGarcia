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
        /* Primero, se llama a la función conectarBDA, que nos dirá si ha fallado o
        se ha hecho correctamente. En caso afirmativo, se le asigna a la variable 
        $conexion. Por lo tanto, lo que el if evalúa es:
        +   Si $conexion es válido entra.
        +   Si $conexion no es false, no entra. */
        if ($conexion = conectarBDA($host, $usuario, $pass, $bda)) {
            /* Aquí lo que haremos será almacenar en la variable $mensaje
            el String que generaremos con cada output del código. Por ejemplo, cuando el
            inicio de sesión sea exitoso, lo guaratemos aquí; y, porsteriormente, se irá
            invocando según se requiera. */
            $mensaje = "";

            // =========================================================================
            /* Comprobamos, del formulario de más abajo, si este se ha enviado. Con esta
            comprobación, si existe un id, significa que el usuario ha pulsado el botón
            de actualizar y que los datos han sido enviados por POST. */
            if (isset($_POST["id"])) {
                //Comprobamos que los datos no estén vacíos
                if ($_POST["nombre"] != "" && $_POST["fecha"] != "" && $_POST["distribuidora"] != "" && $_POST["desarrolladora"] != "") {

                    //Copiamos los datos del formulario a sus variables correspondientes
                    $id = $_POST["id"];
                    $nombre = $_POST["nombre"];
                    $fecha = $_POST["fecha"];
                    $distribuidora_id = $_POST["distribuidora"];
                    $desarrolladora_id = $_POST["desarrolladora"];

                    // =========================================================================
                    /* Este if comprueba si la función actualizarJuego se ha ejecutado de forma
                    correcta. Antes de dicha comprobación, se ejecutan los comandos de la
                    función y luego se evalúan. */
                    if (actualizarJuego($conexion, $id, $nombre, $fecha, $distribuidora_id, $desarrolladora_id)) {
                        $mensaje = "Juego actualizado correctamente";
                    } else {
                        $mensaje = "Error al actualizar";
                    }

                } else {
                    $mensaje = "Debes rellenar todos los campos";
                }
            }
            // =========================================================================
            /* Este if comprueba si, cuando se hace el GET, si hay un parámetro llamado
            id en la URL. De ser así, copia del array generado por el GET la variable id
            y la almacena en otra variable del mismo nombre. */
            if (isset($_GET["id"])) {
                $id = $_GET["id"];
                // $juego es un array donde se almacenan los datos del juego que editaremos
                $juego = obtenerJuegoPorId($conexion, $id);
            }

            // =========================================================================
            /* Este no es un array al uso, ya que se devuelven muchas filas de info. Es
            un tipo de array propio de MySQL; del cuál, después, los recorreremos con un
            mysqli_fetch_array() para obtener los datos de cada fila. */
            $distribuidoras = obtenerDistribuidoras($conexion);
            $desarrolladoras = obtenerDesarrolladoras($conexion);
            ?>

            <h1>Editar juego</h1>

            <?php
            // =========================================================================
            /* Activamos el mensaje siempre que el contenido de este no esté vacío. */
            if ($mensaje != "") {
                echo "<p>" . $mensaje . "</p>";
            }
            ?>

            <!-- Formulario con el que editaremos los juegos -->
            <!-- Aquí pasará lo siguiente: en cada "value" del formulario, se almacenará un
             valor diferente del array $juego, especificando qué campo será su equivalencia-->
            <form method="POST">
                <!-- Como el id de cada juego es autogenerado, lo ocultamos para que no se pueda modificar -->
                <input type="hidden" name="id" value="<?php echo $juego["id"]; ?>">

                Nombre: <input type="text" name="nombre" value="<?php echo $juego["nombre"]; ?>"><br>

                Fecha lanzamiento: <input type="date" name="fecha" value="<?php echo $juego["fecha_lanzamiento"]; ?>"><br>

                Distribuidora:
                <!-- Haremos que el usuario deba seleccionar las diferentes opciones de un "select" -->
                <select name="distribuidora">
                    <?php

                    // =========================================================================
                    /* Con este while se hacen tres cosas a la vez:
                        +   Se lee una fila que sale de mysqli_fetch_array($distribuidoras).
                        +   Se guarda la fila resultante en $fila.
                        +   Se compeueba si es válida. Si no lo es, el while para.

                        Nuestro objetivo es coger la id y el nombre de cada fila, e ir generando
                        una serie de elementos "option" que se almacenará en el "select" que lo
                        contiente.*/
                    while ($fila = mysqli_fetch_array($distribuidoras)) {
                        // Si la id de la fila actual coincide con la del juego que queremos modificar, saldrá seleccionada por defecto
                        if ($fila["id"] == $juego["distribuidora_id"]) {
                            echo "<option value='" . $fila["id"] . "' selected>" . $fila["nombre"] . "</option>";
                        } else {
                            echo "<option value='" . $fila["id"] . "'>" . $fila["nombre"] . "</option>";
                        }
                    }
                    ?>
                </select><br>

                Desarrolladora:
                <!-- El proceso es idéntico al de Distribuidora. -->
                <select name="desarrolladora">
                    <?php
                    while ($fila = mysqli_fetch_array($desarrolladoras)) {

                        if ($fila["id"] == $juego["desarrolladora_id"]) {
                            echo "<option value='" . $fila["id"] . "' selected>" . $fila["nombre"] . "</option>";
                        } else {
                            echo "<option value='" . $fila["id"] . "'>" . $fila["nombre"] . "</option>";
                        }
                    }
                    ?>
                </select><br>

                <!-- Enviamos la edición -->
                <input type="submit" value="Actualizar">

            </form>

            <br>
            <!-- Volvemos al listado -->
            <a href="bd_videojuegos_listado.php">Volver al listado</a>

            <?php
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