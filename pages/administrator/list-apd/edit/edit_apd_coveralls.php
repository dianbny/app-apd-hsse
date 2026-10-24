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
    if($cekData->cekDataFr('_tb_coveralls','_id', $_GET['id']) < 1){ ?>
        <script>
            window.location.href = "<?= BASEURL.'/list-apd-coveralls'; ?>";
        </script>
<?php }

    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    $detailAPD = $getData->getDataFr('_tb_coveralls', '_id', $id);
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
    <a href="<?= BASEURL; ?>/list-apd-coveralls" class="btn-close">X</a>
    <h5>Update Baju Terusan (Coveralls)</h5>

    <form action="<?= BASEURL; ?>/save-update-data-coveralls/<?= $id; ?>" method="POST" enctype="multipart/form-data">
        <div>
            <label for="merk">Merk </label><span>*</span>
            <input type="text" name="merk" id="merk" value="<?= $detailAPD['_merk']; ?>" placeholder="Brand/Merk APD" required>
        </div>
        <div>
            <label for="type">Tipe </label><span>*</span>
            <select name="type" id="type" required>
                <option value="<?= $detailAPD['_jenis']; ?>" selected><?= $detailAPD['_jenis']; ?></option>
                <option value="" disabled>- Pilih Tipe -</option>
                <option value="Coveralls Flame Resistant">Coveralls Flame Resistant</option>
                <option value="Coveralls Worker">Coveralls Worker</option>
                <option value="Coveralls Non-Woven">Coveralls Non-Woven</option>
                <option value="Coveralls Tahan Kimia">Coveralls Tahan Kimia</option>
                <option value="Coveralls Isolasi">Coveralls Isolasi</option>
            </select>
        </div>
        <div>
            <label for="size">Ukuran </label><span>*</span>
            <select name="size" id="size" required>
                <option value="<?= $detailAPD['_ukuran']; ?>" selected><?= 'Size '.$detailAPD['_ukuran']; ?></option>
                <option value="" disabled>- Pilih Ukuran -</option>
                <option value="S">Size S</option>
                <option value="M">Size M</option>
                <option value="L">Size L</option>
                <option value="XL">Size XL</option>
                <option value="XXL">Size XXL</option>
            </select>
        </div>
        <div>
            <label for="stock">Tersedia </label><span>*</span>
            <input type="number" name="stock" id="stock" value="<?= $detailAPD['_stok']; ?>" placeholder="Jumlah APD Tersedia" required>
        </div>
        <div>
            <label for="location">Lokasi APD </label><span>*</span>
            <input type="text" name="location" id="location" value="<?= $detailAPD['_lokasi_apd']; ?>" placeholder="Lokasi APD" required>
        </div>
        <div>
            <label for="rack-code">Kode Rak </label><span>*</span>
            <select name="rack-code" id="rack-code" required>
                <option value="<?= $detailAPD['_rack']; ?>" selected>
                    <?php
                        $rak = $getData->getDataFr('_tb_rack', '_id', $detailAPD['_rack']);
                        echo $rak['_code_rack'];
                    ?>
                </option>
                <option value="" disabled>- Pilih Code Rak -</option>
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
            <input type="number" name="rack-num" id="rack-num" value="<?= $detailAPD['_detail_rack_num']; ?>" placeholder="Detail Nomor RAK" required>
        </div>
        <div>
            <input type="submit" name="submit" class="btn-save" value="Simpan">
        </div>
    </form>
</div>