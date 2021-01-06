<?php

try {
    session_start();

    function cerrarSesion()
    {
        if (isset($_REQUEST['cerrar_sesion'])) {
            global $conexion;
            mysqli_close($conexion);
            unset($_SESSION['login_admin_pass']);
            if (isset($_SESSION['uuid_artista'])) {
                unset($_SESSION['uuid_artista']);
            }
            if (isset($_SESSION['uuid_usuario'])) {
                unset($_SESSION['uuid_usuario']);
            }
            header("Location:..");
        }
    }

    function mostrarUsuarios()
    {
        global $conexion;
        $sentencia = "SELECT * FROM usuario ORDER BY correo_usuario";
        $resultado = mysqli_query($conexion, $sentencia);
        $num_resultados = mysqli_num_rows($resultado);
        echo '
        <fieldset>
            <legend>USUARIOS</legend>';
        if ($num_resultados != 0) {
            echo '
            <form method="POST" action="elimod_usuario.php">
            <table>
                <tr> 
                    <td class="gris"; colspan=11>RESULTADO/S: ', $num_resultados, ' USUARIO/S DISPONIBLE/S</td>
                </tr>
                <tr>
                    <th class="gris";>UUID</th>
                    <th class="gris";>CORREO</th>
                    <th class="gris";>NICK</th>
                    <th class="gris";>NOMBRE</th>
                    <th class="gris";>PASSWORD</th>
                    <th class="gris";>PA&Iacute;S</th>
                    <th class="gris";>FECHA DE ALTA</th>
                    <th class="gris";>IMAGEN</th>
                    <th class="gris";>SALDO</th>
                    <th class="bcred">ELI.</th>
                    <th class="bcblack">MOD.</th>
                </tr>';
            while ($array = mysqli_fetch_assoc($resultado)) {
                echo '
                <tr>';
                foreach ($array as $indice => $valor) {
                    if ($indice == 'imagen_usuario') {
                        echo '
                            <td>
                            <img class="perfil---img" src="', $valor, '" alt="User image">
                            </td>';
                    } elseif ($indice == 'saldo_usuario') {
                        echo '<td>', $valor, '€</td>';
                    } else
                        echo '<td>', $valor, '</td>';
                }
                echo '
                    <td class="bcred">
                        <input type="radio" name="elimina" value=', $array['uuid_usuario'], '>
                    </td>
                    <td class="bcblack">
                        <input type="radio" name="radio_usuario" value=', $array['uuid_usuario'], '>
                    </td>
                </tr>';
            }
            echo '
            </table>
            <input type="submit" name="modificar_registro" class="bcblack" value="MODIFICAR USUARIO">
            <input type="submit" name="eliminar_registros_marcados" class="bcred" value="ELIMINAR USUARIO"> <input type="reset" class="admin-subres" value="RESTABLECER">
            </form>';
        } else {
            echo '<p class="notemas-p">No hay usuarios disponibles</p>';
        }
        echo '</fieldset>';
    }

    if (isset($_SESSION['login_admin_pass'])) {

        echo '
        <!DOCTYPE html>
        <html>

        <head>
            <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
            <title>♛ ⚇ Sesi&oacute;n Iniciada</title>
            <link rel="icon" type="image/png" href="../../../images/icon.PNG">
            <link rel="stylesheet" type="text/css" href="../../../styles/styles.css">
            <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap" rel="stylesheet">
            <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        </head>

        <body class="admin-body">
            <nav class="private-nav">
                <form method="POST">
                    <input type="submit" class="nav-sub-admin" name="cerrar_sesion" value="CERRAR SESIÓN">
                </form>
                <input type="button" class="nav-sub-admin" onclick="mostrarHome();" value="HOME">
            </nav>
            <main class="private-div main-centrado">';

        cerrarSesion();

        include("../../../resources/mysqli.inc.php");
        $conexion = mysqli_connect($cfg_servidor, $cfg_usuario, $cfg_password, $cfg_basephp);

        mostrarUsuarios();

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
