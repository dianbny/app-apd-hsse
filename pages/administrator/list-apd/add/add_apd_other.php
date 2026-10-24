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
    <a href="<?= BASEURL; ?>/list-apd-other" class="btn-close">X</a>
    <h5>Form Add Other Items</h5>

    <form action="<?= BASEURL; ?>/save-data-new-other-apd" method="POST" enctype="multipart/form-data">
        <div>
            <label for="type">Type </label><span>*</span>
            <select name="type" id="type" required>
                <option value="" disabled selected>- Select Type -</option>
                <option value="Windsock">Windsock</option>
                <option value="Gembok Box Merah">Gembok Box Merah</option>
                <option value="Spanduk">Spanduk</option>
                <option value="Pelindung Lebah">Pelindung Lebah</option>
                <option value="Box Master Lock">Box Master Lock</option>
                <option value="Lock Station">Lock Station</option>
                <option value="SCBA">SCBA</option>
                <option value="Tabung SCBA">Tabung SCBA</option>
                <option value="Retractable Fall Arrester">Retractable Fall Arrester</option>
                <option value="Full Body Harness">Full Body Harness</option>
                <option value="Masker 3M">Masker 3M</option>
                <option value="Cartridge Masker">Cartridge Masker</option>
                <option value="Masker">Masker</option>

            </select>
        </div>
        <div>
            <label for="stock">Stock </label><span>*</span>
            <input type="number" name="stock" id="stock" placeholder="Type Stock APD" required>
        </div>
        <div>
            <label for="location">Location APD </label><span>*</span>
            <input type="text" name="location" id="location" value="HSSE Firestation Bunyu Field" placeholder="Type Location APD" required>
        </div>
        <div>
            <label for="rack-code">Rack Code </label><span>*</span>
            <select name="rack-code" id="rack-code" required>
                <option value="" disabled selected>- Select Rack Code -</option>
                <?php
                    if($cekData->cekDataAll('_tb_rack') > 0){
                        foreach ($getData->getDataAll('_tb_rack','_id') as $row){ ?>
                            <option value="<?= $row['_id']; ?>"><?= $row['_code_rack']; ?></option>
                 <?php  }
                    }
                    else { ?>
                        <option value="">Data not found ! </option>
              <?php }
                ?>
            </select>
        </div>
        <div>
            <label for="rack-num">Detail Rack Number </label><span>*</span>
            <input type="number" name="rack-num" id="rack-num" placeholder="Type Detail Rack Number" required>
        </div>
        <div>
            <label for="expired">Expired Date </label><span></span>
            <input type="date" name="expired" id="expired">
        </div>
        <div>
            <label for="f1">Photo APD </label><span>*</span><br><br>
            <input type="file" name="f1" id="f1" accept="image/*">
        </div>
        <div>
            <input type="submit" name="submit" class="btn-save" value="Save">
        </div>
    </form>
</div>