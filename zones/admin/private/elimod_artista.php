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
            mysqli_query($conexion, "DELETE FROM artista WHERE uuid_artista='$string'");

            if (mysqlI_errno($conexion) == 0) {

                require_once '../../../resources/dropbox/vendor/autoload.php';
                include("../../../resources/dropbox.inc.php");
                $app = new DropboxApp($dropboxKey, $dropboxSecret, $dropboxToken);
                $dropbox = new Dropbox($app);
                $ruta = "artists/" . $string;
                $dropbox->delete("/" . $ruta);

                echo '<script>setTimeout(()=>{alert("El artista seleccionado ha sido eliminado correctamente");},100);</script>';
            } else {
                if (mysqli_errno($conexion) == 1451) {
                    echo '<script>setTimeout(()=>{alert("ERROR EN LA ELIMINACIÓN:\n\nEl artista seleccionado posee temas o licencias vendidas");},100);</script>';
                } else {
                    $numerror = mysqli_errno($conexion);
                    $descrerror = mysqli_error($conexion);
                    echo '<script>setTimeout(()=>{alert("SE HA PRODUCIDO UN ERROR EN LA OPERACIÓN:\n\nSe ha producido el error num. ' . $numerror . ' que corresponde a: ' . $descrerror . '");},100);</script>';
                }
            }
            echo '<script>location.href="artistas.php";</script>';
            mysqli_close($conexion);
        } else echo '<script>alert("Seleccione un registro");location.href="artistas.php";</script>';
    } elseif (isset($_REQUEST['modificar_registro'])) {
        if (isset($_REQUEST['radio_artista'])) {

            echo '
            <!DOCTYPE html>
            <html>
            
            <head>
                <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
                <title>♛ ⚉ ✉</title>
                <link rel="icon" type="image/png" href="../../../images/icon.PNG">
                <link rel="stylesheet" type="text/css" href="../../../styles/styles.css">
                <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap" rel="stylesheet">
                <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
            </head>
            
            <body class="admin-body">
                <main class="private-div">';

            $string = $_REQUEST['radio_artista'];

            $_SESSION['uuid_artista'] = $string;

            include("../../../resources/mysqli.inc.php");
            $conexion = mysqli_connect($cfg_servidor, $cfg_usuario, $cfg_password, $cfg_basephp);

            $sentencia = "SELECT * FROM artista WHERE uuid_artista='$string'";
            $resultado = mysqli_query($conexion, $sentencia);
            $array = mysqli_fetch_array($resultado);
            $correo_artista = $array['correo_artista'];
            $password_artista = $array['password_artista'];
            $nombre_artistico_artista = $array['nombre_artistico_artista'];
            $nombre_artista = $array['nombre_artista'];
            $pais_artista = $array['pais_artista'];
            $bio_artista = $array['bio_artista'];
            $saldo_artista = $array['saldo_artista'];
            $estado_artista = $array['estado_artista'];

            echo '
            <fieldset>
                <legend>MODIFICAR ARTISTA</legend>
                <form class="mod-form" action="mod_artista.php" method="POST" enctype="multipart/form-data" onsubmit="return validationArtistNoImage();">
                    
                <label>* CORREO ELECTR&Oacute;NICO: (x@x.xx)</label>
                <input required type="text" name="correo" id="correo" placeholder="', $correo_artista, '" value="', $correo_artista, '">
                <label>PASSWORD: (De 7 a 14 caracteres y de al menos 2 may., 3 min. y 2 núm.)</label>
                <input required type="password" name="pass" id="pass" value="', $password_artista, '">
                <label>* NOMBRE ART&Iacute;STICO: (Cualquier caracter del abecedario (_-) tanto may., min., espacios, acentos y n&uacute;meros)</label>
                <input required type="text" name="nombre_artistico" id="nombre_artistico" value="', $nombre_artistico_artista, '" placeholder="', $nombre_artistico_artista, '">
                <label>NOMBRE: (El primer caracter de cada palabra en may&uacute;scula, permite acentos y espacios)</label>
                <input required type="text" name="nombre" id="nombre" placeholder="', $nombre_artista, '" value="', $nombre_artista, '">
                <label>PA&Iacute;S:</label>
                <select name="pais" id="pais"></select>
                <label>BIOGRAF&Iacute;A:</label>
                <textarea required name="biografia" id="biografia" placeholder="', $bio_artista, '"></textarea>
                <script>document.getElementById("biografia").value = "', $bio_artista, '";</script>
                <label>IMAGEN: (Opcional)</label>
                <input type="file" name="imagen" id="imagen" accept="image/png, image/jpg, image/jpeg">
                <label>SALDO: (€)</label>
                <input type="number" name="saldo" id="saldo" min="0" max="1000" step="0.10" value="', $saldo_artista, '">
                <label>ESTADO:</label>';
            if ($estado_artista == 1) {
                echo '
                    <p><input checked type="radio" name="estado" value="activo"> ACTIVO <input type="radio" name="estado" value="inactivo"> INACTIVO</p>';
            } else echo '
                    <p><input type="radio" name="estado" value="activo"> ACTIVO <input checked type="radio" name="estado" value="inactivo"> INACTIVO</p>';

            echo '
                    <input type="reset" class="sub-center2 bcblack" value="RESTABLECER">
                    <input type="submit" class="sub-center2 bcblack" name="modificar_artista" value="MODIFICAR">
                </form>
            </fieldset>';

            mysqli_close($conexion);

            echo '
                </main>
                <script type="application/javascript" src="../../../scripts/scripts.js"></script>
                <script type="application/javascript">
                    for (let i = 0; i < document.getElementById("pais").options.length; i++) {
                        if (document.getElementById("pais").options.item(i).value == "', $pais_artista, '") {
                            document.getElementById("pais").options.item(i).setAttribute("selected", "selected");
                        }
                    }
                </script>
            </body>
        
            </html>';
        } else echo '<script>alert("Seleccione un registro");location.href="artistas.php";</script>';
    } else header("Location:artistas.php");
} catch (Exception $e) {
    echo '<script type="application/javascript">setTimeout(() => {alert("Exception: ', $e, '");}, 100);</script>';
}
