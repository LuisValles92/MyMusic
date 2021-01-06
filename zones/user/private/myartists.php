<?php

try {
    session_start();

    function cerrarSesion()
    {
        if (isset($_REQUEST['cerrar_sesion'])) {
            global $conexion;
            mysqli_close($conexion);
            unset($_SESSION['login_user_uuid']);
            header("Location:..");
        }
    }

    function mostrarArtistas()
    {
        global $conexion;
        $sentencia = "SELECT imagen_artista, nombre_artistico_artista, nombre_artista, bio_artista FROM artista WHERE estado_artista=true ORDER BY nombre_artistico_artista";
        $resultado = mysqli_query($conexion, $sentencia);
        $num_resultados = mysqli_num_rows($resultado);
        echo '
        <fieldset>
            <legend>MyArtists</legend>';
        if ($num_resultados != 0) {
            echo '
            <table>
                <tr> 
                    <td class="verde"; colspan=4>RESULTADO/S: ', $num_resultados, ' ARTISTA/S DISPONIBLE/S</td>
                </tr>
                <tr>
                    <th class="verde";>IMAGEN</th>
                    <th class="verde";>NOMBRE ART.</th>
                    <th class="verde";>NOMBRE</th>
                    <th class="verde";>BIOGRAF&Iacute;A</th>
                </tr>';
            while ($array = mysqli_fetch_assoc($resultado)) {
                echo '
                <tr>';
                foreach ($array as $indice => $valor) {

                    if ($indice == 'imagen_artista') {
                        echo '
                                <td>
                                <img class="artistaplus-img" src="', $valor, '" alt="Artist image">
                                </td>';
                    } else {
                        echo '<td>', $valor, '</td>';
                    }
                }
                echo '
                </tr>';
            }
            echo '
            </table>';
        } else {
            echo '<p class="notemas-p">No hay artistas disponibles</p>';
        }
        echo '</fieldset>';
    }

    if (isset($_SESSION['login_user_uuid'])) {

        echo '
        <!DOCTYPE html>
        <html>
        
        <head>
            <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
            <title>⚇ ☁ ⚉</title>
            <link rel="icon" type="image/png" href="../../../images/icon.PNG">
            <link rel="stylesheet" type="text/css" href="../../../styles/styles.css">
            <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap" rel="stylesheet">
            <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        </head>
        
        <body class="user-body">
            <nav class="private-nav">
                <form method="POST">
                    <input type="submit" class="nav-sub-user" name="cerrar_sesion" value="CERRAR SESIÓN">
                </form>
                <input type="button" class="nav-sub-user" onclick="mostrarHome();" value="HOME">
            </nav>
            <main class="private-div">
        ';

        cerrarSesion();

        include("../../../resources/mysqli.inc.php");
        $conexion = mysqli_connect($cfg_servidor, $cfg_usuario, $cfg_password, $cfg_basephp);

        mostrarArtistas();

        echo '
            </main>
            <script type="application/javascript" src="../../../scripts/scripts.js"></script>
        </body>
    
        </html>';
    } else {
        header("Location:..");
    }
} catch (Exception $e) {
    echo '<script type="application/javascript">setTimeout(() => {alert("Exception: ', $e, '");}, 100);</script>';
}
