<?php

//////////////////////////////////////////////////////////////////
//              ESTE SCRIPT ES SOLO PARA PRACTICAR              //
//////////////////////////////////////////////////////////////////

//Conexión con el servidor MySQL
$bd = mysqli_connect("localhost", "root", "", "a27_pedrolopezgarcia_biblioteca_videojuegos");

//Seleccionamos el juego de caracteres
mysqli_set_charset($bd, "utf8");

mysqli_select_db($bd, "a27_pedrolopezgarcia_biblioteca_videojuegos");

//Preparamos consultas SQL
$consulta = "SELECT * FROM vista_juegos";

//Le pasamos el objeto de la bd y la consulta SQL a ejecutar
$resultado = mysqli_query($bd, $consulta);

while ($fila = mysqli_fetch_array($resultado)) {
    $id = $fila["id"];
    $nombre = $fila["nombre"];
    $fechaLanzamiento = $fila["fecha_lanzamiento"];
    $distribuidora = $fila["distribuidora"];
    $desarolladora = $fila["desarrolladora"];

    print ($id . " | " . $nombre . " | " . $fechaLanzamiento . " | " . $distribuidora . " | " . $desarolladora . "<br>");
}

mysqli_close($bd);

?>