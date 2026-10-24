<?php
    if(!isset($_SESSION['status-login'])){ 
        require_once "../../../config/const.php";
        header('location:'.BASEURL);
    }
    elseif($_SESSION['level'] != "user"){
        header('location:'.BASEURL.'/logout');
    }

    $id = addslashes($_GET['id']);
    $detailAPD = $getData->getDataFr('_tb_safety_helmet', '_id', $id);
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
    <a href="<?= BASEURL; ?>/user-select-request-safety-helmet" class="btn-close">X</a>
    <h5>Formulir Permintaan Helm (Safety Helmet)</h5>
    
    <form action="<?= BASEURL; ?>/save-data-request-safety-helmet/<?= $id; ?>" method="POST" enctype="multipart/form-data">

        <img src="<?= BASEURL; ?>/uploads/safety-helmet/<?= $detailAPD['_foto']; ?>" style="width:150px;height:200px;margin-bottom:15px;" alt=""> 
        <div>
            <label for="detail">Detail</label>
            <input type="text" name="detail" id="detail" value="<?= $detailAPD['_merk'].' | '.$detailAPD['_jenis'].' | '.$detailAPD['_warna']; ?>" readonly>
        </div>
        <div>
            <label for="name">Nama Peminta </label><span>*</span>
            <input type="text" name="name" id="name" placeholder="Nama Peminta" required>
        </div>
        <div>
            <label for="position">Posisi (Jobdesk)</label><span>*</span>
            <input type="text" name="position" id="position" placeholder="Posisi (Jobdesk)" required>
        </div>
        <div>
            <label for="reason">Alasan Penggantian </label><span>*</span>
            <textarea name="reason" id="reason" placeholder="Alasan Penggantian" class="textarea"></textarea>
        </div>
        <div>
            <label for="stock">Tersedia </label>
            <input type="number" name="stock" id="stock" value="<?= $detailAPD['_stok']; ?>" readonly>
        </div>
        <div>
            <label for="qty">Jumlah Permintaan</label><span>*</span>
            <input type="number" name="qty" id="qty" placeholder="Jumlah Permintaan" required>
        </div>
        <div>
            <label for="f1">Foto APD/Material Lama </label><span>*</span><br><br>
            <input type="file" name="f1" id="f1" accept="image/*">
        </div>
        <div>
            <input type="submit" name="submit" class="btn-save" value="Simpan">
        </div>
    </form>
</div>