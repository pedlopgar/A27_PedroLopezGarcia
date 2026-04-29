<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bd_videojuegos_estilos.css">
    <title>Logout</title>
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
        unset($_SESSION["usuario"]); // Primero, borramos el usuario activo. Así ya no ha nadie logeado
        session_destroy(); // Cerramos completamente la sesión actual del servidor.
        /* Con esto, nos aseguramos de vaciar los datos del usuario que ha iniciado antes
        de cerrarla. Así, la cookie del navegador obligará al usuario a volver a iniciar
        sesión, ya uqe ahora ya no hay información a la cuál la cookie pueda apuntar. */
        echo "Sesión cerrada.<br>";
    } else {
        echo "No hay sesión abierta.<br>";
    }
    // Enlace para volver al login
    echo "<a href='bd_videojuegos_login.php'>Volver al login</a>";
    ?>

</body>

</html>