<?php
    if(!isset($_SESSION['status-login'])){ 
        require_once "../../../config/const.php";
        header('location:'.BASEURL);
    }
    elseif($_SESSION['level'] != "user"){
        header('location:'.BASEURL.'/logout');
    }

    $id = addslashes($_GET['id']);
    $detailAPD = $getData->getDataFr('_tb_safety_gloves', '_id', $id);
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
    <a href="<?= BASEURL; ?>/user-select-borrowing-safety-gloves" class="btn-close">X</a>
    <h5>Formulir Peminjaman Sarung Tangan (Safety Gloves)</h5>
    
    <form action="<?= BASEURL; ?>/save-data-borrowing-safety-gloves/<?= $id; ?>" method="POST" enctype="multipart/form-data">

        <img src="<?= BASEURL; ?>/uploads/safety-gloves/<?= $detailAPD['_foto']; ?>" style="width:150px;height:200px;margin-bottom:15px;" alt=""> 
        <div>
            <label for="detail">Detail</label>
            <input type="text" name="detail" id="detail" value="<?= $detailAPD['_merk'].' | '.$detailAPD['_jenis']; ?>" readonly>
        </div>
        <div>
            <label for="name">Nama Peminjam </label><span>*</span>
            <input type="text" name="name" id="name" placeholder="Nama Peminjam" required>
        </div>
        <div>
            <label for="position">Posisi (Jobdesk) </label><span>*</span>
            <input type="text" name="position" id="position" placeholder="Posisi (Jobdesk)" required>
        </div>
        <div>
            <label for="needs">Keperluan Peminjaman </label><span>*</span>
            <textarea name="needs" id="needs" placeholder="Keperluan Peminjaman" class="textarea"></textarea>
        </div>
        <div>
            <label for="borrowing-date">Tanggal Peminjaman </label><span>*</span>
            <input type="date" name="borrowing-date" id="borrowing-date" required>
        </div>
        <div>
            <label for="return-date">Tanggal Pengembalian </label><span>*</span>
            <input type="date" name="return-date" id="return-date" required>
        </div>
        <div>
            <label for="stock">Tersedia </label>
            <input type="number" name="stock" id="stock" value="<?= $detailAPD['_stok']; ?>" readonly>
        </div>
        <div>
            <label for="qty">Jumlah Peminjaman </label><span>*</span>
            <input type="number" name="qty" id="qty" placeholder="Jumlah Peminjaman" required>
        </div>
        
        <div>
            <input type="submit" name="submit" class="btn-save" value="Simpan">
        </div>
    </form>
</div>