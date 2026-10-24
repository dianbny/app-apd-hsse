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
    <h5>Form Add User</h5>

    <form action="<?= BASEURL; ?>/save-data-new-user" method="POST" enctype="multipart/form-data">
        <div>
            <label for="name">Full Name </label><span>*</span>
            <input type="text" name="name" id="name" placeholder="Type Full Name" required>
        </div>
        <div>
            <label for="email">Email </label><span>*</span>
            <input type="text" name="email" id="email" placeholder="Type Email" required>
        </div>
        <div>
            <label for="username">Username </label><span>*</span>
            <input type="text" name="username" id="username" placeholder="Type Username" required>
        </div>
        <div>
            <label for="password">Password </label><span>*</span>
            <input type="password" name="password" id="password" placeholder="Type Password" required>
        </div>
        <div>
            <label for="level">Level User </label><span>*</span>
            <select name="level" id="level" required>
                <option value="" disabled selected>- Select Level Uses -</option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
                
            </select>
        </div>
        <div>
            <input type="submit" name="submit" class="btn-save" value="Save">
        </div>
    </form>
</div>