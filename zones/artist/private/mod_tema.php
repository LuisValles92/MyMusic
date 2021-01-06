<?php

use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxApp;

try {

    session_start();

    if (isset($_SESSION['uuid_tema']) && isset($_SESSION['login_artist_uuid'])) {

        if (isset($_REQUEST['modificar_tema'])) {

            include("../../../resources/mysqli.inc.php");
            $conexion = mysqli_connect($cfg_servidor, $cfg_usuario, $cfg_password, $cfg_basephp);

            $string = $_SESSION['uuid_tema'];
            $categoria_tema_mod = $_REQUEST['categoria_tema'];
            $nota_tema_mod = htmlspecialchars($_REQUEST['nota_tema']);
            $precio_tema_mod = $_REQUEST['precio_tema'];
            $estado_t = $_REQUEST['estado_tema'];
            if ($estado_t == 'activo') {
                $estado_tema_mod = true;
            } else {
                $estado_tema_mod = false;
            }

            $imagen_size = $_FILES['imagen_tema']['size'];
            if ($imagen_size == 0) {
                $sentencia = "UPDATE tema SET categoria_tema='$categoria_tema_mod',nota_tema='$nota_tema_mod',precio_tema='$precio_tema_mod',estado_tema='$estado_tema_mod' WHERE uuid_tema='$string'";
            } else {
                require_once '../../../resources/dropbox/vendor/autoload.php';
                include("../../../resources/dropbox.inc.php");
                $app = new DropboxApp($dropboxKey, $dropboxSecret, $dropboxToken);
                $dropbox = new Dropbox($app);
                $nombre_del_archivo = pathinfo($_FILES['imagen_tema']['name'], PATHINFO_FILENAME) . '_' . uniqid();
                $tempfile = $_FILES['imagen_tema']['tmp_name'];
                $ext = explode(".", $_FILES['imagen_tema']['name']);
                $ext = end($ext);
                $ruta = "themes/" . $string . "/images";
                $nombredropbox = "/" . $ruta . "/" . $nombre_del_archivo . "." . $ext;
                $dropbox->simpleUpload($tempfile, $nombredropbox, ['autorename' => true]);
                $response = $dropbox->postToAPI("/sharing/create_shared_link_with_settings", [
                    "path" => $nombredropbox
                ]);
                $data = $response->getDecodedBody();
                $imagen_tema_mod = substr($data['url'], 0, strlen($data['url']) - 4) . 'raw=1';

                $sentencia = "UPDATE tema SET categoria_tema='$categoria_tema_mod',nota_tema='$nota_tema_mod',precio_tema='$precio_tema_mod',estado_tema='$estado_tema_mod',imagen_tema='$imagen_tema_mod' WHERE uuid_tema='$string'";
            }

            mysqli_query($conexion, $sentencia);
            if (mysqlI_errno($conexion) == 0) {
                echo '<script>setTimeout(()=>{alert("El tema ha sido modificado correctamente");},100);</script>';
            } else {
                $numerror = mysqli_errno($conexion);
                $descrerror = mysqli_error($conexion);
                echo '<script>setTimeout(()=>{alert("SE HA PRODUCIDO UN ERROR EN LA OPERACIÓN:\n\nSe ha producido el error num. ' . $numerror . ' que corresponde a: ' . $descrerror . '");},100);</script>';
                if (isset($dropbox))
                    $dropbox->delete($nombredropbox);
            }
            mysqli_close($conexion);
            echo '<script>location.href="mymusic.php";</script>';
        } else header("Location:mymusic.php");
    } else header("Location:mymusic.php");
} catch (Exception $e) {
    echo '<script type="application/javascript">setTimeout(() => {alert("Exception: ', $e, '");}, 100);</script>';
}
