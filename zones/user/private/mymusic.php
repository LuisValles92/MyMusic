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

    function mostrarTemas()
    {
        global $conexion;
        $sentencia = "SELECT T.uuid_tema, A.imagen_artista, A.nombre_artistico_artista, T.nombre_tema, T.teaser_tema, T.categoria_tema, T.numero_descargas_tema, T.nota_tema, T.imagen_tema, T.precio_tema FROM artista A, tema T WHERE A.uuid_artista=T.uuid_artista_tema AND A.estado_artista=true AND T.estado_tema=true ORDER BY A.nombre_artistico_artista";
        $resultado = mysqli_query($conexion, $sentencia);
        $num_resultados = mysqli_num_rows($resultado);
        echo '
        <fieldset>
            <legend>MyMusic</legend>';
        if ($num_resultados != 0) {
            echo '
            <form method="POST" action="adq_tema.php">
            <table>
                <tr> 
                    <td class="verde"; colspan=10>RESULTADO/S: ', $num_resultados, ' TEMA/S DISPONIBLE/S</td>
                </tr>
                <tr>
                    <th class="verde";>IMAGEN ART.</th>
                    <th class="verde";>NOMBRE ART.</th>
                    <th class="verde";>NOMBRE TEM.</th>
                    <th class="verde";>MP3 TEASER</th>
                    <th class="verde";>CATEGOR&Iacute;A</th>
                    <th class="verde";>N&Uacute;M. DESCARGAS</th>
                    <th class="verde";>NOTA</th>
                    <th class="verde";>IMAGEN TEM.</th>
                    <th class="verde";>PRECIO</th>
                    <th class="bcmoney">COM.</th>
                </tr>';
            while ($array = mysqli_fetch_assoc($resultado)) {
                echo '
                <tr>';
                foreach ($array as $indice => $valor) {
                    if ($indice != "uuid_tema") {
                        if ($indice == 'teaser_tema') {
                            echo '
                                <td>
                                    <audio type="audio/mpeg" src="', $valor, '" controls controlsList="nodownload"><p>Su navegador no soporta HTML5 (Sí en Opera, Chrome y Firefox)</p></audio>
                                </td>';
                        } elseif ($indice == 'imagen_artista' || $indice == 'imagen_tema') {
                            if ($indice == 'imagen_artista') {
                                echo '
                                <td>
                                <img class="artista-img" src="', $valor, '" alt="Artist image">
                                </td>';
                            } else {
                                echo '
                                <td>
                                <img class="tema-img" src="', $valor, '" alt="Theme image">
                                </td>';
                            }
                        } else {
                            if ($indice == 'precio_tema') {
                                echo '<td>', $valor, '€</td>';
                            } else
                                echo '<td>', $valor, '</td>';
                        }
                    }
                }
                echo '
                    <td class="bcmoney">
                        <input type="radio" name="radio_tema" value=', $array['uuid_tema'], '>
                    </td>
                </tr>';
            }
            echo '
            </table>
            <input type="submit" name="comprar_registro" class="user-subres bcmoney" value="COMPRAR TEMA">
            <input type="reset" class="user-subres" value="RESTABLECER">
            </form>';
        } else {
            echo '<p class="notemas-p">No hay temas disponibles</p>';
        }
        echo '</fieldset>';
    }

    if (isset($_SESSION['login_user_uuid'])) {

        echo '
        <!DOCTYPE html>
        <html>
        
        <head>
            <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
            <title>⚇ ☁ Sesi&oacute;n Iniciada</title>
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

        $uuid = $_SESSION['login_user_uuid'];
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
