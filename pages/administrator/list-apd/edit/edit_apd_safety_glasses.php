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
    
    //Cek Data Berdasarkan ID
    if($cekData->cekDataFr('_tb_safety_glasses','_id', $_GET['id']) < 1){ ?>
        <script>
            window.location.href = "<?= BASEURL.'/list-apd-safety-glasses'; ?>";
        </script>
<?php }

    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    $detailAPD = $getData->getDataFr('_tb_safety_glasses', '_id', $id);
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
    <a href="<?= BASEURL; ?>/list-apd-safety-glasses" class="btn-close">X</a>
    <h5>Form Update Safety Glasses</h5>

    <form action="<?= BASEURL; ?>/save-update-data-safety-glasses/<?= $id; ?>" method="POST" enctype="multipart/form-data">
        <div>
            <label for="merk">Merk </label><span>*</span>
            <input type="text" name="merk" id="merk" value="<?= $detailAPD['_merk']; ?>" placeholder="Type Merk APD" required>
        </div>
        <div>
            <label for="type">Type </label><span>*</span>
            <select name="type" id="type" required>
                <option value="<?= $detailAPD['_jenis']; ?>" selected><?= $detailAPD['_jenis']; ?></option>
                <option value="" disabled>- Select Type -</option>
                <option value="Safety Spectales">Safety Spectales</option>
                <option value="Googles/Overspecs">Googles/Overspecs</option>
                <option value="Face Shield">Face Shield</option>
                <option value="Visor/Browguard">Visor/Browguard</option>
                <option value="Welding Glasses">Welding Glasses</option>
                
            </select>
        </div>
        <div>
            <label for="color">Color </label><span>*</span>
            <select name="color" id="color" required>
                <option value="<?= $detailAPD['_warna']; ?>" selected><?= $detailAPD['_warna']; ?></option>
                <option value="" disabled>- Select Type -</option>
                <option value="Black">Black</option>
                <option value="Clear">Clear</option>
                
                
            </select>
        </div>
        <div>
            <label for="stock">Stock </label><span>*</span>
            <input type="number" name="stock" id="stock" value="<?= $detailAPD['_stok']; ?>" placeholder="Type Stock APD" required>
        </div>
        <div>
            <label for="location">Location APD </label><span>*</span>
            <input type="text" name="location" id="location" value="<?= $detailAPD['_lokasi_apd']; ?>" placeholder="Type Location APD" required>
        </div>
        <div>
            <label for="rack-code">Rack Code </label><span>*</span>
            <select name="rack-code" id="rack-code" required>
                <option value="<?= $detailAPD['_rack']; ?>" selected>
                    <?php
                        $rak = $getData->getDataFr('_tb_rack', '_id', $detailAPD['_rack']);
                        echo $rak['_code_rack'];
                    ?>
                </option>
                <option value="" disabled>- Select Rack Code -</option>
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
            <input type="number" name="rack-num" id="rack-num" value="<?= $detailAPD['_detail_rack_num']; ?>" placeholder="Type Detail Rack Number" required>
        </div>
        <div>
            <input type="submit" name="submit" class="btn-save" value="Save">
        </div>
    </form>
</div>