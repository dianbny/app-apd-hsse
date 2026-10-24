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

    $detailStatus = $getData->getDataFr('_tb_status_safety_helmet', '_id', $id);
    $detailAPD = $getData->getDataFr('_tb_safety_helmet', '_id', $detailStatus['_id_safety_helmet']);
    
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
    <a href="<?= BASEURL; ?>/status-apd-safety-helmet" class="btn-close">X</a>
    <h5>Form Edit Status Safety Helmet</h5>

    <form action="<?= BASEURL; ?>/update-data-status-safety-helmet/<?= $id; ?>" method="POST" enctype="multipart/form-data">
        <div>
            <label for="safety-helmet">Safety Helmet </label><span>*</span>
            <input type="text" name="safety-helmet" id="safety-helmet" value="<?= $detailAPD['_merk'].' | '.$detailAPD['_jenis'].' | '.$detailAPD['_warna']; ?>" placeholder="Type Safety Helmet" required readonly>
        </div>
        <div>
            <label for="qty">Qty </label><span>*</span>
            <input type="number" name="qty" id="qty" value="<?= $detailStatus['_jumlah']; ?>" placeholder="Type Qty" required>
        </div>
        <div>
            <label for="status">Status </label><span>*</span>
            <select name="status" id="status">
                <option value="<?= $detailStatus['_status']; ?>" selected><?= $detailStatus['_status']; ?></option>
                <option value="" disabled>- Select Status -</option>
                <option value="Restocked">Restocked (Barang Masuk)</option>
                <option value="Borrowed">Borrowed (Dipinjam)</option>
                <option value="Issued">Issued (Dikeluarkan)</option>
                <option value="Damaged">Damaged (Rusak)</option>
            </select>
        </div>
        <div>
            <label for="information">Additional Information </label><span>*</span>
            <textarea name="information" id="information" placeholder="Type Additional Information" class="textarea"><?= $detailStatus['_keterangan']; ?></textarea>
        </div>
        <div>
            <input type="submit" name="submit" class="btn-save" value="Save">
        </div>
    </form>
</div>