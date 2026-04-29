<?php
// =========================================================================
// CONECTAR CON LA BASE DE DATOS
function conectarBDA($host, $usuario, $pass, $bda){
    /* Intentamos conectar con la base de datos, usando las variables que
    hemos creado en el archivo de datos.php. */

    $resultado = mysqli_connect($host, $usuario, $pass, $bda);

    if (!$resultado) {
        return false;
    } else {

        /* Si se ha podido conectar, estableceremos el sistema de caracteres
        UTF8, para evitar desajustes con tildes, símbolos y demás. */
        
        mysqli_set_charset($resultado, "utf8");
        return $resultado;
    }
}

// =========================================================================
// FUNCIONES OBTENCIÓN DE TABLAS
/*
    Estas tres funciones hacen, en esencia, lo mismo. Primero, podemos ver
    que cada función tiene la variable "conexion", que hace referencia a los
    datos vistos en datos.php.
    
    Después, dentro de la función, se declara en la variable "$consulta"" la
    consulta que vamos a hacer, cada una siendo análoga a la función y, por
    lo tanto, a la tabla que queremos mostrar.

    Esto será incluído en "mysqli_query()", el cuál se encarga de, en primer
    lugar, definir los datos de la tabla sobre la que haremos la consulta, y
    luego, qué consulta realizaremos.

    Desarrollaremos más la estructura con la función "obtenerJuegos".
*/

function obtenerJuegos($conexion){
    /** Usamos un SELECT * FROM para decirle qué tabla queremos mostrar.
     */
    $consulta = "SELECT * FROM vista_juegos";

    /* OJO: La tabla "vista_juegos" NO es la tabla donde se almacenan los
    datos. Sólo es la tabla con la que se muestran estos datos de forma
    más o menos estética. La tabla donde SÍ se almacenan los datos es
    la llamada "juegos". */

    /* En "mysqli_query" le decimos en qué base de datos hará la consulta
    en $conexion. Luego cuál será la consulta en $consulta. */
    $resultado = mysqli_query($conexion, $consulta);

    /* Devolvemos el resultado de esta operación. */
    return $resultado;
}

function obtenerDistribuidoras($conexion){
    $consulta = "SELECT * FROM distribuidora";
    $resultado = mysqli_query($conexion, $consulta);
    return $resultado;
}

function obtenerDesarrolladoras($conexion){
    $consulta = "SELECT * FROM desarrolladora";
    $resultado = mysqli_query($conexion, $consulta);
    return $resultado;
}

// =========================================================================
// BORRAR UN JUEGO
/*
    Borraremos un juego. Esta función recoge, por una parte, la tabla sobre
    la que actuará; y por otra, el id del juego que ha de buscar para
    borrar.

    Dentro de la función, crearemos una variable para almacenar la consulta
    que queremos hacer. En este caso un DELETE de la tabla "juegos".
*/

function borrarJuego($conexion, $id){
    /* Usamos un DELETE FROM para indicar sobre qué tabla se realizará el
    borrado, y el id para especificar cuál será el juego concreto que
    queremos borrar. */
    $consulta = "DELETE FROM juegos WHERE id = $id";

    /* mysqli_query() ejecuta la sentencia SQL y devuelve true o false
       según si la operación se ha podido realizar correctamente o no. */
    return mysqli_query($conexion, $consulta);
}

// =========================================================================
// INSERTAR UN JUEGO
/*
    Esta función necesitará, para empezar, dónde insertar el juego; en este
    caso en la tabla almacenada en "$conexion". Después, para la consulta,
    necesitará:

        + El nombre del juego.
        + La fecha de lanzamiento de este.
        + El ID de la distribuidora.
        + El ID de la desarrolladora.
*/

function insertarJuego($conexion, $nombre, $fecha, $distribuidora_id, $desarrolladora_id){
    /* Le pasamos cinco parámetros:
        + "$conexion",  la BD donde se inserta el juego.
        + "$nombre", un String del nombre del juego.
        + "$fecha", string en formato YYYY-MM-DD de la fecha del juego.
        + "$distribuidora_id", un int con el id de la distribuidora.
        + "$desarrolladora_id", un int con el id de la desarrolladora.

        Hará un INSERT INTO la tabla de juegos, y los valores de los
        atributos del nuevo elemento serán los de las variables que
        acabamos de mencionar.
    */
    $consulta = "INSERT INTO juegos (nombre, fecha_lanzamiento, distribuidora_id, desarrolladora_id)
                 VALUES ('$nombre', '$fecha', $distribuidora_id, $desarrolladora_id)";
    return mysqli_query($conexion, $consulta);
}

// =========================================================================
// OBTENER UN USUARIO
/* 
    Esta función busca un usuario concreto dentro de la tabla usuarios.
    La usaremos en el login para comprobar si el nombre de usuario existe
    en la base de datos y, si existe, poder comparar su contraseña.
    
    Si la consulta se realiza correctamente, devolverá la fila encontrada.
    En caso contrario, nos devolverá un false.
*/
function obtenerUsuario($conexion, $usuario){
    /* Realizamos una consulta SELECT sobre la tabla usuarios, filtrando
    por el nombre de usuario que hemos recibido. */
    $consulta = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        /* mysqli_fetch_array() obtiene una fila del resultado. Como en
        este caso buscamos un único usuario, solo necesitamos leer una
        fila. */
        $fila = mysqli_fetch_array($resultado);
        mysqli_free_result($resultado);
        return $fila;
    } else {
        return false;
    }
}

// =========================================================================
// OBTENER UN JUEGO POR ID
/* 
    Esta función busca un juego concreto dentro de la tabla juegos
    utilizando su id. La usaremos, por ejemplo, en la página de editar para
    cargar en el formulario los datos actuales del juego que queremos
    modificar.

    Si todo va bien, el juego aparecerá; si no es el caso, devolverá false.
*/
function obtenerJuegoPorId($conexion, $id){
    /* Hacemos una consulta SELECT sobre la tabla juegos, filtrando por el
    identificador del juego.*/
    $consulta = "SELECT * FROM juegos WHERE id = $id";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        /* Leemos la fila devuelta por la consulta. En este caso esperamos
        un único registro.*/
        $fila = mysqli_fetch_array($resultado);
        mysqli_free_result($resultado);
        return $fila;
    } else {
        return false;
    }
}

// =========================================================================
// ACTUALIZAR UN JUEGO
/* 
    Esta función modifica un registro ya existente en la tabla juegos.
    Recibe el id del juego y los nuevos valores que queremos guardar.

    Se usará en la página de editar para actualizar los datos del juego
    seleccionado.
*/
function actualizarJuego($conexion, $id, $nombre, $fecha, $distribuidora_id, $desarrolladora_id){
    /* Creamos una consulta UPDATE para modificar los campos del registro
    indicado en el WHERE. SET indica qué columnas vamos a cambiar y con qué
    valores. */
    $consulta = "UPDATE juegos 
                 SET nombre='$nombre',
                     fecha_lanzamiento='$fecha',
                     distribuidora_id=$distribuidora_id,
                     desarrolladora_id=$desarrolladora_id
                 WHERE id=$id";

    return mysqli_query($conexion, $consulta);
}
?>