<?php
    session_start();
    require_once "../../config/const.php";
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= BASEURL; ?>/assets/css/style_login_register.css">
    <title>Login</title>
</head>
<body>
<form action="<?= BASEURL; ?>/cek-login-user" method="POST">
    <div class="container-form">
        <?php
            if(isset($_SESSION['status']) && isset($_SESSION['msg'])){ ?>
                <div class="notification animate__animated animate__fadeInDown" style="background-color: <?= ($_SESSION['status'] == "success") ? 'rgba(168, 243, 190, 0.4)' : 'rgba(242, 151, 169, 0.67)' ; ?>">
                    <?= $_SESSION['msg']; ?>
                </div>
      <?php }
            session_destroy();
            ?>
        <a href="<?= BASEURL; ?>/landing-page" class="btnCls">X</a>
        <p>
            <b>Selamat Datang</b><br>
            Silahkan Login Terlebih Dahulu !
        </p>
        
        <div>
            <label for="username">Nama Penggunga</label>
            <input type="text" name="username" id="username" placeholder="Nama Pengguna" autocomplete="off" required>
            <img src="<?= BASEURL; ?>/assets/img/user.png" alt="">
        </div>
        <div>
            <label for="password">Sandi</label>
            <input type="password" name="password" id="password" placeholder="Sandi" autocomplete="off" required>
            <img src="<?= BASEURL; ?>/assets/img/padlock.png" alt="">
        </div>
        <div>
            <input type="checkbox" id="showPass"> <label for="showPass">Lihat Sandi <br><br>
            Belum punya akun ? <a href="<?= BASEURL; ?>/registrasi">Daftar</a>
        </div>
        <div>
            <input type="submit" name="login" value="Login" class="btnLogin">
            <p> 
                <a href="<?= BASEURL; ?>/login-administrator">Login Administrator</a>
            </p>
        </div>
    </div>
</form>

    <!--Javascript & JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script type='text/javascript'>
        $(document).ready(function(){
            $('#showPass').click(function(){
                $(this).is(':checked') ? $('#password').attr('type', 'text') : $('#password').attr('type', 'password');
            });
        });
    </script>
</body>
</html>