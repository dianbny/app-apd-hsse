<?php
    if(!isset($_SESSION['status-login'])){ 
        require_once "../../../config/const.php";
        header('location:'.BASEURL);
    }
    elseif($_SESSION['level'] != "user"){
        header('location:'.BASEURL.'/logout');
    }
?>
<div class="container-select-item">
    <a href="<?= BASEURL; ?>/user-borrowing-apd-coveralls" class="btn-close">X</a>

    <h5>Pilih Baju Terusan (Coveralls)</h5>
    <div class="div-card">
        <?php
            if($cekData->cekDataAll('_tb_coveralls') > 0){
                foreach($getData->getDataAll('_tb_coveralls', '_id') as $row){ ?>
                    <div class="card">
                        <img src="<?= BASEURL; ?>/uploads/coveralls/<?= $row['_foto']; ?>" alt="">
                        <table>
                            <tr>
                                <td>Merk</td>
                                <td>:</td>
                                <td><b><?= $row['_merk']; ?></b></td>
                            </tr>
                            <tr>
                                <td>Tipe</td>
                                <td>:</td>
                                <td><b><?= $row['_jenis']; ?></b></td>
                            </tr>
                            <tr>
                                <td>Ukuran</td>
                                <td>:</td>
                                <td><b><?= $row['_ukuran']; ?></b></td>
                            </tr>
                            <tr>
                                <td>Tersedia</td>
                                <td>:</td>
                                <td><div class="status" style="background-color:<?= ($row['_stok'] > 0) ? "#90EE90" : "#F08080"; ?>">&nbsp; <?= $row['_stok']; ?> &nbsp;</div></td>
                            </tr>
                            <tr>
                                <td>Lokasi</td>
                                <td>:</td>
                                <td><b><?= $row['_lokasi_apd']; ?></b></td>
                            </tr>
                        </table>
                        <a href="<?= BASEURL; ?>/user-add-borrowing-coveralls/<?= $row['_id']; ?>" class="link-request"><i class="fa fa-paper-plane" aria-hidden="true"></i>&nbsp; Kirim Permintaan</a>
                    </div>
         <?php  }
            }
            else { ?>
                <span style="font-size:13px;color:rgba(235, 31, 39, 1);">Data tidak ditemukan !</span>
      <?php }
        ?>
    </div>
</div>