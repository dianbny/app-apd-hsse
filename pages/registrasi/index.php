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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <title>Registrasi</title>
</head>
<body>
    <form action="<?= BASEURL; ?>/save-new-user" method="POST">
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
                <div>
                    <label for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name" placeholder="Type Full Name" required>
                    <img src="<?= BASEURL; ?>/assets/img/user.png" alt="">
                </div>
                <div>
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" placeholder="Type Email" required>
                    <img src="<?= BASEURL; ?>/assets/img/email.png" alt="">
                </div>
                <div>
                    <label for="username">Nama Pengguna</label>
                    <input type="text" id="username" name="username" placeholder="Type Username" required>
                    <img src="<?= BASEURL; ?>/assets/img/user.png" alt="">
                </div>
                <div>
                    <label for="password">Sandi</label>
                    <input type="password" id="password" name="password" placeholder="Type Password" required>
                    <img src="<?= BASEURL; ?>/assets/img/padlock.png" alt="">
                </div>
                <div>
                    <input type="checkbox" id="showPass"> <label for="showPass">Lihat Sandi 
                </div>
                <div>
                    <input type="submit" name="submit" value="Register" class="btnLogin">
                    <p> 
                        <a href="<?= BASEURL; ?>/login">Login Pengguna</a>
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