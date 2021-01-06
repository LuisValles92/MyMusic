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
            unset($_SESSION['login_artist_uuid']);
            if (isset($_SESSION['uuid_tema'])) {
                unset($_SESSION['uuid_tema']);
            }
            header("Location:..");
        }
    }

    function mostrarPerfilySaldo()
    {
        global $imagen, $nombre_artistico, $nombre, $pais, $biografia, $estado, $correo, $saldo, $conexion, $uuid;

        echo '
        <fieldset id="fs_perfil">
            <legend>PERFIL</legend>
            <img class="perfil-img" src="', $imagen, '" alt="Artist image">
            <p class="main-p">', $nombre_artistico, '</p>
            <p>', $nombre, '</p>
            <p>', $pais, '</p>
            <p class="bio-estados-p bio-p">', $biografia, '</p>';
        if ($estado == 0) {
            echo '<p class="bio-estados-p estadoinactivo-p">', $correo, '<br>INACTIVO</p>
        </fieldset>';
        } else echo '<p class="bio-estados-p estadoactivo-p">', $correo, '<br>ACTIVO</p>
        </fieldset>';

        // $saldo=50;
        echo '
        <fieldset class="saldo-fs" id="fs_saldo">
            <legend>SALDO</legend>
            <form action="" method="POST">
                <p>TOTAL: ', $saldo, '€</p>
                <input type="range" id="rango_saldo" name="rango_saldo" onchange="mostrarEuroSaldo();" min="0" max="', $saldo, '" step="', $saldo / 10, '" value="0">
                <p id="euro_saldo">0€</p>
                <input type="submit" class="nav-sub-artist cwhite sub-center" name="retirar_saldo" id="retirar_saldo" value="RETIRAR">
            </form>
        </fieldset>';

        if (isset($_REQUEST['retirar_saldo'])) {
            $nuevo_saldo = $saldo - $_REQUEST['rango_saldo'];
            $sentencia = "UPDATE artista SET saldo_artista='$nuevo_saldo' WHERE uuid_artista='$uuid'";
            mysqli_query($conexion, $sentencia);
            if (mysqli_affected_rows($conexion) == 1) {
                echo '<script>setTimeout(()=>{alert("Su saldo ha sido retirado correctamente");},100); location.href=".";</script>';
            }
        }
    }

    function mostrarModificar()
    {
        global $correo, $password, $nombre_artistico, $nombre, $biografia, $conexion, $uuid;

        echo '
        <fieldset id="fs_modificar">
            <legend>MODIFICAR</legend>
            <form class="mod-form" action="" method="POST" enctype="multipart/form-data" onsubmit="return validationArtistNoImage();">
                <label>* CORREO ELECTR&Oacute;NICO: (x@x.xx)</label>
                <input required type="text" name="correo" id="correo" placeholder="', $correo, '" value="', $correo, '">
                <label>PASSWORD: (De 7 a 14 caracteres y de al menos 2 may., 3 min. y 2 núm.)</label>
                <input required type="password" name="pass" id="pass" value="', $password, '">
                <label>* NOMBRE ART&Iacute;STICO: (Tapiado - Si desea modificar este valor consulte al administrador)</label>
                <input required disabled=true type="text" name="nombre_artistico" id="nombre_artistico" value="', $nombre_artistico, '" placeholder="', $nombre_artistico, '">
                <label>NOMBRE: (El primer caracter de cada palabra en may&uacute;scula, permite acentos y espacios)</label>
                <input required type="text" name="nombre" id="nombre" placeholder="', $nombre, '" value="', $nombre, '">
                <label>PA&Iacute;S:</label>
                <select name="pais" id="pais"></select>
                <label>BIOGRAF&Iacute;A:</label>
                <textarea required name="biografia" id="biografia" placeholder="', $biografia, '"></textarea>
                <script>document.getElementById("biografia").value = "', $biografia, '";</script>
                <label>IMAGEN: (Opcional)</label>
                <input type="file" name="imagen" id="imagen" accept="image/png, image/jpg, image/jpeg">
                <input type="reset" class="artist-subres sub-center2" value="RESTABLECER">
                <input type="submit" class="artist-subres sub-center2" name="modificar" value="MODIFICAR">
            </form>
        </fieldset>';

        if (isset($_REQUEST['modificar'])) {
            $correo_mod = htmlspecialchars($_REQUEST['correo']);
            $nombre_mod = htmlspecialchars($_REQUEST['nombre']);
            $pass_mod = htmlspecialchars($_REQUEST['pass']);
            $pais_mod = $_REQUEST['pais'];
            $biografia_mod = htmlspecialchars($_REQUEST['biografia']);
            if ($_FILES['imagen']['size'] == 0) {
                $sentencia = "UPDATE artista SET correo_artista='$correo_mod', nombre_artistico_artista='$nombre_artistico',nombre_artista='$nombre_mod', password_artista='$pass_mod', pais_artista='$pais_mod', bio_artista='$biografia_mod' WHERE uuid_artista='$uuid'";
            } else {
                require_once '../../../resources/dropbox/vendor/autoload.php';
                include("../../../resources/dropbox.inc.php");
                $app = new DropboxApp($dropboxKey, $dropboxSecret, $dropboxToken);
                $dropbox = new Dropbox($app);
                $nombre_del_archivo = pathinfo($_FILES['imagen']['name'], PATHINFO_FILENAME) . '_' . uniqid();
                $tempfile = $_FILES['imagen']['tmp_name'];
                $ext = explode(".", $_FILES['imagen']['name']);
                $ext = end($ext);
                $ruta = "artists/" . $uuid . "/images";
                $nombredropbox = "/" . $ruta . "/" . $nombre_del_archivo . "." . $ext;
                $dropbox->simpleUpload($tempfile, $nombredropbox, ['autorename' => true]);
                $response = $dropbox->postToAPI("/sharing/create_shared_link_with_settings", [
                    "path" => $nombredropbox
                ]);
                $data = $response->getDecodedBody();
                $imagen_mod = substr($data['url'], 0, strlen($data['url']) - 4) . 'raw=1';

                $sentencia = "UPDATE artista SET correo_artista='$correo_mod', nombre_artistico_artista='$nombre_artistico', nombre_artista='$nombre_mod', password_artista='$pass_mod', pais_artista='$pais_mod', bio_artista='$biografia_mod', imagen_artista='$imagen_mod' WHERE uuid_artista='$uuid'";
            }
            mysqli_query($conexion, $sentencia);
            if (mysqlI_errno($conexion) == 0) {
                echo '<script>setTimeout(()=>{alert("Sus datos han sido modificados correctamente");},100); location.href=".";</script>';
            } else {
                if (mysqli_errno($conexion) == 1062) {
                    echo '<script>setTimeout(()=>{alert("ERROR:\n\nEl artista no ha sido modificado porque el correo electrónico ya existe en la base de datos");},100);</script>';
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
        global $conexion, $uuid, $estado;
        echo '
        <fieldset id="fs_modificarEstado">
            <legend>ESTADO</legend>
            <form class="mod-form2" action="" method="POST">
                <label>¿DESEA MODIFICAR EL ESTADO DE SU CUENTA?</label>
                <p>* No aparecer&aacute; como artista ni sus temas en la b&uacute;squeda de los usuarios, pero si alg&uacute;n usuario tiene licencia de sus temas, &eacute;ste s&iacute; que podr&aacute; tener acceso a su tema.</p>';
        if ($estado == 1) {
            echo '
                <p><input checked type="radio" name="estadoArt" value="activo"> ACTIVO</p>
                <p><input type="radio" name="estadoArt" value="inactivo"> INACTIVO</p>';
        } else echo '
                <p><input type="radio" name="estadoArt" value="activo"> ACTIVO</p>
                <p><input checked type="radio" name="estadoArt" value="inactivo"> INACTIVO</p>
                ';
        echo '
                <input type="submit" class="artist-subres sub-center2" name="modificar_estado" value="MODIFICAR">
            </form>
        </fieldset>
        <fieldset id="fs_eliminar" class="eliminar-fs">
            <legend>ELIMINAR</legend>
            <form class="mod-form2" action="" method="POST">
                <label>¿DESEA ELIMINAR SU CUENTA DE ARTISTA DE FORMA PERMANENTE?</label>
                <p>* Se eliminar&aacute; la cuenta &uacute;nicamente si el artista no posee temas ni posee licencias vendidas.</p>
                <input type="submit" class="bcred sub-center2" name="eliminar" value="ELIMINAR">
            </form>
        </fieldset>';

        if (isset($_REQUEST['modificar_estado'])) {
            $estado_mod = $_REQUEST['estadoArt'];
            if ($estado_mod == "activo") {
                $flag = true;
            } else {
                $flag = false;
            }
            $sentencia = "UPDATE artista SET estado_artista='$flag' WHERE uuid_artista='$uuid'";
            mysqli_query($conexion, $sentencia);
            if (mysqli_affected_rows($conexion) == 1) {
                echo '<script>setTimeout(()=>{alert("Su estado ha sido modificado correctamente");},100); location.href=".";</script>';
            }
        }

        if (isset($_REQUEST['eliminar'])) {
            $sentencia = "DELETE FROM artista WHERE uuid_artista='$uuid'";
            mysqli_query($conexion, $sentencia);
            if (mysqlI_errno($conexion) == 0) {

                require_once '../../../resources/dropbox/vendor/autoload.php';
                include("../../../resources/dropbox.inc.php");
                $app = new DropboxApp($dropboxKey, $dropboxSecret, $dropboxToken);
                $dropbox = new Dropbox($app);
                $ruta = "artists/" . $uuid;
                $dropbox->delete("/" . $ruta);

                echo '<script>setTimeout(()=>{alert("EL ARTISTA HA SIDO DADO DE BAJA CORRECTAMENTE");},100); location.href="..";</script>';
                mysqli_close($conexion);
                unset($_SESSION['login_artist_uuid']);
            } else {
                if (mysqli_errno($conexion) == 1451) {
                    echo '<script>setTimeout(()=>{alert("ERROR EN LA BAJA:\n\nEl artista posee temas o licencias vendidas");},100);</script>';
                } else {
                    $numerror = mysqli_errno($conexion);
                    $descrerror = mysqli_error($conexion);
                    echo '<script>setTimeout(()=>{alert("SE HA PRODUCIDO UN ERROR EN LA OPERACIÓN:\n\nSe ha producido el error num. ' . $numerror . ' que corresponde a: ' . $descrerror . '");},100);</script>';
                }
                echo '<script>location.href=".";</script>';
            }
        }
    }

    function mostrarInsertarTemas()
    {
        global $conexion, $uuid;
        echo '
        <button id="botoninsertartemas" class="instem-button" onclick="mostrarInsertarTem();">
            <i class="material-icons">add_circle</i>
        </button>
        <fieldset id="fs_insertar_temas">
            <legend>INSERTAR</legend>
            <form class="mod-form" action="" method="POST" enctype="multipart/form-data" onsubmit="return validationTheme();">
                <label>NOMBRE:</label>
                <input required type="text" name="nombre_tema" id="nombre_tema">
                <label>MP3 - COMPLETO:</label>
                <input type="file" name="completo_tema" id="completo_tema" accept="audio/mp3">
                <label>MP3 - TEASER:</label>
                <input type="file" name="teaser_tema" id="teaser_tema" accept="audio/mp3">
                <label>CATEGORÍA:</label>
                <select name="categoria_tema" id="categoria_tema"></select>
                <label>NOTA: (Colaboraciones, Discográfica...)</label>
                <textarea required name="nota_tema" id="nota_tema"></textarea>
                <label>IMAGEN:</label>
                <input type="file" name="imagen_tema" id="imagen_tema" accept="image/png, image/jpg, image/jpeg">
                <label>PRECIO: (€)</label>
                <input type="number" name="precio_tema" id="precio_tema" min="0" max="10" step="0.10" value="0">
                <label>ESTADO:</label>
                <p><input checked type="radio" name="estado_tema" value="activo"> ACTIVO <input type="radio" name="estado_tema" value="inactivo"> INACTIVO</p>
                <input type="reset" class="artist-subres sub-center2" value="RESTABLECER">
                <input type="submit" class="artist-subres sub-center2" name="insertar_tema" value="INSERTAR">
            </form>
        </fieldset>
        <button id="botonmostrartemas" class="instem-button mb" onclick="mostrarTabla();">
            <i class="material-icons">library_music</i>
        </button>';

        if (isset($_REQUEST['insertar_tema'])) {
            $uuid_tema = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex(random_bytes(16)), 4));
            $nombre_tema = htmlspecialchars($_REQUEST['nombre_tema']);

            require_once '../../../resources/dropbox/vendor/autoload.php';
            include("../../../resources/dropbox.inc.php");
            $app = new DropboxApp($dropboxKey, $dropboxSecret, $dropboxToken);
            $dropbox = new Dropbox($app);
            $nombre_del_archivo = pathinfo($_FILES['completo_tema']['name'], PATHINFO_FILENAME) . '_' . uniqid();
            $tempfile = $_FILES['completo_tema']['tmp_name'];
            $ext = explode(".", $_FILES['completo_tema']['name']);
            $ext = end($ext);
            $ruta = "themes/" . $uuid_tema . "/mp3/completo";
            $nombredropbox_c = "/" . $ruta . "/" . $nombre_del_archivo . "." . $ext;
            $dropbox->simpleUpload($tempfile, $nombredropbox_c, ['autorename' => true]);
            $response = $dropbox->postToAPI("/sharing/create_shared_link_with_settings", [
                "path" => $nombredropbox_c
            ]);
            $data = $response->getDecodedBody();
            $completo_tema = substr($data['url'], 0, strlen($data['url']) - 4) . 'raw=1';

            $nombre_del_archivo = pathinfo($_FILES['teaser_tema']['name'], PATHINFO_FILENAME) . '_' . uniqid();
            $tempfile = $_FILES['teaser_tema']['tmp_name'];
            $ext = explode(".", $_FILES['teaser_tema']['name']);
            $ext = end($ext);
            $ruta = "themes/" . $uuid_tema . "/mp3/teaser";
            $nombredropbox_t = "/" . $ruta . "/" . $nombre_del_archivo . "." . $ext;
            $dropbox->simpleUpload($tempfile, $nombredropbox_t, ['autorename' => true]);
            $response = $dropbox->postToAPI("/sharing/create_shared_link_with_settings", [
                "path" => $nombredropbox_t
            ]);
            $data = $response->getDecodedBody();
            $teaser_tema = substr($data['url'], 0, strlen($data['url']) - 4) . 'raw=1';

            $categoria_tema = $_REQUEST['categoria_tema'];
            $numero_descargas_tema = 0;
            $nota_tema = htmlspecialchars($_REQUEST['nota_tema']);
            $fecha = new DateTime();
            $fecha_tema = $fecha->format('Y-m-d H:i:s');

            $nombre_del_archivo = pathinfo($_FILES['imagen_tema']['name'], PATHINFO_FILENAME) . '_' . uniqid();
            $tempfile = $_FILES['imagen_tema']['tmp_name'];
            $ext = explode(".", $_FILES['imagen_tema']['name']);
            $ext = end($ext);
            $ruta = "themes/" . $uuid_tema . "/images";
            $nombredropbox = "/" . $ruta . "/" . $nombre_del_archivo . "." . $ext;
            $dropbox->simpleUpload($tempfile, $nombredropbox, ['autorename' => true]);
            $response = $dropbox->postToAPI("/sharing/create_shared_link_with_settings", [
                "path" => $nombredropbox
            ]);
            $data = $response->getDecodedBody();
            $imagen_tema = substr($data['url'], 0, strlen($data['url']) - 4) . 'raw=1';

            $precio_tema = $_REQUEST['precio_tema'];
            $estado_t = $_REQUEST['estado_tema'];
            if ($estado_t == 'activo') {
                $estado_tema = true;
            } else {
                $estado_tema = false;
            }

            $sentencia = "INSERT INTO tema (uuid_tema,uuid_artista_tema,nombre_tema,completo_tema,teaser_tema,categoria_tema,numero_descargas_tema,nota_tema,fecha_lanzamiento_tema,imagen_tema,precio_tema,estado_tema) VALUES ('$uuid_tema','$uuid','$nombre_tema','$completo_tema','$teaser_tema','$categoria_tema','$numero_descargas_tema','$nota_tema','$fecha_tema','$imagen_tema','$precio_tema','$estado_tema')";
            mysqli_query($conexion, $sentencia);

            if (mysqlI_errno($conexion) == 0) {
                echo '<script>setTimeout(()=>{alert("EL TEMA HA SIDO INSERTADO CORRECTAMENTE");},100); location.href=".";</script>';
            } else {
                $numerror = mysqli_errno($conexion);
                $descrerror = mysqli_error($conexion);
                echo '<script>setTimeout(()=>{alert("SE HA PRODUCIDO UN ERROR EN LA OPERACIÓN:\n\nSe ha producido el error num. ' . $numerror . ' que corresponde a: ' . $descrerror . '");},100);</script>';
                $dropbox->delete($nombredropbox_c);
                $dropbox->delete($nombredropbox_t);
                $dropbox->delete($nombredropbox);
                echo '<script>location.href=".";</script>';
            }
        }
    }

    if (isset($_SESSION['login_artist_uuid'])) {

        echo '
        <!DOCTYPE html>
        <html>
        
        <head>
            <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
            <title>⚉ Sesi&oacute;n Iniciada</title>
            <link rel="icon" type="image/png" href="../../../images/icon.PNG">
            <link rel="stylesheet" type="text/css" href="../../../styles/styles.css">
            <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap" rel="stylesheet">
            <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        </head>
        
        <body class="artist-body">
            <nav class="private-nav">
                <form method="POST">
                    <input type="submit" class="nav-sub-artist" name="cerrar_sesion" value="CERRAR SESIÓN">
                </form>
                <input type="button" class="nav-sub-artist" value="CLOUD" onclick="mostrarCloud();">
                <input type="button" onclick="mostrarEli(this);" class="nav-sub-artist" value="ESTADO / ELIMINAR">
                <input type="button" onclick="mostrarMod(this);" class="nav-sub-artist" value="MODIFICAR">
                <input type="button" onclick="mostrarTem(this);" class="nav-sub-artist" value="TEMAS">
                <input type="button" onclick="mostrarPerfilSaldo(this);" class="nav-sub-artist button_activo" value="PERFIL / SALDO">
            </nav>
            <main class="private-div">';

        cerrarSesion();

        $uuid = $_SESSION['login_artist_uuid'];
        include("../../../resources/mysqli.inc.php");
        $conexion = mysqli_connect($cfg_servidor, $cfg_usuario, $cfg_password, $cfg_basephp);
        $sentencia = "SELECT * FROM artista WHERE uuid_artista='$uuid'";
        $resultado = mysqli_query($conexion, $sentencia);
        $array = mysqli_fetch_array($resultado);
        $correo = $array['correo_artista'];
        $nombre_artistico = $array['nombre_artistico_artista'];
        $nombre = $array['nombre_artista'];
        $password = $array['password_artista'];
        $pais = $array['pais_artista'];
        $biografia = $array['bio_artista'];
        $fecha_alta = $array['fecha_alta_artista'];
        $imagen = $array['imagen_artista'];
        $saldo = $array['saldo_artista'];
        $estado = $array['estado_artista'];

        mostrarPerfilySaldo();
        mostrarModificar();
        mostrarEliminar();
        mostrarInsertarTemas();

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
