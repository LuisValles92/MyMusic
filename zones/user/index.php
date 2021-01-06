<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <title>⚇ Zona de Usuario</title>
    <link rel="icon" type="image/png" href="../../images/icon.PNG">
    <link rel="stylesheet" type="text/css" href="../../styles/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap" rel="stylesheet">
</head>

<body class="user-body">
    <main>
        <div class="centerimg-div">
            <a href="../..">
                <img class="logolink-img" src="../../images/logo.PNG" alt="MyMusic logo">
            </a>
        </div>
        <div class="user0-div">
            <div class="user1-div">
                <h3>FORMULARIO DE REGISTRO</h3>
                <form action="" method="POST" enctype="multipart/form-data" onsubmit="return validationUser();">
                    <label>* CORREO ELECTR&Oacute;NICO: (x@x.xx)</label>
                    <input required type="text" name="correo" id="correo">
                    <label>PASSWORD: (De 7 a 14 caracteres y de al menos 2 may., 3 min. y 2 núm.)</label>
                    <input required type="password" name="pass" id="pass">
                    <label>* NICK: (De 4 a 20 caracteres (_-) sin acentos y sin espacios)</label>
                    <input required type="text" name="nick" id="nick">
                    <label>NOMBRE: (El primer caracter de cada palabra en may&uacute;scula, permite acentos y espacios)</label>
                    <input required type="text" name="nombre" id="nombre">
                    <label>PA&Iacute;S:</label>
                    <select name="pais" id="pais">
                    </select>
                    <label>IMAGEN:</label>
                    <input type="file" name="imagen" id="imagen" accept="image/png, image/jpg, image/jpeg">
                    <input type="submit" class="user-subres" name="registrar" value="REGISTRAR">
                    <input type="reset" class="user-subres" value="RESTABLECER">
                </form>
            </div>

            <div class="user2-div">
                <h3>LOG IN</h3>
                <form action="" method="POST">
                    <label>CORREO ELECTR&Oacute;NICO:</label>
                    <input required type="text" name="correo_login">
                    <label>PASSWORD:</label>
                    <input required type="password" name="pass_login">
                    <input type="submit" class="user-subres" name="login" value="LOG IN">
                    <input type="reset" class="user-subres" value="RESTABLECER">
                </form>
            </div>
        </div>
    </main>
    <script type="application/javascript" src="../../scripts/scripts.js"></script>
    <?php

    use Kunnu\Dropbox\Dropbox;
    use Kunnu\Dropbox\DropboxApp;

    try {
        session_start();
        if (isset($_REQUEST['registrar'])) {
            $uuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex(random_bytes(16)), 4));
            $correo = htmlspecialchars($_REQUEST['correo']);
            $nick = htmlspecialchars($_REQUEST['nick']);
            $nombre = htmlspecialchars($_REQUEST['nombre']);
            $pass = htmlspecialchars($_REQUEST['pass']);
            $pais = $_REQUEST['pais'];
            $fecha = new DateTime();
            $fecha_alta = $fecha->format('Y-m-d H:i:s');

            require_once '../../resources/dropbox/vendor/autoload.php';
            include("../../resources/dropbox.inc.php");
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
            $imagen = substr($data['url'], 0, strlen($data['url']) - 4) . 'raw=1';

            $saldo = 0;

            include("../../resources/mysqli.inc.php");
            $conexion = mysqli_connect($cfg_servidor, $cfg_usuario, $cfg_password, $cfg_basephp);
            $sentencia = "INSERT INTO usuario (uuid_usuario,correo_usuario,nick_usuario,nombre_usuario,password_usuario,pais_usuario,fecha_alta_usuario,imagen_usuario,saldo_usuario) VALUES ('$uuid','$correo','$nick','$nombre','$pass','$pais','$fecha_alta','$imagen','$saldo')";
            mysqli_query($conexion, $sentencia);

            if (mysqlI_errno($conexion) == 0) {
                echo '<script>setTimeout(()=>{alert("EL USUARIO HA SIDO DADO DE ALTA CORRECTAMENTE");},100);</script>';
            } else {
                if (mysqli_errno($conexion) == 1062) {
                    echo '<script>setTimeout(()=>{alert("ERROR:\n\nEl usuario no ha sido dado de alta porque el correo electrónico o el nick ya existe en la base de datos");},100);</script>';
                } else {
                    $numerror = mysqli_errno($conexion);
                    $descrerror = mysqli_error($conexion);
                    echo '<script>setTimeout(()=>{alert("SE HA PRODUCIDO UN ERROR EN LA OPERACIÓN:\n\nSe ha producido el error num. ' . $numerror . ' que corresponde a: ' . $descrerror . '");},100);</script>';
                }

                $dropbox->delete("/" . "users/" . $uuid);
            }
            mysqli_close($conexion);
            echo '<script>location.href=".";</script>';
        }
        if (isset($_REQUEST['login'])) {
            $correo_login = htmlspecialchars($_REQUEST['correo_login']);
            $pass_login = htmlspecialchars($_REQUEST['pass_login']);
            include("../../resources/mysqli.inc.php");
            $conexion = mysqli_connect($cfg_servidor, $cfg_usuario, $cfg_password, $cfg_basephp);
            $sentencia = "SELECT * FROM usuario WHERE correo_usuario='$correo_login' AND password_usuario='$pass_login'";
            $resultado = mysqli_query($conexion, $sentencia);
            if (mysqli_num_rows($resultado) == 1) {
                $array = mysqli_fetch_array($resultado);
                $_SESSION['login_user_uuid'] = $array['uuid_usuario'];
                header("Location:private");
            } else {
                echo '<script>setTimeout(()=>{alert("ERROR EN EL LOG IN:\n\nNo existe el usuario con el correo electrónico ', $correo_login, ' o la contraseña ', $pass_login, ' es incorrecta");},100);</script>';
            }
            mysqli_close($conexion);
        }
        if (isset($_SESSION['login_user_uuid'])) {
            header("Location:private");
        }
    } catch (Exception $e) {
        echo '<script type="application/javascript">setTimeout(() => {alert("Exception: ', $e, '");}, 100);</script>';
    }
    ?>
</body>

</html>