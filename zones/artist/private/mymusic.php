<?php

try {
    session_start();

    function cerrarSesion()
    {
        if (isset($_REQUEST['cerrar_sesion'])) {
            global $conexion;
            mysqli_close($conexion);
            unset($_SESSION['login_artist_uuid']);
            if (isset($_SESSION['uuid_tema'])) {
                unset($_SESSION['uuid_tema']);
            }
            header("Location:..");
        }
    }

    function mostrarTemas()
    {
        global $conexion, $uuid;
        $sentencia = "SELECT * FROM tema WHERE uuid_artista_tema='$uuid' ORDER BY nombre_tema";
        $resultado = mysqli_query($conexion, $sentencia);
        $num_resultados = mysqli_num_rows($resultado);
        echo '
        <fieldset>
            <legend>MyMusic</legend>';
        if ($num_resultados != 0) {
            echo '
            <form method="POST" action="elimod_tema.php">
            <table>
                <tr> 
                    <td class="morado"; colspan=11>RESULTADO/S: ', $num_resultados, ' TEMA/S DISPONIBLE/S</td>
                </tr>
                <tr>
                    <th>NOMBRE</th>
                    <th>MP3 COMPLETO</th>
                    <th>MP3 TEASER</th>
                    <th>CATEGOR&Iacute;A</th>
                    <th>N&Uacute;M. DESCARGAS</th>
                    <th>NOTA</th>
                    <th>IMAGEN</th>
                    <th>PRECIO</th>
                    <th>ESTADO</th>
                    <th class="bcred">ELI.</th>
                    <th class="bcgray">MOD.</th>
                </tr>';
            while ($array = mysqli_fetch_assoc($resultado)) {
                echo '
                <tr>';
                foreach ($array as $indice => $valor) {
                    if ($indice != "uuid_tema" && $indice != "uuid_artista_tema" && $indice != "fecha_lanzamiento_tema") {
                        if ($indice == 'completo_tema' || $indice == 'teaser_tema') {
                            echo '
                                <td>
                                    <audio type="audio/mpeg" src="', $valor, '" controls><p>Su navegador no soporta HTML5 (Sí en Opera, Chrome y Firefox)</p></audio>
                                </td>';
                        } elseif ($indice == 'imagen_tema') {
                            echo '
                                <td>
                                <img class="tema-img" src="', $valor, '" alt="Theme image">
                                </td>';
                        } else {
                            if ($indice == 'precio_tema') {
                                echo '<td>', $valor, '€</td>';
                            } else
                                echo '<td>', $valor, '</td>';
                        }
                    }
                }
                echo '
                    <td class="bcred">
                        <input type="radio" name="elimina" value=', $array['uuid_tema'], '>
                    </td>
                    <td class="bcgray">
                        <input type="radio" name="radio_tema" value=', $array['uuid_tema'], '>
                    </td>
                </tr>';
            }
            echo '
            </table>
            <input type="submit" name="modificar_registro" class="artist-subres bcgray" value="MODIFICAR TEMA">
            <input type="submit" name="eliminar_registros_marcados" class="artist-subres bcred" value="ELIMINAR TEMA"> <input type="reset" class="artist-subres" value="RESTABLECER">
            </form>';
        } else {
            echo '<p class="notemas-p">No hay temas disponibles</p>';
        }
        echo '</fieldset>';
    }

    if (isset($_SESSION['login_artist_uuid'])) {

        echo '
        <!DOCTYPE html>
        <html>
        
        <head>
            <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
            <title>⚉ ☁ Sesi&oacute;n Iniciada</title>
            <link rel="icon" type="image/png" href="../../../images/icon.PNG">
            <link rel="stylesheet" type="text/css" href="../../../styles/styles.css">
            <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap" rel="stylesheet">
            <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        </head>
        
        <body class="artist-body">
            <nav class="private-nav">
                <form method="POST">
                    <input type="submit" class="nav-sub-artist" name="cerrar_sesion" value="CERRAR SESIÓN">
                </form>
                <input type="button" class="nav-sub-artist" onclick="mostrarHome();" value="HOME">
            </nav>
            <main class="private-div">
        ';

        cerrarSesion();

        $uuid = $_SESSION['login_artist_uuid'];
        include("../../../resources/mysqli.inc.php");
        $conexion = mysqli_connect($cfg_servidor, $cfg_usuario, $cfg_password, $cfg_basephp);

        mostrarTemas();

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
