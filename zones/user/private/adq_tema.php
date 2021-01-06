<?php
try {

    session_start();

    if (isset($_REQUEST['comprar_registro'])) {

        if (isset($_REQUEST['radio_tema'])) {

            $uuid_usuario = $_SESSION['login_user_uuid'];
            $uuid_tema = $_REQUEST['radio_tema'];

            include("../../../resources/mysqli.inc.php");
            $conexion = mysqli_connect($cfg_servidor, $cfg_usuario, $cfg_password, $cfg_basephp);

            $sentencia = "SELECT * FROM licencia WHERE uuid_tema_licencia='$uuid_tema' AND uuid_usuario_licencia='$uuid_usuario'";
            $resultado = mysqli_query($conexion, $sentencia);
            $num_resultados = mysqli_num_rows($resultado);
            if ($num_resultados == 0) {
                $sentencia = "SELECT U.saldo_usuario, T.precio_tema, T.numero_descargas_tema, T.uuid_artista_tema FROM usuario U, tema T WHERE U.uuid_usuario='$uuid_usuario' AND T.uuid_tema='$uuid_tema'";
                $resultado = mysqli_query($conexion, $sentencia);
                $array = mysqli_fetch_array($resultado);
                $saldo_usuario = $array['saldo_usuario'];
                $precio_tema = $array['precio_tema'];
                $numero_descargas_tema = $array['numero_descargas_tema'];
                $uuid_artista = $array['uuid_artista_tema'];
                if ($saldo_usuario >= $precio_tema) {
                    $nuevo_saldo_usuario = $saldo_usuario - $precio_tema;
                    $nuevo_numero_descargas_tema = $numero_descargas_tema + 1;
                    $sentencia = "UPDATE usuario SET saldo_usuario='$nuevo_saldo_usuario' WHERE uuid_usuario='$uuid_usuario'";
                    mysqli_query($conexion, $sentencia);
                    $sentencia = "UPDATE tema SET numero_descargas_tema='$nuevo_numero_descargas_tema' WHERE uuid_tema='$uuid_tema'";
                    mysqli_query($conexion, $sentencia);
                    $sentencia = "UPDATE artista SET saldo_artista=saldo_artista+'$precio_tema' WHERE uuid_artista='$uuid_artista'";
                    mysqli_query($conexion, $sentencia);
                    $uuid_licencia = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex(random_bytes(16)), 4));
                    $fecha = new DateTime();
                    $fecha_alta = $fecha->format('Y-m-d H:i:s');
                    $sentencia = "INSERT INTO licencia (uuid_licencia,uuid_tema_licencia,uuid_usuario_licencia,fecha_licencia,precio_licencia) VALUES ('$uuid_licencia','$uuid_tema','$uuid_usuario','$fecha_alta','$precio_tema')";
                    mysqli_query($conexion, $sentencia);
                    if (mysqlI_errno($conexion) == 0) {
                        echo '<script>setTimeout(()=>{alert("EL TEMA HA SIDO COMPRADO SATISFACTORIAMENTE\n\nYA PUEDE ESCUCHAR EL TEMA COMPLETO EN EL ÁREA LICENCIAS");},100);</script>';
                    } else {
                        $numerror = mysqli_errno($conexion);
                        $descrerror = mysqli_error($conexion);
                        echo '<script>setTimeout(()=>{alert("SE HA PRODUCIDO UN ERROR EN LA OPERACIÓN:\n\nSe ha producido el error num. ' . $numerror . ' que corresponde a: ' . $descrerror . '");},100);</script>';
                    }
                } else {
                    echo '<script>alert("No tiene suficiente saldo para comprar este tema");</script>';
                }
            } else echo '<script>alert("Ya posee la licencia de este tema");</script>';

            mysqli_close($conexion);
            echo '<script>location.href="mymusic.php";</script>';
        } else echo '<script>alert("Seleccione un registro");location.href="mymusic.php";</script>';
    } else header("Location:mymusic.php");
} catch (Exception $e) {
    echo '<script type="application/javascript">setTimeout(() => {alert("Exception: ', $e, '");}, 100);</script>';
}
