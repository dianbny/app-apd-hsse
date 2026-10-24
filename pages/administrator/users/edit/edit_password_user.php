<?php
    //Cek Jika Session Belum Ada
    if(!isset($_SESSION['status-login']) || !isset($_SESSION['level'])){ 
        require_once "../../../config/const.php";
        header('location:'.BASEURL);
    }
    
    //Cek Jika Data Session Sudah Ada
    if($_SESSION['status-login'] != "success"){ ?>
        <script>
            window.location.href = "<?= BASEURL.'/logout'; ?>";
        </script>
<?php }
    elseif($_SESSION['level'] != "administrator"){ ?>
        <script>
            window.location.href = "<?= BASEURL.'/logout'; ?>";
        </script>
<?php }

    $id = addslashes($_GET['id']);

    $detailUser = $getData->getDataFr('_tb_user_login', '_id', $id);
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
    <a href="<?= BASEURL; ?>/list-user" class="btn-close">X</a>
    <h5>Form Update Passowrd User</h5>

    <form action="<?= BASEURL; ?>/save-update-password-user/<?= $id; ?>" method="POST" enctype="multipart/form-data">
        <div>
            <label for="newpassword">New Password </label><span>*</span>
            <input type="password" name="newpassword" id="newpassword" placeholder="Type New Password" autocomplete="off" required>
        </div>

        <div>
            <input type="submit" name="submit" class="btn-save" value="Save">
        </div>
    </form>
</div>