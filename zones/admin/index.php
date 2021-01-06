<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <title>♛ Zona de Administrador</title>
    <link rel="icon" type="image/png" href="../../images/icon.PNG">
    <link rel="stylesheet" type="text/css" href="../../styles/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap" rel="stylesheet">
</head>

<body class="admin-body">
    <main>
        <div class="centerimg-div">
            <a href="../..">
                <img class="logolink-img" src="../../images/logo.PNG" alt="MyMusic logo">
            </a>
        </div>
        <div class="admin-div">
            <h3>LOG IN</h3>
            <form action="" method="POST">
                <label>ADMINISTRADOR:</label>
                <input required type="text" name="admin_login">
                <label>PASSWORD:</label>
                <input required type="password" name="pass_login">
                <input type="submit" class="admin-subres" name="login" value="LOG IN">
                <input type="reset" class="admin-subres" value="RESTABLECER">
            </form>
        </div>
    </main>
    <?php
    try {
        session_start();
        if (isset($_REQUEST['login'])) {
            $admin_login = htmlspecialchars($_REQUEST['admin_login']);
            $pass_login = htmlspecialchars($_REQUEST['pass_login']);
            if ($admin_login == 'Admin123' && $pass_login == 'Admin123') {
                $_SESSION['login_admin_pass'] = true;
                header("Location:private");
            } else {
                echo '<script>setTimeout(()=>{alert("ERROR EN EL LOG IN:\n\nCredenciales inválidas de administrador");},100);</script>';
            }
        }
        if (isset($_SESSION['login_admin_pass'])) {
            header("Location:private");
        }
    } catch (Exception $e) {
        echo '<script type="application/javascript">setTimeout(() => {alert("Exception: ', $e, '");}, 100);</script>';
    }
    ?>
</body>

</html>