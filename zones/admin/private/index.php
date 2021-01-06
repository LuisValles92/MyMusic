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

    if (isset($_SESSION['login_admin_pass'])) {

        echo '
        <!DOCTYPE html>
        <html>

        <head>
            <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
            <title>♛ Sesi&oacute;n Iniciada</title>
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
                <input type="button" class="nav-sub-admin" value="CLOUD" onclick="mostrarCloud();">
            </nav>
            <main class="private-div main-centrado">
                <h1 class="h1-subrayado">ZONA DE ADMINISTRADOR INICIADA</h1>
                <button id="botonmostrarusuarios" class="mosusar-button mb" onclick="mostrarUsuarios();">
                    <i class="material-icons">supervised_user_circle</i>
                </button>
                <button id="botonmostrarartistas" class="mosusar-button mb" onclick="mostrarArtistas();">
                    <i class="material-icons">queue_music</i>
                </button>';

        cerrarSesion();

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
