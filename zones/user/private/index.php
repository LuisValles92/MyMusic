<?php

use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxApp;

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

    function mostrarPerfilySaldo()
    {
        global $imagen, $nick, $nombre, $pais, $correo, $saldo, $conexion, $uuid;

        echo '
        <fieldset id="fs_perfil">
            <legend>PERFIL</legend>
            <img class="perfilimg" src="', $imagen, '" alt="User image">
            <p class="main-p">', $nick, '</p>
            <p>', $nombre, '</p>
            <p>', $pais, '</p>
            <p>', $correo, '</p>
        </fieldset>';

        // $saldo=50;
        echo '
        <fieldset class="saldo-fs-user" id="fs_saldo">
            <legend>SALDO</legend>
            <form action="" method="POST">
                <p>TOTAL: ', $saldo, '€</p>
                <input type="range" class="range-user" id="rango_saldo" name="rango_saldo" onchange="mostrarEuroSaldoUser();" min="0" max="15" step="5" value="0">
                <p id="euro_saldo">0€</p>
                <input type="submit" class="nav-sub-user cwhite sub-center" name="ingresar_saldo" id="ingresar_saldo" value="INGRESAR">
            </form>
        </fieldset>';

        if (isset($_REQUEST['ingresar_saldo'])) {
            $nuevo_saldo = $saldo + $_REQUEST['rango_saldo'];
            $sentencia = "UPDATE usuario SET saldo_usuario='$nuevo_saldo' WHERE uuid_usuario='$uuid'";
            mysqli_query($conexion, $sentencia);
            if (mysqli_affected_rows($conexion) == 1) {
                echo '<script>setTimeout(()=>{alert("Su saldo ha sido ingresado correctamente");},100); location.href=".";</script>';
            }
        }
    }

    function mostrarModificar()
    {
        global $correo, $nick, $nombre, $password, $conexion, $uuid;

        echo '
        <fieldset id="fs_modificar">
            <legend>MODIFICAR</legend>
            <form class="mod-form" action="" method="POST" enctype="multipart/form-data" onsubmit="return validationUserNoImage();">
                <label>* CORREO ELECTR&Oacute;NICO: (x@x.xx)</label>
                <input required type="text" name="correo" id="correo" placeholder="', $correo, '" value="', $correo, '">
                <label>PASSWORD: (De 7 a 14 caracteres y de al menos 2 may., 3 min. y 2 núm.)</label>
                <input required type="password" name="pass" id="pass" value="', $password, '">
                <label>* NICK: (Tapiado - Si desea modificar este valor consulte al administrador)</label>
                <input required disabled=true type="text" name="nick" id="nick" placeholder="', $nick, '" value="', $nick, '">
                <label>NOMBRE: (El primer caracter de cada palabra en may&uacute;scula, permite acentos y espacios)</label>
                <input required type="text" name="nombre" id="nombre" placeholder="', $nombre, '" value="', $nombre, '">
                <label>PA&Iacute;S:</label>
                <select name="pais" id="pais">
                </select>
                <label>IMAGEN: (Opcional)</label>
                <input type="file" name="imagen" id="imagen" accept="image/png, image/jpg, image/jpeg">
                <input type="reset" class="user-subres sub-center2" value="RESTABLECER">
                <input type="submit" class="user-subres sub-center2" name="modificar" value="MODIFICAR">
            </form>
        </fieldset>';

        if (isset($_REQUEST['modificar'])) {
            $correo_mod = htmlspecialchars($_REQUEST['correo']);
            $nombre_mod = htmlspecialchars($_REQUEST['nombre']);
            $pass_mod = htmlspecialchars($_REQUEST['pass']);
            $pais_mod = $_REQUEST['pais'];
            if ($_FILES['imagen']['size'] == 0) {
                $sentencia = "UPDATE usuario SET correo_usuario='$correo_mod', nick_usuario='$nick',nombre_usuario='$nombre_mod', password_usuario='$pass_mod', pais_usuario='$pais_mod' WHERE uuid_usuario='$uuid'";
            } else {
                require_once '../../../resources/dropbox/vendor/autoload.php';
                include("../../../resources/dropbox.inc.php");
                $app = new DropboxApp($dropboxKey, $dropboxSecret, $dropboxToken);
                $dropbox = new Dropbox($app);
                $nombre_del_archivo = pathinfo($_FILES['imagen']['name'], PATHINFO_FILENAME) . '_' . uniqid();
                $tempfile = $_FILES['imagen']['tmp_name'];
                $ext = explode(".", $_FILES['imagen']['name']);
                $ext = end($ext);
                $ruta = "users/" . $uuid . "/images";
                $nombredropbox = "/" . $ruta . "/" . $nombre_del_archivo . "." . $ext;
                $dropbox->simpleUpload($tempfile, $nombredropbox, ['autorename' => true]);
                $response = $dropbox->postToAPI("/sharing/create_shared_link_with_settings", [
                    "path" => $nombredropbox
                ]);
                $data = $response->getDecodedBody();
                $imagen_mod = substr($data['url'], 0, strlen($data['url']) - 4) . 'raw=1';

                $sentencia = "UPDATE usuario SET correo_usuario='$correo_mod', nick_usuario='$nick',nombre_usuario='$nombre_mod', password_usuario='$pass_mod', pais_usuario='$pais_mod', imagen_usuario='$imagen_mod' WHERE uuid_usuario='$uuid'";
            }
            mysqli_query($conexion, $sentencia);
            if (mysqlI_errno($conexion) == 0) {
                echo '<script>setTimeout(()=>{alert("Sus datos han sido modificados correctamente");},100); location.href=".";</script>';
            } else {
                if (mysqli_errno($conexion) == 1062) {
                    echo '<script>setTimeout(()=>{alert("ERROR:\n\nEl usuario no ha sido modificado porque el correo electrónico ya existe en la base de datos");},100);</script>';
                } else {
                    $numerror = mysqli_errno($conexion);
                    $descrerror = mysqli_error($conexion);
                    echo '<script>setTimeout(()=>{alert("SE HA PRODUCIDO UN ERROR EN LA OPERACIÓN:\n\nSe ha producido el error num. ' . $numerror . ' que corresponde a: ' . $descrerror . '");},100);</script>';
                }
                if (isset($dropbox))
                    $dropbox->delete($nombredropbox);
                echo '<script>location.href=".";</script>';
            }
        }
    }

    function mostrarEliminar()
    {
        global $conexion, $uuid;
        echo '<fieldset id="fs_eliminar" class="eliminar-fs">
            <legend>ELIMINAR</legend>
            <form class="mod-form2" action="" method="POST">
                <label>¿DESEA ELIMINAR SU CUENTA DE USUARIO DE FORMA PERMANENTE?</label>
                <p>* Si elimina su cuenta eliminar&aacute; consigo todas sus licencias adquiridas.</p>
                <input type="submit" class="bcred sub-center2" name="eliminar" value="ELIMINAR">
            </form>
        </fieldset>';

        if (isset($_REQUEST['eliminar'])) {
            $sentencia = "DELETE FROM licencia WHERE uuid_usuario_licencia='$uuid'";
            mysqli_query($conexion, $sentencia);
            $sentencia = "DELETE FROM usuario WHERE uuid_usuario='$uuid'";
            mysqli_query($conexion, $sentencia);
            if (mysqlI_errno($conexion) == 0) {

                require_once '../../../resources/dropbox/vendor/autoload.php';
                include("../../../resources/dropbox.inc.php");
                $app = new DropboxApp($dropboxKey, $dropboxSecret, $dropboxToken);
                $dropbox = new Dropbox($app);
                $ruta = "users/" . $uuid;
                $dropbox->delete("/" . $ruta);

                echo '<script>setTimeout(()=>{alert("EL USUARIO HA SIDO DADO DE BAJA CORRECTAMENTE");},100); location.href="..";</script>';
                mysqli_close($conexion);
                unset($_SESSION['login_user_uuid']);
            } else {
                $numerror = mysqli_errno($conexion);
                $descrerror = mysqli_error($conexion);
                echo '<script>setTimeout(()=>{alert("SE HA PRODUCIDO UN ERROR EN LA OPERACIÓN:\n\nSe ha producido el error num. ' . $numerror . ' que corresponde a: ' . $descrerror . '");},100);</script>';
                echo '<script>location.href=".";</script>';
            }
        }
    }

    function mostrarLicencias()
    {
        echo '
        <button id="botonmostrarartist" class="inslic-button" onclick="mostrarArtistasUser();">
            <i class="material-icons">mic</i>
        </button>
        <button id="botonmostrartemasuser" class="inslic-button" onclick="mostrarTemasUser();">
            <i class="material-icons">queue_music</i>
        </button>
        <button id="botonmostrarlicencias" class="inslic-button mb" onclick="mostrarLicenciasUser();">
            <i class="material-icons">library_music</i>
        </button>';
    }

    if (isset($_SESSION['login_user_uuid'])) {

        echo '
        <!DOCTYPE html>
        <html>
        
        <head>
            <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
            <title>⚇ Sesi&oacute;n Iniciada</title>
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
                <input type="button" class="nav-sub-user" value="CLOUD" onclick="mostrarCloud();">
                <input type="button" onclick="mostrarEliUser(this);" class="nav-sub-user" value="ELIMINAR">
                <input type="button" onclick="mostrarModUser(this);" class="nav-sub-user" value="MODIFICAR">
                <input type="button" onclick="mostrarLic(this);" class="nav-sub-user" value="LICENCIAS">
                <input type="button" onclick="mostrarPerfilSaldoUser(this);" class="nav-sub-user button_activo" value="PERFIL / SALDO">
            </nav>
            <main class="private-div">';

        cerrarSesion();

        $uuid = $_SESSION['login_user_uuid'];
        include("../../../resources/mysqli.inc.php");
        $conexion = mysqli_connect($cfg_servidor, $cfg_usuario, $cfg_password, $cfg_basephp);
        $sentencia = "SELECT * FROM usuario WHERE uuid_usuario='$uuid'";
        $resultado = mysqli_query($conexion, $sentencia);
        $array = mysqli_fetch_array($resultado);
        $correo = $array['correo_usuario'];
        $nick = $array['nick_usuario'];
        $nombre = $array['nombre_usuario'];
        $password = $array['password_usuario'];
        $pais = $array['pais_usuario'];
        $fecha_alta = $array['fecha_alta_usuario'];
        $imagen = $array['imagen_usuario'];
        $saldo = $array['saldo_usuario'];

        mostrarPerfilySaldo();
        mostrarModificar();
        mostrarEliminar();
        mostrarLicencias();

        echo '
            </main>
            <script type="application/javascript" src="../../../scripts/scripts.js"></script>
            <script type="application/javascript">
                for (let i = 0; i < document.getElementById("pais").options.length; i++) {
                    if (document.getElementById("pais").options.item(i).value == "', $pais, '") {
                        document.getElementById("pais").options.item(i).setAttribute("selected", "selected");
                    }
                }
            </script>
        </body>
    
        </html>';
    } else {
        header("Location:..");
    }
} catch (Exception $e) {
    echo '<script type="application/javascript">setTimeout(() => {alert("Exception: ', $e, '");}, 100);</script>';
}
