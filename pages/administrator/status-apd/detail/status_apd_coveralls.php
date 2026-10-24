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

    $detailStatus = $getData->getDataFr('_tb_status_coveralls', '_id', $id);
    $detailAPD = $getData->getDataFr('_tb_coveralls', '_id', $detailStatus['_id_coveralls']);
?>
<div class="container-detail">
    <a href="<?= BASEURL; ?>/status-apd-coveralls" class="btn-close">X</a>

    <h5>Coveralls Status Details</h5>

    <table class="table-detail">
        <tr>
            <td>Status</td>
            <td>:</td>
            <td><div class="status" style="background-color:<?php if($detailStatus['_status'] == "Restocked") { echo "#90EE90"; } elseif($detailStatus['_status'] == "Borrowed") { echo "#FFA07A"; } elseif($detailStatus['_status'] == "Issued") { echo "#F08080"; } else { echo "#C0C0C0"; } ?>"><?= $detailStatus['_status']; ?></div></td>
        </tr>
        <tr>
            <td>Merk</td>
            <td>:</td>
            <td>
                <b>
                    <?= $detailAPD['_merk']; ?>
                </b>
            </td>
        </tr>
        <tr>
            <td>Type</td>
            <td>:</td>
            <td>
                <b>
                    <?= $detailAPD['_jenis']; ?>
                </b>
            </td>
        </tr>
        <tr>
            <td>Size</td>
            <td>:</td>
            <td>
                <b>
                    <?= $detailAPD['_ukuran']; ?>
                </b>
            </td>
        </tr>
        <tr>
            <td>Qty</td>
            <td>:</td>
            <td><b><?= $detailStatus['_jumlah']; ?></b></td>
        </tr>
        <tr>
            <td>User</td>
            <td>:</td>
            <td>
                <b>
                    <?php
                        $namaUser = $getData->getDataFr('_tb_user_login', '_id', $detailStatus['_id_user']);
                        echo $namaUser['_nama'];
                    ?>
                </b>
            </td>
        </tr>
        <tr>
            <td>Requester</td>
            <td>:</td>
            <td>
                <b>
                    <?php
                        $namaRequester = $getData->getDataFr('_tb_user_login', '_id', $detailStatus['_id_requester']);
                        echo $namaRequester['_nama'];
                    ?>
                </b>
            </td>
        </tr>
        <?php
            if($detailStatus['_id_user'] != $detailStatus['_id_requester']){
                $detailRequest = $getData->getDataFr(($detailStatus['_status'] == "Borrowed") ? "_tb_borrow_coveralls" : "_tb_request_coveralls", '_updated_at', $detailStatus['_updated_at']); ?>
                <tr>
                    <td>Name</td>
                    <td>:</td>
                    <td><b><?= $detailRequest['_nama']; ?></b></td>
                </tr>
                <tr>
                    <td>Position</td>
                    <td>:</td>
                    <td><b><?= $detailRequest['_jabatan']; ?></b></td>
                </tr>
                <?php
                    if($detailStatus['_status'] == "Borrowed"){ ?>
                        <tr>
                            <td>Date</td>
                            <td>:</td>
                            <td><b><?= $detailRequest['_tgl_peminjaman']; ?></b></td>
                        </tr>
                        <tr>
                            <td>Due Date</td>
                            <td>:</td>
                            <td><b><?= $detailRequest['_tgl_pengembalian']; ?></b></td>
                        </tr>
              <?php }
                ?>
      <?php }
        ?>
        <tr>
            <td>Additional Information</td>
            <td>:</td>
            <td><b><?= $detailStatus['_keterangan']; ?></b></td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>:</td>
            <td><b><?= strftime('%d %B %Y, %H:%M:%S', strtotime($detailStatus['_created_at'])); ?></b></td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>:</td>
            <td><b><?= strftime('%d %B %Y, %H:%M:%S', strtotime($detailStatus['_updated_at'])); ?></b></td>
        </tr>
    </table>
        <?php
            if($detailStatus['_id_user'] == $detailStatus['_id_requester']){ ?>
                <a href="<?= BASEURL; ?>/edit-status-coveralls/<?= $id; ?>" class="btn-edit-delete" style="background-color:#FF4500;"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp; Update</a>
                <a href="javascript:void(0)" class="btn-edit-delete" id="delete-status" data-id="<?= $id; ?>" data-category="coveralls" style="background-color:#800000;"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp; Delete</a>
      <?php }
            else { ?>
                <span style="display:block;font-size:12px;margin:30px 8px;">Note : Readonly</span>
      <?php }
        ?>
    

    <?php
        $user = $getData->getDataFr('_tb_user_login', '_id', $detailStatus['_id_user']);
    ?>
    <span style="display:block;font-size:12px;margin:30px 8px;"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp; Terakhir diperbarui oleh <b><?= $user['_nama']; ?></b>, pada : <b><?= strftime('%d %B %Y, %H:%M:%S', strtotime($detailStatus['_updated_at'])); ?></b> </span>
</div>