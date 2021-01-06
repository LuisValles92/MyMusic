<?php

use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxApp;

try {

    session_start();

    if (isset($_SESSION['uuid_artista']) && isset($_SESSION['login_admin_pass'])) {

        if (isset($_REQUEST['modificar_artista'])) {

            include("../../../resources/mysqli.inc.php");
            $conexion = mysqli_connect($cfg_servidor, $cfg_usuario, $cfg_password, $cfg_basephp);

            $string = $_SESSION['uuid_artista'];

            $correo_artista_mod = htmlspecialchars($_REQUEST['correo']);
            $nombre_artistico_artista_mod = htmlspecialchars($_REQUEST['nombre_artistico']);
            $nombre_artista_mod = htmlspecialchars($_REQUEST['nombre']);
            $pass_artista_mod = htmlspecialchars($_REQUEST['pass']);
            $pais_artista_mod = $_REQUEST['pais'];
            $biografia_artista_mod = htmlspecialchars($_REQUEST['biografia']);
            $saldo_artista_mod = $_REQUEST['saldo'];
            $estado_a = $_REQUEST['estado'];
            if ($estado_a == 'activo') {
                $estado_artista_mod = true;
            } else {
                $estado_artista_mod = false;
            }

            $imagen_size = $_FILES['imagen']['size'];
            if ($imagen_size == 0) {
                $sentencia = "UPDATE artista SET correo_artista='$correo_artista_mod',nombre_artistico_artista='$nombre_artistico_artista_mod',nombre_artista='$nombre_artista_mod',password_artista='$pass_artista_mod',pais_artista='$pais_artista_mod',bio_artista='$biografia_artista_mod',saldo_artista='$saldo_artista_mod',estado_artista='$estado_artista_mod' WHERE uuid_artista='$string'";
            } else {
                require_once '../../../resources/dropbox/vendor/autoload.php';
                include("../../../resources/dropbox.inc.php");
                $app = new DropboxApp($dropboxKey, $dropboxSecret, $dropboxToken);
                $dropbox = new Dropbox($app);
                $nombre_del_archivo = pathinfo($_FILES['imagen']['name'], PATHINFO_FILENAME) . '_' . uniqid();
                $tempfile = $_FILES['imagen']['tmp_name'];
                $ext = explode(".", $_FILES['imagen']['name']);
                $ext = end($ext);
                $ruta = "artists/" . $string . "/images";
                $nombredropbox = "/" . $ruta . "/" . $nombre_del_archivo . "." . $ext;
                $dropbox->simpleUpload($tempfile, $nombredropbox, ['autorename' => true]);
                $response = $dropbox->postToAPI("/sharing/create_shared_link_with_settings", [
                    "path" => $nombredropbox
                ]);
                $data = $response->getDecodedBody();
                $imagen_artista_mod = substr($data['url'], 0, strlen($data['url']) - 4) . 'raw=1';

                $sentencia = "UPDATE artista SET correo_artista='$correo_artista_mod',nombre_artistico_artista='$nombre_artistico_artista_mod',nombre_artista='$nombre_artista_mod',password_artista='$pass_artista_mod',pais_artista='$pais_artista_mod',bio_artista='$biografia_artista_mod',saldo_artista='$saldo_artista_mod',estado_artista='$estado_artista_mod',imagen_artista='$imagen_artista_mod' WHERE uuid_artista='$string'";
            }

            mysqli_query($conexion, $sentencia);
            if (mysqlI_errno($conexion) == 0) {
                echo '<script>setTimeout(()=>{alert("El artista ha sido modificado correctamente");},100);</script>';
            } else {
                if (mysqli_errno($conexion) == 1062) {
                    echo '<script>setTimeout(()=>{alert("ERROR:\n\nEl artista no ha sido modificado porque el correo electrónico o el nombre artístico ya existe en la base de datos");},100);</script>';
                } else {
                    $numerror = mysqli_errno($conexion);
                    $descrerror = mysqli_error($conexion);
                    echo '<script>setTimeout(()=>{alert("SE HA PRODUCIDO UN ERROR EN LA OPERACIÓN:\n\nSe ha producido el error num. ' . $numerror . ' que corresponde a: ' . $descrerror . '");},100);</script>';
                }
                if (isset($dropbox))
                    $dropbox->delete($nombredropbox);
            }
            mysqli_close($conexion);
            echo '<script>location.href="artistas.php";</script>';
        } else header("Location:artistas.php");
    } else header("Location:artistas.php");
} catch (Exception $e) {
    echo '<script type="application/javascript">setTimeout(() => {alert("Exception: ', $e, '");}, 100);</script>';
}
