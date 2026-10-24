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
    <a href="<?= BASEURL; ?>/list-apd-safety-shoes" class="btn-close">X</a>
    <h5>Tambah Sepatu (Safety Shoes)</h5>

    <form action="<?= BASEURL; ?>/save-data-new-safety-shoes" method="POST" enctype="multipart/form-data">
        <div>
            <label for="merk">Merk </label><span>*</span>
            <input type="text" name="merk" id="merk" placeholder="Brand/Merk APD" required>
        </div>
        <div>
            <label for="type">Tipe </label><span>*</span>
            <select name="type" id="type" required>
                <option value="" disabled selected>- Pilih Tipe -</option>
                <option value="Safety Shoes">Safety Shoes</option>
                <option value="Fire Fighter Shoes">Fire Fighter Shoes</option>
                <option value="Rubber Boots">Rubber Boots</option>

            </select>
        </div>
        <div>
            <label for="size">Ukuran </label><span>*</span>
            <select name="size" id="size" required>
                <option value="" disabled selected>- Pilih Ukuran -</option>
                <option value="37/4">37/4</option>
                <option value="38/5">38/5</option>
                <option value="39/6">39/6</option>
                <option value="40/6">40/6</option>
                <option value="41/7">41/7</option>
                <option value="42/8">42/8</option>
                <option value="43/9">43/9</option>
                <option value="44/10">44/10</option>
                <option value="45/10">45/10</option>
                
            </select>
        </div>
        <div>
            <label for="stock">Tersedia </label><span>*</span>
            <input type="number" name="stock" id="stock" placeholder="Jumlah APD Tersedia" required>
        </div>
        <div>
            <label for="location">Lokasi APD </label><span>*</span>
            <input type="text" name="location" id="location" value="HSSE Firestation Bunyu Field" placeholder="Lokasi APD" required>
        </div>
        <div>
            <label for="rack-code">Kode Rak </label><span>*</span>
            <select name="rack-code" id="rack-code" required>
                <option value="" disabled selected>- Pilih Kode Rak -</option>
                <?php
                    if($cekData->cekDataAll('_tb_rack') > 0){
                        foreach ($getData->getDataAll('_tb_rack','_id') as $row){ ?>
                            <option value="<?= $row['_id']; ?>"><?= $row['_code_rack']; ?></option>
                 <?php  }
                    }
                    else { ?>
                        <option value="">Data tidak ditemukan ! </option>
              <?php }
                ?>
            </select>
        </div>
        <div>
            <label for="rack-num">Detail Nomor Rak </label><span>*</span>
            <input type="number" name="rack-num" id="rack-num" placeholder="Detail Nomor Rak" required>
        </div>
        <div>
            <label for="expired">Tanggal Kadaluarsa </label><span>*</span>
            <input type="date" name="expired" id="expired" required>
        </div>
        <div>
            <label for="f1">Foto APD </label><span>*</span><br><br>
            <input type="file" name="f1" id="f1" accept="image/*">
        </div>
        <div>
            <input type="submit" name="submit" class="btn-save" value="Simpan">
        </div>
    </form>
</div>