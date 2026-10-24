<?php
    if(!isset($_SESSION['status-login'])){ 
        require_once "../../../config/const.php";
        header('location:'.BASEURL);
    }
    elseif($_SESSION['level'] != "user"){
        header('location:'.BASEURL.'/logout');
    }

?>
<div class="container-form">
    <?php
        if(isset($_SESSION['status']) && isset($_SESSION['msg'])){ ?>
            <div class="notification animate__animated animate__fadeInDown" style="background-color: <?= ($_SESSION['status'] == "success") ? 'rgba(168, 243, 190, 0.4)' : 'rgba(242, 151, 169, 0.67)' ; ?>">
                <?= $_SESSION['msg']; ?>
            </div>
  <?php }
        unset($_SESSION['status']);
        unset($_SESSION['msg']);
    ?>
    <a href="<?= BASEURL; ?>/dashboard-user" class="btn-close">X</a>
    <h5>Perubahan Kata Sandi </h5>

    <form action="<?= BASEURL; ?>/user-save-update-password/<?= $_SESSION['id_user']; ?>" method="POST" enctype="multipart/form-data">
        <div>
            <label for="oldpassword">Sandi Lama </label><span>*</span>
            <input type="password" name="oldpassword" id="oldpassword" placeholder="Sandi Lama" autocomplete="off" required>
        </div>

        <div>
            <label for="newpassword">Sandi Baru </label><span>*</span>
            <input type="password" name="newpassword" id="newpassword" placeholder="Sandi Baru" autocomplete="off" required>
        </div>

        <div>
            <label for="confirmpassword">Konfirmasi Sandi Baru </label><span>*</span>
            <input type="password" name="confirmpassword" id="confirmpassword" placeholder="Konfirmasi Sandi Baru" autocomplete="off" required>
        </div>

        <div>
            <input type="submit" name="submit" class="btn-save" value="Simpan">
        </div>
    </form>
</div>