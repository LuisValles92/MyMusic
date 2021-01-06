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
            mysqli_query($conexion, "DELETE FROM tema WHERE uuid_tema='$string'");

            if (mysqlI_errno($conexion) == 0) {

                require_once '../../../resources/dropbox/vendor/autoload.php';
                include("../../../resources/dropbox.inc.php");
                $app = new DropboxApp($dropboxKey, $dropboxSecret, $dropboxToken);
                $dropbox = new Dropbox($app);
                $ruta = "themes/" . $string;
                $dropbox->delete("/" . $ruta);

                echo '<script>setTimeout(()=>{alert("El tema seleccionado ha sido eliminado correctamente");},100);</script>';
            } else {
                if (mysqli_errno($conexion) == 1451) {
                    echo '<script>setTimeout(()=>{alert("ERROR EN LA ELIMINACIÓN:\n\nEl artista posee licencias vendidas del tema seleccionado");},100);</script>';
                } else {
                    $numerror = mysqli_errno($conexion);
                    $descrerror = mysqli_error($conexion);
                    echo '<script>setTimeout(()=>{alert("SE HA PRODUCIDO UN ERROR EN LA OPERACIÓN:\n\nSe ha producido el error num. ' . $numerror . ' que corresponde a: ' . $descrerror . '");},100);</script>';
                }
            }
            echo '<script>location.href="mymusic.php";</script>';
            mysqli_close($conexion);
        } else echo '<script>alert("Seleccione un registro");location.href="mymusic.php";</script>';
    } elseif (isset($_REQUEST['modificar_registro'])) {
        if (isset($_REQUEST['radio_tema'])) {

            echo '
            <!DOCTYPE html>
            <html>
            
            <head>
                <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
                <title>⚉ ☁ ✉</title>
                <link rel="icon" type="image/png" href="../../../images/icon.PNG">
                <link rel="stylesheet" type="text/css" href="../../../styles/styles.css">
                <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap" rel="stylesheet">
                <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
            </head>
            
            <body class="artist-body">
                <main class="private-div">';

            $string = $_REQUEST['radio_tema'];

            $_SESSION['uuid_tema'] = $string;

            include("../../../resources/mysqli.inc.php");
            $conexion = mysqli_connect($cfg_servidor, $cfg_usuario, $cfg_password, $cfg_basephp);

            $sentencia = "SELECT * FROM tema WHERE uuid_tema='$string'";
            $resultado = mysqli_query($conexion, $sentencia);
            $array = mysqli_fetch_array($resultado);
            $nombre_tema = $array['nombre_tema'];
            $categoria_tema = $array['categoria_tema'];
            $nota_tema = $array['nota_tema'];
            $precio_tema = $array['precio_tema'];
            $estado_tema = $array['estado_tema'];

            echo '
            <fieldset>
                <legend>MODIFICAR TEMA</legend>
                <form class="mod-form" action="mod_tema.php" method="POST" enctype="multipart/form-data" onsubmit="return validationThemeMod();">
                    <label>NOMBRE:</label>
                    <input required disabled=true type="text" name="nombre_tema" id="nombre_tema" placerholder="', $nombre_tema, '" value="', $nombre_tema, '">
                    <label>CATEGORÍA:</label>
                    <select name="categoria_tema" id="categoria_tema"></select>
                    <label>NOTA: (Colaboraciones, Discográfica...)</label>
                    <textarea required name="nota_tema" id="nota_tema" placeholder="', $nota_tema, '"></textarea>
                    <script>document.getElementById("nota_tema").value = "', $nota_tema, '";</script>
                    <label>IMAGEN: (Opcional)</label>
                    <input type="file" name="imagen_tema" id="imagen_tema" accept="image/png, image/jpg, image/jpeg">
                    <label>PRECIO: (€)</label>
                    <input type="number" name="precio_tema" id="precio_tema" min="0" max="10" step="0.10" value="', $precio_tema, '">
                    <label>ESTADO:</label>';
            if ($estado_tema == 1) {
                echo '
                    <p><input checked type="radio" name="estado_tema" value="activo"> ACTIVO <input type="radio" name="estado_tema" value="inactivo"> INACTIVO</p>';
            } else echo '
                    <p><input type="radio" name="estado_tema" value="activo"> ACTIVO <input checked type="radio" name="estado_tema" value="inactivo"> INACTIVO</p>';

            echo '
                    <input type="reset" class="artist-subres sub-center2 bcgray" value="RESTABLECER">
                    <input type="submit" class="artist-subres sub-center2 bcgray" name="modificar_tema" value="MODIFICAR">
                </form>
            </fieldset>';

            mysqli_close($conexion);

            echo '
                </main>
                <script type="application/javascript" src="../../../scripts/scripts.js"></script>
                <script type="application/javascript">
                    for (let i = 0; i < document.getElementById("categoria_tema").options.length; i++) {
                        if (document.getElementById("categoria_tema").options.item(i).value == "', $categoria_tema, '") {
                            document.getElementById("categoria_tema").options.item(i).setAttribute("selected", "selected");
                        }
                    }
                </script>
            </body>
        
            </html>';
        } else echo '<script>alert("Seleccione un registro");location.href="mymusic.php";</script>';
    } else header("Location:mymusic.php");
} catch (Exception $e) {
    echo '<script type="application/javascript">setTimeout(() => {alert("Exception: ', $e, '");}, 100);</script>';
}
