<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bd_videojuegos_estilo.css">
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
        /* Se llama a la función conectarBDA, que nos dirá si ha fallado o
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
            comprobación, si existe un nombre, significa que el usuario ha pulsado el
            botón de insertar y que los datos han sido enviados por POST. */
            if (isset($_POST["nombre"])) {
                //Comprobamos que los datos no estén vacíos
                if ($_POST["nombre"] != "" && $_POST["fecha"] != "" && $_POST["distribuidora"] != "" && $_POST["desarrolladora"] != "") {

                    //Copiamos los datos del formulario a sus variables correspondientes
                    $nombre = $_POST["nombre"];
                    $fecha = $_POST["fecha"];
                    $distribuidora_id = $_POST["distribuidora"];
                    $desarrolladora_id = $_POST["desarrolladora"];

                    // =========================================================================
                    /* Este if comprueba si la función insertarJuego se ha ejecutado de forma
                    correcta. Antes de dicha comprobación, se ejecutan los comandos de la
                    función y luego se evalúan. */
                    if (insertarJuego($conexion, $nombre, $fecha, $distribuidora_id, $desarrolladora_id)) {
                        $mensaje = "Juego insertado correctamente";
                    } else {
                        $mensaje = "Error al insertar";
                    }

                } else {
                    $mensaje = "Debes rellenar todos los campos";
                }
            }

            // =========================================================================
            /* Este no es un array al uso, ya que se devuelven muchas filas de info. Es
            un tipo de array propio de MySQL; del cuál, después, los recorreremos con un
            mysqli_fetch_array() para obtener los datos de cada fila. */
            $distribuidoras = obtenerDistribuidoras($conexion);
            $desarrolladoras = obtenerDesarrolladoras($conexion);
            ?>

            <h1>Insertar juego</h1>

            <?php

            // =========================================================================
            /* Activamos el mensaje siempre que el contenido de este no esté vacío. */
            if ($mensaje != "") {
                echo "<p>" . $mensaje . "</p>";
            }
            ?>

            <!-- Formulario con el que editaremos los juegos -->
            <!-- Primero, tanto el nombre del juego como la fecha de este serán puestas
             a mano por el usuario. Después, seleccionará de una lista tanto la empresa
             distribuidora como la desarrolladora. -->
            <form method="POST">
                Nombre: <input type="text" name="nombre"><br>
                Fecha lanzamiento: <input type="date" name="fecha"><br>

                Distribuidora:
                <!-- Haremos que el usuario deba seleccionar las diferentes opciones de un "select" -->
                <select name="distribuidora">
                    <?php
                    // =========================================================================
                    /* Con este while se hacen tres cosas a la vez:
                        +   Se lee una fila que sale de mysqli_fetch_array($distribuidoras).
                        +   Se guarda la fila resultante en $fila.
                        +   Se comprueba si es válida. Si no lo es, el while para.

                        Nuestro objetivo es coger la id y el nombre de cada fila, e ir generando
                        una serie de elementos "option" que se almacenará en el "select" que lo
                        contiente.*/
                    while ($fila = mysqli_fetch_array($distribuidoras)) {
                        echo "<option value='" . $fila["id"] . "'>" . $fila["nombre"] . "</option>";
                    }
                    ?>
                </select><br>

                Desarrolladora:
                <!-- El proceso es idéntico al de Distribuidora. -->
                <select name="desarrolladora">
                    <?php
                    while ($fila = mysqli_fetch_array($desarrolladoras)) {
                        echo "<option value='" . $fila["id"] . "'>" . $fila["nombre"] . "</option>";
                    }
                    ?>
                </select><br>
                <!-- Enviamos el nuevo juego -->
                <input type="submit" value="Insertar">
            </form>

            <br>
            <!-- Volvemos al listado -->
            <a href="bd_videojuegos_listado.php">Volver al listado</a>

        </body>

        </html>

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