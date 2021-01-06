<?php

use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxApp;

try {

    session_start();

    if (isset($_SESSION['uuid_usuario']) && isset($_SESSION['login_admin_pass'])) {

        if (isset($_REQUEST['modificar_usuario'])) {

            include("../../../resources/mysqli.inc.php");
            $conexion = mysqli_connect($cfg_servidor, $cfg_usuario, $cfg_password, $cfg_basephp);

            $string = $_SESSION['uuid_usuario'];

            $correo_usuario_mod = htmlspecialchars($_REQUEST['correo']);
            $nick_usuario_mod = htmlspecialchars($_REQUEST['nick']);
            $nombre_usuario_mod = htmlspecialchars($_REQUEST['nombre']);
            $pass_usuario_mod = htmlspecialchars($_REQUEST['pass']);
            $pais_usuario_mod = $_REQUEST['pais'];
            $saldo_usuario_mod = $_REQUEST['saldo'];

            $imagen_size = $_FILES['imagen']['size'];
            if ($imagen_size == 0) {
                $sentencia = "UPDATE usuario SET correo_usuario='$correo_usuario_mod',nick_usuario='$nick_usuario_mod',nombre_usuario='$nombre_usuario_mod',password_usuario='$pass_usuario_mod',pais_usuario='$pais_usuario_mod',saldo_usuario='$saldo_usuario_mod' WHERE uuid_usuario='$string'";
            } else {
                require_once '../../../resources/dropbox/vendor/autoload.php';
                include("../../../resources/dropbox.inc.php");
                $app = new DropboxApp($dropboxKey, $dropboxSecret, $dropboxToken);
                $dropbox = new Dropbox($app);
                $nombre_del_archivo = pathinfo($_FILES['imagen']['name'], PATHINFO_FILENAME) . '_' . uniqid();
                $tempfile = $_FILES['imagen']['tmp_name'];
                $ext = explode(".", $_FILES['imagen']['name']);
                $ext = end($ext);
                $ruta = "users/" . $string . "/images";
                $nombredropbox = "/" . $ruta . "/" . $nombre_del_archivo . "." . $ext;
                $dropbox->simpleUpload($tempfile, $nombredropbox, ['autorename' => true]);
                $response = $dropbox->postToAPI("/sharing/create_shared_link_with_settings", [
                    "path" => $nombredropbox
                ]);
                $data = $response->getDecodedBody();
                $imagen_usuario_mod = substr($data['url'], 0, strlen($data['url']) - 4) . 'raw=1';

                $sentencia = "UPDATE usuario SET correo_usuario='$correo_usuario_mod',nick_usuario='$nick_usuario_mod',nombre_usuario='$nombre_usuario_mod',password_usuario='$pass_usuario_mod',pais_usuario='$pais_usuario_mod',saldo_usuario='$saldo_usuario_mod',imagen_usuario='$imagen_usuario_mod' WHERE uuid_usuario='$string'";
            }

            mysqli_query($conexion, $sentencia);
            if (mysqlI_errno($conexion) == 0) {
                echo '<script>setTimeout(()=>{alert("El usuario ha sido modificado correctamente");},100);</script>';
            } else {
                if (mysqli_errno($conexion) == 1062) {
                    echo '<script>setTimeout(()=>{alert("ERROR:\n\nEl usuario no ha sido modificado porque el correo electrónico o el nick ya existe en la base de datos");},100);</script>';
                } else {
                    $numerror = mysqli_errno($conexion);
                    $descrerror = mysqli_error($conexion);
                    echo '<script>setTimeout(()=>{alert("SE HA PRODUCIDO UN ERROR EN LA OPERACIÓN:\n\nSe ha producido el error num. ' . $numerror . ' que corresponde a: ' . $descrerror . '");},100);</script>';
                }
                if (isset($dropbox))
                    $dropbox->delete($nombredropbox);
            }
            mysqli_close($conexion);
            echo '<script>location.href="usuarios.php";</script>';
        } else header("Location:usuarios.php");
    } else header("Location:usuarios.php");
} catch (Exception $e) {
    echo '<script type="application/javascript">setTimeout(() => {alert("Exception: ', $e, '");}, 100);</script>';
}
