<?php

use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxApp;

try {

    session_start();

    if (isset($_REQUEST['eliminar_registros_marcados'])) {

        if (isset($_REQUEST['elimina'])) {
            $string = $_REQUEST['elimina'];

            include("../../../resources/mysqli.inc.php");
            $conexion = mysqli_connect($cfg_servidor, $cfg_usuario, $cfg_password, $cfg_basephp);
            mysqli_query($conexion, "DELETE FROM usuario WHERE uuid_usuario='$string'");

            if (mysqlI_errno($conexion) == 0) {

                require_once '../../../resources/dropbox/vendor/autoload.php';
                include("../../../resources/dropbox.inc.php");
                $app = new DropboxApp($dropboxKey, $dropboxSecret, $dropboxToken);
                $dropbox = new Dropbox($app);
                $ruta = "users/" . $string;
                $dropbox->delete("/" . $ruta);

                echo '<script>setTimeout(()=>{alert("El usuario seleccionado ha sido eliminado correctamente");},100);</script>';
            } else {
                if (mysqli_errno($conexion) == 1451) {
                    echo '<script>setTimeout(()=>{alert("ERROR EN LA ELIMINACIÓN:\n\nEl usuario seleccionado posee licencias, éste sólo se puede eliminar desde su propia cuenta");},100);</script>';
                } else {
                    $numerror = mysqli_errno($conexion);
                    $descrerror = mysqli_error($conexion);
                    echo '<script>setTimeout(()=>{alert("SE HA PRODUCIDO UN ERROR EN LA OPERACIÓN:\n\nSe ha producido el error num. ' . $numerror . ' que corresponde a: ' . $descrerror . '");},100);</script>';
                }
            }
            echo '<script>location.href="usuarios.php";</script>';
            mysqli_close($conexion);
        } else echo '<script>alert("Seleccione un registro");location.href="usuarios.php";</script>';
    } elseif (isset($_REQUEST['modificar_registro'])) {
        if (isset($_REQUEST['radio_usuario'])) {

            echo '
            <!DOCTYPE html>
            <html>
            
            <head>
                <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
                <title>♛ ⚇ ✉</title>
                <link rel="icon" type="image/png" href="../../../images/icon.PNG">
                <link rel="stylesheet" type="text/css" href="../../../styles/styles.css">
                <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap" rel="stylesheet">
                <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
            </head>
            
            <body class="admin-body">
                <main class="private-div">';

            $string = $_REQUEST['radio_usuario'];

            $_SESSION['uuid_usuario'] = $string;

            include("../../../resources/mysqli.inc.php");
            $conexion = mysqli_connect($cfg_servidor, $cfg_usuario, $cfg_password, $cfg_basephp);

            $sentencia = "SELECT * FROM usuario WHERE uuid_usuario='$string'";
            $resultado = mysqli_query($conexion, $sentencia);
            $array = mysqli_fetch_array($resultado);
            $correo_usuario = $array['correo_usuario'];
            $password_usuario = $array['password_usuario'];
            $nick_usuario = $array['nick_usuario'];
            $nombre_usuario = $array['nombre_usuario'];
            $pais_usuario = $array['pais_usuario'];
            $saldo_usuario = $array['saldo_usuario'];

            echo '
            <fieldset>
                <legend>MODIFICAR USUARIO</legend>
                <form class="mod-form" action="mod_usuario.php" method="POST" enctype="multipart/form-data" onsubmit="return validationUserNoImage();">
                    <label>* CORREO ELECTR&Oacute;NICO: (x@x.xx)</label>
                    <input required type="text" name="correo" id="correo" placeholder="', $correo_usuario, '" value="', $correo_usuario, '">
                    <label>PASSWORD: (De 7 a 14 caracteres y de al menos 2 may., 3 min. y 2 núm.)</label>
                    <input required type="password" name="pass" id="pass" value="', $password_usuario, '">
                    <label>* NICK: (De 4 a 20 caracteres (_-) sin acentos y sin espacios)</label>
                    <input required type="text" name="nick" id="nick" placeholder="', $nick_usuario, '" value="', $nick_usuario, '">
                    <label>NOMBRE: (El primer caracter de cada palabra en may&uacute;scula, permite acentos y espacios)</label>
                    <input required type="text" name="nombre" id="nombre" placeholder="', $nombre_usuario, '" value="', $nombre_usuario, '">
                    <label>PA&Iacute;S:</label>
                    <select name="pais" id="pais">
                    </select>
                    <label>IMAGEN: (Opcional)</label>
                    <input type="file" name="imagen" id="imagen" accept="image/png, image/jpg, image/jpeg">
                    <label>SALDO: (€)</label>
                    <input type="number" name="saldo" id="saldo" min="0" max="1000" step="0.10" value="', $saldo_usuario, '">
                    <input type="reset" class="sub-center2 bcblack" value="RESTABLECER">
                    <input type="submit" class="sub-center2 bcblack" name="modificar_usuario" value="MODIFICAR">
                </form>
            </fieldset>';

            mysqli_close($conexion);

            echo '
                </main>
                <script type="application/javascript" src="../../../scripts/scripts.js"></script>
                <script type="application/javascript">
                    for (let i = 0; i < document.getElementById("pais").options.length; i++) {
                        if (document.getElementById("pais").options.item(i).value == "', $pais_usuario, '") {
                            document.getElementById("pais").options.item(i).setAttribute("selected", "selected");
                        }
                    }
                </script>
            </body>
        
            </html>';
        } else echo '<script>alert("Seleccione un registro");location.href="usuarios.php";</script>';
    } else header("Location:usuarios.php");
} catch (Exception $e) {
    echo '<script type="application/javascript">setTimeout(() => {alert("Exception: ', $e, '");}, 100);</script>';
}
